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
                                        <form method="POST" action="{{ route('storecourseofferingactivitiesquestion') }}" class="mb-5" id="validationForm" name="validationForm">
                                            @csrf
                                            <div class="d-flex justify-content-between">
                                                <h3>{{$course_section[0]->name .' - '. $class_activity[0]->assesment->short_name . '-' . $class_activity[0]->assesment_name}}</h3>
                                                <a class="btn btn-primary btn-sm py-2 px-2" style="color: white;" onclick="openClassActivityModal('{{route('getactivityandquestions')}}',{{$id}})"><i class="fa fa-eye"></i>Show Added Question</a>
                                            </div>

                                            <input type="hidden" name="courseoffer_id" value="{{ $course_section[0]->id }}">
                                            <input type="hidden" name="activity_id" value="{{ $id }}">
                                            <input type="hidden" name="activity_question_count" value="Q{{ $activity_question_count+1 }}">

                                            <div id="questionContainer">
                                                <div style="padding: 15px 15px 15px 15px;" class="card">
                                                    <h4 class="card-title">Add Activity Question</h4>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">CLO <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <select id="clo_id" name="clo_id" class="select"  onchange="getObeWeightlimit('{{route('calculateobeweightagainstclo')}}','{{$course_section[0]->id}}')">
                                                                        <!-- <select id="clo_id" name="clo_id" class="select"> -->
                                                                        <option value="" >- Select CLO -</option>
                                                                        @foreach ($clos as $clo)
                                                                            <option id="weight_{{$clo->id}}" value="{{ $clo->id }}" clo-weight="{{$clo->weight}}" >{{ $clo->code .' - '. $clo->description}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger">{{$errors->first('clo_id')}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Question <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="name"  autofocus>
                                                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Correct Answer (Answer Guide)</label>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" class="form-control" name="answer" autofocus></textarea>
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
                                                                <label class="col-lg-3 col-form-label">% CLO Weight </label>
                                                                <div class="col-lg-9">
                                                                <input type="number" class="form-control" name="obe_weight" step="0.01">

                                                                    <!-- <span class="text-danger" >{{$errors->first('obe_weight')}}</span> -->
                                                                    <span class="text-danger" id="obe_weight_span">{{$errors->first('obe_weight')}}</span>
                                                                </div>
                                                            </div>	
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label"> <span class="text-danger">*</span> Max Marks</label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="max_mark"  step="0.01">
                                                                    <span class="text-danger" >{{$errors->first('max_mark')}}</span>
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
                                                <button type="button" onclick="window.location='{{ route("showcourseofferingactivities", ['id' => $course_section[0]->id]) }}'" class="btn btn-danger">Cancel</button>
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
                                    <h3>Activities Question</h3>
                                    <div class="table-responsive">
                                        <table class="datatable table table-stripped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Question Name</th>
                                                    <th>Name</th>
                                                    <th>CLO</th>
                                                    <th class="text-right">Complexity</th>
                                                    <th class="text-right">Question Type</th>
                                                    <th class="text-right">% CLO Weight</th>
                                                    <th class="text-right">Max Marks</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activity_question as $aq)
                                                    <tr>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="#">{{ $aq->question_name  }} </a>
                                                            </h2>
                                                        </td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="#">{{ $aq->name  }} </a>
                                                            </h2>
                                                        </td>
                                                        <td>
                                                            <h5 class="table-avatar">
                                                                <span style="color:white;" class="badge badge-danger">{{ $aq->clo->code ?? ' --- ' }}</span>
                                                            </h5>
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
                                                        <td class="text-right">
                                                            <a class="btn btn-primary btn-sm" style="color: white;" onclick="openEditActivityQuestionModal('{{route('geteditactivityquestionview')}}',{{$aq->id}})">Edit</a>
                                                            <a class="btn btn-primary btn-sm" style="color: white;"  onclick="openDeleteModel('{{$aq->id}}')">Delete</a>
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
            <div id="view_class_activity_and_question" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Class Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-content">
                            <!-- Modal COntent Append from jquery -->
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit_activity_question" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Activity Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit_activity_question_modal_content">
                            
                        </div>
                    </div>
                </div>
            </div>
                <!-- Delete Leave Modal  -->
                <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Delete Question</h3>
                                    <p>Are you sure want to delete question?</p>
                                </div>
                                <input type="hidden" name="id" value="" id="delete_id">
                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="javascript:void(0);" onclick="deleteData('{{ route('destroyquestion') }}')" class="btn btn-primary continue-btn">Delete</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             <!-- /Delete Leave Modal -->
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
             
            function openClassActivityModal(siteurl , id) {
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: "POST",
                    url: siteurl , 
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        // console.log(data.activity.assesment_name)
                        $('#modal-content').html(response.html);
                        $('#view_class_activity_and_question').modal('show');

                        $('#modal-content select[name="assesment_id"]').select2();
                        $('#modal-content select[name="clo_id"]').select2();
                        $('#modal-content select[name="complexity"]').select2();
                        $('#modal-content select[name="question"]').select2();
                        var element = $(".select2");
                        element.css("width", "450px");
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            
            function getObeWeightlimit(siteurl,courseoffer_id){
                const clo_id = $('#clo_id').val();
                const cloWeight = $('#weight_'+clo_id).attr('clo-weight');
                // alert(cloWeight)
                // $('input[name="obe_weight"]').attr('readonly', 'readonly');
                $('input[name="obe_weight"]').html('');
                $('#obe_weight_span').html('');
                getLimitRequest(siteurl, clo_id, courseoffer_id,cloWeight);
            }
            
            function getLimitRequest(siteurl, clo_id, courseoffer_id,cloWeight){
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
                        // console.log('hh');
                        var max = 0;
                        var weight = cloWeight ? cloWeight : 100;
                        // if(response <= cloWeight){
                            max = weight - response;
                            $('input[name="obe_weight"]').attr('min', '0').attr('max', max);
                            // $('input[name="obe_weight"]').removeAttr('readonly');
                            $('#obe_weight_span').html('Limit Minimum 0 : Maximum  '+max)
                        // }
                        
                        // console.log(cloWeight);
                        if(response === weight){
                            $('input[name="obe_weight"]').attr('readonly', 'readonly');
                            // $('#obe_weight_span').html('CLO Total Weight is' + weight )
                            $('#obe_weight_span').html('According to the selected CLO, the weight is completely used (Selected CLO Weight : ' + weight + ')');
                        }
                    }
                });
            }

            function openEditActivityQuestionModal(siteurl , id) {
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: "POST",
                    url: siteurl , 
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // console.log(data.activity.assesment_name)
                        $('#edit_activity_question_modal_content').html(response.html);
                        $('#edit_activity_question').modal('show');
                        $('#edit_activity_question_modal_content select[name="clo_id"]').select2();
                        $('#edit_activity_question_modal_content select[name="complexity"]').select2();
                        $('#edit_activity_question_modal_content select[name="question"]').select2();
                        var element = $(".select2");
                        element.css("width", "450px");
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } 

            function updateClassActivityQuestion(siteurl){
                jQuery.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });     
                
                const   id = $('#activity_question_id').val(),
                        activity_id = $('#activity_id').val(),
                        courseoffer_id = $('#courseoffer_id').val(),
                        name = $('#name').val(),
                        answer = $('#answer').val(),
                        clo_id    = $('#model_clo_id').val(),
                        complexity    = $('#complexity').val(),
                        question    = $('#question').val(),
                        max_mark    = $('#max_mark').val(),
                        obe_weight    = $('#obe_weight').val(),
                        guidline    = $('#guidline').val(),
                        choices    = $('#choices').val();
// alert(clo_id);
                $('#updateclassactivityquestion').prop('disabled',true);
                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        id: id,
                        activity_id : activity_id,
                        courseoffer_id : courseoffer_id,
                        name : name,
                        answer : answer,
                        clo_id : clo_id,
                        complexity : complexity,
                        question : question,
                        max_mark : max_mark,
                        obe_weight : obe_weight,
                        guidline : guidline,
                        choices : choices,
                    },
                    success: function(response){
                        $('#edit_activity_question_modal_content').modal("hide");
                        location.reload();
                    }
                });
            } 

				
		</script>
        @endsection
