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
use App\Models\StudentPloAttainment;
use App\Models\StudentQuestionPloAttainment;
use App\Models\PloByCourseSectionClo;
use App\Models\StudentQuestionAttainment;
use App\Models\StudentCloAttainment;
use App\Models\ClassActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use PDF;
use App\Jobs\ProcessAssessmentLock;
use Illuminate\Support\Facades\DB;

class AttainmentController extends Controller
{

    public function showeCloAttainment($id)
    {
         ini_set('memory_limit', '256M');
        // init
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
        // $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->take(5)->get();
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
        $StudentQuestionAttainment = new StudentQuestionAttainment();
        $StudentCloAttainment = new StudentCloAttainment();

        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
        // return view('courseoffering.cloattainment.backup',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo'));
        return view('courseoffering.cloattainment.attainment',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo','StudentCloAttainment','StudentQuestionAttainment'));
    }
    public function printCloAttainmentPdf(Request $request)
    {
        ini_set('memory_limit', '512M'); // Increase memory for heavy table
        ini_set("pcre.backtrack_limit", "5000000");

        $id = $request->id;

        // Load all required models exactly like the main page
        $enrolledstudent = EnrollStudent::with(['student','course_section'])
            ->wherecourse_section_id($id)
            ->latest()
            ->get();

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
        $StudentQuestionAttainment = new StudentQuestionAttainment();
        $StudentCloAttainment = new StudentCloAttainment();

        $course_offering = CourseOffer::with(['institute','course','teacher','program'])
            ->whereid($id)
            ->first();

        // Chart received as base64
        $chartImage = $request->clo_chart;

        // Build CLO stats for the chart + table
        $clo_data = [];

        foreach ($clos as $clo) {

            $clo_code = $courseofferclo::select('code')->whereId($clo->clo_id)->first();

            $records = $StudentCloAttainment::where('courseoffer_id', $id)
                ->where('clo_id', $clo->clo_id)
                ->get();

            $total_students = $records->count();
            $students_above_50 = $records->where('achieved_flag', 'Y')->count();

            $percentage_above_50 = $total_students > 0 
                ? ($students_above_50 / $total_students) * 100 
                : 0;

            $average_attainment = $total_students > 0 
                ? $records->avg('weighted_total') 
                : 0;

            $clo_data[] = [
                'clo' => $clo_code->code ?? '-',
                'total_students' => $total_students,
                'students_above_50' => $students_above_50,
                'percentage_above_50' => round($percentage_above_50, 2),
                'average_attainment' => round($average_attainment, 2),
            ];
        }

        // Load PDF view
        $pdf = \PDF::loadView(
            'courseoffering.cloattainment.clo_attainment_pdf',
            compact(
                'id','cqiactivityquestion','cqistudentassessment','clos','activityquestion',
                'enrolledstudent','studentassessment','assesment','course_offering',
                'courseofferclo','StudentCloAttainment','StudentQuestionAttainment','clo_data',
                'chartImage'
            )
        )->setPaper('A4', 'landscape'); // Landscape for wide table

        return $pdf->stream("CLO_Attainment_$id.pdf");
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
        $StudentQuestionPloAttainment = new StudentQuestionPloAttainment();
        $StudentPloAttainment = new StudentPloAttainment();
        $courseofferclo = new CourseOfferClo();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

        return view('courseoffering.ploattainment.attainment',compact('id','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plo','ploObject','plobycoursesectionclo','course_offering','courseofferclo','StudentQuestionPloAttainment','StudentPloAttainment'));

    }

    
    // public function generatePdfForPloAttainment($id)
    // {

    //     $course = CourseOffer::select('course_id')->whereid($id)->first();
    //     $course_id = $course->course_id;
    //     $courseoffer = CourseOffer::with(['institute', 'course','teacher','sesssion'])->where('id',$id)->first();
    //     $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
    //     $clos = StudentAssessment::where('courseoffer_id', $id)->distinct('clo_id')->pluck('clo_id');
    //     $plos = CourseOfferPlo::select('plo_id')->where('course_section_id', $id)->whereIn('clo_id', $clos)->groupBy('plo_id')->get();
    //     $plobycoursesectionclo = new CourseOfferPlo();
    //     $activityquestion = new ActivityQuestion();
    //     $studentassessment = new StudentAssessment();
    //     $assesment = new Assesment();
    //     $cqiactivityquestion = new CqiActivityQuestion();
    //     $cqistudentassessment = new CqiStudentAssessment();
    //     $courseofferclo = new CourseOfferClo();

    //     $ploObject = new PLO();
    //     $image = asset('public/assets/img/riphah-logo.png');

    //     $plo_data = [];
    //     $labels = [];
    //     $data = [];

    //     foreach($plos as $plo){
    //         $totalAverageOutcome = 0;
    //         $totalStudents = count($enrolledstudent);
    //         $studentsAbove50 = 0;
    //         $plo_code = $ploObject::select('id','code')->whereid($plo->plo_id)->first();
    //         // $plo_code = $plobycoursesectionclo::select('code')->where('plo_id', $plo->plo_id)->first()
    //         foreach($enrolledstudent as $student){
    //             $studentTotalOutcome = 0;
    //             $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
    //                 ->where('course_id', $course_id)
    //                 ->where('plo_id', $plo->plo_id)
    //                 ->groupBy('clo_id')
    //                 ->get();

    //             foreach($clo_usedinplo as $clo){
    //                 $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')
    //                     ->where('courseoffer_id', $id)
    //                     ->where('clo_id', $clo->clo_id)
    //                     ->get();

    //                 foreach($questions as $q){
    //                     $outcomes = $studentassessment::select('id','outcome')
    //                         ->where('clo_id', $clo->clo_id)
    //                         ->where('student_id', $student->student->id)
    //                         ->where('question_id', $q->id)
    //                         ->where('activity_id', $q->activity_id)
    //                         ->where('courseoffer_id', $id)
    //                         ->first();

    //                     if($q->obe_weight && $outcomes !== null){
    //                         $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
    //                         $studentTotalOutcome += $averageOutcome;
    //                     }
    //                 }

    //                 $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')
    //                     ->where('courseoffer_id', $id)
    //                     ->where('clo_id', $clo->clo_id)
    //                     ->get();

    //                 foreach($cqiquestions as $cq){
    //                     $cqioutcomes = $cqistudentassessment::select('id','outcome')
    //                         ->where('clo_id', $clo->clo_id)
    //                         ->where('student_id', $student->student->id)
    //                         ->where('cqi_question_id', $cq->id)
    //                         ->where('cqi_activity_id', $cq->cqi_activity_id)
    //                         ->where('courseoffer_id', $id)
    //                         ->first();

    //                     if($cq->obe_weight && $cqioutcomes !== null){
    //                         $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
    //                         $studentTotalOutcome += $cqiaverageOutcome;
    //                     }
    //                 }
    //             }

    //             // Apply the new rule for attainment calculation
    //             if ($studentTotalOutcome >= 50) {
    //                 $studentsAbove50++;
    //                 $studentTotalOutcome = 100; // Consider it as 100%
    //             } else {
    //                 $studentTotalOutcome = 0; // Consider it as 0%
    //             }

    //             $totalAverageOutcome += $studentTotalOutcome;
    //         }

    //         $averageAttainment = ($totalAverageOutcome / $totalStudents);
    //         $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;
    //         $i =1;
    //         $plo_data[] = [
    //             'plo' => $plo_code->code,
    //             'total_students' => $totalStudents,
    //             'students_above_50' => $studentsAbove50,
    //             'percentage_above_50' => $percentageAbove50,
    //             'average_attainment' => $averageAttainment
    //         ];

    //         $labels[] = $plo_code->code ?? 'PLO CODE';
    //         $data[] = $averageAttainment;
    //         $i++;
    //     }


    //     // $outputPath = storage_path('app/public/plo_chart.png');
    //     $outputPath = 'https://obe.riphah.edu.pk/storage/app/public/plo_chart.png';
    //     $chartImagePath = $this->generateChartImage($labels, $data,$outputPath);
    //     // echo $chartImagePath;
    //     // exit;
    //     $pdf = PDF::loadView('courseoffering.ploattainment.pdfattainment',compact('id','ploObject','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plobycoursesectionclo','courseoffer','plo_data','courseofferclo'))
    //     ->setOptions(['defaultFont' => 'sans-serif', 'zoom' => 1.08])
    //     ->setPaper('a4', 'landscape');

    //     return $pdf->download('plo-attainment.pdf');
    // }
    public function generatePdfForPloAttainment($id)
{
    $course = CourseOffer::select('course_id')->where('id', $id)->first();
    $course_id = $course->course_id;

    $enrolledstudent = EnrollStudent::with(['student','course_section'])
        ->where('course_section_id', $id)->latest()->get();

    $clos = StudentAssessment::where('courseoffer_id', $id)->distinct('clo_id')->pluck('clo_id');
    $plos = CourseOfferPlo::select('plo_id')
        ->where('course_section_id', $id)
        ->whereIn('clo_id', $clos)
        ->groupBy('plo_id')->get();

    $plobycoursesectionclo = new CourseOfferPlo();
    $ploObject = new PLO();
    $activityquestion = new ActivityQuestion();
    $assesment = new Assesment();
    $cqiactivityquestion = new CqiActivityQuestion();
    $StudentQuestionPloAttainment = new StudentQuestionPloAttainment();
    $StudentPloAttainment = new StudentPloAttainment();
    $courseofferclo = new CourseOfferClo();

    $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])
        ->where('id', $id)->latest()->first();

