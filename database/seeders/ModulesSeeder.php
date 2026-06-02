<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ModulesSeeder;
use DB;

class ModulesSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    // Setups
    
    Module::create([
        'module_name' => 'Category',
        'slug' => 'category',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-category',
        // 'menu_template' => 'http://localhost/obe/manage-category',
        'icon' => 'la la-briefcase','category_id' => 1,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Module',
        'slug' => 'module',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-module',
        // 'menu_template' => 'http://localhost/obe/manage-module',
        'icon' => 'la la-cube','category_id' => 1,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Organization',
        'slug' => 'organization',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-organization',
        // 'menu_template' => 'http://localhost/obe/manage-organization',
        'icon' => 'la la-graduation-cap','category_id' => 1,'status' => 1, 
      ]);
      Module::create([
        'module_name' => 'Campus',
        'slug' => 'campus',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-campus',
        // 'menu_template' => 'http://localhost/obe/manage-campus',
        'icon' => 'la la-graduation-cap','category_id' => 1,'status' => 1, 
      ]);
      Module::create([
        'module_name' => 'Institute',
        'slug' => 'institute',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-institute',
        // 'menu_template' => 'http://localhost/obe/manage-institute',
        'icon' => 'la la-graduation-cap','category_id' => 1,'status' => 1, 
      ]);
      // Module::create([
      //   'module_name' => 'Acedemic Year',
      //   'slug' => 'acedemicyear',
      //   // 'menu_template' => 'https://obe.riphah.edu.pk/manage-acedemicyear',
      //   'menu_template' => 'http://localhost/obe/manage-acedemicyear',
      //   'icon' => 'la la-edit','category_id' => 1,'status' => 1, 
      // ]);
      
      Module::create([

        'module_name' => 'Assessment',
        'slug' => 'assesment',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-assesment',
        // 'menu_template' => 'http://localhost/obe/manage-assesment',
        'icon' => 'la la-edit','category_id' => 1,'status' => 1, 
      ]);
    
    // Users
    Module::create([

        'module_name' => 'Manage User',
        'slug' => 'user',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-user',
        // 'menu_template' => 'http://localhost/obe/manage-user',
        'icon' => 'la la-user','category_id' => 2,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Functionality Permission',
        'slug' => 'functionalitypermission',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-functionalitypermission',
        // 'menu_template' => 'http://localhost/obe/manage-functionalitypermission',
        'icon' => 'la la-user','category_id' => 2,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Student',
        'slug' => 'student',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-student',
        // 'menu_template' => 'http://localhost/obe/manage-student',
        'icon' => 'la la-users','category_id' => 1,'status' => 1, 
      ]);
    // Module::create([

    //     'module_name' => 'User Type',
    //     'slug' => 'usertype',
    //     // 'menu_template' => 'https://obe.riphah.edu.pk/manage-usertype',
    //     'menu_template' => 'http://localhost/obe/manage-usertype',
    //     'icon' => 'la la-user','category_id' => 2,'status' => 1, 
    //   ]);
    // ROLES
    Module::create([

        'module_name' => 'Manage Role',
        'slug' => 'role',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-role',
        // 'menu_template' => 'http://localhost/obe/manage-role',
        'icon' => 'la la-money','category_id' => 3,'status' => 1, 
      ]);
    
    // OBE
    Module::create([

      'module_name' => 'Program',
      'slug' => 'program',
      'menu_template' => 'https://obe.riphah.edu.pk/manage-program',
      // 'menu_template' => 'http://localhost/obe/manage-program',
      'icon' => 'la la-crosshairs','category_id' => 1,'status' => 1, 
    ]);
    Module::create([

      'module_name' => 'Course',
      'slug' => 'course',
      'menu_template' => 'https://obe.riphah.edu.pk/manage-course',
      // 'menu_template' => 'http://localhost/obe/manage-course',
      'icon' => 'la la-edit','category_id' => 1,'status' => 1, 
    ]);
    Module::create([

      'module_name' => 'Course Offer',
      'slug' => 'courseoffering',
      'menu_template' => 'https://obe.riphah.edu.pk/manage-courseoffering',
      // 'menu_template' => 'http://localhost/obe/manage-courseoffering',
      'icon' => 'la la-edit','category_id' => 1,'status' => 1, 
    ]);
    Module::create([

        'module_name' => 'Program Education Objective',
        'slug' => 'peo',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-program-education-objective',
        // 'menu_template' => 'http://localhost/obe/manage-program-education-objective',
        'icon' => 'la la-file-text','category_id' => 4,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Program Learning Outcome',
        'slug' => 'plo',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-program-learning-outcome',
        // 'menu_template' => 'http://localhost/obe/manage-program-learning-outcome',
        'icon' => 'la la-file-text','category_id' => 4,'status' => 1, 
      ]);
    Module::create([

        'module_name' => 'Course Learning Outcome',
        'slug' => 'clo',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-course-learning-outcome',
        // 'menu_template' => 'http://localhost/obe/manage-course-learning-outcome',
        'icon' => 'la la-file-text','category_id' => 4,'status' => 1, 
      ]);
    
    // REGISTRAR
    Module::create([

        'module_name' => 'Curriculum',
        'slug' => 'cirriculum',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-cirriculum',
        // 'menu_template' => 'http://localhost/obe/manage-cirriculum',
        'icon' => 'la la-file-text','category_id' => 5,'status' => 1, 
      ]);   
    Module::create([
        'module_name' => 'Session',
        'slug' => 'session',
        'menu_template' => 'https://obe.riphah.edu.pk/manage-session',
        // 'menu_template' => 'http://localhost/obe/manage-session',
        'icon' => 'la la-file-text','category_id' => 1,'status' => 1, 
      ]);   
  }
  
}