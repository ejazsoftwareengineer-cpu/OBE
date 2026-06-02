<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricQuestion extends Model
{
    use HasFactory;
    
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'question',
        'weight',
        'rubric_id',
        'description',
        'created_by',
    ];
}
