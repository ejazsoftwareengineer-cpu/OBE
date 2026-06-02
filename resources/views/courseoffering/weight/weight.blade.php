<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title> Course Offering </title>      
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
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li> 
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link active">Adjust Weight</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content">
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px 0px 0px 10px;">
                                        <h4 class="mb-0">Adjust CLO Weight Against Questions</h4>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dynamically generated CLOs -->
                        <div id="dynamic_clos" class="row">
                            <?php $p = 0; foreach($clos as $clo){ $p++; ?>
                                <div class="col-sm-12">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <?php $weight = $clo->weight ?? 100 ;?>
                                            <h5 class="mb-0">
                                                <?=$clo->code ?? 'CLO CODE'?> 
                                                (Weight : <?php echo $weight ;?>) 
                                                <span id="errormessage" style="color:green;"></span>
                                                <span id="errormessage_red" style="color:red;"></span>
                                            </h5>
                                        </div>
                                        <input type="hidden" id="course_offer_id" value="{{ $id }}">
                                        <div class="card-body">
                                            <?php 
                                            $questions = $activityquestion::with(['classActivity:id,assesment_name'])
                                                ->select('*')
                                                ->where('courseoffer_id', $id)
                                                ->where('clo_id', $clo->id)
                                                ->get(); 
                                            ?>
                                            <!-- Questions for CLO -->
                                            <?php foreach($questions as $q){ 
                                                $inputId = "input_{$clo->id}_{$q->id}";
                                            ?>
                                                <div class="form-group row align-items-center">
                                                    <label for="<?=$inputId?>" class="col-sm-2 col-form-label">
                                                        <?=$q->classActivity->assesment_name?> (<?=$q->question_name ?? ' -'?>)
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <input type="number" 
                                                               id="<?=$inputId?>" 
                                                               name="weights[]" 
                                                               class="form-control clo-weight" 
                                                               placeholder="Enter CLO Weight" 
                                                               value="<?=$q->obe_weight?>" 
                                                               data-indicator="{{$p}}" 
                                                               data-totalweight-id="<?=$weight?>" 
                                                               data-clo-id="<?=$clo->id?>" 
                                                               data-question-id="<?=$q->id?>">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Global Update Button -->
                        <div class="text-right mt-3">
                            <button class="btn btn-primary" onclick="updateAllWeights('{{route('updateCloWeight')}}')">
                                Update All
                            </button>
                        </div>


                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
        <script>
            function updateAllWeights(siteurl) {

                let weightsData = [];
                document.querySelectorAll(".clo-weight").forEach(function(input) {
                    weightsData.push({
                        fieldValue: input.value,
                        questionId: input.getAttribute('data-question-id'),
                        cloId: input.getAttribute('data-clo-id'),
                        totalweight: input.getAttribute('data-totalweight-id'),
                        indicator: input.getAttribute('data-indicator')
                    });
                });

                const course_offer_id = $('#course_offer_id').val();

                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        weights: weightsData,
                        course_offer_id: course_offer_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // if (response.status === 'success') {
                        //     location.reload();
                        // } else if (response.status === 'error') {
                        //     alert(response.message);
                        // }
                            if (response.status === 'success') {
                                $('#errormessage').html(response.message);
                                // showToast(response.message, 'success');
                                // setTimeout(() => location.reload(), 1500); // reload after showing toast
                            } else if (response.status === 'error') {
                                $('#errormessage_red').html(response.message);
                                // showToast(response.message, 'danger');
                            }
                        

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        </script>
        @endsection
