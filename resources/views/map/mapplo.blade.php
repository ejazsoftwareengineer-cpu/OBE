<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Map PLO</title>      
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
									<li class="breadcrumb-item active">Map PEO & PLO & CLO</li>
								</ul>
							</div>
						</div>
					</div>
					<h5>PEO's PLO's Mapping</h5>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Select Program</label>
												<div class="col-lg-9">
													<select id="peo-plo-program-id" name="program_id" class="select" onchange="getMappingPEOPLOsection('{{route('getmappingviewbypeoplo')}}')">
														<option value="">- Select -</option>
														@foreach ($program as $prog)
															<option value="{{ $prog->id }}" >{{ $prog->name ?? ' ' }}</option>
														@endforeach
													</select>
													</div>
												</div>
										</div>
									</div>
									<div id="peo-plo-mapping-table" class="table-responsive">
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<h5>CLO's PLO's Mapping</h5>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Select Program</label>
												<div class="col-lg-9">
													<select id="program_id" name="program_id" class="select" onchange="getCourses('{{route('getcoursesbyprogram')}}')">
														<option value="">- Select -</option>
														@foreach ($program as $pro)
															<option value="{{ $pro->id }}" >{{ $pro->name ?? ' ' }}</option>
														@endforeach
													</select>
													    <span id="sapn_program_id" style="color:red;display:none;">Program is Required</span>
													</div>
												</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Select Course</label>
												<div class="col-lg-9">
													<select id="course_id" name="course_id" class="select" onchange="getQuestion('{{route('getmappingviewbycourse')}}')">
													
													</select>
													<span id="sapn_course_id" style="color:red;display:none;">Course is Required</span>
												</div>
											</div>
										</div>
									</div>
									<div id="mapping-table" class="table-responsive">
										
									</div>
								</div>
							</div>
						</div>
					</div>
					
										
				</div>			
			</div>
        @endsection

        @section('script')
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

			<script>
				function getMappingPEOPLOsection(siteurl){
					const peo_plo_program_id = $('#peo-plo-program-id').val();
					$('#peo-plo-mapping-table').html('');
					getDropDownDataPeoPlo(siteurl, peo_plo_program_id);
					
				}
				function getDropDownDataPeoPlo(siteurl, peo_plo_program_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							peo_plo_program_id: peo_plo_program_id
						},
						success: function(response){
                            $('#peo-plo-mapping-table').html(response);
						}
					});
				}
				
				function getQuestion(siteurl){
					const course_id = $('#course_id').val();
					const program_id = $('#program_id').val();
					if(!program_id){
						$('#sapn_program_id').show();
						return;
						// alert(program_id);
					}else if(!course_id){
						$('#sapn_course_id').show();
						return;	
					}else{
						$('#sapn_program_id').hide();
						$('#sapn_course_id').hide();
						$('#mapping-table').html('');
						getDropDownData(siteurl, course_id,program_id);
					}
				}
				
				function getDropDownData(siteurl, course_id, program_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							course_id: course_id,
							program_id: program_id
						},
						success: function(response){
                            $('#mapping-table').html(response);
						}
					});
				}
				
				function mapPLOCLO(siteurl,plo_id,clo_id,course_id,unique_id){
					jQuery.ajaxSetup({
						headers: {
								'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});
					if($("#checkbox"+unique_id).is(":checked")){
						var checked = 1;      
					} else if($("#checkbox"+unique_id).is(":not(:checked)")){            
						var checked = 0;      
					}  
					const program_id = $('#program_id').val();
					  $.ajax({
						type: "POST",
						url: siteurl,
						data: {
							plo_id: plo_id,
							clo_id: clo_id,
							course_id: course_id,
							program_id: program_id,
							checked: checked
						},
					}); 
				}
				
				function mapPEOPLO(siteurl,plo_id,peo_id,program_id,unique_id){
					jQuery.ajaxSetup({
						headers: {
								'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});
					if($("#peoplocheckbox"+unique_id).is(":checked")){
						var checked = 1;      
					} else if($("#peoplocheckbox"+unique_id).is(":not(:checked)")){            
						var checked = 0;      
					}     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							plo_id: plo_id,
							peo_id: peo_id,
							program_id: program_id,
							checked: checked,
						}
					});
				}
				function getCourses(siteurl){
                const program_id = $('#program_id').val();
                $('#course_id').html('');
                getDropDownCoursesData(siteurl, program_id);
                
            }
            function getDropDownCoursesData(siteurl, program_id){
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });     
                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        program_id: program_id
                    },
                    success: function(response){
                        $('#course_id').html(response);
                    }
                });
            }


				
			</script>
        @endsection
