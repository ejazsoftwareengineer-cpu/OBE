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
                            <h3 class="page-title">Course Offering</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Course Offering</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourseoffering',$id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}" class="nav-link ">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link active">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link">CQI</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="">
                                            <table class="table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Used / Unused</th>
                                                        <th>Code</th>
                                                        <th>Course</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($courseclo as $cc)
                                                        
                                                        <tr style="border-top: outset;">
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $cc->name ?? ''  }} </a>
                                                                </h2>
                                                            </td>
                                                            <?php 
                                                            $flag ='';
                                                            $button ='';
                                                            if($cc->course){
                                                                $course_id = $cc->course->id;
                                                                $clo_id = $cc->id;
                                                                $class_activity = DB::select("SELECT id FROM `class_activities` WHERE FIND_IN_SET('$clo_id',`clo_id`) AND `course_id` ='$course_id'");
                                                                if($class_activity){
                                                                    $flag = "Used";
                                                                    $button = "text-sucees";
                                                                }else{
                                                                    $flag = "Unused";
                                                                    $button = "text-danger";
                                                                }
                                                            }
                                                            ?>
                                                            <td><i class="fa fa-dot-circle-o {{$button}}"></i> {{ $flag }}</td>
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
                                                            <td>{{ $cc->description  }}</td>

                                                            <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                        @if ($cc->status === 1)
                                                                            <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                        @else
                                                                        <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                        @endif
                                                                </div>
                                                            </td>
                                                            <?php  $map_plo =  App\Models\PloByCourseSectionClo::with(['plo','program'])->whereclo_id($cc->id)->latest()->get(); 
                                                            
                                                            ?>
                                                            <td class="text-center">
                                                                <?php if(!count($map_plo) > 0){
                                                                    $arr = array(
                                                                        'id' => $cc->id,
                                                                        'courseoffering' => $id,
                                                                        'course' => $course_id,
                                                                    );
                                                                ?>
                                                                    <a type="button" class="btn btn-primary" href="{{route('mapcourseofferingplo',$arr)}}" >Map PLO</a>
                                                                <?php } ?>
                                                            </td> 
                                                    </tr>
                                                    <?php 
                                                        foreach($map_plo as $mp){ 
                                                            if($mp->id){
                                                    ?>
                                                                        
                                                    <tr style="border-top: outset;">
                                                        <th>Program</th>
                                                        <th>PLO</th>
                                                        <th>Domain</th>
                                                        <th>Level</th>
                                                        <th>Emphasis Level	</th>
                                                    </tr>
                                                    <td>{{ $mp->program->name ?? " - " }}</td>
                                                    <td>{{$mp->plo->code ?? " - "}}</td>
                                                    <?php
                                                        $domain = '';
                                                        if($mp->domain === 1){
                                                            $domain = 'Cognative';
                                                        }else if($mp->domain === 2){
                                                            $domain = 'Affective';
                                                        }else if($mp->domain === 3){
                                                            $domain = 'Psychomotor';
                                                        }
                                                    ?>
                                                    <td>{{$domain}}</td>
                                                    <?php
                                                        $level = '';
                                                        if($mp->level === 1){
                                                            $level = 'Receiving';
                                                        }else if($mp->level === 2){
                                                            $level = 'Responding';
                                                        }else if($mp->level === 3){
                                                            $level = 'Valuation';
                                                        }else if($mp->level === 4){
                                                            $level = 'Organization';
                                                        }else if($mp->level === 5){
                                                            $level = 'Intimalization';
                                                        }else if($mp->level === 6){
                                                            $level = 'Knowledge';
                                                        }else if($mp->level === 7){
                                                            $level = 'Comprehension';
                                                        }else if($mp->level === 8){
                                                            $level = 'Application';
                                                        }else if($mp->level === 9){
                                                            $level = 'Analysis';
                                                        }else if($mp->level === 10){
                                                            $level = 'Synthesis';
                                                        }else if($mp->level === 11){
                                                            $level = 'Evaluation';
                                                        }else if($mp->level === 12){
                                                            $level = 'Perception';
                                                        }else if($mp->level === 13){
                                                            $level = 'Set';
                                                        }else if($mp->level === 14){
                                                            $level = 'Guided Response';
                                                        }else if($mp->level === 15){
                                                            $level = 'Mechanism';
                                                        }else if($mp->level === 16){
                                                            $level = 'Complete Overt Response';
                                                        }else if($mp->level === 17){
                                                            $level = 'Adaption';
                                                        }else if($mp->level === 18){
                                                            $level = 'Organization';
                                                        }
                                                    ?>
                                                    <td>{{$level}}</td>
                                                    <?php
                                                    $emphasis_level = '';
                                                    if($mp->emphasis_level === 1 ){
                                                        $emphasis_level = 'Low';
                                                    }else if($mp->emphasis_level === 2){
                                                        $emphasis_level = 'Medium';
                                                    }else if($mp->emphasis_level === 3){
                                                        $emphasis_level = 'High';
                                                    }
                                                    ?>
                                                    <td>{{ $emphasis_level }}</td>

                                                    <?php 
                                                        }
                                                            } 
                                                    ?>
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

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')

        @endsection
