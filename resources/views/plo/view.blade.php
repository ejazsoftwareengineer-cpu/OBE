<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | Program Learning Outcome</title>      
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
                            <h3 class="page-title">PLO</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Program Learning Outcome</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="#plo_view" data-toggle="tab" class="nav-link active">View</a></li>
                                <!-- <li class="nav-item"><a href="#plo_peos" data-toggle="tab" class="nav-link" onclick="showPloPeoData({{$plo->id}},'{{route('showplopeodata')}}')">PEOs</a></li> -->
                                <!-- <li class="nav-item"><a href="#plo_program" data-toggle="tab" class="nav-link" onclick="showPloProgramData({{$plo->id}},'{{route('showploprogramdata')}}')">Program Batch</a></li> -->
                                <!-- <li class="nav-item"><a href="#plo_kpis" data-toggle="tab" class="nav-link" onclick="showPloKpisData({{$plo->id}},'{{route('showplokpisdata')}}')">Plo KPIs</a></li> -->
                            </ul>   
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                
                    <!-- View PLO -->
                    <div id="plo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">                            
                            <input type="hidden" id="plo_id" name="id" value="{{  $plo->id  }}">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">{{ $plo->code }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="personal-info">
                                            <table class="table table-bordered mb-0 personal-info">
                                                <tbody>
                                                    <tr >
                                                        <th>Code</th>
                                                        <td>{{ $plo->code }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Name</th>
                                                        <td>{{ $plo->name }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>WA Code</th>
                                                        <td>{{ $plo->wa_code }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Description</th>
                                                        <td>{{ $plo->description }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Strategies</th>
                                                        <td>{{ $plo->strategies }}</td>
                                                    </tr>
                                                    <tr >
                                                        <th>Program</th>
                                                        @if ($plo->program)
                                                        <td>{{ $plo->program->name ?? '-' }}</td>
                                                        @else
                                                            <td> - </td>
                                                        @endif
                                                    </tr>
                                                    
                                                    <tr >
                                                        <th>Active</th>
                                                        <td>@php if($plo->status === 1 ){echo 'Yes'; }else{echo 'No';}  @endphp</td>
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
                    
                    <!-- Assign PEO -->
                    <div class="tab-pane fade" id="plo_peos">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="mt-3 mr-3">
                                        <a href="#" onclick="openAssignPloModal()" class="btn add-btn" style="width: 10px;">Add</a>
                                    </div >
                                    <div class="card-body">
                                        <div id="div_datatable_plopeo" class="table-responsive">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Assign PEO -->

                    <!-- PLO KPIs -->
                    <div class="tab-pane fade" id="plo_kpis" >
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="mt-3 mr-3">
                                        <a href="#" onclick="openPloKpisModal()" class="btn add-btn" style="width: 10px;">Add</a>
                                    </div >
                                    <div class="card-body">
                                        <div id="div_datatable_plokpis" class="table-responsive" >
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /PLO KPIs -->               
                                                                        
                    <!-- PLO Programs -->               
                    <div class="tab-pane fade" id="plo_program">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="mt-3 mr-3">
                                        <a href="#" onclick="openPloProgramModal()" class="btn add-btn" style="width: 10px;">Add</a>
                                    </div >
                                    <div class="card-body">
                                        <div id="div_datatable_ploprogram" class="table-responsive">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /PLO Programs -->
                    
                </div>
            </div>
            <!-- /Page Content -->
            
            <!-- Assign PEO TO PLO -->
            <div id="assign_peo_to_plo" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign PEO </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">PEO</label>
                                        <select id ="peo_id" name="peo_id" class="select">
                                            <option value="" selected > - Select PEO - </option>
                                                @foreach ($peos as $peo)
                                                    <option value="{{ $peo->id }}" >{{ $peo->code .' - '. $peo->description }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Weight <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" id="weight" name="weight" placeholder="Enter Weight">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="submit-section">
                                <button id="save_peo_program" class="btn btn-success" onclick="savePloPeo('{{route('addplopeo')}}','{{route('showplopeodata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign PEO TO PLO -->

            <!-- Add KPIs Modal -->
            <div id="open_plo_kpis" class="modal custom-modal fade"  role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add PLO KPIs</h5>
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
                                        <label class="col-form-label">KPI % <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" id="kpi_percentage" name="kpi_percentage"placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Measured When <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="measured_when" id="measured_when" placeholder="Yearly /Bi-Yearly" >
                                    </div>
                                </div>
                            </div>
                                
                            <div class="submit-section"> 
                                <button id="save_plo_kpis" class="btn btn-success" onclick="savePloKpis('{{route('addplokpis')}}','{{route('showplokpisdata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add KPIs Modal -->

            <!-- Assign PLO Program Modal -->
            <div id="open_plo_program" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Program </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Program</label>
                                        <select class="select">
                                            <option value="" selected > - Select Program - </option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="submit-section">
                                <button id="save_peo_program" class="btn btn-success" onclick="savePloProgram('{{route('addploprogram')}}','{{route('showploprogramdata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign PLO Program Modal -->
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')

        @endsection
