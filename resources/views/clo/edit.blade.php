<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit | Course Learning Outcomes</title>
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
									<li class="breadcrumb-item active">Edit Course Learning Outcomes</li>
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
									<form method="POST" action="{{ route('updatecourselearningoutcome') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
										<div class="row">
											<div class="col-xl-6">
                                            <?php $course = $course_object::select('id','program_id','name','code')->whereid($id)->first(); ?>
                                            <?php $program = $program_object::select('id','name')->whereid($course->program_id)->first(); ?>
                                            <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Program</label>
                                                    <div class="col-lg-9">
                                                        <input type="hidden" class="form-control"  value="{{$program->id}}" autofocus>
                                                        <input type="text" class="form-control"  readonly value="{{$program->name}}" autofocus>

                                                    </div>
                                                </div>
                                            <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Course</label>
                                                    <div class="col-lg-9">
                                                    <input type="hidden" class="form-control" name="course_id" value="{{$course->id}}" autofocus>
                                                    <input type="text" class="form-control" name="coursename" readonly value="{{$course->name}}" autofocus>

                                                    </div>
                                                </div>
											</div>
										</div>
                                        <div id="cloContainer">
                                            <?php $clocount = 0; $clos_ids = $clo_object::wherecourse_id($id)->pluck('id'); $clos = $clo_object::wherecourse_id($id)->get(); ?>
                                            <?php foreach($clos as $clo): ?>
                                                <?php $clocount++; ?>
                                                <input type="hidden" name="clos_ids[]" value="{{ $clos_ids }}">
                                                <input type="hidden" name="clo_id_{{$clocount}}" value="{{$clo->id}}">
                                                <div class="row clo-item" data-clo="{{$clocount}}">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Code</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" readonly class="form-control" name="code_{{$clocount}}" value="{{$clo->code}}" autofocus placeholder="Enter clo code">
                                                                                <span class="text-danger">{{$errors->first('code')}}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">CLO Weight</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" class="form-control" name="weight_{{$clocount}}" value="{{$clo->weight}}" autofocus placeholder="Enter Clo weight">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Description</label>
                                                                            <div class="col-lg-9">
                                                                                <textarea type="text" name="description_{{$clocount}}" class="form-control" placeholder="Enter description">{{$clo->description}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Domain</label>
                                                                            <div class="col-lg-9">
                                                                                <select id="domain_{{$clocount}}" name="domain_{{$clocount}}" class="select" onchange="changeDomain({{$clocount}})">
                                                                                    <option value="" {{ $clo->domain == '' ? 'selected' : '' }}>Select Domain</option>
                                                                                    <option value="1" {{ $clo->domain == '1' ? 'selected' : '' }}>Cognitive</option>
                                                                                    <option value="2" {{ $clo->domain == '2' ? 'selected' : '' }}>Affective</option>
                                                                                    <option value="3" {{ $clo->domain == '3' ? 'selected' : '' }}>Psychomotor</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <?php
                                                                                $level = 0;
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
                                                                            <div id="simple_{{$clocount}}" class="col-lg-9">
                                                                                <select name="level1_{{$clocount}}" class="select">
                                                                                    <option value="{{$clo->level}}" selected>{{$level ?? ''}}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div style="display:none;" id="cognative_{{$clocount}}" class="col-lg-9">
                                                                                <select name="level2_{{$clocount}}" class="select">
                                                                                    <option value="">- Select -</option>
                                                                                    <option class="cognative" value="6">Remembering</option>
                                                                                    <option class="cognative" value="7">Understanding</option>
                                                                                    <option class="cognative" value="8">Applying</option>
                                                                                    <option class="cognative" value="9">Analyzing</option>
                                                                                    <option class="cognative" value="10">Evaluating</option>
                                                                                    <option class="cognative" value="11">Creating</option>
                                                                                </select>
                                                                            </div>
                                                                            <div style="display:none;" id="effective_{{$clocount}}" class="col-lg-9">
                                                                                <select name="level3_{{$clocount}}" class="select">
                                                                                    <option value="">- Select -</option>
                                                                                    <option class="effective" value="1">Receiving</option>
                                                                                    <option class="effective" value="2">Responding</option>
                                                                                    <option class="effective" value="3">Valuing</option>
                                                                                    <option class="effective" value="4">Organization</option>
                                                                                    <option class="effective" value="5">Internalizing</option>
                                                                                </select>
                                                                            </div>
                                                                            <div style="display:none;" id="psychomotor_{{$clocount}}" class="col-lg-9">
                                                                                <select name="level4_{{$clocount}}" class="select">
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
                                                                    <button type="button" class="btn btn-danger remove-clo" data-clo="{{$clocount}}">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
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
                    var cloCount = {{$clocount}};

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

                    function updateCloIndices() {
                        $('#cloContainer .clo-item').each(function(index) {
                            var newIndex = index + 1;
                            $(this).data('clo', newIndex);
                            $(this).find('input[name^="code_"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`CLO${newIndex}`);
                            $(this).find('input[name^="weight_"]').attr('name', `weight_${newIndex}`);
                            $(this).find('textarea[name^="description_"]').attr('name', `description_${newIndex}`);
                            $(this).find('select[name^="domain_"]').attr('name', `domain_${newIndex}`).attr('id', `domain_${newIndex}`).attr('onchange', `changeDomain(${newIndex})`);
                            $(this).find('select[name^="level1_"]').attr('name', `level1_${newIndex}`);
                            $(this).find('select[name^="level2_"]').attr('name', `level2_${newIndex}`);
                            $(this).find('select[name^="level3_"]').attr('name', `level3_${newIndex}`);
                            $(this).find('select[name^="level4_"]').attr('name', `level4_${newIndex}`);
                            $(this).find('.remove-clo').attr('data-clo', newIndex);
                        });
                    }

                    $('#addCloButton').click(function() {
                        cloCount++;
                        var cloHtml = `
                            <div class="row clo-item" data-clo="${cloCount}">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Code</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" class="form-control" readonly name="code_${cloCount}" value="CLO${cloCount}" autofocus placeholder="Enter clo code">
                                                            <span id="code_${cloCount}" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">CLO Weight</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" class="form-control" name="weight_${cloCount}" autofocus placeholder="Enter Clo weight">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Description</label>
                                                        <div class="col-lg-9">
                                                            <textarea type="text" name="description_${cloCount}" class="form-control" placeholder="Enter description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Domain</label>
                                                        <div class="col-lg-9">
                                                            <select id="domain_${cloCount}" name="domain_${cloCount}" class="select" onchange="changeDomain(${cloCount})">
                                                                <option value="">Select Domain</option>
                                                                <option value="1">Cognitive</option>
                                                                <option value="2">Affective</option>
                                                                <option value="3">Psychomotor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Level</label>
                                                        <div id="simple_${cloCount}" class="col-lg-9">
                                                            <select name="level1_${cloCount}" class="select">
                                                                <option value="" selected>None</option>
                                                            </select>
                                                        </div>
                                                        <div style="display:none;" id="cognative_${cloCount}" class="col-lg-9">
                                                            <select name="level2_${cloCount}" class="select">
                                                                <option value="">- Select -</option>
                                                                <option class="cognative" value="6">Remembering</option>
                                                                <option class="cognative" value="7">Understanding</option>
                                                                <option class="cognative" value="8">Applying</option>
                                                                <option class="cognative" value="9">Analyzing</option>
                                                                <option class="cognative" value="10">Evaluating</option>
                                                                <option class="cognative" value="11">Creating</option>
                                                            </select>
                                                        </div>
                                                        <div style="display:none;" id="effective_${cloCount}" class="col-lg-9">
                                                            <select name="level3_${cloCount}" class="select">
                                                                <option value="">- Select -</option>
                                                                <option class="effective" value="1">Receiving</option>
                                                                <option class="effective" value="2">Responding</option>
                                                                <option class="effective" value="3">Valuing</option>
                                                                <option class="effective" value="4">Organization</option>
                                                                <option class="effective" value="5">Internalizing</option>
                                                            </select>
                                                        </div>
                                                        <div style="display:none;" id="psychomotor_${cloCount}" class="col-lg-9">
                                                            <select name="level4_${cloCount}" class="select">
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
                                                <button type="button" class="btn btn-danger remove-clo" data-clo="${cloCount}">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        $('#cloContainer').append(cloHtml);
                        $('#cloContainer select').select2();
                        var element = $(".select2");
                        element.css("width", "100%");
                    });

                    $(document).on('click', '.remove-clo', function() {
                        var cloIndex = $(this).data('clo');
                        $(this).closest('.clo-item').remove();
                        cloCount--;
                        updateCloIndices();
                    });
                </script>


        @endsection
