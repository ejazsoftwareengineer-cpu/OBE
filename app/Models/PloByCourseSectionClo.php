<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloByCourseSectionClo extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clo_id',
        'course_id',
        'course_section_id',
        'program_id',
        'domain',
        'emphasis_level',
        'plo_id',
        'level',
        'created_by',
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
    public function plo(){
        return $this->belongsTo(PLO::class,'plo_id','id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function coursesection(){
        return $this->belongsTo(CourseSection::class,'course_section_id','id');
    }
    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }
}
