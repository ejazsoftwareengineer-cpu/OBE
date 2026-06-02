<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rubric;
use App\Models\RubricScoreSet;
use App\Models\RubricQuestion;
use App\Models\Institute;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RubricController extends Controller
{
    // public function getRubrics(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Rubric::latest()->get();
    //         return Datatables::of($data)
    //             ->addIndexColumn()
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
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changerubricstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changerubricstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
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
    //                 $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editrubric',$row->id).'">Edit</a>';
    //                 // $actionBtn = '<div class="dropdown dropdown-action">
    //                 //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
    //                 //                     <div class="dropdown-menu dropdown-menu-right">
    //                 //                         <a class="dropdown-item" href="'.route('editrubric',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
    //                 //                     </div>
    //                 //                 </div>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['status','action'])
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
    //     return view('rubric.manage');
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $organization = Organization::select('id','name')->wherestatus(1)->get();
    //     $institute = Institute::select('id','name')->wherestatus(1)->get();
    //     $rubric_ss = RubricScoreSet::select('id','name')->wherestatus(1)->get();
    //     return view('rubric.add',compact('institute','rubric_ss'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $rubric = new Rubric();
    //     $rubric->institute_id = $request->input('institute_id');
    //     $rubric->name = $request->input('name');
    //     $rubric->rubric_score_set_id = $request->input('rubric_score_set_id');
    //     $rubric->comment = $request->input('comment');
    //     $rubric->status = $request->input('status');
    //     $rubric->save();
    //     $questionCount = 1;
    //     while ($request->has("question_name_$questionCount")) {
    //         $rubricquestion = new RubricQuestion(); 
    //         $rubricquestion->rubric_id = $rubric->id;
    //         $rubricquestion->question = $request->input("question_name_$questionCount");
    //         $rubricquestion->weight = $request->input("question_weight_$questionCount");
    //         $rubricquestion->description = $request->input("description_$questionCount");
    //         $rubricquestion->save();
    //         $questionCount++;
    //     }
    //     return response()->json(['message' => 'Rubric added successfully']);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
        
    //     $rubric = Rubric::find($id);
    //     $organization = Organization::select('id','name')->wherestatus(1)->get();
    //     $institute = Institute::select('id','name')->wherestatus(1)->get();
    //     $rubric_ss = RubricScoreSet::select('id','name')->wherestatus(1)->get();
    //     $rubric_question = RubricQuestion::select('*')->whererubric_id($id)->get();
    //     return view('rubric.edit',compact('institute','rubric_ss','rubric','rubric_question'));
    //     // return view('rubric.edit',compact('rubric'));
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
    //     // $rubric = new Rubric();
    //     $update_data = array(
    //         'name' => $request->input('name'),
    //         'institute_id' => $request->input('institute_id'),
    //         'rubric_score_set_id' => $request->input('rubric_score_set_id'),
    //         'comment' => $request->input('comment'),
    //         'status' => $request->input('status'),
    //     );
    //     Rubric::whereid($request->input('id'))->update($update_data);
    //     $questionCount = 1;
    //     while ($request->has("question_name_$questionCount")) {
    //         $rubric_ques = RubricQuestion::find($request->input("question_id_$questionCount"));
    //         if($rubric_ques){
    //             $update_data = array(
    //                 'rubric_id' => $request->input('id'),
    //                 'question' => $request->input("question_name_$questionCount"),
    //                 'weight' => $request->input("question_weight_$questionCount"),
    //                 'description' => $request->input("description_$questionCount")
    //             );
    //             RubricQuestion::whereid($request->input("question_id_$questionCount"))->update($update_data);
    //         }else{
    //             $rubricquestion = new RubricQuestion(); 
    //             $rubricquestion->rubric_id = $rubric->id;
    //             $rubricquestion->question = $request->input("question_name_$questionCount");
    //             $rubricquestion->weight = $request->input("question_weight_$questionCount");
    //             $rubricquestion->description = $request->input("description_$questionCount");
    //             $rubricquestion->save();
    //         }
    //         $questionCount++;
    //     }
    //     return response()->json(['message' => 'Rubric added successfully']);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $id = $_REQUEST['id'];
    //     Rubric::whereid($id)->delete();
    //     return redirect()->route('managerubric')->with('error','Data Deleted Successfully');
    // }

    // public function changeStatus()
    // {
    //     $id = $_REQUEST['id'];
    //     $status = $_REQUEST['status'];
    //     $update_data = array(
    //         'status' => $status,
    //     );
    //     Rubric::whereid($id)->update($update_data);
    //     return redirect()->route('managerubric');
    // }
}
