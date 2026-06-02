<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CourseSection;
use App\Models\CourseOffer;
use App\Models\CLO;
use App\Models\ProgramBatch;
use App\Models\Program;
use App\Models\StudentAttendance;
use App\Models\ActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\CqiClassActivity;
use App\Models\CqiStudentAssessment;
use App\Models\CqiActivityQuestion;
use App\Models\CqiActivityQuestionRubrics;
use App\Models\EnrollStudent;
use App\Models\Institute;
use App\Models\Role;
use App\Models\Cqi;
use App\Models\CourseOfferPlo;
use App\Models\CourseOfferClo;
use App\Models\CqiStudent;
use App\Models\Sesssion;
use App\Models\User;
use App\Models\Assesment;
use App\Models\StudentCloAttainment;
use App\Models\StudentQuestionAttainment;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\ActivityQuestionRubric;
use App\Models\Student;
use App\Models\PloByCourseSectionClo;
use App\Models\ClassActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;


class CourseOfferingController extends Controller
{

    use TraitFunctions;
    public function getCourseoffers(Request $request)
    {
        // if ($request->ajax()) {

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
            // echo "<pre>";
            // print_r( $sesssion->id);
            // die();
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;

            if($flag === 'all'){
                $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get();
            }elseif($flag === 'institute'){
                $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                $data =  (!empty($courseoffer_ids)) ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->whereIn('id', $courseoffer_ids)->latest()->get() :  null;
            }elseif($flag === 'program'){
                $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                $data =  (!empty($courseoffer_ids)) ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->whereIn('id', $courseoffer_ids)->latest()->get() :  null;
            }elseif($flag === 'reports_dashboard'){
                $data =  [];
            }elseif($flag === 'enrolled_course'){
                $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                // echo "<pre>";
                // print_r($courseoffer_ids);
                // die();
                // // $data =  (!empty($courseoffer_ids)) ? CourseOffer::with(['institute', 'course', 'teacher'])
                // ->where(function ($query) use ($session, $courseoffer_ids, $user) {
                //     $query->where('active_session_id', $session->id)
                //           ->whereIn('id', $courseoffer_ids)
                //           ->orWhere('teacher_id', $user->id);
                // })
                // ->latest()
                // ->get() :  null;
                $data = (!empty($courseoffer_ids)) ?  CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->whereIn('id', $courseoffer_ids)->latest()->get(): CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->where('teacher_id', $user->id)->latest()->get();

                // $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->where('teacher_id', $user->id)->latest()->get();

            }elseif($flag === 'courseoffering_enrollment'){
                $data =  [];
            }else{
                $data =  [];
            }

                // $user = Auth::user();

                // $roleId = session('role_key');
                // $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
                // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
                // if($flag === 'all'){
                //     $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }elseif($flag === 'institute'){
                //     // $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                //     // $data =  (!empty($courseoffer_ids) && $sesssion !== null) ? CourseOffer::with(['institute', 'course','teacher'])
                //     //     ->where('active_session_id',$sesssion->id)
                //     //     ->whereIn('id', $courseoffer_ids)->latest()->get() :  null;
                //         $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }elseif($flag === 'program'){
                //     // $program_ids = $hasFunctionalityPermission['program_id'];
                //     // $data =  (!empty($program_ids)) ? Program::with(['institute' => function($query) {
                //     //     return $query->select(['id', 'name']);
                //     // }])->whereIn('id', $program_ids)->latest()->get() :  null;
                //     $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }elseif($flag === 'reports_dashboard'){
                //      $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }elseif($flag === 'enrolled_course'){
                //      $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }elseif($flag === 'courseoffering_enrollment'){
                //      $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }else{
                //      $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
                // }

            // if ($user && $user->hasRole('super-admin')) {
            //     $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get() : [];
            // }elseif($user && $user->hasRole('teacher')) {
            //     $data = $sesssion !== null ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->where('teacher_id', Auth::user()->id)->latest()->get() : [];
            //     // $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->where('teacher_id', Auth::user()->id)->latest()->get();
            // }else{
            //     $data = [];
            //     // $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$sesssion->id)->latest()->get();
            // }


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
                ->addColumn('teacher', function($row){
                    $teacher = '';
                    if($row->teacher){
                        $teacher = $row->teacher->name;
                    }else{
                        $teacher = '-';
                    }
                    $teacher_d = $teacher;
                    return $teacher_d;
                })
                ->addColumn('course', function($row){
                    $course = '';
                    $i = "'";
                    if($row->course){
                        $course = $row->course->name;
                    }else{
                        $course = '-';
                    }
                    $course_d = $course;
                    return $course_d;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changecourseofferingstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changecourseofferingstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('courseoffering-all');
                    $edit_permission = $this->checkPermissions('courseoffering-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                        $actionBtn = '<div>
                            <a class="btn btn-primary btn-sm" href="'.route('showcourseoffering',$row->id).'">View</a>
                        </div>';
                    }


                    // <a class="btn btn-success btn-sm" href="'.route('editcourseoffering',$row->id).'">Edit</a>
                    return $actionBtn;
                })
                ->rawColumns(['institute','teacher','course','status','action'])
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
        $check_all_permission = $this->checkPermissions('courseoffering-all');
        $check_read_permission = $this->checkPermissions('courseoffering-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('courseoffering-write');
            $edit_permission = $this->checkPermissions('courseoffering-edit');
            $delete_permission = $this->checkPermissions('courseoffering-delete');
          return view('courseoffering.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('courseoffering-all');
        $check_create_permission = $this->checkPermissions('courseoffering-write');
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
                $users = User::select('id', 'name', 'role_id')->get();
            }else{
                $institute = Institute::select('id','name')->whereIn('id', $institute_id)->wherestatus(1)->get();
                $users = User::select('id', 'name', 'role_id')->whereIn('institute_id', $institute_id)->get();
                // $institute = Institute::select('id','name')->whereid($institute_id)->wherestatus(1)->get();
                // $users = User::select('id', 'name', 'role_id')->whereinstitute_id($institute_id)->get();
            }

            $courses = Course::select('id','code','name')->wherestatus(1)->get();
            // $program_batch = ProgramBatch::select('id','name')->wherestatus(1)->get();
            $sesssion = '';
            if(session()->has('session_key')) {
                $sessionId = session('session_key');
                $sesssion = Sesssion::select('id','title')->whereid($sessionId)->get();
            }else{
                $sesssion = Sesssion::select('id','title')->wherestatus('1')->get();
            }
            // $clos = CLO::select('id','code')->wherestatus(1)->get();
            $teacherroleid = Role::select('id')->whereguard_name('teacher')->first();
            // $users = User::select('id', 'name', 'role_id')->whereinstitute_id($institute_id)->get();

            $teachers = $users->filter(function ($user) {
                $roles = json_decode($user->role_id, true);
                return is_array($roles) && in_array(5, $roles);
            });
            // $teachers = User::select('id','name')
            // ->whereRaw("JSON_CONTAINS(role_id, '5')")
            // ->get();
            // ->whereJsonContains('role_id', $teacherroleid->id)
            // echo "<pre>";
            // print_r($teachers);
            // die();
            // ->whererole_id($teacherroleid->id)

            return view('courseoffering.add',compact('sesssion','institute','courses','teachers'));
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
            'course_name' => 'required',
            'active_session_id' => 'required',
            'teacher_id' => 'required',
        ],
        [
            'course_name.required' => 'Course Name is required',
            'active_session_id.required' => 'Active Session Required',
            'teacher_id.required' => 'Teacher Required',
        ]);
        $clos = CLO::where('course_id',$request->course_id)->wherestatus(1)->get();
        $plos = PloByCourseSectionClo::whereprogram_id($request->program_id)->wherecourse_id($request->course_id)->get();
        if($plos->isEmpty()){
            return redirect()->route('managecourseoffering')->with('error','PLO not defined BY selected course.');
        }
        if(!$clos->isEmpty()){
            $courseoffer = CourseOffer::create([
                'active_session_id' => $request->active_session_id,
                'institute_id' => $request->institute_id,
                'program_id' => $request->program_id,
                'cirriculum_id' => $request->cirriculum_id,
                'semester' => $request->semester,
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,
                'status' => $request->status,
                'course_status' => $request->course_status,
                'gender' => $request->gender,
                'name' => $request->name,
                'section' => $request->section,
                'mark_per' => $request->mark_per,
                'student_per' => $request->student_per,
                'available_seats' => $request->available_seats,
                'office_hours' => $request->office_hours,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ]);

            $clos = CLO::where('course_id',$request->course_id)->wherestatus(1)->get();

            if(!$clos->isEmpty()){
                foreach($clos as $clo){
                    if($clo->course_id && $clo->id){
                        $courseoffer_clo = new CourseOfferClo();
                        $courseoffer_clo->code = $clo->code;
                        $courseoffer_clo->name = $clo->name;
                        $courseoffer_clo->description = $clo->description;
                        $courseoffer_clo->course_id = $clo->course_id;
                        $courseoffer_clo->courseoffer_id = $courseoffer->id;
                        $courseoffer_clo->domain = $clo->domain;
                        $courseoffer_clo->emphasis_level = $clo->emphasis_level;
                        $courseoffer_clo->weight = $clo->weight;
                        $courseoffer_clo->level = $clo->level;
                        $courseoffer_clo->save();

                        $plos = PloByCourseSectionClo::whereprogram_id($request->program_id)->whereclo_id($clo->id)->wherecourse_id($clo->course_id)->first();

                        $plo_courseoffer = new CourseOfferPlo();
                        $plo_courseoffer->clo_id = $courseoffer_clo->id;
                        $plo_courseoffer->course_id = $plos->course_id;
                        $plo_courseoffer->course_section_id = $courseoffer->id;
                        $plo_courseoffer->plo_id = $plos->plo_id;
                        $plo_courseoffer->save();

                    }

                }
            }else{
                return redirect()->route('managecourseoffering')->with('error','CLO & PLO not defined BY selected course.');
            }
            // $plos = PloByCourseSectionClo::whereprogram_id($request->program_id)->wherecourse_id($clo->course_id)->get();
            // if(!$plos->isEmpty()){
            //     foreach($plos as $plo){
            //         $plo_courseoffer = new CourseOfferPlo();
            //         $plo_courseoffer->clo_id = $plo->id;
            //         $plo_courseoffer->course_id = $plo->course_id;
            //         $plo_courseoffer->course_section_id = $courseoffer->id;
            //         $plo_courseoffer->plo_id = $plo->plo_id;
            //         $plo_courseoffer->save();
            //     }
            // }else{
            //     return redirect()->route('managecourseoffering')->with('error','PLO not defined BY selected course.');
            // }
        }else{
            return redirect()->route('managecourseoffering')->with('error','CLO not defined BY selected course.');
        }


