<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseSection;
use App\Models\CourseOffer;
use App\Models\CLO;
use App\Models\PLO;
use App\Models\ProgramBatch;
use App\Models\Program;
use App\Models\StudentAttendance;
use App\Models\ActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\CqiClassActivity;
use App\Models\CqiStudentAssessment;
use App\Models\CqiActivityQuestion;
use App\Models\CqiActivityQuestionRubrics;
use App\Models\EnrollStudent;
use App\Models\Institute;
use App\Models\Role;
use App\Models\Cqi;
use App\Models\CourseOfferPlo;
use App\Models\CourseOfferClo;
use App\Models\CqiStudent;
use App\Models\Sesssion;
use App\Models\User;
use App\Models\Assesment;
use App\Models\Faculty;
use App\Models\StudentPloAttainment;
use App\Models\Course;
use App\Models\ActivityQuestionRubric;
use App\Models\Student;
use App\Models\PloByCourseSectionClo;
use App\Models\ClassActivity;
use PDF;
use App\Traits\TraitFunctions;
use App\Exports\ProgramPloExport;
use App\Exports\CourseStatusExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    
    use TraitFunctions;

    public function index()
    {
        return view('report.index');
    }

    public function programwiseplo()
    {
            $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];

            // echo "<pre>";
            // print_r($institute_id);
            // die();

            if ($flag === 'all') {
                $institute = Institute::select('id','name')->wherestatus(1)->get();
            }else{
                $institute = Institute::select('id','name')->whereIn('id', $institute_id)->wherestatus(1)->get();
            }
        $sessions = Sesssion::select('id','title')->get();
        $students = [];
        return view('report.plo_report',compact('institute','sessions','students'));
    }


    public function printprogramwisereportpdf(Request $request)
    {
        
            ini_set('max_execution_time', 300);
            set_time_limit(300);
        
        $program = Program::select('id','name')->whereid($request->program_id)->wherestatus(1)->first();
        $session = Sesssion::select('id','title')->whereid($request->session_id)->first();
        // Get all program PLOs
        $prog_plos = PLO::where('program_id', $request->program_id)->get();

        // Get all active students in the selected session
        $students = Student::where('program_id', $request->program_id)
            ->where('active_session_id', $request->session_id)
            ->get();

        $data = []; // Final formatted data for PDF

        foreach ($students as $student) {
            $enrolledSections = EnrollStudent::where('student_id', $student->id)->pluck('course_section_id');
            $courseOffers = CourseOffer::whereIn('id', $enrolledSections)->get();

            $ploAttainments = []; // Store repeated PLO values

            foreach ($courseOffers as $courseOffer) {
                $clos = StudentAssessment::where('courseoffer_id', $courseOffer->id)
                    ->distinct('clo_id')
                    ->pluck('clo_id');

                $plos = CourseOfferPlo::select('plo_id')
                    ->where('course_section_id', $courseOffer->id)
                    ->whereIn('clo_id', $clos)
                    ->groupBy('plo_id')
                    ->get();

                foreach ($plos as $plo) {
                    // $cloUsedInPlo = CourseOfferPlo::select('clo_id')
                    //     ->where('course_id', $courseOffer->course_id)
                    //     ->where('plo_id', $plo->plo_id)
                    //     ->groupBy('clo_id')
                    //     ->get();

                    $totalAverageOutcome = 0;
                    $totalObeWeight = 0;

                    // foreach ($cloUsedInPlo as $clo) {
                        // $questions = ActivityQuestion::where('courseoffer_id', $courseOffer->id)
                        //     ->where('clo_id', $clo->clo_id)
                        //     ->get();

                        // $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                        //                                         ->where('course_id', $courseOffer->course_id)
                        //                                         ->where('plo_id', $plo->plo_id)
                        //                                         ->groupBy('clo_id')
                        //                                         ->get();

                        // $questions = $StudentQuestionPloAttainment::where('courseoffer_id', $courseOffer->id)
                        //     ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                        //     ->select('question_id','cqi_question_id','question_flag')
                        //     ->distinct()
                        //     ->get();


                        // foreach ($questions as $q) {
                            // if ($q->obe_weight) {
                            //     $totalObeWeight += $q->obe_weight;

                            //     $outcome = StudentAssessment::where('clo_id', $clo->clo_id)
                            //         ->where('student_id', $student->id)
                            //         ->where('question_id', $q->id)
                            //         ->where('activity_id', $q->activity_id)
                            //         ->where('courseoffer_id', $courseOffer->id)
                            //         ->first();

                            //     if ($outcome && $outcome->outcome !== null) {
                            //         $weightedOutcome = ($outcome->outcome / $q->max_mark) * $q->obe_weight;
                            //         $totalAverageOutcome += $weightedOutcome;
                            //     }
                            // }
                            // $mark = $StudentQuestionPloAttainment::where('student_id', $student->id)
                            //                                         ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                            //                                         ->where('question_flag', $q->question_flag)
                            //                                         ->where(function($query) use ($q) {
                            //                                             $query->where('question_id', $q->question_id)
                            //                                                 ->orWhere('cqi_question_id', $q->cqi_question_id);
                            //                                         })
                            //                                         ->first();
                        // }

                        // $cqiQuestions = CqiActivityQuestion::where('courseoffer_id', $courseOffer->id)
                        //     ->where('clo_id', $clo->clo_id)
                        //     ->get();

                        // foreach ($cqiQuestions as $cq) {
                        //     if ($cq->obe_weight) {
                        //         $totalObeWeight += $cq->obe_weight;

                        //         $cqiOutcome = CqiStudentAssessment::where('clo_id', $clo->clo_id)
                        //             ->where('student_id', $student->id)
                        //             ->where('cqi_question_id', $cq->id)
                        //             ->where('cqi_activity_id', $cq->cqi_activity_id)
                        //             ->where('courseoffer_id', $courseOffer->id)
                        //             ->first();

                        //         if ($cqiOutcome && $cqiOutcome->outcome !== null) {
                        //             $cqiWeightedOutcome = ($cqiOutcome->outcome / $cq->max_mark) * $cq->obe_weight;
                        //             $totalAverageOutcome += $cqiWeightedOutcome;
                        //         }
                        //     }
                        // }
                    // }

                    // $ploweight = ($totalObeWeight != 0) ? ($totalAverageOutcome / $totalObeWeight) * 100 : 0;
                    $plo_att = StudentPloAttainment::select('weighted_total')->where('student_id', $student->id)
                        ->where('plo_id', $plo->plo_id)
                        ->where('courseoffer_id', $courseOffer->id)
                        ->first();


                    // Store this attainment against the PLO
                    $ploAttainments[$plo->plo_id][] = number_format($plo_att->weighted_total ?? 0.00 , 2);
                }
            }

            // Format student row
            $data[] = [
                'name' => $student->name,
                'reg_no' => $student->roll_no ?? $student->registration_no,
                'plos' => $ploAttainments 
            ];
        }
        // echo "<pre>";
        // print_r($data);
        // die();
        return PDF::loadView('report.pdf_plo_report', [
            'prog_plos' => $prog_plos,
            'students' => $data,
            'program_name' => $program->name,
            'session' => $session->title
        ])->setPaper('a4', 'landscape')->stream('plo-report.pdf');
    }

    // public function printprogramwisereportpdf(Request $request)
    // {
        
    //     $program = Program::select('id','name')->whereid($request->program_id)->wherestatus(1)->first();
    //     $session = Sesssion::select('id','title')->whereid($request->session_id)->first();
    //     // Get all program PLOs
    //     $prog_plos = PLO::where('program_id', $request->program_id)->get();

    //     // Get all active students in the selected session
    //     $students = Student::where('program_id', $request->program_id)
    //         ->where('active_session_id', $request->session_id)
    //         ->get();

    //     $data = []; // Final formatted data for PDF

    //     foreach ($students as $student) {
    //         $enrolledSections = EnrollStudent::where('student_id', $student->id)->pluck('course_section_id');
    //         $courseOffers = CourseOffer::whereIn('id', $enrolledSections)->get();

    //         $ploAttainments = []; // Store repeated PLO values

    //         foreach ($courseOffers as $courseOffer) {
    //             $clos = StudentAssessment::where('courseoffer_id', $courseOffer->id)
    //                 ->distinct('clo_id')
    //                 ->pluck('clo_id');

    //             $plos = CourseOfferPlo::select('plo_id')
    //                 ->where('course_section_id', $courseOffer->id)
    //                 ->whereIn('clo_id', $clos)
    //                 ->groupBy('plo_id')
    //                 ->get();

    //             foreach ($plos as $plo) {
    //                 $cloUsedInPlo = CourseOfferPlo::select('clo_id')
    //                     ->where('course_id', $courseOffer->course_id)
    //                     ->where('plo_id', $plo->plo_id)
    //                     ->groupBy('clo_id')
    //                     ->get();

    //                 $totalAverageOutcome = 0;
    //                 $totalObeWeight = 0;

    //                 foreach ($cloUsedInPlo as $clo) {
    //                     $questions = ActivityQuestion::where('courseoffer_id', $courseOffer->id)
    //                         ->where('clo_id', $clo->clo_id)
    //                         ->get();

    //                     foreach ($questions as $q) {
    //                         if ($q->obe_weight) {
    //                             $totalObeWeight += $q->obe_weight;

    //                             $outcome = StudentAssessment::where('clo_id', $clo->clo_id)
    //                                 ->where('student_id', $student->id)
    //                                 ->where('question_id', $q->id)
    //                                 ->where('activity_id', $q->activity_id)
    //                                 ->where('courseoffer_id', $courseOffer->id)
    //                                 ->first();

    //                             if ($outcome && $outcome->outcome !== null) {
    //                                 $weightedOutcome = ($outcome->outcome / $q->max_mark) * $q->obe_weight;
    //                                 $totalAverageOutcome += $weightedOutcome;
    //                             }
    //                         }
    //                     }

    //                     $cqiQuestions = CqiActivityQuestion::where('courseoffer_id', $courseOffer->id)
    //                         ->where('clo_id', $clo->clo_id)
    //                         ->get();

    //                     foreach ($cqiQuestions as $cq) {
    //                         if ($cq->obe_weight) {
    //                             $totalObeWeight += $cq->obe_weight;

    //                             $cqiOutcome = CqiStudentAssessment::where('clo_id', $clo->clo_id)
    //                                 ->where('student_id', $student->id)
    //                                 ->where('cqi_question_id', $cq->id)
    //                                 ->where('cqi_activity_id', $cq->cqi_activity_id)
    //                                 ->where('courseoffer_id', $courseOffer->id)
    //                                 ->first();

    //                             if ($cqiOutcome && $cqiOutcome->outcome !== null) {
    //                                 $cqiWeightedOutcome = ($cqiOutcome->outcome / $cq->max_mark) * $cq->obe_weight;
    //                                 $totalAverageOutcome += $cqiWeightedOutcome;
    //                             }
    //                         }
    //                     }
    //                 }

    //                 $ploweight = ($totalObeWeight != 0) ? ($totalAverageOutcome / $totalObeWeight) * 100 : 0;

    //                 // Store this attainment against the PLO
    //                 $ploAttainments[$plo->plo_id][] = number_format($ploweight, 2);
    //             }
    //         }

    //         // Format student row
    //         $data[] = [
    //             'name' => $student->name,
    //             'reg_no' => $student->roll_no ?? $student->registration_no,
    //             'plos' => $ploAttainments 
    //         ];
    //     }
    //     echo "<pre>";
    //     print_r($data);
    //     die();
    //     return PDF::loadView('report.pdf_plo_report', [
    //         'prog_plos' => $prog_plos,
    //         'students' => $data,
    //         'program_name' => $program->name,
    //         'session' => $session->title
    //     ])->setPaper('a4', 'landscape')->stream('plo-report.pdf');
    // }

    // public function programWiseReportView(Request $request)
    // {

    //       ini_set('max_execution_time', 300);
    //         set_time_limit(300);

    //     $user = Auth::user();
    //         $roleId = session('role_key');
    //         $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    //         $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
    //         $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];

    //         if ($flag === 'all') {
    //             $institute = Institute::select('id','name')->wherestatus(1)->get();
    //         }else{
    //             $institute = Institute::select('id','name')->whereIn('id', $institute_id)->wherestatus(1)->get();
    //         }
    //     $sessions = Sesssion::select('id','title')->get();
    //     $students = [];

    //     $program = Program::select('id','name')->whereid($request->program_id)->wherestatus(1)->first();
    //     $session = Sesssion::select('id','title')->whereid($request->session_id)->first();
        
    //     $prog_plos = PLO::where('program_id', $request->program_id)->get();
    //     $students = Student::where('program_id', $request->program_id)
    //         ->where('active_session_id', $request->session_id)
    //         ->limit(60)
    //         ->get();

    //     $data = []; 


    //     // echo "<pre>";
    //     // print_r($students->toArray());
    //     // die();
    //     foreach ($students as $student) {
    //         $enrolledSections = EnrollStudent::where('student_id', $student->id)->pluck('course_section_id');
    //         $courseOffers = CourseOffer::whereIn('id', $enrolledSections)->get();

    //         $ploAttainments = []; 

    //         foreach ($courseOffers as $courseOffer) {
    //             $clos = StudentAssessment::where('courseoffer_id', $courseOffer->id)
    //                 ->distinct('clo_id')
    //                 ->pluck('clo_id');

    //             $plos = CourseOfferPlo::select('plo_id')
    //                 ->where('course_section_id', $courseOffer->id)
    //                 ->whereIn('clo_id', $clos)
    //                 ->groupBy('plo_id')
    //                 ->get();

    //             foreach ($plos as $plo) {
    //                 $cloUsedInPlo = CourseOfferPlo::select('clo_id')
    //                     ->where('course_id', $courseOffer->course_id)
    //                     ->where('plo_id', $plo->plo_id)
    //                     ->groupBy('clo_id')
    //                     ->get();

                  
    //                 $totalAverageOutcome = 0;
    //                 $totalObeWeight = 0;

    //                  $plo_att = StudentPloAttainment::select('weighted_total')->where('student_id', $student->id)
    //                     ->where('plo_id', $plo->plo_id)
    //                     ->where('courseoffer_id', $courseOffer->id)
    //                     ->first();


    //     // echo "<pre>";
    //     // print_r($plo_att);
    //     // die();
    //                 if(empty($plo_att)){
    //                     $att  =0;
    //                 }else{
    //                     $att  = number_format($plo_att->weighted_total ?? 0.00 , 2);
    //                 }
    //                 $ploAttainments[$plo->plo_id][] = [
    //                     'attainment' => $att,
    //                     'plo_code'   => PLO::find($plo->plo_id)->code ?? '', // Get PLO code
    //                     'course'     => $courseOffer->course->name ?? '',    // Assuming relation exists
    //                     'course_offer' => $courseOffer->id
    //                 ];

                    
                    
    //             }
    //         }
            
    //         // Format student row
    //         $data[] = [
    //             'name' => $student->name,
    //             'reg_no' => $student->roll_no ?? $student->registration_no,
    //             'plos' => $ploAttainments 
    //         ];
    //     }
    //     // echo "<pre>";
    //     // print_r($data);
    //     // die();

    //     $prog_plos = $prog_plos;
    //     $students = $data;
    //     $program_name = $program->name;
    //     $session = $session->title;

    //     return view('report.plo_report', compact('institute','sessions','prog_plos','students','program_name','session'));
    // }

    public function programWiseReportView(Request $request)
    {
        $user   = Auth::user();
        $roleId = session('role_key');

        $permission = $this->hasFunctionalityPermission($user->id, $roleId);
        $flag         = $permission['flag'] ?? $permission->relavent_table_flag ?? '';
        $institute_id = $permission['institute_id'] ?? [];

        // Institutes
        $institute = Institute::select('id','name')
            ->when($flag !== 'all', function ($q) use ($institute_id) {
                $q->whereIn('id', $institute_id);
            })
            ->whereStatus(1)
            ->get();

        $sessions = Sesssion::select('id','title')->get();

        // Program & Session
        $program = Program::select('id','name')
            ->whereId($request->program_id)
            ->whereStatus(1)
            ->firstOrFail();

        $sessionObj = Sesssion::select('id','title')
            ->whereId($request->session_id)
            ->firstOrFail();

        // Program PLOs
        $prog_plos = PLO::where('program_id', $request->program_id)->get();

        // Students
        $students = Student::where('program_id', $request->program_id)
            ->where('active_session_id', $request->session_id)
            ->get();

        if ($students->isEmpty()) {
            return view('report.plo_report', compact(
                'institute','sessions','prog_plos','students'
            ));
        }

        /* ===================== PRELOAD DATA ===================== */

        // PLO codes
        $ploCodes = PLO::pluck('code', 'id');

        // Enrollments
        $enrollments = EnrollStudent::whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy('student_id');

        // Course Offers
        $courseOffers = CourseOffer::with('course')
            ->whereIn('id', $enrollments->flatten()->pluck('course_section_id'))
            ->get()
            ->keyBy('id');

        // CLOs used per course offer
        $courseClos = StudentAssessment::select('courseoffer_id','clo_id')
            ->whereIn('courseoffer_id', $courseOffers->keys())
            ->distinct()
            ->get()
            ->groupBy('courseoffer_id');

        // CourseOffer → PLO mapping
        $courseOfferPlos = CourseOfferPlo::select('course_section_id','plo_id')
            ->get()
            ->groupBy('course_section_id');

        // Student PLO Attainments
        $ploAttainments = StudentPloAttainment::whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy(['student_id','courseoffer_id','plo_id']);

        /* ===================== BUILD REPORT ===================== */

        $finalStudents = [];

        foreach ($students as $student) {

            $studentPlos = [];

            foreach ($enrollments[$student->id] ?? [] as $enroll) {

                $courseOffer = $courseOffers[$enroll->course_section_id] ?? null;
                if (!$courseOffer) continue;

                foreach ($courseOfferPlos[$courseOffer->id] ?? [] as $ploMap) {

                    $plo_id = $ploMap->plo_id;

                    $plo_att = optional(
                        $ploAttainments[$student->id][$courseOffer->id][$plo_id] ?? null
                    )->first();

                    $studentPlos[$plo_id][] = [
                        'attainment'   => number_format($plo_att->weighted_total ?? 0.00, 2),
                        'plo_code'     => $ploCodes[$plo_id] ?? '',
                        'course'       => $courseOffer->course->name ?? '',
                        'course_offer' => $courseOffer->id
                    ];
                }
            }

            $finalStudents[] = [
                'name'   => $student->name,
                'reg_no' => $student->roll_no ?? $student->registration_no,
                'plos'   => $studentPlos
            ];
        }

        $students     = $finalStudents;
        $program_name = $program->name;
        $session      = $sessionObj->title;

        return view('report.plo_report', compact(
            'institute',
            'sessions',
            'prog_plos',
            'students',
            'program_name',
            'session'
        ));
    }


    // public function printprogramwisereportexcel(Request $request)
    // {
        
    //         ini_set('max_execution_time', 500);
    //         set_time_limit(500);

    //     $prog_plos = PLO::where('program_id', $request->program_id)->get();
    //     $students = Student::where('program_id', $request->program_id)
    //         ->where('active_session_id', $request->session_id)
    //         ->get();

    //     $data = [];

    //     foreach ($students as $student) {
    //         $enrolledSections = EnrollStudent::where('student_id', $student->id)->pluck('course_section_id');
    //         $courseOffers = CourseOffer::whereIn('id', $enrolledSections)->get();

    //         $ploAttainments = [];

    //         foreach ($courseOffers as $courseOffer) {
    //             $clos = StudentAssessment::where('courseoffer_id', $courseOffer->id)
    //                 ->distinct('clo_id')->pluck('clo_id');

    //             $plos = CourseOfferPlo::select('plo_id')
    //                 ->where('course_section_id', $courseOffer->id)
    //                 ->whereIn('clo_id', $clos)
    //                 ->groupBy('plo_id')->get();

    //             foreach ($plos as $plo) {
    //                 // $cloUsedInPlo = CourseOfferPlo::select('clo_id')
    //                 //     ->where('course_id', $courseOffer->course_id)
    //                 //     ->where('plo_id', $plo->plo_id)
    //                 //     ->groupBy('clo_id')->get();

    //                 // $totalAverageOutcome = 0;
    //                 // $totalObeWeight = 0;

    //                 // foreach ($cloUsedInPlo as $clo) {
    //                 //     $questions = ActivityQuestion::where('courseoffer_id', $courseOffer->id)
    //                 //         ->where('clo_id', $clo->clo_id)->get();

    //                 //     foreach ($questions as $q) {
    //                 //         if ($q->obe_weight) {
    //                 //             $totalObeWeight += $q->obe_weight;
    //                 //             $outcome = StudentAssessment::where('clo_id', $clo->clo_id)
    //                 //                 ->where('student_id', $student->id)
    //                 //                 ->where('question_id', $q->id)
    //                 //                 ->where('activity_id', $q->activity_id)
    //                 //                 ->where('courseoffer_id', $courseOffer->id)
    //                 //                 ->first();

    //                 //             if ($outcome && $outcome->outcome !== null) {
    //                 //                 $weightedOutcome = ($outcome->outcome / $q->max_mark) * $q->obe_weight;
    //                 //                 $totalAverageOutcome += $weightedOutcome;
    //                 //             }
    //                 //         }
    //                 //     }

    //                 //     $cqiQuestions = CqiActivityQuestion::where('courseoffer_id', $courseOffer->id)
    //                 //         ->where('clo_id', $clo->clo_id)->get();

    //                 //     foreach ($cqiQuestions as $cq) {
    //                 //         if ($cq->obe_weight) {
    //                 //             $totalObeWeight += $cq->obe_weight;
    //                 //             $cqiOutcome = CqiStudentAssessment::where('clo_id', $clo->clo_id)
    //                 //                 ->where('student_id', $student->id)
    //                 //                 ->where('cqi_question_id', $cq->id)
    //                 //                 ->where('cqi_activity_id', $cq->cqi_activity_id)
    //                 //                 ->where('courseoffer_id', $courseOffer->id)
    //                 //                 ->first();

    //                 //             if ($cqiOutcome && $cqiOutcome->outcome !== null) {
    //                 //                 $cqiWeightedOutcome = ($cqiOutcome->outcome / $cq->max_mark) * $cq->obe_weight;
    //                 //                 $totalAverageOutcome += $cqiWeightedOutcome;
    //                 //             }
    //                 //         }
    //                 //     }
    //                 // }

    //                 // $ploweight = ($totalObeWeight != 0) ? ($totalAverageOutcome / $totalObeWeight) * 100 : 0;
    //                 // $ploAttainments[$plo->plo_id][] = number_format($ploweight, 2);
    //                 $plo_att = StudentPloAttainment::select('weighted_total')->where('student_id', $student->id)
    //                     ->where('plo_id', $plo->plo_id)
    //                     ->where('courseoffer_id', $courseOffer->id)
    //                     ->first();
    //                 $ploAttainments[$plo->plo_id][] = number_format($plo_att->weighted_total ?? 0.00 , 2);
    //             }
    //         }

    //         $data[] = [
    //             'name' => $student->name,
    //             'reg_no' => $student->roll_no ?? $student->registration_no,
    //             'plos' => $ploAttainments
    //         ];
    //     }
    //         echo "<pre>";
    //         print_r($data);
    //         die();

    //     return Excel::download(new ProgramPloExport($data, $prog_plos), 'program-plo-report.xlsx');
    // }

    public function printprogramwisereportexcel(Request $request)
    {
        ini_set('max_execution_time', 500);
        set_time_limit(500);

        $prog_plos = PLO::where('program_id', $request->program_id)->get();

        $students = Student::where('program_id', $request->program_id)
            ->where('active_session_id', $request->session_id)
            ->get();

        if ($students->isEmpty()) {
            return back()->with('error','No students found');
        }

        /* ===================== PRELOAD DATA ===================== */

        $ploCodes = PLO::pluck('code', 'id');

        $enrollments = EnrollStudent::whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy('student_id');

        $courseOffers = CourseOffer::with('course')
            ->whereIn('id', $enrollments->flatten()->pluck('course_section_id'))
            ->get()
            ->keyBy('id');

        $courseOfferPlos = CourseOfferPlo::select('course_section_id','plo_id')
            ->get()
            ->groupBy('course_section_id');

        $ploAttainments = StudentPloAttainment::whereIn('student_id', $students->pluck('id'))
            ->get()
            ->groupBy(['student_id','courseoffer_id','plo_id']);

        /* ===================== BUILD REPORT ===================== */

        $finalStudents = [];

        foreach ($students as $student) {

            $studentPlos = [];

            foreach ($enrollments[$student->id] ?? [] as $enroll) {

                $courseOffer = $courseOffers[$enroll->course_section_id] ?? null;
                if (!$courseOffer) continue;

                foreach ($courseOfferPlos[$courseOffer->id] ?? [] as $ploMap) {

                    $plo_id = $ploMap->plo_id;

                    $plo_att = optional(
                        $ploAttainments[$student->id][$courseOffer->id][$plo_id] ?? null
                    )->first();

                    $studentPlos[$plo_id][] = [
                        'attainment'   => number_format($plo_att->weighted_total ?? 0.00, 2),
                        'plo_code'     => $ploCodes[$plo_id] ?? '',
                        'course'       => $courseOffer->course->name ?? '',
                        'course_offer' => $courseOffer->id
                    ];
                }
            }

            $finalStudents[] = [
                'name'   => $student->name,
                'reg_no' => $student->roll_no ?? $student->registration_no,
                'plos'   => $studentPlos
            ];
        }

        return Excel::download(
            new ProgramPloExport($finalStudents, $prog_plos),
            'program-plo-report.xlsx'
        );
    }
   public function statusreport(Request $request)
    {
        set_time_limit(300);

        $user = Auth::user();
        $roleId = session('role_key');

        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id, $roleId);
        $flag = $hasFunctionalityPermission ? ($hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag) : '';
        $institute_ids = $hasFunctionalityPermission['institute_id'] ?? [];

        $institute = Institute::select('id', 'name')
            ->when($flag !== 'all', function ($q) use ($institute_ids) {
                $q->whereIn('id', $institute_ids);
            })
            ->whereStatus(1)
            ->get();

        $sessions = Sesssion::select('id', 'title')->get();
        $courseOffers = [];

        if ($request->isMethod('post')) {

            $courseOffers = CourseOffer::with(['course', 'teacher', 'program'])
                ->when($request->institute_id, function ($q) use ($request) {
                    $q->where('institute_id', $request->institute_id);
                })
                ->when($request->program_id, function ($q) use ($request) {
                    $q->where('program_id', $request->program_id);
                })
                ->when($request->session_id, function ($q) use ($request) {
                    $q->where('active_session_id', $request->session_id);
                })
                ->where('status', 1)
                ->get();

            foreach ($courseOffers as $offer) {

                $clos = CourseOfferClo::where('courseoffer_id', $offer->id)->pluck('code');
                $offer->clo_codes = $clos->implode(', ');

                $offer->total_questions = ActivityQuestion::where('courseoffer_id', $offer->id)->count();

                $totalEnrolled = EnrollStudent::where('course_section_id', $offer->id)->count();
                $offer->total_enrolled = $totalEnrolled;
    
                $attemptCount = StudentAssessment::where('courseoffer_id', $offer->id)
                    ->selectRaw('COUNT(DISTINCT student_id, question_id) as total')
                    ->value('total');

                if ($totalEnrolled > 0 && $offer->total_questions > 0) {

                    $potentialAttempts = $totalEnrolled * $offer->total_questions;

                    $percentage = ($attemptCount / $potentialAttempts) * 100;

                    $offer->attempt_percentage = min(100, round($percentage));

                } else {
                    $offer->attempt_percentage = 0;
                }
            }

        
            if ($request->has('export')) {

                $exportData = $courseOffers->map(function ($offer) {
                    return [
                        'course_name' => $offer->course->name ?? $offer->name,
                        'code' => $offer->course->code ?? '',
                        'section' => $offer->section,
                        'instructor' => $offer->teacher->name ?? '',
                        'total_enrolled' => $offer->total_enrolled,
                        'total_questions' => $offer->total_questions,
                        'attempt_percentage' => $offer->attempt_percentage . '%',
                    ];
                });

                return Excel::download(new CourseStatusExport($exportData), 'course-status-report.xlsx');
            }
        }

        return view('report.status_report', compact('institute', 'sessions', 'courseOffers'));
    }


}