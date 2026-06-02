<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add | PLO</title>      
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
									<li class="breadcrumb-item active">Add PLO</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">PLO</h4>
									<form method="POST" action="{{ route('storeplo') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        
                                        <input type="hidden" name="program_batch_id" value="{{ $id }}">
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Code</label>
													<div class="col-lg-9">
														<input id="code" type="text" class="form-control"
															name="code" value="{{ old('code') }}"   autofocus placeholder="Enter Code">
															<span class="text-danger">{{$errors->first('code')}}</span>
													</div>
												</div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Description</label>
													<div class="col-lg-9">
                                                        <textarea type="text" name="description" value="{{ old('description') }}"  class="form-control" placeholder="Enter Descriptions"></textarea>
													</div>
												</div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PEO's</label>
                                                    <div class="col-lg-9">
                                                        <select id="peo_id" name="peo_id" class="select">
                                                            <option value="" selected>- Select -</option>
                                                            @foreach ($peos as $peo)
																<option value="{{ $peo->id }}" >{{ $peo->code .' - '.$peo->description }}</option>
															@endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
											</div>
												
											<div class="col-xl-6">
                                                <div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" class="form-control"
															name="name" value="{{ old('name') }}"   autofocus placeholder="Enter Name">
															<span class="text-danger">{{$errors->first('name')}}</span>
													</div>
												</div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Strategies</label>
                                                    <div class="col-lg-9">
                                                        <textarea type="text" name="strategies" value="{{ old('strategies') }}"  class="form-control" placeholder="Enter Strategies"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Knowledge Profiles</label>
                                                    <div class="col-lg-9">
                                                        <textarea type="text" name="knowledge_profile" value="{{ old('knowledge_profile') }}"  class="form-control" placeholder="Enter Knowledge Profile"></textarea>
                                                    </div>
                                                </div>
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("showplo",$id) }}'" class="btn btn-danger">Cancel</button>
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
