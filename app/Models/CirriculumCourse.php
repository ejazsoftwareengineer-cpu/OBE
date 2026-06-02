<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CirriculumCourse extends Model
{ use HasFactory;
      /**
       * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */

   protected $fillable = [
      'semester',
      'course_id',
      'cirriculum_id',
      'status',
      'created_by',
   ];

   /**
    * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
   protected $hidden = [];


   public function course(){
      return $this->belongsTo(Course::class,'course_id','id');
   }

   public function cirriculum(){
      return $this->belongsTo(Cirriculum::class,'cirriculum_id','id');
   }

   
}
