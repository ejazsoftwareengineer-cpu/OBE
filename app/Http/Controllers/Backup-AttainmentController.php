<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CourseSection;
use App\Models\CourseOffer;
use App\Models\CLO;
use App\Models\ProgramBatch;
use App\Models\StudentAttendance;
use App\Models\ActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\EnrollStudent;
use App\Models\Institute;
use App\Models\Sesssion;
use App\Models\CourseOfferClo;
use App\Models\User;
use App\Models\Assesment;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\PLO;
use App\Models\CourseOfferPlo;
use App\Models\ActivityQuestionRubric;
use App\Models\CqiActivityQuestion;
use App\Models\CqiStudentAssessment;
use App\Models\Student;
use App\Models\PloByCourseSectionClo;
use App\Models\ClassActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use PDF;

class AttainmentController extends Controller
{
    
    public function showeCloAttainment($id)
    {   
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get(); 
        $clos = StudentAssessment::select('clo_id')
            ->where('courseoffer_id', $id)
            ->whereNotNull('clo_id')
            ->orderBy('clo_id')
            ->groupBy('clo_id')
            ->get();
        $courseofferclo = new CourseOfferClo();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $assesment = new Assesment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
         
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
        // return view('courseoffering.cloattainment.backup',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo'));
        return view('courseoffering.cloattainment.attainment',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo'));
    }

    public function showePloAttainment($id)
    {   
        
        $course = CourseOffer::select('course_id')->whereid($id)->first();
        $course_id = $course->course_id;
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get(); 
        $clos = StudentAssessment::where('courseoffer_id', $id)->distinct('clo_id')->pluck('clo_id');
        $plos = CourseOfferPlo::select('plo_id')->where('course_section_id', $id)->whereIn('clo_id', $clos)->groupBy('plo_id')->get();
        $plobycoursesectionclo = new CourseOfferPlo();
        $plo = new PLO();
        $ploObject = new PLO();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $assesment = new Assesment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
        $courseofferclo = new CourseOfferClo(); 
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

        return view('courseoffering.ploattainment.attainment',compact('id','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plo','ploObject','plobycoursesectionclo','course_offering','courseofferclo'));
    }
    public function generatePdfForPloAttainment($id)
    {
        
        $course = CourseOffer::select('course_id')->whereid($id)->first();
        $course_id = $course->course_id;
        $courseoffer = CourseOffer::with(['institute', 'course','teacher','sesssion'])->where('id',$id)->first();
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get(); 
        $clos = StudentAssessment::where('courseoffer_id', $id)->distinct('clo_id')->pluck('clo_id');
        $plos = CourseOfferPlo::select('plo_id')->where('course_section_id', $id)->whereIn('clo_id', $clos)->groupBy('plo_id')->get();
        $plobycoursesectionclo = new CourseOfferPlo();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $assesment = new Assesment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
        $courseofferclo = new CourseOfferClo();
        
        $ploObject = new PLO();
        $image = asset('public/assets/img/riphah-logo.png');
            
        $plo_data = [];
        $labels = []; 
        $data = []; 

        foreach($plos as $plo){
            $totalAverageOutcome = 0;
            $totalStudents = count($enrolledstudent);
            $studentsAbove50 = 0;
            // $plo_code = $plobycoursesectionclo::select('code')->where('plo_id', $plo->plo_id)->first()
            foreach($enrolledstudent as $student){
                $studentTotalOutcome = 0;
                $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                    ->where('course_id', $course_id)
                    ->where('plo_id', $plo->plo_id)
                    ->groupBy('clo_id')
                    ->get();

                foreach($clo_usedinplo as $clo){
                    $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')
                        ->where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    foreach($questions as $q){
                        $outcomes = $studentassessment::select('id','outcome')
                            ->where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('question_id', $q->id)
                            ->where('activity_id', $q->activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();
                        
                        if($q->obe_weight && $outcomes !== null){
                            $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                            $studentTotalOutcome += $averageOutcome;
                        }
                    }

                    $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')
                        ->where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    foreach($cqiquestions as $cq){
                        $cqioutcomes = $cqistudentassessment::select('id','outcome')
                            ->where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('cqi_question_id', $cq->id)
                            ->where('cqi_activity_id', $cq->cqi_activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();

                        if($cq->obe_weight && $cqioutcomes !== null){
                            $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
                            $studentTotalOutcome += $cqiaverageOutcome;
                        }
                    }
                }

                // Apply the new rule for attainment calculation
                if ($studentTotalOutcome >= 50) {
                    $studentsAbove50++;
                    $studentTotalOutcome = 100; // Consider it as 100%
                } else {
                    $studentTotalOutcome = 0; // Consider it as 0%
                }

                $totalAverageOutcome += $studentTotalOutcome;
            }

            $averageAttainment = ($totalAverageOutcome / $totalStudents);
            $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;
            $i =1;
            $plo_data[] = [
                'plo' => 'PLO'.$i,
                'total_students' => $totalStudents,
                'students_above_50' => $studentsAbove50,
                'percentage_above_50' => $percentageAbove50,
                'average_attainment' => $averageAttainment
            ];
            
            $labels[] = 'PLO'.$i ?? 'PLO CODE'; 
            $data[] = $averageAttainment; 
            $i++;
        }

        
        // $outputPath = storage_path('app/public/plo_chart.png');
        $outputPath = 'https://obe.riphah.edu.pk/storage/app/public/plo_chart.png';
        $chartImagePath = $this->generateChartImage($labels, $data,$outputPath);

        $pdf = PDF::loadView('courseoffering.ploattainment.pdfattainment',compact('id','ploObject','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plobycoursesectionclo','courseoffer','plo_data','courseofferclo'))
        ->setOptions(['defaultFont' => 'sans-serif', 'zoom' => 1.08])
        ->setPaper('a4', 'landscape');

        return $pdf->download('plo-attainment.pdf');
    }
    
    public function generatePdfForCloAttainment($id)
    {
        $courseoffer = CourseOffer::with(['institute', 'course','teacher'])->where('id', $id)->first();
        $enrolledstudent = EnrollStudent::with(['student', 'course_section'])->where('course_section_id', $id)->latest()->get(); 
        $clos = StudentAssessment::select('clo_id')
            ->where('courseoffer_id', $id)
            ->whereNotNull('clo_id')
            ->orderBy('clo_id')
            ->groupBy('clo_id')
            ->get();
        $courseofferclo = new CourseOfferClo();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
        $assesment = new Assesment();
        
        $clo_data = [];
        $labels = []; 
        $data = []; 

        foreach ($clos as $clo) {
            $clo_code = $courseofferclo::select('code')->where('id', $clo->clo_id)->first();
            $totalAverageOutcome = 0;
            $totalStudents = count($enrolledstudent);
            $studentsAbove50 = 0;

            foreach ($enrolledstudent as $student) {
                $studentTotalOutcome = 0;
                $questions = $activityquestion::select('id', 'activity_id', 'obe_weight', 'max_mark')
                    ->where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->get();
                
                foreach ($questions as $q) {
                    $outcomes = $studentassessment::select('id', 'outcome')
                        ->where('clo_id', $clo->clo_id)
                        ->where('student_id', $student->student->id)
                        ->where('question_id', $q->id)
                        ->where('activity_id', $q->activity_id)
                        ->where('courseoffer_id', $id)
                        ->first();
                    
                    if ($q->obe_weight && $outcomes !== null) {
                        $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                        $studentTotalOutcome += $averageOutcome;
                    }
                }

                if ($studentTotalOutcome >= 50) {
                    $studentsAbove50++;
                    $studentTotalOutcome = 100;
                } else {
                    $studentTotalOutcome = 0; 
                }

                $totalAverageOutcome += $studentTotalOutcome;
            }

            $averageAttainment = ($totalAverageOutcome / $totalStudents);
            $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;

            $clo_data[] = [
                'clo' => $clo_code->code ?? '-',
                'total_students' => $totalStudents,
                'students_above_50' => $studentsAbove50,
                'percentage_above_50' => $percentageAbove50,
                'average_attainment' => $averageAttainment
            ];

            $labels[] = $clo_code->code ?? 'CLO CODE'; 
            $data[] = $averageAttainment; 
        }
        // $outputPath = storage_path('app/public/clo_chart.png');
        $outputPath = 'https://obe.riphah.edu.pk/storage/app/public/clo_chart.png';
        $chartImagePath = $this->generateChartImage($labels, $data,$outputPath);

        $pdf = PDF::loadView('courseoffering.cloattainment.pdfattainment', compact('id', 'cqiactivityquestion', 'cqistudentassessment', 'clos', 'activityquestion', 'enrolledstudent', 'studentassessment', 'assesment', 'courseoffer', 'courseofferclo', 'clo_data','chartImagePath'))->setOptions(['defaultFont' => 'sans-serif', 'zoom' => 1.08])->setPaper('a4', 'landscape');

        return $pdf->download('clo-attainment.pdf');
    }

    private function generateChartImage($labels, $data,$outputPath)
    {

        $labelsJson = json_encode($labels);
        $dataJson = json_encode($data);

        // Set environment variables
        putenv("LABELS=$labelsJson");
        putenv("DATA=$dataJson");
        putenv("OUTPUT_PATH=$outputPath");

        // Execute the Node.js script
        // $nodeScript = base_path('public/assets/js/script.js');
        $nodeScript = 'https://obe.riphah.edu.pk/public/assets/js/script.js';
        $command = "node $nodeScript";
        exec($command, $output, $returnVar);
        return $outputPath;
    }

    public function printclo(Request $request)
    {
        $id = $request->id;
        $clo_chart = $request->clo_chart;
        $courseoffer = CourseOffer::with(['institute', 'course','teacher'])->where('id', $id)->first();
        $enrolledstudent = EnrollStudent::with(['student', 'course_section'])->where('course_section_id', $id)->latest()->get(); 
        $clos = StudentAssessment::select('clo_id')
            ->where('courseoffer_id', $id)
            ->whereNotNull('clo_id')
            ->orderBy('clo_id')
            ->groupBy('clo_id')
            ->get();
        $courseofferclo = new CourseOfferClo();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
        $assesment = new Assesment();
        // $clo_data = [];
        $clo_data = [];
        $labels = []; 
        $data = []; 

        foreach ($clos as $clo) {
            $clo_code = $courseofferclo::select('code')->where('id', $clo->clo_id)->first();
            $totalAverageOutcome = 0;
            $totalStudents = count($enrolledstudent);
            $studentsAbove50 = 0;

            foreach ($enrolledstudent as $student) {
                $studentTotalOutcome = 0;
                $questions = $activityquestion::select('id', 'activity_id', 'obe_weight', 'max_mark')
                    ->where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->get();
                
                foreach ($questions as $q) {
                    $outcomes = $studentassessment::select('id', 'outcome')
                        ->where('clo_id', $clo->clo_id)
                        ->where('student_id', $student->student->id)
                        ->where('question_id', $q->id)
                        ->where('activity_id', $q->activity_id)
                        ->where('courseoffer_id', $id)
                        ->first();
                    
                    if ($q->obe_weight && $outcomes !== null) {
                        $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                        $studentTotalOutcome += $averageOutcome;
                    }
                }

                if ($studentTotalOutcome >= 50) {
                    $studentsAbove50++;
                    $studentTotalOutcome = 100;
                } else {
                    $studentTotalOutcome = 0; 
                }

                $totalAverageOutcome += $studentTotalOutcome;
            }

            $averageAttainment = ($totalAverageOutcome / $totalStudents);
            $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;

            $clo_data[] = [
                'clo' => $clo_code->code ?? '-',
                'total_students' => $totalStudents,
                'students_above_50' => $studentsAbove50,
                'percentage_above_50' => $percentageAbove50,
                'average_attainment' => $averageAttainment
            ];

            $labels[] = $clo_code->code ?? 'CLO CODE'; 
            $data[] = $averageAttainment; 
        }
        
        $pdf = PDF::loadView('courseoffering.cloattainment.pdfattainment', compact('id', 'cqiactivityquestion', 'cqistudentassessment', 'clos', 'activityquestion', 'enrolledstudent', 'studentassessment', 'assesment', 'courseoffer', 'courseofferclo','clo_data', 'clo_chart'));

        return $pdf->download('clo-attainment.pdf');

        // dd($request->clo_chart);
        // echo "================================";
        // exit;
        // $pdf = PDF::loadView('courseoffering.print')->setOptions(['defaultFont' =>'sans-serif', 'zoom' => 1.08])->setPaper('a4', 'landscape');
        // return $pdf->download('courseoffering.pdf');
    }
    public function printplo(Request $request)
    {
        $id = $request->id;
        $plo_chart = $request->plo_chart;
        $course = CourseOffer::select('course_id')->whereid($id)->first();
        $course_id = $course->course_id;
        $courseoffer = CourseOffer::with(['institute', 'course','teacher','sesssion'])->where('id',$id)->first();
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get(); 
        $clos = StudentAssessment::where('courseoffer_id', $id)->distinct('clo_id')->pluck('clo_id');
        $plos = CourseOfferPlo::select('plo_id')->where('course_section_id', $id)->whereIn('clo_id', $clos)->groupBy('plo_id')->get();
        $plobycoursesectionclo = new CourseOfferPlo();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $assesment = new Assesment();
        $cqiactivityquestion = new CqiActivityQuestion();
        $cqistudentassessment = new CqiStudentAssessment();
        $courseofferclo = new CourseOfferClo();
        
        $ploObject = new PLO();
    
        $plo_data = [];
        $labels = []; 
        $data = []; 
        $totalStudents = count($enrolledstudent);

        foreach ($plos as $plo) {
            // Reset accumulators for each PLO
            $totalAverageOutcome1 = 0; 
            $studentsAbove50 = 0; 

            // Loop through all students
            foreach ($enrolledstudent as $student) {
                // Reset accumulators for each student
                $studentTotalOutcome = 0;
                $totalobeweight = 0;

                // Fetch CLOs associated with the current PLO
                $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                    ->where('course_id', $course_id)
                    ->where('plo_id', $plo->plo_id)
                    ->groupBy('clo_id')
                    ->get();

                // Loop through each CLO used in the PLO
                foreach ($clo_usedinplo as $clo) {
                    // Fetch questions linked to the CLO
                    $questions = $activityquestion::select('id', 'activity_id', 'obe_weight', 'max_mark')
                        ->where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    // Loop through each question linked to this CLO
                    foreach ($questions as $q) {
                        // Initialize OBE weight for each question
                        $obe_weight = '';
                        if ($q->obe_weight) {
                            $obe_weight = $q->obe_weight . '.00';
                            $totalobeweight += $q->obe_weight; // Add OBE weight to total
                        }

                        // Fetch the student's outcome for this question
                        $outcomes = $studentassessment::select('id', 'outcome')
                            ->where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('question_id', $q->id)
                            ->where('activity_id', $q->activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();

                        // Calculate the weighted outcome if a valid outcome and weight exist
                        if ($q->obe_weight && $outcomes !== null) {
                            $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                            $studentTotalOutcome += $averageOutcome;
                        }
                    }

                    // Fetch CQI activity questions associated with the CLO
                    $cqiquestions = $cqiactivityquestion::select('id', 'cqi_activity_id', 'obe_weight', 'max_mark')
                        ->where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    // Loop through each CQI question and calculate its weighted outcome
                    foreach ($cqiquestions as $cq) {
                        if ($cq->obe_weight) {
                            $cqi_obe_weight = $cq->obe_weight . '.00';
                            $totalobeweight += $cq->obe_weight;
                        }

                        // Fetch the student's CQI outcome
                        $cqioutcomes = $cqistudentassessment::select('id', 'outcome')
                            ->where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('cqi_question_id', $cq->id)
                            ->where('cqi_activity_id', $cq->cqi_activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();

                        // Calculate the weighted CQI outcome
                        if ($cq->obe_weight && $cqioutcomes !== null) {
                            $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
                            $studentTotalOutcome += $cqiaverageOutcome;
                        }
                    }
                }

                // Calculate the overall attainment percentage for this student
                $ploweight = ($totalobeweight != 0) ? ($studentTotalOutcome / $totalobeweight) * 100 : 0;

                // Check if the student's performance is above the 50% threshold
                if ($ploweight >= 50) {
                    $studentsAbove50++;
                    $studentTotalOutcome = 100; // Fully achieved
                } else {
                    $studentTotalOutcome = 0; // Not achieved
                }

                // Accumulate total outcomes for this PLO
                $totalAverageOutcome1 += $studentTotalOutcome;
            }

            // Calculate PLO averages
            $averageAttainment = ($totalStudents > 0) ? ($totalAverageOutcome1 / $totalStudents) : 0;
            $percentageAbove50 = ($totalStudents > 0) ? ($studentsAbove50 / $totalStudents) * 100 : 0;
            $i =1;
            // Store PLO results
            $plo_data[] = [
                'plo' => $plo->plo_id,
                'total_students' => $totalStudents,
                'students_above_50' => $studentsAbove50,
                'percentage_above_50' => $percentageAbove50,
                'average_attainment' => $averageAttainment
            ];
                 $labels[] = 'PLO'.$i ?? 'PLO CODE'; 
            $data[] = $averageAttainment; 
            $i++;
        }
        // foreach($plos as $plo){
        //     $totalAverageOutcome = 0;
        //     $totalStudents = count($enrolledstudent);
        //     $studentsAbove50 = 0;
        //     // $plo_code = $plobycoursesectionclo::select('code')->where('plo_id', $plo->plo_id)->first()
        //     foreach($enrolledstudent as $student){
        //         $studentTotalOutcome = 0;
        //         $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
        //             ->where('course_id', $course_id)
        //             ->where('plo_id', $plo->plo_id)
        //             ->groupBy('clo_id')
        //             ->get();

        //         foreach($clo_usedinplo as $clo){
        //             $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')
        //                 ->where('courseoffer_id', $id)
        //                 ->where('clo_id', $clo->clo_id)
        //                 ->get();

        //             foreach($questions as $q){
        //                 $outcomes = $studentassessment::select('id','outcome')
        //                     ->where('clo_id', $clo->clo_id)
        //                     ->where('student_id', $student->student->id)
        //                     ->where('question_id', $q->id)
        //                     ->where('activity_id', $q->activity_id)
        //                     ->where('courseoffer_id', $id)
        //                     ->first();
                        
        //                 if($q->obe_weight && $outcomes !== null){
        //                     $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
        //                     $studentTotalOutcome += $averageOutcome;
        //                 }
        //             }

        //             $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')
        //                 ->where('courseoffer_id', $id)
        //                 ->where('clo_id', $clo->clo_id)
        //                 ->get();

        //             foreach($cqiquestions as $cq){
        //                 $cqioutcomes = $cqistudentassessment::select('id','outcome')
        //                     ->where('clo_id', $clo->clo_id)
        //                     ->where('student_id', $student->student->id)
        //                     ->where('cqi_question_id', $cq->id)
        //                     ->where('cqi_activity_id', $cq->cqi_activity_id)
        //                     ->where('courseoffer_id', $id)
        //                     ->first();

        //                 if($cq->obe_weight && $cqioutcomes !== null){
        //                     $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
        //                     $studentTotalOutcome += $cqiaverageOutcome;
        //                 }
        //             }
        //         }

        //         // Apply the new rule for attainment calculation
        //         if ($studentTotalOutcome >= 50) {
        //             $studentsAbove50++;
        //             $studentTotalOutcome = 100; // Consider it as 100%
        //         } else {
        //             $studentTotalOutcome = 0; // Consider it as 0%
        //         }

        //         $totalAverageOutcome += $studentTotalOutcome;
        //     }

        //     $averageAttainment = ($totalAverageOutcome / $totalStudents);
        //     $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;
        //     $i =1;
        //     $plo_data[] = [
        //         'plo' => 'PLO'.$i,
        //         'total_students' => $totalStudents,
        //         'students_above_50' => $studentsAbove50,
        //         'percentage_above_50' => $percentageAbove50,
        //         'average_attainment' => $averageAttainment
        //     ];
            
        //     $labels[] = 'PLO'.$i ?? 'PLO CODE'; 
        //     $data[] = $averageAttainment; 
        //     $i++;
        // }
        
        $pdf = PDF::loadView('courseoffering.ploattainment.pdfattainment',compact('id','ploObject','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plobycoursesectionclo','courseoffer','plo_data','plo_chart','courseofferclo'))
        ->setOptions(['defaultFont' => 'sans-serif', 'zoom' => 1.08])
        ->setPaper('a4', 'landscape');

        return $pdf->download('plo-attainment.pdf');

        // dd($request->clo_chart);
        // echo "================================";
        // exit;
        // $pdf = PDF::loadView('courseoffering.print')->setOptions(['defaultFont' =>'sans-serif', 'zoom' => 1.08])->setPaper('a4', 'landscape');
        // return $pdf->download('courseoffering.pdf');
    }
    




}
