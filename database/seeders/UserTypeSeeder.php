<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\UserTypeSeeder;
use DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        "ALTER TABLE user_types AUTO_INCREMENT = 1";
        UserType::create([
            'name' => 'Teacher',
            'slug' => 'teacher',
            'status' => 1,
            'created_by' => 1,
        ]);
        UserType::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'status' => 1,
            'created_by' => 1,
        ]);
        UserType::create([
            'name' => 'Teacher Assistant',
            'slug' => 'teacherassistant',
            'status' => 1,
            'created_by' => 1,
        ]); 
        UserType::create([
            'name' => 'HoD',
            'slug' => 'hod',
            'status' => 1,
            'created_by' => 1,
        ]);
        UserType::create([
            'name' => 'Dean',
            'slug' => 'dean',
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}
