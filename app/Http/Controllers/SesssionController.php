<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Campus;
use App\Models\Sesssion;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class SesssionController extends Controller
{
    
    use TraitFunctions;
    public function getSesssions(Request $request)
    {
        if ($request->ajax()) {
            $data = Sesssion::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('duration', function($row){
                    $s_year = date('M/Y', strtotime($row->start_date));
                    $e_year = date('M/Y', strtotime($row->end_date));
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changesessionstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changesessionstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('session-all'); 
                    $edit_permission = $this->checkPermissions('session-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editsession',$row->id).'">Edit</a>';
                    }

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
        $check_all_permission = $this->checkPermissions('session-all');
        $check_read_permission = $this->checkPermissions('session-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('session-write');
            $edit_permission = $this->checkPermissions('session-edit');
            $delete_permission = $this->checkPermissions('session-delete');
          return view('sesssion.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        
        $check_all_permission = $this->checkPermissions('session-all'); 
        $check_create_permission = $this->checkPermissions('session-write');
        if($check_create_permission == true || $check_all_permission == true){
            return view('sesssion.add');
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
            'title' => 'required',
        ], 
        [
            'title.required' => 'Title is required',
        ]);

        $newEntry = Sesssion::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'title' => $request->title,
            'status' => $request->status,
            'type' => $request->type,
            'created_by' => Auth::user()->id,
        ]);

        if ($newEntry->status == 1) {
            Sesssion::where('id', '!=', $newEntry->id)->update(['status' => 0]);
        }

        return redirect()->route('managesession')->with('success','Data Added Successfully');
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
        $sesssion = Sesssion::findOrFail($id);
        return view('sesssion.edit',compact('sesssion'));
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
        $update_data = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'title' => $request->title,
            'status' => $request->status,
            'type' => $request->type,
        ];
        Sesssion::where('id', $request->id)->update($update_data);
        $newEntry = Sesssion::find($request->id);
        if ($newEntry->status == 1) {
            Sesssion::where('id', '!=', $newEntry->id)->update(['status' => 0]);
        }
        
        return redirect()->route('managesession')->with('success','Data Updated Successfully');
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
        Sesssion::whereid($id)->delete();
        return redirect()->route('managesession')->with('error','Data Deleted Successfully');
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
        $newEntry = Sesssion::whereid($id)->update($update_data);
        if ($newEntry->status == 1) {
            Sesssion::where('id', '!=', $newEntry->id)->update(['status' => 0]);
        }
        return redirect()->route('managesession');
    }
}
