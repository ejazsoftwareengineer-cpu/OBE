<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Campus;
use App\Models\Assesment;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class AssesmentController extends Controller
{
    use TraitFunctions;
    public function getAssesment(Request $request)
    {
        if ($request->ajax()) {
            $data = Assesment::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('allowed_operation', function($row){
                    $allowed_operation = '';
                    if($row->allowed_operation == 1){
                        $allowed_operation = 'Accept Uploads';
                    }else if($row->allowed_operation == 2){
                        $allowed_operation = 'Online Quiz';
                    }else if($row->allowed_operation == 3){
                        $allowed_operation = 'Online Assignment';
                    }else{
                        $allowed_operation = '-';
                    }
                    $allowed_operationlabel = $allowed_operation;
                    return $allowed_operationlabel;
                })
                ->addColumn('status', function($row){
                    $status = '';
                    $i = "'";
                    if($row->status === 1){
                        $status = '<i class="fa fa-dot-circle-o text-purple"></i> Active';
                    }elseif($row->status === 0){
                        $status = '<i class="fa fa-dot-circle-o text-info"></i> InActive';
                    }else{
                        $status = '<i class="fa fa-dot-circle-o text-info"></i>  - ';
                    }
                    $statusBtn = '<div class="table-col dropdown action-label">
                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                '.$status.'
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changeassesmentstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeassesmentstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('assesment-all'); 
                    $edit_permission = $this->checkPermissions('assesment-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editassesment',$row->id).'">Edit</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editassesment',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','allowed_operation','action'])
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
        $check_all_permission = $this->checkPermissions('assesment-all');
        $check_read_permission = $this->checkPermissions('assesment-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('assesment-write');
            $edit_permission = $this->checkPermissions('assesment-edit');
            $delete_permission = $this->checkPermissions('assesment-delete');
          return view('assesment.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        
        $check_all_permission = $this->checkPermissions('assesment-all'); 
        $check_create_permission = $this->checkPermissions('assesment-write');
        if($check_create_permission == true || $check_all_permission == true){
            return view('assesment.add');
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
        ], 
        [
            'name.required' => 'Name is required',
        ]);

        Assesment::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'status' => $request->status,
            'allowed_operation' => $request->allowed_operation,
            'is_rubric' => $request->is_rubric,
            'allow_change_cms' => $request->allow_change_cms,
            'cms_value' => $request->cms_value,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('manageassesment')->with('success','Data Added Successfully');
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
        $assesment = Assesment::findOrFail($id);

        return view('assesment.edit',compact('assesment'));
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
            'short_name' => $request->short_name,
            'status' => $request->status,
            'allowed_operation' => $request->allowed_operation,
            'is_rubric' => $request->is_rubric,
            'allow_change_cms' => $request->allow_change_cms,
            'cms_value' => $request->cms_value,
        );
        Assesment::whereid($request->id)->update($update_data);
        return redirect()->route('manageassesment')->with('success','Data Updated Successfully');
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
        Assesment::whereid($id)->delete();
        return redirect()->route('manageassesment')->with('error','Data Deleted Successfully');
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
        Assesment::whereid($id)->update($update_data);
        return redirect()->route('manageassesment');
    }
    
    
}