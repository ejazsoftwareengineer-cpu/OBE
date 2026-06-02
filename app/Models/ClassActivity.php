<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivity extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'assesment_id',
        'clo_id',
        'course_id',
        'course_section_id',
        'assesment_name',
        'assesment_date',
        'assesment_total_mark',
        'assesment_gpa_weight',
        'complex_engineering_problem',
        'gpa_calculation',
        'created_by'
    ];
    
    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
    
    public function assesment(){
        return $this->belongsTo(Assesment::class,'assesment_id','id');
    }
    
    public function activityQuestions()
    {
        return $this->hasMany(ActivityQuestion::class, 'activity_id');
    }

}
