<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cirriculum;
use App\Models\Institute;
use App\Models\Faculty;
use App\Models\Sesssion;
use App\Models\CirriculumCourse;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class CirriculumController extends Controller
{
    use TraitFunctions;
    public function getCirriculums(Request $request)
    {
        if ($request->ajax()) {
            // $data = Cirriculum::with(['institute','program'])->where('active_session_id',$sesssion->id)->latest()->get();
            $sesssion = '';
            if(session()->has('session_key')) {
                $sessionId = session('session_key');
                $sesssion = Sesssion::whereid($sessionId)->first();
            }else{
                $sesssion = Sesssion::select('id','title')->wherestatus('1')->first();
            }
            $user = Auth::user();
            
            $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            if($flag === 'all'){
                $data = $sesssion !== null ? Cirriculum::with(['institute','program'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
            }elseif($flag === 'institute'){
                $cirriculum_ids = $hasFunctionalityPermission['cirriculum_id'];
                $data =  (!empty($cirriculum_ids) && $sesssion !== null) ? Cirriculum::with(['institute','program'])
                    ->where('active_session_id',$sesssion->id)
                    ->whereIn('id', $cirriculum_ids)->latest()->get() :  null; 
            }elseif($flag === 'program'){
               $cirriculum_ids = $hasFunctionalityPermission['cirriculum_id'];
                $data =  (!empty($cirriculum_ids) && $sesssion !== null) ? Cirriculum::with(['institute','program'])
                    ->where('active_session_id',$sesssion->id)
                    ->whereIn('id', $cirriculum_ids)->latest()->get() :  null; 
            }elseif($flag === 'reports_dashboard'){
                $data =  []; 
            }elseif($flag === 'enrolled_course'){
               $cirriculum_ids = $hasFunctionalityPermission['cirriculum_id'];
                $data =  (!empty($cirriculum_ids) && $sesssion !== null) ? Cirriculum::with(['institute','program'])
                    ->where('active_session_id',$sesssion->id)
                    ->whereIn('id', $cirriculum_ids)->latest()->get() :  null; 
            }elseif($flag === 'courseoffering_enrollment'){
               $cirriculum_ids = $hasFunctionalityPermission['cirriculum_id'];
                $data =  (!empty($cirriculum_ids) && $sesssion !== null) ? Cirriculum::with(['institute','program'])
                    ->where('active_session_id',$sesssion->id)
                    ->whereIn('id', $cirriculum_ids)->latest()->get() :  null; 
            }else{
                $data =  []; 
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('institute', function($row){
                    $institute = '';
                    if($row->institute){
                        $institute = $row->institute->name;
                    }else{
                        $institute = '-';
                    }
                    $institute_d = $institute;
                    return $institute_d;
                })
                ->addColumn('program', function($row){
                    $program = '';
                    if($row->program){
                        $program = $row->program->name;
                    }else{
                        $program = '-';
                    }
                    $program_d = $program;
                    return $program_d;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changecirriculumstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changecirriculumstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('cirriculum-all'); 
                    $edit_permission = $this->checkPermissions('cirriculum-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editcirriculum',$row->id).'">Edit</a>
                        <a class="btn btn-danger btn-sm" href="'.route('coursecirriculum',$row->id).'">Add Course</a>
                        <a class="btn btn-primary btn-sm" href="'.route('viewcoursecirriculum',$row->id).'">View</a>';
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editcirriculum',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                         <a class="dropdown-item" href="'.route('coursecirriculum',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Add Course in Cirriculum </a>
                    //                         <a class="dropdown-item" href="'.route('viewcoursecirriculum',$row->id).'"><i class="fa fa-pencil m-r-5"></i> View Course Cirriculum </a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['institute','program','status','action'])
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
        $check_all_permission = $this->checkPermissions('cirriculum-all');
        $check_read_permission = $this->checkPermissions('cirriculum-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('cirriculum-write');
            $edit_permission = $this->checkPermissions('cirriculum-edit');
            $delete_permission = $this->checkPermissions('cirriculum-delete');
            return view('cirriculum.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('cirriculum-all'); 
        $check_create_permission = $this->checkPermissions('cirriculum-write');
        if($check_create_permission == true || $check_all_permission == true){
            
            $institute = Institute::select('id','name')->wherestatus(1)->get();
            $sesssion = '';
            if(session()->has('session_key')) {
                $sessionId = session('session_key');
                $sesssion = Sesssion::select('id','title')->whereid($sessionId)->get();
            }else{
                $sesssion = Sesssion::select('id','title')->wherestatus('1')->get();
            }
            return view('cirriculum.add',compact('institute','sesssion'));
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
            'active_session_id' => 'required',
        ], 
        [
            'name.required' => 'Organization Name is required',
            'active_session_id.required' => 'Active Session Required',
        ]);

        Cirriculum::create([
            'name' => $request->name,
            'active_session_id' => $request->active_session_id,
            'description' => $request->description,
            'institute_id' => $request->institute_id,
            'program_id' => $request->program_id,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('managecirriculum')->with('success','Data Added Successfully');
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
        
        $cirriculum = Cirriculum::with(['program'=>function($query) {
            return $query->select(['id', 'name']);
        },'institute' =>function($query) {
            return $query->select(['id', 'name']);
        }])->whereid($id)->get();
        $cirriculum = $cirriculum[0];
        
        $institute = Institute::select('id','name')->wherestatus(1)->get();
        $sesssion = '';
        if(session()->has('session_key')) {
            $sessionId = session('session_key');
            $sesssion = Sesssion::select('id','title')->whereid($sessionId)->get();
        }else{
            $sesssion = Sesssion::select('id','title')->wherestatus('1')->get();
        }
        return view('cirriculum.edit',compact('cirriculum','institute','sesssion'));
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
            'institute_id' => $request->institute_id,
            'active_session_id' => $request->active_session_id,
            'program_id' => $request->program_id,
            'status' => $request->status,
        );
        Cirriculum::whereid($request->id)->update($update_data);
        return redirect()->route('managecirriculum')->with('success','Data Updated Successfully');
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
        Cirriculum::whereid($id)->delete();
        return redirect()->route('managecirriculum')->with('error','Data Deleted Successfully');
    } 
    
    public function removeCourseCirriculum()
    {
        $id = $_REQUEST['id'];
        CirriculumCourse::whereid($id)->delete();
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
        Cirriculum::whereid($id)->update($update_data);
        return redirect()->route('managecirriculum');
    }

    public function courseCirriculum($id){

        $cirriculum = Cirriculum::with(['program'=>function($query) {
            return $query->select(['id', 'name']);
        },'institute' =>function($query) {
            return $query->select(['id', 'name']);
        }])->whereid($id)->first();
        $courses_id = CirriculumCourse::wherecirriculum_id($id)->pluck('course_id');
        $course = Course::whereNotIn('id', $courses_id)->whereprogram_id($cirriculum->program->id)->latest()->get();


        $cirriculum_course = CirriculumCourse::wherecirriculum_id($id)->groupBy('semester')->pluck('semester');
        $CirriculumCourseObject = new CirriculumCourse();

        return view('cirriculum.addcourseincirriculum',compact('id','cirriculum_course','CirriculumCourseObject','cirriculum','course'));
    }

    public function viewCourseCirriculum($id){

        // $cirriculum_course = CirriculumCourse::with(['cirriculum','course'])->wherecirriculum_id($id)->get();
        $cirriculum_course = CirriculumCourse::wherecirriculum_id($id)->groupBy('semester')->pluck('semester');
        $CirriculumCourseObject = new CirriculumCourse();
        // echo "<pre>";
        // print_r($cirriculum_course);
        // die();
        return view('cirriculum.viewcourseincirriculum',compact('id','cirriculum_course','CirriculumCourseObject'));
    }

    public function addCourseCirriculum(){
        $semester = $_REQUEST['semester'];
        $courses_values = $_REQUEST['courses_values'];
        $cirriculum_id = $_REQUEST['cirriculum_id'];
        $courses = explode(',', $courses_values);

        foreach($courses as $cou){
            $course_id = trim($cou,"abc");
            CirriculumCourse::create([
                'course_id' => $course_id,
                'semester' => $semester,
                'cirriculum_id' => $cirriculum_id,
                'status' => '1',
                'created_by' => Auth::user()->id,
            ]);
        }
        
    }
}
