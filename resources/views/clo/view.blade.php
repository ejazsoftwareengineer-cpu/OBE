<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | CLO</title>      
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
                            <h3 class="page-title">CLO</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Course Learning Outcome</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourselearningoutcome',$clo->id)}}" class="nav-link active">View</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showplobyclo',$clo->id)}}" class="nav-link ">PLO's</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                    <!-- View CLO -->
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">                            
                            <input type="hidden" id="clo_id" name="id" value="{{  $clo->id  }}">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">{{ $clo->code ?? '' }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="personal-info">
                                            <table class="table table-bordered mb-0 personal-info">
                                                <tbody>
                                                    <tr>
                                                        <th>Code</th>
                                                        <td>{{ $clo->code ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td>{{ $clo->description ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Course</th>
                                                        @if($clo->course)
                                                        <td>{{ $clo->course->name ?? '' }}</td>
                                                        @else 
                                                        <td> - </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th>Active</th>
                                                        <td>@php if($clo->status === 1 ){echo 'Yes'; }else{echo 'No';}  @endphp</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Type</th>
                                                        <td>{{ $clo->type ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Course Section</th>
                                                        @if($clo->course)
                                                            <td>{{ $clo->course->code ?? '' }}</td>
                                                        @else 
                                                            <td> - </td>
                                                        @endif
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
                 
                    
                </div>
            </div>
            <!-- /Page Content -->
            <!-- Modal -->
            <!-- / Modal -->

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')

        @endsection
