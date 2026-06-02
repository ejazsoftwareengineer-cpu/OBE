<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CqiClassActivity extends Model
{
    use HasFactory;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
        'cqi_id',
        'assesment_id',
        'course_offer_id',
        'assesment_name',
        'assesment_date',
        'assesment_total_mark',
        'assesment_gpa_weight',
        'complex_engineering_problem',
        'gpa_calculation',
        'created_by',
    ];
    
    public function assesment(){
        return $this->belongsTo(Assesment::class,'assesment_id','id');
    } 
    public function cqi(){
        return $this->belongsTo(Cqi::class,'cqi_id','id');
    } 
    public function course_offer(){
        return $this->belongsTo(CourseOffer::class,'course_offer_id','id');
    }
    
    public function activityQuestions()
    {
        return $this->hasMany(CqiActivityQuestion::class, 'cqi_activity_id');
    }
}
