<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBatch extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'acedemic_year',
        'program_id',
        'cirriculum_id',
        'no_of_session',
        'status',
        'theory_crdit_hr',
        'lab_crdit_hr',
        'description',
        'name',
        'use_in_obe',
        'gpa_method',
        'mark_per',
        'student_per',
        'plo_passing_threshold',
        'start_date',
        'end_date',
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
}
