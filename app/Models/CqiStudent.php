<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CqiStudent extends Model
{
    use HasFactory;
    /**
        * The attributes that are mass assignable.
       *
       * @var array<int, string>
       */
   
       protected $fillable = [
           'cqi_id',
           'courseoffer_id',
           'student_id',
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

    public function course_section(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }
}
