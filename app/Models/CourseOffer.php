<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOffer extends Model
{
    use HasFactory;
    
 /**
     * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'active_session_id',
        'institute_id',
        'program_id',
        'cirriculum_id',
        'semester',
        'course_id',
        'teacher_id',
        'status',
        'course_status',
        'gender',
        'name',
        'section',
        'mark_per',
        'student_per',
        'available_seats',
        'office_hours',
        'description',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [];
      
    public function institute(){
        return $this->belongsTo(Institute::class,'institute_id','id');
    }
    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }
    public function cirriculum(){
        return $this->belongsTo(Cirriculum::class,'cirriculum_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }  
    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }
    public function sesssion(){
        return $this->belongsTo(Sesssion::class,'active_session_id');
    }
}
