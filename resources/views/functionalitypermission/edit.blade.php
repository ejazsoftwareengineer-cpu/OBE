<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Functionality Permission</title>      
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
									<li class="breadcrumb-item active">Edit Functionality Permission</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('updatefunctionalitypermission') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" id="functionalitypermission_id" value="{{ $functionalitypermission->id }}">
										
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">User</label>
													<div class="col-lg-9">
														<select name="user_id" class="select">
															<option value="">Select user</option>
															@foreach ($users as $user)
																<option value="{{ $user->id }}" @if($user->id === $functionalitypermission->user_id) ? selected : '' @endif   >{{ $user->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('user_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Role</label>
													<div class="col-lg-9">
														<select name="role_id" class="select">
															<option value="">Select role</option>
															@foreach ($roles as $role)
																<option value="{{ $role->id }}"  @if($role->id === $functionalitypermission->role_id) ? selected : '' @endif   >{{ $role->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('role_id')}}</span>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Function</label>
													<div class="col-lg-9">
														<select id="function_id" name="function_id" class="select" onchange="getTableData('{{route('getdatabyfunction')}}')">
															<option value="">Select function</option>
															@foreach ($functionality as $fun)
																<option value="{{ $fun->id }}"  @if($fun->id === $functionalitypermission->function_id) ? selected : '' @endif >{{ $fun->functionality_name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('function_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label" id="function_label">Please Select</label>
													<div class="col-lg-9" id="field_relavent_id">
													<select id="relavent_id" name="relavent_id" class="select">    
														<option value="">None</option>
													</select>
														<span class="text-danger">{{$errors->first('relavent_id')}}</span>
													</div>
												</div>
												
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managefunctionalitypermission") }}'" class="btn btn-danger">Cancel</button>
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

				function getTableData(siteurl){
					const function_id = $('#function_id').val();
					// alert(function_id);
					$('#field_relavent_id').html('');
					getDropDown(siteurl, function_id);
				}

				function getDropDown(siteurl, id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					const functionalitypermissionId = $('#functionalitypermission_id').val();
					// alert(functionalitypermissionId)
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: id,
							functionalitypermissionId: functionalitypermissionId,
						},
						success: function(response){
							console.log(response)
							$('#field_relavent_id').html(response);
							$('#field_relavent_id select[id="relavent_id"]').select2();
							var element = $('.select2-container');
							element.css("width", "450px");
						}
					});
				}
				$(document).ready(function() {
					const selectedFunctionId = $('#function_id').val();
					
					if (selectedFunctionId) {
						getTableData('{{ route('getdatabyfunction') }}');
					}
				});
			</script>
        @endsection
