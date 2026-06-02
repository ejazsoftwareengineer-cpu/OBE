<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Program</title>      
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
									<li class="breadcrumb-item active">Add Program</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Program information</h4>
									<form method="POST" action="{{ route('storeprogram') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Organization <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select id="organization_id" name="organization_id" class="select" onchange="getCampus('{{route('getcampusbyorganization')}}')">
															<option value=""> Select organization</option>
															
															@foreach ($organization as $org)
																<option value="{{ $org->id }}" >{{ $org->name }}</option>
															
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('organization_id')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Campus <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="campus_id[]" id="campus_id" class="select" onchange="getInstitute('{{route('getmultipleinstitutebycampus')}}')" multiple="multiple">
															
														</select>
														<span class="text-danger">{{$errors->first('campus_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Institute <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select id="institute_id" name="institute_id[]" class="form-control select2" multiple="multiple">
															
														</select>
														<span class="text-danger">{{$errors->first('institute_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program Name <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ old('name') }}"   autofocus placeholder="Enter program name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
												
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Vision</label>
													<div class="col-lg-9">
													<textarea type="text" name="vision" class="form-control" placeholder="Enter vision"></textarea>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Mission</label>
													<div class="col-lg-9">
														<textarea type="text" name="mission" class="form-control" placeholder="Enter mission"></textarea>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Session Type<span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="session_type" class="select">
															<option value="">- Select -</option>
															<option value="1" >Semester</option>
															<option value="2">Annual</option>
														</select>
														<span class="text-danger">{{$errors->first('session_type')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label" title="Semester">Semester<span class="text-danger">*</span></label>
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
													<label class="col-lg-3 col-form-label">Program Level <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_level" class="select">
															<option value="">- Select -</option>
															<option value="1">Bachelor 14 Years</option>
															<option value="2">Bachelor 15 Years</option>
															<option value="3">Bachelor 16 Years</option>
															<option value="4">Bachelor 17 Years</option>
															<option value="5">Masters 16 Years</option>
															<option value="6">Masters 17 Years</option>
															<option value="7">MS/MPhil 18 Years</option>
															<option value="8">PhD</option>
															<option value="9">PGD</option>
															<option value="10">Certificate</option>
														</select>
														<span class="text-danger">{{$errors->first('program_level')}}</span>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program Format <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_type" class="select">
															<option value="">- Select -</option>
															<option value="M">Morning</option>
															<option value="E">Evening</option>
															<option value="A">Afternoon</option>
															<option value="W">Weekend</option>
														</select>
														<span class="text-danger">{{$errors->first('program_type')}}</span>
													</div>
												</div>
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Students %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="student_per" autofocus placeholder="%">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marks %</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="mark_per" autofocus placeholder="%">
													</div>
												</div> -->
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">Accreditation body</label>
													<div class="col-lg-9">
														<select name="assessment_method" class="select">
															<option value="">- Select -</option>
															<option value="0">None</option>
															<option value="1">PEC (Washington Accord)</option>
															<option value="2">NCEAC</option>
															<option value="3">NBEAC</option>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Type of taxonomy</label>
													<div class="col-lg-9">
														<select name="learning_type_category" class="select">
															<option value="">- Select -</option>
															<option value="0">None</option>
															<option value="1">Blooms Taxonomy v.1</option>
															<option value="2">Blooms Taxonomy v.2</option>
															<option value="3">Blooms Taxonomy v.3 (Harrow)</option>
														</select>
													</div>
												</div> -->
												
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter description"></textarea>
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
											</div>
										</div>
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageprogram") }}'" class="btn btn-danger">Cancel</button>
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
				function getCampus(siteurl){
					const organization_id = $('#organization_id').val();
					$('#campus_id').html('');
					getDropDown(siteurl, organization_id, 'campus');
				}
				function getInstitute(siteurl){
					const campus_id = $('#campus_id').val();
					// alert(campus_id)
					$('#institute_id').html('');
					getDropDown(siteurl, campus_id, 'institute');
				}
				

				function getDropDown(siteurl, id, condition){
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
						},
						success: function(response){
							if(condition ==='institute'){
								$('#institute_id').html(response);
							}else if(condition ==='campus'){
								$('#campus_id').html(response);
							}
						}
					});
				}
			</script>
			<script>
				$(document).ready(function() {
					$('#institute_id').select2({
						placeholder: "Select Institutes",
						allowClear: false,
						width: '100%'
					});
				});
			</script>
        @endsection
