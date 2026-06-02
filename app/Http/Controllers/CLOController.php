<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PLO;
use App\Models\CLO;
use App\Models\PEO;
use App\Models\Program;
use App\Models\PloPeo;
use App\Models\PloKpis;
use App\Models\Department;
use App\Models\Course;
use App\Models\ProgramBatch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class CLOController extends Controller
{
    use TraitFunctions;
    // public function getClo(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $user = Auth::user();
    //
    //         $roleId = session('role_key');
    //         $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    // //         $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
    //         if($flag === 'all'){
    //             $data = CLO::with(['course'=>function($query) {
    //                 return $query->select(['id', 'code', 'name']);
    //             }])->latest()->get();

    //         }elseif($flag === 'institute'){
    //             $cloId = $hasFunctionalityPermission['clo_id'];
    //             $data =  (!empty($cloId)) ?  CLO::with(['course'=>function($query) {
    //                 return $query->select(['id', 'code', 'name']);
    //             }])->whereIn('id', $cloId)->latest()->get() :  null;
    //         }elseif($flag === 'program'){
    //             $cloId = $hasFunctionalityPermission['clo_id'];
    //             $data =  (!empty($cloId)) ? CLO::with(['course'=>function($query) {
    //                 return $query->select(['id', 'code', 'name']);
    //             }])->whereIn('id', $cloId)->latest()->get() :  null;
    //         }elseif($flag === 'reports_dashboard'){
    //             $data =  [];
    //         }elseif($flag === 'enrolled_course'){
    //             $cloId = $hasFunctionalityPermission['clo_id'];
    //             $data =  (!empty($cloId)) ? CLO::with(['course'=>function($query) {
    //                 return $query->select(['id', 'code', 'name']);
    //             }])->whereIn('id', $cloId)->latest()->get() :  null;
    //         }elseif($flag === 'courseoffering_enrollment'){
    //             $cloId = $hasFunctionalityPermission['clo_id'];
    //             $data =  (!empty($cloId)) ? CLO::with(['course'=>function($query) {
    //                 return $query->select(['id', 'code', 'name']);
    //             }])->whereIn('id', $cloId)->latest()->get() :  null;
    //         }else{
    //             $data = [];
    //         }

    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('course', function($row){
    //                 $course = '';
    //                 $i = "'";
    //                 if($row->course){
    //                     $course = $row->course->code . ' - ' . $row->course->name;
    //                 }else{
    //                     $course = '-';
    //                 }
    //                 $courselabel = $course;
    //                 return $courselabel;
    //             })
    //             ->addColumn('status', function($row){
    //                 $status = '';
    //                 $i = "'";
    //                 if($row->status === 1){
    //                     $status = '<i class="fa fa-dot-circle-o text-purple"></i> Active';
    //                 }else{
    //                     $status = '<i class="fa fa-dot-circle-o text-info"></i> InActive';
    //                 }
    //                 $statusBtn = '<div class="table-col dropdown action-label">
    //                             <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
    //                             '.$status.'
    //                             </a>
    //                             <div class="dropdown-menu dropdown-menu-right">
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changeclostatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeclostatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
    //                             </div>
    //                         </div>';
    //                 return $statusBtn;
    //             })
    //             ->addColumn('action', function($row){

                    // $check_all_permission = $this->checkPermissions('campus-all');
                    // $edit_permission = $this->checkPermissions('campus-edit');
                    // $actionBtn = '';
                    // if($edit_permission === true || $check_all_permission === true){

                    // }
    //                 $actionBtn = '<div style="display:flex;"><a class="btn btn-success btn-sm" href="'.route('editcourselearningoutcome',$row->id).'">Edit</a>
    //                 <a class="btn btn-primary btn-sm" href="'.route('showcourselearningoutcome',$row->id).'">View</a></div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['status', 'course', 'action'])
    //             ->make(true);
    //     }
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $user = Auth::user();
        $roleId = session('role_key');
        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
        $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
        $course_ids = $hasFunctionalityPermission['course_ids'] ?? [];
         if ($flag === 'all') {
            $courses = CLO::select('course_id')
                ->orderBy('course_id')
                ->groupBy('course_id')
                ->get();
        }else{

            $courses = CLO::select('course_id')
                ->whereIn('course_id',$course_ids)
                ->orderBy('course_id')
                ->groupBy('course_id')
                ->get();
        }
        $clo_object = new CLO();
        $course_object = new Course();

        $program_object = new Program();

        return view('clo.manage',compact('courses','clo_object','course_object','program_object'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $course_ids = CLO::pluck('course_id')->toArray();
        // $courses = Course::select('id', 'name', 'code')
        //             ->whereNotIn('id', $course_ids)
        //             ->where('status', 1)
        //             ->get();
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
        return view('clo.add',compact('program'));
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
            'code_1'    => 'required',
            'course_id' => 'required|array|min:1',
        ], [
            'code_1.required'    => 'CLO Code is required',
            'course_id.required' => 'At least one course is required',
        ]);

        // Loop through each selected course
        foreach ($request->course_id as $courseId) {

            $cloCount = 1;
            while ($request->has("code_$cloCount")) {

                $level = 0;
                if ($request->input("domain_$cloCount") === '1') {
                    $level = $request->input("level2_$cloCount");
                } elseif ($request->input("domain_$cloCount") === '2') {
                    $level = $request->input("level3_$cloCount");
                } elseif ($request->input("domain_$cloCount") === '3') {
                    $level = $request->input("level4_$cloCount");
                }

                $clo = new CLO();
                $clo->course_id       = $courseId;
                $clo->code            = $request->input("code_$cloCount");
                $clo->weight          = $request->input("weight_$cloCount");
                $clo->domain          = $request->input("domain_$cloCount");
                $clo->emphasis_level  = $request->input("emphasis_level_$cloCount");
                $clo->description     = $request->input("description_$cloCount");
                $clo->level           = $level;
                $clo->created_by      = Auth::user()->id;
                $clo->save();

                $cloCount++;
            }
        }

        return redirect()->route('managecourselearningoutcome')
            ->with('success', 'Data Added Successfully');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'code_1' => 'required',
    //         'course_id' => 'required',
    //     ],
    //     [
    //         'code_1.required' => 'CLO Code is required',
    //         'course_id.required' => 'Course is required',
    //     ]);
    //     $cloCount = 1;
    //     while ($request->has("code_$cloCount")) {
    //         $level = '';
    //         if($request->input("domain_$cloCount") === '1'){
    //             $level = $request->input("level2_$cloCount");
    //         }else if($request->input("domain_$cloCount") === '2'){
    //             $level = $request->input("level3_$cloCount");
    //         }else if($request->input("domain_$cloCount") === '3'){
    //             $level =$request->input("level4_$cloCount");
    //         }else{
    //             $level = 0;
    //         }
    //         $clo = new CLO();
    //         $clo->course_id = $request->course_id ? $request->course_id : 0;
    //         $clo->code = $request->input("code_$cloCount");
    //         $clo->weight = $request->input("weight_$cloCount");
    //         $clo->domain = $request->input("domain_$cloCount");
    //         $clo->emphasis_level = $request->input("emphasis_level_$cloCount");
    //         $clo->description = $request->input("description_$cloCount");
    //         $clo->level = $level;
    //         $clo->created_by = Auth::user()->id;
    //         $clo->save();
    //         $cloCount++;
    //     }
    //     return redirect()->route('managecourselearningoutcome')->with('success','Data Added Successfully');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clo_object = new CLO();
        $course_object = new Course();
        $program_object = new Program();
        return view('clo.viewclo',compact('id','clo_object','course_object','program_object'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = Course::select('id','name','code')->wherestatus(1)->get();
        $clo_object = new CLO();
        $course_object = new Course();
        $program_object = new Program();
        return view('clo.edit',compact('id','clo_object','course_object','courses','program_object'));
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
         $course_id = $request->input('course_id');
         $clos_ids = $request->input('clos_ids') ? $request->input('clos_ids') : []; // Fetch the `clos_ids` array from the request or set to empty
         $clos_ids = array_map('intval', $clos_ids); // Convert all IDs to integers to ensure proper comparison

         // Get existing CLO IDs for the course
         $current_clo_ids = CLO::where('course_id', $course_id)->pluck('id')->toArray();

         // Find CLOs to delete
         $clo_ids_to_delete = array_diff($current_clo_ids, $clos_ids);
         if (!empty($clo_ids_to_delete)) {
             CLO::whereIn('id', $clo_ids_to_delete)->delete();
         }

         $cloCount = 1;

         while ($request->has("code_$cloCount")) {
             // Determine the level based on the domain
             $level = '';
             if ($request->input("domain_$cloCount") === '1') {
                 $level = $request->input("level2_$cloCount");
             } else if ($request->input("domain_$cloCount") === '2') {
                 $level = $request->input("level3_$cloCount");
             } else if ($request->input("domain_$cloCount") === '3') {
                 $level = $request->input("level4_$cloCount");
             } else {
                 $level = ''; // Default empty if domain is missing
             }

             $clo_id = $request->input("clo_id_$cloCount");
             $cloData = [
                 'course_id' => $course_id,
                 'code' => $request->input("code_$cloCount"),
                 'weight' => $request->input("weight_$cloCount"),
                 'domain' => $request->input("domain_$cloCount"),
                 'description' => $request->input("description_$cloCount"),
                 'level' => $level,
                 'created_by' => Auth::user()->id,
             ];

             if ($clo_id && in_array($clo_id, $clos_ids)) {
                 // Update existing CLO
                 CLO::where('id', $clo_id)->update($cloData);
             } else {
                 // Create a new CLO
                 CLO::create($cloData);
             }

             $cloCount++;
         }

         return redirect()->route('managecourselearningoutcome')->with('success', 'Data Updated Successfully');
     }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        CLO::whereid($id)->update($update_data);
        return redirect()->route('managecourselearningoutcome');
    }

    public function showPloByClo($id){
        $clos = CLO::with(['course'=>function($query) {
            return $query->select(['id', 'code']);
        }])->whereid($id)->latest()->get();
        $clo = $clos[0];

        $programs = Program::select('id','name')->wherestatus(1)->get();
        return view('clo.ploofclo',compact('clo','programs'));
    }
}
