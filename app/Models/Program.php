<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'organization_id',
        'campus_id',
        'institute_id',
        'no_of_session',
        'mark_per',
        'assessment_method',
        'vision',
        'status',
        'session_type',
        'program_level',
        'program_type',
        'student_per',
        'learning_type_category',
        'mission',
        'description',
        'created_by',
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
    
    public function programbatch(){
        return $this->hasMany(ProgramBatch::class);
    }
}
