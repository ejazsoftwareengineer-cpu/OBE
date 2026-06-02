<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Faculty</title>      
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
									<li class="breadcrumb-item active">Edit Faculty</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Faculty INFO</h4>
									<form method="POST" action="{{ route('updatefaculty') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $faculty->id }}">
										<div class="row">
                                            <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ $faculty->name }}" placeholder="Enter Faculty Name">
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
													<label class="col-lg-3 col-form-label">Vision</label>
													<div class="col-lg-9">
													<textarea type="text" name="vision" class="form-control" placeholder="Enter Visions"> {{ $faculty->vision }}</textarea>
													</div>
												</div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Campus</label>
													<div class="col-lg-9">
														<select name="campus_id" class="select">
															<option value=""> Select Campus</option>
															
															@foreach ($campuses as $campus)
																<option value="{{ $campus->id }}" @if($campus->id === $faculty->campus_id) ? selected : '' @endif  >{{ $campus->name }}</option>
															
															@endforeach
														</select>
														<span class="text-danger">{{$errors->first('campus_id')}}</span>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
													<textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter Descriptions">{{ $faculty->description }}</textarea>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Mission</label>
													<div class="col-lg-9">
														<textarea type="text" name="mission" class="form-control" placeholder="Enter Mission">{{ $faculty->mission }}</textarea>
													</div>
												</div>
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managefaculty") }}'" class="btn btn-danger">Cancel</button>
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
