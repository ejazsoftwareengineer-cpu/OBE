<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Organization</title>      
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
									<li class="breadcrumb-item active">Edit Organization</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Organization </h4>
									<form method="POST" action="{{ route('updateorganization') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $organization->id }}">
										<div class="row">
                                            <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $organization->name }}" placeholder="Enter organization name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter descriptions">{{ $organization->description }}</textarea>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Vision</label>
													<div class="col-lg-9">
													<textarea type="text" name="vision" class="form-control" placeholder="Enter vision"> {{ $organization->vision }}</textarea>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
											
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															<option value="1" @if($organization->status == '1') selected @endif>Active</option>
															<option value="0" @if($organization->status == '0') selected @endif>Inactive</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Location</label>
													<div class="col-lg-9">
														<textarea type="text" name="location" value="{{ old('location') }}"  class="form-control" placeholder="Enter organization location">{{ $organization->location }}</textarea>
														<span class="text-danger">{{$errors->first('location')}}</span>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Mission</label>
													<div class="col-lg-9">
														<textarea type="text" name="mission" class="form-control" placeholder="Enter mission">{{ $organization->mission }}</textarea>
													</div>
												</div>
												
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageorganization") }}'" class="btn btn-danger">Cancel</button>
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
