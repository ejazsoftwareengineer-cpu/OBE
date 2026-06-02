<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Campus</title>      
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
									<li class="breadcrumb-item active">Add Campus</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Campus information</h4>
									<form method="POST" action="{{ route('storecampus') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Campus Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ old('name') }}"   autofocus placeholder="Enter campus name">
															<span class="text-danger">{{$errors->first('name')}}</span>
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
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">City</label>
													<div class="col-lg-9">
														<input id="city" type="text" class="form-control"
															name="city" value="{{ old('city') }}"   autofocus placeholder="Enter city">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Zipcode</label>
													<div class="col-lg-9">
														<input id="zipcode" type="text" class="form-control"
															name="zipcode" value="{{ old('zipcode') }}"   autofocus placeholder="Enter zipCode">
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Campus Code</label>
													<div class="col-lg-9">
														<input id="campus_code" type="text" class="form-control"
															name="campus_code" value="{{ old('campus_code') }}"   autofocus placeholder="Enter campus code">
															<span class="text-danger">{{$errors->first('campus_code')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Organization</label>
													<div class="col-lg-9">
														<select name="organization_id" class="select">
															<option value=""> Select organization</option>
															@foreach ($organizations as $organization)
																<option value="{{ $organization->id }}" >{{ $organization->name }}</option>
															
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('organization_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Location</label>
													<div class="col-lg-9">
														<textarea type="text" name="location" value="{{ old('location') }}"  class="form-control" placeholder="Enter campus location"></textarea>
														<span class="text-danger">{{$errors->first('location')}}</span>
													</div>
												</div>
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managecampus") }}'" class="btn btn-danger">Cancel</button>
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
