<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOfferClo extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'code',
        'name',
        'description',
        'course_id',
        'courseoffer_id',
        'domain',
        'emphasis_level',
        'weight',
        'level'
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
    public function courseoffer(){
        return $this->belongsTo(CourseOffer::class,'courseoffer_id','id');
    }
     public function questions()
    {
        return $this->hasMany(ActivityQuestion::class, 'clo_id', 'id');
    }
}
