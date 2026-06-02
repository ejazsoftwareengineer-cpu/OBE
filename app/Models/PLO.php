<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PLO extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'plo';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [ 
    'code',
    'name',
    // 'wa_code',
    'description',
    'strategies',
    'institute_id',
    'program_id',
    'program_batch_id',
    'knowledge_profile',
    'peo_id',
    'status',
     'created_by'];

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

    // public function department(){
    //     return $this->belongsTo(Department::class,'department_id','id');
    // }
    
    public function peo(){
        return $this->belongsTo(PEO::class,'peo_id','id');
    }
}
