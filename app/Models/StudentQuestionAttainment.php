<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuestionAttainment extends Model
{
    use HasFactory;

    protected $table = 'student_question_attainments';

    protected $fillable = [
        'student_id',
        'clo_id',
        'courseoffer_id',
        'question_id',
        'activity_id',
        'cqi_question_id',
        'cqi_activity_id',
        'obtained_marks',
        'max_marks',
        'obe_weight',
        'percentage',
        'achieved_flag',
        'question_flag',
    ];

    /* ================= RELATIONSHIPS ================= */

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function clo()
    {
        return $this->belongsTo(CLO::class, 'clo_id');
    }

    public function courseOffer()
    {
        return $this->belongsTo(CourseOffer::class, 'courseoffer_id');
    }

    public function question()
    {
        return $this->belongsTo(ActivityQuestion::class, 'question_id');
    }

    public function activity()
    {
        return $this->belongsTo(ClassActivity::class, 'activity_id');
    }

    public function cqiQuestion()
    {
        return $this->belongsTo(CqiActivityQuestion::class, 'cqi_question_id');
    }

    public function cqiActivity()
    {
        return $this->belongsTo(CqiClassActivity::class, 'cqi_activity_id');
    }
}
