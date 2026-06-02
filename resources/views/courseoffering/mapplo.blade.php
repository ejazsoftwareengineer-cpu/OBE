<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>MAP | PLO Mapping</title>      
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
									<li class="breadcrumb-item active">Add PLO Mapping </li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Add PLO Mapping</h4>
									<form method="POST" action="{{ route('storeplobyclo') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<input type="hidden" name="clo_id" value="{{ $id }}"/>
										<input type="hidden" name="course_id" value="{{ $course }}"/>
										<input type="hidden" name="course_section_id" value="{{ $courseoffering }}"/>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Program </label>
													<div class="col-lg-9">
														<select id="program_id" name="program_id"  class="select" onchange="getPlo('{{route('getplobyprogram')}}')">
                                                            <option value="" selected>- Select -</option>
															@foreach ($program as $p)
																<option value="{{ $p->id }}" >{{ $p->name }}</option>
															@endforeach
                                                        </select>
													</div>
												</div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Domain</label>
                                                    <div class="col-lg-9">
                                                        <select id="domain" name="domain" class="select" onchange="changeDomain()">
                                                            <option value="" selected>Select Domain</option>
                                                            <option value="1" >Cognative</option>
                                                            <option value="2">Affective</option>
                                                            <option value="3">Psychomotor</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Emphasis Level</label>
                                                    <div class="col-lg-9">
                                                        <select name="emphasis_level" class="select">
															<option value="">- Select -</option>
															<option value="1">3. Low</option>
															<option value="2">2. Medium</option>
															<option value="3">1. High</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
											</div>
												
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">PLO's</label>
													<div class="col-lg-9">
														<select  id="plo_id" name="plo_id" class="select">
                                                            <option value="" selected>- Select -</option>
                                                        </select>
													</div>
												</div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Level</label>
													<div id= "simple" class="col-lg-9">
														<select name="level1" class="select">
															<option value="">- Select -</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div style="display:none;" id="cognative" class="col-lg-9">
                                                        <select  id="level" name="level2" class="select">
															<option value="">- Select -</option>
															<option class="cognative" value="1">Receiving</option>
															<option class="cognative" value="2">Responding</option>
															<option class="cognative" value="3">Valuation</option>
															<option class="cognative" value="4">Organization</option>
															<option class="cognative" value="5">Intimalization</option>
															
                                                        </select>
                                                    </div>
													<div style="display:none;" id="effective" class="col-lg-9">
                                                       
														<select name="level3" class="select">
															<option value="">- Select -</option>
															<option class="effective" value="6">Knowledge</option>
															<option class="effective" value="7">Comprehension</option>
															<option class="effective" value="8">Application</option>
															<option class="effective" value="9">Analysis</option>
															<option class="effective" value="10">Synthesis</option>
															<option class="effective" value="11">Evaluation</option>
                                                        </select>
														 
                                                    </div>
													<div style="display:none;"  id="psychomotor" class="col-lg-9">
														<select name="level4" class="select">
															<option value="">- Select -</option>
															<option class="psychomotor" value="12">Perception</option>
															<option class="psychomotor" value="13">Set</option>
															<option class="psychomotor" value="14">Guided Response</option>
															<option class="psychomotor" value="15">Mechanism</option>
															<option class="psychomotor" value="16">Complete Overt Response</option>
															<option class="psychomotor" value="17">Adaption</option>
															<option class="psychomotor" value="18">Organization</option>
                                                        </select>
                                                        
                                                    </div>
													
                                                </div>
                                                
											</div>
										</div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("showcourseofferingclo",$courseoffering) }}'" class="btn btn-danger">Cancel</button>
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
        
		<script>
                function getPlo(siteurl){
                    const program_id = $('#program_id').val();
                    $('#plo_id').html('');
                    getDropDownByProgram(siteurl, program_id);
                }
				function changeDomain(){
                    const domain = $('#domain').val();
					if(domain === '1'){
						$('#simple').css('display','none');
						$('#effective').css('display','none');
						$('#psychomotor').css('display','none');
						$("#cognative").removeAttr("style");
					}else if(domain === '2'){
						$('#simple').css('display','none');
						$('#cognative').css('display','none');
						$("#effective").removeAttr("style");
					}else if(domain === '3'){
						$('#simple').css('display','none');
						$('#cognative').css('display','none');
						$('#effective').css('display','none');
						$("#psychomotor").removeAttr("style");
					}else{
						$('#simple').css('display','none');
						$('#cognative').css('display','none');
						$('#effective').css('display','none');
						$("#psychomotor").css('display','none');
						$("#simple").removeAttr("style");
					}
                }
                
                function getDropDownByProgram(siteurl, id){
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });     
                    $.ajax({
                        type: "POST",
                        url: siteurl,
                        data: {
                            id: id,
                        },
                        success: function(response){
							console.log(response)
							$('#plo_id').html(response);
                        }
                    });
                }
            </script>
        @endsection
