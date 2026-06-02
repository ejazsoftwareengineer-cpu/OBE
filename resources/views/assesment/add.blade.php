<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Assesment</title>      
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
									<li class="breadcrumb-item active">Activity/Assessment Method</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Create Activity/Assessment Method</h4>
									<form method="POST" action="{{ route('storeassesment') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ old('name') }}"   autofocus >
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
											</div>
											
											<div class="col-xl-6">
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
											
											<!-- <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Allowed Operation</label>
													<div class="col-lg-9">
														<select name="allowed_operation" class="select">
															<option value="0">None</option>
															<option value="1" selected="">Accept Uploads</option>
															<option value="2">Online Quiz</option>
															<option value="3">Online Assignment</option>
														</select>
														
													</div>
												</div>
											</div> -->
										</div>
										
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Sub activity</label>
													<div class="col-lg-9">
														<input id="short_name" type="text" class="form-control"
															name="short_name" value="{{ old('short_name') }}" autofocus >
													</div>
												</div>
												
											</div>
											<!-- <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Allowed Operation</label>
													<div class="col-lg-9">
														<select name="allowed_operation" class="select">
															<option value="0">None</option>
															<option value="1" selected="">Accept Uploads</option>
															<option value="2">Online Quiz</option>
															<option value="3">Online Assignment</option>
														</select>
														
													</div>
												</div>
											</div> -->
											<!-- <div class="form-group row" style="margin: auto;">
												<label class="d-block"> Is Rubric</label>
												<div class="col-lg-3">
													<input type="checkbox" id="is_rubric" name="is_rubric" value="0" class="check">
													<label for="is_rubric" class="checktoggle">checkbox</label>
												</div>
												
											</div>	
											<div class="form-group row" style="margin: auto;">
												<label class="d-block">Allow to change in CMS</label>
												<div class="col-lg-3">
													<input type="checkbox" id="allow_change_cms" name="allow_change_cms" value="0" class="check">
													<label for="allow_change_cms" class="checktoggle">checkbox</label>
												</div>
											</div>	
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Default value in CMS Planning</label>
													<div class="col-lg-9">
													<input type="number" class="form-control" name="cms_value" >
													</div>
												</div>
											</div> -->
										</div>
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageassesment") }}'" class="btn btn-danger">Cancel</button>
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
			
            $('#is_rubric').change(function(){
                if($(this).prop("checked") == true){
                    $('#is_rubric').val(1)
                }else if($(this).prop("checked") == false){
                    $('#is_rubric').val(0)
                }
            });
			
            $('#allow_change_cms').change(function(){
                if($(this).prop("checked") == true){
                    $('#allow_change_cms').val(1)
                }else if($(this).prop("checked") == false){
                    $('#allow_change_cms').val(0)
                }
            });
		</script>
        @endsection
