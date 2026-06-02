<?php 
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EnrollStudent;
use App\Models\CourseOfferClo;
use App\Models\ActivityQuestion; 

class AssessmentMarksTemplateExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    protected $id;
    protected $clos;
    protected $questions;

    public function __construct($id)
    {
        $this->id = $id;
        $this->clos = CourseOfferClo::where('courseoffer_id', $id)->get();
        $this->questions = ActivityQuestion::with('classActivity')
            ->where('courseoffer_id', $id)
            ->get()
            ->groupBy('clo_id');
    }

    public function collection()
    {
        return EnrollStudent::select('enroll_students.*')
            ->join('students', 'students.id', '=', 'enroll_students.student_id')
            ->where('enroll_students.course_section_id', $this->id)
            ->orderBy('students.registration_no', 'asc')
            ->with('student') // optionally still load the relation
            ->get();
    }

    public function headings(): array
    {
        $baseHeadings = ['Registration No.', 'Name'];

        foreach ($this->clos as $clo) {
            if (isset($this->questions[$clo->id])) {
                foreach ($this->questions[$clo->id] as $index => $question) {
                    $activityName = $question->classActivity->assesment_name ?? 'Unknown Activity';
                    $questionName = $question->question_name ?? 'Unknown Question';
                    $activityId = $question->id;
                    $cloId = $clo->id;
                    $baseHeadings[] = "(Activity ID: {$activityId}) (CLO ID: {$cloId}) {$clo->code} - {$activityName} (" . $questionName . ") (Total Mark :: " . $question->max_mark . ")";
                }
            }
        }

        return $baseHeadings;
    }

    public function map($row): array
    {
        $studentData = [
            $row->student->registration_no,
            $row->student->name,
        ];

        $marks = [];
        foreach ($this->clos as $clo) {
            if (isset($this->questions[$clo->id])) {
                foreach ($this->questions[$clo->id] as $question) {
                    $marks[] = ''; 
                }
            }
        }

        return array_merge($studentData, $marks);
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->freezePane('A2');

                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
                    ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
                    ->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                $sheet->getProtection()->setSheet(true);

                foreach (range('A', $sheet->getHighestColumn()) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
