<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $role = Role::findOrFail(1);
        $permission_result = Permission::create([
          'name' =>  'role-all',
          'guard_name' => 'super-admin',
          'status' => 1,
          'created_by' => 1,
        ]);
        $role->givePermissionTo($permission_result->id);
  }
}

