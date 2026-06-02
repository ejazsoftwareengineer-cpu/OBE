<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RubricScoreSet;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RubricScoreSetController extends Controller
{
    // public function getRubricScroreSets(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = RubricScoreSet::latest()->get();
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
    //                                 <a class="dropdown-item" onclick="changeStatus('.$i.route('changerubricscoresetstatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
    //                                 <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changerubricscoresetstatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
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
    //                 $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editrubricscoreset',$row->id).'">Edit</a>';
    //                 // $actionBtn = '<div class="dropdown dropdown-action">
    //                 //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
    //                 //                     <div class="dropdown-menu dropdown-menu-right">
    //                 //                         <a class="dropdown-item" href="'.route('editrubricscoreset',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
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
    //     return view('rubricscoreset.manage');
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('rubricscoreset.add');
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
    //         'name.required' => 'Name is required',
    //     ]);

    //     RubricScoreSet::create([
    //         'name' => $request->name,
    //         'status' => $request->status,
    //         'description' => $request->description,
    //         'created_by' => Auth::user()->id,
    //     ]);
    //     return redirect()->route('managerubricscoreset')->with('success','Data Added Successfully');
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
    //     $rubricscoreset = RubricScoreSet::find($id);
    //     return view('rubricscoreset.edit',compact('rubricscoreset'));
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
    //         'name' => $request->name,
    //         'status' => $request->status,
    //         'description' => $request->description,
    //     );
    //     RubricScoreSet::whereid($request->id)->update($update_data);
    //     return redirect()->route('managerubricscoreset')->with('success','Data Updated Successfully');
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
    //     RubricScoreSet::whereid($id)->delete();
    //     return redirect()->route('managerubricscoreset')->with('error','Data Deleted Successfully');
    // }

    // public function changeStatus()
    // {
    //     $id = $_REQUEST['id'];
    //     $status = $_REQUEST['status'];
    //     $update_data = array(
    //         'status' => $status,
    //     );
    //     RubricScoreSet::whereid($id)->update($update_data);
    //     return redirect()->route('managerubricscoreset');
    // }
}
