<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\CourseSection;
use App\Models\Sesssion;
use App\Models\Program;
use App\Models\Campus;
use App\Models\EnrollStudent;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Traits\TraitFunctions;
use Image;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Mail;
use App\Mail\UserMail;

class StudentController extends Controller
{
    use TraitFunctions;
    public function getStudents(Request $request)
    {
        if ($request->ajax()) {



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
            // echo "<pre>";
            // print_r($hasFunctionalityPermission);
            // die();
            if($flag === 'all'){
                $data = $sesssion !== null ? Student::with(['program'])->latest()->get() : [];
            }elseif($flag === 'institute'){
                $program_id = $hasFunctionalityPermission['program_id'];
                 
                $data =  (!empty($program_id) && $sesssion !== null) ? Student::with(['program'])
                    // ->where('active_session_id',$sesssion->id)
                    ->whereIn('program_id', $program_id)->latest()->get() :  null; 
            }elseif($flag === 'program'){
               $program_id = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_id) && $sesssion !== null) ? Student::with(['program'])
                    // ->where('active_session_id',$sesssion->id)
                    ->whereIn('program_id', $program_id)->latest()->get() :  null; 
            }elseif($flag === 'reports_dashboard'){
                $data =  []; 
            }elseif($flag === 'enrolled_course'){
               $program_id = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_id) && $sesssion !== null) ? Student::with(['program'])
                    // ->where('active_session_id',$sesssion->id)
                    ->whereIn('program_id', $program_id)->latest()->get() :  null; 
            }elseif($flag === 'courseoffering_enrollment'){
               $program_id = $hasFunctionalityPermission['program_id'];
                $data =  (!empty($program_id) && $sesssion !== null) ? Student::with(['program'])
                    // ->where('active_session_id',$sesssion->id)
                    ->whereIn('program_id', $program_id)->latest()->get() :  null; 
            }else{
                $data =  []; 
            }

            // $data = Student::with(['program'])->latest()->get();
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
                ->addColumn('gender', function($row){
                    $gender = '';
                    $i = "'";
                    if($row->gender === 'female'){
                        $gender = 'Female';
                    }else{
                        $gender = 'Male';
                    }
                    $genderlabel = $gender;
                    return $genderlabel;
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changestudentstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changestudentstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    // $check_all_permission = $this->checkPermissions('campus-all'); 
                    // $edit_permission = $this->checkPermissions('campus-edit');
                    // $actionBtn = '';
                    // if($edit_permission === true || $check_all_permission === true){
                    
                    // }
                    $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editstudent',$row->id).'">Edit</a>';
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editstudent',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','gender','action'])
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
        return view('student.manage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id','name')->wherestatus(1)->get();
        // $coursesection = CourseSection::select('id','name')->wherestatus(1)->get();
        $programs = Program::select('id','name')->wherestatus(1)->get();
        $campuses = Campus::select('id','name')->wherestatus(1)->get();
        $sesssion = '';
        if(session()->has('session_key')) {
            $sessionId = session('session_key');
            $sesssion = Sesssion::select('id','title')->whereid($sessionId)->get();
        }else{
            $sesssion = Sesssion::select('id','title')->wherestatus('1')->get();
        }
        // echo "<pre>";
        // print_r($sesssion);
        // die();
        // $countries = Country::select('id','name')->get();
        // return view('student.add',compact('roles','sessions','programs','campuses','sesssion','countries','coursesection'));
        return view('student.add',compact('roles','programs','campuses','sesssion'));
    
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
            'program_id' => 'required',
            'active_session_id' => 'required',
            'registration_no' => 'required',

            // 'cnic' => 'required',
            // 'roll_no' => 'required',
            // 'registration_no' => 'required',
            // 'email' => 'required|unique:students|unique:users',
        ],
        [
            'name.required' => 'Name is required',
            'program_id.required' => 'Program is required',
            'active_session_id.required' => 'Session is required',
            'registration_no.required' => 'Sap ID is required',
            // 'email.required' => 'Email is required',
            // 'roll_no.required' => 'Roll No. cannnot be blank',
            // 'registration_no.required' => 'Registration No. cannnot be blank',
            // 'cnic.required' => 'CNIC No is required',
        ]);

        $imageName = '';
        $files = $request->file('student_profile_pic');
        if($request->hasFile('student_profile_pic'))
        {
            $imageName = uniqid().'image'.date('his').'.'.$files->extension();
            $filePath = public_path('/assets/student_image');
            $img = Image::make($files->getRealPath());
            $img->save($filePath.'/'.$imageName);
        }
        // $password = Str::random(8);
        // $hashed_random_password = Hash::make($password);

        // $user_data = User::create([
        //     'firstname' => $request->name,
        //     'name' => $request->name,
        //     'password' => $hashed_random_password,
        //     'gender' => $request->gender,
        //     'status' => $request->status,
        //     'address' => $request->address,
        //     'phone_number' => $request->phone_number,
        //     'role_id' => json_encode(["7"]),
        //     'created_by' => Auth::user()->id,
        // ]);
        // $user_id = $user_data->id;

        $student_data = Student::create([
            // 'user_id' => $user_id,
            'name' => $request->name,
            'roll_no' =>$request->registration_no,
            'registration_no' =>$request->registration_no,
            // 'email' => $request->email,
            'nationality' => $request->nationality,
            'state' => $request->state,
            'city' => $request->city,
            'marital_status' => $request->marital_status,
            'cnic' => $request->cnic,
            'religion' => $request->religion,
            'admission_type' => $request->admission_type,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'inter_degree_type' => $request->inter_degree_type,
            'inter_max' => $request->inter_max,
            'inter_obt' => $request->inter_obt,
            'passing_year_int' => $request->passing_year_int,
            'inter_board' => $request->inter_board,
            'matric_degree_type' => $request->matric_degree_type,
            'matric_passing_year' => $request->matric_passing_year,
            'matric_max' => $request->matric_max,
            'matric_obt' => $request->matric_obt,
            'matric_board' => $request->matric_board,
            'transfered' => $request->transfered,
            'guardian' => $request->guardian,
            'guardian_name' => $request->guardian_name,
            'guardian_cnic' => $request->guardian_cnic,
            'guardian_mobile' => $request->guardian_mobile,
            'student_profile_pic' => $imageName,
            'active_session_id' =>$request->active_session_id,
            'program_id' => $request->program_id,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);

        // $student_id = $student_data->id;
        // $mailData = [
        //     'email' => $request->email,
        //     'password' => $password,
        // ];
        // Mail::to($request->email)->send(new UserMail($mailData));
        return redirect()->route('managestudent')->with('success','Data Added Successfully');
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
        $student = Student::find($id);
        $roles = Role::select('id','name')->wherestatus(1)->get();
        $programs = Program::select('id','name')->wherestatus(1)->get();
        $campuses = Campus::select('id','name')->wherestatus(1)->get();
        $countries = Country::select('id','name')->get(); 
        $sessions = '';
        if($student->active_session_id){
            $sessions = Sesssion::select('id','title')->where('id',$student->active_session_id)->get();
        }else{
            if(session()->has('session_key')) {
                $sessionId = session('session_key');
                $sessions = Sesssion::select('id','title')->whereid($sessionId)->get();
            } 
        }
        return view('student.edit',compact('student', 'roles','programs','campuses','countries','sessions'));
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
        $imageName = '';
        $files = $request->file('student_profile_pic');
        if($request->hasFile('student_profile_pic'))
        {
            if($request->old_image){
                unlink('public/assets/student_image/'.$request->old_image);
            }
            $imageName = uniqid().'image'.date('his').'.'.$files->extension();
            $filePath = public_path('/assets/student_image');
            $img = Image::make($files->getRealPath());
            $img->save($filePath.'/'.$imageName);
        }
        $user_update_data = array(
            'firstname' => $request->name,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'status' => $request->status,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        );
        User::whereid($request->user_id)->update($user_update_data);

        $student_update_data = array(
            'user_id' => $request->user_id,
            'name' => $request->name,
            'roll_no' =>$request->roll_no,
            'registration_no' =>$request->registration_no,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'state' => $request->state,
            'city' => $request->city,
            'marital_status' => $request->marital_status,
            'cnic' => $request->cnic,
            'religion' => $request->religion,
            'admission_type' => $request->admission_type,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'inter_degree_type' => $request->inter_degree_type,
            'inter_max' => $request->inter_max,
            'inter_obt' => $request->inter_obt,
            'passing_year_int' => $request->passing_year_int,
            'inter_board' => $request->inter_board,
            'matric_degree_type' => $request->matric_degree_type,
            'matric_passing_year' => $request->matric_passing_year,
            'matric_max' => $request->matric_max,
            'matric_obt' => $request->matric_obt,
            'matric_board' => $request->matric_board,
            'transfered' => $request->transfered,
            'guardian' => $request->guardian,
            'guardian_name' => $request->guardian_name,
            'guardian_cnic' => $request->guardian_cnic,
            'guardian_mobile' => $request->guardian_mobile,
            'student_profile_pic' => $imageName,
            'active_session_id' => $request->active_session_id,
            'program_id' => $request->program_id,
        );
        Student::whereid($request->id)->update($student_update_data);

        return redirect()->route('managestudent')->with('success','Data Updated Successfully');
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
        User::whereid($id)->delete();
        return redirect()->route('managestudent')->with('error','Data Deleted Successfully');
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
        User::whereid($id)->update($update_data);
        return redirect()->route('managestudent');
    }
     public function downloadTemplate()
        {
            // Define CSV content (header row)
            $csvData = "student_id,name,email\n";

            // File name with timestamp
            $fileName = "student_template_" . date('Y-m-d_H-i-s') . ".csv";

            // Return response as CSV download
            return response($csvData, 200, [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName"
            ]);
        }

}
