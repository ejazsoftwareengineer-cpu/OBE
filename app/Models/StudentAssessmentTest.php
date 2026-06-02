<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssessmentTest extends Model
{

    protected $table = 'student_assessments_01_04_2026';
    use HasFactory;
    protected $fillable = [
        'courseoffer_id',
        'student_id',
        'activity_id',
        'question_id',
        'clo_id',
        'outcome',
    ];
}
