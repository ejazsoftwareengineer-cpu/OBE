<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Add Program Educational Objectives</title>      
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
									<li class="breadcrumb-item active">Add Program Educational Objectives</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
                    
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Program Educational Objectives</h4>
									<form method="POST" action="{{ route('storeprogrameducationobjective') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf

                                        <div class="row">
                                            
											<div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Program <span class="text-danger">*</span></label>
                                                    <div class="col-lg-9">
                                                        <select id="program_id"  name="program_id" class="select" >
                                                            @foreach ($programs as $program)
																<option value="{{ $program->id }}" >{{ $program->name }}</option>
															@endforeach
                                                        </select>
														<span class="text-danger">{{$errors->first('program_id')}}</span>
                                                    </div>
                                                </div>
                                                
											</div>
										</div>
                                        <div id="peoContainer">
                                            
                                        </div>
                                        <div class="text-right" style="padding-bottom: 20px;">
                                            <button id="addPeoButton" type="button" class="btn btn-primary">Add PEO</button>
                                        </div>
										
										<div class="text-left">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" onclick="window.location='{{ route("manageprogrameducationobjective") }}'" class="btn btn-danger">Cancel</button>
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
            function updatePeoIndices() {
                $('#peoContainer .peo-row').each(function(index) {
                    var newIndex = index + 1;
                    $(this).attr('data-peo', newIndex);
                    $(this).find('input[id^="code"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`PEO${newIndex}`);
                    $(this).find('input[id^="name"]').attr('name', `name_${newIndex}`).attr('id', `name_${newIndex}`);
                    $(this).find('textarea[name^="description"]').attr('name', `description_${newIndex}`);
                    $(this).find('.remove-peo').attr('data-peo', newIndex);
                });
            }

            function addPeo(index) {
                var peoHtml = `
                    <div class="row peo-row" data-peo="${index}">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PEO Code<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input id="code_${index}" type="text" readonly class="form-control" value="PEO${index}" placeholder="Enter PEO Code" name="code_${index}" autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PEO Name<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input id="name_${index}" type="text" class="form-control" name="name_${index}" autofocus placeholder="Enter name">
                                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">PEO Description<span class="text-danger">*</span></label>
                                                <div class="col-lg-12">
                                                    <textarea type="text" name="description_${index}" class="form-control" placeholder="Enter description"></textarea>
                                                    <span class="text-danger">{{$errors->first('description')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger remove-peo" data-peo="${index}">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#peoContainer').append(peoHtml);
            }

            $(document).ready(function() {
                var peoCount = 1;

                $('#addPeoButton').click(function() {
                    addPeo(peoCount);
                    peoCount++;
                });

                $(document).on('click', '.remove-peo', function() {
                    $(this).closest('.peo-row').remove();
                    updatePeoIndices();
                    peoCount = $('#peoContainer .peo-row').length + 1; // Adjust peoCount to the number of PEOs
                });
            });
        </script>

        @endsection
