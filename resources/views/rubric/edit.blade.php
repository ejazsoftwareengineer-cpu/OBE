<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Rubric </title>      
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
									<li class="breadcrumb-item active">Update Rubric </li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<form method="POST" action="{{ route('updaterubric') }}" class="mb-5" enctype="multipart/form-data"	>
						@csrf
						<input type="hidden" name="id" value="{{ $rubric->id }}">
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Update Rubric</h4>
												<div class="row">
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Institute <span class="text-danger">*</span></label>
															<div class="col-lg-9">
																<select name="institute_id" class="select" >
																	<option value=""> Select Institute</option>
																	@foreach ($institute as $ins)
																		<option value="{{ $ins->id }}" @if($rubric->institute_id === $ins->id) ? selected : '' @endif >{{ $fac->name }}</option>
																	@endforeach
																</select>
																<span id="institute_id" class="text-danger"></span>
															</div>
														</div>
													</div>	
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Rubric Name<span class="text-danger">*</span></label>
															<div class="col-lg-9">
																<input type="text" class="form-control" name="name" value="{{ $rubric->name }}" autofocus placeholder="Enter Name">
																<span id="name" class="text-danger"></span>
															</div>
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Rubric Score Set<span class="text-danger">*</span></label>
															<div class="col-lg-9">
																<select name="rubric_score_set_id" class="select">
																	<option value="">Select Rubric Score Set</option>
																	@foreach ($rubric_ss as $rss)
																		<option value="{{ $rss->id }}" @if($rubric->rubric_score_set_id === $rss->id) ? selected : '' @endif  >{{ $rss->name }}</option>
																	@endforeach
																</select>
																<span id="rubric_score_set_id" class="text-danger"></span>
															</div>
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Rubric Comment</label>
															<div class="col-lg-9">
																<textarea type="text" name="comment" class="form-control" placeholder="Enter Comment">{{ $rubric->comment }}</textarea>
															</div>
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Status</label>
															<div class="col-lg-9">
																<select name="status" class="select">
																	 
																	<option value="1" @if($rubric->status == '1') selected @endif>Active</option>
                                                        			<option value="0" @if($rubric->status == '0') selected @endif>Inactive</option>
																</select>
															</div>
														</div>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>

							<div id="questionContainer">
								<div class="text-right" style="padding-bottom: 20px;">
									<button id="addQuestionButton" type="button" class="btn btn-primary">Add Question</button>
								</div>
								<?php $i = 0; ?>
								@foreach ($rubric_question as $question)
								<?php $i++;?>
								
								<input type="hidden" name="question_id_{{$i}}" value="{{ $question->id }}">
								<div class="row">
									<div class="col-md-12">
										<div class="card">
											<div class="card-body">
												<h4 class="card-title">Question No.# {{ $i }}</h4>
												<div class="row">
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">Question Name</label>
															<div class="col-lg-9">
																<input type="text" class="form-control" name="question_name_{{$i}}">
																<span id="question_name_{{$i}}" value="{{ $question->question}}" class="text-danger"></span>
															</div>
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group row">
															<label class="col-lg-3 col-form-label">% Weight</label>
															<div class="col-lg-9">
																<input type="number" class="form-control" value="{{ $question->weight }}" name="question_weight_{{$i}}">
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xl-12">
														<div class="form-group row">
															<label class="col-lg-1 col-form-label">Description</label>
															<div class="col-lg-11" style="padding-left: 80px;">
																<textarea type="text" name="description_{{$i}}" class="form-control" placeholder="Enter Description">{{ $question->description }}</textarea>
															</div>
														</div>
													</div>
												</div>
												<div class="text-right">
													<button type="button" class="btn btn-danger remove-question" data-question="{{$i}}">Remove</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								@endforeach
								
							</div>
							<div class="text-left">
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="button" onclick="window.location='{{ route("managerubric") }}'" class="btn btn-danger">Cancel</button>
							</div>
					</form>
				</div>			
			</div>
        @endsection

        @section('script')
			<script>
			$(document).ready(function() {
				var questionCount = {{$i}};

				$('#addQuestionButton').click(function() {
					questionCount++;
					var questionHtml = `
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Question No.# ${questionCount}</h4>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Question Name</label>
													<div class="col-lg-9">
														<input type="text" class="form-control" name="question_name_${questionCount}">
														<span id="question_name_${questionCount}" class="text-danger"></span>
													</div>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">% Weight</label>
													<div class="col-lg-9">
														<input type="number" class="form-control" name="question_weight_${questionCount}">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xl-12">
												<div class="form-group row">
													<label class="col-lg-1 col-form-label">Description</label>
													<div class="col-lg-11" style="padding-left: 80px;">
														<textarea type="text" name="description_${questionCount}" class="form-control" placeholder="Enter Description"></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="text-right">
											<button type="button" class="btn btn-danger remove-question" data-question="${questionCount}">Remove</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					`;
					$('#questionContainer').append(questionHtml);
				});

				$(document).on('click', '.remove-question', function() {
					var questionId = $(this).data('question');
					$(this).closest('.card').parent().remove();
				});
				$('form').submit(function(event) {
						event.preventDefault();
						var valid = true;
						if (!$('select[name="institute_id"]').val()) {
							valid = false;
							$('#institute_id').text('Please select a Institute.');
						}
						if (!$('select[name="institute_id"]').val()) {
							valid = false;
							$('#rubric_score_set_id').text('Please select a Score Set.');
						}
						// Example: Check if the rubric_name is not empty
						if ($('input[name="name"]').val().trim() === '') {
							valid = false;
							$('#name').text('Please enter a Rubric Name.');
						}
						var formData = new FormData(this);
						for (var i = 1; i <= questionCount; i++) {
							if ($('input[name="question_name_' + i + '"]').val().trim() === '') {
								valid = false;
								$('#question_name_' + i + '').text('Please enter a Question Name.');
							}
							formData.append('question_name_' + i, $('input[name="question_name_' + i + '"]').val());
							formData.append('question_weight_' + i, $('input[name="question_weight_' + i + '"]').val());
							formData.append('description_' + i, $('textarea[name="description_' + i + '"]').val());
						}
						if (valid) {
							$.ajax({
								url: '{{ route('updaterubric') }}',
								type: 'POST',
								data: formData,
								processData: false,
								contentType: false,
								success: function(response) {
									window.location.href = '{{ route('managerubric') }}';
								}
							});
						}else{
							return;
						}
					});

			});
			</script>


        @endsection
