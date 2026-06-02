<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Campus;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class CampusController extends Controller
{
    use TraitFunctions;
    public function getCampus(Request $request)
    {
        
        // if ($request->ajax()) {
            // exit('eh');
            $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            if($flag === 'all'){
                $data = Campus::with(['organization'=>function($query) {
                    return $query->select(['id', 'name']);
                }])->latest()->get();
            }elseif($flag === 'institute'){
                $campusId = $hasFunctionalityPermission['campus_id'] ?? [];
                // print_r($campusId);
                // die('ejaz');
                $data =  (!empty($campusId)) ? Campus::with(['organization'=>function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $campusId)->latest()->get() :  null; 
            }elseif($flag === 'program'){
                $campusId = $hasFunctionalityPermission['campus_id'] ?? [];
                
                $data =  (!empty($campusId)) ? Campus::with(['organization'=>function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $campusId)->latest()->get() :  null;
            }elseif($flag === 'reports_dashboard'){
                $data =  [];
            }elseif($flag === 'enrolled_course'){
                $campusId = $hasFunctionalityPermission['campus_id'] ?? [];
                
                $data =  (!empty($campusId)) ? Campus::with(['organization'=>function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $campusId)->latest()->get() :  null;
            }elseif($flag === 'courseoffering_enrollment'){
                $data =  [];
            }else{
                $data = [];
            }

           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('organization', function($row){
                    $organization = '';
                    $i = "'";
                    if($row->organization){
                        $organization = $row->organization->name;
                    }else{
                        $organization = '-';
                    }
                    $organizationlabel = $organization;
                    return $organizationlabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changecampusstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changecampusstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('campus-all'); 
                    $edit_permission = $this->checkPermissions('campus-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editcampus',$row->id).'">Edit</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editcampus',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','organization','action'])
                ->make(true);
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check_all_permission = $this->checkPermissions('campus-all');
        $check_read_permission = $this->checkPermissions('campus-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('campus-write');
            $edit_permission = $this->checkPermissions('campus-edit');
            $delete_permission = $this->checkPermissions('campus-delete');
          return view('campus.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        
        $check_all_permission = $this->checkPermissions('campus-all'); 
        $check_create_permission = $this->checkPermissions('campus-write');
        if($check_create_permission == true || $check_all_permission == true){
            $organizations = Organization::select('id','name')->wherestatus(1)->get();
            return view('campus.add',compact('organizations'));
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
            'name' => 'required',
            'location' => 'required',
            'organization_id' => 'required',
            'campus_code' => 'required',
        ], 
        [
            'name.required' => 'Campus Name is required',
            'location.required' => 'Location is required',
            'campus_code.required' => 'Campus Code is required',
            'organization_id.required' => 'Organization required',
        ]);

        Campus::create([
            'name' => $request->name,
            'campus_code' => $request->campus_code,
            'location' => $request->location,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'organization_id' => $request->organization_id,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('managecampus')->with('success','Data Added Successfully');
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
        $campus = Campus::findOrFail($id);
        $organizations = Organization::select('id','name')->wherestatus(1)->get();

        return view('campus.edit',compact('campus','organizations'));
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
        $update_data = array(
            'name' => $request->name,
            'campus_code' => $request->campus_code,
            'location' => $request->location,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'organization_id' => $request->organization_id,
            'status' => $request->status,
        );
        Campus::whereid($request->id)->update($update_data);
        return redirect()->route('managecampus')->with('success','Data Updated Successfully');
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
        Campus::whereid($id)->delete();
        return redirect()->route('managecampus')->with('error','Data Deleted Successfully');
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
        Campus::whereid($id)->update($update_data);
        return redirect()->route('managecampus');
    }
}
