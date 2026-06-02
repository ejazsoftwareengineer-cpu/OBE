<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add | Program Learning Outcomes</title>      
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
									<li class="breadcrumb-item active">Add Program Learning Outcomes</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
                    <div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Program Learning Outcomes</h4>
									<form method="POST" action="{{ route('storeprogramlearningoutcome') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<!-- <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"> Institute <span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <select id="institute_id" name="institute_id" class="select" onchange="getProgram('{{route('getinstitutebyprogram')}}')">
                                                            <option value="">Select institute</option>
                                                            @foreach ($institute as $ins)
																<option value="{{ $ins->id }}" >{{ $ins->name }}</option>
															@endforeach
                                                        </select>
                                                        
															<span class="text-danger">{{$errors->first('institute_id')}}</span>
                                                    </div>
                                                </div>
											</div> -->
                                            
											<div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Program Name<span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <select id="program_id"  name="program_id" class="select" >
                                                            <option value="">Select Program</option>
                                                            @foreach ($programs as $ins)
																<option value="{{ $ins->id }}" >{{ $ins->name }}</option>
															@endforeach
                                                        </select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
                                                    </div>
                                                </div>
                                                
											</div>
										</div>
                                        <div id="ploContainer">
                                            
                                        </div>
                                        <div class="text-right" style="padding-bottom: 20px;">
                                            <button id="addPloButton" type="button" class="btn btn-primary">Add PLO</button>
                                        </div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageprogramlearningoutcome") }}'" class="btn btn-danger">Cancel</button>
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
                function updatePloIndices() {
                    $('#ploContainer .plo-row').each(function(index) {
                        var newIndex = index + 1;
                        $(this).attr('data-plo', newIndex);
                        $(this).find('input[id^="code"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`PLO${newIndex}`);
                        $(this).find('input[id^="name"]').attr('name', `name_${newIndex}`).attr('id', `name_${newIndex}`);
                        $(this).find('textarea[name^="description"]').attr('name', `description_${newIndex}`);
                        $(this).find('.remove-plo').attr('data-plo', newIndex);
                    });
                }

                function addPlo(index) {
                    var ploHtml = `
                        <div class="row plo-row" data-plo="${index}">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PLO Code<span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <input id="code_${index}" type="text" readonly class="form-control" value="PLO${index}" placeholder="Enter PLO Code" name="code_${index}" autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PLO Name<span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <input id="name_${index}" type="text" class="form-control" name="name_${index}" autofocus placeholder="Enter name">
                                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">PLO Description<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12">
                                                        <textarea type="text" name="description_${index}" class="form-control" placeholder="Enter description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-danger remove-plo" data-plo="${index}">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#ploContainer').append(ploHtml);
                }

                $(document).ready(function() {
                    var ploCount = 1;

                    $('#addPloButton').click(function() {
                        addPlo(ploCount);
                        ploCount++;
                    });

                    $(document).on('click', '.remove-plo', function() {
                        $(this).closest('.plo-row').remove();
                        updatePloIndices();
                        ploCount = $('#ploContainer .plo-row').length + 1; // Adjust ploCount to the number of PLOs
                    });
                });


                function getProgram(siteurl){
                    const institute_id = $('#institute_id').val();
                    $('#program_id').html('');
                    getDropDownByDepartmentProgram(siteurl, institute_id, 'program');
                }
                
                
                function getDropDownByDepartmentProgram(siteurl, id, condition){
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
                            if(condition ==='program'){
                                $('#program_id').html(response);
                            }
                        }
                    });
                }
            </script>
        @endsection
