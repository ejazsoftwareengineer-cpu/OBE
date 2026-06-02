<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollStudent extends Model
{
    use HasFactory;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'program_id',
        'student_id',
        'course_section_id',
        'remarks',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    
    protected $hidden = [];
    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    // public function course_section()
    // {
    //     return $this->belongsTo(CourseSection::class);
    // }
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function course_section(){
        return $this->belongsTo(CourseOffer::class,'course_section_id','id');
    }
}
