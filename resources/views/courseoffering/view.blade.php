<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title> Course Offering </title>      
        <style>
            tr {

                max-width: 60px !important;
            }
            .personal-info {
                border: 1px solid #dee2e6; /* Add your desired border color and width */
                padding: 10px; /* Add padding for better spacing */
                border-radius: 5px; /* Optional: Add rounded corners */
            }

            .personal-info li {
                border-bottom: 1px solid #dee2e6; /* Add bottom border for each list item */
                padding: 5px 0; /* Add padding to separate list items */
            }

            /* Remove border from the last list item to avoid double border */
            .personal-info li:last-child {
                border-bottom: none;
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
                            <h3 class="page-title">Offered Course</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Name : {{$course_offering->course->name ?? ' - '}} </li>
                            </ul>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Code : {{$course_offering->course->code ?? ' - '}}</li>
                            </ul>
                            
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Teacher : {{$course_offering->teacher->name ?? 'Not Selected'}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php // echo "<pre>"; print_r($course_offering->course); die(); ?>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourseoffering',$course_offering->id)}}" class="nav-link active">View</a></li>
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$course_offering->id)}}" class="nav-link ">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$course_offering->id)}}" class="nav-link ">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$course_offering->id)}}" class="nav-link ">Students</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$course_offering->id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$course_offering->id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$course_offering->id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$course_offering->id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$course_offering->id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$course_offering->id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                       
                <div class="tab-content">
                    <!-- View CLO -->
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-4 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info border">
                                            <li>
                                                <div class="title ml-2">School/Institute</div>
                                                @if($course_offering->institute)
                                                    <div class="text"><a href="">{{ $course_offering->institute->name ?? '-' }}</a></div>
                                                @else 
                                                <div class="text"></div>
                                                @endif
                                            </li> 
                                            <li>
                                                <div class="title ml-2">Program</div>
                                                @if($course_offering->program)
                                                    <div class="text"><a href="">{{ $course_offering->program->name ?? '-' }}</a></div>
                                                @else 
                                                <div class="text"> - </div>
                                                @endif
                                            </li>
                                            <li>
                                                <div class="title ml-2">Name</div>
                                                <div class="text"><a href="">{{ $course_offering->name ?? '-' }}</a></div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Teacher</div>
                                                @if($course_offering->teacher)
                                                    <div class="text"><a href="">{{ $course_offering->teacher->name ?? '-' }}</a></div>
                                                @else 
                                                <div class="text"></div>
                                                @endif
                                            </li>
                                            <li>
                                                <div class="title ml-2">Course</div>
                                                @if($course_offering->course)
                                                    <div class="text"><a href="">{{ $course_offering->course->name ?? '-' }}</a></div>
                                                @else 
                                                <div class="text"></div>
                                                @endif
                                            </li>
                                            <li>
                                                <div class="title ml-2">Gender</div>
                                                <?php 
                                                    $gender = "";
                                                    if($course_offering->gender === 1){
                                                        $gender = "Both";
                                                    }elseif($course_offering->gender === 2){
                                                        $gender = "Male";
                                                    }elseif($course_offering->gender === 3){
                                                        $gender = "Female";
                                                    }else{
                                                        $gender = "-";
                                                    }
                                                ?>
                                                <div class="text">{{ $gender ?? '-' }}</div>
                                            </li>
                                            <li>
                                                <?php 
                                                    $based_type = "";
                                                    if($course_offering->course){
                                                        if($course_offering->course->based_type === 1){
                                                            $based_type = "CLO Based";
                                                        }elseif($course_offering->course->based_type === 2){
                                                            $based_type = "PLO Based";
                                                        }else{
                                                            $based_type = "-";
                                                        }
                                                    }
                                                ?>
                                                <div class="title ml-2">PLO Base</div>
                                                <div class="text">{{ $based_type ?? '-' }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info border">
                                           
                                            <li>
                                                <div class="title ml-2">Semester</div>
                                                <div class="text">{{ $course_offering->semester  ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Section</div>
                                                <div class="text">{{ $course_offering->section ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Marks % </div>
                                                <div class="text">{{ $course_offering->mark_per ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Student % </div>
                                                <div class="text">{{ $course_offering->student_per ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">WhatsApp Group </div>
                                                <div class="text">{{ '-' }}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Office Hours	</div>
                                                <div class="text">{{ $course_offering->office_hours ?? '-' }}</div>
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <ul class="personal-info border">
                                            <li>
                                                <?php 
                                                    $status = "";
                                                    if($course_offering->status === 1){
                                                        $status = "Active";
                                                    }elseif($course_offering->status === 0){
                                                        $status = "Inactive";
                                                    }else{
                                                        $status = "-";
                                                    }
                                                ?>
                                                <div class="title ml-2">Status</div>
                                                <div class="text">{{ $status ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Use in GPA</div>
                                                <div class="text">-</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Supervisor Based</div>
                                                <div class="text">-</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Available Seats</div>
                                                <div class="text">{{ $course_offering->available_seats ?? '-'}}</div>
                                            </li>
                                            <li>
                                                <div class="title ml-2">Connected Course Section</div>
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
