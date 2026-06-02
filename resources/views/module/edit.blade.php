<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Module</title>      
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
									<li class="breadcrumb-item active">Edit Module</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Module information</h4>
									<form method="POST" action="{{ route('updatemodule') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <input type="hidden" name="id" value="{{ $module->id }}">
										<div class="row">
                                            <div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Name</label>
													<div class="col-lg-9">
														<input id="name" type="text" onblur="creat_link(),menus('{{url('/')}}')"  class="form-control"
															name="module_name" value="{{ $module->module_name }}" placeholder="Enter Module Name">
															<span class="text-danger">{{$errors->first('module_name')}}</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<select name="status" class="select">
															 
															<option value="1" @if($module->status == '1') selected @endif>Active</option>
															<option value="0" @if($module->status == '0') selected @endif>Inactive</option>
														</select>
													</div>
												</div>
											</div>
												
											
										</div>
										<div class="row">
										<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Icon</label>
													<div class="col-lg-9">
													<input id="icon" type="text"  value="{{ $module->icon }}" class="form-control"
															name="icon" >
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Category</label>
													<div class="col-lg-9">
														<select name="category_id" class="select">
															<option value=""> Select Category</option>
															@foreach ($category as $cat)
																<option value="{{ $cat->id }}" @if($module->category_id === $cat->id) ? selected : '' @endif  >{{ $cat->name }}</option>
															
															@endforeach
														</select>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Slug</label>
													<div class="col-lg-9">
														<input id="permalink" type="text" value="{{ $module->slug }}" class="form-control"
															name="slug">
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Menu Template</label>
													<div class="col-lg-9">
														<textarea id="menudescription" type="text" name="menu_template" class="form-control" >{{ $module->menu_template }}</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managemodule") }}'" class="btn btn-danger">Cancel</button>
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
