<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CqiStudentAssessment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'clo_id',
        'cqi_activity_id',
        'cqi_question_id',
        'student_id',
        'courseoffer_id',
        'outcome',
    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [];
    
    public function clo(){
        return $this->belongsTo(CLO::class,'clo_id','id');
    }
    public function activity(){
        return $this->belongsTo(CqiClassActivity::class,'cqi_activity_id','id');
    }
    public function question(){
        return $this->belongsTo(CqiivityQuestion::class,'cqi_activity_id','id');
    }  
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function courseoffer(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }
}
