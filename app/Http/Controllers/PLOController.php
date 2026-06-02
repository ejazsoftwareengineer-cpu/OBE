<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PLO;
use App\Models\PEO;
use App\Models\Program;
use App\Models\PloPeo;
use App\Models\Institute;
use App\Models\PloKpis;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class PLOController extends Controller
{
    use TraitFunctions;
    // public function getPlo(Request $request)
    // {
    //     // if ($request->ajax()) {
    //         $user = Auth::user();
    //         $roleId = session('role_key');
    //         $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    //         $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
    //         if($flag === 'all'){
    //             $data = PLO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->latest()->get();
    //         }elseif($flag === 'institute'){
    //             $plo_ids = $hasFunctionalityPermission['plo_id'];
    //             $data =  (!empty($plo_ids)) ? PLO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $plo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'program'){
    //             $plo_ids = $hasFunctionalityPermission['plo_id'];
    //             $data =  (!empty($plo_ids)) ? PLO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $plo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'reports_dashboard'){
    //             $data =  [];
    //         }elseif($flag === 'enrolled_course'){
    //             $plo_ids = $hasFunctionalityPermission['plo_id'];
    //             $data =  (!empty($plo_ids)) ? PLO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $plo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'courseoffering_enrollment'){
    //             $data =  [];
    //         }else{
    //             $data =  [];
    //         }
            
    //         // $user = Auth::user();
            
    //         // $roleId = session('role_key');
    //         // $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    //         // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;

    //         // // echo "<pre>";
    //         // // print_r($hasFunctionalityPermission);
    //         // // die();
            
    //         // if($flag === 'all'){
    //         //     $data = PLO::with(['program'=>function($query) {
    //         //         return $query->select(['id', 'name']);
    //         //     }])->latest()->get();

    //         // }elseif($flag === 'institute'){
    //         //     $ploId = $hasFunctionalityPermission['plo_id'];
    //         //     $data =  (!empty($ploId)) ? PLO::with(['program'=>function($query) {
    //         //         return $query->select(['id', 'name']);
    //         //     }])->whereIn('id', $ploId)->latest()->get() :  null; 
    //         // }elseif($flag === 'program'){
    //         //     // $ploId = $hasFunctionalityPermission['plo_id'];
    //         //     $data =  PLO::with(['program'=>function($query) {
    //         //         return $query->select(['id', 'name']);
    //         //     }])->latest()->get(); 
    //         //     // echo "<pre>";
    //         //     // print_r($data);
    //         //     // die('hh');
    //         //     // $data =  (!empty($ploId)) ? PLO::with(['program'=>function($query) {
    //         //     //     return $query->select(['id', 'name']);
    //         //     // }])->whereIn('id', $ploId)->latest()->get() :  null; 
    //         // }elseif($flag === 'reports_dashboard'){
    //         //     $data =  [];
    //         // }elseif($flag === 'enrolled_course'){
    //         //     $ploId = $hasFunctionalityPermission['plo_id'];
    //         //     $data =  (!empty($ploId)) ? PLO::with(['program'=>function($query) {
    //         //         return $query->select(['id', 'name']);
    //         //     }])->whereIn('id', $ploId)->latest()->get() :  null; 
    //         // }elseif($flag === 'courseoffering_enrollment'){
    //         //     $ploId = $hasFunctionalityPermission['plo_id'];
    //         //     $data =  (!empty($ploId)) ? PLO::with(['program'=>function($query) {
    //         //         return $query->select(['id', 'name']);
    //         //     }])->whereIn('id', $ploId)->latest()->get() :  null; 
    //         // }else{
    //         //     $data = [];
    //         // }
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('program', function($row){
    //                 $program = '';
    //                 $i = "'";
    //                 if($row->program){
    //                     $program = $row->program->name;
    //                 }else{
    //                     $program = '-';
    //                 }
    //                 $programlabel = $program;
    //                 return $programlabel;
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
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changeplostatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeplostatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
    //                             </div>
    //                         </div>';
    //                 return $statusBtn;
    //             })
    //             ->addColumn('action', function($row){

    //                 // $check_all_permission = $this->checkPermissions('campus-all'); 
    //                 // $edit_permission = $this->checkPermissions('campus-edit');
    //                 // $actionBtn = '';
    //                 // if($edit_permission === true || $check_all_permission === true){
                    
    //                 // }
    //                 $actionBtn = '<div style="display:flex;">
    //                 <a class="btn btn-primary btn-sm" href="'.route('showprogramlearningoutcome',$row->id).'">View</a>
    //                 <a class="btn btn-success btn-sm" href="'.route('editprogramlearningoutcome',$row->id).'">Edit</a></div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['status', 'program', 'action'])
    //             ->make(true);
    //     // }
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('plo.manage');
    // }
    public function index()
    {
        $user = Auth::user();
        $roleId = session('role_key');
        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
        $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
        $program_id = $hasFunctionalityPermission['program_id'] ?? [];
         if ($flag === 'all') {
            $program = PLO::select('program_id')
                ->orderBy('program_id')
                ->groupBy('program_id')
                ->where('status' , 1)
                ->get();
        }else{
            
            $program = PLO::select('program_id')
                ->whereIn('program_id',$program_id)
                ->orderBy('program_id')
                ->groupBy('program_id')
                ->where('status' , 1)
                ->get();
        }
        $plo_object = new PLO();
        $program_object = new Program();
        $institute_object = new Institute();
        
        return view('plo.manage',compact('program','plo_object','program_object','institute_object'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $departments = Department::select('id','name')->wherestatus(1)->get();
        $user = Auth::user();
        $roleId = session('role_key');
        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
        // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
        $program_id = $hasFunctionalityPermission['program_id'] ?? [];
        $institute_id = $hasFunctionalityPermission['institute_id'] ?? [];
// echo "<pre>";
// print_r($program_id);
// die();
        if($program_id && $institute_id){
            $programs = Program::select('id','name')->whereIn('id',$program_id)->wherestatus(1)->get();
            $institute = Institute::select('id','name')->whereIn('id',$institute_id)->wherestatus(1)->get();
        }else{
            $programs = Program::select('id','name')->wherestatus(1)->get();
            $institute = Institute::select('id','name')->wherestatus(1)->get();
        }

        // $programs = Program::select('id','name')->wherestatus(1)->get();
        return view('plo.add',compact('institute','programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // exit('store');
        // Validate the general PLO data
        $request->validate([
            'code_1' => 'required',
            'description_1' => 'required',
            // 'institute_id'=> 'required',
            'program_id'=> 'required',
            'name_1' => 'required',
        ], 
        [
            'code_1.required' => 'Code required',
            'description_1.required' => 'PLO description required',
            // 'institute_id.required' => 'Institute required',
            'program_id.required' => 'Program required',
            'name_1.required' => 'Name required',
        ]);

        $ploCount = 1;
        while ($request->has("code_$ploCount")) {
            PLO::create([
                'code' => $request->input("code_$ploCount"),
                'name' => $request->input("name_$ploCount"),
                'description' => $request->input("description_$ploCount"),
                // 'strategies' => $request->input("strategies_$ploCount"),
                // 'knowledge_profile' => $request->input("knowledge_profile_$ploCount"),
                // 'institute_id' => $request->institute_id ? $request->institute_id : 0,
                'program_id' => $request->program_id ? $request->program_id : 0,
                // 'status' => $request->input("status_$ploCount"),
                'created_by' => Auth::user()->id,
                'status' => 1,
            ]);
            $ploCount++;
        }

        return redirect()->route('manageprogramlearningoutcome')->with('success', 'Data Added Successfully');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required',
    //         'description' => 'required',
    //         'institute_id'=> 'required',
    //         'program_id'=> 'required',
    //         // 'program_batch_id'=> 'required',
    //         // 'wa_code' => 'required',
    //         'name' => 'required',
    //     ], 
    //     [
    //         'code.required' => 'Code required',
    //         'description.required' => 'PLO description required',
    //         'institute_id.required' => 'Department required',
    //         'program_id.required' => 'Program required',
    //         // 'program_batch_id.required' => 'Program batch required',
    //         // 'wa_code.required' => 'WA Code required',
    //         'name.required' => 'Name required',
    //     ]);
         
    //     PLO::create([
    //         'code' => $request->code,
    //         // 'wa_code' => $request->wa_code,
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'strategies' => $request->strategies,
    //         'knowledge_profile' => $request->knowledge_profile,
    //         // 'department_id' => $request->department_id ? $request->department_id : 0 ,
    //         'institute_id' => $request->institute_id ? $request->institute_id : 0 ,
    //         'program_id' => $request->program_id ? $request->program_id : 0 ,
    //         // 'program_batch_id' => $request->program_batch_id ? $request->program_batch_id : 0 ,
    //         'status' => $request->status,
    //         'created_by' => Auth::user()->id,
    //     ]);
    //     return redirect()->route('manageprogramlearningoutcome')->with('success','Data Added Successfully');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plo_object = new PLO();
        $institute_object = new Institute();
        $program_object = new Program();
        return view('plo.viewplo',compact('id','plo_object','institute_object','program_object'));
        
        // $plos = PLO::with([
        //     'program'=>function($query) {
        //         return $query->select(['id', 'name']);
        //     },
        //     'institute'=>function($query) {
        //         return $query->select(['id', 'name']);
        //     },
        // ])->whereid($id)->latest()->get();
        // $plo = $plos[0];
        // $peos = PEO::select('id', 'code', 'description')->wherestatus(1)->get();
        // return view('plo.view',compact('plo','peos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $plos = PLO::with([
        //     'program'=>function($query) {
        //         return $query->select(['id', 'name']);
        //     },
        //     'institute'=>function($query) {
        //         return $query->select(['id', 'name']);
        //     }
        // ])->whereid($id)->latest()->get();
        // $plo = $plos[0];
        // $institute = Institute::select('id','name')->wherestatus(1)->get();

        // $courses = Course::select('id','name','code')->wherestatus(1)->get();
        $plo_object = new PLO();
        $institute_object = new Institute();
        $program_object = new Program();
        return view('plo.edit',compact('id','plo_object','institute_object','program_object'));

        // return view('plo.edit',compact('plo','institute'));
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
        //  echo "<pre>";
        // print_r($request->all());
        // die();
        // $institute_id = $request->input("institute_id");
        $program_id = $request->input("program_id");

        // Retrieve existing PLO IDs for the given program
        $current_plo_ids = PLO::where('program_id', $program_id)->pluck('id')->toArray();
        $plo_ids_from_request = []; // To keep track of PLO IDs provided in the request

        $ploCount = 1;
        $maxPLOs = 15; // Maximum number of PLOs expected

        for ($ploCount = 1; $ploCount <= $maxPLOs; $ploCount++) {
            if ($request->has("code_$ploCount")) {
                $plo_id = $request->input("plo_id_$ploCount"); // Assuming 'plo_id_x' is provided for each PLO

                // Collect IDs from request to manage deletions later
                if ($plo_id) {
                    $plo_ids_from_request[] = $plo_id;
                }

                $ploData = [
                    // 'institute_id' => $institute_id,
                    'program_id' => $program_id,
                    'code' => $request->input("code_$ploCount"),
                    'name' => $request->input("name_$ploCount"),
                    'description' => $request->input("description_$ploCount"),
                    'created_by' => Auth::user()->id,
                    'status' => 1,
                ];

                if ($plo_id && in_array($plo_id, $current_plo_ids)) {
                    // Update existing PLO
                    PLO::where('id', $plo_id)->update($ploData);
                } else {
                    // Create new PLO
                    $newPlo = new PLO();
                    $newPlo->fill($ploData);
                    $newPlo->save();
                }
            }
        }

        // Delete PLOs not in the current request
        $plo_ids_to_delete = array_diff($current_plo_ids, $plo_ids_from_request);
        PLO::whereIn('id', $plo_ids_to_delete)->delete();

        // $institute_id = $request->input("institute_id");
        // $program_id = $request->input("program_id");
        // PLO::where('program_id', $program_id)->delete();

        // $ploCount = 1;
        // $maxCLOs = 15; // You can set this to a higher value if you expect more CLOs

        // for ($ploCount = 1; $ploCount <= $maxCLOs; $ploCount++) {
        //     if ($request->has("code_$ploCount")) {
              

        //         $plo = new PLO();
        //         $plo->institute_id = $institute_id;
        //         $plo->program_id = $program_id;
        //         $plo->code = $request->input("code_$ploCount");
        //         $plo->name = $request->input("name_$ploCount");
        //         $plo->description = $request->input("description_$ploCount");
        //         $plo->created_by = Auth::user()->id;
        //         $plo->status = 1;
        //         $plo->save();
        //     }
        // }
        // $update_data = array(
        //     'code' => $request->code,
        //     // 'wa_code' => $request->wa_code,
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     // 'strategies' => $request->strategies,
        //     // 'knowledge_profile' => $request->knowledge_profile,
        //     // 'institute_id' => $request->institute_id,
        //     // 'department_id' => $request->department_id,
        //     // 'program_id' => $request->program_id ,
        //     // 'program_batch_id' => $request->program_batch_id,
        //     // 'status' => $request->status,
        // );
        // PLO::whereid($request->id)->update($update_data);
        return redirect()->route('manageprogramlearningoutcome')->with('success','Data Updated Successfully');
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
        PLO::whereid($id)->update($update_data);
        return redirect()->route('manageprogramlearningoutcome');
    }

    public function createPloPeo(Request $request){

        PloPeo::create([
            'peo_id' => $request->peo_id ,
            'plo_id' => $request->plo_id ,
            'weight' => $request->weight,
        ]);
        return response()->json(['success' =>true, 'message' =>'Successfully Created']);
    }   
    
    public function createPloProgram(Request $request){

        PloPeo::create([
            'peo_id' => $request->peo_id ,
            'plo_id' => $request->plo_id ,
            'weight' => $request->weight,
        ]);
        return response()->json(['success' =>true, 'message' =>'Successfully Created']);
    }  

    public function createPloKpis(Request $request){

        PloKpis::create([
            'plo_id' => $request->plo_id ,
            'name' => $request->name,
            'code' => $request->code ,
            'description' => $request->description ,
            'measured_when' => $request->measured_when ,
            'kpi_percentage' => $request->kpi_percentage ,
        ]);
        return response()->json(['success' =>true, 'message' =>'Successfully Created']);
    }

    public function showPloProgramData(Request $request){
        $i = 1;
        $plopeos = PloPeo::with(['peo'=>function($query) {
            return $query->select(['id', 'code', 'description']);
        }])->wherepeo_id($request->id)->latest()->get();
        ?>
         <table id="datatable_ploprogram" class="datatable table table-stripped mb-0">
                                                
                                                
         <thead>
            <tr>
                <th> # </th>
                <th> Program</th>
                <th> Session</th>
                <!-- <th> Action</th> -->
            </tr>
        </thead>
        <tbody>
        <?php    
     
         ?>
        </tbody>
        </table>
        <?php 
        $this->callDataTable('datatable_ploprogram');
    }

    public function showPloPeoData(Request $request){
        $i = 1;
        $plopeos = PloPeo::with(['peo'=>function($query) {
            return $query->select(['id', 'code', 'description']);
        }])->wherepeo_id($request->id)->latest()->get();
        ?>
         <table id="datatable_plopeo" class="datatable table table-stripped mb-0">
                                                
                                                
         <thead>
            <tr>
                <th> # </th>
                <th> Peo</th>
                <th> Weight</th>
                <!-- <th> Action</th> -->
            </tr>
        </thead>
        <tbody>
        <?php    
         foreach ($plopeos as $plopeo){
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $plopeo->peo->code . ' - ' . $plopeo->peo->description ; ?></td>
                    <td><?php echo $plopeo->weight ;?></td>
                    <!-- <td class="text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit m-r-5"></i></button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash m-r-5"></i></button>
                    </td> -->
                </tr>
            <?php 
            $i++;
         }
         ?>
        </tbody>
        </table>
        <?php 
        $this->callDataTable('datatable_plopeo');
    }

    public function showPloKpisData(Request $request){
        $i = 1;
        $peokpis = PloKpis::whereplo_id($request->id)->get();
        ?>

            <table id="datatable_plokpis" class="datatable table table-stripped mb-0">
                                  
         <thead>
            <tr>
                <th> #</th>
                <th> Code</th>
                <th> Name</th>
                <th> Description</th>
                <th> KPIs %</th>
                <th> When Measured</th>
            </tr>
        </thead>
        <tbody>
        <?php    
         foreach ($peokpis as $peokpi){
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $peokpi->code; ?></td>
                    <td><?php echo $peokpi->name; ?></td>
                    <td><?php echo $peokpi->description; ?></td>
                    <td><?php echo $peokpi->kpi_percentage; ?></td>
                    <td><?php echo $peokpi->measured_when; ?></td>
                    <!-- <td class="text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit m-r-5"></i></button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash m-r-5"></i></button>
                    </td> -->
                </tr>
            <?php 
            $i++;
         }
         ?>
        </tbody>
        </table>
        <?php 
        $this->callDataTable('datatable_plokpis');
    }

    public function callDataTable($datatable){
        ?>
        <script>
          $('#<?php echo $datatable;?>').dataTable( {
            "bDestroy": true,
            "searching": true,
            scrollCollapse: true,
            scrollY: true,
            lengthMenu: [[100, 150, -1], [100, 150, "All"]],
          } );
        </script>
        <?php
    }
}
