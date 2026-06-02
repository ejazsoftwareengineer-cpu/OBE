<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cqi extends Model
{
    use HasFactory;
    /**
        * The attributes that are mass assignable.
       *
       * @var array<int, string>
       */
   
       protected $fillable = [
            'courseoffer_id',
            'course_id',
            'clo_id',
            'cqiremarks',
            'issue_date',
            'name',
            'status',
            'created_by',
       ];
       
    public function course_offer(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function clo(){
        return $this->belongsTo(CLO::class,'clo_id','id');
    }
}
