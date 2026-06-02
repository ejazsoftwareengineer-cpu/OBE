<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Module;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;

class ModuleController extends Controller
{
    use TraitFunctions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getModules(Request $request)
    {
        if ($request->ajax()) {
            $data = Module::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
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
                                    <a class="dropdown-item" onclick="changeStatus('.$i.route('changemodulestatus').$i.','. $row->id.',1)"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('.$i.route('changemodulestatus').$i.','.$row->id.',0)"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                </div>
                            </div>';
                    return $statusBtn;
                })
                ->addColumn('action', function($row){

                    $check_all_permission = $this->checkPermissions('module-all'); 
                    $edit_permission = $this->checkPermissions('module-edit');
                    $actionBtn = '';
                    if($edit_permission === true || $check_all_permission === true){
                    
                        $actionBtn = '<a class="btn btn-success btn-sm" href="'.route('editmodule',$row->id).'">Edit</a>';        
                    }
                    // $actionBtn = '<div class="dropdown dropdown-action">
                    //                     <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    //                     <div class="dropdown-menu dropdown-menu-right">
                    //                         <a class="dropdown-item" href="'.route('editmodule',$row->id).'"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    //                     </div>
                    //                 </div>';
                    return $actionBtn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
    }

    public function index()
    {
        $check_all_permission = $this->checkPermissions('module-all');
        $check_read_permission = $this->checkPermissions('module-read');
        if($check_read_permission == true || $check_all_permission == true){
            $write_permission = $this->checkPermissions('module-write');
            $edit_permission = $this->checkPermissions('module-edit');
            $delete_permission = $this->checkPermissions('module-delete');
            return view('module.manage',compact('write_permission','edit_permission','delete_permission','check_all_permission'));
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
        $check_all_permission = $this->checkPermissions('module-all'); 
        $check_create_permission = $this->checkPermissions('module-write');
        if($check_create_permission == true || $check_all_permission == true){
            
            $category = Category::select('id','name')->wherestatus(1)->get();
            return view('module.add', compact('category'));
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
            'module_name' => 'required',
        ], 
        [
            'module_name.required' => 'Module Name is required',
        ]);

        Module::create([
            'module_name' => $request->module_name,
            'slug' => $request->slug,
            'menu_template' => $request->menu_template,
            'icon' => $request->icon,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('managemodule')->with('success','Data Added Successfully');
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
        $module = Module::find($id);
        $category = Category::select('id','name')->wherestatus(1)->get();
        return view('module.edit',compact('module','category'));
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
            'module_name' => $request->module_name,
            'slug' => $request->slug,
            'menu_template' => $request->menu_template,
            'category_id' => $request->category_id,
            'icon' => $request->icon,
            'status' => $request->status,
        );
        Module::whereid($request->id)->update($update_data);
        return redirect()->route('managemodule')->with('success','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $_REQUEST['id'];
        Module::whereid($id)->delete();
        return redirect()->route('managemodule')->with('error','Data Deleted Successfully');
    }

    public function changeStatus()
    {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $update_data = array(
            'status' => $status,
        );
        Module::whereid($id)->update($update_data);
        return redirect()->route('managemodule');
    }

}
