<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Course Offering</title>      
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
									<li class="breadcrumb-item active">Edit Course Offering</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('updatecourseoffering') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $courseoffering->id }}">
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Institute</label>
													<div class="col-lg-9">
														<select name="institute_id" class="select">
															<option value="">- Select -</option>
															@foreach ($institute as $ins)
																<option value="{{ $ins->id }}" @if($ins->id === $courseoffering->institute_id) ? selected : '' @endif >{{ $ins->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course</label>
													<div class="col-lg-9">
														<select name="course_id" class="select">
															<option value="">- Select -</option>
															@foreach ($courses as $course)
																<option value="{{ $course->id }}" @if($course->id === $courseoffering->course_id) ? selected : '' @endif >{{ $course->code. '-' .$course->name}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $courseoffering->name }}" autofocus>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Section</label>
													<div class="col-lg-9">
														<input id="section" type="text" class="form-control"
															name="section" value="{{ $courseoffering->section }}" autofocus>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marks %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="mark_per" value="{{ $courseoffering->mark_per }}" autofocus placeholder="%">
													</div>
												</div>	
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Students %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" value="{{ $courseoffering->student_per }}" name="student_per" autofocus placeholder="%">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" @if($courseoffering->status == '1') selected @endif >Active</option>
															<option value="0" @if($courseoffering->status == '0') selected @endif >Inactive</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Semester</label>
													<div class="col-lg-9">
														<select name="semester_id" class="select">
															<option value="">- Select -</option>
															@foreach ($program_batch as $pb)
																<option value="{{ $pb->id }}" @if($pb->id === $courseoffering->semester_id) ? selected : '' @endif >{{ $pb->name }}</option>
															
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Teacher</label>
													<div class="col-lg-9">
														<select name="teacher_id" class="select">
															<option value="">- Select -</option>
															@foreach ($teachers as $t)
																<option value="{{ $t->id }}" @if($t->id === $courseoffering->teacher_id) ? selected : '' @endif >{{ $t->name }}</option>
															
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Status</label>
													<div class="col-lg-9">
														<select name="course_status" class="select">
																<option value="">- Select -</option>
																<option value="1" @if($courseoffering->course_status == '1') selected @endif>Open</option>
																<option value="2" @if($courseoffering->course_status == '2') selected @endif>Finished</option>
																<option value="3" @if($courseoffering->course_status == '3') selected @endif>Incomplete</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Gender</label>
													<div class="col-lg-9">
														<select name="gender" class="select">
																<option value="">- Select -</option>
																<option value="1" @if($courseoffering->gender == '1') selected @endif>Both</option>
																<option value="2" @if($courseoffering->gender == '2') selected @endif>Male</option>
																<option value="3" @if($courseoffering->gender == '3') selected @endif>Female</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Available Seats</label>
													<div class="col-lg-9">
														<input type="number" value="200" class="form-control" value="{{ $courseoffering->available_seats }}" name="available_seats" autofocus placeholder="%">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" class="form-control" placeholder="Enter Descriptions">{{ $courseoffering->description }}</textarea>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Office Hours</label>
													<div class="col-lg-9">
													<textarea type="text" name="office_hours" class="form-control" >{{ $courseoffering->office_hours }}</textarea>
													</div>
												</div>

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

        @endsection
