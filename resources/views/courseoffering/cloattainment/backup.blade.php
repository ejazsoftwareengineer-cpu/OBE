
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title> Course Offering </title>
    <style>
        .table-container {
            overflow-y: auto; /* Enable vertical scrollbar */
            max-height: 400px; /* Set the maximum height of the container */
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
        th.sticky-header {
            position: sticky;
            top: 0;
            background-color: white; /* Ensure the background matches the table background */
            z-index: 1000; /* Ensure the header is above other content */
            border: 1px solid grey;
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
                            <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link active">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">

                <x-alert></x-alert>


                <?php  // $c = $courseoffer::whereid($id)->first(); 
                // echo "<pre>";
                // print_r($c->locked);
                // die();
                ?>

                <?php if($course_offering->locked == 1) { ?>
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <!-- <div class=""> -->
                                <div class="card mb-0">
                                    <div class="review-header text-left">

                                        <div style="display: flex; justify-content: space-between; align-items: center;padding: 0px 0px 8px 0px;">
                                        <h4 style="margin: 0;">CLO's Attainment</h4>
                                        <form method="POST" action="{{ route('printclo') }}" target="_blank" class="mb-5" >
                                            @csrf
                                            <input type="hidden" id="clo_chart" name="clo_chart" >
                                            <input type="hidden" name="id" value="{{ $id }}" >
                                            <input  id="export_button"  type="submit" value="Export">
                                        </form>
                                        <!-- <a href="{{ route('generatepdfforcloattainment', $id) }}" style="border:1px solid #c7bcb2; padding: 5px; text-decoration: none;">Export</a> -->
                                    </div>
                                        <div class="table-container">
                                            <table class=" table-bordered table-stripped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center; ">CLO</th>
                                                        <?php $c_i = 1;?>
                                                        <?php foreach($clos as $clo){?>
                                                            <?php $clo_usedinquestion = $activityquestion::where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->count();
                                                                $clo_code = $courseofferclo::select('code')->whereid($clo->clo_id)->first();
                                                                ?>
                                                                <?php $cqi_clo_usedinquestion = $cqiactivityquestion::where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->count();
                                                                ?>
                                                            <th class="sticky-header" colspan="{{$clo_usedinquestion+$cqi_clo_usedinquestion}}" style="text-align:center;; "> {{$clo_code->code ?? '-'}}</th>
                                                            <th class="sticky-header" rowspan="4" style="text-align:center;;background-color:#e5ecec; "> Weighted Total</th>
                                                            <th class="sticky-header" rowspan="4" style="text-align:center;;background-color:#e5ecec; "> CLO<br>Achieved</th>
                                                            <?php $c_i++;?>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center; ">Activity</th>

                                                        <?php foreach($clos as $clo){?>
                                                            <?php $questions = $activityquestion::with('classActivity')->select('id','activity_id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                            <?php foreach($questions as $q){ $assesment = $q->classActivity->assesment ?? null;
                                                                //  echo "<pre>"; print_r($assesment); die();
                                                                ?>

                                                                <?php //$assesment_name = $assesment::select('id','name')->where('id', $assesment->name)
                                                                // ->first();
                                                                ?>
                                                                <th class="sticky-header" style="text-align:center; ">{{ $q->classActivity->assesment_name ?? '-' }}</th>
                                                            <?php } ?>

                                                            <!-- Cqi -->
                                                            <?php $cqiquestions = $cqiactivityquestion::with('cqiclassactivity')->select('id','cqi_activity_id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                            <?php foreach($cqiquestions as $cq){
                                                                $cqiassesment =  $cq->cqiclassactivity->assesment;
                                                                // echo "<pre>"; print_r($cqiassesment); die();
                                                                ?>

                                                                <?php // $cqiassesment = $assesment::select('id','name')->where('id', $cqiassesment->name)
                                                                ?>
                                                                <th class="sticky-header" style="text-align:center; "><a href="javascript:void(0);">{{ $cqiassesment->name }}</a></th>
                                                            <?php } ?>
                                                            <!-- End Cqi -->
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center; "></th>
                                                        <?php $q_i = 1;?>
                                                        <?php foreach($clos as $clo){?>
                                                            <?php $questions = $activityquestion::select('id','question_name','name')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>

                                                                <?php foreach($questions as $q){?>
                                                                    <th class="sticky-header" style="text-align:center; ">{{$q->name}}</th>
                                                                <?php } ?>
                                                                <!-- Cqi -->
                                                                <?php $cqiquestions = $cqiactivityquestion::select('id','question_name')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){?>

                                                                    <th class="sticky-header" style="text-align:center; "><a href="javascript:void(0);">{{ $cq->question_name }}</a></th>
                                                                <?php } ?>

                                                                <!-- End Cqi -->
                                                            <?php $q_i++;?>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center; ">CLO Weight %</th>
                                                        <?php $w_i = 1; $obe_weight=''; $cqi_obe_weight='';?>
                                                        <?php foreach($clos as $clo){?>
                                                            <?php $questions = $activityquestion::select('id','activity_id','obe_weight')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>

                                                                <?php foreach($questions as $q){
                                                                    if($q->obe_weight){
                                                                        $obe_weight = $q->obe_weight;
                                                                    }
                                                                    ?>
                                                                    <th class="sticky-header" style="text-align:center; ">{{$obe_weight}}</th>
                                                                <?php } ?>
                                                                <!-- Cqi -->
                                                                <?php $cqiquestions = $cqiactivityquestion::select('id','obe_weight','cqi_activity_id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <?php foreach($cqiquestions as $cq){
                                                                    if($cq->obe_weight){
                                                                        $cqi_obe_weight = $cq->obe_weight;
                                                                    }
                                                                    ?>
                                                                    <th class="sticky-header" style="text-align:center; "><a href="javascript:void(0);">{{$cqi_obe_weight}}</a></th>
                                                                <?php } ?>
                                                                    <!-- End Cqi -->
                                                            <?php $w_i++;?>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center; "></th>
                                                        <?php $q_i = 1;?>
                                                        <?php foreach($clos as $clo){?>
                                                            <?php $questions = $activityquestion::select('id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>

                                                                <?php foreach($questions as $q){?>
                                                                    <th class="sticky-header" style="text-align:center; "></th>
                                                                <?php } ?>
                                                                <!-- Cqi -->
                                                                <?php $cqiquestions = $cqiactivityquestion::select('id')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>

                                                                <?php foreach($cqiquestions as $cq){?>
                                                                    <th class="sticky-header" style="text-align:center; "></th>
                                                                <?php } ?>
                                                                    <!-- End Cqi -->
                                                                <th class="sticky-header" colspan="2" style="text-align:center;background-color:#e5ecec; "> KPI 50%</th>
                                                            <?php $q_i++;?>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:210px; text-align:left;">Registration No.</th>
                                                        <th style="width:150px; text-align:left;">Name</th>

                                                        <?php
                                                        $max_mark = '';
                                                        $cqi_max_mark = '';
                                                        foreach($clos as $clo){?>
                                                            <?php $questions = $activityquestion::select('id','max_mark')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>

                                                                <?php foreach($questions as $q){
                                                                    if($q->max_mark){
                                                                        $max_mark = $q->max_mark.'.00';
                                                                    }
                                                                    ?>
                                                                    <th style="width:30px; text-align:center;">{{$q->max_mark}}</th>
                                                                <?php } ?>
                                                                <?php $cqiquestions = $cqiactivityquestion::select('id','max_mark')->where('courseoffer_id', $id)
                                                                ->where('clo_id', $clo->clo_id)
                                                                ->get();
                                                                ?>
                                                                <!-- Cqi -->
                                                                <?php foreach($cqiquestions as $cq){
                                                                    if($cq->max_mark){
                                                                        $cqi_max_mark = $cq->max_mark.'.00';
                                                                    }
                                                                    ?>
                                                                    <th style="width:30px; text-align:center;"><a href="javascript:void(0);">{{$cq->max_mark}}</a></th>
                                                                <?php } ?>
                                                                <!-- End Cqi -->
                                                                <th style="width:30px; text-align:center;background-color:#e5ecec;"></th>
                                                                <th style="width:20px; text-align:center;background-color:#e5ecec;"></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    foreach($enrolledstudent as $student){ ?>
                                                        <tr>
                                                            <td style="vertical-align: top;width:210px; text-align:left;"><a>{{$student->student->registration_no}}</a></td>
                                                            <td style="vertical-align: top;width:150px; text-align:left;">{{$student->student->name}}</td>
                                                            <?php $s_i = 1; ?>
                                                            <?php foreach($clos as $clo){ ?>
                                                                <?php
                                                                // Initialize weights and total outcome
                                                                $totalAverageOutcome = 0;
                                                                $weight = 0;

                                                                // Get questions
                                                                $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')
                                                                    ->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();

                                                                // Loop through questions and calculate total outcome and weight
                                                                foreach($questions as $q){
                                                                    $outcomes = $studentassessment::select('id','outcome')
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->where('student_id', $student->student->id)
                                                                        ->where('question_id', $q->id)
                                                                        ->where('activity_id', $q->activity_id)
                                                                        ->where('courseoffer_id', $id)
                                                                        ->first();

                                                                    $weight += $q->obe_weight;
                                                                    if($q->obe_weight && $outcomes !== null){
                                                                        $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                                                                        $totalAverageOutcome += $averageOutcome;
                                                                    }

                                                                    ?>
                                                                    <td style="vertical-align: top;width:30px; text-align:center;">{{$outcomes->outcome ?? 0}} </td>
                                                                <?php } ?>

                                                                <!-- Calculate CQI outcomes and add to the total -->
                                                                <?php
                                                                $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')
                                                                    ->where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->get();

                                                                foreach($cqiquestions as $cq) {
                                                                    $cqioutcomes = $cqistudentassessment::select('id','outcome')
                                                                        ->where('clo_id', $clo->clo_id)
                                                                        ->where('student_id', $student->student->id)
                                                                        ->where('cqi_question_id', $cq->id)
                                                                        ->where('cqi_activity_id', $cq->cqi_activity_id)
                                                                        ->where('courseoffer_id', $id)
                                                                        ->first();

                                                                        // $weight -= $cq->obe_weight;
                                                                    if($cq->obe_weight && $cqioutcomes !== null){
                                                                        $weight += $cq->obe_weight;
                                                                        $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
                                                                        $totalAverageOutcome += $cqiaverageOutcome;
                                                                    }
                                                                    ?>
                                                                    <td style="vertical-align: top;width:30px; text-align:center;">{{$cqioutcomes->outcome ?? ''}}</td>
                                                                <?php } ?>

                                                                <!-- Final calculation of total average outcome -->
                                                                <?php
                                                                if ($weight == 0) {
                                                                    $totalAverageOutcome_new = 0;
                                                                } else {
                                                                    $totalAverageOutcome_new = ($totalAverageOutcome / $weight) * 100;
                                                                }

                                                                // Determine color and flag based on totalAverageOutcome_new
                                                                $color = 'red';
                                                                $flag = 'N';
                                                                if ($totalAverageOutcome_new >= 50) {
                                                                    $color = 'blue';
                                                                    $flag = 'Y';
                                                                }
                                                                ?>

                                                                <!-- Output the total average outcome and flag -->
                                                                <td style="vertical-align: top;width:30px; text-align:center;background-color:#e5ecec;">
                                                                    <span style="color:{{$color}}">{{ number_format($totalAverageOutcome_new, 2) }}</span>
                                                                </td>
                                                                <td style="vertical-align: top;width:20px; text-align:center;background-color:#e5ecec;">{{$flag}}</td>
                                                                <?php $s_i++; ?>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>


                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <p>
                                            <font color="blue">* any blue color means activity is achieved</font>
                                            <br>
                                            <font color="red">** any red color means some KPI is not achieved</font>
                                        </p>
                                    <?php
                                            $clo_data = [];

                                            foreach ($clos as $clo) {
                                                $clo_code = $courseofferclo::select('code')->whereId($clo->clo_id)->first();

                                                $totalStudents = count($enrolledstudent);
                                                $studentsAbove50 = 0;
                                                $sumAveragePercentage = 0;

                                                foreach ($enrolledstudent as $student) {
                                                    $totalAverageOutcome = 0;
                                                    $weight = 0;

                                                    // Questions from activities
                                                    $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')
                                                        ->where('courseoffer_id', $id)
                                                        ->where('clo_id', $clo->clo_id)
                                                        ->get();

                                                    foreach ($questions as $q) {
                                                        $outcome = $studentassessment::select('outcome')
                                                            ->where('clo_id', $clo->clo_id)
                                                            ->where('student_id', $student->student->id)
                                                            ->where('question_id', $q->id)
                                                            ->where('activity_id', $q->activity_id)
                                                            ->where('courseoffer_id', $id)
                                                            ->first();

                                                        $weight += $q->obe_weight;
                                                        if ($q->obe_weight && $outcome) {
                                                            $averageOutcome = ($outcome->outcome / $q->max_mark) * $q->obe_weight;
                                                            $totalAverageOutcome += $averageOutcome;
                                                        }
                                                    }

                                                    // CQI Questions
                                                    $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')
                                                        ->where('courseoffer_id', $id)
                                                        ->where('clo_id', $clo->clo_id)
                                                        ->get();

                                                    foreach ($cqiquestions as $cq) {
                                                        $cqioutcome = $cqistudentassessment::select('outcome')
                                                            ->where('clo_id', $clo->clo_id)
                                                            ->where('student_id', $student->student->id)
                                                            ->where('cqi_question_id', $cq->id)
                                                            ->where('cqi_activity_id', $cq->cqi_activity_id)
                                                            ->where('courseoffer_id', $id)
                                                            ->first();

                                                        if ($cq->obe_weight && $cqioutcome) {
                                                            $weight += $cq->obe_weight;
                                                            $cqiAverageOutcome = ($cqioutcome->outcome / $cq->max_mark) * $cq->obe_weight;
                                                            $totalAverageOutcome += $cqiAverageOutcome;
                                                        }
                                                    }

                                                    // Final average attainment for this student for this CLO
                                                    $attainmentPercent = $weight ? ($totalAverageOutcome / $weight) * 100 : 0;

                                                    $sumAveragePercentage += $attainmentPercent;
                                                    if ($attainmentPercent >= 50) {
                                                        $studentsAbove50++;
                                                    }
                                                }

                                                // CLO-wise summary
                                                $percentageAbove50 = $totalStudents ? ($studentsAbove50 / $totalStudents) * 100 : 0;
                                                $averageAttainment = $totalStudents ? $sumAveragePercentage / $totalStudents : 0;

                                                $clo_data[] = [
                                                    'clo' => $clo_code->code ?? '-',
                                                    'total_students' => $totalStudents,
                                                    'students_above_50' => $studentsAbove50,
                                                    'percentage_above_50' => $percentageAbove50,
                                                    'average_attainment' => $averageAttainment
                                                ];
                                            }

                                            // Final JSON
                                            $json_clo_data = json_encode($clo_data);
                                            ?>

                                        <!-- <style>
                                            table {
                                                width: 100%;
                                                border-collapse: collapse;
                                            }
                                            table, th, td {
                                                border: 1px solid black;
                                            }
                                            th, td {
                                                padding: 8px;
                                                text-align: left;
                                            }
                                        </style> -->

                                        <table style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">CLO</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Total Students</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Number of Students Attained CLO Above 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Percentage Above 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Percentage Average</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($clo_data as $data) { ?>
                                                    <tr>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['clo']; ?></td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['total_students']; ?></td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['students_above_50']; ?></td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo number_format($data['percentage_above_50'], 2) . '%'; ?></td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo number_format($data['average_attainment'], 2); ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                        <!-- <canvas id="myChart" width="300" height="100"></canvas> -->
                                        <div id="clo_chart_div" style="width: 900px; height: 500px;"></div>
                                    </div>
                                </div>
                        <!-- </div> -->
                    </div>
                
                <?php }else{ ?>
                    <div class="alert alert-warning text-center mt-3" role="alert">
                        <h5 class="mb-0">⚠️ Please lock your assessment first before proceeding.</h5>
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
        <?php if($course_offering->locked == 1) { ?>
        window.onload = function() {
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawCloChart);

            function drawCloChart() {
                var cloData = <?php echo $json_clo_data; ?>;
                // var cloData = [
                //     {
                //         "clo": "CLO1",
                //         "total_students": 10,
                //         "students_above_50": 7,
                //         "percentage_above_50": 70,
                //         "average_attainment": 75
                //     },
                //     {
                //         "clo": "CLO2",
                //         "total_students": 15,
                //         "students_above_50": 10,
                //         "percentage_above_50": 66.67,
                //         "average_attainment": 80
                //     },
                //     {
                //         "clo": "CLO3",
                //         "total_students": 12,
                //         "students_above_50": 9,
                //         "percentage_above_50": 75,
                //         "average_attainment": 85
                //     }
                // ];
                // console.log(cloData); // To verify the data structure in the console

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'CLO');
                data.addColumn('number', 'Average Attainment');
                data.addColumn({type: 'string', role: 'annotation'});

                cloData.forEach(function(item) {
                    data.addRow([item.clo, item.average_attainment, item.average_attainment.toString() + '%']);
                });

                var options = {
                    title: 'CLO Attainment Chart',
                    vAxis: {
                        title: '% Attainment',
                        textStyle: { color: 'black' },
                        viewWindow: {
                            min: 0,
                            max: 100
                        }
                    },
                    hAxis: {
                        title: 'CLO',
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

                var chart = new google.visualization.ComboChart(document.getElementById('clo_chart_div'));
                chart.draw(data, options);

            }
        }
        // setTimeout(() => {
        //     let chartdata = $('#clo_chart_div').html();
        //     $('#clo_chart').val(chartdata);
        // }, 2000);
        setTimeout(() => {
            let chartDiv = document.getElementById('clo_chart_div');
            html2canvas(chartDiv).then(canvas => {
                let chartData = canvas.toDataURL('image/png');
                document.getElementById('clo_chart').value = chartData;

                // Enable the export button after chart data is ready
                document.getElementById('export_button').disabled = false;
            });
        }, 2000);
         <?php } ?>
    </script>



    @endsection

