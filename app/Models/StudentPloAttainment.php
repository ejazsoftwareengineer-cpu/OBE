<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPloAttainment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'plo_id',
        'clo_id',
        'courseoffer_id',
        'weighted_total',
        'achieved_flag',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function plo()
    {
        return $this->belongsTo(PLO::class, 'plo_id');
    }

    public function clo()
    {
        return $this->belongsTo(Clo::class, 'clo_id');
    }

    public function courseOffer()
    {
        return $this->belongsTo(CourseOffer::class, 'courseoffer_id');
    }
}
