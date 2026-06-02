<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PEO;
use App\Models\PLO;
use App\Models\PeoPrograms;
use App\Models\PeoKpis;
use App\Models\Program;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class PEOController extends Controller
{
    use TraitFunctions;
    // public function getPeo(Request $request)
    // {
    //     // if ($request->ajax()) {
    //     //     $user = Auth::user();
            
    //     //     $roleId = session('role_key');
    //     //     $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    //     //     $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
    //     //     if($flag === 'all'){
    //     //         $data = PEO::with(['program'=>function($query) {
    //     //             return $query->select(['id', 'name']);
    //     //         }])->latest()->get();

    //     //     }elseif($flag === 'institute'){
    //     //         $peoId = $hasFunctionalityPermission['peo_id'];
    //     //         $data =  (!empty($peoId)) ? PEO::with(['program'=>function($query) {
    //     //             return $query->select(['id', 'name']);
    //     //         }])->whereIn('id', $peoId)->latest()->get() :  null; 
    //     //     }elseif($flag === 'program'){
    //     //         $peoId = $hasFunctionalityPermission['peo_id'];
    //     //         $data =  (!empty($peoId)) ? PEO::with(['program'=>function($query) {
    //     //             return $query->select(['id', 'name']);
    //     //         }])->whereIn('id', $peoId)->latest()->get() :  null; 
    //     //     }elseif($flag === 'reports_dashboard'){
    //     //         $data =  [];
    //     //     }elseif($flag === 'enrolled_course'){
    //     //         $peoId = $hasFunctionalityPermission['peo_id'];
    //     //         $data =  (!empty($peoId)) ? PEO::with(['program'=>function($query) {
    //     //             return $query->select(['id', 'name']);
    //     //         }])->whereIn('id', $peoId)->latest()->get() :  null; 
    //     //     }elseif($flag === 'courseoffering_enrollment'){
    //     //         $peoId = $hasFunctionalityPermission['peo_id'];
    //     //         $data =  (!empty($peoId)) ? PEO::with(['program'=>function($query) {
    //     //             return $query->select(['id', 'name']);
    //     //         }])->whereIn('id', $peoId)->latest()->get() :  null; 
    //     //     }else{
    //     //         $data = [];
    //     //     }

    //         $user = Auth::user();
    //         $roleId = session('role_key');
    //         $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
    //         $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
    //         if($flag === 'all'){
    //             $data = PEO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->latest()->get();
    //         }elseif($flag === 'institute'){
    //             $peo_ids = $hasFunctionalityPermission['peo_id'];
    //             $data =  (!empty($peo_ids)) ? PEO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $peo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'program'){
    //             $peo_ids = $hasFunctionalityPermission['peo_id'];
    //             $data =  (!empty($peo_ids)) ? PEO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $peo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'reports_dashboard'){
    //             $data =  [];
    //         }elseif($flag === 'enrolled_course'){
    //             $peo_ids = $hasFunctionalityPermission['peo_id'];
    //             $data =  (!empty($peo_ids)) ? PEO::with(['program'=>function($query) {
    //                 return $query->select(['id', 'name']);
    //             }])->whereIn('id', $peo_ids)->latest()->get() :  null; 
    //         }elseif($flag === 'courseoffering_enrollment'){
    //             $data =  [];
    //         }else{
    //             $data =  [];
    //         }
            
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
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changepeostatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changepeostatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
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
    //                 <a class="btn btn-success btn-sm" href="'.route('editprogrameducationobjective',$row->id).'">Edit</a>
    //                 <a class="btn btn-primary btn-sm" href="'.route('showprogrameducationobjective',$row->id).'">View</a>
    //                 </div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['program','status','action'])
    //             ->make(true);
    //     // }
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
        $program_id = $hasFunctionalityPermission['program_id'] ?? [];
       
         if ($flag === 'all') {
            $program = PEO::select('program_id')
                ->orderBy('program_id')
                ->groupBy('program_id')
                ->get();
        }else{
            
            $program = PEO::select('program_id')
                ->whereIn('program_id',$program_id)
                ->orderBy('program_id')
                ->groupBy('program_id')
                ->get();
        }
        $program_object = new Program();
        $peo_object = new PEO();
        
        // return view('plo.manage',compact('program','plo_object','program_object','institute_object'));

        return view('peo.manage',compact('program','program_object','peo_object'));
        // $program_object = new Program();
        // $peo_object = new PEO();
        // $peos = PEO::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        return view('peo.add',compact('programs'));
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
            'code_1' => 'required',
            'description_1' => 'required',
            'program_id'=> 'required',
            'name_1' => 'required',
        ], 
        [
            'code_1.required' => 'Code required',
            'description_1.required' => 'PLO description required',
            'program_id.required' => 'Program required',
            'name_1.required' => 'Name required',
        ]);

        $peoCount = 1;
        while ($request->has("code_$peoCount")) {
            PEO::create([
                'code' => $request->input("code_$peoCount"),
                'name' => $request->input("name_$peoCount"),
                'description' => $request->input("description_$peoCount"),
                'program_id' => $request->program_id ? $request->program_id : 0,
                'created_by' => Auth::user()->id,
                'status' => 1,
            ]);
            $peoCount++;
        }

        return redirect()->route('manageprogrameducationobjective')->with('success', 'Data Added Successfully');

        // $request->validate([
        //     'code' => 'required',
        //     'description' => 'required',
        //     'program_id' => 'required',
        // ], 
        // [
        //     'program_id.required' => 'Program required',
        //     'description.required' => 'PEO description required',
        //     'code.required' => 'Code is required',
        // ]);
        
        // PEO::create([
        //     'code' => $request->code,
        //     'description' => $request->description,
        //     'strategies' => $request->strategies,
        //     'element' => $request->element,
        //     'program_id' => $request->program_id,
        //     'aligned_vision' => $request->aligned_vision ? 1 : 0 ,
        //     'aligned_mission' => $request->aligned_mission ? 1 : 0 ,
        //     'status' => $request->status,
        //     'created_by' => Auth::user()->id,
        // ]);
        // return redirect()->route('manageprogrameducationobjective')->with('success','Data Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peo_object = new PEO();
        $program_object = new Program();
        return view('peo.viewpeo',compact('id','peo_object','program_object'));
        // $peo = PEO::findOrFail($id);
        // $peos = PEO::all();
        // $peoprograms = PeoPrograms::all();
        // $programs = Program::select('id','name')->wherestatus(1)->get();
        // return view('peo.view',compact('peo','peos','programs','peoprograms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peo_object = new PEO();
        $program_object = new Program();
        return view('peo.edit',compact('id','peo_object','program_object'));

        // $peo = PEO::findOrFail($id);
        // $programs = Program::select('id','name')->wherestatus(1)->get();

        // return view('peo.edit',compact('peo','programs'));
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
        // $update_data = array(
        //     'code' => $request->code,
        //     'description' => $request->description,
        //     'strategies' => $request->strategies,
        //     'element' => $request->element,
        //     'program_id' => $request->program_id,
        //     'aligned_vision' => $request->aligned_vision ? 1 : 0 ,
        //     'aligned_mission' => $request->aligned_mission ? 1 : 0 ,
        //     // 'program_id' => json_encode($request->program_id),
        //     'status' => $request->status,
        // );
        // PEO::whereid($request->id)->update($update_data);
        $program_id = $request->input("program_id");
        PEO::where('program_id', $program_id)->delete();

        $peoCount = 1;
        $maxCLOs = 15; // You can set this to a higher value if you expect more CLOs

        for ($peoCount = 1; $peoCount <= $maxCLOs; $peoCount++) {
            if ($request->has("code_$peoCount")) {
              

                $peo = new PEO();
                $peo->program_id = $program_id;
                $peo->code = $request->input("code_$peoCount");
                $peo->name = $request->input("name_$peoCount");
                $peo->description = $request->input("description_$peoCount");
                $peo->created_by = Auth::user()->id;
                $peo->status = 1;
                $peo->save();
            }
        }
        return redirect()->route('manageprogrameducationobjective')->with('success','Data Updated Successfully');
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
        PEO::whereid($id)->update($update_data);
        return redirect()->route('manageprogrameducationobjective');
    }

    public function createPeoProgram(Request $request){

        PeoPrograms::create([
            'peo_id' => $request->peo_id ,
            'program_id' => $request->program_id,
            'program_vision' => $request->program_vision ,
            'program_mission' => $request->program_vision,
        ]);
        return response()->json(['success' =>true, 'message' =>'Successfully Created']);
    }  

    public function createPeoKpis(Request $request){

        PeoKpis::create([
            'peo_id' => $request->peo_id ,
            'name' => $request->name,
            'code' => $request->code ,
            'description' => $request->description ,
            'measured_when' => $request->measured_when ,
            'kpi_percentage' => $request->kpi_percentage ,
        ]);
        return response()->json(['success' =>true, 'message' =>'Successfully Created']);
    }


    public function showPeoProgrameData(Request $request){
        $i = 1;
        $peoprograms = PeoPrograms::with(['programs'=>function($query) {
            return $query->select(['id', 'name']);
        }])->wherepeo_id($request->id)->latest()->get();
        ?>
         <table id="datatable_peoprogram" class="datatable table table-stripped mb-0">
                                                
                                                
         <thead>
            <tr>
                <th> # </th>
                <th> Program</th>
                <th> Alignment with Program Vision</th>
                <th> Alignment with Program Mission</th>
                <!-- <th> Action</th> -->
            </tr>
        </thead>
        <tbody>
        <?php    
         foreach ($peoprograms as $peoprogram){
            echo "<pre>";
            print_r($peoprogram->programs);
            die();
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $peoprogram->programs->name; ?></td>
                    <td><?php echo $peoprogram->program_vision === 1  ? 'Yes' : 'NO'; ?></td>
                    <td><?php echo $peoprogram->program_mission === 1  ? 'Yes' : 'NO'; ?></td>
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
        $this->callDataTable('datatable_peoprogram');
    }

    public function showPeoKpisData(Request $request){
        $i = 1;
        $peokpis = PeoKpis::wherepeo_id($request->id)->get();
        ?>

            <table id="datatable_peokpis" class="datatable table table-stripped mb-0">
                                                
                                                
         <thead>
            <tr>
                <th> #</th>
                <th> Code</th>
                <th> Name</th>
                <th> Description</th>
                <th> KPIs %</th>
                <th> When Measured</th>
                <!-- <th> Action</th> -->
            </tr>
        </thead>
        <tbody>
        <?php    
         foreach ($peokpis as $peokpi){
            $measured_when = '-';
            if($peokpi->measured_when == 1){
                $measured_when = "After 1 year";
            }elseif($peokpi->measured_when == 2){
                $measured_when = "After 2 year";
            }elseif($peokpi->measured_when == 3){
                $measured_when = "After 3 year";
            }elseif($peokpi->measured_when == 4){
                $measured_when = "After 4 year";
            }elseif($peokpi->measured_when == 5){
                $measured_when = "After 5 year";
            }else{
                $measured_when = "-";
            }
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $peokpi->code; ?></td>
                    <td><?php echo $peokpi->name; ?></td>
                    <td><?php echo $peokpi->description; ?></td>
                    <td><?php echo $peokpi->kpi_percentage; ?></td>
                    <td><?php echo $measured_when; ?></td>
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
        $this->callDataTable('datatable_peokpis');
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
