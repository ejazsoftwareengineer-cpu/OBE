<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CourseSection;
use App\Models\CLO;
use App\Models\ProgramBatch;
use App\Models\ActivityQuestion;
use App\Models\EnrollStudent;
use App\Models\Institute;
use App\Models\User;
use App\Models\Assesment;
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

class CourseSectionController extends Controller
{
    // use TraitFunctions;
    // public function getCourseSections(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = CourseSection::with(['institute', 'course','teacher'])->latest()->get();
            
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('institute', function($row){
    //                 $institute = '';
    //                 if($row->institute){
    //                     $institute = $row->institute->name;
    //                 }else{
    //                     $institute = '-';
    //                 }
    //                 $institute_d = $institute;
    //                 return $institute_d;
    //             })
    //             ->addColumn('teacher', function($row){
    //                 $teacher = '';
    //                 if($row->teacher){
    //                     $teacher = $row->teacher->name;
    //                 }else{
    //                     $teacher = '-';
    //                 }
    //                 $teacher_d = $teacher;
    //                 return $teacher_d;
    //             })
    //             ->addColumn('course', function($row){
    //                 $course = '';
    //                 $i = "'";
    //                 if($row->course){
    //                     $course = $row->course->name;
    //                 }else{
    //                     $course = '-';
    //                 }
    //                 $course_d = $course;
    //                 return $course_d;
    //             })
    //             ->addColumn('status', function($row){
    //                 $status = '';
    //                 $i = "'";
    //                  if($row->status === 1){
    //                     $status = '<i class="fa fa-dot-circle-o text-purple"></i> Active';
    //                 }elseif($row->status === 0){
    //                     $status = '<i class="fa fa-dot-circle-o text-info"></i> InActive';
    //                 }else{
    //                     $status = '<i class="fa fa-dot-circle-o text-info"></i> Select Status';
    //                 }
    //                 $statusBtn = '<div class="table-col dropdown action-label">
    //                             <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
    //                             '.$status.'
    //                             </a>
    //                             <div class="dropdown-menu dropdown-menu-right">
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changecoursesectionstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changecoursesectionstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
    //                             </div>
    //                         </div>';
    //                 return $statusBtn;
    //             })
    //             ->addColumn('action', function($row){

    //                 $check_all_permission = $this->checkPermissions('campus-all'); 
    //                 $edit_permission = $this->checkPermissions('campus-edit');
    //                 $actionBtn = '';
    //                 if($edit_permission === true || $check_all_permission === true){
                    
    //                 }
                    
    //                 $actionBtn = '<div style="display:flex;"><a class="btn btn-success btn-sm" href="'.route('editcoursesection',$row->id).'">Edit</a>
    //                 <a class="btn btn-primary btn-sm" href="'.route('showcoursesection',$row->id).'">View</a></div>';
                   
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['institute','teacher','course','status','action'])
    //             ->make(true);
    //     }
    // }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     $check_all_permission = $this->checkPermissions('coursesection-all');
    //     $check_read_permission = $this->checkPermissions('coursesection-read');
    //     if($check_read_permission == true || $check_all_permission == true){
    //         $write_permission = $this->checkPermissions('coursesection-write');
    //         $edit_permission = $this->checkPermissions('coursesection-edit');
    //         $delete_permission = $this->checkPermissions('coursesection-delete');
    //         $courses = CourseSection::all();
    //       return view('coursesection.manage',compact('courses','write_permission','edit_permission','delete_permission','check_all_permission'));
    //     }else{
    //       $error = "403";
    //       $heading = "Oops! Forbidden";
    //       $message = "You don't have permission to access this module";
    //       return view('errors.error',compact('message','error','heading'));
    //     }
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $check_all_permission = $this->checkPermissions('coursesection-all'); 
    //     $check_create_permission = $this->checkPermissions('coursesection-write');
    //     if($check_create_permission == true || $check_all_permission == true){
              
    //         $institute = Institute::select('id','name')->wherestatus(1)->get();
    //         $courses = Course::select('id','code','name')->wherestatus(1)->get();
    //         $program_batch = ProgramBatch::select('id','name')->wherestatus(1)->get();
    //         $clos = CLO::select('id','code')->wherestatus(1)->get();
    //         $teachers = User::select('id','name')->whereusertype_id(1)->get();

    //         return view('coursesection.add',compact('program_batch','clos','institute','courses','teachers'));
    //     }else{
    //       $error = "403";
    //       $heading = "Oops! Forbidden";
    //       $message = "You don't have permission to access this module";
    //       return view('errors.error',compact('message','error','heading'));
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //     ], 
    //     [
    //         'name.required' => 'Course Name is required',
    //     ]);

    //     CourseSection::create([
    //         'institute_id' => $request->institute_id,
    //         // 'faculty_id' => $request->faculty_id,
    //         'course_id' => $request->course_id,
    //         'name' => $request->name,
    //         'section' => $request->section,
    //         'mark_per' => $request->mark_per,
    //         'student_per' => $request->student_per,
    //         'status' => $request->status,
    //         'semester_id' => $request->semester_id,
    //         'teacher_id' => $request->teacher_id,
    //         'course_status' => $request->course_status,
    //         'gender' => $request->gender,
    //         'available_seats' => $request->available_seats,
    //         'description' => $request->description,
    //         'office_hours' => $request->office_hours,
    //         'created_by' => Auth::user()->id,
    //     ]);
    //     return redirect()->route('managecoursesection')->with('success','Data Added Successfully');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $cs = CourseSection::with(['institute', 'course', 'semester','teacher'])->whereid($id)->latest()->get();
    //     $course_section = $cs[0];
    //     return view('coursesection.view',compact('course_section'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $coursesection= CourseSection::find($id);
    //     $institute = Institute::select('id','name')->wherestatus(1)->get();
    //     $courses = Course::select('id','code','name')->wherestatus(1)->get();
    //     $program_batch = ProgramBatch::select('id','name')->wherestatus(1)->get();
    //     $clos = CLO::select('id','code')->wherestatus(1)->get();
    //     $teachers = User::select('id','name')->whereusertype_id(1)->get();
       
    //     return view('coursesection.edit',compact('teachers','institute','coursesection','program_batch','clos','courses'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request)
    // {
    //     $update_data = array(
    //         'institute_id' => $request->institute_id,
    //         // 'faculty_id' => $request->faculty_id,
    //         'course_id' => $request->course_id,
    //         'name' => $request->name,
    //         'section' => $request->section,
    //         'mark_per' => $request->mark_per,
    //         'student_per' => $request->student_per,
    //         'status' => $request->status,
    //         'semester_id' => $request->semester_id,
    //         'teacher_id' => $request->teacher_id,
    //         'course_status' => $request->course_status,
    //         'gender' => $request->gender,
    //         'available_seats' => $request->available_seats,
    //         'description' => $request->description,
    //         'office_hours' => $request->office_hours,
    //     );
    //     CourseSection::whereid($request->id)->update($update_data);
    //     return redirect()->route('managecoursesection')->with('success','Data Updated Successfully');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy()
    // {
    //     $id = $_REQUEST['id'];
    //     CourseSection::whereid($id)->delete();
    //     return redirect()->route('managecoursesection')->with('error','Data Deleted Successfully');
    // }

    // /**
    //  * 
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function changeStatus()
    // {
    //     $id = $_REQUEST['id'];
    //     $status = $_REQUEST['status'];
    //     $update_data = array(
    //         'status' => $status,
    //     );
    //     CourseSection::whereid($id)->update($update_data);
    //     return redirect()->route('managecoursesection');
    // }

    // public function showCourseSectionActivities($id)
    // {
    //     $class_activity = ClassActivity::select('*')->wherecourse_section_id($id)->get();
    //     $assesment = Assesment::select('*')->wherestatus(1)->get();
    //     $course_ids = CourseSection::select('id','course_id')->whereid($id)->get();
    //     $course_id = null;
    //     if ($course_ids->isEmpty()) {
    //         $course_id = null;
    //     } else {
    //         $course_id = $course_ids[0]->course_id;
    //     }
    //     $clos = CLO::select('id','code')->wherecourse_id($course_id)->get();
    //     return view('coursesection.classactivities',compact('id','assesment','course_id','clos' ,'class_activity'));
    // } 
    
    // public function showCourseSectionActivitiesQuestion($id)
    // {
    //     $activity_question = ActivityQuestion::select('*')->whereactivity_id($id)->get();
    //     $class_activity = ClassActivity::select('*')->whereid($id)->get();
    //     $section_id = $class_activity[0]->course_section_id;
    //     $course_section = CourseSection::select('*')->whereid($section_id)->get();
    //     $course_id = $course_section[0]->course_id;
    //     $clos = CLO::select('id','code','description')->wherecourse_id($course_id)->get();

    //     return view('coursesection.addquestion',compact('id','clos','activity_question','class_activity','course_section'));
    // }
    
    // public function showCourseSectionClo($id)
    // {
    //     $course_id = CourseSection::select('id','course_id')->whereid($id)->get();
    //     $course_id = $course_id[0]->course_id;
    //     $courseclo = CLO::with(['course'])->wherecourse_id($course_id)->latest()->get();
        
    //     return view('coursesection.clolisting',compact('id','courseclo'));
    // }
    
    // public function getActivityAndQuestions(Request $request)
    // {
    //     $activity = ClassActivity::with(['assesment', 'activityQuestions.activityQuestionRubrics'])
    //     ->where('id', $request->id)
    //     ->latest()
    //     ->first();
        
    //     if (!$activity) {
    //         return response()->json(['error' => 'Activity not found'], 404);
    //     }

    //     foreach ($activity->activityQuestions as $question) {
    //         $cloIds = explode(',', $question->clo_id);
    //         $cloRecords = CLO::whereIn('id', $cloIds)->get();
    //         $question->setAttribute('cloRecords', $cloRecords);
    //     }
        
    //     $assesment = Assesment::select('*')->wherestatus(1)->get();

    //     $html = view('coursesection.viewactivityquestionmodal', 
    //         [
    //         'assesment' => $assesment,
    //         'activity' => $activity,
    //         ]
    //     )->render();

    //     return response()->json(['html' => $html]);
    //     // return response()->json(['activity' => $activity]);
    // }

    // public function showCourseSectionStudent($id)
    // {
    //     $students = Student::select('id','roll_no','name')->wherestatus(1)->get();
    //     $enrolled_students = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get();
        
    //     return view('coursesection.students.enrollstudents',compact('id','students','enrolled_students'));
    // }

    // public function mapCourseSectionPlo($id,$coursesection,$course)
    // {
    //     $program_batch = ProgramBatch::select('id','acedemic_year')->get();
    //     return view('coursesection.mapplo',compact('id','coursesection','course','program_batch'));
    // }

    // public function storePloByClo(Request $request)
    // {
    //     $request->validate([
    //         'clo_id' => 'required',
    //     ]);
    //     $level = '';
    //     if($request->domain === '1'){
    //         $level = $request->level2;
    //     }else if($request->domain === '2'){
    //         $level = $request->level3;
    //     }else if($request->domain === '3'){
    //         $level = $request->leve4;
    //     }else{
    //         $level = 0;
    //     }
    //     PloByCourseSectionClo::create([
    //         'clo_id' => $request->clo_id,
    //         'course_id' => $request->course_id,
    //         'course_section_id' => $request->course_section_id,
    //         'program_batch_id' => $request->program_batch_id,
    //         'domain' => $request->domain,
    //         'emphasis_level' => $request->emphasis_level,
    //         'plo_id' => $request->plo_id,
    //         'level' => $level,
    //         'created_by' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('showcoursesectionclo',$request->course_section_id)->with('success','Data Added Successfully');

    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    // */
    // public function storeActivities(Request $request){
    //     $request->validate([
    //         'assesment_name' => 'required',
    //     ], 
    //     [
    //         'assesment_name.required' => 'Name is required',
    //     ]);

    //     ClassActivity::create([
    //         'assesment_id' => $request->assesment_id,
    //         'course_id' => $request->course_id,
    //         'course_section_id' => $request->course_section_id,
    //         'assesment_name' => $request->assesment_name,
    //         'assesment_date' => $request->assesment_date,
    //         'assesment_total_mark' => $request->assesment_total_mark,
    //         'assesment_gpa_weight' => $request->assesment_gpa_weight,
    //         'complex_engineering_problem' => $request->complex_engineering_problem,
    //         'gpa_calculation' => $request->gpa_calculation,
    //         'created_by' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('showcoursesectionactivities',$request->course_section_id)->with('success','Data Added Successfully');

    // }  

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    // */
    // public function storeActivitiesQuestion(Request $request){
    //     $request->validate([
    //         'name' => 'required',
    //         'clo_id' => 'required',
    //     ], 
    //     [
    //         'name.required' => 'Name is required',
    //         'clo_id.required' => "Select CLO's",
    //     ]);

    //     $question = ActivityQuestion::create([
    //         'activity_id' => $request->activity_id,
    //         'name' => $request->name,
    //         'answer' => $request->answer,
    //         'clo_id' => implode(',',$request->clo_id),
    //         'complexity' => $request->complexity,
    //         'question' => $request->question,
    //         'max_mark' => $request->max_mark,
    //         'obe_weight' => $request->obe_weight,
    //         'guidline' => $request->guidline,
    //         'choices' => $request->choices,
    //         'not_for_obe' => $request->not_for_obe,
    //         'created_by' => Auth::user()->id,
    //     ]);
        
    //     $questionCount = 1;
    //     while ($request->filled("question_complexity_scale_1_row_$questionCount")) {
    //         $rubricquestion = new ActivityQuestionRubric();
    //         $rubricquestion->question_id = $question->id;
    //         $rubricquestion->activity_id = $request->activity_id;
    //         $rubricquestion->scale_1 = $request->input("question_complexity_scale_1_row_$questionCount");
    //         $rubricquestion->scale_2 = $request->input("question_complexity_scale_2_row_$questionCount");
    //         $rubricquestion->scale_3 = $request->input("question_complexity_scale_3_row_$questionCount");
    //         $rubricquestion->scale_4 = $request->input("question_complexity_scale_4_row_$questionCount");
    //         $rubricquestion->scale_5 = $request->input("question_complexity_scale_5_row_$questionCount");
    //         $rubricquestion->scale_6 = $request->input("question_complexity_scale_6_row_$questionCount");
    //         $rubricquestion->created_by = Auth::user()->id;
    //         $rubricquestion->save();
    //         $questionCount++;
    //     }
    //     return redirect()->back();
    // }           
                      
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    // */
    // public function storeExistingStudents(Request $request){

    //     foreach($request->student_id as $s){

    //         EnrollStudent::create([
    //             'student_id' => $s,
    //             'course_section_id' => $request->course_section_id,
    //             'remarks' => $request->remarks,
    //         ]);
    //     }
    // }



}

