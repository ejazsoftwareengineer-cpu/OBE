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
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link active">Students</a></li> 
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
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
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px 0px 0px 10px;">
                                        <h4 class="mb-0">Course Offer Students</h4>
                                        <div>
                                            <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#existing_enroll_students">
                                                <i class="fa fa-plus"></i> Enroll Existing Students
                                            </a>
                                            <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#existing_enroll_students_csv">
                                                <i class="fa fa-plus"></i> Upload CSV File 
                                            </a>
                                        </div>
                                    </div> 
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Registration No.</th>
                                                        <th>Name</th>
                                                        <th>Section</th>
                                                        <th>Status</th>
                                                        <th class="text-right">Action</th>
                                                        <!-- <th>Grade</th> -->
                                                        <!-- <th>Score/GPA</th> --> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($enrolled_students as $es)
                                                        
                                                        <tr style="border-top: outset;">
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->student->registration_no ?? '' }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->student->name  ?? '' }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->course_section->section  ?? ''  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                    <?php if($es->student) {?>
                                                                        @if ($es->student->status === 1)
                                                                            <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                        @else
                                                                            <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                        @endif
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="btn btn-primary btn-sm" style="color: white;"  onclick="openDeleteModel('{{$es->id}}')">Delete</a>
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
            <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Remove Enrolled Student</h3>
                                <p>Are you sure want to delete enrolled student?</p>
                            </div>
                            <input type="hidden" name="id" value="" id="delete_id">
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" onclick="deleteData('{{ route('destroyenrolledstudent') }}')" class="btn btn-primary continue-btn">Delete</a>
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
            <!-- Assign PEO TO PLO -->
            <div id="existing_enroll_students" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enroll Existing Student In Course Section </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" id="course_section_id" name="course_section_id" value="{{$id}}">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Session</label>
                                        <select id="session_id" name="session_id" class="select" onchange="getStudents('{{route('getstudentbyprogram')}}')">
                                            <option value="">- Select Session -</option>
                                            @foreach ($session as $s)
                                                <option value="{{ $s->id }}" >{{ $s->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Program</label>
                                        <select id="program_id" name="program_id" class="select" onchange="getStudents('{{route('getstudentbyprogram')}}')">
                                            <option value="">- Select Program -</option>
                                            @foreach ($programs as $program)
                                                <option value="{{ $program->id }}" >{{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="studnets_div" class="col-sm-12" style="display:none;">
                                    <!-- <div class="form-group"> -->
                                        <!-- <label class="col-form-label">Students</label>
                                        <select id ="student_id" name="student_id[]" class="select" multiple> -->
                                            <!-- <option value="select_all">Select All</option> -->
                                            <!-- @foreach ($students as $student)
                                                <option value="{{ $student->id }}" >{{ $student->roll_no .' - '. $student->name }}</option>
                                            @endforeach -->
                                        <!-- </select> -->
                                    <!-- </div> -->
                                </div>
                                <!-- <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Remarks <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="remarks" name="remarks">
                                    </div>
                                </div> -->
                            </div>
                            
                            <div class="submit-section">
                                <button id="save_enroll_students_button" class="btn btn-success" onclick="saveExistingStudent('{{route('addexistingstudent')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign PEO TO PLO -->
           <div id="existing_enroll_students_csv" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enroll Existing Students by CSV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="enroll_students_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="course_section_id" name="course_section_id" value="{{$id}}">
                                
                                <div class="form-group">
                                    <label class="col-form-label">Download CSV Template</label><br>
                                    <a href="{{ route('downloadstudenttemplate') }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-download"></i> Download Template
                                    </a>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="col-form-label">Upload CSV File</label>
                                    <input type="file" name="file" id="student_csv_file" class="form-control" accept=".csv" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button id="upload_enroll_students_button" type="button" class="btn btn-success" onclick="uploadExistingStudent('{{route('uploadexistingstudent')}}')">
                                    Save
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- / Modal -->

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
            <script type="text/javascript">
                // document.addEventListener('DOMContentLoaded', function () {
                //     const selectElement = document.getElementById('student_id');
                //     const selectAllOption = selectElement.querySelector('option[value="select_all"]');

                //     selectElement.addEventListener('change', function () {
                //         if (selectAllOption.selected) {
                //             for (let option of selectElement.options) {
                //                 if (option.value !== 'select_all') {
                //                     option.selected = true;
                //                 }
                //             }
                //             selectAllOption.selected = false; // Deselect the "Select All" option
                //         }
                //     });
                // });
                function uploadExistingStudent(siteurl) {
                    let form = document.getElementById('enroll_students_form');
                    let formData = new FormData(form);

                    $('#upload_enroll_students_button').prop('disabled', true);
                    $.ajax({
                        url: siteurl,
                        type: "POST",
                        data: formData,
                        processData: false,  // important for file upload
                        contentType: false,  // important for file upload
                        success: function (response) {
                            if (response.status === 'success') {
                                location.reload();
                                // showToast(response.message, 'success');
                                // $('#existing_enroll_students_csv').modal('hide');
                                // setTimeout(() => location.reload(), 1500);
                            } else {
                                 $('#upload_enroll_students_button').prop('disabled', false);
                                // showToast(response.message, 'danger');
                            }
                        }
                        // error: function (xhr) {
                        //     showToast("Error uploading file. Please try again.", 'danger');
                        // }
                    });
                }

                function getStudents(siteurl){
					const program_id = $('#program_id').val();
					const session_id = $('#session_id').val();
					$('#studnets_div').html('');
					getDropDownData(siteurl, program_id,session_id);
				}
                function getDropDownData(siteurl, id,session_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});   
                    // if(id && session_id){
                        $.ajax({
                            type: "POST",
                            url: siteurl,
                            data: {
                                id: id,
                                session_id: session_id
                            },
                            success: function(response){
                                $('#studnets_div').html(response);
                                // $('#student_id').html(response);
                                $('#studnets_div').show();
                            }
                        });
                    // }  
                    // $('#studnets_div').hide();

				}

                function saveExistingStudent(siteurl) {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    const program_id = $('#program_id').val();
                    const course_section_id = $('#course_section_id').val();

                    // Collect all selected student IDs
                    const student_ids = [];
                    $('.student-checkbox:checked').each(function() {
                        student_ids.push($(this).val());
                    });

                    // Verify selected students before making the AJAX request
                    if (student_ids.length === 0) {
                        alert('Please select at least one student.');
                        $('#save_enroll_students_button').prop('disabled', false);
                        return;
                    }

                    // Disable the button to prevent multiple submissions
                    $('#save_enroll_students_button').prop('disabled', true);

                    // Make the AJAX request
                    $.ajax({
                        type: "POST",
                        url: siteurl,
                        data: {
                            program_id: program_id,
                            student_ids: student_ids, // Send array of selected student IDs
                            course_section_id: course_section_id,
                        },
                        success: function(response) {
                            location.reload(); // Reload on success
                        },
                        error: function(error) {
                            console.error('Error:', error); // Log any errors
                            $('#save_enroll_students_button').prop('disabled', false); // Re-enable button if an error occurs
                        }
                    });
                }

            </script>
        @endsection
