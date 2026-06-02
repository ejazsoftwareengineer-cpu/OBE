<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title> Question </title>      
        <style>
            tr {
                max-width: 60px !important;
            }
            
            table tbody>tr>:nth-child(2), 
            table tbody>tr>:nth-child(3), 
            table tbody>tr>:nth-child(4), 
            table tbody>tr>:nth-child(5), 
            table tbody>tr>:nth-child(6) {
                text-align : right; !important
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
                            <h3 class="page-title">Question </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Question </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <?php if (!$clos || count($clos) === 0) { ?>
                    <div class="alert alert-danger alert-dismissible" style="background-color: #f8d7da; border-color:#f5c6cb; color:#721c24; margin-bottom: 0px;">
                        <strong>Alert!</strong> This Course Clos not exist.
                    </div>
                <?php } ?>
                <div class="tab-content">
                    <div id="clo_view" class="pro-overview tab-pane fade show active">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('storecourseofferingcqiactivitiesquestion') }}" class="mb-5" id="validationForm" name="validationForm">
                                            @csrf

                                            <input type="hidden" name="courseoffer_id" value="{{ $course_section->id ?? '' }}">
                                            <input type="hidden" name="activity_id" value="{{ $id ?? '' }}">
                                            <input type="hidden" name="activity_question_count" value="Q{{ $activity_question_count+1 }}">

                                            <div id="questionContainer">
                                                <div style="padding: 15px 15px 15px 15px;" class="card">
                                                    <h4 class="card-title">Question No.# 1</h4>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">CLO <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                        <select id="clo_id" name="clo_id" class="select"  onchange="getObeWeightlimit('{{route('calculateobeweightagainstclo')}}','{{ $course_section->id ?? ''}}')">
                                                                        @foreach ($clos as $clo)
                                                                            <option value="{{ $clo->id }}" >{{ $clo->code .' - '. $clo->description}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger">{{$errors->first('clo_id')}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Name <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="name"  autofocus>
                                                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Correct Answer (Answer Guide)</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="answer" autofocus>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Complexity</label>
                                                                <div class="col-lg-9">
                                                                    <select name="complexity" class="select">
                                                                        <option value="">- Select -</option>
                                                                        <option value="1">Depth of knowledge required</option>
                                                                        <option value="2">Range of conflicting requirements</option>
                                                                        <option value="3">Depth of analysis required</option>
                                                                        <option value="4">Familiarity of issues</option>
                                                                        <option value="5">Extent of applicable codes</option>
                                                                        <option value="6">Extent of stakeholder involvement and level of conflicting requiremen</option>
                                                                        <option value="7">Interdependence</option>
                                                                        <option value="8">Consequences</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Question Type</label>
                                                                <div class="col-lg-9">
                                                                    <select name="question" class="select">
                                                                        <option value="">- Select -</option>
                                                                        <option value="T" selected="">Text Base</option>
                                                                        <option value="R">Single Choice</option>
                                                                        <option value="M">Multi Choice</option>
                                                                        <option value="U">Attachment</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">% OBE Weight <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="obe_weight" autofocus >
                                                                    <span class="text-danger" id="obe_weight_span">{{$errors->first('obe_weight')}}</span>
                                                                </div>
                                                            </div>	
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Max Marks</label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="max_mark" autofocus >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Question (Guidline for Question)</label>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="guidline" class="form-control" placeholder="Enter Guidline"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Choices (Choices Guide) (Set Choices)</label>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="choices" class="form-control" placeholder="Enter Choices Guide"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row" style="padding: 5px 0px 10px 18px;">
                                                                <label class="d-block"> Not for OBE</label>
                                                                <div class="col-lg-9">
                                                                    <input id="not_for_obe" type="checkbox" name="not_for_obe" value="0" class="check">
                                                                    <label for="not_for_obe" class="checktoggle">checkbox</label>
                                                                </div>
                                                            </div>	
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <label class="d-block"> Define Rubrics</label>
                                                            <div class="form-group row" style="padding: 5px 0px 10px 18px;">
                                                                <div class="col-lg-12">
                                                                    <table class="table table-bordered target-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">Define Cirteria </th>
                                                                                <th class="text-center">Poor <br>0-1</th>
                                                                                <th class="text-center">Unsatisfactory <br>1-2</th>
                                                                                <th class="text-center">Satisfactory <br>2-3</th>
                                                                                <th class="text-center">Very Satisfactory <br>3-4</th>
                                                                                <th class="text-center">Outstanding <br>4-5</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_1_row_1"></textarea></td>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_2_row_1"></textarea></td>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_3_row_1"></textarea></td>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_4_row_1"></textarea></td>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_5_row_1"></textarea></td>
                                                                                <td class="text-center"><textarea type="text"  class="form-control" name="question_complexity_scale_6_row_1"></textarea></td>
                                                                                <td class="text-center" style="width: 11%;">
                                                                                    <a class="btn btn-success btn-sm addRowButton" style="color: white;">Add</a>
                                                                                    <a class="btn btn-danger btn-sm removeRowButton"  style="color: white;display: none;">Remove</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" onclick="window.location='{{ route("showcqi", ['id' => $course_section->id]) }}'" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View Activity Questions -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h3>Cqi Activity Question</h3>
                                    <div class="table-responsive">
                                        <table class="datatable table table-stripped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-right">Complexity</th>
                                                    <th class="text-right">Question Type</th>
                                                    <th class="text-right">% OBE Weight</th>
                                                    <th class="text-right">Max Marks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activity_question as $aq)
                                                    <tr>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="#">{{ $aq->name  }} </a>
                                                            </h2>
                                                        </td>
                                                        <?php
                                                            $complexity = '';
                                                            if($aq->complexity === 1){
                                                                $complexity = 'Depth of knowledge required';
                                                            }else if($aq->complexity === 2){
                                                                $complexity = 'Range of conflicting requirements';
                                                            }else if($aq->complexity === 3){
                                                                $complexity = 'Depth of analysis required';
                                                            }else if($aq->complexity === 4){
                                                                $complexity = 'Familiarity of issues';
                                                            }else if($aq->complexity === 5){
                                                                $complexity = 'Extent of applicable codes';
                                                            }else if($aq->complexity === 6){
                                                                $complexity = 'Extent of stakeholder involvement and level of conflicting requiremen';
                                                            }else if($aq->complexity === 7){
                                                                $complexity = 'Interdependence';
                                                            }else if($aq->complexity === 8){
                                                                $complexity = 'Consequences';
                                                            }else{
                                                                $ $complexity = '-';
                                                            }
                                                        ?>
                                                        <td>{{$complexity}}</td>
                                                        <?php
                                                            $question = '';
                                                            if($aq->question === 'T'){
                                                                $question = 'Text Base';
                                                            }else if($aq->question === 'R'){
                                                                $question = 'Single Choice';
                                                            }else if($aq->question === 'M'){
                                                                $question = 'Multi Choice';
                                                            }else if($aq->question === 'U'){
                                                                $question = 'Attachment';
                                                            }else{
                                                                $question = '-';
                                                            }
                                                        ?>
                                                        <td>{{$question}}</td>
                                                        
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="#">{{ $aq->obe_weight  }} </a>
                                                            </h2>
                                                        </td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="#">{{ $aq->max_mark  }} </a>
                                                            </h2>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
        <script type="text/javascript">
            var questionCount = 1;
            
            var rowCount = 1;
            $("table.target-table").on("click", ".addRowButton", function () {
                var targetTable = $(this).closest("table");
                var newRow = $(this).closest("tr").clone();
                newRow.find("textarea").val("");
                newRow.find("textarea").each(function (index) {
                    var currentName = $(this).attr("name");
                    var newName = currentName.replace(/row_\d+/, "row_" + (rowCount + 1));
                    $(this).attr("name", newName);
                });

                newRow.find(".addRowButton").remove();
                newRow.find(".removeRowButton").show();
                targetTable.find("tbody").append(newRow);
                rowCount++;
            });

            // Remove Row
            $("table").on("click", ".removeRowButton" , function () {
                if ($("table tbody tr").length > 1) {
                    $(this).closest("tr").remove();
                }
            });

            $('#not_for_obe').change(function(){
                if($(this).prop("checked") == true){
                    $('#not_for_obe').val(1)
                }else if($(this).prop("checked") == false){
                    $('#not_for_obe').val(0)
                    $('#obe_weight_span').val(0)
                }
            });

            function getObeWeightlimit(siteurl,courseoffer_id){
                const clo_id = $('#clo_id').val();
                $('input[name="obe_weight"]').attr('readonly', 'readonly');
                $('input[name="obe_weight"]').html('');
                getLimitRequest(siteurl, clo_id, courseoffer_id);
            }
            
            function getLimitRequest(siteurl, clo_id, courseoffer_id){
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });     
                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        clo_id: clo_id,
                        courseoffer_id: courseoffer_id,
                    },
                    success: function(response){
                        console.log(response);
                        var max = 0;
                        if(response <= 100 ){
                            max = 100 - response;
                            $('input[name="obe_weight"]').attr('min', '0').attr('max', max);
                            $('input[name="obe_weight"]').removeAttr('readonly');
                            $('#obe_weight_span').html('Limit Minimum 0 : Maximum  '+max)
                        }
                        
                        if(max === 0){
                            $('input[name="obe_weight"]').attr('readonly', 'readonly');
                            $('#obe_weight_span').html('According to Selected CLO, OBE Weight 100% Complete')
                        }
                    }
                });
            }
				
		</script>
        @endsection
