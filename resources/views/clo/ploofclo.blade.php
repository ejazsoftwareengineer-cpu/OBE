<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View | CLO</title>      
        <style>
            tr {

                max-width: 60px !important;
            }
        </style>
        @extends('layouts.backend.app')

        @section('content')
        <!-- Page Wrapper -->
        <div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">CLO</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Course Learning Outcome</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a  href="{{route('showcourselearningoutcome',$clo->id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showplobyclo',$clo->id)}}" class="nav-link active">PLO's</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                    <!-- View CLO -->
                    <div class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>PLO's</h3>
                                            </div>
                                            <div class="col-6 text-right">
                                                <a onclick="openMapPLOAtCLoModal()" style="color:white;margin-bottom: 10px;" class="btn add-btn"><i class="fa fa-plus"></i> Map PLO</a>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Activity Name</th>
                                                        <th class="text-right">Total Marks</th>
                                                        <th class="text-right">GPA Weigth</th>
                                                        <th class="text-right">Date</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View PEO -->
                 
                    
                </div>
            </div>
             <!-- Assign PEO TO PLO -->
             <div id="assign_clo_to_plo" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign PLO </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Program </label>
                                        <select id ="program_id" name="program_id" class="select" onchange="getPlo('{{route('getplobyprogram')}}')">
                                            <option value="" selected > - Select Program  - </option>
                                                @foreach ($programs as $p)
                                                    <option value="{{ $p->id }}" >{{ $p->name  }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">PLO</label>
                                        <select  id="plo_id" name="plo_id" class="select">
                                            <option value="" selected>- Select -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Learning Type</label>
                                        <select id="domain" name="domain" class="select" onchange="changeDomain()">
                                            <option value="" selected>Select Domain</option>
                                            <option value="1" >Cognative</option>
                                            <option value="2">Affective</option>
                                            <option value="3">Psychomotor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Level</label>
                                        <div id= "simple" class="col-lg-12">
                                            <select name="level1" class="select">
                                                <option value="">- Select -</option>
                                            </select>
                                            
                                        </div>
                                        <div style="display:none;" id="cognative" class="col-lg-12">
                                            <select  id="level" name="level2" class="select">
                                                <option value="">- Select -</option>
                                                <option class="cognative" value="1">Receiving</option>
                                                <option class="cognative" value="2">Responding</option>
                                                <option class="cognative" value="3">Valuation</option>
                                                <option class="cognative" value="4">Organization</option>
                                                <option class="cognative" value="5">Intimalization</option>
                                                
                                            </select>
                                        </div>
                                        <div style="display:none;" id="effective" class="col-lg-12">
                                            
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
                                        <div style="display:none;"  id="psychomotor" class="col-lg-12">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Emphasis Level</label>
                                        <select id ="emphasislevel" name="emphasislevel" class="select">
                                            <option value="" selected > - Emphasis Level - </option>
                                            <option value="1"> Low </option>
                                            <option value="2"> Medium </option>
                                            <option value="3"> High  </option>
                                               
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="submit-section">
                                <button id="save_plo_program" class="btn btn-success" onclick="savePloClo('{{route('addplopeo')}}','{{route('showplopeodata')}}')">Save</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
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
