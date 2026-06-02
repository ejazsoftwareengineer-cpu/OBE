<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloPlo extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */

     protected $fillable = [
        'clo_id', 
        'program_batch_id', 
        'plo_id', 
        'domain',
        'emphasis_level',
        'level',
    ];

     /**
      * The attributes that should be hidden for serialization.
      *
      * @var array<int, string>
    */
     protected $hidden = [];
 
     public function plo(){
         return $this->belongsTo(PLO::class,'plo_id','id');
     }
     public function batch(){
         return $this->belongsTo(ProgramBatch::class,'programbatch_id','id');
     }
}
