<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RoleSeeder;
use DB;

class RoleSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'super-admin',
            'status' => 1,
        ]);
        Role::create([
            'name' => 'Admin',
            'guard_name' => 'admin',
            'status' => 1,
        ]);
        Role::create([
            'name' => 'Program Incharge',
            'guard_name' => 'program-incharge',
            'status' => 1,
        ]);
        Role::create([
            'name' => 'Deen',
            'guard_name' => 'deen',
            'status' => 1,
        ]);
        Role::create([
            'name' => 'Teacher',
            'guard_name' => 'teacher',
            'status' => 1,
        ]);
        Role::create([
            'name' => 'Coordinator',
            'guard_name' => 'coordinator',
            'status' => 1,
        ]);
    }
    
}