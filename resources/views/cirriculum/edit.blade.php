<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Curriculum</title>      
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
									<li class="breadcrumb-item active">Edit Curriculum</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<form method="POST" action="{{ route('updatecirriculum') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $cirriculum->id }}">

										<div class="row">
                                            <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Session Offer</label>
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
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $cirriculum->name }}" placeholder="Enter Curriculum Name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Institute</label>
													<div class="col-lg-9">
														<select name="institute_id" id="institute_id" class="select" onchange="getProgram('{{route('getinstitutebyprogram')}}')">
															<option value=""> Select Institute</option>
															@foreach ($institute as $ins)
																<option value="{{ $ins->id }}"  @if($ins->id === $cirriculum->institute_id) ? selected : '' @endif   >{{ $ins->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('institute_id')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Programs</label>
													<div class="col-lg-9">
														<select id="program_id" name="program_id" class="select" >
															<?php if($cirriculum->program) {?>
																<option value="{{ $cirriculum->program->id }}">{{$cirriculum->program->name}}</option>  
															<?php }?> 
															
														</select>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter Descriptions">{{ $cirriculum->description }}</textarea>
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
											<button type="button" onclick="window.location='{{ route("managecirriculum") }}'" class="btn btn-danger">Cancel</button>
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
				getDropDownByDepartmentProgram(siteurl, institute_id, 'program');
			}
			
			function getDropDownByDepartmentProgram(siteurl, id, condition){
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
						if(condition ==='program'){
							$('#program_id').html(response);
						}
					}
				});
			}
		</script>
        @endsection
