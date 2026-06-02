<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CqiActivityQuestionRubrics extends Model
{
    use HasFactory;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
      'cqi_question_id',
      'cqi_activity_id',
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
        return $this->belongsTo(CqiActivityQuestion::class,'cqi_question_id','id');
    }
}
