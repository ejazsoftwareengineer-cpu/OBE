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
                        <!-- <div class=""> -->
                                <div class="card mb-0">
                                    <div class="review-header text-left">

                                        <div style="display: flex; justify-content: space-between; align-items: center;padding: 0px 0px 8px 0px;">
                                        <h4 style="margin: 0;">CLO's Attainment</h4>
                                        <form method="POST" action="{{ route('printCloAttainmentPdf') }}" target="_blank" class="mb-5" >
                                            @csrf
                                            <input type="hidden" id="clo_chart" name="clo_chart" >
                                            <input type="hidden" name="id" value="{{ $id }}" >
                                            <input  id="export_button"  type="submit" value="Export">
                                        </form>
                                    </div>
                                        <div class="table-container">
                                            <table class=" table-bordered table-stripped table-condensed">
                                               <thead>
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center;">CLO</th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                // Get distinct questions for CLO (both normal + CQI)
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('question_id','cqi_question_id')
                                                                    ->distinct()
                                                                    ->get();

                                                                $question_count = $questions->count();

                                                                // Get CLO Code
                                                                $clo_code = $courseofferclo::select('code')->whereId($clo->clo_id)->first();
                                                            ?>
                                                            <th class="sticky-header" colspan="{{ $question_count }}" style="text-align:center;">
                                                                {{ $clo_code->code ?? '-' }}
                                                            </th>
                                                            <th class="sticky-header" rowspan="4" style="text-align:center;background-color:#e5ecec;">Weighted Total</th>
                                                            <th class="sticky-header" rowspan="4" style="text-align:center;background-color:#e5ecec;">CLO<br>Achieved</th>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <!-- Activity Names -->
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center;">Activity</th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('activity_id','cqi_activity_id','question_id','cqi_question_id','question_flag')
                                                                    ->distinct()
                                                                    ->get();
                                                            ?>
                                                            <?php foreach($questions as $q): ?>
                                                                <?php if($q->question_flag == 1): ?>
                                                                    <th class="sticky-header" style="text-align:center;">
                                                                        {{ $q->activity->assesment_name ?? '-' }}
                                                                    </th>
                                                                <?php elseif($q->question_flag == 2): ?>
                                                                    <th class="sticky-header" style="text-align:center;">
                                                                        {{ $q->cqiActivity->assesment->name ?? '-' }}
                                                                    </th>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <!-- Question Names -->
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center;">Question</th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('question_id','cqi_question_id','question_flag')
                                                                    ->distinct()
                                                                    ->get();
                                                            ?>
                                                            <?php foreach($questions as $q): ?>
                                                                <th class="sticky-header" style="text-align:center;">
                                                                    {{ $q->question?->name ?? $q->cqiQuestion?->question_name ?? '-' }}
                                                                </th>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <!-- CLO Weight % -->
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center;">CLO Weight %</th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('obe_weight','question_flag','question_id','cqi_question_id')
                                                                    ->distinct()
                                                                    ->get();
                                                            ?>
                                                            <?php foreach($questions as $q): ?>
                                                                <th class="sticky-header" style="text-align:center;">
                                                                    {{ $q->obe_weight ?? 0 }}
                                                                </th>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <!-- KPI Row -->
                                                    <tr>
                                                        <th class="sticky-header" colspan="2" style="text-align:center;"></th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('question_id','cqi_question_id')
                                                                    ->distinct()
                                                                    ->get();
                                                            ?>
                                                            <?php foreach($questions as $q): ?>
                                                                <th class="sticky-header" style="text-align:center;"></th>
                                                            <?php endforeach; ?>
                                                            <th class="sticky-header" colspan="2" style="text-align:center;background-color:#e5ecec;">KPI 50%</th>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <!-- Max Marks -->
                                                    <tr>
                                                        <th style="width:210px;text-align:left;">Registration No.</th>
                                                        <th style="width:150px;text-align:left;">Name</th>
                                                        <?php foreach($clos as $clo): ?>
                                                            <?php
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('max_marks','question_flag','question_id','cqi_question_id')
                                                                    ->distinct()
                                                                    ->get();
                                                            ?>
                                                            <?php foreach($questions as $q): ?>
                                                                <td style="vertical-align:top;width:30px;text-align:center;">
                                                                    {{ $q->max_marks ?? 0 }}
                                                                </td>
                                                            <?php endforeach; ?>
                                                            <th style="width:30px;text-align:center;background-color:#e5ecec;"></th>
                                                            <th style="width:20px;text-align:center;background-color:#e5ecec;"></th>
                                                        <?php endforeach; ?>
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

                                                            <?php foreach($clos as $clo){ ?>

                                                                <?php
                                                                // Get all distinct questions for this CLO (same logic as THEAD)
                                                                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->select('question_id','cqi_question_id','question_flag')
                                                                    ->distinct()
                                                                    ->get();
                                                                ?>

                                                                <?php foreach($questions as $q){ ?>
                                                                    <?php
                                                                    // Get this student's marks for the current question
                                                                    $mark = $StudentQuestionAttainment::where('student_id', $student->student->id)
                                                                        ->where('clo_id', $clo->clo_id)
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
                                                                // ===== CLO Attainment (Weighted Total + Flag) =====
                                                                $clo_att = $StudentCloAttainment::where('student_id', $student->student->id)
                                                                    ->where('clo_id', $clo->clo_id)
                                                                    ->first();

                                                                $color = 'red';
                                                                $flag  = 'N';
                                                                if ($clo_att && $clo_att->achieved_flag == 'Y') {
                                                                    $color = 'blue';
                                                                    $flag  = 'Y';
                                                                }
                                                                ?>

                                                                <!-- Weighted Total -->
                                                                <td style="vertical-align: top;width:30px; text-align:center;background-color:#e5ecec;">
                                                                    <span style="color:{{ $color }}">{{ $clo_att->weighted_total ?? '-' }}</span>
                                                                </td>

                                                                <!-- CLO Achieved Flag -->
                                                                <td style="vertical-align: top;width:20px; text-align:center;background-color:#e5ecec;">
                                                                    <span style="color:{{ $color }}">{{ $flag }}</span>
                                                                </td>

                                                            <?php } // end CLO loop ?>
                                                        </tr>
                                                    <?php } // end student loop ?>
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
                                        $clo_data = []; // array to hold CLO stats
                                        ?>

                                        <table style="width:100%;border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">CLO</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Total Students</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Number of Students Attained CLO ≥ 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Percentage ≥ 50%</th>
                                                    <th style="padding:8px;text-align:left;border: 1px solid black;">Average Attainment (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($clos as $clo){ ?>
                                                    <?php
                                                    $clo_code = $courseofferclo::select('code')->whereId($clo->clo_id)->first();
                                                    $records = $StudentCloAttainment::where('courseoffer_id', $id)
                                                        ->where('clo_id', $clo->clo_id)
                                                        ->get();

                                                    $total_students = $records->count();
                                                    $students_above_50 = $records->where('achieved_flag','Y')->count();
                                                    $percentage_above_50 = $total_students > 0 
                                                        ? ($students_above_50 / $total_students) * 100 
                                                        : 0;
                                                    $average_attainment = $total_students > 0 
                                                        ? $records->avg('weighted_total') 
                                                        : 0;

                                                    // push to array
                                                    $clo_data[] = [
                                                        'clo' => $clo_code->code ?? '-',
                                                        'total_students' => $total_students,
                                                        'students_above_50' => $students_above_50,
                                                        'percentage_above_50' => round($percentage_above_50, 2),
                                                        'average_attainment' => round($average_attainment, 2),
                                                    ];
                                                    ?>
                                                    <tr>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $clo_code->code ?? '-' }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $total_students }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ $students_above_50 }}</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ number_format($percentage_above_50, 2) }}%</td>
                                                        <td style="padding:8px;text-align:left;border: 1px solid black;">{{ number_format($average_attainment, 2) }}</td>
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
            </div>

        </div>


    </div>

    @endsection

    @section('script')

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        
        <?php if($course_offering->locked == 1) { ?>
            window.onload = function() {
            document.getElementById('export_button').disabled = true;
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawCloChart);

            function drawCloChart() {
                var cloData = <?php echo json_encode($clo_data); ?>;
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
        setTimeout(() => {
            let chartDiv = document.getElementById('clo_chart_div');
            html2canvas(chartDiv).then(canvas => {
                let chartData = canvas.toDataURL('image/png');
                document.getElementById('clo_chart').value = chartData;
                document.getElementById('export_button').disabled = false;
            });
        }, 2000);
         <?php } ?>


              
                document.addEventListener("DOMContentLoaded", function () {
                    const lockBtn = document.getElementById("lockBtn");
                    const progressWrapper = document.getElementById("progressWrapper");
                    const progressBar = document.getElementById("progressBar");
// showLoader();
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
                        fetch("{{ route('lockassessment', $id) }}", {
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
                                }, 800);
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


