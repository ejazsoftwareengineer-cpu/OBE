<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Acedemic Year</title>      
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
									<li class="breadcrumb-item active">Add Acedemic Year</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<form method="POST" action="{{ route('storeacedemicyear') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Start Date</label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker" name="start_date" type="text" placeholder="Enter Start Date">
															<span class="text-danger">{{$errors->first('start_date')}}</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">End Date</label>
													<div class="col-lg-9">
														<input class="form-control datetimepicker" name="end_date" type="text" placeholder="Enter Start Date">
															<span class="text-danger">{{$errors->first('end_date')}}</span>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
													<input id="name" type="text" class="form-control"
															name="name" placeholder="Fall / Spring Year">
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
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Type </label>
													<div class="col-lg-9">
														<select name="type" class="select">
															 
															<option value="f">Fall</option>
															<option value="s">Spring</option>
														</select>
														
													</div>
												</div>
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageacedemicyear") }}'" class="btn btn-danger">Cancel</button>
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
