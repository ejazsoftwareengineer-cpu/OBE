<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add User</title>      
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
									<li class="breadcrumb-item active">Add User</li>
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
									<form method="POST" action="{{ route('storeuser') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">First Name</label>
													<div class="col-lg-9">
														<input id="firstname" type="text" class="form-control"
															name="firstname" value="{{ old('firstname') }}"   autofocus placeholder="Enter first name">
															<span class="text-danger">{{$errors->first('firstname')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Last Name</label>
													<div class="col-lg-9">
														<input id="lastname" type="text" class="form-control" name="lastname" autofocus value="{{ old('lastname') }}" placeholder="Enter last name">
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
													<label class="col-lg-3 col-form-label">Phone</label>
													<div class="col-lg-9">
														<input id="phone_number" type="text" class="form-control"
															name="phone_number" value="{{ old('phone_number') }}" autofocus placeholder="Enter phone number">
															<span class="text-danger">{{$errors->first('phone_number')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Role</label>
													<div class="col-lg-9">
														<select name="role_id[]" class="select" multiple>
															<option value="" >Select role</option>
															@foreach ($roles as $role)
																<option value="{{ $role->id }}" >{{ $role->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('role_id')}}</span>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Email</label>
													<div class="col-lg-9">
														<input id="email" type="text" class="form-control"
															name="email" value="{{ old('email') }}" autofocus placeholder="Enter email address">
															<span class="text-danger">{{$errors->first('email')}}</span>
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
												<!-- <div class="form-group row">
													<label class="col-lg-3 col-form-label">User Type</label>
													<div class="col-lg-9">
														<select name="usertype_id" class="select">
															<option value="">Select user type</option>
															@foreach ($usertypes as $usertype)
																<option value="{{ $usertype->id }}" >{{ $usertype->name }}</option>
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('usertype_id')}}</span>
													</div>
												</div> -->
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Address</label>
													<div class="col-lg-9">
														<textarea type="text" name="address" value="{{ old('address') }}"  class="form-control" placeholder="Enter address"></textarea>
													</div>
												</div>
											</div>
										</div>

										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageuser") }}'" class="btn btn-danger">Cancel</button>
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
