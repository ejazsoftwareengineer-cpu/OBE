<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CqiActivityQuestion extends Model
{
    use HasFactory;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
        'courseoffer_id',
        'cqi_activity_id',
        'question_name',
        'name',
        'answer',
        'clo_id',
        'complexity',
        'question',
        'max_mark',
        'obe_weight',
        'guidline',
        'choices',
        'not_for_obe',
        'created_by',
    ];

    public function cqiclassactivity()
    {
        return $this->belongsTo(CqiClassActivity::class, 'cqi_activity_id');
    }

    public function activityQuestionRubrics()
    {
        return $this->hasMany(ActivityQuestionRubric::class, 'question_id');
    }

    public function clo()
    {
        return $this->belongsTo(CLO::class, 'clo_id');
    }
    public function courseoffer(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }
}
