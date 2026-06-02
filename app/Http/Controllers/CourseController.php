<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\CLO;
use App\Models\CourseSection;
use App\Models\Department;
use App\Models\Institute;
use App\Models\Program;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    use TraitFunctions;
    public function getCourses(Request $request)
    {
        // if ($request->ajax()) {
            $user = Auth::user();
          
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            
            // echo "<pre>";
            // print_r($hasFunctionalityPermission['course_ids']);
            // die();
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            if($flag === 'all'){
                $data = Course::with(['program'])->wherestatus(1)->latest()->get();
                
            // echo "<pre>";
            // print_r($data);
            // die();
            }elseif($flag === 'institute'){
                $course_ids = $hasFunctionalityPermission['course_ids'];
                $data =  (!empty($course_ids)) ? Course::with(['program'])->whereIn('id', $course_ids)->latest()->get() :  null; 
            }elseif($flag === 'program'){
                $course_ids = $hasFunctionalityPermission['course_ids'];
                $data =  (!empty($course_ids)) ? Course::with(['program'])->whereIn('id', $course_ids)->latest()->get() :  null; 
            }elseif($flag === 'reports_dashboard'){
                $data =  [];
            }elseif($flag === 'enrolled_course'){
                $course_ids = $hasFunctionalityPermission['course_ids'];
                $data =  (!empty($course_ids)) ? Course::with(['program'])->whereIn('id', $course_ids)->latest()->get() :  null; 
            }elseif($flag === 'courseoffering_enrollment'){
                $data =  [];
            }else{
                $data =  [];
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('program', function($row){
                    $program = '';
                    $i = "'";
                    if($row->program){
                        $program = $row->program->name;
                    }else{
                        $program = '-';
                    }
                    $programlabel = $program;
                    return $programlabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changecoursestatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changecoursestatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('course-all'); 
                    $edit_permission = $this->checkPermissions('course-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<div class="text-right">
                            <a class="btn btn-success btn-sm" href="'.route('editcourse',$row->id).'">Edit</a>
                            </div>';
                    }
                        return $actionBtn;
                        // <a class="btn btn-primary btn-sm" href="'.route('showcourse',$row->id).'">View</a>
                })
                ->rawColumns(['program','status','action'])
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
        $check_all_permission = $this->checkPermissions('course-all');
        $check_read_permission = $this->checkPermissions('course-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('course-write');
            $edit_permission = $this->checkPermissions('course-edit');
            $delete_permission = $this->checkPermissions('course-delete');
            $courses = Course::all();
          return view('courses.manage',compact('courses','write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('course-all'); 
        $check_create_permission = $this->checkPermissions('course-write');
        if($check_create_permission == true || $check_all_permission == true){  
            $user = Auth::user();
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            $program_id = $hasFunctionalityPermission['program_id'] ?? [];
    
            if($program_id){
                $program = Program::select('id','name')->whereIn('id',$program_id)->wherestatus(1)->get();
            }else{
                $program = Program::select('id','name')->wherestatus(1)->get();
            }
            // $program = Program::select('id','name')->wherestatus(1)->get();
            $institute = Institute::select('id','name')->wherestatus(1)->get();
            return view('courses.add',compact('institute','program'));
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
            // 'code' => 'required|unique:courses',
            'code' => 'required',
            'course_level' => 'required',
            'delivery_format' => 'required',
            'obe_mapping' => 'required',
            'based_type' => 'required',
            'program_id' => 'required',
        ], 
        [
            'name.required' => 'Course Name is required',
            'code.required' => 'Course Code is required',
            'course_level.required' => 'Course Level is required',
            'delivery_format.required' => 'Course Delivery Format is required',
            'obe_mapping.required' => 'OBE Mapping is required',
            'based_type.required' => 'Based Type is required',
            'program_id.required' => 'Program is required',
        ]);

        Course::create([
            'code' => $request->code,
            'delivery_format' => $request->delivery_format,
            'theory' => $request->theory,
            'lab' => $request->lab,
            'tutorial' => $request->tutorial,
            'obe_mapping' => $request->obe_mapping,
            'program_id' => $request->program_id,
            // 'institute_id' => $request->institute_id,
            // 'department_id' => $request->department_id,
            'name' => $request->name,
            'course_level' => $request->course_level,
            'based_type' => $request->based_type,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('managecourse')->with('success','Data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with([ 'institute'])->whereid($id)->latest()->first();
        // $course = $cs[0];
        return view('courses.view',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        $program = Program::select('id','name')->wherestatus(1)->get();
        $institute = Institute::select('id','name')->wherestatus(1)->get();
        return view('courses.edit',compact('course','institute','program'));
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
            'code' => $request->code,
            'delivery_format' => $request->delivery_format,
            'theory' => $request->theory,
            'lab' => $request->lab,
            'tutorial' => $request->tutorial,
            'obe_mapping' => $request->obe_mapping,
            'program_id' => $request->program_id,
            // 'department_id' => $request->department_id,
            // 'institute_id' => $request->institute_id,
            'name' => $request->name,
            'course_level' => $request->course_level,
            'based_type' => $request->based_type,
            'description' => $request->description,
            'status' => $request->status,
        );
        Course::whereid($request->id)->update($update_data);
        return redirect()->route('managecourse')->with('success','Data Updated Successfully');
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
        Course::whereid($id)->delete();
        return redirect()->route('managecourse')->with('error','Data Deleted Successfully');
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
        Course::whereid($id)->update($update_data);
        return redirect()->route('managecourse');
    }

    public function showClo($id)
    {

        $courseclo = CLO::with(['course'])->wherecourse_id($id)->latest()->get();
        return view('courses.manageclo',compact('id','courseclo'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCourseClo($id)
    { 
        return view('courses.addclo',compact('id'));  
    }

    public function storeCourseClo(Request $request){

        $request->validate([
            'code' => 'required',
            'description' => 'required',
        ], 
        [
            'code.required' => 'Course Code is required',
            'description.required' => 'Course Name is required',
        ]);
        CLO::create([
            'code' => $request->code,
            'name' => $request->name,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('showclo',$request->course_id)->with('success','Data Added Successfully');
    }
}
