<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add | Course Learning Outcomes</title>      
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
									<li class="breadcrumb-item active">Add Course Learning Outcomes</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Course Learning Outcomes</h4>
									<form method="POST" action="{{ route('storecourselearningoutcome') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <div class="row">
											<div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"> Program <span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <select id="program_id" name="program_id[]" class="select" onchange="getCourses('{{route('getMultipleCoursesbyProgram')}}')" multiple>
                                                            <option value="">Select Program</option>
                                                            @foreach ($program as $pro)
																<option value="{{ $pro->id }}" >{{ $pro->name }}</option>
															@endforeach
                                                        </select>
                                                    </div>
                                                </div>
											</div>
                                            
											<div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Course<span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <select id="course_id"  name="course_id[]" class="select" multiple>
                                                        </select>
														<span class="text-danger">{{$errors->first('course_id')}}</span>
                                                    </div>
                                                </div>
                                                
											</div>
										</div>
										
                                        <div id="cloContainer">
                                           
                                            <!-- <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Course Learning Outcomes</h4>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Code</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" class="form-control" name="code_1" autofocus placeholder="Enter clo code">
                                                                            <span class="text-danger">{{$errors->first('code')}}</span>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">CLO Weight</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="number" class="form-control" name="weight_1" autofocus placeholder="Enter Weight">
                                                                            <span class="text-danger">{{$errors->first('weight')}}</span>
                                                                        </div>
                                                                    </div>    
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Description</label>
                                                                        <div class="col-lg-9">
                                                                            <textarea type="text" name="description_1" class="form-control" placeholder="Enter description"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6"> 
                                                                                                                                
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Domain</label>
                                                                        <div class="col-lg-9">
                                                                            <select id="domain_1" name="domain_1" class="select" onchange="changeDomain(1)">
                                                                                <option value="" selected>Select Domain</option>
                                                                                <option value="1" >Cognative</option>
                                                                                <option value="2">Affective</option>
                                                                                <option value="3">Psychomotor</option>
                                                                            </select>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Level</label>
                                                                        <div id= "simple_1" class="col-lg-9">
                                                                            <select name="level1_1" class="select">
                                                                                <option value="">- Select -</option>
                                                                            </select>
                                                                            
                                                                        </div>
                                                                        <div style="display:none;" id="cognative_1" class="col-lg-9">
                                                                            <select name="level2_1" class="select">
                                                                                <option value="">- Select -</option>
                                                                                <option class="cognative" value="6">Remembering</option>
                                                                                <option class="cognative" value="7">Understanding</option>
                                                                                <option class="cognative" value="8">Applying</option>
                                                                                <option class="cognative" value="9">Analyzing</option>
                                                                                <option class="cognative" value="10">Evaluating</option>
                                                                                <option class="cognative" value="11">Creating</option>
                                                                            </select>
                                                                        </div>
                                                                        <div style="display:none;" id="effective_1" class="col-lg-9">
                                                                            <select name="level3_1" class="select">
                                                                                <option value="">- Select -</option>
                                                                                <option class="effective" value="1">Receiving</option>
                                                                                <option class="effective" value="2">Responding</option>
                                                                                <option class="effective" value="3">Valuing</option>
                                                                                <option class="effective" value="4">Organization</option>
                                                                                <option class="effective" value="5">Internalizing</option>
                                                                            </select>
                                                                        </div>
                                                                        <div style="display:none;"  id="psychomotor_1" class="col-lg-9">
                                                                            <select name="level4_1" class="select">
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
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-danger remove-clo" data-clo="1">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="text-right" style="padding-bottom: 20px;">
                                            <button id="addCloButton" type="button" class="btn btn-primary">Add CLO</button>
                                        </div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("managecourselearningoutcome") }}'" class="btn btn-danger">Cancel</button>
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
            $('#aligned_vision').change(function(){
                if($(this).prop("checked") == true){
                    $('#aligned_vision').val(1)
                }else if($(this).prop("checked") == false){
                    $('#aligned_vision').val(0)
                }
            });
            $('#aligned_mission').change(function(){
                if($(this).prop("checked") == true){
                    $('#aligned_mission').val(1)
                }else if($(this).prop("checked") == false){
                    $('#aligned_mission').val(0)
                }
            });
                
            function updateCloIndices() {
                $('#cloContainer .clo-row').each(function(index) {
                    var newIndex = index + 1;
                    $(this).attr('data-clo', newIndex);
                    $(this).find('input[name^="code"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`CLO${newIndex}`);
                    $(this).find('input[name^="weight"]').attr('name', `weight_${newIndex}`);
                    $(this).find('textarea[name^="description"]').attr('name', `description_${newIndex}`);
                    $(this).find('select[name^="domain"]').attr('name', `domain_${newIndex}`).attr('id', `domain_${newIndex}`).attr('onchange', `changeDomain(${newIndex})`);
                    $(this).find('select[name^="level"]').attr('name', function(i, oldName) {
                        return oldName.replace(/\d+/, newIndex);
                    });
                    $(this).find('.remove-clo').attr('data-clo', newIndex);
                });
            }

            function addClo(index) {
                var cloHtml = `
                    <div class="row clo-row" data-clo="${index}">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Course Learning Outcomes</h4>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Code</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="code_${index}" value="CLO${index}" readonly autofocus placeholder="Enter clo code">
                                                    <span id="code_${index}" class="text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">CLO Weight</label>
                                                <div class="col-lg-9">
                                                    <input type="number" class="form-control" name="weight_${index}" autofocus placeholder="Enter Weight">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Description</label>
                                                <div class="col-lg-9">
                                                    <textarea type="text" name="description_${index}" class="form-control" placeholder="Enter description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Domain</label>
                                                <div class="col-lg-9">
                                                    <select id="domain_${index}" name="domain_${index}" class="select" onchange="changeDomain(${index})">
                                                        <option value="" selected>Select Domain</option>
                                                        <option value="1">Cognative</option>
                                                        <option value="2">Affective</option>
                                                        <option value="3">Psychomotor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Level</label>
                                                <div id="simple_${index}" class="col-lg-9">
                                                    <select name="level1_${index}" class="select">
                                                        <option value="">- Select -</option>
                                                    </select>
                                                </div>
                                                <div style="display:none;" id="cognative_${index}" class="col-lg-9">
                                                    <select id="level" name="level2_${index}" class="select">
                                                        <option value="">- Select -</option>
                                                        <option class="cognative" value="6">Remembering</option>
                                                        <option class="cognative" value="7">Understanding</option>
                                                        <option class="cognative" value="8">Applying</option>
                                                        <option class="cognative" value="9">Analyzing</option>
                                                        <option class="cognative" value="10">Evaluating</option>
                                                        <option class="cognative" value="11">Creating</option>
                                                    </select>
                                                </div>
                                                <div style="display:none;" id="effective_${index}" class="col-lg-9">
                                                    <select name="level3_${index}" class="select">
                                                        <option value="">- Select -</option>
                                                        <option class="effective" value="1">Receiving</option>
                                                        <option class="effective" value="2">Responding</option>
                                                        <option class="effective" value="3">Valuing</option>
                                                        <option class="effective" value="4">Organization</option>
                                                        <option class="effective" value="5">Internalizing</option>
                                                    </select>
                                                </div>
                                                <div style="display:none;" id="psychomotor_${index}" class="col-lg-9">
                                                    <select name="level4_${index}" class="select">
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
                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger remove-clo" data-clo="${index}">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#cloContainer').append(cloHtml);
                $('#cloContainer select').select2();
                var element = $(".select2");
                element.css("width", "100%");
            }
            function changeDomain(index) {
                const domain = $(`#domain_${index}`).val();
                $(`#simple_${index}`).css('display', 'none');
                $(`#cognative_${index}`).css('display', 'none');
                $(`#effective_${index}`).css('display', 'none');
                $(`#psychomotor_${index}`).css('display', 'none');

                if (domain === '1') {
                    $(`#cognative_${index}`).removeAttr("style");
                } else if (domain === '2') {
                    $(`#effective_${index}`).removeAttr("style");
                } else if (domain === '3') {
                    $(`#psychomotor_${index}`).removeAttr("style");
                } else {
                    $(`#simple_${index}`).removeAttr("style");
                }
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

            $(document).ready(function() {
                var cloCount = 1;

                $('#addCloButton').click(function() {
                    addClo(cloCount);
                    cloCount++;
                });

                $(document).on('click', '.remove-clo', function() {
                    $(this).closest('.clo-row').remove();
                    updateCloIndices();
                    cloCount = $('#cloContainer .clo-row').length + 1; // Adjust cloCount to the number of CLOs
                });

                
            });
        </script>

                <!-- <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Emphasis Level</label>
                        <div class="col-lg-9">
                            <select name="emphasis_level_${cloCount}" class="select">
                                <option value="">- Select -</option>
                                <option value="1">3. Low</option>
                                <option value="2">2. Medium</option>
                                <option value="3">1. High</option>
                            </select>
                            
                        </div>
                    </div> 
                -->

        @endsection
