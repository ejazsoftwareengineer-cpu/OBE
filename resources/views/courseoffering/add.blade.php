<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Course Offering</title>      
        @extends('layouts.backend.app')

        @section('content')

            <div class="page-wrapper">
			
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">Add Course Offering</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('storecourseoffering') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Session</label>
													<div class="col-lg-9">
														<select name="active_session_id" class="select" >
															@foreach ($sesssion as $session)
																<option value="{{ $session->id }}" >{{ $session->title }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{ $errors->first('active_session_id') }}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Institute</label>
													<div class="col-lg-9">
														<select id="institute_id" name="institute_id" class="select" onchange="getProgram('{{route('getinstitutebyprogram')}}')">
															<option value="">- Select -</option>
															@foreach ($institute as $ins)
																<option value="{{ $ins->id }}" >{{ $ins->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Programs</label>
													<div class="col-lg-9">
														<select id="program_id" name="program_id" class="select" onchange="getCirriculum('{{route('getcirriculumbyprogram')}}')">
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Cirriculum</label>
													<div class="col-lg-9">
														<select id="cirriculum_id" name="cirriculum_id" class="select" onchange="getSemester('{{route('getsemesterbycirriculum')}}')">
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Semester</label>
													<div class="col-lg-9">
														<select id="semester" name="semester" class="select" onchange="getCourse('{{route('getcoursebysemester')}}')">
														</select>
													</div>
												</div>
												
												
												
												
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Office Hours</label>
													<div class="col-lg-9">
													<textarea type="text" name="office_hours" class="form-control" ></textarea>
													</div>
												</div> -->
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" selected>Active</option>
															<option value="0">Inactive</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course</label>
													<div class="col-lg-9">
														<select id="course_id" name="course_id" class="select" onchange="getCourseDetail('{{route('getcoursebycourseid')}}')">
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Name</label>
													<div class="col-lg-9">
														<input id="course_name" type="text" class="form-control"
															name="course_name" value="{{ old('name') }}" readonly autofocus>
															
														<span class="text-danger">{{ $errors->first('course_name') }}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Code</label>
													<div class="col-lg-9">
														<input id="course_code" type="text" class="form-control"
															name="name" value="{{ old('name') }}" readonly autofocus>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Teacher Name</label>
													<div class="col-lg-9">
														<select name="teacher_id" class="select">
															<option value="">- Select -</option>
															@foreach ($teachers as $t)
																<option value="{{ $t->id }}" >{{ $t->name }}</option>
															@endforeach
														</select>
														
														<span class="text-danger">{{ $errors->first('teacher_id') }}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Section</label>
													<div class="col-lg-9">
														<select name="section" class="select">
															<option value="">Select Section</option>
															<option value="A" selected>A</option>
															<option value="B">B</option>
															<option value="C">C</option>
															<option value="D">D</option>
															<option value="E">E</option>
															<option value="F">F</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter Descriptions"></textarea>
													</div>
												</div>
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Students %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" id="student_per" name="student_per" autofocus placeholder="%">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marks %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" id="mark_per" name="mark_per" autofocus placeholder="%">
													</div>
												</div>	 -->
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Status</label>
													<div class="col-lg-9">
														<select name="course_status" class="select">
																<option value="">- Select -</option>
																<option value="1">Open</option>
																<option value="2">Finished</option>
																<option value="3">Incomplete</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Gender</label>
													<div class="col-lg-9">
														<select name="gender" class="select">
																<option value="">- Select -</option>
																<option value="1">Both</option>
																<option value="2">Male</option>
																<option value="3">Female</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Available Seats</label>
													<div class="col-lg-9">
														<input type="number" value="200" class="form-control" name="available_seats" autofocus placeholder="%">
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
				
				</div>			
			</div>
        @endsection

        @section('script')
			<script>
				function getProgram(siteurl){
					const institute_id = $('#institute_id').val();
					$('#program_id').html('');
					getDropDownData(siteurl, institute_id, 'program',null);
				}
				function getCirriculum(siteurl){
					const program_id = $('#program_id').val();
					$('#cirriculum_id').html('');
					getDropDownData(siteurl, program_id, 'cirriculum',null);
				}
				function getSemester(siteurl){
					const cirriculum_id = $('#cirriculum_id').val();
					$('#semester').html('');
					getDropDownData(siteurl, cirriculum_id, 'semester',null);
				}
				function getCourse(siteurl){
					const semester = $('#semester').val();
					const cirriculum_id = $('#cirriculum_id').val();
					$('#course_id').html('');
					getDropDownData(siteurl, semester, 'course',cirriculum_id,null);
				}
				function getCourseDetail(siteurl){
					const course_id = $('#course_id').val();
					$('#course_name').val('');
					$('#course_code').val('');
					getDropDownData(siteurl, course_id,'course_detail',null);
				}
				
				function getDropDownData(siteurl, id, condition,cirriculum_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: id,
							cirriculum_id: cirriculum_id,
							flag: 'option',
						},
						success: function(response){
							if(condition ==='program'){
								$('#program_id').html(response);
							}else if(condition ==='cirriculum'){
								$('#cirriculum_id').html(response);
							}else if(condition ==='semester'){
								$('#semester').html(response);
							}else if(condition ==='course'){
								$('#course_id').html(response);
							}else if(condition ==='course_detail'){
								var res = JSON.parse(response);
								$('#course_code').val(res[0].code);
								$('#course_name').val(res[0].name);
								// $('#course_name').html(response);
								// $('#course_code').html(response);
							}
						}
					});
				}
				
			</script>
        @endsection
