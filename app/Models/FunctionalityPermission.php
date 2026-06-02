<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionalityPermission extends Model
{
    use HasFactory;
    
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

    protected $fillable = [
        'role_id',
        'user_id',
        'function_id',
        'relavent_id',
        'relavent_table_flag',
        'created_by'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function functionality(){
        return $this->belongsTo(Functionality::class,'function_id');
    }
}
