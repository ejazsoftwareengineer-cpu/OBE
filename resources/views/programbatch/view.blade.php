<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | Program Batch</title>      
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
                            <h3 class="page-title">Program Batch</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Program Batch</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showprogrambatch',$programbatch->id)}}" class="nav-link active">View</a></li>
                                <li class="nav-item"><a href="{{route('showplo',$programbatch->id)}}" class="nav-link ">PLO List</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                
                    <!-- View CLO -->
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                    <div class="row">
                            <div class="col-md-6 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Program Batch</div>
                                                <div class="text"><a href="">{{ $programbatch->name }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Academic Year</div>
                                                <div class="text"><a href="">{{ $programbatch->acedemic_year }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Program</div>
                                                <div class="text"><a href="">{{ $programbatch->program->name }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">No of Sessions</div>
                                                <div class="text"><a href="">{{ $programbatch->no_of_session }}</a></div>
                                            </li>
                                            <li>
                                            <?php 
                                                    $status = "";
                                                    if($programbatch->status === 1){
                                                        $status = "Active";
                                                    }elseif($programbatch->status === 0){
                                                        $status = "Inactive";
                                                    }else{
                                                        $status = "-";
                                                    }
                                                ?>
                                                <div class="title">Status</div>
                                                <div class="text">{{ $status }}</div>
                                            </li>
                                            <li>
                                                <?php
                                                    $use_in_obe = "";
                                                    if($programbatch->use_in_obe === 1){
                                                        $use_in_obe = "Yes";
                                                    }elseif($programbatch->use_in_obe === 2){
                                                        $use_in_obe = "NO";
                                                    }else{
                                                        $use_in_obe = "-";
                                                    }
                                                ?>
                                                <div class="title">Course Level</div>
                                                <div class="text">{{ $use_in_obe }}</div>
                                            </li>
                                            <li>
                                                <div class="title">PLO passing threshold</div>
                                                <div class="text">{{ $programbatch->plo_passing_threshold }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Include Indirect Assessment on Student Portal</div>
                                                <div class="text">NO</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Marks %</div>
                                                <div class="text">{{ $programbatch->mark_per }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Students %</div>
                                                <div class="text">{{ $programbatch->student_per }}</div>
                                            </li>
                                            <li>
                                                <?php
                                                    $gpa_method = "";
                                                    if($programbatch->gpa_method === 'R'){
                                                        $gpa_method = "Round";
                                                    }elseif($programbatch->gpa_method === 'C'){
                                                        $gpa_method = "Ceil";
                                                    }else{
                                                        $gpa_method = "-";
                                                    }
                                                ?>
                                                <div class="title">GPA Policy </div>
                                                <div class="text">{{ $gpa_method}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Curriculum</div>
                                                <div class="text">.</div>
                                            </li>
                                            <li>
                                                <div class="title">Freshman and Sophomore year Semesters</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Junior and Senior year Semesters	</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Freshman and Sophomore year Weight</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Junior and Senior year Weight</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Indirect Assessment Percentage</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                        </ul>
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
