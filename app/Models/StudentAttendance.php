<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'student_id',
        'course_offer_id',
        'attendance',
        'mark_date',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [];
    
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function course_offer(){
        return $this->belongsTo(CourseOffer::class,'course_offer_id','id');
    }
    
    public function scopeWithAttendances($query, $date)
    {
        return $query->whereDate('mark_date', $date);
    }
}
