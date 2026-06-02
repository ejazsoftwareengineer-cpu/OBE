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
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourseoffering',$id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}" class="nav-link ">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link ">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li> 
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link active">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">

                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Course Students Attendance</h4>
                                    <div class="mb-2">
                                        <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#today_attendance_students"> Mark Today Attendence
                                        </a>
                                        <a href="#" class="btn btn-info mr-2" data-toggle="modal" data-target="#existing_attendance_students">
                                            <i class="fa fa-edit"></i> Mark Existing Attendance
                                        </a> 
                                    </div>
                                </div> 
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Mark Date</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mark_date as  $m)
                                            <tr>
                                                <td>{{ $m->mark_date }}</td>
                                                <?php 
                                                    $presentCount = $attendance_module
                                                    ->where('mark_date', $m->mark_date)
                                                    ->where('course_offer_id', $id)
                                                    ->where('attendance', '1')
                                                    ->count();
                                                ?>
                                                <td>{{ $presentCount }}</td>
                                                <?php 
                                                    $absentCount = $attendance_module
                                                    ->where('mark_date', $m->mark_date)
                                                    ->where('course_offer_id', $id)
                                                    ->where('attendance', '2')
                                                    ->count();
                                                ?>
                                                <td>{{ $absentCount }}</td>
                                                <td class="text-right">
                                                    <a style="color: white;" class="btn btn-info btn-sm" onclick="AttendanceByDate('{{route('editattendancebydate')}}','{{$id}}','{{$m->mark_date}}','edit')">Edit</a>
                                                    <a style="color: white;" class="btn btn-success btn-sm" onclick="AttendanceByDate('{{route('viewattendancebydate')}}','{{$id}}','{{$m->mark_date}}','view')">View</a>
                                                </td>
                                            </tr>
                                               
                                            @endforeach
                                        </tbody>
                                    </table>                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View PEO -->
                </div>
            </div>
            <!-- /Page Content -->
            <!-- Modal -->
            <!-- Today Attendance -->
            <div id="today_attendance_students" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mark Today Attendance </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class=" table table-stripped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Registration No.</th>
                                                <th>Name</th>
                                                <th>Attendance Date</th>
                                                <th class="text-center">Mark Attendance </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($student_attendances as $es)
                                                <tr style="border-top: outset;">
                                                    <td>{{ $es->student->registration_no ?? ''  }} </td>
                                                    <td>{{ $es->student->name ?? '' }} </td>
                                                    <td>{{ date('Y-m-d') }} </td>
                                                    <?php 
                                                        $a = $attendance_module->select('attendance')
                                                        ->where('student_id', $es->student->id)
                                                        ->where('mark_date', date('Y-m-d'))
                                                        ->where('course_offer_id', $id)
                                                        ->get();
                                                    ?>
                                                    <td class="text-center">
                                                        <div class="radio-action" style="display:flex;">
                                                            <label class="radio-container" style="border: 1px solid gainsboro;">
                                                                <span class="radiomark"></span> Present
                                                                <input type="radio" class="attendance-radio" name="attendance_<?=$es->student->id.'_'.date('Y-m-d');?>" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','1','{{$id}}', '{{ date('Y-m-d') }}')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '1' ? 'checked' : ''; ?>>
                                                            </label>
                                                            <label class="radio-container" style="border: 1px solid gainsboro;">
                                                                <span class="radiomark"></span> Absent
                                                                <input type="radio" class="attendance-radio" name="attendance_<?=$es->student->id.'_'.date('Y-m-d');?>" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','2','{{$id}}', '{{ date('Y-m-d') }}')" <?php echo $a->isNotEmpty() && $a->first()->attendance === '2' ? 'checked' : ''; ?>>
                                                            </label>
                                                        </div>
                                                    </td>


                                                </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <div class="submit-section">
                                <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today Attendance -->
            <!-- Today Attendance -->
            <div id="edit_attendance_students" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Attendance </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <div class="card-body">
                                <div  id="edit-table-responsive-attendance"  class="table-responsive">
                                   
                                </div>
                            </div>
                            <div class="submit-section">
                                <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today Attendance -->
            <!-- Today Attendance -->
            <div id="view_attendance_students" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">View Attendance </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <div class="card-body">
                                <div  id="view-table-responsive-attendance"  class="table-responsive">
                                  
                                </div>
                            </div>
                            
                            
                            <div class="submit-section">
                                <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today Attendance -->
            
            <!-- EXitng Attendance -->
            <div id="existing_attendance_students" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mark Existing Attendance </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                        <div class="card-body">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="mark_date" class="mr-2 mt-2">Please select a date for updating attendance:</label>
                                        <input class="form-control datetimepicker mt-1" id="exitingmark_date" name="mark_date" type="text">
                                        <!-- <div class="input-group-append"> -->
                                            <button class="btn btn-primary ml-2 mb-2" type="button" onclick="getAttendanceByDate('{{route('getattendancebydate')}}','{{$id}}')">Load</button>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <div id="table-responsive-attendance" class="table-responsive">

                            </div>
                        </div>

                            
                            
                            <div class="submit-section">
                                <!-- <button class="btn btn-danger" data-dismiss="modal">Close</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Modal -->

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
            <script type="text/javascript">
                
                function changeAttendanceStatus(siteurl,studentid,attendance,offeredcourseid,mark_date){

                    jQuery.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: siteurl,
                        data: {
                            studentid: studentid,
                            offeredcourseid: offeredcourseid,
                            attendance: attendance,
                            mark_date: mark_date,
                        },
                        success: function(response){
                            // location.reload();
                        }
                    });
                }

                function getAttendanceByDate(siteurl,id){
                    jQuery.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#table-responsive-attendance').html();
                    var exitingmark_date = $('#exitingmark_date').val();
                    $.ajax({
                        type: "POST",
                        url: siteurl,
                        data: {
                            id: id,
                            mark_date: exitingmark_date,
                        },
                        success: function(response){
                            $('#table-responsive-attendance').html(response);
                        }
                    });
                }

                function AttendanceByDate(siteurl,id,mark_date,condition){
                    jQuery.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    if(condition === 'view'){
                        $('#view-table-responsive-attendance').html();
                        $('#view_attendance_students').modal('show');
                    }else if(condition === 'edit'){
                        $('#edit-table-responsive-attendance').html();
                        $('#edit_attendance_students').modal('show');
                    }
                    $.ajax({
                        type: "POST",
                        url: siteurl,
                        data: {
                            id: id,
                            mark_date: mark_date,
                        },
                        success: function(response){
                            if(condition === 'view'){
                                $('#view-table-responsive-attendance').html(response);
                            }else if(condition === 'edit'){
                                $('#edit-table-responsive-attendance').html(response);
                            }
                        }
                    });
                }
                $(document).ready(function() {
                    $('#today_attendance_students').on('hidden.bs.modal', function (e) {
                        location.reload();
                    }); 
                    $('#edit_attendance_students').on('hidden.bs.modal', function (e) {
                        // $('#edit-table-responsive-attendance').html();
                        location.reload();
                    }); 
                    $('#view_attendance_students').on('hidden.bs.modal', function (e) {
                        $('#view-table-responsive-attendance').html();
                        // location.reload();
                    });
                    $('#existing_attendance_students').on('hidden.bs.modal', function (e) {
                        location.reload();
                    });
                    
                });
            </script>
        @endsection