    // Generate PLO Summary Data (same logic as in view)
    $plo_data = [];
    foreach ($plos as $plo) {
        $plo_code = PLO::select('code')->where('id', $plo->plo_id)->first();

        $records = StudentPloAttainment::where('courseoffer_id', $id)
            ->where('plo_id', $plo->plo_id)
            ->get();

        $total_students = $records->count();
        $students_above_50 = $records->where('achieved_flag', 'Y')->count();
        $percentage_above_50 = $total_students > 0 ? ($students_above_50 / $total_students) * 100 : 0;
        $average_attainment = $total_students > 0 ? $records->avg('weighted_total') : 0;

        $plo_data[] = [
            'plo' => $plo_code->code ?? 'PLO',
            'total_students' => $total_students,
            'students_above_50' => $students_above_50,
            'percentage_above_50' => round($percentage_above_50, 2),
            'average_attainment' => round($average_attainment, 2),
        ];
    }

    // Generate Chart as Base64 Image (using Google Charts via URL)
    $chartUrl = $this->generatePloChartImage($plo_data);

    $data = compact(
        'id', 'course_id', 'enrolledstudent', 'plos', 'plobycoursesectionclo',
        'ploObject', 'activityquestion', 'assesment', 'cqiactivityquestion',
        'StudentQuestionPloAttainment', 'StudentPloAttainment', 'courseofferclo',
        'course_offering', 'plo_data', 'chartUrl'
    );

    $pdf = Pdf::loadView('courseoffering.ploattainment.pdf', $data)
              ->setPaper('a4', 'landscape');

