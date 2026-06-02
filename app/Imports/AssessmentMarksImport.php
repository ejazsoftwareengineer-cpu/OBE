<?php


namespace App\Imports;

use App\Models\EnrollStudent;
use App\Models\ActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AssessmentMarksImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $courseOfferId;
    protected $students;
    protected $questions;
    protected $existing;

    public function __construct($courseOfferId)
    {
        $this->courseOfferId = $courseOfferId;

        // Preload Students (registration_no → id)
        $this->students = Student::pluck('id', 'registration_no');

        // Preload Questions (id → model)
        $this->questions = ActivityQuestion::select('id','activity_id','max_mark')->get()->keyBy('id');

        // Preload Existing Assessments
        $this->existing = StudentAssessment::where('courseoffer_id', $courseOfferId)
            ->get()
            ->keyBy(function ($record) {
                return $record->student_id . '-' . $record->question_id . '-' . $record->clo_id;
            });
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $reg = $row['registration_no'];
            $studentId = $this->students[$reg] ?? null;

            if (!$studentId) {
                continue;
            }

            foreach ($row->except(['registration_no', 'name']) as $key => $value) {

                preg_match('/activity_id_(\d+)_clo_id_(\d+)/', $key, $matches);

                if (!$matches) continue;

                $questionId = $matches[1];
                $cloId      = $matches[2];

                if (!isset($this->questions[$questionId])) continue;

                $question = $this->questions[$questionId];

                if ($value === null || $value === "") continue;

                if ((float) $value > (float) $question->max_mark) continue;

                $mapKey = $studentId . '-' . $questionId . '-' . $cloId;

                if (isset($this->existing[$mapKey])) {
                    // Update existing
                    $this->existing[$mapKey]->update([
                        'outcome' => $value
                    ]);
                } else {
                    // Insert new
                    StudentAssessment::create([
                        'clo_id'        => $cloId,
                        'activity_id'   => $question->activity_id,
                        'question_id'   => $questionId,
                        'student_id'    => $studentId,
                        'courseoffer_id'=> $this->courseOfferId,
                        'outcome'       => $value,
                    ]);
                }
            }
        }
    }

    // ========== CHUNK SIZE ==========
    public function chunkSize(): int
    {
        return 500; // Prevents timeouts
    }
}

// namespace App\Imports;

// use App\Models\EnrollStudent;
// use App\Models\ActivityQuestion;
// use App\Models\StudentAssessment;
// use App\Models\Student;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class AssessmentMarksImport implements ToCollection, WithHeadingRow
// {
//     protected $courseOfferId;

//     public function __construct($courseOfferId)
//     {
//         $this->courseOfferId = $courseOfferId;
//     }
//     public function collection(Collection $rows)
//     {
//         foreach ($rows as $row) {

//         //      echo "<pre>";
//         // print_r($row);
//         // die();
//             $studentId = $row['registration_no'];
//             $studentName = $row['name'];
    
//             // Fetch the student ID based on registration number
//             $student = Student::select('id')->where('registration_no', $studentId)->first();
//             if (!$student) {
//                 continue; // Skip if student is not found
//             }
    
//             $student_id = $student->id;
    
//             foreach ($row->except(['registration_no', 'name']) as $key => $value) {
//                 preg_match('/activity_id_(\d+)_clo_id_(\d+)/', $key, $matches);
    
//                 if (!empty($matches)) {
//                     $question_id = $matches[1];
//                     $cloId = $matches[2];
    
//                     $question = ActivityQuestion::select('id', 'activity_id', 'max_mark')
//                         ->where('id', $question_id)
//                         ->first();
    
//                     if (!$question) {
//                         continue; // Skip if question is not found
//                     }
    
//                     $activity_id = $question->activity_id;
    
//                     // Only proceed with update or insert if $value is not null
//                     if ($value !== null) {
//                         // Ensure value does not exceed max_mark
//                         if ((float) $value > (float) $question->max_mark) {
//                             continue; // Skip if value exceeds max mark
//                         }
    
//                         $assessment = StudentAssessment::where([
//                             ['clo_id', $cloId],
//                             ['activity_id', $activity_id],
//                             ['question_id', $question_id],
//                             ['student_id', $student_id],
//                             ['courseoffer_id', $this->courseOfferId]
//                         ])->first();
    
//         //                 echo "<pre>";
//         // print_r($assessment);
//         // die();
//                         if ($assessment) {
//                             // Update assessment outcome only if value is not null
//                             $assessment->update(['outcome' => $value]);
//                         } else {
//                             // Create new assessment if not found
//                             StudentAssessment::create([
//                                 'clo_id' => $cloId,
//                                 'activity_id' => $activity_id,
//                                 'question_id' => $question_id,
//                                 'student_id' => $student_id,
//                                 'courseoffer_id' => $this->courseOfferId,
//                                 'outcome' => $value,
//                             ]);
//                         }
//                     }
//                 }
//             }
//         }
//     }
    
// }
