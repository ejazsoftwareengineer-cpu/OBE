<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Activity/Assessment </title>      
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
									<li class="breadcrumb-item active">Edit Activity/Assessment Method</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('updateassesment') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $assesment->id }}">
										
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $assesment->name }}" autofocus >
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" @if($assesment->status == '1') selected @endif>Active</option>
															<option value="0" @if($assesment->status == '0') selected @endif>Inactive</option>
														</select>
														
													</div>
												</div>
											</div>
											
											<!-- <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Allowed Operation</label>
													<div class="col-lg-9">
														<select name="allowed_operation" class="select">
															<option value="0" @if($assesment->allowed_operation == '0') selected @endif>None</option>
															<option value="1" @if($assesment->allowed_operation == '1') selected @endif>Accept Uploads</option>
															<option value="2" @if($assesment->allowed_operation == '2') selected @endif>Online Quiz</option>
															<option value="3" @if($assesment->allowed_operation == '3') selected @endif>Online Assignment</option>
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
															name="short_name" value="{{ $assesment->short_name }}" autofocus >
													</div>
												</div>
												
											</div>
											<!-- <div class="form-group row" style="margin: auto;">
												<label class="d-block"> Is Rubric</label>
												<div class="col-lg-3">
													<input type="checkbox" id="is_rubric" name="is_rubric" value="{{ $assesment->is_rubric }}" class="check" <?php echo ($assesment->is_rubric === 1 ? 'checked' : '');?>>
													<label for="is_rubric" class="checktoggle">checkbox</label>
												</div>
												
											</div>	
											<div class="form-group row" style="margin: auto;">
												<label class="d-block">Allow to change in CMS</label>
												<div class="col-lg-3">
													<input type="checkbox" id="allow_change_cms" name="allow_change_cms" value="{{ $assesment->allow_change_cms }}" <?php echo ($assesment->allow_change_cms === 1 ? 'checked' : '');?> class="check">
													<label for="allow_change_cms" class="checktoggle">checkbox</label>
												</div>
											</div>	
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Default value in CMS Planning</label>
													<div class="col-lg-9">
													<input type="number" class="form-control" name="cms_value" value="{{ $assesment->cms_value }}">
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

        @endsection
