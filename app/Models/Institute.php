<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'name',
        'description',
        'sap_institute_id',
        'campus_id',
        'mission',
        'vision',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
    
    public function campus(){
        return $this->belongsTo(Campus::class,'campus_id');
    }
    
    public function program(){
        return $this->hasMany(Program::class);
    }
    
}
