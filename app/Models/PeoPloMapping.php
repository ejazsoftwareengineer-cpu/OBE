<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeoPloMapping extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'peo_id',
        'program_id',
        'plo_id',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
    
    public function peo(){
        return $this->belongsTo(PEO::class,'peo_id','id');
    }
    public function plo(){
        return $this->belongsTo(PLO::class,'plo_id','id');
    }
    public function program(){
        return $this->belongsTo(Program::class,'program_id','id');
    }
}
