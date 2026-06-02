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
                                
                                <li class="nav-item"><a  href="{{route('showcourse',$course->id)}}" class="nav-link active">View</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showclo',$course->id)}}" class="nav-link ">CLO</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                    <!-- View CLO -->
                    <div id="view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-6 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Code</div>
                                                <div class="text"><a href="">{{ $course->code ?? '' }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Name</div>
                                                <div class="text"><a href="">{{ $course->name ?? '' }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Department</div>
                                                <div class="text"><a href="">{{ $course->department->name ?? '' }}</a></div>
                                            </li>
                                            <li>
                                                <?php 
                                                    $status = "";
                                                    if($course->status === 1){
                                                        $status = "Active";
                                                    }elseif($course->status === 0){
                                                        $status = "Inactive";
                                                    }else{
                                                        $status = "-";
                                                    }
                                                ?>
                                                <div class="title">Status</div>
                                                <div class="text">{{ $status ?? '' }}</div>
                                            </li>
                                            <li>
                                            <?php
                                                $course_level = "";
                                                if($course->course_level === 1){
                                                    $course_level = "Undergrade";
                                                }elseif($course->course_level === 2){
                                                    $course_level = "Graduate";
                                                }elseif($course->course_level === 4){
                                                    $course_level = "Certificate - Weekend";
                                                }elseif($course->course_level === 3){
                                                    $course_level = "Certificate - Week Day";
                                                }elseif($course->course_level === 5){
                                                    $course_level = "Certificate - General";
                                                }else{
                                                    $course_level = "-";
                                                }
                                                ?>
                                                <div class="title">Course Level</div>
                                                <div class="text">{{ $course_level }}</div>
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
                                                <?php 
                                                $based_type = "";
                                                if($course->based_type === 1){
                                                    $based_type = "CLO Based";
                                                }elseif($course->based_type === 2){
                                                    $based_type = "PLO Based";
                                                }else{
                                                    $based_type = "-";
                                                }
                                                ?>
                                                <div class="title">PLO Base</div>
                                                <div class="text">{{ $based_type }}</div>
                                            </li>
                                            <li>
                                                <?php
                                                $delivery_format = "";
                                                if($course->delivery_format === 1){
                                                    $delivery_format = "Theory";
                                                }elseif($course->delivery_format === 2){
                                                    $delivery_format = "Lab";
                                                }elseif($course->delivery_format === 3){
                                                    $delivery_format = "Theory+Lab";
                                                }elseif($course->delivery_format === 4){
                                                    $delivery_format = "Tutorial";
                                                }elseif($course->delivery_format === 5){
                                                    $delivery_format = "Theory+Tutorial";
                                                }elseif($course->delivery_format === 6){
                                                    $delivery_format = "Theory+Tutorial+Lab";
                                                }else{
                                                    $delivery_format = "-";
                                                }
                                                ?>
                                                <div class="title">Delivery Format </div>
                                                <div class="text">{{ $delivery_format  ?? '' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Supervisor Based	 </div>
                                                <div class="text">{{ $course->student_per  ?? ''  }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Knowledge Area</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Connected Course</div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