        return redirect()->route('managecourseoffering')->with('success','Data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cs = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->get();
        $course_offering = $cs[0];
        return view('courseoffering.view',compact('course_offering'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $cirriculumcourse = CirriculumCourse::select('id','name')->wherestatus(1)->get();
        $courseoffering= CourseOffer::find($id);
        $institute = Institute::select('id','name')->wherestatus(1)->get();
        $program = Program::select('id','name')->wherestatus(1)->get();
        $cirriculum = Cirriculum::select('id','name')->wherestatus(1)->get();
        $courses = Course::select('id','code','name')->wherestatus(1)->get();
        // $clos = CLO::select('id','code')->wherestatus(1)->get();
        $teachers = User::select('id','name')->whereusertype_id(1)->get();

        return view('courseoffering.edit',compact('teachers','institute','program','cirriculum','cirriculumcourse','courseoffering','courses'));
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
            'active_session_id' => $request->active_session_id,
            'institute_id' => $request->institute_id,
            'program_id' => $request->program_id,
            'cirriculum_id' => $request->cirriculum_id,
            'semester' => $request->semester,
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
            'course_status' => $request->course_status,
            'gender' => $request->gender,
            'name' => $request->name,
            'section' => $request->section,
            'mark_per' => $request->mark_per,
            'student_per' => $request->student_per,
            'available_seats' => $request->available_seats,
            'office_hours' => $request->office_hours,
            'description' => $request->description,
        );
        CourseOffer::whereid($request->id)->update($update_data);
        return redirect()->route('managecourseoffering')->with('success','Data Updated Successfully');
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
        CourseOffer::whereid($id)->delete();
        return redirect()->route('managecourseoffering')->with('error','Data Deleted Successfully');
    }

    public function destroyClassActivity()
    {
        $id = $_REQUEST['id'];
        ClassActivity::whereid($id)->delete();
        ActivityQuestion::whereactivity_id($id)->delete();
    }

    public function destroyQuestion()
    {
        $id = $_REQUEST['id'];
        ActivityQuestion::whereid($id)->delete();
    }
    public function destroyenrolledstudent()
    {
        $id = $_REQUEST['id'];
        EnrollStudent::whereid($id)->delete();
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
        CourseOffer::whereid($id)->update($update_data);
        return redirect()->route('managecourseoffering');
    }

    public function showCourseOfferingActivities($id)
    {
        $class_activity = ClassActivity::with(['assesment'])->wherecourse_section_id($id)->get();
        $assesment = Assesment::select('*')->wherestatus(1)->get();
        $course_ids = CourseOffer::select('id','course_id')->whereid($id)->get();
        $course_id = null;
        if ($course_ids->isEmpty()) {
            $course_id = null;
        } else {
            $course_id = $course_ids[0]->course_id;
        }
        $clos = CourseOfferClo::select('id','code')->wherecourseoffer_id($id)->get();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
        $activityquestion = new ActivityQuestion();

        return view('courseoffering.classactivities',compact('id','course_offering','assesment','course_id','clos' ,'class_activity','activityquestion'));
    }

    public function showCourseOfferingActivitiesQuestion($id)
    {
        $activity_question = ActivityQuestion::with('clo')->whereactivity_id($id)->get();
        $activity_question_count = ActivityQuestion::select('*')->whereactivity_id($id)->count();
        $class_activity = ClassActivity::with(['assesment'])->whereid($id)->get();
        $section_id = $class_activity[0]->course_section_id;
        $course_section = CourseOffer::select('*')->whereid($section_id)->get();
        $course_id = $course_section[0]->course_id;
        $clos = CourseOfferClo::select('id','code','weight','description')->wherecourseoffer_id($section_id)->get();

        return view('courseoffering.addquestion',compact('id','clos','activity_question','class_activity','course_section','activity_question_count'));
    }

    public function showcourseOfferingClo($id)
    {
        $course_id = CourseOffer::select('id','course_id')->whereid($id)->get();
        $course_id = $course_id[0]->course_id;
        $courseclo = CLO::with(['course'])->wherecourse_id($course_id)->latest()->get();

        return view('courseoffering.clolisting',compact('id','courseclo'));
    }

    public function getActivityAndQuestions(Request $request)
    {
        $activity = ClassActivity::with(['assesment', 'activityQuestions.activityQuestionRubrics'])
        ->where('id', $request->id)
        ->latest()
        ->first();

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        foreach ($activity->activityQuestions as $question) {
            // $cloIds = explode(',', $question->clo_id);
            $cloIds = $question->clo_id;
            $cloRecords = CourseOfferClo::where('id', $cloIds)->get();
            $question->setAttribute('cloRecords', $cloRecords);
        }

        $assesment = Assesment::select('*')->wherestatus(1)->get();

        $html = view('courseoffering.viewactivityquestionmodal',
            [
            'assesment' => $assesment,
            'activity' => $activity,
            ]
        )->render();

        return response()->json(['html' => $html]);
        // return response()->json(['activity' => $activity]);
    }
    public function getEditActivityView(Request $request)
    {
        $activity = ClassActivity::with(['assesment', 'activityQuestions.activityQuestionRubrics'])
        ->where('id', $request->id)
        ->latest()
        ->first();

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }


        $assesment = Assesment::select('*')->wherestatus(1)->get();

        $html = view('courseoffering.editactivitymodal',
            [
            'assesment' => $assesment,
            'activity' => $activity,
            ]
        )->render();

        return response()->json(['html' => $html]);
    }
    public function getEditActivityQuestionView(Request $request)
    {
        // $activity = ClassActivity::with(['assesment', 'activityQuestions.activityQuestionRubrics'])
        // ->where('id', $request->id)
        // ->latest()
        // ->first();
        $question = ActivityQuestion::with(['clo','courseoffer:id','classActivity:id','activityQuestionRubrics'])->where('id', $request->id)->first();

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }


