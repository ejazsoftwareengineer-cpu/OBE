<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PEO extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'peo';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [ 'name','code', 'description', 'element', 'strategies', 'program_id'.'status', 'aligned_vision', 'aligned_mission', 'program_id', 'created_by'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    
    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }
    public function programs(){
        return $this->hasMany(Program::class,'program_id','id');
    }
}
