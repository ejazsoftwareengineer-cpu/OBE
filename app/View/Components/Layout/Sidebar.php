<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;
use App\Models\User;
use App\Models\Module;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    // public function render()
    // {
    //     $user = User::find(Auth::user()->id);
    //     $module_object = new Module();
    //     $userRole = $user->roles->toArray();
    //     $categories = Category::all();
    //     $roles = Role::pluck('name','name')->all();
    //     $collection = array();
    //     if($userRole){
    //         $rolename = $userRole[0]['name'];
    //         $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
    //         ->where("role_has_permissions.role_id",$userRole[0]['id'])
    //         ->get();
    //         foreach($rolePermissions as $role_per){

    //             $per_name = explode('-',$role_per->name);
    //             if(!in_array($per_name[0],$collection)){
    //                 $collection[] = $per_name[0];
    //             }
    //         }
    //     }
    //     return view('components.layout.sidebar',compact('collection','categories','module_object'));
    // }
    public function render()
    {
        $user = User::find(Auth::user()->id);
        $module_object = new Module();
        // $userRole = $user->roles->toArray();
        $categories = Category::all();
        $roles = Role::pluck('name','name')->all();
      
        if(session()->has('role_key')) {
            $roleId = session('role_key');      
            $userRole = Role::whereid($roleId)->get()->toArray();
        }else{
            $userRole = $user->roles->toArray();
        }

        $collection = array();
        if($userRole){
            $rolename = $userRole[0]['name'];
            $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$userRole[0]['id'])
            ->get();
            foreach($rolePermissions as $role_per){

                $per_name = explode('-',$role_per->name);
                if(!in_array($per_name[0],$collection)){
                    $collection[] = $per_name[0];
                }
            }
        }
        return view('components.layout.sidebar',compact('collection','categories','module_object'));
    }
}
