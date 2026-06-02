<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ModulesSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\FunctionalitySeeder;
use Database\Seeders\UserTypeSeeder;
use Illuminate\Support\Facades\Schema;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
        * Seed the application's database.
        *
        * @return void
    */
    public function run()
    {
        // DB::table('roles')->truncate();
        // DB::table('users')->truncate();
        // DB::table('categories')->truncate();
        // DB::table('functionalities')->truncate();
        // DB::table('modules')->truncate();

        $this->call([
            RoleSeeder::class,
            UserTableSeedeer::class,
            FunctionalitySeeder::class,
            RolesAndPermissionsSeeder::class,
            ModulesSeeder::class,
            CategorySeeder::class,
            // UserTypeSeeder::class,
          ]);
    }
    
}
