<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization;
use App\Models\Campus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class OrganizationController extends Controller
{
    use TraitFunctions;

    public function getOrganizations(Request $request)
    {
        if ($request->ajax()) {
            $data = Organization::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                   
                    $name = '<h2 class="table-avatar"><a href="'.route('organizationcampus',$row->id).'">'.$row->name.' </a></h2>';
                    return $name;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changeorganizationstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeorganizationstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('organization-all'); 
                    $edit_permission = $this->checkPermissions('organization-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                    
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editorganization',$row->id).'">Edit</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editorganization',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['name','status','action'])
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
        $check_all_permission = $this->checkPermissions('organization-all');
        $check_read_permission = $this->checkPermissions('organization-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('organization-write');
            $edit_permission = $this->checkPermissions('organization-edit');
            $delete_permission = $this->checkPermissions('organization-delete');
          return view('organization.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
        }else{
          $error = "403";
          $heading = "Oops! Forbidden";
          $message = "You don't have permission to access this module";
          return view('errors.error',compact('message','error','heading'));
        }
        // $organizations = Organization::all();
        // return view('organization.manage',compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $check_all_permission = $this->checkPermissions('organization-all'); 
        $check_create_permission = $this->checkPermissions('organization-write');
        if($check_create_permission == true || $check_all_permission == true){
            return view('organization.add');
        }else{
          $error = "403";
          $heading = "Oops! Forbidden";
          $message = "You don't have permission to access this module";
          return view('errors.error',compact('message','error','heading'));
        }
        return view('organization.add');
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
        ],
        [
            'name.required' => 'Organization Name is required',
            'location.required' => 'Location is required',
        ]);

        Organization::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('manageorganization')->with('success','Data Added Successfully');
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

    public function organizationCampus($id){

        $check_all_permission = $this->checkPermissions('campus-all');
        $check_read_permission = $this->checkPermissions('campus-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('campus-write');
            $edit_permission = $this->checkPermissions('campus-edit');
            $delete_permission = $this->checkPermissions('campus-delete');

          return view('organization.campus',compact('id','write_permission','edit_permission','delete_permission','check_all_permission'));
        }else{
          $error = "403";
          $heading = "Oops! Forbidden";
          $message = "You don't have permission to access this module";
          return view('errors.error',compact('message','error','heading'));
        }
    }
    public function getorganizationCampus($id)
    {
        // if ($request->ajax()) {
            $data = Campus::with(['organization'=>function($query) {
                return $query->select(['id', 'name']);
            }])->where('organization_id',$id)->latest()->get();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);
        return view('organization.edit',compact('organization'));
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
            'description' => $request->description,
            'location' => $request->location,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'status' => $request->status,
        );
        Organization::whereid($request->id)->update($update_data);
        return redirect()->route('manageorganization')->with('success','Data Updated Successfully');
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
        Organization::whereid($id)->delete();
        return redirect()->route('manageorganization')->with('error','Data Deleted Successfully');
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
        Organization::whereid($id)->update($update_data);
        return redirect()->route('manageorganization');
    }
}
