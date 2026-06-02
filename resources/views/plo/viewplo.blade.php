<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | Program Learning Outcomes</title>      
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
									<li class="breadcrumb-item active">View Program Learning Outcomes</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
                                    <div class="row">
											<!-- <div class="col-xl-6"> -->
                                            <?php $program = $program_object::select('id','name','institute_id')->whereid($id)->first(); ?>
                                           
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Program</label>
                                                    <div class="col-lg-9">
                                                    <input type="hidden" class="form-control" name="program_id" value="{{$program->id}}" autofocus>
                                                    <input type="text" class="form-control" name="program_name" readonly value="{{$program->name}}" autofocus>
                                                        
                                                    </div>
                                                </div>
											</div>
										</div>
                                        <div id="ploContainer">
                                        <?php $plocount = 0; $plos = $plo_object::whereprogram_id($id)->get(); ?>
                                            <?php foreach($plos as $plo): ?>
                                                <?php $plocount++; ?>
                                                <input type="hidden" name="plo_id_{{$plocount}}" value="{{$plo->id}}">
                                                <div class="row plo-item" data-plo="{{$plocount}}">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Code</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" readonly class="form-control" name="code_{{$plocount}}" value="{{$plo->code}}" autofocus placeholder="Enter clo code">
                                                                                <span class="text-danger">{{$errors->first('code')}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Name</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" class="form-control" name="weight_{{$plocount}}" value="{{$plo->name}}" autofocus placeholder="Enter Clo Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Description</label>
                                                                            <div class="col-lg-12">
                                                                                <textarea type="text" name="description_{{$plocount}}" class="form-control" placeholder="Enter description">{{$plo->description}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
										
								</div>
							</div>
						</div>
					</div>
				
				</div>			
			</div>
        @endsection

        @section('script')
        
        @endsection
