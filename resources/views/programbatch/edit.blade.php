<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Program Batch</title>      
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
									<li class="breadcrumb-item active">Edit Program Batch</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('updateprogrambatch') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $programbatch->id }}">
										<div class="row">
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Acedemic year</label>
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
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program</label>
													<div class="col-lg-9">
														<select name="program_id" class="select">
															<option value=""> Select Program</option>
															@foreach ($programs as $program)
																<option value="{{ $program->id }}" @if($program->id === $programbatch->program_id) ? selected : '' @endif  >{{ $program->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label" title="Semester">No. of Session</label>
													<div class="col-lg-9">
														<select name="no_of_session" class="select">
															<option value="">- Select -</option>
															<option value="1" @if($programbatch->no_of_session == '1') selected @endif>1</option>
															<option value="2" @if($programbatch->no_of_session == '2') selected @endif>2</option>
															<option value="3" @if($programbatch->no_of_session == '3') selected @endif>3</option>
															<option value="4" @if($programbatch->no_of_session == '4') selected @endif>4</option>
															<option value="5" @if($programbatch->no_of_session == '5') selected @endif>5</option>
															<option value="6" @if($programbatch->no_of_session == '6') selected @endif>6</option>
															<option value="7" @if($programbatch->no_of_session == '7') selected @endif>7</option>
															<option value="8" @if($programbatch->no_of_session == '8') selected @endif>8</option>
															<option value="9" @if($programbatch->no_of_session == '9') selected @endif>9</option>
															<option value="10" @if($programbatch->no_of_session == '10') selected @endif>10</option>
															<option value="11" @if($programbatch->no_of_session == '11') selected @endif>11</option>
															<option value="12" @if($programbatch->no_of_session == '12') selected @endif>12</option>
														</select>
														<span class="text-danger">{{$errors->first('no_of_session')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" selected>Active</option>
															<option value="0">Inactive</option>
														</select>
													</div>
												</div>
											
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Theory Credit Hours</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" value="{{ $programbatch->theory_crdit_hr }}" name="theory_crdit_hr" autofocus>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Lab Credit Hours</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" value="{{ $programbatch->lab_crdit_hr }}" name="lab_crdit_hr" autofocus>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" class="form-control" placeholder="Enter Descriptions">{{ $programbatch->description }}</textarea>
													</div>
												</div>	
											</div>
											
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program Batch Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control" name="name" value="{{ $programbatch->name }}" autofocus>
														<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Use in OBE</label>
													<div class="col-lg-9">
														<select name="use_in_obe" class="select">
															<option value="">- Select -</option>
															<option value="1"  @if($programbatch->use_in_obe == '1') selected @endif>yes</option>
															<option value="2"  @if($programbatch->use_in_obe == '2') selected @endif>no</option>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">GPA Round Method</label>
													<div class="col-lg-9">
														<select name="gpa_method" class="select">
															<option value="R" @if($programbatch->gpa_method == 'R') selected @endif>Round</option>
															<option value="C" @if($programbatch->gpa_method == 'C') selected @endif>Ceil</option>
														</select>
													</div>
												</div>
	
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marks %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" value="{{ $programbatch->mark_per }}" name="mark_per" autofocus placeholder="%">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Students %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" value="{{ $programbatch->student_per }}" name="student_per" autofocus placeholder="%">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">PLO passing threshold</label>
													<div class="col-lg-9">
														<input type="numbers" value="50" class="form-control"
															name="plo_passing_threshold" value="{{ $programbatch->plo_passing_threshold }}" autofocus>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Start Date</label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker" value="{{ $programbatch->start_date }}" name="start_date" type="text" placeholder="Enter Start Date">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">End Date</label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker1" value="{{ $programbatch->end_date }}" name="end_date" type="text" placeholder="Enter End Date" >
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
