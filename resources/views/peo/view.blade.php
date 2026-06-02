<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | Program Education Objective</title>      
        <style>
            tr {

                max-width: 60px !important;
            }
        </style>
        @extends('layouts.backend.app')

        @section('content')
        <!-- Page Wrapper -->
        <div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">PEO</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Program Education Objective</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="#peo_view" data-toggle="tab" class="nav-link active">View</a></li>
                                <!-- <li class="nav-item"><a href="#peo_programs" data-toggle="tab" class="nav-link " onclick="showPeoProgramData({{$peo->id}},'{{route('showpeoprogramedata')}}')">Programs</a></li> -->
                                <!-- <li class="nav-item"><a href="#peo_kpis" data-toggle="tab" class="nav-link" onclick="showPeoKpisData({{$peo->id}},'{{route('showpeokpisdata')}}')">Peo KPIs</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                
                    <!-- View PEO -->
                    <div id="peo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">                            
                            <input type="hidden" id="peo_id" name="id" value="{{  $peo->id  }}">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">{{ $peo->code }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="personal-info">
                                            <table class="table table-bordered mb-0 personal-info">
                                                <tbody>
                                                    <tr >
                                                        <th>Code</th>
                                                        <td>{{ $peo->code }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Description</th>
                                                        <td>{{ $peo->description }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Elements</th>
                                                        <td>{{ $peo->element }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Strategies</th>
                                                        <td>{{ $peo->strategies }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Aligned with Riphah International University Vision</th>
                                                        <td>@php if($peo->aligned_vision === 1 ){echo 'Yes'; }else{echo 'No';}  @endphp</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Aligned with Riphah International University Mission</th>
                                                        <td>@php if($peo->aligned_mission === 1 ){echo 'Yes'; }else{echo 'No';}  @endphp</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Active</th>
                                                        <td>@php if($peo->status === 1 ){echo 'Yes'; }else{echo 'No';}  @endphp</td>
                                                    </tr>
                                                </tbody>
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!-- /View PEO -->
                    
                    <!-- Program PEO -->
                    <div class="tab-pane fade" id="peo_programs">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="mt-3 mr-3">
                                        <a href="#" onclick="openAssignProgramModal()" class="btn add-btn" style="width: 10px;">Add</a>
                                    </div >
                                    <div class="card-body">
                                        <div id="div_datatable_peoprogram" class="table-responsive">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Program PEO -->

                    <!-- PEO KPIs -->
                    <div class="tab-pane fade" id="peo_kpis" >
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="mt-3 mr-3">
                                        <a href="#" onclick="openPeoKpisModal()" class="btn add-btn" style="width: 10px;">Add</a>
                                    </div >
                                    <div class="card-body">
                                        <div  id="div_datatable_peokpis" class="table-responsive" >
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /PEO KPIs -->
                    
                </div>
            </div>
            <!-- /Page Content -->
            
            <!-- Assign Program Modal -->
            <div id="assign_program" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add PEO Program</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Program</label>
                                        <select id ="program_id" name="program_id" class="select">
                                            <option value="" selected > - Select Program -</option>
                                            @foreach ($programs as $program)
                                                <option value="{{ $program->id }}" >{{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="d-block">Alignment With Program Vision</label>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="aligned_vision" name="aligned_vision" value="0" class="check">
                                            <label for="aligned_vision" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="d-block">Alignment With Program Vision</label>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="aligned_mission" name="aligned_mission" value="0" class="check">
                                            <label for="aligned_mission" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="submit-section">
                                <button id="save_peo_program" class="btn btn-success" onclick="savePeoProgram('{{route('addpeoprogram')}}','{{route('showpeoprogramedata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign Program Modal -->

            <!-- Add KPIs Modal -->
            <div id="open_peo_kpis" class="modal custom-modal fade"  role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add PEO KPIs</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Code <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="code" name="code" placeholder="Enter KPI code">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Description<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="description" id="description" placeholder="Enter Description">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Set KPI % <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" min="0" max="100" id="kpi_percentage" name="kpi_percentage"placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Measured When <span class="text-danger">*</span></label>
                                        <select   id="measured_when" name="measured_when" class="select">
                                            <option value="">- Select -</option>
                                            <option value="1">After 1 year</option>
                                            <option value="2">After 2 year</option>
                                            <option value="3">After 3 year</option>
                                            <option value="4">After 4 year</option>
                                            <option value="5">After 5 year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="submit-section"> 
                                <button id="save_peo_kpis" class="btn btn-success" onclick="savePeoKpis('{{route('addpeokpis')}}','{{route('showpeokpisdata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add KPIs Modal -->
           
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')

        @endsection
