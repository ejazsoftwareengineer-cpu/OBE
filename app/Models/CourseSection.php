<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;
 /**
     * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'institute_id',
        'course_id',
        'name',
        'section',
        'mark_per',
        'student_per',
        'status',
        'semester_id',
        'teacher_id',
        'course_status',
        'gender',
        'available_seats',
        'description',
        'office_hours',
        'created_by',
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

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
       
    public function semester(){
        return $this->belongsTo(ProgramBatch::class,'semester_id');
    }
       
    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }
    
}
