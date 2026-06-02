<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FunctionalityPermission;
use App\Models\Functionality;
use App\Models\Institute;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class FunctionalityPermissionController extends Controller
{
    use TraitFunctions;
    public function getFunctionalityPermissions(Request $request)
    {
        if ($request->ajax()) {
            // $data = FunctionalityPermission::latest()->get();
            $data = FunctionalityPermission::with([
                'role' => function ($query) {
                    return $query->select(['id', 'name']);
                },
                'user' => function ($query) {
                    return $query->select(['id', 'name']);
                },
                'functionality' => function ($query) {
                    return $query->select(['id', 'functionality_name']);
                }
            ])->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($row){
                    $user = '';
                    $i = "'";
                    if($row->user){
                        $user = $row->user->name;
                    }else{
                        $user = '-';
                    }
                    $userlabel = $user;
                    return $userlabel;
                })
                ->addColumn('role', function($row){
                    $role = '';
                    $i = "'";
                    if($row->role){
                        $role = $row->role->name;
                    }else{
                        $role = '-';
                    }
                    $rolelabel = $role;
                    return $rolelabel;
                })
                ->addColumn('functionality', function($row){
                    $function = '';
                    $i = "'";
                    if($row->functionality){
                        $function = $row->functionality->functionality_name;
                    }else{
                        $function = '-';
                    }
                    $functionlabel = $function;
                    return $functionlabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changefunctionalitypermissionstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changefunctionalitypermissionstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    // $check_all_permission = $this->checkPermissions('functionalitypermission-all'); 
                    // $edit_permission = $this->checkPermissions('functionalitypermission-edit');
                    // $actionBtn = '';
                    // if($edit_permission === true || $check_all_permission === true){
                    
                    // }
                    $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editfunctionalitypermission',$row->id).'">Edit</a>';
                
                    return $actionBtn;
                })
                ->rawColumns(['status','user','role','functionality','action'])
                // ->rawColumns(['status','action','campus'])
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
        $check_all_permission = $this->checkPermissions('functionalitypermission-all');
        $check_read_permission = $this->checkPermissions('functionalitypermission-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('functionalitypermission-write');
            $edit_permission = $this->checkPermissions('functionalitypermission-edit');
            $delete_permission = $this->checkPermissions('functionalitypermission-delete');
          return view('functionalitypermission.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('functionalitypermission-all'); 
        $check_create_permission = $this->checkPermissions('functionalitypermission-write');
        if($check_create_permission == true || $check_all_permission == true){
            
        $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];

            // echo "<pre>";
            // print_r($institute_id);
            // die();

            if ($flag === 'all') {
                $institute = Institute::select('id','name')->wherestatus(1)->get();
                $users = User::select('id', 'name')->get();
            }else{
                // $institute = Institute::select('id','name')->whereIn('id', $institute_id)->wherestatus(1)->get();
                $users = User::select('id', 'name', 'role_id')->whereIn('institute_id', $institute_id)->get();
                // $institute = Institute::select('id','name')->whereid($institute_id)->wherestatus(1)->get();
                // $users = User::select('id', 'name', 'role_id')->whereinstitute_id($institute_id)->get();
            }


        //   $users = User::select('id','name')->wherestatus(1)->get();
          $roles = Role::select('id','name')->wherestatus(1)->get();
          $functionality = Functionality::whereNotIn('id', [1])->wherestatus(1)->get();
            return view('functionalitypermission.add',compact('users','functionality','roles'));
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
            'role_id' => 'required',
            'user_id' => 'required',
            'function_id' => 'required',
            'relavent_id' => 'required',
        ],  
        [
            'role_id.required' => 'Role is required',
            'user_id.required' => 'User is required',
            'function_id.required' => 'Functionality required',
            'relavent_id.required' => 'Required',
        ]);
        $relaventId = $request->input('relavent_id');
        $relaventIds = is_array($relaventId) ? implode(',', $relaventId) : (is_string($relaventId) ? $relaventId : $relaventId);
        $existing = FunctionalityPermission::where('user_id',$request->user_id)->where('role_id',$request->role_id)->first();
        if(!$existing){
            FunctionalityPermission::create([
                'role_id'=> $request->role_id,
                'user_id'=> $request->user_id,
                'function_id'=> $request->function_id,
                'relavent_id'=> $relaventIds,
                'relavent_table_flag'=> $request->relavent_table_flag,
                'created_by' => Auth::user()->id,
            ]);
        }else{
            $update = array(
                'role_id'=> $request->role_id,
                'user_id'=> $request->user_id,
                'function_id'=> $request->function_id,
                'relavent_id'=> $relaventIds,
                'relavent_table_flag'=> $request->relavent_table_flag,
            );
            FunctionalityPermission::where('user_id',$request->user_id)->where('role_id',$request->role_id)->update($update);
            return redirect()->route('managefunctionalitypermission')->with('success','Functionality Permission Updated.');
        }
        return redirect()->route('managefunctionalitypermission')->with('success','Data Added Successfully');
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
        $functionalitypermission = FunctionalityPermission::find($id);
        $users = User::select('id','name')->wherestatus(1)->get();
        $roles = Role::select('id','name')->wherestatus(1)->get();
        $functionality = Functionality::wherestatus(1)->get();
        return view('functionalitypermission.edit',compact('functionalitypermission','users','roles','functionality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'user_id' => 'required',
            'function_id' => 'required',
            'relavent_id' => 'required',
        ],  
        [
            'role_id.required' => 'Role is required',
            'user_id.required' => 'User is required',
            'function_id.required' => 'Functionality required',
            'relavent_id.required' => 'Required',
        ]);
        $relaventId = $request->input('relavent_id');
        $relaventIds = is_array($relaventId) ? implode(',', $relaventId) : (is_string($relaventId) ? $relaventId : $relaventId);

        $update_data = array(
            'role_id'=> $request->role_id,
            'user_id'=> $request->user_id,
            'function_id'=> $request->function_id,
            'relavent_id'=> $relaventIds,
            'relavent_table_flag'=> $request->relavent_table_flag,
        );
        FunctionalityPermission::whereid($request->id)->update($update_data);

        return redirect()->route('managefunctionalitypermission')->with('success','Data Updated Successfully');
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
        FunctionalityPermission::whereid($id)->delete();
        return redirect()->route('managefunctionalitypermission')->with('error','Data Deleted Successfully');
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
        FunctionalityPermission::whereid($id)->update($update_data);
        return redirect()->route('managefunctionalitypermission');
    }
}
