<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;
use App\Models\Sesssion;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class Header extends Component
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
    public function render()
    {
        $sesssion = Sesssion::select('id','title')->get();   
        $user = Auth::user();
        $roleIds = $user->roles->pluck('id')->toArray();
        $roles = Role::select('id','name')->whereIn('id',$roleIds)->get();
        $userRole ='' ;
        if(session()->has('role_key')) {
            $roleId = session('role_key');
            $userRole = Role::whereid($roleId)->first();
        }
        $usersession = '';
        if(session()->has('session_key')) {
            $sessionId = session('session_key');
            $usersession = Sesssion::whereid($sessionId)->first();
        }

        return view('components.layout.header',compact('sesssion','roles','userRole','usersession'));
    }
}
