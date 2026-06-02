<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | Course Learning Outcomes</title>      
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
									<li class="breadcrumb-item active">View Course Learning Outcomes</li>
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
											<div class="col-xl-6">
                                            <?php $course = $course_object::select('id','name','code')->whereid($id)->first(); ?>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label" disabled >Course</label>
                                                    <div class="col-lg-9">
                                                        <select name="course_id" class="select">
                                                            <?php $code= $course->code ?? '' ;?>
                                                            <?php $name= $course->name ?? '' ;?>
																<option >{{ $code  . '-' .$name  }}</option>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
                                        <div id="cloContainer">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                    <?php $clocount = 1; $clos = $clo_object::wherecourse_id($id)->get(); ?>
                                                    <?php foreach($clos as $clo){?>
                                                        <div class="card-body">
                                                            <h4 class="card-title">CLO {{$clocount}}</h4>
                                                            <div class="row">
                                                                
                                                                <div class="col-xl-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Code</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" value="{{$clo->code}}">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">CLO Weight</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" value="{{$clo->weight }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Description</label>
                                                                        <div class="col-lg-9">
                                                                            <textarea type="text" class="form-control">{{ $clo->description}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6"> 
                                                                    
                                                                    <?php
                                                                        $domain = '';
                                                                        if($clo->domain === 1){
                                                                            $domain = 'Cognative';
                                                                        }else if($clo->domain === 2){
                                                                            $domain = 'Affective';
                                                                        }else if($clo->domain === 3){
                                                                            $domain = 'Psychomotor';
                                                                        }
                                                                    ?>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Domain</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" value="{{ $domain }}">
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        $level = '';
                                                                        if($clo->level === 1){
                                                                            $level = 'Receiving';
                                                                        }else if($clo->level === 2){
                                                                            $level = 'Responding';
                                                                        }else if($clo->level === 3){
                                                                            $level = 'Valuing';
                                                                        }else if($clo->level === 4){
                                                                            $level = 'Organization';
                                                                        }else if($clo->level === 5){
                                                                            $level = 'Internalizing';
                                                                        }else if($clo->level === 6){
                                                                            $level = 'Remembering';
                                                                        }else if($clo->level === 7){
                                                                            $level = 'Understanding';
                                                                        }else if($clo->level === 8){
                                                                            $level = 'Applying';
                                                                        }else if($clo->level === 9){
                                                                            $level = 'Analyzing';
                                                                        }else if($clo->level === 10){
                                                                            $level = 'Evaluating';
                                                                        }else if($clo->level === 11){
                                                                            $level = 'Creating';
                                                                        }else if($clo->level === 12){
                                                                            $level = 'Perception';
                                                                        }else if($clo->level === 13){
                                                                            $level = 'Set';
                                                                        }else if($clo->level === 14){
                                                                            $level = 'Guided Response';
                                                                        }else if($clo->level === 15){
                                                                            $level = 'Mechanism';
                                                                        }else if($clo->level === 16){
                                                                            $level = 'Complete Overt Response';
                                                                        }else if($clo->level === 17){
                                                                            $level = 'Adaption';
                                                                        }else if($clo->level === 18){
                                                                            $level = 'Organization';
                                                                        }else{
                                                                            $level ="None";
                                                                        }
                                                                    ?>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Level</label>
                                                                        <div  class="col-lg-9">
                                                                            <input type="text" class="form-control" value="{{ $level }}">
                                                                        </div>
                                                                    </div>

                                                                   

                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php $clocount++; } ?>
                                                    </div>
                                                </div>
                                            </div>
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
