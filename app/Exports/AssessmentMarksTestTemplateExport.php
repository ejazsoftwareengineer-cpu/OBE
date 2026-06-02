<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\EnrollStudent;
use App\Models\CourseOffer;
use App\Models\CourseOfferClo;
use App\Models\StudentQuestionAttainment;
use App\Models\StudentCloAttainment;
use App\Models\StudentAssessment;
use App\Models\StudentAssessmentTest;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Models\ActivityQuestion;
class AssessmentMarksTestTemplateExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $id;
    protected $clos;
    protected $questions;
    
    public function __construct($id)
    {
        //dd($clos);
        $this->id = $id;
        // dd($this->id);
        // $this->clos = CourseOfferClo::where('courseoffer_id', $id)->get();
        $this->clos = CourseOfferClo::whereIn('id', function ($query) use ($id) {
    $query->selectRaw('DISTINCT clo_id')
          ->from('activity_questions')
          ->where('courseoffer_id', $id);
})->get();

// echo "<pre>";
// print_r($this->clos->toArray());
// die();

        // dd($this->clos);
        $this->questions = ActivityQuestion::with('classActivity')
            ->where('courseoffer_id', $id)
            ->get()
            ->groupBy('clo_id'); 
    }

    public function view(): View
    {
        
        $id = $this->id;
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($this->id)->latest()->first();
        // dd($course_offering);
        // Fetch CLOs from CourseOfferClo for this course offer
        // $clos = CourseOfferClo::select('id as clo_id', 'code')
        //     ->where('courseoffer_id', $this->id)
        //     ->get();

        $clos = CourseOfferClo::select('id as clo_id', 'code')->whereIn('id', function ($query) use ($id) {
            $query->selectRaw('DISTINCT clo_id')
                ->from('activity_questions')
                ->where('courseoffer_id',  $this->id);
        })->get();

        $enrolledstudent = EnrollStudent::with(['student','course_section'])
    ->join('students', 'students.id', '=', 'enroll_students.student_id')
    ->where('enroll_students.course_section_id', $this->id)
    ->orderBy('students.registration_no', 'asc')
    ->select('enroll_students.*')
    ->get();
        // dd($enrolledstudent);
        // Fetch existing marks for pre-populating the template
        $standard_assessments = StudentAssessment::where('courseoffer_id', $this->id)
            ->get()
            ->groupBy(['student_id', 'question_id', 'clo_id']);


            
        // dd($standard_assessments);
        return view('exports.clo_report', [
            'id' => $this->id,
            'course_offering' => $course_offering,
            'clos' => $clos,
            'enrolledstudent' => $enrolledstudent,
            'standard_assessments' => $standard_assessments,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Enable sheet protection
                $sheet->getProtection()->setSheet(true);
                $sheet->getProtection()->setPassword('obe_template');

                // Determine the range of cells to unlock (the marks input area)
                // We need to know how many students and how mantions
                $enrolledstudent_count = EnrollStudent::wherecourse_section_id($this->id)->count();
                
                // $clos = StudentAssessment::select('clo_id')
                //     ->where('courseoffer_id', $this->id)
                //     ->whereNotNull('clo_id')
                //     ->orderBy('clo_id')
                //     ->groupBy('clo_id')
                //     ->get();
                $clos = CourseOfferClo::select('id')->wherecourseoffer_id($this->id)->get();

                $total_question_columns = 0;
                foreach($clos as $clo) {
                    $q_count = ActivityQuestion::where('courseoffer_id', $this->id)
                        ->where('clo_id', $clo->id)
                        ->select('question_id','cqi_question_id')
                        ->distinct()
                        ->count();
                    $total_question_columns += $q_count; 
                }

                // Headers are 12 rows
                $header_rows = 12; 
                $start_row = $header_rows + 1;
                $end_row = $header_rows + $enrolledstudent_count;

                // Starting from Column C (3rd column)
                $current_col = 3;
                foreach($clos as $clo) {
                     $q_count = \App\Models\ActivityQuestion::where('courseoffer_id', $this->id)
                        ->where('clo_id', $clo->id)
                        ->select('question_id','cqi_question_id')
                        ->distinct()
                        ->count();
                     
                     if ($q_count > 0) {
                        $start_col_letter = Coordinate::stringFromColumnIndex($current_col);
                        $end_col_letter = Coordinate::stringFromColumnIndex($current_col + $q_count - 1);
                        
                        $range = $start_col_letter . $start_row . ':' . $end_col_letter . $end_row;
                        $sheet->getStyle($range)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
                        
                        $current_col += $q_count; // move to next CLO block
                     }
                }
                
                // Hide metadata rows as requested
                $sheet->getRowDimension(4)->setVisible(false);
                $sheet->getRowDimension(5)->setVisible(false);
                $sheet->getRowDimension(6)->setVisible(false);
            },
        ];
    }
}