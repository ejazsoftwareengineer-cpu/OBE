<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Program;
use App\Models\Campus;
use App\Models\Institute;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class ProgramController extends Controller
{
    use TraitFunctions;

    public function getPrograms(Request $request)
    {
        // if ($request->ajax()) {
            $user = Auth::user();
            
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            // echo "<pre>";
            // print_r($hasFunctionalityPermission);
            // die();
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;



            $institute_id = $hasFunctionalityPermission['institute_id'] ?? '';
            if($flag === 'all'){
                $data = Program::with(['institute'=>function($query) {
                    return $query->select(['id', 'name']);
                }])->wherestatus(1)->latest()->get();
            }elseif($flag === 'institute'){
                $program_ids = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_ids)) ? Program::with(['institute' => function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $program_ids)->latest()->get() :  null; 
            }elseif($flag === 'program'){
                $program_ids = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_ids)) ? Program::with(['institute' => function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $program_ids)->latest()->get() :  null; 
            }elseif($flag === 'reports_dashboard'){
                $data =  [];
            }elseif($flag === 'enrolled_course'){
                $program_ids = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_ids)) ? Program::with(['institute' => function($query) {
                    return $query->select(['id', 'name']);
                }])->whereIn('id', $program_ids)->latest()->get() :  null; 
            }elseif($flag === 'courseoffering_enrollment'){
                $data =  [];
            }else{
                $data =  [];
            }
            //  echo "<pre>";
            // print_r($data);
            // die();

            // $data = Program::with(['institute'=>function($query) {
            //     return $query->select(['id', 'name']);
            // }])->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changeprogramstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeprogramstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('program-all'); 
                    $edit_permission = $this->checkPermissions('program-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editprogram',$row->id).'">Edit</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editprogram',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','action'])
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
        $check_all_permission = $this->checkPermissions('program-all');
        $check_read_permission = $this->checkPermissions('program-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('program-write');
            $edit_permission = $this->checkPermissions('program-edit');
            $delete_permission = $this->checkPermissions('program-delete');
          return view('program.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('program-all'); 
        $check_create_permission = $this->checkPermissions('program-write');
        if($check_create_permission == true || $check_all_permission == true){
            
            $organization = Organization::select('id','name')->wherestatus(1)->get();
            $campus = Campus::select('id','name')->wherestatus(1)->get();
            $institute = Institute::select('id','name')->wherestatus(1)->get();
            return view('program.add',compact('campus','organization','institute'));
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
            'organization_id' => 'required',
            'campus_id' => 'required',
            'institute_id' => 'required|array|min:1',
            'name' => 'required',
            'program_level' => 'required',
            'program_type' => 'required',
            'session_type' => 'required',
            'no_of_session' => 'required'
        ], [
            'organization_id.required' => 'Organization Required',
            'campus_id.required' => 'Campus Required',
            'institute_id.required' => 'Institute Required',
            'name.required' => 'Program Required',
            'program_level.required' => 'Program level Required',
            'program_type.required' => 'Program Format Required',
            'session_type.required' => 'Session Type Required',
            'no_of_session.required' => 'No. Of Session Required'
        ]);

        Program::create([
            'name' => $request->name,
            'organization_id' => $request->organization_id,
            'campus_id' => implode(',', $request->campus_id), // $request->campus_id,
            // Convert array of IDs into a comma-separated string or JSON
            'institute_id' => implode(',', $request->institute_id),
            'no_of_session' => $request->no_of_session,
            'mark_per' => $request->mark_per,
            'assessment_method' => $request->assessment_method,
            'vision' => $request->vision,
            'status' => $request->status,
            'session_type' => $request->session_type,
            'program_level' => $request->program_level,
            'program_type' => $request->program_type,
            'student_per' => $request->student_per,
            'learning_type_category' => $request->learning_type_category,
            'mission' => $request->mission,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('manageprogram')->with('success', 'Data Added Successfully');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'organization_id' => 'required',
    //         'campus_id' => 'required',
    //         'institute_id' => 'required',
    //         'name' => 'required',
    //         'program_level' => 'required',
    //         'program_type' => 'required',
    //         'session_type' => 'required',
    //         'no_of_session' => 'required'
    //     ], 
    //     [
    //         'organization_id.required' => 'Organization Required',
    //         'campus_id.required' => 'Campus Required',
    //         'institute_id.required' => 'Institute Required',
    //         'name.required' => 'Program Required',
    //         'program_level.required' => 'Program level Required',
    //         'program_type.required' => 'Program Format Required',
    //         'session_type.required' => 'Session Type Required',
    //         'no_of_session.required' => 'No. Of Session Required'
    //     ]);

    //     Program::create([
    //         'name' => $request->name,
    //         'organization_id' => $request->organization_id,
    //         'campus_id' => $request->campus_id,
    //         'institute_id' => $request->institute_id,
    //         'no_of_session' => $request->no_of_session,
    //         'mark_per' => $request->mark_per,
    //         'assessment_method' => $request->assessment_method,
    //         'vision' => $request->vision,
    //         'status' => $request->status,
    //         'session_type' => $request->session_type,
    //         'program_level' => $request->program_level,
    //         'program_type' => $request->program_type,
    //         'student_per' => $request->student_per,
    //         'learning_type_category' => $request->learning_type_category,
    //         'mission' => $request->mission,
    //         'description' => $request->description,
    //         'created_by' => Auth::user()->id,
    //     ]);
    //     return redirect()->route('manageprogram')->with('success','Data Added Successfully');
    // }

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
        $program = Program::find($id);
        $organization = Organization::select('id','name')->wherestatus(1)->get();
        $campus = Campus::select('id','name')->wherestatus(1)->get();
        $institute = Institute::select('id','name')->wherestatus(1)->get();
        // return view('program.add',compact('campus','organization','institute'));
        return view('program.edit',compact('program','campus','organization','institute'));
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
            'organization_id' => 'required',
            'campus_id' => 'required',
            'institute_id' => 'required',
            'name' => 'required',
            'program_level' => 'required',
            'program_type' => 'required',
            'session_type' => 'required',
            'no_of_session' => 'required'
        ], 
        [
            'organization_id.required' => 'Organization Required',
            'campus_id.required' => 'Campus Required',
            'institute_id.required' => 'Institute Required',
            'name.required' => 'Program Required',
            'program_level.required' => 'Program level Required',
            'program_type.required' => 'Program Format Required',
            'session_type.required' => 'Session Type Required',
            'no_of_session.required' => 'No. Of Session Required'
        ]);

        $update_data = array(
            'name' => $request->name,
            'organization_id' => $request->organization_id,
            'campus_id' => $request->campus_id,
            'institute_id' => $request->institute_id,
            'no_of_session' => $request->no_of_session,
            'mark_per' => $request->mark_per,
            'assessment_method' => $request->assessment_method,
            'vision' => $request->vision,
            'status' => $request->status,
            'session_type' => $request->session_type,
            'program_level' => $request->program_level,
            'program_type' => $request->program_type,
            'student_per' => $request->student_per,
            'learning_type_category' => $request->learning_type_category,
            'mission' => $request->mission,
            'description' => $request->description,
        );
        Program::whereid($request->id)->update($update_data);
        return redirect()->route('manageprogram')->with('success','Data Updated Successfully');
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
        Program::whereid($id)->delete();
        return redirect()->route('manageprogram')->with('error','Data Deleted Successfully');
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
        Program::whereid($id)->update($update_data);
        return redirect()->route('manageprogram');
    }
}
