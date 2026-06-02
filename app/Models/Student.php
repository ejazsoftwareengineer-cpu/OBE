<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'roll_no',
        'registration_no',
        'email',
        'nationality',
        'state',
        'city',
        'marital_status',
        'cnic',
        'religion',
        'admission_type',
        'birthday',
        'gender',
        'address',
        'phone_number',
        'inter_degree_type',
        'inter_max',
        'inter_obt',
        'passing_year_int',
        'inter_board',
        'matric_degree_type',
        'matric_passing_year',
        'matric_max',
        'matric_obt',
        'matric_board',
        'transfered',
        'guardian',
        'guardian_name',
        'guardian_cnic',
        'guardian_mobile',
        'session_id',
        'user_id',
        'program_id',
        'active_session_id',
        'student_profile_pic',
        'status', 
        'created_by'
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
