<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Faculty;
use App\Models\Campus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class FacultyController extends Controller
{
    use TraitFunctions;
    public function getFacultys(Request $request)
    {
        if ($request->ajax()) {
            // $data = Faculty::latest()->get();
            $data = Faculty::with(['campus'=>function($query) {
                return $query->select(['id', 'name']);
            }])->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('campus', function($row){
                    $campus = '';
                    $i = "'";
                    if($row->campus){
                        $campus = $row->campus->name;
                    }else{
                        $campus = '-';
                    }
                    $campuslabel = $campus;
                    return $campuslabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changefacultystatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changefacultystatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('faculty-all'); 
                    $edit_permission = $this->checkPermissions('faculty-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editfaculty',$row->id).'">Edit</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editfaculty',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','action','campus'])
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
        $check_all_permission = $this->checkPermissions('faculty-all');
        $check_read_permission = $this->checkPermissions('faculty-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('faculty-write');
            $edit_permission = $this->checkPermissions('faculty-edit');
            $delete_permission = $this->checkPermissions('faculty-delete');
          return view('faculty.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('faculty-all'); 
        $check_create_permission = $this->checkPermissions('faculty-write');
        if($check_create_permission == true || $check_all_permission == true){
            $campuses = Campus::select('id','name')->wherestatus(1)->get();
            return view('faculty.add',compact('campuses'));
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
            'name.required' => 'Organization Name is required',
        ]);

        Faculty::create([
            'name' => $request->name,
            'description' => $request->description,
            'campus_id' => $request->campus_id,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('managefaculty')->with('success','Data Added Successfully');
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
        $faculty = Faculty::find($id);
        $campuses = Campus::select('id','name')->wherestatus(1)->get();
        return view('faculty.edit',compact('faculty', 'campuses'));
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
            'campus_id' => $request->campus_id,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'status' => $request->status,
        );
        Faculty::whereid($request->id)->update($update_data);
        return redirect()->route('managefaculty')->with('success','Data Updated Successfully');
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
        Faculty::whereid($id)->delete();
        return redirect()->route('managefaculty')->with('error','Data Deleted Successfully');
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
        Faculty::whereid($id)->update($update_data);
        return redirect()->route('managefaculty');
    }
}
