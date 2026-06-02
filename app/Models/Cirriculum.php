<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cirriculum extends Model
{
    use HasFactory;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'active_session_id',
        'name',
        'description',
        'institute_id', 
        'department_id',
        'program_id',
        'status',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
    */
    protected $hidden = [];
    
    
    public function institute(){
        return $this->belongsTo(Institute::class,'institute_id','id');
    }

    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }
    
}