    return $pdf->stream('PLO_Attainment_'.$course_offering->course->code.'.pdf');
}
    private function generatePloChartImage($plo_data)
{
    $labels = [];
    $values = [];
    foreach ($plo_data as $item) {
        $labels[] = $item['plo'];
        $values[] = $item['average_attainment'];
    }

    $chartData = [
        'cht' => 'bvg',
        'chs' => '900x400',
        'chd' => 't:' . implode(',', $values),
        'chl' => implode('|', $labels),
        'chxt' => 'x,y',
        'chxl' => '1:|0|20|40|60|80|100',
        'chco' => '4C7EF4',
        'chtt' => 'PLO Attainment Chart',
        'chts' => '000000,16',
        'chxt' => 'x,y',
        'chxl' => '0:|' . implode('|', $labels) . '|1:|0%|20%|40%|60%|80%|100%',
        'chds' => '0,100',
        'chbh' => 'a',
        'chf' => 'bg,s,FFFFFF',
        'chm' => 'N,000000,0,-1,12'
    ];

    return 'https://chart.googleapis.com/chart?' . http_build_query($chartData);
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

    // public function printclo(Request $request)
    // {
    //     $id = $request->id;
    //     $clo_chart = $request->clo_chart;
    //     $courseoffer = CourseOffer::with(['institute', 'course','teacher'])->where('id', $id)->first();
    //     $enrolledstudent = EnrollStudent::with(['student', 'course_section'])->where('course_section_id', $id)->latest()->get();
    //     $clos = StudentAssessment::select('clo_id')
    //         ->where('courseoffer_id', $id)
    //         ->whereNotNull('clo_id')
    //         ->orderBy('clo_id')
    //         ->groupBy('clo_id')
    //         ->get();
    //     $courseofferclo = new CourseOfferClo();
    //     $activityquestion = new ActivityQuestion();
    //     $studentassessment = new StudentAssessment();
    //     $cqiactivityquestion = new CqiActivityQuestion();
    //     $cqistudentassessment = new CqiStudentAssessment();
    //     $assesment = new Assesment();
    //     // $clo_data = [];
    //     $clo_data = [];
    //     $labels = [];
    //     $data = [];

    //     foreach ($clos as $clo) {
    //         $clo_code = $courseofferclo::select('code')->where('id', $clo->clo_id)->first();
    //         $totalAverageOutcome = 0;
    //         $totalStudents = count($enrolledstudent);
    //         $studentsAbove50 = 0;

    //         foreach ($enrolledstudent as $student) {
    //             $studentTotalOutcome = 0;
    //             $questions = $activityquestion::select('id', 'activity_id', 'obe_weight', 'max_mark')
    //                 ->where('courseoffer_id', $id)
    //                 ->where('clo_id', $clo->clo_id)
    //                 ->get();

    //             foreach ($questions as $q) {
    //                 $outcomes = $studentassessment::select('id', 'outcome')
    //                     ->where('clo_id', $clo->clo_id)
    //                     ->where('student_id', $student->student->id)
    //                     ->where('question_id', $q->id)
    //                     ->where('activity_id', $q->activity_id)
    //                     ->where('courseoffer_id', $id)
    //                     ->first();

    //                 if ($q->obe_weight && $outcomes !== null) {
    //                     $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
    //                     $studentTotalOutcome += $averageOutcome;
    //                 }
    //             }

    //             if ($studentTotalOutcome >= 50) {
    //                 $studentsAbove50++;
    //                 $studentTotalOutcome = 100;
    //             } else {
    //                 $studentTotalOutcome = 0;
    //             }

    //             $totalAverageOutcome += $studentTotalOutcome;
    //         }

    //         $averageAttainment = ($totalAverageOutcome / $totalStudents);
    //         $percentageAbove50 = ($studentsAbove50 / $totalStudents) * 100;

    //         $clo_data[] = [
    //             'clo' => $clo_code->code ?? '-',
    //             'total_students' => $totalStudents,
    //             'students_above_50' => $studentsAbove50,
    //             'percentage_above_50' => $percentageAbove50,
    //             'average_attainment' => $averageAttainment
    //         ];

    //         $labels[] = $clo_code->code ?? 'CLO CODE';
    //         $data[] = $averageAttainment;
    //     }

    //     $pdf = PDF::loadView('courseoffering.cloattainment.pdfattainment', compact('id', 'cqiactivityquestion', 'cqistudentassessment', 'clos', 'activityquestion', 'enrolledstudent', 'studentassessment', 'assesment', 'courseoffer', 'courseofferclo','clo_data', 'clo_chart'));

    //     return $pdf->stream('clo-attainment.pdf');
    //     // return $pdf->download('clo-attainment.pdf');

    //     // dd($request->clo_chart);
    //     // echo "================================";
    //     // exit;
    //     // $pdf = PDF::loadView('courseoffering.print')->setOptions(['defaultFont' =>'sans-serif', 'zoom' => 1.08])->setPaper('a4', 'landscape');
    //     // return $pdf->download('courseoffering.pdf');
    // }
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
        $StudentQuestionPloAttainment = new StudentQuestionPloAttainment();
        $StudentPloAttainment = new StudentPloAttainment();
        $ploObject = new PLO();
        foreach($plos as $plo){
            
            $plo_code = $ploObject::select('code')->whereId($plo->plo_id)->first();
    
            $records = $StudentPloAttainment::where('courseoffer_id', $id)
                ->where('plo_id', $plo->plo_id)
                ->get();
    
            $total_students = $records->count();
            $students_above_50 = $records->where('achieved_flag','Y')->count();
            $percentage_above_50 = $total_students > 0 
                ? ($students_above_50 / $total_students) * 100 
                : 0;
            $average_attainment = $total_students > 0 
                ? $records->avg('weighted_total')   // FIXED
                : 0;
    
    
            // push to array (optional, for JSON/export)
            $plo_data[] = [
                'plo' => $plo_code->code ?? '-',
                'total_students' => $total_students,
                'students_above_50' => $students_above_50,
                'percentage_above_50' => round($percentage_above_50, 2),
                'average_attainment' => round($average_attainment, 2),
            ];
        }


        $pdf = PDF::loadView('courseoffering.ploattainment.pdfattainment',compact('id','ploObject','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','StudentQuestionPloAttainment','StudentPloAttainment','plobycoursesectionclo','courseoffer','plo_chart','courseofferclo','plo_data'))
        ->setOptions(['defaultFont' => 'sans-serif' ])
        ->setPaper('a4', 'landscape');
        // echo "<pre>";
        // print_r($pdf);
        // die();
        return $pdf->stream('plo-attainment.pdf');

        // return $pdf->download('plo-attainment.pdf');

    }

    // public function lockAssessment($id)
    // {
    //     $offering = CourseOffer::findOrFail($id);
    //     $offering->locked = 1;
    //     $offering->save();

    //     // Delete old records
    //     StudentQuestionAttainment::where('courseoffer_id', $id)->delete();
    //     StudentCloAttainment::where('courseoffer_id', $id)->delete();
    //     StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
    //     StudentPloAttainment::where('courseoffer_id', $id)->delete();

    //     // Dispatch queue (this runs in background)
    //     ProcessAssessmentLock::dispatch($id);

    //     return redirect()->route('showenrolledstudentassessment', $id)
    //         ->with('success', 'Assessment Locked — Processing in background.');
    // }

        // public function lockAssessment($id)
        // {
        //     $offering = CourseOffer::findOrFail($id);
        //     $offering->locked = 1;
        //     $offering->save();

        //     // Remove old attainment records for a clean recalculation
        //     StudentQuestionAttainment::where('courseoffer_id', $id)->delete();
        //     StudentCloAttainment::where('courseoffer_id', $id)->delete();
        //     // StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
        //     // StudentPloAttainment::where('courseoffer_id', $id)->delete();

        //     $this->calculateAndStoreQuestionAttainment($id);
        //     $this->calculateAndStoreCloAttainment($id);
        //     // $this->calculateAndStorePloQuestionAttainment($id);
        //     // $this->calculateAndStorePloAttainment($id);

        //     // return redirect()->route('showenrolledstudentassessment', $id)
        //         // ->with('success', 'Locked Assessment');
        // } 
        public function lockAssessment($id)
        {
            ini_set('max_execution_time', 300);
            set_time_limit(300);

            DB::transaction(function () use ($id) {

                // Lock assessment
                CourseOffer::whereId($id)->update(['locked' => 1]);

                // Clean old data (Question + CLO)
                StudentQuestionAttainment::where('courseoffer_id', $id)->delete();
                StudentCloAttainment::where('courseoffer_id', $id)->delete();

                // Recalculate Question → CLO attainment
                $this->calculateAndStoreQuestionAndCloAttainment($id);
            });

            // return redirect()->route('showenrolledstudentassessment', $id)
                // ->with('success', 'Assessment locked and attainments calculated successfully.');
        }
        // public function lockAssessmentPLO($id)
        // {
        //     $offering = CourseOffer::findOrFail($id);
        //     $offering->lockedplo = 1;
        //     $offering->save();

        //     // Remove old attainment records for a clean recalculation
        //     // StudentQuestionAttainment::where('courseoffer_id', $id)->delete();
        //     // StudentCloAttainment::where('courseoffer_id', $id)->delete();
        //     StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
        //     StudentPloAttainment::where('courseoffer_id', $id)->delete();

        //     // $this->calculateAndStoreQuestionAttainment($id);
        //     // $this->calculateAndStoreCloAttainment($id);
        //     $this->calculateAndStorePloAttainmentComplete($id);
        //     // $this->calculateAndStorePloQuestionAttainment($id);
        //     echo "<pre>";
        //     print_r('k');
        //     die();
        //     // $this->calculateAndStorePloAttainment($id);

        //     // return redirect()->route('showenrolledstudentassessment', $id)
        //         // ->with('success', 'Locked Assessment');
        // }
