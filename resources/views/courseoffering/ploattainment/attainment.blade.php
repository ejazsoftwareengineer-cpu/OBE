<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title> Course Offering </title>
    <style>
        .table-container {
            overflow-y: auto; 
            /* max-height: 400px; Set the maximum height of the container */
        }


        /* Fix the width of the table headers */
        .table-container thead th {
            width: 150px; /* Adjust according to your table content */
        }

        /* Ensure the table header remains visible while scrolling */
        .table-container thead {
            position: sticky;
            top: 0;
            background-color: white; /* Set the background color as needed */
            z-index: 1; /* Ensure the header stays on top */
        }
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
                            <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}"class="nav-link ">Class Activities</a></li>
                            <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link ">CLO List</a></li> -->
                            <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li>
                            <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                            <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link ">Mark Assessment</a></li>
                            <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link">CLO Attainment</a></li>
                            <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link active">PLO Attainment</a></li>
                            <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <x-alert></x-alert>



                <?php if($course_offering->lockedplo == 1) { ?>
                      <div class="review-header text-center mt-2 mb-5 position-relative">
                        <div class="alert alert-warning text-center mt-3" role="alert">
                            <h5 class="review-title">Re-Calculate Your Assessment</h5>
                            <h5 class="mb-0">⚠️ If marks are not updating on this page, please re-calculate the assessment.</h5>
                            <button id="lockBtn" class="btn btn-danger ml-2">
                                    Re-Calculate Assessment
                                </button>
                        </div>
                        <!-- Progress Bar (hidden initially) -->
                        <div id="progressWrapper" class="mt-4" style="display:none;">
                            <div class="progress">
                                <div id="progressBar" 
                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" style="width: 0%">0%</div>
                            </div>
                            <p class="mt-2">Processing... please wait</p>

                            <!-- New red line message -->
                            <p class="text-danger mt-2">
                                Once the process is completed, this page will reload automatically.
                            </p>
                        </div>
                    </div>
                <div id="clo_view" class="pro-overview tab-pane fade show active">
                    <div class="">
                        <div class="">
                            <div class="card mb-0">
                                <div class="review-header text-left">
                                <div style="display: flex; justify-content: space-between; align-items: center;padding: 0px 0px 8px 0px;">
                                    <h4 style="margin: 0;">PLO's Attainment</h4>
                                    <form method="POST" action="{{ route('printplo') }}" target="_blank" class="mb-5" >
										@csrf
                                        <input type="hidden" id="plo_chart" name="plo_chart" >
                                        <input type="hidden" name="id" value="{{ $id }}" >
                                        <input id="export_button" type="submit" disabled value="Export">
                                    </form>
                                    <!-- <a href="{{ route('generatepdfforploattainment', $id) }}" style="border:1px solid #c7bcb2; padding: 5px; text-decoration: none;">Export</a> -->
                                </div>

                                    <!-- <h4>PLO's Attainment</h4>
                                    <a href="{{route('showeploattainment',$id)}}"  style="border: 1px solid #000; padding: 5px; text-decoration: none;">Export</a> -->
                                    <div class="table-container">
                                        <table  class=" table-bordered table-stripped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align:center; border:1px solid grey ">PLO</th>
                                                    <?php $p_i = 1;

                                                    ?>

                                                    <?php foreach($plos as $plo){?>

                                                        <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();

                                                                $plo_code = $ploObject::select('id','code')->whereid($plo->plo_id)->first();

                                                                ?>


                                                                <?php $plocolspan = 0;
                                                                    foreach($clo_usedinplo as $clo){
                                                                        $clo_usedinquestion = $activityquestion::where('courseoffer_id', $id)
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->count();
                                                                        $plocolspan += $clo_usedinquestion;

                                                                        $cqi_clo_usedinquestion = $cqiactivityquestion::where('courseoffer_id', $id)
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->count();
                                                                        $plocolspan += $cqi_clo_usedinquestion;

                                                                    }
                                                                ?>
                                                        <th colspan="{{$plocolspan}}" style="text-align:center; border:1px solid grey; ">{{ $plo_code->code }}</th>
                                                        <th rowspan="5" style="text-align:center; border:1px solid grey;background-color:#e5ecec; "> Weighted Total</th>
                                                        <th rowspan="5" style="text-align:center; border:1px solid grey;background-color:#e5ecec; "> PLO<br>Achieved</th>
                                                        <?php $p_i++;?>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="text-align:center;word-wrap: break-word; border:1px solid grey ">Activity</th>
                                                    <?php $a_i = 1;?>
                                                    <?php foreach($plos as $plo){

                                                        ?>

                                                        <?php
                                                            $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                            ->where('plo_id', $plo->plo_id)
                                                            ->groupBy('clo_id')
                                                            ->get();


                                                                ?>

                                                                <?php foreach($clo_usedinplo as $clo){ ?>

                                                                    <?php $questions = $activityquestion::where('courseoffer_id', $id)
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->get();

                                                                        // echo "<pre>";
                                                                        // print_r($questions);
                                                                        // die('ejaz');

                                                                        ?>

                                                                <?php foreach($questions as $q){

                                                                    ?>
                                                                    <?php $assesment_name = $assesment::select('id','name')->where('id', $q->classActivity->assesment_id)->first();
                                                                        ?>
                                                                        <th style="text-align:center; border:1px solid grey">{{$assesment_name->name ?? '--'}}</th>
                                                                    <?php } ?>

                                                                    <!-- Cqi -->
                                                                    <?php
                                                                    $cqiquestions = $cqiactivityquestion::with('cqiclassactivity')->select('id','cqi_activity_id')->where('courseoffer_id', $id)
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->get();
                                                                        ?>
                                                                    <?php foreach($cqiquestions as $cq){?>

                                                                        <?php $cqiassesment = $assesment::select('id','name')->where('id', $cq->cqiclassactivity->assesment_id)->first();?>
                                                                        <th style="text-align:center;  border:1px solid grey;"><a href="javascript:void(0);">{{ $cqiassesment->name }}</a></th>
                                                                    <?php } ?>
                                                                    <!-- End Cqi -->
                                                                <?php } ?>
                                                        <?php $a_i++;?>
                                                    <?php } ?>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" style="text-align:center;word-wrap: break-word; border:1px solid grey ">Question</th>
                                                    <?php foreach($plos as $plo){?>
                                                            <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();
                                                                ?>
                                                            <?php foreach($clo_usedinplo as $clo){?>
                                                                <?php $questions = $activityquestion::select('id','question_name')->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();
                                                                    ?>
                                                                    <?php foreach($questions as $q){?>
                                                                        <th style="text-align:center; border:1px solid grey">{{$q->question_name}}</th>
                                                                    <?php } ?>
                                                            <?php } ?>

                                                            <!-- Cqi -->
                                                            <?php $cqiquestions = $cqiactivityquestion::select('id','question_name')->where('courseoffer_id', $id)
                                                            ->where('clo_id', $clo->clo_id)
                                                            ->get();
                                                            ?>
                                                            <?php foreach($cqiquestions as $cq){?>

                                                                <th style="text-align:center;  border:1px solid grey;"><a href="javascript:void(0);">{{ $cq->question_name }}</a></th>
                                                            <?php } ?>

                                                            <!-- End Cqi -->
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="text-align:center; border:1px solid grey"> Assigned CLO</th>
                                                    <?php foreach($plos as $plo){?>
                                                            <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();
                                                                ?>
                                                            <?php foreach($clo_usedinplo as $clo){?>
                                                                <?php $questions = $activityquestion::select('id','clo_id')->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();
                                                                    $clo_code = $courseofferclo::select('code')->whereid($clo->clo_id)->first();
                                                                    ?>
                                                                    <?php foreach($questions as $q){?>
                                                                        <th style="text-align:center; border:1px solid grey">{{$clo_code->code}}</th>
                                                                    <?php } ?>
                                                            <?php } ?>
                                                            <?php $cqiquestions = $cqiactivityquestion::select('id','clo_id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){ ?>
                                                                    <th style="text-align:center; border:1px solid grey"><a href="javascript:void(0);">CLO{{$cq->clo_id}}</a></th>
                                                                <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="text-align:center; border:1px solid grey ">CLO Weight %</th>
                                                    <?php $w_i = 1; $obe_weight='';?>
                                                    <?php  foreach($plos as $plo){ ?>
                                                            <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();
                                                                ?>
                                                            <?php
                                                            // $totalobeweight = 0;
                                                                foreach($clo_usedinplo as $clo){ ?>
                                                                <?php $questions = $activityquestion::select('id','activity_id','obe_weight')->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();

                                                                    ?>

                                                                <?php  foreach($questions as $q){
                                                                    if($q->obe_weight){
                                                                        $obe_weight = $q->obe_weight.'.00';
                                                                        // $totalobeweight += $q->obe_weight;
                                                                    }else{
                                                                        $obe_weight='';
                                                                    }
                                                                    ?>
                                                                    <th style="text-align:center; border:1px solid grey">{{$obe_weight}}</th>
                                                                <?php } ?>

                                                                <!-- Cqi -->
                                                                <?php $cqiquestions = $cqiactivityquestion::select('id','obe_weight','cqi_activity_id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){
                                                                    if($cq->obe_weight){
                                                                        $cqi_obe_weight = $cq->obe_weight.'.00';
                                                                        // $totalobeweight += $cq->obe_weight;
                                                                    }
                                                                    ?>
                                                                    <th style="text-align:center; border:1px solid grey; "><a href="javascript:void(0);">{{$cqi_obe_weight}}</a></th>
                                                                <?php } ?>
                                                                    <!-- End Cqi -->
                                                            <?php } ?>
                                                        <?php $w_i++;?>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" style="text-align:center; border:1px solid grey"></th>
                                                    <?php foreach($plos as $plo){?>
                                                            <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();
                                                                ?>
                                                            <?php foreach($clo_usedinplo as $clo){?>
                                                                <?php $questions = $activityquestion::select('id','question_name')->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();
                                                                    ?>
                                                                    <?php foreach($questions as $q){?>
                                                                        <th style="text-align:center; border:1px solid grey">---</th>
                                                                    <?php } ?>
                                                             
                                                             <?php $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){?>
                                                                    <th style="text-align:center; border:1px solid grey">-- </th>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            <th colspan="2" style="text-align:center; border:1px solid grey;background-color:#e5ecec; ">KPI 50%</th>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th style="width:210px; text-align:left;">Registration No.</th>
                                                    <th style="width:150px; text-align:left;">Name</th>

                                                    <?php
                                                    $max_mark = '';
                                                    $cqi_max_mark = '';
                                                     foreach($plos as $plo){ ?>
                                                        <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();
                                                            ?>
                                                        <?php foreach($clo_usedinplo as $clo){?>
                                                            <?php $questions = $activityquestion::select('id','max_mark')->where('courseoffer_id', $id)
                                                            ->where('clo_id', $clo->clo_id)
                                                            ->get();
                                                            ?>
                                                            <?php foreach($questions as $q){ ?>
                                                                <th style="width:30px; text-align:center;">{{$q->max_mark}}.00</th>
                                                            <?php } ?>

                                                            <?php $cqiquestions = $cqiactivityquestion::select('id','max_mark')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){ ?>
                                                                    <th style="width:30px; text-align:center;"><a href="javascript:void(0);">{{$cq->max_mark}}.00</a></th>
                                                                <?php } ?>

                                                        <?php } ?>
                                                        <th style="width:30px; text-align:center;background-color:#e5ecec;"></th>
                                                        <th style="width:20px; text-align:center;background-color:#e5ecec;"></th>

                                                    <?php } ?>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                <?php foreach($enrolledstudent as $student){ ?>
                                                    <tr>
                                                        <!-- Registration No -->
                                                        <td style="vertical-align: top;width:210px; text-align:left;">
                                                            <a>{{ $student->student->registration_no }}</a>
                                                        </td>

                                                        <!-- Student Name -->
                                                        <td style="vertical-align: top;width:150px; text-align:left;">
                                                            {{ $student->student->name }}
                                                        </td>

                                                        <?php foreach($plos as $plo){ ?>

                                                            <?php
                                                            // ===== CLOs under this PLO =====
                                                            $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                                                                ->where('course_id', $course_id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->groupBy('clo_id')
                                                                ->get();

                                                            // ===== Get all distinct questions linked with CLOs under this PLO =====
                                                            $questions = $StudentQuestionPloAttainment::where('courseoffer_id', $id)
                                                                ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                                                                ->select('question_id','cqi_question_id','question_flag')
                                                                ->distinct()
                                                                ->get();
                                                            ?>

                                                            <?php foreach($questions as $q){ ?>
                                                                <?php
                                                                // Get this student's marks for the current question
                                                                $mark = $StudentQuestionPloAttainment::where('student_id', $student->student->id)
                                                                    ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                                                                    ->where('question_flag', $q->question_flag)
                                                                    ->where('question_id', $q->question_id)
                                                                    ->where(function($query) use ($q) {
                                                                        $query->where('question_id', $q->question_id)
                                                                            ->orWhere('cqi_question_id', $q->cqi_question_id);
                                                                    })
                                                                    ->first();
                                                                ?>
                                                                <td style="vertical-align: top;width:30px; text-align:center;">
                                                                    {{ $mark->obtained_marks ?? '-' }}
                                                                </td>
                                                            <?php } ?>

                                                            <?php
                                                            // ===== PLO Attainment (Weighted Total + Flag) =====
                                                            $plo_att = $StudentPloAttainment::where('student_id', $student->student->id)
                                                                ->where('plo_id', $plo->plo_id)
                                                                ->where('courseoffer_id', $id)
                                                                ->first();

                                                            $color = 'red';
                                                            $flag  = 'N';
                                                            if ($plo_att && $plo_att->achieved_flag == 'Y') {
                                                                $color = 'blue';
                                                                $flag  = 'Y';
                                                            }
                                                            ?>

                                                            <!-- Weighted Total -->
                                                            <td style="vertical-align: top;width:30px; text-align:center;background-color:#e5ecec;">
                                                                <span style="color:{{ $color }}">{{ $plo_att->weighted_total ?? '-' }}</span>
                                                            </td>

                                                            <!-- PLO Achieved Flag -->
                                                            <td style="vertical-align: top;width:20px; text-align:center;background-color:#e5ecec;">
                                                                <span style="color:{{ $color }}">{{ $flag }}</span>
                                                            </td>

                                                        <?php } // end PLO loop ?>
                                                    </tr>
                                                <?php } // end student loop ?>
                                            </tbody>


                                        </table>

                                    </div>
                                    <br>
                                    <p>
                                        <font color="blue">* * any blue color means activity is achieved</font>
                                        <br>
                                        <font color="red">** any red color means some KPI is not achieved</font>
                                    </p>
                                        <table style="width:100%;border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">PLO</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Total Students</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Number of Students Attained PLO ≥ 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Percentage ≥ 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Average Attainment (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($plos as $plo){ ?>
                                                    <?php
                                                    $plo_code = $ploObject::select('code')->whereId($plo->plo_id)->first();

                                                    $records = $StudentPloAttainment::where('courseoffer_id', $id)
                                                        ->where('plo_id', $plo->plo_id)
                                                        ->get();

                                                    $total_students = $records->count();
                                                    $students_above_50 = $records->where('achieved_flag','Y')->count();
                                                    $percentage_above_50 = $total_students > 0 
                                                        ? ($students_above_50 / $total_students) * 100 
                                                        : 0;
                                                    $average_attainment = $total_students > 0 
                                                        ? $records->avg('weighted_total')   // FIXED
                                                        : 0;


                                                    // push to array (optional, for JSON/export)
                                                    $plo_data[] = [
                                                        'plo' => $plo_code->code ?? '-',
                                                        'total_students' => $total_students,
                                                        'students_above_50' => $students_above_50,
                                                        'percentage_above_50' => round($percentage_above_50, 2),
                                                        'average_attainment' => round($average_attainment, 2),
                                                    ];
                                                    ?>
                                                    <tr>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $plo_code->code ?? '-' }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $total_students }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $students_above_50 }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ number_format($percentage_above_50, 2) }}%</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ number_format($average_attainment, 2) }}</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>


                                        <!-- <canvas id="myChart" width="250" height="150"></canvas> -->
                                        <div id="plo_chart_div" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
              
                <?php }else{ ?>
                    <div class="alert alert-warning text-center mt-3" role="alert">
                        <h5 class="mb-0">⚠️ Please Calculate your assessment first before proceeding.</h5>
                    </div>
                     <div class="review-header text-center mt-2 mb-5 position-relative">
                        <h3 class="review-title">Calculate Your Assessment</h3>
                        <div class="row mt-4 justify-content-center">
                            <div class="form-group col-sm-8 d-flex align-items-center">
                                <label class="col-sm-9">
                                    Please Calculate your assessment after entering student marks. 
                                    Once Calculated, marks cannot be changed from the teacher portal. 
                                    <span class="text-danger">*</span>
                                </label>

                                <!-- Lock Button -->
                                <button id="lockBtn" class="btn btn-danger ml-2">
                                    Calculate Assessment
                                </button>
                            </div>
                        </div>

                        <!-- Progress Bar (hidden initially) -->
                        <div id="progressWrapper" class="mt-4" style="display:none;">
                            <div class="progress">
                                <div id="progressBar" 
                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" style="width: 0%">0%</div>
                            </div>
                            <p class="mt-2">Processing... please wait</p>

                            <!-- New red line message -->
                            <p class="text-danger mt-2">
                                Once the process is completed, this page will reload automatically.
                            </p>
                        </div>
                    </div>

                <?php } ?>
                <!-- /View PEO -->
            </div>
        </div>
        <!-- /Page Content -->
        <!-- Modal -->

        <!-- / Modal -->


    </div>
    <!-- /Page Wrapper -->

    @endsection

    @section('script')

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        <?php if($course_offering->lockedplo == 1) { ?>
        window.onload = function() {
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawCloChart);

            function drawCloChart() {
                var ploData =  <?php echo json_encode($plo_data); ?>;

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'PLO');
                    data.addColumn('number', 'Average Attainment');
                    data.addColumn({type: 'string', role: 'annotation'});

                    ploData.forEach(function(item) {
                        data.addRow([item.plo, parseFloat(item.average_attainment.toFixed(2)), item.average_attainment.toFixed(2) + '%']);
                    });

                    var options = {
                        title: 'PLO Attainment Chart',
                        vAxis: {
                            title: '% Attainment',
                            textStyle: { color: 'black' },
                            viewWindow: {
                                min: 0,
                                max: 100
                            }
                        },
                        hAxis: {
                            title: 'PLO',
                            textStyle: { color: 'black' },
                            slantedText: true,
                            slantedTextAngle: 45
                        },
                        legend: { textStyle: { color: 'black' } },
                        titleTextStyle: { color: 'black' },
                        seriesType: 'bars',
                        annotations: {
                            alwaysOutside: true,
                            textStyle: {
                                fontSize: 12,
                                color: 'black'
                            }
                        }
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('plo_chart_div'));
                    chart.draw(data, options);
            }
        }
        // setTimeout(() => {
        //     let chartdata = $('#clo_chart_div').html();
        //     $('#clo_chart').val(chartdata);
        // }, 2000);
        setTimeout(() => {
            let chartDiv = document.getElementById('plo_chart_div');
            html2canvas(chartDiv).then(canvas => {
                let chartData = canvas.toDataURL('image/png');
                document.getElementById('plo_chart').value = chartData;

                // Enable the export button after chart data is ready
                document.getElementById('export_button').disabled = false;
            });
        }, 2000);
        
         <?php } ?>


         
                document.addEventListener("DOMContentLoaded", function () {
                    const lockBtn = document.getElementById("lockBtn");
                    const progressWrapper = document.getElementById("progressWrapper");
                    const progressBar = document.getElementById("progressBar");

                    lockBtn.addEventListener("click", function () {
                        showLoader();
                        // Show progress bar
                        progressWrapper.style.display = "block";
                        let progress = 0;

                        // Simulated progress animation
                        const interval = setInterval(() => {
                            if (progress >= 100) { // stop at 90 until request completes
                                clearInterval(interval);
                            } else {
                                progress += 10;
                                progressBar.style.width = progress + "%";
                                progressBar.textContent = progress + "%";
                            }
                        }, 400);

                        // Send actual request
                        fetch("{{ route('lockAssessmentPLO', $id) }}", {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then(response => {
                             if (response.status === 200) {
                                // Ensure progress is full before reload
                                progress = 100;
                                progressBar.style.width = "100%";
                                progressBar.textContent = "100%";

                                setTimeout(() => {
                                    location.reload();
                                }, 4000);
                            }
                        })
                        .catch(() => {
                            alert("Something went wrong!");
                            progressWrapper.style.display = "none";
                              hideLoader();
                        });
                    });
                });

    </script>

    @endsection

