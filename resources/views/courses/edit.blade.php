<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Course</title>      
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
									<li class="breadcrumb-item active">Edit Course</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Course Information</h4>
									<form method="POST" action="{{ route('updatecourse') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $course->id }}">
										<div class="row">

										<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_id" class="select">
															<option value="">- Select -</option>
															@foreach ($program as $pro)
																<option value="{{ $pro->id }}" @if($pro->id === $course->program_id) ? selected : '' @endif >{{ $pro->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>	

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Code <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="code" type="text" class="form-control"
															name="code" value="{{ $course->code ?? '' }}" autofocus placeholder="Enter course code">
															<span class="text-danger">{{$errors->first('code')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Name <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $course->name ?? '' }}" autofocus placeholder="Enter course name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Level <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="course_level" class="select">
															<option value="">- Select -</option>
															<option value="1" @if($course->course_level == '1') selected @endif>Undergrade</option>
															<option value="2" @if($course->course_level == '2') selected @endif>Graduate</option>
															<option value="3" @if($course->course_level == '3') selected @endif>Certificate - Week Day</option>
															<option value="4" @if($course->course_level == '4') selected @endif>Certificate - Weekend</option>
															<option value="5" @if($course->course_level == '5') selected @endif>Certificate - General</option>
														</select>
														<span class="text-danger">{{$errors->first('course_level')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Delivery Format <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select id="delivery_format" name="delivery_format" class="select" onchange="changeInputs()">
															<option value="">- Select -</option>
															<option value="1" @if($course->delivery_format == '1') selected @endif>Theory</option>
															<option value="2" @if($course->delivery_format == '2') selected @endif>Lab</option>
															<option value="3" @if($course->delivery_format == '3') selected @endif>Theory+Lab</option>
															<option value="4" @if($course->delivery_format == '4') selected @endif>Tutorail</option>
															<option value="5" @if($course->delivery_format == '5') selected @endif>Theory+Tutorail</option>
															<option value="6" @if($course->delivery_format == '6') selected @endif>Theory+Tutorail+Lab</option>
														</select>
														
														<span class="text-danger">{{$errors->first('delivery_format')}}</span>
														
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-4">
														<label>Theory</label>
														<input type="number" class="form-control"   value="{{ $course->theory ?? ''}}"  id="theory" name="theory" autofocus placeholder="Theory Cr. Hr.">
													</div>
													<div class="col-lg-4">
														<label>Lab</label>
														<input type="number" class="form-control" value="{{ $course->lab ?? ''}}"   id="lab" name="lab" autofocus placeholder="Lab Cr. Hr.">
													</div>
													<div class="col-lg-4">
														<label>Tutorial</label>
														<input type="number" class="form-control"  value="{{ $course->tutorial ?? ''}}" id="tutorial" name="tutorial" autofocus placeholder="Tutorial Cr. Hr.">
													</div>
												</div>										
											</div>
												
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">OBE Mapping <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="obe_mapping" class="select">
															<option value="">- Select -</option>
															<option value="yes" @if($course->obe_mapping == 'yes') selected @endif>Yes</option>
															<option value="no" @if($course->obe_mapping == 'no') selected @endif>No</option>
														</select>
														<span class="text-danger">{{$errors->first('obe_mapping')}}</span>
													</div>
												</div>
<!-- 												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Institute <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="institute_id" class="select">
															<option value="">- Select -</option>
															@foreach ($institute as $ins)
																<option value="{{ $ins->id }}" >{{ $ins->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('institute_id')}}</span>
													</div>
												</div>	 -->
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Based Type <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="based_type" class="select">
															<option value="">- Select -</option>
															<option value="1" @if($course->based_type == '1') selected @endif>CLO Based</option>
															<option value="2" @if($course->based_type == '2') selected @endif>PLO Based</option>
														</select>
														<span class="text-danger">{{$errors->first('based_type')}}</span>
														
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status </label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" @if($course->status == '1') selected @endif>Active</option>
															<option value="0" @if($course->status == '0') selected @endif>Inactive</option>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
														<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter description"> {{ $course->description ?? '' }}</textarea>
													</div>
												</div>

											</div>



											
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managecourse") }}'" class="btn btn-danger">Cancel</button>
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
				function changeInputs(){
					const delivery_format = $('#delivery_format').val();
					if(delivery_format === '1'){
						$('#theory').removeAttr('readonly');
						
						$('#lab').attr('readonly', true);
						$('#tutorial').attr('readonly', true);
					}else if(delivery_format === '2'){
						$('#lab').removeAttr('readonly');
						$('#theory').attr('readonly', true);
						$('#tutorial').attr('readonly', true);
						
					}else if(delivery_format === '3'){
						$('#theory').removeAttr('readonly');
						$('#lab').removeAttr('readonly');
						$('#tutorial').attr('readonly', true);
						
					}else if(delivery_format === '4'){
						$('#theory').attr('readonly', true);
						$('#lab').attr('readonly', true);
						$('#tutorial').removeAttr('readonly');

					}else if(delivery_format === '5'){
						$('#lab').attr('readonly', true);
						$('#theory').removeAttr('readonly');
						$('#tutorial').removeAttr('readonly');
					}else if(delivery_format === '6'){
						$('#theory').removeAttr('readonly');
						$('#lab').removeAttr('readonly');
						$('#tutorial').removeAttr('readonly');
					}

				}
			</script>
        @endsection
