<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Edit | Program Learning Outcomes</title>      
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
									<li class="breadcrumb-item active">Edit  Program Learning Outcomes</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								
								<div class="card-body">
									<form method="POST" action="{{ route('updateprogramlearningoutcome') }}" class="mb-5" id="validationForm" name="validationForm">
										@csrf
                                        <div class="row">
											<!-- <div class="col-xl-6"> -->
                                            <?php $program = $program_object::select('id','name','institute_id')->whereid($id)->first(); ?>
                                            <?php //$institute = $institute_object::select('id','name')->whereid($program->institute_id)->first(); ?>
                                                <!-- <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Institute</label>
                                                    <div class="col-lg-9">
                                                    <input type="hidden" class="form-control" name="institute_id" value="{{$institute->id}}" autofocus>
                                                    <input type="text" class="form-control" name="institute_name" readonly value="{{$institute->name}}" autofocus>
                                                        
                                                    </div>
                                                </div> -->
											<!-- </div> -->
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
                                        <?php $plocount = 0; $plos_ids = $plo_object::whereprogram_id($id)->pluck('id'); $plos = $plo_object::whereprogram_id($id)->get(); ?>
                                            <?php foreach($plos as $plo): ?>
                                                <?php $plocount++; ?>
                                                <input type="hidden" name="plos_ids" value="{{ $plos_ids }}">
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
                                                                                <input type="text" readonly class="form-control" name="code_{{$plocount}}" value="{{$plo->code}}" autofocus placeholder="Enter Clo code">
                                                                                <span class="text-danger">{{$errors->first('code')}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Name</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="text" class="form-control" name="name_{{$plocount}}" value="{{$plo->name}}" autofocus placeholder="Enter PLO Name">
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
                                                                <div class="text-right">
                                                                    <button type="button" class="btn btn-danger remove-plo" data-plo="{{$plocount}}">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
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
        $(document).ready(function() {
    var ploCount = {{$plocount}};

    function updatePloIndices() {
        $('#ploContainer .plo-item').each(function(index) {
            var newIndex = index + 1;
            $(this).attr('data-plo', newIndex);
            $(this).find('input[name^="code_"]').attr('name', `code_${newIndex}`).attr('id', `code_${newIndex}`).val(`PLO${newIndex}`);
            $(this).find('input[name^="weight_"]').attr('name', `weight_${newIndex}`);
            $(this).find('textarea[name^="description_"]').attr('name', `description_${newIndex}`);
            $(this).find('.remove-plo').attr('data-plo', newIndex);
        });
    }

    $('#addPloButton').click(function() {
        ploCount++;
        var ploHtml = `
            <div class="row plo-item" data-plo="${ploCount}">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Code</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" readonly name="code_${ploCount}" value="PLO${ploCount}" autofocus placeholder="Enter plo code">
                                            <span id="code_${ploCount}" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Name</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="weight_${ploCount}" autofocus placeholder="Enter PLO weight">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Description</label>
                                        <div class="col-lg-12">
                                            <textarea type="text" name="description_${ploCount}" class="form-control" placeholder="Enter description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-danger remove-plo" data-plo="${ploCount}">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        $('#ploContainer').append(ploHtml);
    });

    $(document).on('click', '.remove-plo', function() {
        var ploIndex = $(this).data('plo');
        $(this).closest('.plo-item').remove();
        ploCount--;
        updatePloIndices();
    });
});
</script>
        @endsection
