<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AcedemicYear;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class AcedemicController extends Controller
{
    // testing 1
    use TraitFunctions;
    public function getAcedemicYear(Request $request)
    {
        if ($request->ajax()) {
            $data = AcedemicYear::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('duration', function($row){
                    $s_year = date('Y', strtotime($row->start_date));
                    $e_year = date('Y', strtotime($row->end_date));
                    $duration = $s_year .' - '. $e_year;
                    return $duration;
                })
                ->addColumn('type', function($row){
                    $type = '';
                    if($row->type == 'f'){
                        $type = 'Fall';
                    }else if($row->type == 's'){
                        $type = 'Spring';
                    }else{
                        $type = '-';
                    }
                    $typelabel = $type;
                    return $typelabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changeacedemicyearstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeacedemicyearstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){


                    $check_all_permission = $this->checkPermissions('campus-all'); 
                    $edit_permission = $this->checkPermissions('campus-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                    
                    }
                    $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editacedemicyear',$row->id).'">Edit</a>';
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editacedemicyear',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','duration','type','action'])
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
        $check_all_permission = $this->checkPermissions('acedemicyear-all');
        $check_read_permission = $this->checkPermissions('acedemicyear-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('acedemicyear-write');
            $edit_permission = $this->checkPermissions('acedemicyear-edit');
            $delete_permission = $this->checkPermissions('acedemicyear-delete');
          return view('acedemicyear.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        
        $check_all_permission = $this->checkPermissions('acedemicyear-all'); 
        $check_create_permission = $this->checkPermissions('acedemicyear-write');
        if($check_create_permission == true || $check_all_permission == true){
            return view('acedemicyear.add');
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
            'name.required' => 'Acedemic Year  is required',
        ]);

        AcedemicYear::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'name' => $request->name,
            'status' => $request->status,
            'type' => $request->type,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('manageacedemicyear')->with('success','Data Added Successfully');
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
        $acedemicyear = AcedemicYear::findOrFail($id);
        return view('acedemicyear.edit',compact('acedemicyear'));
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
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'name' => $request->name,
            'status' => $request->status,
            'type' => $request->type,
        );
        AcedemicYear::whereid($request->id)->update($update_data);
        return redirect()->route('manageacedemicyear')->with('success','Data Updated Successfully');
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
        AcedemicYear::whereid($id)->delete();
        return redirect()->route('manageacedemicyear')->with('error','Data Deleted Successfully');
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
        AcedemicYear::whereid($id)->update($update_data);
        return redirect()->route('manageacedemicyear');
    }
}