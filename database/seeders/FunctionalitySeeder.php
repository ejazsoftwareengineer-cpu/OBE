<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Functionality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ModulesSeeder;
use DB;

class FunctionalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Functionality::create([
            'functionality_name' => 'All',
            'slug' => 'all',
            'status' => 1, 
        ]);
        Functionality::create([
            'functionality_name' => 'Institute',
            'slug' => 'institute',
            'status' => 1, 
        ]);
        Functionality::create([
            'functionality_name' => 'Program',
            'slug' => 'program',
            'status' => 1, 
        ]);
        Functionality::create([
            'functionality_name' => 'Reports/Dashboard',
            'slug' => 'reports_dashboard',
            'status' => 1, 
        ]);
        Functionality::create([
            'functionality_name' => 'Enrolled Course',
            'slug' => 'enrolled_course',
            'status' => 1, 
        ]);
        Functionality::create([
            'functionality_name' => 'Course Offering / Enrollment',
            'slug' => 'courseoffering_enrollment',
            'status' => 1, 
        ]);
    }
  
}