        $clos = CourseOfferClo::select('id','code')->wherecourseoffer_id($question->courseoffer->id)->get();

        $html = view('courseoffering.editactivityquestionmodal',
            [
            'clos' => $clos,
            'question' => $question,
            ]
        )->render();

        return response()->json(['html' => $html]);
    }

    public function showCourseOfferingStudent($id)
    {
        $user = Auth::user();
        $roleId = session('role_key');
        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
        // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
        $program_id = $hasFunctionalityPermission['program_id'] ?? [];

        if($program_id){
            $programs = Program::select('id','name')->whereIn('id',$program_id)->wherestatus(1)->get();
        }else{
            $programs = Program::select('id','name')->wherestatus(1)->get();
        }

        $students = Student::select('id','roll_no','name')->wherestatus(1)->get();
        $enrolled_students = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

        // $programs = Program::select('id','name')->wherestatus(1)->get();
        $session = Sesssion::select('id','title')->get();

        return view('courseoffering.students.enrollstudents',compact('id','course_offering','students','enrolled_students','programs','session'));

    }

    public function mapCourseOfferingPlo($id,$courseoffering,$course)
    {
        $program = Program::select('id','name')->get();
        return view('courseoffering.mapplo',compact('id','courseoffering','course','program'));
    }

    public function storePloByClo(Request $request)
    {
        $request->validate([
            'clo_id' => 'required',
        ]);
        $level = '';
        if($request->domain === '1'){
            $level = $request->level2;
        }else if($request->domain === '2'){
            $level = $request->level3;
        }else if($request->domain === '3'){
            $level = $request->leve4;
        }else{
            $level = 0;
        }
        PloByCourseSectionClo::create([
            'clo_id' => $request->clo_id,
            'course_id' => $request->course_id,
            'course_section_id' => $request->course_section_id,
            'program_id' => $request->program_id,
            'domain' => $request->domain,
            'emphasis_level' => $request->emphasis_level,
            'plo_id' => $request->plo_id,
            'level' => $level,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('showcourseofferingclo',$request->course_section_id)->with('success','Data Added Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function storeActivities(Request $request){
        $request->validate([
            'assesment_name' => 'required',
        ],
        [
            'assesment_name.required' => 'Name is required',
        ]);

        ClassActivity::create([
            'assesment_id' => $request->assesment_id,
            'course_id' => $request->course_id,
            'course_section_id' => $request->course_section_id,
            'assesment_name' => $request->assesment_name,
            'assesment_date' => $request->assesment_date,
            // 'assesment_total_mark' => $request->assesment_total_mark,
            'assesment_gpa_weight' => $request->assesment_gpa_weight,
            'complex_engineering_problem' => $request->complex_engineering_problem,
            'gpa_calculation' => $request->gpa_calculation,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('showcourseofferingactivities',$request->course_section_id)->with('success','Data Added Successfully');

    }

    public function updateClassActivity(Request $request)
    {

        $update_data = array(
            'assesment_id' => $request->assesment_id,
            'course_id' => $request->course_id,
            'course_section_id' => $request->course_section_id,
            'assesment_name' => $request->assesment_name,
            'assesment_date' => $request->assesment_date,
            // 'assesment_total_mark' => $request->assesment_total_mark,
            'assesment_gpa_weight' => $request->assesment_gpa_weight,
        );
        ClassActivity::whereid($request->id)->update($update_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function storeActivitiesQuestion(Request $request){
        $request->validate([
            'name' => 'required',
            'obe_weight' => 'required',
            'clo_id' => 'required',
            'max_mark' => 'required',
        ],
        [
            'name.required' => 'Name is required',
            'clo_id.required' => "Select CLO's",
            'obe_weight.required' => "OBE Weight Required",
            'max_mark.required' => "Question Total Marks Required",
        ]);

        $question = ActivityQuestion::create([
            'activity_id' => $request->activity_id,
            'question_name' => $request->activity_question_count,
            'name' => $request->name,
            'answer' => $request->answer,
            'courseoffer_id' => $request->courseoffer_id,
            'clo_id' => $request->clo_id,
            // 'clo_id' => implode(',',$request->clo_id),
            'complexity' => $request->complexity,
            'question' => $request->question,
            'max_mark' => $request->max_mark,
            'obe_weight' => $request->obe_weight,
            'guidline' => $request->guidline,
            'choices' => $request->choices,
            'not_for_obe' => $request->not_for_obe,
            'created_by' => Auth::user()->id,
        ]);

        $questionCount = 1;
        while ($request->filled("question_complexity_scale_1_row_$questionCount")) {
            $rubricquestion = new ActivityQuestionRubric();
            $rubricquestion->question_id = $question->id;
            $rubricquestion->activity_id = $request->activity_id;
            $rubricquestion->scale_1 = $request->input("question_complexity_scale_1_row_$questionCount");
            $rubricquestion->scale_2 = $request->input("question_complexity_scale_2_row_$questionCount");
            $rubricquestion->scale_3 = $request->input("question_complexity_scale_3_row_$questionCount");
            $rubricquestion->scale_4 = $request->input("question_complexity_scale_4_row_$questionCount");
            $rubricquestion->scale_5 = $request->input("question_complexity_scale_5_row_$questionCount");
            $rubricquestion->scale_6 = $request->input("question_complexity_scale_6_row_$questionCount");
            $rubricquestion->created_by = Auth::user()->id;
            $rubricquestion->save();
            $questionCount++;
        }
        return redirect()->back();
    }
    public function updateClassActivityQuestion(Request $request)
    {

        // dd($request->all());
        ActivityQuestion::whereid($request->id)->update([
            'activity_id' => $request->activity_id,
            'name' => $request->name,
            'answer' => $request->answer,
            'courseoffer_id' => $request->courseoffer_id,
            'clo_id' => $request->clo_id,
            'complexity' => $request->complexity,
            'question' => $request->question,
            'max_mark' => $request->max_mark,
            'obe_weight' => $request->obe_weight,
            'guidline' => $request->guidline,
            'choices' => $request->choices,

        ]);

        return ;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function storeExistingStudents(Request $request)
    {
        // Check if `student_ids` is an array before iterating
        if (is_array($request->student_ids)) {
            foreach ($request->student_ids as $s) {
                $existingEnrollment = EnrollStudent::where('student_id', $s)
                    ->where('course_section_id', $request->course_section_id)
                    ->first();

                if (!$existingEnrollment) {
                    EnrollStudent::create([
                        'student_id' => $s,
                        'program_id' => $request->program_id,
                        'course_section_id' => $request->course_section_id,
                        'remarks' => $request->remarks,
                    ]);
                }
            }
        } else {
            // Handle the case where no student IDs were selected
            return response()->json(['error' => 'No students selected.'], 400);
        }

        return response()->json(['success' => true]);
    }


    public function showEnrolledStudentAttendance($id)
    {
        $mark_date = StudentAttendance::select('mark_date')->wherecourse_offer_id($id)->whereNotNull('mark_date')->groupBy('mark_date')->get();
        $attendance_module = new StudentAttendance();
        $student_attendances = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

        return view('courseoffering.attendance.attendance',compact('id','mark_date','attendance_module','student_attendances','course_offering'));
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function storeAttendenceStatus()
    {
        $studentid = $_REQUEST['studentid'];
        $attendance = $_REQUEST['attendance'];
        $offeredcourseid = $_REQUEST['offeredcourseid'];
        $mark_date = $_REQUEST['mark_date'];

        $student_attendance = StudentAttendance::where('student_id', $studentid)->where('mark_date', $mark_date)->get();

        if ($student_attendance->isEmpty()) {
            StudentAttendance::create([
                'student_id' => $studentid,
                'course_offer_id' => $offeredcourseid,
                'mark_date' => $mark_date,
                'attendance' => $attendance,
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $update_data = array(
                'student_id' => $studentid,
                'course_offer_id' => $offeredcourseid,
                'mark_date' => $mark_date,
                'attendance' => $attendance,
                'created_by' => Auth::user()->id,
            );
            StudentAttendance::wherestudent_id($studentid)->wheremark_date($mark_date)->wherecourse_offer_id($offeredcourseid)->update($update_data);
        }
    }

    function editAttendanceByDate(){

        $id = $_REQUEST['id'];
        $mark_date = $_REQUEST['mark_date'];
        if($id){
            $student_attendances = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
            ?>
               <table class=" table table-stripped mb-0">
                    <thead>
                        <tr>
                            <th>Registration No.</th>
                            <th>Name</th>
                            <th>Attendance Date</th>
                            <th class="text-center">Mark Attendance </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            foreach($student_attendances as $ess){
                ?>
                    <tr style="border-top: outset;">
                        <td><?= $ess->student->registration_no ?? ''  ;?> </td>
                        <td><?= $ess->student->name ?? '' ;?> </td>
                        <td><?= $mark_date;?> </td>
                <?php
                 $a = StudentAttendance::select('attendance')
                    ->where('student_id', $ess->student->id)
                    ->where('mark_date', $mark_date)
                    ->where('course_offer_id', $id)
                    ->get();
                ?>
                    <td class="text-center">
                        <div class="radio-action" style="display:flex;">
                            <label class="radio-container mr-2" style="border: 1px solid gainsboro;">
                                <span class="radiomark"></span> Present
                                <input type="radio" class="attendance-radio" name="attendance_<?=$ess->student->id;?>" onclick="changeAttendanceStatus('<?= route('changeattendencestatus');?>','<?= $ess->student->id;?>','1','<?=$id;?>', '<?= $mark_date;?>')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '1' ? 'checked' : ''; ?>>
                            </label>
                            <label class="radio-container mr-2" style="border: 1px solid gainsboro;">
                                <span class="radiomark"></span> Absent
                                <input type="radio" class="attendance-radio" name="attendance_<?=$ess->student->id;?>" onclick="changeAttendanceStatus('<?= route('changeattendencestatus');?>','<?= $ess->student->id;?>','2','<?=$id;?>', '<?= $mark_date;?>')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '2' ? 'checked' : ''; ?>>
                            </label>

                        </div>
                    </td>


                </tr>
                <?php
            }
            ?>
                    </tbody>
                </table>
            <?php

        }
    }

    function viewAttendanceByDate(){

        $id = $_REQUEST['id'];
        $mark_date = $_REQUEST['mark_date'];
        if($id){
            $student_attendances = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
            ?>
               <table class=" table table-stripped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Registration No.</th>
                            <th>Name</th>
                            <th>Attendance Date</th>
                            <th class="text-center">Mark Attendance </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            $i = 1;
            foreach($student_attendances as $ess){
                ?>
                    <tr style="border-top: outset;">
                        <td><?= $i ?? ''; ?></td>
                        <td><?= $ess->student->registration_no ?? ''  ;?> </td>
                        <td><?= $ess->student->name ?? '' ;?> </td>
                        <td><?= $mark_date;?> </td>
                <?php
                 $a = StudentAttendance::select('attendance')
                    ->where('student_id', $ess->student->id)
                    ->where('mark_date', $mark_date)
                    ->where('course_offer_id', $id)
                    ->get();
                ?>
                    <td class="text-center">
                        <div class="radio-action" style="display:flex;">
                            <?php if($a->isNotEmpty() && $a->first()->attendance === '1'){ ?>
                                <span style="font-size: 15px;" class="badge bg-inverse-success">Present</span>
                            <?php }?>
                            <?php if($a->isNotEmpty() && $a->first()->attendance === '2'){ ?>
                                <span style="font-size: 15px;" class="badge bg-inverse-danger">Absent</span>
                            <?php }?>
                            <?php if($a->isEmpty() || !in_array($a->first()->attendance, ['1', '2'])){ ?>
                                <span style="font-size: 15px;" class="badge bg-inverse-warning">Not Mark</span>
                            <?php }?>
                        </div>
                    </td>
                </tr>
                <?php
            $i++;
            }
            ?>
                    </tbody>
                </table>
            <?php

        }
    }

    function getAttendanceByDate(){

        $id = $_REQUEST['id'];
        $mark = $_REQUEST['mark_date'];
        $mark_date = date('Y-m-d', strtotime($mark));

        if($id){
            $student_attendances = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
            ?>
               <table class=" table table-stripped mb-0">
                    <thead>
                        <tr>
                            <th>Registration No.</th>
                            <th>Name</th>
                            <th>Attendance Date</th>
                            <th class="text-center">Mark Attendance </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            foreach($student_attendances as $ess){
                ?>
                    <tr style="border-top: outset;">
                        <td><?= $ess->student->registration_no ?? ''  ;?> </td>
                        <td><?= $ess->student->name ?? '' ;?> </td>
                        <td><?= $mark_date;?> </td>
                <?php
                 $a = StudentAttendance::select('attendance')
                    ->where('student_id', $ess->student->id)
                    ->where('mark_date', $mark_date)
                    ->where('course_offer_id', $id)
                    ->get();
                ?>
                    <td class="text-center">
                        <div class="radio-action" style="display:flex;">
                            <label class="radio-containermr-2" style="border: 1px solid gainsboro;">
                                <span class="radiomark"></span> Present
                                <input type="radio" class="attendance-radio" name="attendance_<?=$ess->student->id;?>" onclick="changeAttendanceStatus('<?= route('changeattendencestatus');?>','<?= $ess->student->id;?>','1','<?=$id;?>', '<?= $mark_date;?>')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '1' ? 'checked' : ''; ?>>
                            </label>
                            <label class="radio-container mr-2" style="border: 1px solid gainsboro;">
                                <span class="radiomark"></span> Absent
                                <input type="radio" class="attendance-radio" name="attendance_<?=$ess->student->id;?>" onclick="changeAttendanceStatus('<?= route('changeattendencestatus');?>','<?= $ess->student->id;?>','2','<?=$id;?>', '<?= $mark_date;?>')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '2' ? 'checked' : ''; ?>>
                            </label>

                        </div>
                    </td>


                </tr>
                <?php
            }
            ?>
                    </tbody>
                </table>
            <?php

        }
    }

    public function showEnrolledStudentAssessment($id)
    {
        $classactivity = ClassActivity::select('id','assesment_name')->wherecourse_section_id($id)->get();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
        return view('courseoffering.assessment.assessment',compact('id','classactivity','course_offering'));
    }

    function getOutcomeViewByActivity()
{
    $classactivity_id = $_REQUEST['id'];
    $courseoffer_id = $_REQUEST['courseoffer_id'];

    if ($classactivity_id) {
        $students = EnrollStudent::with(['student:id,name,registration_no,roll_no'])
            ->where('course_section_id', $courseoffer_id)
            ->latest()
            ->get();

        $questions = ActivityQuestion::where('activity_id', $classactivity_id)
            ->orderBy('activity_id')
            ->get();
        ?>

        <div class="ml-3 mr-3  table-responsive">
            <table id="outcomeTable" class="table table-bordered review-table mb-0">
                <thead>
                    <tr>
                        <th>Registration No.</th>
                        <th>Student Name</th>
                        <?php
                        $qq = 1;
                        foreach ($questions as $q) {
                            ?>
                            <th>Q <?= $qq; ?> (<?= $q->max_mark; ?>.00)</th>
                            <?php
                            $qq++;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($students as $s) {
                        ?>
                        <tr>
                            <td><?= $s->student->registration_no ?? ''; ?> </td>
                            <td><?= $s->student->name ?? ''; ?> </td>
                            <?php
                            foreach ($questions as $q) {
                                $outcome = StudentAssessment::select('outcome')
                                    ->where('activity_id', $classactivity_id)
                                    ->where('question_id', $q->id)
                                    ->where('student_id', $s->student->id)
                                    ->where('courseoffer_id', $courseoffer_id)
                                    ->first();
                                ?>
                                <td>
                                    <input type="hidden" name="<?= $s->student->registration_no; ?>_questionid_<?= $q->id; ?>" value="<?= $q->id; ?>">
                                    <input
                                        id="<?= $s->student->registration_no; ?>_outcome_question_<?= $q->id; ?>"
                                        name="<?= $s->student->registration_no; ?>_outcome_question_<?= $q->id; ?>"
                                        type="number"
                                        min="0" max="<?= $q->max_mark ?>"
                                        class="form-control" required
                                        value="<?= $outcome->outcome ?? '0'; ?>">
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="submit-section mb-3">
            <button class="btn btn-success" type="submit">Save</button>
            <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        </form>

        <script>
            $(document).ready(function() {
                $('#outcomeTable').DataTable({
                    "paging": true, // Enable pagination
                    "ordering": true, // Enable sorting
                    "searching": true, // Enable search/filter
                    "info": true, // Show information
                    "pageLength": 100
                });
            });
        </script>

        <?php
    }
}


    public function storeOutcome(Request $request)
    {
        $classactivity_id = $request->input('classactivity_id');
        $courseoffer_id = $request->input('courseoffer_id');

        if ($courseoffer_id) {
            $students = EnrollStudent::with(['student:id,name,registration_no,roll_no'])
                ->where('course_section_id', $courseoffer_id)
                ->latest()
                ->get();

            $questions = ActivityQuestion::where('activity_id', $classactivity_id)
                ->orderBy('activity_id')
                ->get();

            foreach ($students as $student) {
                $registration_no = $student->student->registration_no;

                foreach ($questions as $question) {
                    $outcomeKey = $registration_no . '_outcome_question_' . $question->id;
                    $questionKey = $registration_no . '_questionid_' . $question->id;

                    if ($request->$outcomeKey) {
                        $outcome = StudentAssessment::where('activity_id', $classactivity_id)
                            ->where('question_id', $question->id)
                            ->where('student_id', $student->student->id)
                            ->where('courseoffer_id', $courseoffer_id)
                            ->first();

                        $assessmentData = [
                            'clo_id' => $question->clo_id,
                            'activity_id' => $classactivity_id,
                            'courseoffer_id' => $courseoffer_id,
                            'question_id' => $request->$questionKey,
                            'student_id' => $student->student->id,
                            'outcome' => $request->$outcomeKey
                        ];

                        if ($outcome) {
                            $outcome->update($assessmentData);
                        } else {
                            StudentAssessment::create($assessmentData);
                        }
                    }
                }
            }
        }
        return redirect()->route('showenrolledstudentassessment',$request->input('courseoffer_id'))->with('success','Outcome Update Successfully');
    }

    function calculateObeWeightAgainstClo(){

        $clo_id = $_REQUEST['clo_id'];
        $courseoffer_id = $_REQUEST['courseoffer_id'];
        $questions = ActivityQuestion::select('clo_id','courseoffer_id','obe_weight')
            ->where('courseoffer_id', $courseoffer_id)
            ->where('clo_id', $clo_id)
            ->get();
        $totalWeight = 0;
        foreach($questions as $q){
            $totalWeight += $q->obe_weight;
        }

        echo $totalWeight;
        exit;
    }

    public function showCQI($id)
    {
        $cqis = Cqi::with(['course_offer','user','clo'])->wherecourseoffer_id($id)->latest()->get();
        $cqiclassactivty = CqiClassActivity::with(['course_offer','assesment','cqi'])->wherecourse_offer_id($id)->latest()->get();
        $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
        $assesments = Assesment::select('*')->wherestatus(1)->get();
        $course_section = CourseOffer::select('course_id')->whereid($id)->first();

        $clos = StudentAssessment::select('clo_id')
            ->where('courseoffer_id', $id)
            ->whereNotNull('clo_id')
            ->orderBy('clo_id')
            ->groupBy('clo_id')
            ->get();
        $activityquestion = new ActivityQuestion();
        $studentassessment = new StudentAssessment();
        $assesment = new Assesment();
        $cqiactivity = new CqiClassActivity();
        $StudentQuestionAttainment = new StudentQuestionAttainment();
        $StudentCloAttainment = new StudentCloAttainment();
        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();

        return view('courseoffering.cqi.cqi',compact('id','course_section','cqiclassactivty','cqiactivity','clos','activityquestion','enrolledstudent','studentassessment','assesment','assesments','cqis','course_offering','StudentCloAttainment','StudentQuestionAttainment'));
    }

    /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
    */
public function storeCQI(Request $request)
{
    $request->validate([
        'clo_id' => 'required|array|min:1',
        'student_id' => 'required|array|min:1',
    ], [
        'clo_id.required' => 'Please select at least one CLO.',
        'student_id.required' => 'Please select at least one Student',
    ]);

    $courseoffer_id = $request->input('courseoffer_id');
    $selectedCLOs = $request->input('clo_id', []);
    $selectedStudents = $request->input('student_id', []);
    $cqiremarks = $request->input('cqiremarks');
    $course_id = $request->input('course_id');
    $currentDate = date('Y-m-d');

    $i = 1;

    foreach ($selectedCLOs as $cloId) {

        $cqi = Cqi::create([
            'courseoffer_id' => $courseoffer_id,
            'course_id' => $course_id,
            'clo_id' => $cloId,
            'cqiremarks' => $cqiremarks,
            'issue_date' => $currentDate,
            'name' => '000' . $i,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        $i++;

        foreach ($selectedStudents as $studentId) {

            $studentCLOKey = 'student_clo_' . $studentId;
            $studentCLOData = $request->input($studentCLOKey, []);

            if (!empty($studentCLOData)) {

                foreach ($studentCLOData as $studentCLOArray) {

                    if (strpos($studentCLOArray, "clo-id:$cloId") !== false) {

                        CqiStudent::create([
                            'cqi_id' => $cqi->id,
                            'courseoffer_id' => $courseoffer_id,
                            'student_id' => $studentId,
                            'created_by' => Auth::user()->id,
                        ]);

                        break; // prevent duplicate insert
                    }

                }

            }

        }

    }

    return redirect()->route('showcqi', $courseoffer_id)
        ->with('success', 'CQI Added Successfully');
}
    // public function storeCQI(Request $request)
    // {
    //     $request->validate([
    //         'clo_id' => 'required|array|min:1',
    //         'student_id' => 'required|array|min:1',
    //     ],
    //     [
    //         'clo_id.required' => 'Please select at least one CLO.',
    //         'student_id.required' => 'Please select at least one Student',
    //     ]);

    //     $courseoffer_id = $request->input('courseoffer_id');
    //     $selectedCLOs = $request->input('clo_id', []);
    //     $selectedStudents = $request->input('student_id', []);
    //     $cqiremarks = $request->input('cqiremarks');
    //     $course_id = $request->input('course_id');
    //     $generateCAR = $request->has('cqi-separate');
    //     $currentDate = date('Y-m-d');
    //     $i = 1;

        
    //     foreach ($selectedCLOs as $cloId) {

    //         $cqi = Cqi::create([
    //             'courseoffer_id' => $courseoffer_id,
    //             'course_id' => $course_id,
    //             'clo_id' => $cloId,
    //             'cqiremarks' => $cqiremarks,
    //             'issue_date' => $currentDate,
    //             'name' => '000'.$i,
    //             'status' => 1,
    //             'created_by' => Auth::user()->id,
    //         ]);
    //         $i++;
    //         foreach ($selectedStudents as $studentId) {
    //             $studentCLOKey = 'student_clo_' . $studentId;

    //             foreach ($request->$studentCLOKey as $studentCLOArray) {

    //                 if (strpos($studentCLOArray, "clo-id:$cloId") !== false) {

    //                     CqiStudent::create([
    //                         'cqi_id' => $cqi->id,
    //                         'courseoffer_id' => $courseoffer_id,
    //                         'student_id' => $studentId,
    //                         'created_by' => Auth::user()->id,
    //                     ]);

    //                 }

    //             }

    //         }
    //     }

    //     return redirect()->route('showcqi',$request->input('courseoffer_id'))->with('success','CQI Added Successfully');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function storeCqiActivities(Request $request){

        CqiClassActivity::create([
            'cqi_id' => $request->cqi_id,
            'course_offer_id' => $request->course_offer_id,
            'assesment_id' => $request->assesment_id,
            'assesment_name' => $request->assesment_name,
            'assesment_date' => $request->assesment_date,
            'assesment_total_mark' => $request->assesment_total_mark,
            'assesment_gpa_weight' => $request->assesment_gpa_weight,
            'complex_engineering_problem' => $request->complex_engineering_problem,
            'gpa_calculation' => $request->gpa_calculation,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('showcqi',$request->course_offer_id)->with('success','Data Added Successfully');

    }

    public function showCourseOfferingCqiActivitiesQuestion($id)
    {
        $activity_question = CqiActivityQuestion::select('*')->wherecqi_activity_id($id)->get();
        $activity_question_count = CqiActivityQuestion::select('*')->wherecqi_activity_id($id)->count();

        $class_activity = CqiClassActivity::select('*')->whereid($id)->get();
        $section_id = $class_activity[0]->course_offer_id;
        $cqi_id = $class_activity[0]->cqi_id;
        $cqi = Cqi::select('*')->whereid($cqi_id)->get();
        $clo_id = $cqi[0]->clo_id;
        $clos = CourseOfferClo::select('id','code','description')->whereid($clo_id)->get();
        $course_section = CourseOffer::select('*')->whereid($section_id)->first();

        return view('courseoffering.cqi.addquestion',compact('id','clos','activity_question','class_activity','course_section','activity_question_count'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function storeCqiActivitiesQuestion(Request $request){
        $request->validate([
            'name' => 'required',
            'obe_weight' => 'required',
            'clo_id' => 'required',
        ],
        [
            'name.required' => 'Name is required',
            'clo_id.required' => "Select CLO's",
            'obe_weight.required' => "OBE Weight Required",
        ]);

        $question = CqiActivityQuestion::create([
            'cqi_activity_id' => $request->activity_id,
            'question_name' => $request->activity_question_count,
            'name' => $request->name,
            'answer' => $request->answer,
            'courseoffer_id' => $request->courseoffer_id,
            'clo_id' => $request->clo_id,
            // 'clo_id' => implode(',',$request->clo_id),
            'complexity' => $request->complexity,
            'question' => $request->question,
            'max_mark' => $request->max_mark,
            'obe_weight' => $request->obe_weight,
            'guidline' => $request->guidline,
            'choices' => $request->choices,
            'not_for_obe' => $request->not_for_obe,
            'created_by' => Auth::user()->id,
        ]);

        $questionCount = 1;
        while ($request->filled("question_complexity_scale_1_row_$questionCount")) {
            $rubricquestion = new CqiActivityQuestionRubrics();
            $rubricquestion->cqi_question_id = $question->id;
            $rubricquestion->cqi_activity_id = $request->activity_id;
            $rubricquestion->scale_1 = $request->input("question_complexity_scale_1_row_$questionCount");
            $rubricquestion->scale_2 = $request->input("question_complexity_scale_2_row_$questionCount");
            $rubricquestion->scale_3 = $request->input("question_complexity_scale_3_row_$questionCount");
            $rubricquestion->scale_4 = $request->input("question_complexity_scale_4_row_$questionCount");
            $rubricquestion->scale_5 = $request->input("question_complexity_scale_5_row_$questionCount");
            $rubricquestion->scale_6 = $request->input("question_complexity_scale_6_row_$questionCount");
            $rubricquestion->created_by = Auth::user()->id;
            $rubricquestion->save();
            $questionCount++;
        }
        return redirect()->back();
    }

    function getOutcomeViewByCqiActivity(){

        $classactivity_id = $_REQUEST['id'];
        $cqi_id = $_REQUEST['cqi_id'];
        $course_offer_id = $_REQUEST['course_offer_id'];
        if($classactivity_id){
                $students = CqiStudent::with(['student:id,name,registration_no,roll_no'])->wherecqi_id($cqi_id)->wherecourseoffer_id($course_offer_id)->latest()->get();
                $questions = CqiActivityQuestion::where('cqi_activity_id', $classactivity_id)->orderBy('cqi_activity_id')->get();
            ?>

               <table class="table table-bordered review-table mb-0">
                    <thead>
                        <tr>
                            <th>Registration No.</th>
                            <th>Student Name</th>
                            <?php
                                    $qq = 1;
                                foreach($questions as $q){
                            ?>
                            <th>Q <?=$qq; ?> ( <?=$q->max_mark;?>.00)</th>
                            <?php
                                    $qq++;
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                foreach($students as $s){
            ?>
                    <tr>

                        <td><?= $s->student->registration_no ?? ''  ;?> </td>
                        <td><?= $s->student->name ?? '' ;?> </td>
                        <?php
                        $oq = 1;
                        foreach($questions as $q){
                            $outcome = CqiStudentAssessment::select('outcome')
                            ->where('cqi_activity_id', $classactivity_id)
                            ->where('cqi_question_id', $q->id)
                            ->where('student_id', $s->student->id)
                            ->where('courseoffer_id', $course_offer_id)
                            ->first();
                            ?>
                            <td>
                                <input type="hidden" name="<?=$s->student->registration_no;?>_questionid_<?=$q->id; ?>" value="<?=$q->id;?>">
                                <input
                                id="<?=$s->student->registration_no;?>_outcome_question_<?=$q->id; ?>"
                                name="<?=$s->student->registration_no;?>_outcome_question_<?=$q->id; ?>"
                                type="number"
                                min="0" max="<?=$q->max_mark?>"
                                class="form-control" required
                                value="<?=$outcome->outcome ?? '';?>">
                            </td>
                        <?php
                            $oq++;
                            }
                        ?>
                </tr>
            <?php
                }
            ?>
                    </tbody>
                </table>
                <div class="submit-section mb-3">
                    <button  class="btn btn-success" type="submit">Save</button>
                    <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
                </div>
            </form>
            <?php
        }
    }

    public function storeCqiOutcome(Request $request)
    {
        $classactivity_id = $request->input('classactivity_id');
        $courseoffer_id = $request->input('courseoffer_id');
        $cqi_id = $request->input('cqi_id');

        if ($courseoffer_id) {
            $students = CqiStudent::with(['student:id,name,registration_no,roll_no'])
                ->wherecqi_id($cqi_id)
                ->wherecourseoffer_id($courseoffer_id)
                ->latest()
                ->get();

            $questions = CqiActivityQuestion::where('cqi_activity_id', $classactivity_id)
                ->orderBy('cqi_activity_id')
                ->get();

            foreach ($students as $student) {
                $registration_no = $student->student->registration_no;

                foreach ($questions as $question) {
                    $outcomeKey = $registration_no . '_outcome_question_' . $question->id;
                    $questionKey = $registration_no . '_questionid_' . $question->id;

                    if ($request->$outcomeKey) {
                        $outcome = CqiStudentAssessment::where('cqi_activity_id', $classactivity_id)
                            ->where('cqi_question_id', $question->id)
                            ->where('student_id', $student->student->id)
                            ->where('courseoffer_id', $courseoffer_id)
                            ->first();

                        $assessmentData = [
                            'clo_id' => $question->clo_id,
                            'cqi_activity_id' => $classactivity_id,
                            'courseoffer_id' => $courseoffer_id,
                            'cqi_question_id' => $request->$questionKey,
                            'student_id' => $student->student->id,
                            'outcome' => $request->$outcomeKey
                        ];

                        if ($outcome) {
                            $outcome->update($assessmentData);
                        } else {
                            CqiStudentAssessment::create($assessmentData);
                        }
                    }
                }
            }
        }
        return redirect()->route('showcqi',$request->input('courseoffer_id'))->with('success','Outcome Update Successfully');
    }

    public function showweight($id)
    {
        $clos = CourseOfferClo::where('courseoffer_id', $id)->get();
        $activityquestion = new ActivityQuestion();

        $course_offering = CourseOffer::with(['institute', 'course','teacher','program'])->whereid($id)->latest()->first();
        return view('courseoffering.weight.weight',compact('id','clos','activityquestion','course_offering'));
    }



    // public function updatecloweight(Request $request)
    // {
    //     $fieldValue = $request->input('fieldValue');
    //     $questionId = $request->input('questionId');
    //     $courseoffer_id = $request->input('course_offer_id');
    //     $clo_id = $request->input('cloId');
    //     $totalweight_check = $request->input('totalweight');

    //     // Calculate the current total weight without the current question's weight
    //     $questions = ActivityQuestion::select('obe_weight')
    //         ->where('courseoffer_id', $courseoffer_id)
    //         ->where('clo_id', $clo_id)
    //         ->where('id', '!=', $questionId) // Exclude the current question
    //         ->get();

    //     $totalWeight = 0;
    //     foreach ($questions as $q) {
    //         $totalWeight += $q->obe_weight;
    //     }

    //     // Add the new field value to the total weight
    //     $newTotalWeight = $totalWeight + $fieldValue;

    //     if ($newTotalWeight <= $totalweight_check) {
    //         // Update the obe_weight only if it doesn't exceed the total weight limit
    //         $update = ['obe_weight' => $fieldValue];
    //         ActivityQuestion::where('id', $questionId)->update($update);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Weight updated successfully.'
    //         ]);
    //     } else {
    //         // Return an error message if the new total weight exceeds the limit
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => "Total weight cannot be greater than $totalweight_check"
    //         ]);
    //     }
    // }

    public function updatecloweight(Request $request)
    {
        $courseoffer_id = $request->input('course_offer_id');
        $weights = $request->input('weights', []); // array of inputs

        if (empty($weights)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data provided.'
            ]);
        }

        // Group weights by clo_id for validation
        $grouped = [];
        foreach ($weights as $w) {
            $grouped[$w['cloId']][] = $w;
        }

        foreach ($grouped as $cloId => $items) {
            // Get CLO total allowed weight (same for all questions in this CLO)
            $totalweight_check = $items[0]['totalweight'];

            // Calculate sum of submitted weights for this CLO
            $sumWeights = array_sum(array_column($items, 'fieldValue'));

            if ($sumWeights > $totalweight_check) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Total weight for CLO ID $cloId cannot exceed $totalweight_check"
                ]);
            }
        }

        // If all validation passes, update each question weight
        foreach ($weights as $w) {
            ActivityQuestion::where('id', $w['questionId'])
                ->where('courseoffer_id', $courseoffer_id)
                ->where('clo_id', $w['cloId'])
                ->update([
                    'obe_weight' => $w['fieldValue']
                ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All weights updated successfully.'
        ]);
    }

    public function uploadexistingstudent(Request $request)
    {
        $request->validate([
            'course_section_id' => 'required|integer',
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $rows = array_map('str_getcsv', file($path));

        // Skip header row if needed
        unset($rows[0]);

        $notInserted = []; // track missing students

        foreach ($rows as $row) {
            // CSV format: roll_no, name, ...
            $rollNo = $row[0] ?? null;  // assuming first column is roll_no

            if ($rollNo) {
                // $rollNo = str_pad($rollNo, 9, '0', STR_PAD_LEFT);
                // find student by roll_no
                $student = Student::select('id', 'program_id', 'roll_no', 'name')
                    ->whereRaw('CAST(roll_no AS UNSIGNED) = ?', [(int)$rollNo])
                    ->where('status', 1)
                    ->first();

                if ($student) {
                    // Enroll student
                    EnrollStudent::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'course_section_id' => $request->course_section_id,
                        ],
                        [
                            'program_id' => $student->program_id,
                            'remarks' => $request->remarks,
                        ]
                    );
                } else {
                    // track roll_no not found
                    $notInserted[] = $rollNo;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Students imported successfully.',
            'not_inserted' => $notInserted, // return missing roll numbers
        ]);
    }
}
