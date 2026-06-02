<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityQuestion extends Model
{
    use HasFactory;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
        'activity_id',
        'question_name',
        'name',
        'answer',
        'courseoffer_id',
        'clo_id',
        'complexity',
        'question',
        'max_mark',
        'obe_weight',
        'guidline',
        'choices',
        'not_for_obe',
        'created_by'
    ];

    public function classActivity()
    {
        return $this->belongsTo(ClassActivity::class, 'activity_id');
    }

    public function courseoffer(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }

    public function activityQuestionRubrics()
    {
        return $this->hasMany(ActivityQuestionRubric::class, 'question_id');
    }

    public function clo()
    {
        return $this->belongsTo(CourseOfferClo::class, 'clo_id');
    }

}
