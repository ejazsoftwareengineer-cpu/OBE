<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Session</title>      
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
									<li class="breadcrumb-item active">Add Program Batch</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('storeprogrambatch') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Acedemic year</label>
													<div class="col-lg-9">
														<select name="acedemic_year" class="select">
														<?php
															// $start_year = 2006; // The first year in the range
															// $end_year = date('Y'); // The current year as the last year in the range
															// // Loop through each year in the range and create an option for it
															// for ($year = $start_year; $year <= $end_year; $year++) {
															// 	echo '<option value="' . $year . '-' . ($year+1) . '">' . $year . '-' . ($year+1) . '</option>';
															// }
														?>
														</select>
													</div>
												</div>
												 -->
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Acedemic year <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="acedemic_year" class="select">
															<option value=""> Select Acedemic year</option>
															@foreach ($acedemic_year as $ay)
																<?php 
																$s_year = date('Y', strtotime($ay->start_date));
																$e_year = date('Y', strtotime($ay->end_date));
																?>
																<option value="{{ $ay->id }}" >{{ $s_year .'-'.$e_year }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Curriculum <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="cirriculum_id" class="select">
															<option value=""> Select Curriculum</option>
															@foreach ($cirriculum as $c)
																
																<option value="{{ $c->id }}" >{{ $c->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program Name <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_id" class="select">
															<option value=""> Select Program</option>
															@foreach ($programs as $program)
																<option value="{{ $program->id }}" >{{ $program->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program Batch Detail <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ old('name') }}" placeholder="EE-ISB 2002-2006"  autofocus>
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
													
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Batch Start Date <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker" name="start_date" type="text" placeholder="Enter Start Date">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Batch End Date <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker1" name="end_date" type="text" placeholder="Enter End Date" >
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label" title="Semester">No. of Session <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="no_of_session" class="select">
															<option value="">- Select -</option>
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
														</select>
														<span class="text-danger">{{$errors->first('no_of_session')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
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
													<label class="col-lg-3 col-form-label">Theory Credit Hours <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="theory_crdit_hr" autofocus>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Lab Credit Hours <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="lab_crdit_hr" autofocus>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Map with OBE <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="use_in_obe" class="select">
															<option value="">- Select -</option>
															<option value="1" selected>yes</option>
															<option value="2">no</option>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">GPA Calculation <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="gpa_method" class="select">
															<option value="R" selected="">Round</option>
															<option value="C">Ceil</option>
														</select>
														
													</div>
												</div>
	
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marks % </label>
													<div class="col-lg-9">
														<input type="number" class="form-control" min="0" max="100" name="mark_per" value="50" autofocus placeholder="%">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Students % </label>
													<div class="col-lg-9">
														<input type="number" min="0" max="100" class="form-control" name="student_per" value="50" autofocus placeholder="%">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">PLO passing threshold<span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input type="numbers" min="0" max="100" value="50" class="form-control"
															name="plo_passing_threshold" autofocus>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter Descriptions"></textarea>
													</div>
												</div>
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageprogrambatch") }}'" class="btn btn-danger">Cancel</button>
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
