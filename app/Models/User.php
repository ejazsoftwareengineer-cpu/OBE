<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'phone_number',
        'usertype_id',
        'institute_id',
        'role_id',
        'email',
        'password',
        'address',
        'gender',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = 
    [
        'email_verified_at' => 'datetime',
    ];
    
    public function usertype(){
        return $this->belongsTo(UserType::class,'usertype_id','id');
    }
    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }
    public function institute(){
        return $this->belongsTo(Institute::class,'institute_id','id');
    }
    
    public function hasRole($roleName)
    {
        return $this->roles->where('guard_name', $roleName)->count() > 0;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
}
