<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategorySeeder;
use DB;

class CategorySeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
    public function run()
    {
        Category::create([
            'name' => 'Setup',
            'icon' => 'la la-object-ungroup',
            'status' => 1,
            'created_by' => 1,
        ]);
        Category::create([
            'name' => 'User',
            'icon' => 'la la-users',
            'status' => 1,
            'created_by' => 1,
        ]);
        Category::create([
            'name' => 'Roles',
            'icon' => 'la la-user-secret',
            'status' => 1,
            'created_by' => 1,
        ]); 
        Category::create([
            'name' => 'OBE',
            'icon' => 'la la-file-text',
            'status' => 1,
            'created_by' => 1,
        ]);
        Category::create([
            'name' => 'Registrar',
            'icon' => 'la la-object-ungroup',
            'status' => 1,
            'created_by' => 1,
        ]);
    }
}