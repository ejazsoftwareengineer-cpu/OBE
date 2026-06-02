<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityQuestionRubric extends Model
{
    use HasFactory;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
      'question_id',
      'activity_id',
      'scale_1',
      'scale_2',
      'scale_3',
      'scale_4',
      'scale_5',
      'scale_6',
      'created_by'
    ];
    public function activityQuestion()
    {
        return $this->belongsTo(ActivityQuestion::class,'question_id','id');
    }

}
