<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOfferPlo extends Model
{
    use HasFactory;
    
    /**
    * The table associated with the model.
    *
    * @var string
    */
    
    protected $fillable = [ 
        'clo_id',
        'course_id',
        'course_section_id',
        'plo_id',
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
}
