<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\ActivityQuestion;
use App\Models\CqiActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\StudentAssessmentTest;
use App\Models\CqiStudentAssessment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class AssessmentMarksTestImport implements ToCollection
{
    protected $courseOfferId;
    protected $students;
    protected $questions;
    protected $existing;

    public function __construct($courseOfferId)
    {
        $this->courseOfferId = $courseOfferId;

        // Preload Students (registration_no → id) for faster lookup
        $this->students = Student::pluck('id', 'registration_no');

        // Preload Questions (id → model) for faster lookup
        $this->questions = ActivityQuestion::select('id', 'activity_id', 'max_mark')->get()->keyBy('id');

        // Preload Existing Assessments to minimize DB calls during the loop
        $this->existing = StudentAssessment::where('courseoffer_id', $courseOfferId)
            ->get()
            ->keyBy(function ($record) {
                return $record->student_id . '-' . $record->question_id . '-' . $record->clo_id;
            });
    }


 public function collection(Collection $rows)
{
    $activityIds = null;
    $questionIds = null;
    $cloIds      = null;
    $dataStartRow = 0;

    // 🔍 Detect metadata rows
    foreach ($rows as $index => $row) {
        $firstCell = strtolower(trim($row[0] ?? ''));

        if ($firstCell == 'activity id') {
            $activityIds = $row;
        } elseif ($firstCell == 'question id') {
            $questionIds = $row;
        } elseif ($firstCell == 'clo id') {
            $cloIds = $row;
        } elseif ($firstCell == 'registration no.') {
            $dataStartRow = $index + 1;
        }
    }

    if (!$activityIds || !$questionIds || !$cloIds) {
        throw new \Exception("Invalid file format.");
    }

    $dataRows = $rows->slice($dataStartRow);

    $insertData = [];

        foreach ($dataRows as $row) {

            $registrationNo = trim($row[0] ?? '');
            if (!$registrationNo) continue;

            $student_id = $this->students[$registrationNo] ?? null;
            if (!$student_id) continue;

            for ($colIndex = 2; $colIndex < count($row); $colIndex++) {

                $activityId = $activityIds[$colIndex] ?? null;
                $questionId = $questionIds[$colIndex] ?? null;
                $cloId      = $cloIds[$colIndex] ?? null;

                //   skip invalid columns
                if (!$activityId || !$questionId || !$cloId) continue;

                $outcomeStr = trim((string) ($row[$colIndex] ?? ''));
                if ($outcomeStr === '') continue;

                //   clean and round value
                $cleanOutcome = preg_replace('/[^0-9.]/', '', $outcomeStr);
                if (!is_numeric($cleanOutcome)) continue;

                $outcome = round((float)$cleanOutcome, 2);

                // ---------- NORMAL QUESTION ----------
                $q = $this->questions[$questionId] ?? null;

                if ($q) {
                    // Check if marks exceed max_marks
                    if ($outcome > (float)$q->max_mark) {
                        \Log::warning("Mark exceeded max_mark for Student: $registrationNo, Q_ID: $questionId. Mark: $outcome, Max: {$q->max_mark}");
                        continue;
                    }

                    //   Use updateOrCreate to reflect updates
                    $record = \App\Models\StudentAssessment::updateOrCreate([
                        'courseoffer_id' => $this->courseOfferId,
                        'student_id'     => $student_id,
                        'activity_id'    => $q->activity_id,
                        'question_id'    => $questionId,
                        'clo_id'         => $cloId,
                    ], [
                        'outcome'        => $outcome,
                    ]);

                    \Log::info("Imported Mark - Student: $registrationNo, Q_ID: $questionId, Outcome: $outcome");
                } 
                // ---------- CQI QUESTION (or other) ----------
                else {
                    // Logic for CQI can be added here
                }
            }
        }
    }

    // public function collection(Collection $rows)
    // {
    //     $activityIds = null;
    //     $questionIds = null;
    //     $cloIds      = null;
    //     $dataStartRow = 0;

    //     foreach ($rows as $index => $row) {
    //         $firstCell = strtolower(trim($row[0] ?? ''));

    //         if ($firstCell == 'activity id') {
    //             $activityIds = $row;
    //         } elseif ($firstCell == 'question id') {
    //             $questionIds = $row;
    //         } elseif ($firstCell == 'clo id') {
    //             $cloIds = $row;
    //         } elseif ($firstCell == 'registration no.') {
    //             $dataStartRow = $index + 1;
    //         }
    //     }

    //     // 🎯 Slice student rows
    //     $dataRows = $rows->slice($dataStartRow);

    //     $debugData = [];

    //     foreach ($dataRows as $rowIndex => $row) {

    //         $registrationNo = $row[0] ?? 'N/A';

    //         for ($colIndex = 2; $colIndex < count($row); $colIndex++) {

    //             $activityId = $activityIds[$colIndex] ?? null;
    //             $questionId = $questionIds[$colIndex] ?? null;
    //             $cloId      = $cloIds[$colIndex] ?? null;
    //             $marks      = $row[$colIndex] ?? null;

    //             // 🚫 Skip non-question columns
    //             if (!$activityId || !$questionId || !$cloId) {
    //                 continue;
    //             }

    //             // 🚫 Skip empty marks
    //             if ($marks === null || $marks === '') {
    //                 continue;
    //             }

    //             $debugData[] = [
    //                 'courseoffer_id' => $this->courseOfferId,
    //                 'row' => $rowIndex + 1,
    //                 'registration_no' => $registrationNo,
    //                 'activity_id' => $activityId,
    //                 'question_id' => $questionId,
    //                 'clo_id' => $cloId,
    //                 'marks' => $marks,
    //             ];
    //         }
    //     }

    //     dd($debugData);
    // }
    // public function collection(Collection $rows)
    // {
    //     $activityIds = null;
    //     $questionIds = null;
    //     $cloIds      = null;
    //     $dataStartRow = 0;

    //     foreach ($rows as $index => $row) {
    //         $firstCell = strtolower(trim($row[0] ?? ''));

    //         if ($firstCell == 'activity id') {
    //             $activityIds = $row;
    //         } elseif ($firstCell == 'question id') {
    //             $questionIds = $row;
    //         } elseif ($firstCell == 'clo id') {
    //             $cloIds = $row;
    //         } elseif ($firstCell == 'registration no.') {
    //             $dataStartRow = $index + 1;
    //         }
    //     }

    //     //   DEBUG HERE
    //     dd([
    //         'activity_ids' => $activityIds,
    //         'question_ids' => $questionIds,
    //         'clo_ids' => $cloIds,
    //         'data_start_row' => $dataStartRow

    //     ]);
        
    // }
    // public function collection(Collection $rows)
    // {
    //     $activityIds = null;
    //     $questionIds = null;
    //     $cloIds      = null;
    //     $dataStartRow = 0;

    //     // Dynamic detection of metadata and data start row
    //     // This makes the import resilient to row shifting (e.g. from title changes)
    //     foreach ($rows as $index => $row) {
    //         $firstCell = strtolower(trim($row[0] ?? ''));
            
    //         if ($firstCell == 'activity id') {
    //             $activityIds = $row;
    //         } elseif ($firstCell == 'question id') {
    //             $questionIds = $row;
    //         } elseif ($firstCell == 'clo id') {
    //             $cloIds = $row;
    //         } elseif ($firstCell == 'registration no.') {
    //             $dataStartRow = $index + 1; // Mark where student data starts
    //         }
    //     }

    //     // Basic validation of the file structure
    //     if (!$activityIds || !$questionIds || !$cloIds) {
    //         throw new \Exception("The uploaded file structure is invalid. Required metadata rows (Activity ID, Question ID, CLO ID) could not be located.");
    //     }

    //     // Slice the collection to start processing from student data
    //     $dataRows = $rows->slice($dataStartRow);

    //     foreach ($dataRows as $row) {
    //         $registrationNo = trim($row[0] ?? '');
    //         if (!$registrationNo) continue;

    //         $student_id = $this->students[$registrationNo] ?? null;
    //         if (!$student_id) continue;

    //         // Loop through columns starting from Column C (index 2)
    //         for ($colIndex = 2; $colIndex < count($row); $colIndex++) {
    //             $activityId = $activityIds[$colIndex] ?? null;
    //             $questionId = $questionIds[$colIndex] ?? null;
    //             $cloId      = $cloIds[$colIndex] ?? null;
    //             $outcome    = $row[$colIndex];

    //             // If any critical ID is missing for this column, skip it
    //             if ($activityId === null || $questionId === null || $cloId === null) continue;
                
    //             // If outcome is empty, skip this cell
    //             if ($outcome === null || $outcome === "") continue;

    //             // Handle outcomes assignment
    //             $q = $this->questions[$questionId] ?? null;
                
    //             if ($q) {
    //                 // Standard Assessment mapping
    //                 if ((float)$outcome > (float)$q->max_mark) continue;
                    
    //                 StudentAssessment::updateOrCreate([
    //                     'courseoffer_id' => $this->courseOfferId,
    //                     'student_id'     => $student_id,
    //                     'activity_id'    => $q->activity_id,
    //                     'question_id'    => $questionId,
    //                     'clo_id'         => $cloId,
    //                 ], [
    //                     'outcome'        => $outcome
    //                 ]);
    //             } else {
    //                 // Check if it belongs to CQI Assessment
    //                 $cq = CqiActivityQuestion::find($questionId);
    //                 if ($cq) {
    //                     if ((float)$outcome > (float)$cq->max_mark) continue;
                        
    //                     CqiStudentAssessment::updateOrCreate([
    //                         'courseoffer_id' => $this->courseOfferId,
    //                         'student_id'     => $student_id,
    //                         'cqi_activity_id'=> $activityId,
    //                         'cqi_question_id'=> $questionId,
    //                         'clo_id'         => $cloId,
    //                     ], [
    //                         'outcome'        => $outcome
    //                     ]);
    //                 }
    //             }
    //         }
    //     }
    // }
}
