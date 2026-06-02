<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Student</title>      
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
									<li class="breadcrumb-item active">Edit Student</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Personal Information</h4>
									<form method="POST" action="{{ route('updatestudent') }}" class="mb-5" id="validationForm" name="validationForm" enctype="multipart/form-data">
										@csrf
                                        <input type="hidden" name="id" value="{{ $student->id }}">
                                        <input type="hidden" name="user_id" value="{{ $student->user_id }}">
                                        <input type="hidden" name="old_image" value="{{ $student->student_profile_pic }}">
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $student->name }}"   autofocus placeholder="Enter Name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Session <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="session_id" class="select">
														<option value=""> - Select Session -</option>
															@foreach ($sessions as $session)
																<option value="{{ $session->id }}" @if($session->id === $student->active_session_id) ? selected : '' @endif >{{ $session->title }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<select name="program_id" class="select">
															<option value="">Select Programs</option>
															@foreach ($programs as $program)
																<option value="{{ $program->id }}" @if($program->id === $student->program_id) ? selected : '' @endif >{{ $program->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Campus</label>
													<div class="col-lg-9">
														<select name="campus_id" class="select">
															<option value="">Select Campus</option>
															@foreach ($campuses as $campus)
																<option value="{{ $campus->id }}"@if($campus->id === $student->campus_id) ? selected : '' @endif >{{ $campus->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Country</label>
													<div class="col-lg-9">
														<select id="nationality" name="nationality" class="select"  onchange="getProvince('{{route('getstatebycountry')}}')">
															<option value="">Select Nationality</option>
															@foreach ($countries as $country)
																<option value="{{ $country->id }}" >{{ $country->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Province</label>
													<div class="col-lg-9">
														<select id="state" name="state" class="select" onchange="getCites('{{route('getcitiesbystates')}}')">
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">City</label>
													<div class="col-lg-9">
														<select id="cities" name="city" class="select">
															
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Phone</label>
													<div class="col-lg-9">
														<input id="phone_number" type="text" class="form-control"
															name="phone_number" value="{{ $student->phone_number }}" autofocus placeholder="Enter Phone Number">
															<span class="text-danger">{{$errors->first('phone_number')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Address</label>
													<div class="col-lg-9">
														<textarea type="text" name="address"   class="form-control" placeholder="Enter Address">{{ $student->address }}</textarea>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Registration No. <span class="text-danger">*</span></label>
													<div class="col-lg-9">
														<input id="registration_no" type="text" class="form-control"
															name="registration_no" value="{{ $student->registration_no }}"   autofocus placeholder="Enter Sap ID">
															<span class="text-danger">{{$errors->first('registration_no')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Email</label>
													<div class="col-lg-9">
														<input id="email" type="text" class="form-control"
															name="email" value="{{ $student->email }}" autofocus placeholder="Enter Email Address">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Cnic</label>
													<div class="col-lg-9">
														<input id="cnic" type="text" class="form-control" name="cnic" value="{{ $student->cnic }}" autofocus placeholder="Enter CNIC">
														<span class="text-danger">{{$errors->first('cnic')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Marital Status</label>
													<div class="col-lg-9">
														<select name="marital_status" class="select">
															<option value="">Select Marital Status</option>
															<option value="Single" selected>Single</option>
															<option value="Married">Married</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Religion</label>
													<div class="col-lg-9">
														<select name="religion" class="select">
															<option value="">Select Religion</option>
															<option value="Islam" selected>Islam</option>
															<option value="Christian">Christian</option>
															<option value="Other">Other</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Admission Type</label>
													<div class="col-lg-9">
														<select name="admission_type" class="select">
															<option value="">Select Admission Type</option>
															<option value="Regular" selected>Regular</option>
															<option value="Provisional ">Provisional </option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Birthdate</label>
													<div class="col-lg-9">
														<input id="birthdate" type="text" class="form-control"
															name="birthday" value="{{ $student->birthday }}" autofocus placeholder="Enter Birth Date">
															<span class="text-danger">{{$errors->first('birthday')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Gender</label>
													<div class="col-lg-9">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="gender" value="male" checked>
															<label class="form-check-label" >
															Male
															</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input"  type="radio" name="gender" value="female">
															<label class="form-check-label" >
															Female
															</label>
														</div>
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
										<hr>
										<div class="row">
											<div class="col-xl-6">
												<h4> Matric Detail </h4>
												<!-- start matric -->
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Result Status</label>
													<div class="col-lg-9">
														<select name="matric_degree_type" class="select">
															<option value="">Select Result Status</option>
															<option value="Pass" selected>Pass</option>
															<option value="Result Awaiting">Result Awaiting</option>
														</select>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Passing Year</label>
													<div class="col-lg-9">
														<input id="matric_passing_year" type="text" value="{{ $student->matric_passing_year }}" class="form-control"
															name="matric_passing_year" autofocus placeholder="Enter Passing Year">
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Total Marks</label>
													<div class="col-lg-9">
														<input id="matric_max" type="number" class="form-control"
															name="matric_max" value="1050" readonly autofocus>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Marks Obtained</label>
													<div class="col-lg-9">
														<input id="matric_obt" type="number" class="form-control"
															name="matric_obt" value="{{ $student->matric_obt }}" autofocus placeholder="Enter Matric Mark Obtained">
															<span class="text-danger" id="span_matric_obt"></span>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Board</label>
													<div class="col-lg-9">
														<input id="matric_board" type="text"  value="{{ $student->matric_board }}" class="form-control"
															name="matric_board" autofocus placeholder="Enter Board Name">
													</div>                   
												</div>   
												<!-- end matric -->
											</div>
											<div class="col-xl-6">
												<h4> Inter Detail </h4>
												<!-- start inter -->
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Result Status</label>
													<div class="col-lg-9">
														<select name="inter_degree_type" class="select">
															<option value="">Select Result Status</option>
															<option value="Pass" selected>Pass</option>
															<option value="Result Awaiting">Result Awaiting</option>
														</select>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Passing Year</label>
													<div class="col-lg-9">
														<input id="passing_year_int" type="text" value="{{ $student->passing_year_int }}" class="form-control"
															name="passing_year_int" autofocus placeholder="Enter Passing Year">
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Total Marks</label>
													<div class="col-lg-9">
														<input id="inter_max" type="number" class="form-control"
															name="inter_max" value="1100" readonly autofocus>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Marks Obtained</label>
													<div class="col-lg-9">
														<input id="inter_obt" type="number" class="form-control"
															name="inter_obt" value="{{ $student->inter_obt }}" autofocus placeholder="Enter 1st Obtained Marks ">
														<span class="text-danger" id="span_inter_obt"></span>
													</div>
												</div>
												<div class="form-group row" id="">
													<label class="col-lg-3 col-form-label">Board</label>
													<div class="col-lg-9">
														<input id="inter_board" type="text" value="{{ $student->inter_board }}" class="form-control"
															name="inter_board" autofocus placeholder="Enter Inter Board">
													</div>
												</div>
												<!-- end inter -->
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Transferred</label>
													<div class="col-lg-9">
														<select name="transfered" class="select">
															<option value="">Select Transferred/Migrated</option>
															<option value="1">Yes</option>
															<option value="2" selected>No</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Father/ Guardian</label>
													<div class="col-lg-9">
														<select name="guardian" class="select">
															<option value="">Select Father/guardian</option>
															<option value="Father" selected> Father</option>
															<option value="Mother">Mother</option>
															<option value="Uncle">Uncle</option>
															<option value="Brother">Brother</option>
															<option value="Sister">Sister</option>
														</select>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Father/ Guardian Name</label>
													<div class="col-lg-9">
														<input id="guardian_name" type="text"  value="{{ $student->guardian_name }}" class="form-control"
															name="guardian_name" autofocus placeholder="father/guardian Name">
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Father/ Guardian CNIC</label>
													<div class="col-lg-9">
														<input id="guardian_cnic" type="text" class="form-control" name="guardian_cnic" value="{{ $student->guardian_cnic }}" autofocus placeholder="Enter Guardian CNIC NO">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Father/ Guardian Contact Number</label>
													<div class="col-lg-9">
														<input id="guardian_mobile" type="text" class="form-control" name="guardian_mobile" value="{{ $student->guardian_mobile }}" autofocus placeholder="Enter Guardian Cantact No">
													</div>
												</div>

											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xl-12">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Profile Picture</label>
													<div class="col-lg-9">
														<input id="student_profile_pic" type="file" class="form-control" name="student_profile_pic">
													</div>
												</div>
											</div>
										</div>
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managestudent") }}'" class="btn btn-danger">Cancel</button>
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
			$(document).ready(function(){
				$("#matric_passing_year").datepicker({
					format: "yyyy",
					viewMode: "years", 
					minViewMode: "years",
					autoclose:true
				});  
				$("#passing_year_int").datepicker({
					format: "yyyy",
					viewMode: "years", 
					minViewMode: "years",
					autoclose:true
				});  
			})
			function getProvince(siteurl){
				const country_id = $('#nationality').val();
				$('#state').html('');
				getDropDownByCountryState(siteurl, country_id, 'country');
			}

			function getCites(siteurl){
				const state_id = $('#state').val();
				$('#cities').html('');
				getDropDownByCountryState(siteurl, state_id, 'state');
			}
			
			function getDropDownByCountryState(siteurl, id, condition){
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
						if(condition ==='country'){
							$('#state').html(response);
						}else if(condition ==='state'){
							$('#cities').html(response);
						}
					}
				});
			}
		</script>
        @endsection
