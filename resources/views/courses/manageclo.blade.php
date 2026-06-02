<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title> Course </title>      
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
                            <h3 class="page-title">Course </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Course</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li><a  href="{{ route('showcourse',$id) }}" class="nav-link">View</a></li>
                                <li><a href="{{ route('showclo',$id) }}" class="nav-link active">CLO</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                   
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="col-auto float-right ml-auto" style="padding: 10px 10px 10px 10px;">
                                            <a href="{{ route('addcourseclo',$id) }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Clo</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Course</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($courseclo as $cc)
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $cc->name  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $cc->code  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $cc->course->name  }} </a>
                                                                </h2>
                                                            </td>

                                                            <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                        @if ($cc->status === 1)
                                                                            <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                        @else
                                                                        <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                        @endif
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach
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
