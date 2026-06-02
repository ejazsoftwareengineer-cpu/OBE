<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCloAttainment extends Model
{
    use HasFactory;

    protected $table = 'student_clo_attainments';

    protected $fillable = [
        'student_id',
        'clo_id',
        'courseoffer_id',
        'weighted_total',
        'achieved_flag',
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
}
