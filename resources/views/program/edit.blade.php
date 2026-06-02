<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Program</title>      
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
									<li class="breadcrumb-item active">Edit Program</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Edit Program : {{ $program->name }}  </h4>
									<form method="POST" action="{{ route('updateprogram') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $program->id }}">
											<div class="row">
												<div class="col-xl-6">
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Organization <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select id="organization_id" name="organization_id" class="select" onchange="getCampus('{{route('getcampusbyorganization')}}')">

																
																@foreach ($organization as $org)
																	<option value="{{ $org->id }}"  @if($org->organization_id === $program->organization_id) ? selected : '' @endif  >{{ $org->name }}</option>
																
																@endforeach
															</select>
															<span class="text-danger">{{$errors->first('organization_id')}}</span>
														</div>
													</div>
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Campus <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select name="campus_id" id="campus_id" class="select" onchange="getInstitute('{{route('getinstitutebycampus')}}')">
																@foreach ($campus as $cam)
																	<option value="{{ $cam->id }}" @if($cam->id === $program->campus_id) ? selected : '' @endif >{{ $cam->name }}</option>
																
																@endforeach
															</select>
															<span class="text-danger">{{$errors->first('campus_id')}}</span>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Institute <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select id="institute_id" name="institute_id" class="select">
																@foreach ($institute as $ins)
																	<option value="{{ $ins->id }}" @if($ins->id === $program->institute_id) ? selected : '' @endif >{{ $ins->name }}</option>
																
																@endforeach
															</select>
															<span class="text-danger">{{$errors->first('institute_id')}}</span>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Program Name <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<input id="name" type="text" class="form-control"
																name="name" value="{{ $program->name }}" autofocus>
																<span class="text-danger">{{$errors->first('name')}}</span>
														</div>
													</div>
													
													
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Vision </label>
														<div class="col-lg-9">
														<textarea type="text" name="vision" class="form-control" placeholder="Enter vision"> {{ $program->vision }}</textarea>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Mission </label>
														<div class="col-lg-9">
															<textarea type="text" name="mission" class="form-control" placeholder="Enter mission"> {{ $program->mission }}</textarea>
														</div>
													</div>
												</div>
													
												<div class="col-xl-6">
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Session Type<span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select name="session_type" class="select">
															<option value="">- Select -</option>
																<option value="1" @if($program->session_type == '1') selected @endif >Semester</option>
																<option value="2" @if($program->session_type == '2') selected @endif >Annual</option>
															</select>
															
															<span class="text-danger">{{$errors->first('session_type')}}</span>
														</div>
													</div>
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label" title="Semester">Semester<span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select name="no_of_session" class="select">
															<option value="">- Select -</option>
																<option value="1" @if($program->no_of_session == '1') selected @endif>1</option>
																<option value="2" @if($program->no_of_session == '2') selected @endif>2</option>
																<option value="3" @if($program->no_of_session == '3') selected @endif>3</option>
																<option value="4" @if($program->no_of_session == '4') selected @endif>4</option>
																<option value="5" @if($program->no_of_session == '5') selected @endif>5</option>
																<option value="6" @if($program->no_of_session == '6') selected @endif>6</option>
																<option value="7" @if($program->no_of_session == '7') selected @endif>7</option>
																<option value="8" @if($program->no_of_session == '8') selected @endif>8</option>
																<option value="9" @if($program->no_of_session == '9') selected @endif>9</option>
																<option value="10" @if($program->no_of_session == '10') selected @endif>10</option>
																<option value="11" @if($program->no_of_session == '11') selected @endif>11</option>
																<option value="12" @if($program->no_of_session == '12') selected @endif>12</option>
															</select>
															
															<span class="text-danger">{{$errors->first('no_of_session')}}</span>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Program Level <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select name="program_level" class="select">
																
																<option value="">- Select -</option>
																<option value="1" @if($program->program_level == '1') selected @endif>Bachelor 14 Years</option>
																<option value="2" @if($program->program_level == '2') selected @endif >Bachelor 15 Years</option>
																<option value="3" @if($program->program_level == '3') selected @endif>Bachelor 16 Years</option>
																<option value="4" @if($program->program_level == '4') selected @endif>Bachelor 17 Years</option>
																<option value="5" @if($program->program_level == '5') selected @endif>Masters 16 Years</option>
																<option value="6" @if($program->program_level == '6') selected @endif>Masters 17 Years</option>
																<option value="7" @if($program->program_level == '7') selected @endif>MS/MPhil 18 Years</option>
																<option value="8" @if($program->program_level == '8') selected @endif>PhD</option>
																<option value="9" @if($program->program_level == '9') selected @endif>PGD</option>
																<option value="10" @if($program->program_level == '10') selected @endif>Certificate</option>
															</select>
															<span class="text-danger">{{$errors->first('program_level')}}</span>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Program Format <span class="text-danger">*</span></label>
														<div class="col-lg-9">
															<select name="program_type" class="select">
															<option value="">- Select -</option>
																<option value="M" @if($program->program_type == 'M') selected @endif>Morning</option>
																<option value="E" @if($program->program_type == 'E') selected @endif>Evening</option>
																<option value="A" @if($program->program_type == 'A') selected @endif>Afternoon</option>
																<option value="W" @if($program->program_type == 'W') selected @endif>Weekend</option>
															</select>
															<span class="text-danger">{{$errors->first('program_type')}}</span>
														</div>
													</div>
													<!-- <div class="form-group row">
														<label class="col-lg-3 col-form-label">Students %</label>
														<div class="col-lg-9">
															<input type="number" class="form-control" name="student_per" value="{{ $program->student_per }}" autofocus placeholder="%">
														</div>
													</div>
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Marks %</label>
														<div class="col-lg-9">
															<input type="number" class="form-control"  value="{{ $program->mark_per }}" name="mark_per" autofocus placeholder="%">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Accreditation body</label>
														<div class="col-lg-9">
															<select name="assessment_method" class="select">
															<option value="">- Select -</option>
																<option value="0" @if($program->assessment_method == '1') selected @endif>None</option>
																<option value="1" @if($program->assessment_method == '2') selected @endif>PEC (Washington Accord)</option>
																<option value="2" @if($program->assessment_method == '2') selected @endif>NCEAC</option>
																<option value="3" @if($program->assessment_method == '3') selected @endif>NBEAC</option>
															</select>
														</div>
													</div>
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Type of taxonomy</label>
														<div class="col-lg-9">
															<select name="learning_type_category" class="select">
															<option value="">- Select -</option>
																<option value="1" @if($program->learning_type_category == '1') selected @endif>None</option>
																<option value="2" @if($program->learning_type_category == '2') selected @endif>Blooms Taxonomy v.1</option>
																<option value="3" @if($program->learning_type_category == '3') selected @endif>Blooms Taxonomy v.2</option>
																<option value="4" @if($program->learning_type_category == '4') selected @endif>Blooms Taxonomy v.3 (Harrow)</option>
															</select>
														</div>
													</div> -->
													
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Description</label>
														<div class="col-lg-9">
														<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter description">{{ $program->description }}</textarea>
														</div>
													</div>
													
													<div class="form-group row">
														<label class="col-lg-3 col-form-label">Status</label>
														<div class="col-lg-9">
															<select name="status" class="select">
																<option value="1" @if($program->status == '1') selected @endif>Active</option>
																<option value="0" @if($program->status == '0') selected @endif>Inactive</option>
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
        @endsection
