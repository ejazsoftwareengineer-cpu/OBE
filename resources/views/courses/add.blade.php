<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Course</title>      
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
									<li class="breadcrumb-item active">Add Course</li>
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
									<form method="POST" action="{{ route('storecourse') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_id" class="select">
															<option value="">- Select -</option>
															@foreach ($program as $pro)
																<option value="{{ $pro->id }}" >{{ $pro->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
													</div>
												</div>	
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Code <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="code" type="text" class="form-control"
															name="code" autofocus placeholder="Enter course code">
															<span class="text-danger">{{$errors->first('code')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Name <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" autofocus placeholder="Enter course name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Level <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="course_level" class="select">
															<option value="">- Select -</option>
															<option value="5">Certificate - General</option>
															<option value="3">Certificate - Week Day</option>
															<option value="4">Certificate - Weekend</option>
															<option value="2">Graduate</option>
															<option value="1">Undergrade</option>
														</select>
														
														<span class="text-danger">{{$errors->first('course_level')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Course Delivery Format <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select id="delivery_format" name="delivery_format" class="select" onchange="changeInputs()">
															<option value="">- Select -</option>
															<option value="1">Theory</option>
															<option value="2">Lab</option>
															<option value="3">Theory+Lab</option>
															<option value="4">Tutorail</option>
															<option value="5">Theory+Tutorail</option>
															<option value="6">Theory+Tutorail+Lab</option>
														</select>
														
														<span class="text-danger">{{$errors->first('delivery_format')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-4">
														<label>Theory</label>
														<input type="number" class="form-control" readonly id="theory" name="theory" autofocus placeholder="Theory Cr. Hr.">
													</div>
													<div class="col-lg-4">
														<label>Lab</label>
														<input type="number" class="form-control" readonly id="lab" name="lab" autofocus placeholder="Lab Cr. Hr.">
													</div>
													<div class="col-lg-4">
														<label>Tutorial</label>
														<input type="number" class="form-control" readonly id="tutorial" name="tutorial" autofocus placeholder="Tutorial Cr. Hr.">
													</div>
												</div>										
											</div>
												
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">OBE Mapping <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="obe_mapping" class="select">
															<option value="">- Select -</option>
															<option value="Yes" selected>Yes</option>
															<option value="No">No</option>
														</select>
														<span class="text-danger">{{$errors->first('obe_mapping')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Based Type <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="based_type" class="select">
															<option value="">- Select -</option>
															<option value="1" selected>CLO Based</option>
															<!-- <option value="2">PLO Based</option> -->
														</select>
														
														<span class="text-danger">{{$errors->first('based_type')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status </label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" selected>Active</option>
															<option value="0">Inactive</option>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
														<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter description"></textarea>
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
