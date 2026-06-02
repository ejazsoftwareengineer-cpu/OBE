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
           
           table tbody>tr>:nth-child(2), 
           table tbody>tr>:nth-child(3), 
           table tbody>tr>:nth-child(4), 
           table tbody>tr>:nth-child(5), 
           table tbody>tr>:nth-child(6) {
               text-align : right; !important
           }
           .custom-modal-content {
                width: 90%; /* Adjust the width as needed */
                max-width: 100%; /* Ensure it doesn't exceed the viewport width */
            }
            .round-label {
                display: inline-block;
                background-color: #3498db; /* Change this to the desired background color */
                color: white; /* Change this to the desired text color */
                padding: 10px 15px; /* Adjust the padding to make the label round */
                border-radius: 50%; /* This makes the label round */
                text-align: center;
                text-decoration: none;
                font-weight: bold;
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
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}" class="nav-link active">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link ">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('storecourseofferingactivities') }}" class="mb-5" id="validationForm" name="validationForm">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                                            <input type="hidden" name="course_section_id" value="{{ $id }}">
                                            <h3>Add Class Activity</h3>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Activity/Assesment Method</label>
                                                        <div class="col-lg-9">
                                                            <select name="assesment_id" class="select">
                                                                <option value="">- Select -</option>
                                                                @foreach ($assesment as $a)
																    <option value="{{ $a->id }}" >{{ $a->short_name }}</option>
															    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Date</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control datetimepicker" name="assesment_date" type="text" placeholder="Date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <!-- <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Total Marks</label>
                                                        <div class="col-lg-9">
                                                            <input type="number" class="form-control" name="assesment_total_mark" autofocus >
                                                        </div>
                                                    </div>	 -->
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Name</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" class="form-control"
                                                                name="assesment_name" autofocus>
                                                                
														<span class="text-danger">{{$errors->first('assesment_name')}}</span>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Weight</label>
                                                        <div class="col-lg-9">
                                                            <input type="number" class="form-control" name="assesment_gpa_weight" autofocus >
                                                        </div>
                                                    </div>	 -->
                                                    <!-- <div class="form-group row" style="padding: 20px 0px 10px 18px;">
                                                        <label class="d-block"> Complex Engineering</label>
                                                        <div class="col-lg-3">
                                                            <input type="checkbox" id="complex_engineering_problem" name="complex_engineering_problem" value="0" class="check">
                                                            <label for="complex_engineering_problem" class="checktoggle">checkbox</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" style="padding: 20px 0px 10px 18px;">
                                                       
                                                        <label class="d-block">Include for GPA Calculation</label>
                                                        <div class="col-lg-3">
                                                            <input type="checkbox" id="gpa_calculation" name="gpa_calculation" value="0" class="check">
                                                            <label for="gpa_calculation" class="checktoggle">checkbox</label>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>

                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" onclick="window.location='{{ route("managecourseoffering") }}'" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h3>CLOs Class Activities Mapping</h3>
                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Activity Name</th>
                                                        <th class="text-right">Assessment Name</th>
                                                        <!-- <th class="text-right">Weigth</th> -->
                                                        <th class="text-right">Total Question</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($class_activity as $ca)
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $ca->assesment_name  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $ca->assesment->short_name ?? '-'  }} </a>
                                                                </h2>
                                                            </td>
                                                            <!-- <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $ca->assesment_gpa_weight  }} </a>
                                                                </h2>
                                                            </td> -->
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <?php  $count =  $activityquestion->whereactivity_id($ca->id)->count();?>
                                                                    <a href="#" style="color: white;" class="round-label">{{ $count  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="btn btn-primary btn-sm" href="{{route('showcourseofferingactivitiesquestion',$ca->id)}}">Questions</a>
                                                                <a class="btn btn-primary btn-sm" style="color: white;" onclick="openClassActivityModal('{{route('getactivityandquestions')}}',{{$ca->id}})">View</a>
                                                                <a class="btn btn-primary btn-sm" style="color: white;" onclick="openEditClassActivityModal('{{route('geteditactivityview')}}',{{$ca->id}})">Edit</a>
                                                                <a class="btn btn-primary btn-sm" style="color: white;"  onclick="openDeleteModel('{{$ca->id}}')">Delete</a>
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
                </div>
            </div>
            <div id="view_class_activity_and_question" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Class Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-content">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div id="edit_class_activity" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Class Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit_class_activity_modal_content">
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delete Leave Modal  -->
            <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Class Activity</h3>
                                <p>Are you sure want to delete class activity?</p>
                            </div>
                            <input type="hidden" name="id" value="" id="delete_id">
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" onclick="deleteData('{{ route('destroyclassactivity') }}')" class="btn btn-primary continue-btn">Delete</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- /Delete Leave Modal -->
        </div>

        @endsection

        @section('script')
        
        <script type="text/javascript">
            
            $('.datetimepicker').datepicker({
                format: 'mm/dd/yyyy',
                autoclose: true,
                todayHighlight: true
            });
            function openEditClassActivityModal(siteurl , id) {
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: "POST",
                    url: siteurl , 
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // console.log(data.activity.assesment_name)
                        $('#edit_class_activity_modal_content').html(response.html);
                        $('#edit_class_activity').modal('show');
                        $('#edit_class_activity_modal_content select[name="assesment_id"]').select2();
                        var element = $(".select2");
                        element.css("width", "450px");
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } 
            function updateClassActivity(siteurl){
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });     

                const   id = $('#activity_id').val(),
                        course_id = $('#course_id').val(),
                        course_section_id = $('#course_section_id').val(),
                        assesment_id = $('#assesment_id').val(),
                        assesment_name    = $('#assesment_name').val(),
                        assesment_date    = $('#assesment_date').val(),
                        assesment_gpa_weight    = $('#assesment_gpa_weight').val();
                        // var assesment_total_mark    = $('#assesment_total_mark').val();
                $('#updateclassactivity').prop('disabled',true);
                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        id: id,
                        course_id: course_id,
                        course_section_id: course_section_id,
                        assesment_id: assesment_id,
                        assesment_name: assesment_name,
                        assesment_date: assesment_date,
                        // assesment_total_mark: assesment_total_mark,
                        assesment_gpa_weight: assesment_gpa_weight,
                    },
                    success: function(response){
                        $('#edit_class_activity_modal_content').modal("hide");
                        location.reload();
                        // showPeoProgramData(peo_id, main_url);
                    }
                });
            } 

            function openClassActivityModal(siteurl , id) {
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: "POST",
                    url: siteurl , 
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        // console.log(data.activity.assesment_name)
                        $('#modal-content').html(response.html);
                        $('#view_class_activity_and_question').modal('show');

                        $('#modal-content select[name="assesment_id"]').select2();
                        $('#modal-content select[name="clo_id"]').select2();
                        $('#modal-content select[name="complexity"]').select2();
                        $('#modal-content select[name="question"]').select2();
                        var element = $(".select2");
                        element.css("width", "450px");
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            
            $('#gpa_calculation').change(function(){
                if($(this).prop("checked") == true){
                    $('#gpa_calculation').val(1)
                }else if($(this).prop("checked") == false){
                    $('#gpa_calculation').val(0)
                }
            });

            $('#complex_engineering_problem').change(function(){
                if($(this).prop("checked") == true){
                    $('#complex_engineering_problem').val(1)
                }else if($(this).prop("checked") == false){
                    $('#complex_engineering_problem').val(0)
                }
            });
        </script>
        @endsection
