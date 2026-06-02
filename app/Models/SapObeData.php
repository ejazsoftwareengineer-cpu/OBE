<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SapObeData extends Model
{
    use HasFactory;
    /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
    */
    protected $fillable = [
        'AdmAyear',
        'AdmPerid',
        'SapId',
        'ProgNam',
        'OrgId',
        'OrgNam',
        'InstId',
        'Varyf',
        'InstNam',
        'ScObjid',
        'AwObjid',
        'Course',
        'Cpattemp',
        'Packnumber',
        'SecNam',
        'Tabnr',
        'TeacherId',
        'Teacher',
        'StObjid',
        'Student12',
        'VornaMc',
        'NachnMc',
        'Student',
        'Smstatus',
        'Agrid',
        'Agrtype',
        'Agrremark',
        'Sessional',
        'Mid',
        'Final',
        'Performance',
        'Viva',
    ];
}
