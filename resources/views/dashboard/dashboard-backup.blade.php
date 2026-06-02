<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Dashboard</title>      
        <style>
            .dropdown-divider {
                border-top: 1px solid #b5bdc5 !important;
            }
        </style>
        @extends('layouts.backend.app')
        @section('content')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title text-warning" >Welcome : {{ $userRole->name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <!-- /Page Header -->
            
                <div class="col-md-12">
                    <!-- <h4> Offered Courses </h4> -->
                    <div class="row mb-24">
                            
                            <?php 
                            // echo "<pre>";
                            // print_r($data);
                            // die();
                            foreach ($data as $d){ ?>
                                <a href="{{ route('showcourseoffering',$d->id) }}">
                                    <div class="col-lg-4 col-xl-4 mt-3 class-node">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="user-profile mb-4">
                                                    <div class="ul-widget-card__user-info">
                                                        <p class="m-0 text-16"><a href="{{ route('showcourseoffering',$d->id) }}">Section Name : {{ $d->name }}</a></p>
                                                        <p class="text-muted m-0">
                                                            <a>{{ $d->course->name ?? '-' }} - {{ $d->sesssion->title ?? '-'}}</a> <br>
                                                            <a>Teacher Name : {{ $d->teacher->name ?? '-' }}</a><br>
                                                            <a>Department Name : {{ $d->institute->name ?? '-' }} </a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>
                                                <div class="ul-widget-card__rate-icon">
                                                    <?php $enrolled_students = $enrolled_student::wherecourse_section_id($d->id)->count(); ?>
                                                    <?php $count_clo = $clo::wherecourseoffer_id($d->id)->count(); ?>
                                                    <?php $count_plo = $plo::wherecourse_section_id($d->id)->count(); ?>
                                                     <?php $count_activity = $activity::wherecourse_section_id($d->id)->count(); ?>
                                                     
                                                
                                                    
                                                    

                                                    <span class="i-Business-Mens text-warning">{{ $enrolled_students }} Students </span> - 
                                                    <span class="i-Business-Mens text-success">{{ $count_clo }} CLO's </span> - 
                                                    <span class="i-Business-Mens text-danger">{{ $count_plo }} PLO's </span> -
                                           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                       
                    </div>
                </div>
            </div>
        </div>
   {{-- 
    <?php $count_ques_activity = $ques_activity::wherecourseoffer_id($d->id)->count(); ?>   
    <?php $count_studentassessment = $studentassessment::wherecourseoffer_id($d->id)->count(); ?>

         <span class="i-Business-Mens text-warning">{{ $count_activity }} Class Activity </span> -
                                                    <span class="i-Business-Mens text-primary">{{ $count_ques_activity }} Question's </span> 
    //   $avg = ($enrolled_students > 0) ? (($count_studentassessment * 100) / $enrolled_students) : 0 ;

--}}
        @endsection

        @section('script')

        @endsection