<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProgramBatch;
use App\Models\Program;
use App\Models\PEO;
use App\Models\AcedemicYear;
use App\Models\PLO;
use App\Models\Cirriculum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use Yajra\DataTables\DataTables;

class ProgramBatchController extends Controller
{
    
    // use TraitFunctions;

    // public function getProgramBatchs(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = ProgramBatch::with(['program'=>function($query) {
    //             return $query->select(['id', 'name']);
    //         }])->latest()->get();
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
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changeprogrambatchstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changeprogrambatchstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
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
    //                 $actionBtn = '<div style="display:flex;"><a class="btn btn-success btn-sm" href="'.route('editprogrambatch',$row->id).'">Edit</a>
    //                 <a class="btn btn-primary btn-sm" href="'.route('showprogrambatch',$row->id).'">View</a></div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['status','action','program'])
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
    //     $check_all_permission = $this->checkPermissions('programbatch-all');
    //     $check_read_permission = $this->checkPermissions('programbatch-read');
    //     if($check_read_permission == true || $check_all_permission == true){
    //       $write_permission = $this->checkPermissions('programbatch-write');
    //       $edit_permission = $this->checkPermissions('programbatch-edit');
    //       $delete_permission = $this->checkPermissions('programbatch-delete');
    //       return view('programbatch.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
    //     $check_all_permission = $this->checkPermissions('programbatch-all');
    //     $check_create_permission = $this->checkPermissions('programbatch-write');
    //     if($check_create_permission == true  || $check_all_permission == true){
            
    //         $programs = Program::select('id','name')->wherestatus(1)->get();
    //         $acedemic_year = AcedemicYear::select('*')->wherestatus(1)->get();
    //         $cirriculum = Cirriculum::select('*')->wherestatus(1)->get();
    //         return view('programbatch.add',compact('cirriculum','programs','acedemic_year'));
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
    //         'name.required' => 'Organization Name is required'
    //     ]);
        
    //     ProgramBatch::create([
    //         'cirriculum_id' =>  $request->cirriculum_id,
    //         'acedemic_year' =>  $request->acedemic_year,
    //         'program_id' => $request->program_id,
    //         'no_of_session' =>  $request->no_of_session,
    //         'status' => $request->status,
    //         'theory_crdit_hr' =>    $request->theory_crdit_hr,
    //         'lab_crdit_hr' =>   $request->lab_crdit_hr,
    //         'description' =>    $request->description,
    //         'name' =>   $request->name,
    //         'use_in_obe' => $request->use_in_obe,
    //         'gpa_method' => $request->gpa_method,
    //         'mark_per' =>   $request->mark_per,
    //         'student_per' =>    $request->student_per,
    //         'plo_passing_threshold' =>  $request->plo_passing_threshold,
    //         'start_date' => $request->start_date,
    //         'end_date' =>   $request->end_date,
    //         'created_by' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('manageprogrambatch')->with('success','Data Added Successfully');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $programbatch = ProgramBatch::with(['program'])->whereid($id)->latest()->get();
    //     $programbatch =$programbatch[0];
        
    //     return view('programbatch.view',compact('programbatch'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $programbatch = ProgramBatch::find($id);
    //     $programs = Program::select('id','name')->wherestatus(1)->get();
    //     $acedemic_year = AcedemicYear::select('*')->wherestatus(1)->get();
    //     return view('programbatch.edit',compact('programbatch','acedemic_year','programs'));
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
    //         'acedemic_year' =>  $request->acedemic_year,
    //         'cirriculum_id' =>  $request->cirriculum_id,
    //         'program_id' => $request->program_id,
    //         'no_of_session' =>  $request->no_of_session,
    //         'status' => $request->status,
    //         'theory_crdit_hr' =>    $request->theory_crdit_hr,
    //         'lab_crdit_hr' =>   $request->lab_crdit_hr,
    //         'description' =>    $request->description,
    //         'name' =>   $request->name,
    //         'use_in_obe' => $request->use_in_obe,
    //         'gpa_method' => $request->gpa_method,
    //         'mark_per' =>   $request->mark_per,
    //         'student_per' =>    $request->student_per,
    //         'plo_passing_threshold' =>  $request->plo_passing_threshold,
    //         'start_date' => $request->start_date,
    //         'end_date' =>   $request->end_date,
    //     );
    //     ProgramBatch::whereid($request->id)->update($update_data);
    //     return redirect()->route('manageprogrambatch')->with('success','Data Updated Successfully');
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
    //     ProgramBatch::whereid($id)->delete();
    //     return redirect()->route('manageprogrambatch')->with('error','Data Deleted Successfully');
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
    //     ProgramBatch::whereid($id)->update($update_data);
    //     return redirect()->route('manageprogrambatch');
    // }
    
    // public function showPlo($id)
    // {

    //     $courseclo = array(); 
    //     $plos = PLO::with(['peo'])->whereprogram_batch_id($id)->latest()->get();
    //     return view('programbatch.showplo',compact('id','plos'));
    // }

    //  /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function createPlo($id)
    // { 
    //     $peos =  PEO::select('id','code','description')->wherestatus(1)->get();
    //     return view('programbatch.addplo',compact('id','peos'));  
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function storePlo(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required',
    //         'name' => 'required',
    //     ], 
    //     [
    //         'code.required' => 'Code is required',
    //         'name.required' => 'Name is required',
    //     ]);
         
    //     PLO::create([
    //         'code' => $request->code,
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'strategies' => $request->strategies,
    //         'knowledge_profile' => $request->knowledge_profile,
    //         'program_batch_id' => $request->program_batch_id ? $request->program_batch_id : 0 ,
    //         'peo_id' => $request->peo_id ? $request->peo_id : 0 ,
    //         'created_by' => Auth::user()->id,
    //     ]);
    //     return redirect()->route('showplo',$request->program_batch_id)->with('success','Data Added Successfully');
    // }

}