// public function lockAssessmentPLO($id)
// {
//     DB::beginTransaction();

//     try {

//         $offering = CourseOffer::findOrFail($id);
//         $offering->lockedplo = 1;
//         $offering->save();

//         StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
//         StudentPloAttainment::where('courseoffer_id', $id)->delete();

//         $this->calculateAndStorePloAttainmentComplete($id);

//         DB::commit();

//         return redirect()->back()->with('success', 'Assessment locked and PLO calculated');

//     } catch (\Exception $e) {
//         DB::rollBack();
//         throw $e;
//     }
// }

        public function lockAssessmentPLO($id)
        {
            CourseOffer::whereId($id)->update(['lockedplo' => 1]);
            StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
            StudentPloAttainment::where('courseoffer_id', $id)->delete();
            $this->calculateAndStorePloAttainmentComplete($id);

            return redirect()->back()->with('success', 'Assessment locked & PLO calculated');
        }

        public function calculateAndStorePloAttainmentComplete($id)
        {
            ini_set('max_execution_time', 300);
            set_time_limit(300);

            DB::transaction(function () use ($id) {

                /* ================= BASIC DATA ================= */
                $course      = CourseOffer::select('course_id')->findOrFail($id);
                $course_id   = $course->course_id;

                $students = EnrollStudent::with('student:id')
                    ->where('course_section_id', $id)
                    ->get()
                    ->pluck('student.id');

                if ($students->isEmpty()) return;

                /* ================= DELETE OLD DATA ================= */
                StudentQuestionPloAttainment::where('courseoffer_id', $id)->delete();
                StudentPloAttainment::where('courseoffer_id', $id)->delete();

                /* ================= PRELOAD DATA ================= */
                $clos = StudentAssessment::where('courseoffer_id', $id)
                    ->distinct()
                    ->pluck('clo_id');

                $ploClos = CourseOfferPlo::where('course_id', $course_id)
                    ->whereIn('clo_id', $clos)
                    ->get()
                    ->groupBy('plo_id');

                $questions = ActivityQuestion::where('courseoffer_id', $id)->get();
                $cqiQuestions = CqiActivityQuestion::where('courseoffer_id', $id)->get();

                $studentAssessments = StudentAssessment::where('courseoffer_id', $id)->get()
                    ->keyBy(fn($r) => "{$r->student_id}_{$r->clo_id}_{$r->question_id}_{$r->activity_id}");

                $cqiAssessments = CqiStudentAssessment::where('courseoffer_id', $id)->get()
                    ->keyBy(fn($r) => "{$r->student_id}_{$r->clo_id}_{$r->cqi_question_id}_{$r->cqi_activity_id}");

                /* ================= QUESTION → PLO ================= */
                $questionRows = [];

                foreach ($students as $student_id) {
                    foreach ($ploClos as $plo_id => $cloSet) {

                        foreach ($cloSet as $clo) {

                            /* ----- Normal Questions ----- */
                            foreach ($questions->where('clo_id', $clo->clo_id) as $q) {

                                $key = "{$student_id}_{$clo->clo_id}_{$q->id}_{$q->activity_id}";
                                $outcome = $studentAssessments[$key]->outcome ?? 0;

                                $max = $q->max_mark ?: 1;
                                $w   = $q->obe_weight ?: 0;
                                $pct = ($outcome / $max) * $w;

                                $questionRows[] = [
                                    'student_id'     => $student_id,
                                    'plo_id'         => $plo_id,
                                    'clo_id'         => $clo->clo_id,
                                    'courseoffer_id' => $id,
                                    'question_id' => $q->id,
                                    'activity_id' => $q->activity_id,
                                    'cqi_question_id' => null,
                                    'cqi_activity_id' => null,
                                    'obtained_marks' => $outcome,
                                    'max_marks'      => $max,
                                    'obe_weight'     => $w,
                                    'percentage'     => $pct,
                                    'achieved_flag'  => $pct >= 50 ? 'Y' : 'N',
                                    'question_flag'  => 1,
                                ];
                            }

                            /* ----- CQI Questions ----- */
                            foreach ($cqiQuestions->where('clo_id', $clo->clo_id) as $cq) {

                                $key = "{$student_id}_{$clo->clo_id}_{$cq->id}_{$cq->cqi_activity_id}";
                                if (!isset($cqiAssessments[$key])) continue;

                                $outcome = $cqiAssessments[$key]->outcome ?? 0;
                                $max = $cq->max_mark ?: 1;
                                $w   = $cq->obe_weight ?: 0;
                                $pct = ($outcome / $max) * $w;

                                $questionRows[] = [
                                    'student_id'      => $student_id,
                                    'plo_id'          => $plo_id,
                                    'clo_id'          => $clo->clo_id,
                                    'courseoffer_id'  => $id,
                                   'question_id' => null,
                                    'activity_id' => null,
                                    'cqi_question_id' => $cq->id,
                                    'cqi_activity_id' => $cq->cqi_activity_id,
                                    'obtained_marks'  => $outcome,
                                    'max_marks'       => $max,
                                    'obe_weight'      => $w,
                                    'percentage'      => $pct,
                                    'achieved_flag'   => $pct >= 50 ? 'Y' : 'N',
                                    'question_flag'   => 2,
                                ];
                            }
                        }
                    }
                }

                /* ================= BULK INSERT ================= */
                collect($questionRows)->chunk(1000)->each(function ($chunk) {
                    StudentQuestionPloAttainment::insert($chunk->toArray());
                });

                /* ================= FINAL PLO ================= */
                $final = StudentQuestionPloAttainment::select(
                        'student_id',
                        'plo_id',
                        DB::raw('SUM(percentage) as total_pct'),
                        DB::raw('SUM(obe_weight) as total_w')
                    )
                    ->where('courseoffer_id', $id)
                    ->groupBy('student_id', 'plo_id')
                    ->get();

                $finalRows = [];

                foreach ($final as $f) {
                    $weighted = $f->total_w > 0 ? ($f->total_pct / $f->total_w) * 100 : 0;

                    $finalRows[] = [
                        'student_id'     => $f->student_id,
                        'plo_id'         => $f->plo_id,
                        'courseoffer_id' => $id,
                        'weighted_total' => $weighted,
                        'achieved_flag'  => $weighted >= 50 ? 'Y' : 'N',
                    ];
                }

                StudentPloAttainment::insert($finalRows);
            });
        }

        public function calculateAndStoreQuestionAndCloAttainment($id)
        {
            ini_set('max_execution_time', 300);
            set_time_limit(300);

            DB::transaction(function () use ($id) {

                /* ================= BASIC DATA ================= */
                $students = EnrollStudent::with('student:id')
                    ->where('course_section_id', $id)
                    ->get()
                    ->pluck('student.id');

                if ($students->isEmpty()) return;

                /* ================= CLEAN OLD DATA ================= */
                StudentQuestionAttainment::where('courseoffer_id', $id)->delete();
                StudentCloAttainment::where('courseoffer_id', $id)->delete();

                /* ================= PRELOAD DATA ================= */
                $clos = StudentAssessment::where('courseoffer_id', $id)
                    ->whereNotNull('clo_id')
                    ->distinct()
                    ->pluck('clo_id');

                $questions = ActivityQuestion::where('courseoffer_id', $id)->get();
                $cqiQuestions = CqiActivityQuestion::where('courseoffer_id', $id)->get();

                $assessments = StudentAssessment::where('courseoffer_id', $id)->get()
                    ->keyBy(fn($r) => "{$r->student_id}_{$r->clo_id}_{$r->question_id}_{$r->activity_id}");

                $cqiAssessments = CqiStudentAssessment::where('courseoffer_id', $id)->get()
                    ->keyBy(fn($r) => "{$r->student_id}_{$r->clo_id}_{$r->cqi_question_id}_{$r->cqi_activity_id}");

                /* ================= QUESTION ATTAINMENT ================= */
                $questionRows = [];

                foreach ($students as $student_id) {
                    foreach ($clos as $clo_id) {

                        /* ----- Normal Questions ----- */
                        foreach ($questions->where('clo_id', $clo_id) as $q) {

                            $key = "{$student_id}_{$clo_id}_{$q->id}_{$q->activity_id}";
                            $obtained = $assessments[$key]->outcome ?? 0;

                            $max = $q->max_mark ?: 1;
                            $w   = $q->obe_weight ?: 0;
                            $pct = ($obtained / $max) * $w;

                            $questionRows[] = [
                                'student_id'     => $student_id,
                                'clo_id'         => $clo_id,
                                'courseoffer_id' => $id,
                                
                                'question_id' => $q->id,
                                'activity_id' => $q->activity_id,
                                'cqi_question_id' => null,
                                'cqi_activity_id' => null,
                                'obtained_marks' => $obtained,
                                'max_marks'      => $max,
                                'obe_weight'     => $w,
                                'percentage'     => $pct,
                                'achieved_flag'  => $pct >= 50 ? 'Y' : 'N',
                                'question_flag'  => 1,
                            ];
                        }

                        /* ----- CQI Questions ----- */
                        foreach ($cqiQuestions->where('clo_id', $clo_id) as $cq) {

                            $key = "{$student_id}_{$clo_id}_{$cq->id}_{$cq->cqi_activity_id}";
                            if (!isset($cqiAssessments[$key])) continue;

                            $obtained = $cqiAssessments[$key]->outcome ?? 0;
                            $max = $cq->max_mark ?: 1;
                            $w   = $cq->obe_weight ?: 0;
                            $pct = ($obtained / $max) * $w;

                            $questionRows[] = [
                                'student_id'      => $student_id,
                                'clo_id'          => $clo_id,
                                'courseoffer_id'  => $id,
                                'question_id' => null,
    'activity_id' => null,
    'cqi_question_id' => $cq->id,
    'cqi_activity_id' => $cq->cqi_activity_id,

                                'obtained_marks'  => $obtained,
                                'max_marks'       => $max,
                                'obe_weight'      => $w,
                                'percentage'      => $pct,
                                'achieved_flag'   => $pct >= 50 ? 'Y' : 'N',
                                'question_flag'   => 2,
                            ];
                        }
                    }
                }

                /* ================= BULK INSERT QUESTIONS ================= */
                collect($questionRows)->chunk(1000)->each(function ($chunk) {
                    StudentQuestionAttainment::insert($chunk->toArray());
                });

                /* ================= CLO ATTAINMENT ================= */
                $cloResults = StudentQuestionAttainment::select(
                        'student_id',
                        'clo_id',
                        DB::raw('SUM(percentage) as total_pct'),
                        DB::raw('SUM(obe_weight) as total_w')
                    )
                    ->where('courseoffer_id', $id)
                    ->groupBy('student_id', 'clo_id')
                    ->get();

                $cloRows = [];

                foreach ($cloResults as $r) {
                    $weighted = $r->total_w > 0 ? ($r->total_pct / $r->total_w) * 100 : 0;

                    $cloRows[] = [
                        'student_id'     => $r->student_id,
                        'clo_id'         => $r->clo_id,
                        'courseoffer_id' => $id,
                        'weighted_total' => $weighted,
                        'achieved_flag'  => $weighted >= 50 ? 'Y' : 'N',
                    ];
                }

                StudentCloAttainment::insert($cloRows);
            });
        }

        public function calculateAndStoreQuestionAttainment($id)
        {
            $enrolledStudents = EnrollStudent::with('student')
                ->where('course_section_id', $id)
                ->get();

            $clos = StudentAssessment::select('clo_id')
                ->where('courseoffer_id', $id)
                ->whereNotNull('clo_id')
                ->groupBy('clo_id')
                ->get();

            foreach ($enrolledStudents as $student) {
                foreach ($clos as $clo) {
                    // ============= NORMAL ACTIVITIES =============
                    $questions = ActivityQuestion::where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    foreach ($questions as $q) {
                        $outcome = StudentAssessment::where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('question_id', $q->id)
                            ->where('activity_id', $q->activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();

                        $obtained   = $outcome->outcome ?? 0;
                        $maxMark    = $q->max_mark ?? 1;
                        $w          = $q->obe_weight ?? 0;
                        $percentage = $maxMark > 0 ? ($obtained / $maxMark) * $w : 0;
                        $flagQ      = $percentage >= 50 ? 'Y' : 'N';

                        StudentQuestionAttainment::create([
                            'student_id'     => $student->student->id,
                            'clo_id'         => $clo->clo_id,
                            'courseoffer_id' => $id,
                            'question_id'    => $q->id,
                            'activity_id'    => $q->activity_id,
                            'obtained_marks' => $obtained,
                            'max_marks'      => $maxMark,
                            'obe_weight'     => $w,
                            'percentage'     => $percentage,
                            'achieved_flag'  => $flagQ,
                            'question_flag'  => 1
                        ]);
                    }

                    // ============= CQI ACTIVITIES =============
                    // ============= CQI ACTIVITIES =============
                    $cqiquestions = CqiActivityQuestion::where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    foreach ($cqiquestions as $cq) {
                        $cqioutcome = CqiStudentAssessment::where('clo_id', $clo->clo_id)
                            ->where('student_id', $student->student->id)
                            ->where('cqi_question_id', $cq->id)
                            ->where('cqi_activity_id', $cq->cqi_activity_id)
                            ->where('courseoffer_id', $id)
                            ->first();

                        // ✅ Insert only if student has entry in CqiStudentAssessment
                        if ($cqioutcome) {
                            $obtained   = $cqioutcome->outcome ?? 0;
                            $maxMark    = $cq->max_mark ?? 1;
                            $w          = $cq->obe_weight ?? 0;
                            $percentage = $maxMark > 0 ? ($obtained / $maxMark) * $w : 0;
                            $flagQ      = $percentage >= 50 ? 'Y' : 'N';

                            StudentQuestionAttainment::create([
                                'student_id'       => $student->student->id,
                                'clo_id'           => $clo->clo_id,
                                'courseoffer_id'   => $id,
                                'cqi_question_id'  => $cq->id,
                                'cqi_activity_id'  => $cq->cqi_activity_id,
                                'obtained_marks'   => $obtained,
                                'max_marks'        => $maxMark,
                                'obe_weight'       => $w,
                                'percentage'       => $percentage,
                                'achieved_flag'    => $flagQ,
                                'question_flag'    => 2
                            ]);
                        }
                    }

                }
            }
        }

        public function calculateAndStoreCloAttainment($id)
        {
            $enrolledStudents = EnrollStudent::with('student')
                ->where('course_section_id', $id)
                ->get();

            foreach ($enrolledStudents as $student) {
                $clos = StudentQuestionAttainment::select('clo_id')
                    ->where('courseoffer_id', $id)
                    ->where('student_id', $student->student->id)
                    ->groupBy('clo_id')
                    ->get();

                foreach ($clos as $clo) {
                    $records = StudentQuestionAttainment::where('student_id', $student->student->id)
                        ->where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->get();

                    $totalWeighted = 0;
                    $totalWeight   = 0;

                    foreach ($records as $rec) {
                        $totalWeighted += ($rec->percentage);  // already includes weight effect
                        $totalWeight   += $rec->obe_weight ?? 0;
                    }

                    // Avoid division by zero
                    $weightedTotal = $totalWeight > 0 ? ($totalWeighted / $totalWeight) * 100 : 0;
                    $flag          = $weightedTotal >= 50 ? 'Y' : 'N';

                    StudentCloAttainment::updateOrCreate(
                        [
                            'student_id'     => $student->student->id,
                            'clo_id'         => $clo->clo_id,
                            'courseoffer_id' => $id,
                        ],
                        [
                            'weighted_total' => $weightedTotal,
                            'achieved_flag'  => $flag,
                        ]
                    );
                }
            }

            // return back()->with('success', 'CLO Attainment Calculated from Question Records Successfully!');
        }

        public function calculateAndStorePloQuestionAttainment($id)
        {
            $course = CourseOffer::select('course_id')->whereId($id)->first();
            $course_id = $course->course_id;

            $enrolledStudents = EnrollStudent::with('student')
                ->where('course_section_id', $id)
                ->get();

            $clos = StudentAssessment::where('courseoffer_id', $id)
                ->distinct('clo_id')
                ->pluck('clo_id');

            $plos = CourseOfferPlo::select('plo_id')
                ->where('course_section_id', $id)
                ->whereIn('clo_id', $clos)
                ->groupBy('plo_id')
                ->get();

            foreach ($enrolledStudents as $student) {
                foreach ($plos as $plo) {
                    // CLOs mapped with this PLO
                    $clo_usedinplo = CourseOfferPlo::select('clo_id')
                        ->where('course_id', $course_id)
                        ->where('plo_id', $plo->plo_id)
                        ->groupBy('clo_id')
                        ->get();

                    foreach ($clo_usedinplo as $clo) {
                        // ========== NORMAL QUESTIONS ==========
                        $questions = ActivityQuestion::where('courseoffer_id', $id)
                            ->where('clo_id', $clo->clo_id)
                            ->get();

                        foreach ($questions as $q) {
                            $outcome = StudentAssessment::where('clo_id', $clo->clo_id)
                                ->where('student_id', $student->student->id)
                                ->where('question_id', $q->id)
                                ->where('activity_id', $q->activity_id)
                                ->where('courseoffer_id', $id)
                                ->first();

                            $obtained   = $outcome->outcome ?? 0;
                            $maxMark    = $q->max_mark ?? 1;
                            $w          = $q->obe_weight ?? 0;
                            $percentage = $maxMark > 0 ? ($obtained / $maxMark) * $w : 0;
                            $flagQ      = $percentage >= 50 ? 'Y' : 'N';

                            StudentQuestionPloAttainment::create([
                                'student_id'     => $student->student->id,
                                'plo_id'         => $plo->plo_id,
                                'clo_id'         => $clo->clo_id,
                                'courseoffer_id' => $id,
                                'question_id'    => $q->id,
                                'activity_id'    => $q->activity_id,
                                'cqi_question_id'=> null,
                                'cqi_activity_id'=> null,
                                'obtained_marks' => $obtained,
                                'max_marks'      => $maxMark,
                                'obe_weight'     => $w,
                                'percentage'     => $percentage,
                                'achieved_flag'  => $flagQ,
                                'question_flag'  => 1 // normal question
                            ]);
                        }

                        // ========== CQI QUESTIONS ==========
                        $cqiquestions = CqiActivityQuestion::where('courseoffer_id', $id)
                            ->where('clo_id', $clo->clo_id)
                            ->get();

                        foreach ($cqiquestions as $cq) {
                            $cqioutcome = CqiStudentAssessment::where('clo_id', $clo->clo_id)
                                ->where('student_id', $student->student->id)
                                ->where('cqi_question_id', $cq->id)
                                ->where('cqi_activity_id', $cq->cqi_activity_id)
                                ->where('courseoffer_id', $id)
                                ->first();

                            // 👉 skip if student has no record for this CQI question
                            if (!$cqioutcome) {
                                continue;
                            }

                            $obtained   = $cqioutcome->outcome ?? 0;
                            $maxMark    = $cq->max_mark ?? 1;
                            $w          = $cq->obe_weight ?? 0;
                            $percentage = $maxMark > 0 ? ($obtained / $maxMark) * $w : 0;
                            $flagQ      = $percentage >= 50 ? 'Y' : 'N';

                            StudentQuestionPloAttainment::create([
                                'student_id'       => $student->student->id,
                                'plo_id'           => $plo->plo_id,
                                'clo_id'           => $clo->clo_id,
                                'courseoffer_id'   => $id,
                                'question_id'      => null,
                                'activity_id'      => null,
                                'cqi_question_id'  => $cq->id,
                                'cqi_activity_id'  => $cq->cqi_activity_id,
                                'obtained_marks'   => $obtained,
                                'max_marks'        => $maxMark,
                                'obe_weight'       => $w,
                                'percentage'       => $percentage,
                                'achieved_flag'    => $flagQ,
                                'question_flag'    => 2 // CQI question
                            ]);
                        }
                    }
                }
            }

            // return response()->json([
            //     'status'  => 'success',
            //     'message' => 'Student Question-PLO attainments calculated & saved successfully.'
            // ]);
        }

        public function calculateAndStorePloAttainment($id)
        {
            $enrolledStudents = EnrollStudent::with('student')
                ->where('course_section_id', $id)
                ->get();

            foreach ($enrolledStudents as $student) {
                // All distinct PLOs from question-level attainments

               
                 
                $plos = StudentQuestionPloAttainment::select('plo_id')
                    ->where('courseoffer_id', $id)
                    ->where('student_id', $student->student->id)
                    ->groupBy('plo_id')
                    ->get();

                foreach ($plos as $plo) {
                   
                    $records = StudentQuestionPloAttainment::where('student_id', $student->student->id)
                        ->where('courseoffer_id', $id)
                        ->where('plo_id', $plo->plo_id)
                        ->get();


                    $totalWeighted = 0;
                    $totalWeight   = 0;

                    foreach ($records as $rec) {
                        $totalWeighted += ($rec->percentage);  // already weighted value
                        $totalWeight   += $rec->obe_weight ?? 0;
                    }

                    // Avoid division by zero
                    $weightedTotal = $totalWeight > 0 ? ($totalWeighted / $totalWeight) * 100 : 0;
                    $flag          = $weightedTotal >= 50 ? 'Y' : 'N';

                    StudentPloAttainment::updateOrCreate(
                        [
                            'student_id'     => $student->student->id,
                            'plo_id'         => $plo->plo_id,
                            'courseoffer_id' => $id,
                        ],
                        [
                            'weighted_total' => $weightedTotal,
                            'achieved_flag'  => $flag,
                        ]
                    );
                }
            }

            // return back()->with('success', 'PLO Attainment Calculated from Question Records Successfully!');
        }

        public function showeCloAttainmentnew($id)
        {
            ini_set('memory_limit', '256M');
            // init
            $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
            // $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->take(5)->get();
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
            $StudentQuestionAttainment = new StudentQuestionAttainment();
            $StudentCloAttainment = new StudentCloAttainment();

            $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
            // return view('courseoffering.cloattainment.backup',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo'));
            return view('courseoffering.cloattainment.backup',compact('id','cqiactivityquestion','cqistudentassessment','clos','activityquestion','enrolledstudent','studentassessment','assesment','course_offering','courseofferclo','StudentCloAttainment','StudentQuestionAttainment'));
        }
        
        public function showePloAttainmentnew($id)
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
            $StudentQuestionPloAttainment = new StudentQuestionPloAttainment();
            $StudentPloAttainment = new StudentPloAttainment();
            $courseofferclo = new CourseOfferClo();
            $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

            return view('courseoffering.ploattainment.backup',compact('id','course_id','cqiactivityquestion','cqistudentassessment','plos','activityquestion','enrolledstudent','studentassessment','assesment','plo','ploObject','plobycoursesectionclo','course_offering','courseofferclo','StudentQuestionPloAttainment','StudentPloAttainment'));

        }
}
