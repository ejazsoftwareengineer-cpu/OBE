<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="robots" content="noindex, nofollow">
        <title> Course Offering </title>      
        <style>
            /* tr {

                max-width: 60px !important;
            } */
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
                            <h3 class="page-title">Offered Course</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Name : {{$course_offering->course->name ?? ' - '}} </li>
                            </ul>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Code : {{$course_offering->course->code ?? ' - '}}</li>
                            </ul>
                            
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Teacher : {{$course_offering->teacher->name ?? 'Not Selected'}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourseoffering',$id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}" class="nav-link ">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link ">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li> 
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link active">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                
                <x-alert></x-alert>
                    <div id="cqi_view" class="pro-overview tab-pane fade show active">
                        <div id="gridItems" data-pjax-container="" data-pjax-push-state="" data-pjax-timeout="1000">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-12">Corrective Action Request Generated</h4>

                                    <div id="w0" class="grid-view">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>CLO</th>
                                                    <th>Date of Issue</th>
                                                    <th>Name (Originator)</th>
                                                    <th>CAR No./REF</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $cc = 1; foreach($cqis as $cqi){ //echo "<pre>"; print_r($cqi->user->name);die();?>

                                                    <tr>
                                                        <td>{{$cc}}</td>
                                                        <?php if($cqi->status == 1){ ?>
                                                            <td>Initiated</td>
                                                        <?php } else{ ?>
                                                            <td>-</td>
                                                        <?php } ?>
                                                        <td>{{$cqi->clo->name ?? '' }}</td>
                                                        <td>{{$cqi->issue_date}}</td>
                                                        <td>{{$cqi->user->name ?? ''}}</td>
                                                        <td>{{$cqi->name ?? ''}}</td>
                                                        <?php if($cqiactivity::wherecqi_id($cqi->id)->exists()){ ?>
                                                            <td>Activity Added</td>
                                                        <?php }else{ ?>
                                                            <td><a style="color: white;" class="btn btn-success" onclick="openClassActivity({{$id}},{{$cqi->id}})">Add Class Activity</a></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php $cc++;}?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h4 class="mt-24">CQI Class Activities</h4>
                                    <div id="w1" class="grid-view">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Activity/Assesment Method</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Total Marks</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $cca = 1; foreach($cqiclassactivty as $activity){ 
                                                //echo "<pre>"; print_r($cqi->user->name);die();?>
                                                <tr>
                                                    <td>{{$activity->assesment->name ?? ''}}</td>
                                                    <td>{{$activity->assesment_name ?? ''}}</td>
                                                    <td>{{$activity->assesment_date ?? ''}}</td>
                                                    <td>{{$activity->assesment_total_mark ?? ''}}</td>
                                                    <td class="text-left">
                                                         <a class="btn btn-primary btn-sm" href="{{route('showcourseofferingcqiactivitiesquestion',$activity->id)}}">Add Question</a>
                                                        <a class="btn btn-primary btn-sm"  style="color: white;" onclick="getQuestion('{{route('getoutcomeviewbycqiactivity')}}','{{$activity->cqi_id}}','{{ $activity->id }}','{{$id}}')">Add/Update Outcome</a>
                                                    </td>
                                                </tr>
                                             <?php } ?>   
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-24">
                                <div class="card-body">
                                    <h4 id="student">Perform CQI</h4>
                                    <div class="sky-form">
                                        <form method="POST" action="{{ route('storecqi') }}" class="mb-5" id="validationForm" name="validationForm">
										    @csrf
                                            <input type="hidden"  name="course_id"  value="{{ $course_section->course_id }}">
                                            <input type="hidden"  name="courseoffer_id"  value="{{ $id }}">
                                            Generate CAR for selected CLOs 
                                            <div class="row mb-12">
                                                <?php $c =1;  foreach($clos as $clo){?>
                                                    <div class="col-md-2" data-toggle="tooltip" title="">
                                                        <label class="checkbox checkbox-primary">
                                                            <input type="checkbox" id="clo_id_{{ $c }}" name="clo_id[]" data="{{ $clo->clo_id }}" value="{{ $clo->clo_id }}" checked="checked">
                                                            <span>CLO{{$c}}</span>
                                                            <span class="checkmark"></span>
                                                        </label>

                                                    </div>

                                                <?php $c++; } ?>
                                            </div>
                                            
											<span class="text-danger">{{ $errors->first('clo_id') }}</span>

                                            <div id="closection">
                                                <p class="note"> Please select at least one Student from the list to proceed.</p>
                                                <br>
                                                <div>
                                                    <table style="width:100%; " class="table table-bordered table-stripped table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:90px; text-align:left;">
                                                                    <!-- <label class="checkbox checkbox-warning">
                                                                        <input type="checkbox" checked="checked" onclick="toggle(this)">
                                                                        <span class="checkmark"></span>
                                                                    </label> -->
                                                                    <span>Select</span>
                                                                </th>
                                                                
                                                                <th style="width:120px; text-align:left;">Registration No.</th>
                                                                <th style="width:200px; text-align:left;">Name</th>
                                                                <?php $t =1;  foreach($clos as $clo){?>
                                                                    <th style="width:30px; text-align:center;">CLO {{$t}}</th>
                                                                <?php $t++; } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($enrolledstudent as $student){?>
                                                            <tr>
                                                                <td style="vertical-align: top;width:120px; text-align:left;">
                                                                    <label class="checkbox checkbox-primary">
                                                                        <input type="checkbox" id="student_id_{{$student->student->id}}" 
                                                                            name="student_id[]" 
                                                                            value="{{$student->student->id}}" data="{{$student->student->id}}" checked="checked"><span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                                <td style="vertical-align: top;width:210px; text-align:left;"><a>{{$student->student->registration_no}}</a></td>
                                                                <td style="vertical-align: top;width:150px; text-align:left;">{{$student->student->name}}</td>
                                                                <?php foreach($clos as $clo){ ?>
                                                                    <?php $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')->where('courseoffer_id', $id)
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->get();
                                                                        $totalAverageOutcome = 0;
                                                                        $weight = 0;
                                                                        ?>

                                                                        <?php foreach($questions as $q){?>
                                                                            <?php $outcomes = $studentassessment::select('id','outcome')
                                                                                ->where('clo_id', $clo->clo_id)
                                                                                ->where('student_id', $student->student->id)
                                                                                ->where('question_id', $q->id)
                                                                                ->where('activity_id', $q->activity_id)
                                                                                ->where('courseoffer_id', $id)
                                                                                ->first();

                                                                                if($q->obe_weight && $outcomes !== null){
                                                                                    $averageOutcome = ($outcomes->outcome  / $q->max_mark) * $q->obe_weight;
                                                                                    $totalAverageOutcome += $averageOutcome;
                                                                                    $weight += $q->obe_weight;
                                                                                }
                                                                                ?>
                                                                                 <?php 
                                                                    if ($weight == 0) {
                                                                        $totalAverageOutcome_new = 0; // or set a default value
                                                                    } else {
                                                                        $totalAverageOutcome_new = ($totalAverageOutcome / $weight) * 100;
                                                                    }
                                                            
                                                                ?>
                                                                        <?php 
                                                                            }
                                                                            $color = 'red'; 
                                                                            if($totalAverageOutcome_new >= 50){ 
                                                                                $color = 'blue';
                                                                            }
                                                                        ?>
                                                                        <?php if($color == 'red'){?>
                                                                            <input type="hidden"
                                                                            name="student_clo_{{$student->student->id}}[]" 
                                                                            value="stu-id:{{$student->student->id}},clo-id:{{$clo->clo_id}}">
                                                                        <?php } ?>
                                                                        <td style="vertical-align: top;width:30px; text-align:center;background-color:#e5ecec;"> <span style="color:{{$color}}">{{ number_format($totalAverageOutcome_new, 2) }}</span></td>
                                                                <?php } ?>
                                                            </tr>
                                                        
                                                        <?php } ?>
                                                           
                                                        </tbody>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col col-12">
                                                    <div class="form-group field-cqi-remarks">
                                                        <label class="control-label" for="cqi-remarks">Remarks</label>
                                                        <textarea id="cqi-remarks" class="form-control" name="cqiremarks" rows="2"></textarea>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col col-12">
                                                    <div class="form-group field-cqi-separate">
                                                        <label
                                                            class="checkbox checkbox-primary"> Generate CAR every CLO<span class="checkmark"></span>
                                                        </label>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-12">
                                                <button type="submit" class="btn btn-success">Generate</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View PEO -->
                </div>
            </div>
            <!-- /Page Content -->
            <!-- Modal -->
            <div id="view_class_activity" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Class Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('storecourseofferingcqiactivities') }}" class="mb-5" id="validationForm" name="validationForm">
                                                @csrf
                                                <input type="hidden" name="cqi_id" id="cqi_id" >
                                                <input type="hidden" name="course_offer_id" value="{{ $id }}">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Activity/<br>Assesment Method</label>
                                                            <div class="col-lg-9">
                                                                <select name="assesment_id" class="select">
                                                                    <option value="">- Select -</option>
                                                                    @foreach ($assesments as $a)
                                                                        <option value="{{ $a->id }}" >{{ $a->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Date</label>
                                                            <div class="col-lg-9">
                                                                <input class="form-control datetimepicker" name="assesment_date" type="text" placeholder="Date">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="padding: 20px 0px 10px 18px;">
                                                            <div>
                                                                <label class="d-block"> Complex Engineering</label>
                                                                <div class="col-lg-3">
                                                                    <input type="checkbox" id="complex_engineering_problem" name="complex_engineering_problem" value="0" class="check">
                                                                    <label for="complex_engineering_problem" class="checktoggle">checkbox</label>
                                                                </div>
                                                            </div>
                                                            <div class="pl-5">
                                                                <label class="d-block">Include for GPA Calculation</label>
                                                                <div class="col-lg-3">
                                                                    <input type="checkbox" id="gpa_calculation" name="gpa_calculation" value="0" class="check">
                                                                    <label for="gpa_calculation" class="checktoggle">checkbox</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Name</label>
                                                            <div class="col-lg-9">
                                                                <input type="text" class="form-control" name="assesment_name" autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">Total Marks</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control" name="assesment_total_mark" autofocus >
                                                            </div>
                                                        </div>	
                                                        <div class="form-group row">
                                                            <label class="col-lg-3 col-form-label">GPA Weight</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" class="form-control" name="assesment_gpa_weight" autofocus >
                                                            </div>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="mb-2 btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="outcome_activity" class="modal custom-modal fade show" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1000px;">
                    <div class="modal-content custom-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Outcome</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form  method="POST" action="{{ route('storecqioutcome') }}" class="mb-5">
                                            @csrf
                                            <input type="hidden" name="classactivity_id" id="model-classactivity_id">
                                            <input type="hidden" name="courseoffer_id" value="<?=$id;?>">
                                            <input type="hidden"  id="model-cqi_id" name="cqi_id" value="<?=$id;?>">
                                            <div class="table-responsive" id="outcome-table">
                                                
                                            </div>
                                            
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
            <!-- / Modal -->

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
            <script>
                $(document).ready(function() {
                    $('input[type="checkbox"]').change(function() {
                        var checkboxId = $(this).attr('id');
                        var data = $(this).attr('data');
                        var isChecked = $(this).is(':checked');
                        var newValue = isChecked ? data : 0;
                        // alert(checkboxId)

                        $('input[id="' + checkboxId + '"]').val(newValue);
                    });
                });
                function openClassActivity(courseoffer_id, cqi_id) {
                    $('#cqi_id').val(cqi_id);
                    $('#view_class_activity').modal('show');
                    
                }
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
                function getQuestion(siteurl,cqi_id,classactivity_id,course_offer_id){
                    $('#outcome_activity').modal('show');
					$('#outcome-table').html('');
					getDropDownData(siteurl, classactivity_id, cqi_id,course_offer_id);
				}
				
				function getDropDownData(siteurl, classactivity_id, cqi_id,course_offer_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: classactivity_id,
							cqi_id: cqi_id,
							course_offer_id: course_offer_id,
						},
						success: function(response){
                            $('#model-classactivity_id').val(classactivity_id);
                            $('#model-cqi_id').val(cqi_id);
                            $('#outcome-table').html(response);
						}
					});
				}

                $('#gpa_calculation').change(function(){
                    if($(this).prop("checked") == true){
                        $('#gpa_calculation').val(1)
                    }else if($(this).prop("checked") == false){
                        $('#gpa_calculation').val(0)
                    }
                });

                $('#complex_engineering_problem').change(function(){
                    if($(this).prop("checked") == true){
                        $('#complex_engineering_problem').val(1)
                    }else if($(this).prop("checked") == false){
                        $('#complex_engineering_problem').val(0)
                    }
                });
				
			</script>
        @endsection
