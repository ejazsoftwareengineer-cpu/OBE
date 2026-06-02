<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'code',
        'delivery_format',
        'theory',
        'lab',
        'tutorial',
        'program_id',
        // 'program_batch_id',
        // 'institute_id',
        // 'department_id',
        'obe_mapping',
        'clo_id',
        'name',
        'course_level',
        'based_type',
        'description',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    
    protected $hidden = [];
 
    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }

    // public function department(){
    //     return $this->belongsTo(Department::class,'department_id','id');
    // }
    
    public function institute(){
        return $this->belongsTo(Institute::class,'institute_id','id');
    }
    
}
