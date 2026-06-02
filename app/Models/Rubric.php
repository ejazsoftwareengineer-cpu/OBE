<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'institute_id',
        'rubric_score_set_id',
        'comment',
        'name',
        'status',
        'created_by',
    ];
    
    public function institute(){
        return $this->belongsTo(Institute::class,'institute_id','id');
    }
    
}
