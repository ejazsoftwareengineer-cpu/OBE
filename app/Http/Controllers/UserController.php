<?php
          
namespace App\Http\Controllers;
       
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserType;
use App\Models\Institute;
use App\Models\ProgramBatch;
use App\Models\Program;
use App\Models\Functionality;
use App\Models\Campus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Mail;
use App\Mail\UserMail;
      
class UserController extends Controller
{
    use TraitFunctions;
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];
            if ($flag === 'all') {
                // $institute = Institute::select('id','name')->wherestatus(1)->get();
                $data = User::with(['institute'])->get();
            }else{
                $data = User::with(['institute'])->whereinstitute_id($institute_id)->get();
                // $institute = Institute::select('id','name')->whereid($institute_id)->wherestatus(1)->get();
            }

            $data = User::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('gender', function($row){
                    $gender = '';
                    $i = "'";
                    if($row->gender === 'female'){
                        $gender = 'Female';
                    }else{
                        $gender = 'Male';
                    }
                    $genderlabel = $gender;
                    return $genderlabel;
                })
                ->addColumn('institute', function($row){
                    $institute = '';
                    $i = "'";
                    if($row->institute){
                        $institute = $row->institute->name;
                    }else{
                        $institute = '-';
                    }
                    $institute_d = $institute;
                    return $institute_d;
                })
                ->addColumn('role', function($row){
                    $roles = json_decode($row->role_id,true);
                    $roleNames = '';
                    if(is_array($roles)){
                        foreach ($roles as $roleId) {
                            $role = Role::find($roleId);
                            if ($role) {
                                $roleNames .= $role->name . ', ';
                            }
                        }
                    }
                    $roleNames = rtrim($roleNames, ', ');
                    return $roleNames;
                })
                ->addColumn('status', function($row){
                    $status = '';
                    $i = "'";
                     if($row->status === 1){
                        $status = '<i class="fa fa-dot-circle-o text-purple"></i> Active';
                    }elseif($row->status === 0){
                        $status = '<i class="fa fa-dot-circle-o text-info"></i> InActive';
                    }else{
                        $status = '<i class="fa fa-dot-circle-o text-info"></i> Select Status';
                    }
                    $statusBtn = '<div class="table-col dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                '.$status.'
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changestatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changestatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('user-all'); 
                    $edit_permission = $this->checkPermissions('user-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('edituser',$row->id).'">Edit</a>';
                    }

                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('edituser',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','role','institute','gender','action'])
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check_all_permission = $this->checkPermissions('user-all');
        $check_read_permission = $this->checkPermissions('user-read');
        if($check_read_permission == true || $check_all_permission == true){
          $write_permission = $this->checkPermissions('user-write');
          $edit_permission = $this->checkPermissions('user-edit');
          $delete_permission = $this->checkPermissions('user-delete');
          return view('users.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
        }else{
          $error = "403";
          $heading = "Oops! Forbidden";
          $message = "You don't have permission to access this module";
          return view('errors.error',compact('message','error','heading'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check_all_permission = $this->checkPermissions('user-all'); 
        $check_create_permission = $this->checkPermissions('user-write');
        if($check_create_permission == true || $check_all_permission == true){

            $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];
            if ($flag === 'all') {
                $institute = Institute::select('id','name')->wherestatus(1)->get();
            }else{
                $institute = Institute::select('id','name')->whereid($institute_id)->wherestatus(1)->get();
            }

            $roles = Role::select('id','name')->whereNotIn('id', [1])->wherestatus(1)->get();
            $usertypes = UserType::select('id','name')->wherestatus(1)->get();
            // $institute = Institute::select('id','name')->wherestatus(1)->get();
            $functionality = Functionality::wherestatus(1)->get();
          
          return view('users.add',compact('roles','usertypes','functionality','institute'));
        }else{
          $error = "403";
          $heading = "Oops! Forbidden";
          $message = "You don't have permission to access this module";
          return view('errors.error',compact('message','error','heading'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'role_id' => 'required',
            'email' => 'required|unique:users',
        ],
        [
            'firstname.required' => 'First Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Unique Email Required',
            'role_id.required' => 'Role required',
        ]);
        // echo "<pre>";
        // print_r(implode(',',$request->input('role_id')));
        // die();  
        // $roles = $request->input('role_id');
        // $role = implode(',',$roles);
        
        $password = Str::random(8);
        $hashed_random_password = Hash::make($password);
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->firstname . ' ' .$request->lastname,
            'email' => $request->email,
            'password' => $hashed_random_password,
            'gender' => $request->gender,
            'institute_id' => $request->institute_id,
            // 'role_id' => $role,
            'role_id' => json_encode($request->role_id),
            'status' => $request->status,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'created_by' => Auth::user()->id,
        ]);

        // if($role){
        //     foreach($roles as $r){

        //         $model_array = array(
        //             'model_type' => 'App\Models\User',
        //             'role_id'   => $r,
        //             'model_id'   => $user_date->id,

        //         );
        //         DB::table('model_has_roles')->insert($model_array);
        //     }
        // }
        
        $user = User::find($user->id);
        $roles = Role::select('id')->get()->toArray();
        $user_roles = json_decode($user->role_id);
       
        foreach($user_roles as $user_role){

            if(!in_array($user_role, $roles)){

                $model_array = array(
                    'model_type' => 'App\Models\User',
                    'role_id'   => $user_role,
                    'model_id'   => $user->id,

                );
                
                DB::table('model_has_roles')->insert($model_array);

            }

        }
        $mailData = [
            'email' => $request->email,
            'password' => $password,
        ];
         
        Mail::to($request->email)->send(new UserMail($mailData));
        return redirect()->route('manageuser')->with('success','Data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // $userRole = $user->roles->toArray();
        // $result = DB::table('model_has_roles')->select('role_id')->where('model_id', '=' ,$id )->get();
        // $userRole = '';
        // if(!$result->isEmpty()){
        //     $userRole = $result[0]->role_id;
        // }

        $userRole = DB::table('model_has_roles')->where('model_id', $id)->pluck('role_id')->toArray();
        $roles = Role::select('id','name')->wherestatus(1)->get();
        // $sessions = ProgramBatch::select('id','name')->wherestatus(1)->get();   
        $usertypes = UserType::select('id','name')->wherestatus(1)->get(); 
        $campuses = Campus::select('id','name')->wherestatus(1)->get();
        $institute = Institute::select('id','name')->wherestatus(1)->get();
        return view('users.edit',compact('user','userRole','roles','usertypes','campuses','institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)
    // {
    //     $role = $request->input('role_id');
    //     $commarole = implode(',',$roles);
    //     $update_data = array(
    //         'firstname' => $request->firstname,
    //         'lastname' => $request->lastname,
    //         'email' => $request->email,
    //         'gender' => $request->gender,
    //         'usertype_id' => $request->usertype_id,
    //         'role_id' => $commarole,
    //         'status' => $request->status,
    //         'address' => $request->address,
    //         'phone_number' => $request->phone_number
    //     );
    //     User::whereid($request->id)->update($update_data);
    //     $user = User::find($request->id);
    //     $roles = Role::pluck('name','name')->all();
    //     foreach($role as $r){

    //         if($user->hasRole($roles)){
    //             DB::table('model_has_roles')->where('model_id',$request->id)->delete();
    //             if($request->input('role_id')){
    //                 $model_array = array(    
    //                     'model_type' => 'App\Models\User',
    //                     'role_id'   => $request->input('role_id'),
    //                     'model_id'   => $user->id,
    //                 );
    //                 DB::table('model_has_roles')->insert($model_array);
    //             }
    //         }else{
    //             DB::table('model_has_roles')->where('model_id',$request->id)->delete();
    //             if($request->input('role_id')){
    //                 $model_array = array(
    //                     'model_type' => 'App\Models\User',
    //                     'role_id'   => $request->input('role_id'),
    //                     'model_id'   => $user->id,
    
    //                 );
    //                 DB::table('model_has_roles')->insert($model_array);
    //             }
    //         }
    //     }

    //     return redirect()->route('manageuser')->with('success','Data Updated Successfully');
    // }
    public function update(Request $request)
    {
        // Retrieve the role IDs from the form input and implode them into a comma-separated string
        // $roleIds = $request->input('role_id');
        // $commaSeparatedRoles = implode(',', $roleIds);

        // Define the update data for the user
        $user = User::findOrFail($request->id);
        $update = $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'usertype_id' => $request->usertype_id,
            'institute_id' => $request->institute_id,
            // 'role_id' => $commaSeparatedRoles, // Update with the comma-separated roles
            'role_id' => json_encode($request->input('role_id')), // Update with the comma-separated roles
            'status' => $request->status,
            'address' => $request->address,
            'phone_number' => $request->phone_number
        ]);

        if($update){

            $user = User::find($user->id);
            $roles = Role::select('id')->get()->toArray();
            $user_roles = json_decode($user->role_id);
            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            foreach($user_roles as $user_role){

                if(!in_array($user_role, $roles)){

                    $model_array = array(
                        'model_type' => 'App\Models\User',
                        'role_id'   => $user_role,
                        'model_id'   => $user->id,
    
                    );
                    
                    DB::table('model_has_roles')->insert($model_array);
    
                }

            }
        }
        // Update the user data
        // User::where('id', $request->id)->update($update_data);

        // // Find the user by ID
        // $user = User::find($request->id);

        // // Delete existing roles for the user
        // DB::table('model_has_roles')->where('model_id', $request->id)->delete();

        // // Insert new roles for the user
        // foreach ($roleIds as $roleId) {
        //     $model_array = [
        //         'model_type' => 'App\Models\User',
        //         'role_id'   => $roleId,
        //         'model_id'   => $user->id,
        //     ];
        //     DB::table('model_has_roles')->insert($model_array);
        // }

        return redirect()->route('manageuser')->with('success', 'Data Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = $_REQUEST['id'];
        User::whereid($id)->delete();
        return redirect()->route('manageuser')->with('error','Data Deleted Successfully');
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus()
    {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $update_data = array(
            'status' => $status,
        );
        User::whereid($id)->update($update_data);
        return redirect()->route('manageuser');
    }


    public function profile(){
        $user_detail = User::find(Auth::user()->id);
        return view('users.profile',compact('user_detail'));
    }

  public function changepassword(){
        $user_detail = User::find(Auth::user()->id);
        return view('users.changepassword',compact('user_detail'));
    }


public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'confirmed',
            'min:8',
            'max:12',
            'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,12}$/'
        ],
    ], [
        'new_password.regex' => 'Password must contain letter, number and special character.',
    ]);

    $user = Auth::user();

    // 1. Check if the "Current Password" entered is actually correct
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Current password is incorrect.');
    }

    // 2. NEW VALIDATION: Check if the "New Password" is the same as the "Current Password"
    if (Hash::check($request->new_password, $user->password)) {
        return back()->with('error', 'New password cannot be the same as your current password. Please choose a different one.');
    }

    // Update password
    $user->password = Hash::make($request->new_password);

    // Mark as changed
    $user->change_password = 1;

    $user->save();

    return back()->with('success', 'Password updated successfully.');
}

}
