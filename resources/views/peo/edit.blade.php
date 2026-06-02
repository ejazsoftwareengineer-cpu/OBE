<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit Program Educational Objective</title>      
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
									<li class="breadcrumb-item active">Edit Program Educational Objective</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<h4 class="card-title">Program Educational Objective</h4>
									<form method="POST" action="{{ route('updateprogrameducationobjective') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <div class="row">
											<div class="col-xl-6">
                                            <?php $program = $program_object::select('id','name')->whereid($id)->first(); ?>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Program</label>
                                                    <div class="col-lg-9">
                                                    <input type="hidden" class="form-control" name="program_id" value="{{$program->id}}" autofocus>
                                                    <input type="text" class="form-control" name="program_name" readonly value="{{$program->name}}" autofocus>
                                                        
                                                    </div>
                                                </div>
											</div>
										</div>

                                        <div id="peoContainer">
                                            <?php $peocount = 0; $peos = $peo_object::whereprogram_id($id)->get(); ?>
                                            <?php foreach($peos as $peo): ?>
                                                <?php $peocount++; ?>
                                                <input type="hidden" name="peo_id_{{$peocount}}" value="{{$peo->id}}">
                                                <div class="row peo-item" data-peo="{{$peocount}}">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Code</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" readonly class="form-control" name="code_{{$peocount}}" value="{{$peo->code}}" autofocus placeholder="Enter PEO code">
                                                                                <span class="text-danger">{{$errors->first('code')}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Name</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" class="form-control" name="name_{{$peocount}}" value="{{$peo->name}}" autofocus placeholder="Enter PEO Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Description</label>
                                                                            <div class="col-lg-12">
                                                                                <textarea type="text" name="description_{{$peocount}}" class="form-control" placeholder="Enter description">{{$peo->description}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="button" class="btn btn-danger remove-peo" data-peo="{{$peocount}}">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
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
            $(document).ready(function() {
                var peoCount = {{$peocount}};

                function updatePeoIndices() {
                    $('#peoContainer .peo-item').each(function(index) {
                        var newIndex = index + 1;
                        $(this).attr('data-peo', newIndex);
                        $(this).find('input[name^="code_"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`PEO${newIndex}`);
                        $(this).find('input[name^="name_"]').attr('name', `name_${newIndex}`);
                        $(this).find('textarea[name^="description_"]').attr('name', `description_${newIndex}`);
                        $(this).find('.remove-peo').attr('data-peo', newIndex);
                    });
                }

                $('#addPeoButton').click(function() {
                    peoCount++;
                    var peoHtml = `
                        <div class="row peo-item" data-peo="${peoCount}">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Code</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" readonly name="code_${peoCount}" value="PEO${peoCount}" autofocus placeholder="Enter PEO code">
                                                        <span id="code_${peoCount}" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Name</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="name_${peoCount}" autofocus placeholder="Enter PEO Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Description</label>
                                                    <div class="col-lg-12">
                                                        <textarea type="text" name="description_${peoCount}" class="form-control" placeholder="Enter description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-danger remove-peo" data-peo="${peoCount}">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#peoContainer').append(peoHtml);
                });

                $(document).on('click', '.remove-peo', function() {
                    var peoIndex = $(this).data('peo');
                    $(this).closest('.peo-item').remove();
                    updatePeoIndices();
                    peoCount = $('#peoContainer .peo-item').length; // Adjust peoCount to the number of PEOs
                });
            });
        </script>
        @endsection
