




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLO's Attainment</title>
    <style>
        /* PDF PAGE SETTINGS */
        @page {
            size: A3 landscape;
            margin: 5mm;
        }

        /* BODY */
        body{
            font-family: sans-serif;
            margin:0;
            padding:0;
        }

        /* HEADER */
        .header{
            text-align:center;
            padding:4px;
        }

        /* CONTENT */
        .content{
            padding:10px;
        }

        /* TABLE WRAPPER */
        .table-container{
            width:100%;
            overflow:hidden;
        }

        /* SCALE TABLE TO FIT PAGE */
        .table-scale{
            transform:scale(0.75);
            transform-origin:top left;
            width:133%;
        }

        /* TABLE */
        table{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
            font-size:7px;
        }

        /* TABLE CELLS */
        th,td{
            border:1px solid #ccc;
            padding:3px;
            text-align:center;
            vertical-align:middle;
            word-wrap:break-word;
        }

        /* HEADER CELLS */
        th{
            font-weight:bold;
        }

        /* FIRST TWO COLUMNS */
        td:first-child,
        th:first-child{
            width:90px;
            text-align:left;
        }

        td:nth-child(2),
        th:nth-child(2){
            width:120px;
            text-align:left;
        }

        /* PLO RESULT COLUMNS */
        .result-column{
            background:#e5ecec;
            font-weight:bold;
        }

        /* COLORS FOR ATTAINMENT */
        .attained{
            color:blue;
            font-weight:bold;
        }

        .not-attained{
            color:red;
            font-weight:bold;
        }

        /* FOOTER */
        .footer{
            text-align:center;
            position:fixed;
            bottom:0;
            width:100%;
        }

        /* REMOVE EXTRA SPACE */
        .zero-margin-padding{
            margin:0;
            padding:0;
        }

        .chart-container{
            width:100%;
            text-align:center;
            margin-top:5px;
        }

        .chart-container img{
            width:100%;
            height:auto;
        }
    </style>
</head>
<body>
    <div class="content">
        <img style="width: 150px;float: right;" src="data:image/png;base64,{{ base64_encode(file_get_contents('https://obe.riphah.edu.pk/assets/img/riphah-logo.png')) }}"/>
        <h4 class="zero-margin-padding">Class Room Combined Result(OBE) - PLO Attainment</h4>
        <h5 class="zero-margin-padding">Course : {{$courseoffer->course->code ?? ''}} - {{$courseoffer->course->name ?? ''}}</h5>
        <h5 class="zero-margin-padding">Course Section : {{$courseoffer->course->code ?? ''}} - {{$courseoffer->sesssion->title ?? ''}}</h5>
        <h5 class="zero-margin-padding">Teacher : {{$courseoffer->teacher->name ?? ''}}</h5>
        <h5 class="zero-margin-padding">Semester : {{$courseoffer->sesssion->title ?? ''}}</h5>
        <h5>Session : {{$courseoffer->sesssion->title ?? ''}}</h5>

        <div class="table-container">
            <div class="table-scale">
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align:center; border:1px solid grey ">PLO</th>
                            <?php $p_i = 1;?>
                            <?php foreach($plos as $plo){?>
                                <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                    ->where('plo_id', $plo->plo_id)
                                                                    ->groupBy('clo_id')
                                                                    ->get();
                                        $plo_code = $ploObject::select('id','code')->whereid($plo->plo_id)->first();
                                        ?>
                                    
                                        <?php $plocolspan = 0; foreach($clo_usedinplo as $clo){
                                            $clo_usedinquestion = $activityquestion::where('courseoffer_id', $id)
                                            ->where('clo_id', $clo->clo_id)
                                            ->count();
                                            $plocolspan += $clo_usedinquestion;
                                            
                                            $cqi_clo_usedinquestion = $cqiactivityquestion::where('courseoffer_id', $id)
                                            ->where('clo_id', $clo->clo_id)
                                            ->count();
                                            $plocolspan += $cqi_clo_usedinquestion;
                                            
                                        }?>
                                <th colspan="{{$plocolspan}}" style="text-align:center; border:1px solid grey; ">{{ $plo_code->code }}</th>
                                <th rowspan="5" style="text-align:center; border:1px solid grey;background-color:#e5ecec; "> Weighted Total</th>
                                <th rowspan="5" style="text-align:center; border:1px solid grey;background-color:#e5ecec; "> PLO<br>Achieved</th>
                                <?php $p_i++;?>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align:center;word-wrap: break-word; border:1px solid grey ">Activity</th>
                            <?php $a_i = 1;?>
                            <?php foreach($plos as $plo){?>
                                <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                    ->where('plo_id', $plo->plo_id)
                                                                    ->groupBy('clo_id')
                                                                    ->get();
                                        ?>
                                        <?php foreach($clo_usedinplo as $clo){?>
                                            <?php $questions = $activityquestion::with('classActivity')->select('id','activity_id')->where('courseoffer_id', $id)
                                                ->where('clo_id', $clo->clo_id)
                                                ->get();?>
                                        
                                            <?php foreach($questions as $q){?>
                                                <?php $assesment_name = $assesment::select('id','name')->where('id', $q->classActivity->assesment_id)
                                                ->first();
                                                ?>
                                                <th style="text-align:center; border:1px solid grey">{{$assesment_name->name}}</th>
                                            <?php } ?>
                                            
                                            <!-- Cqi -->
                                            <?php $cqiquestions = $cqiactivityquestion::with('cqiclassactivity')->select('id','cqi_activity_id')->where('courseoffer_id', $id)
                                                ->where('clo_id', $clo->clo_id)
                                                ->get();
                                                ?>
                                            <?php foreach($cqiquestions as $cq){?>
                                                
                                                <?php $cqiassesment = $assesment::select('id','name')->where('id', $cq->cqiclassactivity->assesment_id)
                                                ->first();
                                                ?>
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
                            <th colspan="2" style="text-align:center; border:1px solid grey ">OBE Weight %</th>
                            <?php $w_i = 1; $obe_weight='';?>
                            <?php foreach($plos as $plo){ ?>
                                    <?php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)
                                                                    ->where('plo_id', $plo->plo_id)
                                                                    ->groupBy('clo_id')
                                                                    ->get();
                                        ?>
                                    <?php $totalobeweight = 0; foreach($clo_usedinplo as $clo){?>
                                        <?php $questions = $activityquestion::select('id','activity_id','obe_weight')->where('courseoffer_id', $id)
                                            ->where('clo_id', $clo->clo_id)
                                            ->get();
                                            
                                            ?>

                                        <?php  foreach($questions as $q){
                                            if($q->obe_weight){
                                                $obe_weight = $q->obe_weight.'.00';
                                                $totalobeweight += $q->obe_weight;
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
                                                $totalobeweight += $cq->obe_weight;
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
                                                <th style="text-align:center; border:1px solid grey"></th>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)
                                        ->where('clo_id', $clo->clo_id)
                                        ->get();
                                        ?>
                                        <?php foreach($cqiquestions as $cq){?>
                                            <th style="text-align:center; border:1px solid grey"></th>
                                        <?php } ?>
                                    <th colspan="2" style="text-align:center; border:1px solid grey;background-color:#e5ecec; ">KPI 50%</th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th style="width:100px; text-align:left;">Registration No.</th>
                            <th style="width:100px; text-align:left;">Name</th>
                            
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
                                        <th style="width:10px; text-align:center;">{{$q->max_mark}}.00</th>
                                    <?php } ?>

                                    <?php $cqiquestions = $cqiactivityquestion::select('id','max_mark')->where('courseoffer_id', $id)
                                        ->where('clo_id', $clo->clo_id)
                                        ->get();
                                        ?>
                                        <?php foreach($cqiquestions as $cq){ ?>
                                            <th style="width:10px; text-align:center;"><a href="javascript:void(0);">{{$cq->max_mark}}.00</a></th>
                                        <?php } ?>

                                <?php } ?>
                                <th style="width:10px; text-align:center;background-color:#e5ecec;"></th>
                                <th style="width:10px; text-align:center;background-color:#e5ecec;"></th>
                                
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
        </div>
        <!-- Your other content goes here -->
    </div>
    <h5>PLO Attainment criteria in graph, 50% of Students. 50 of Marks for this Course Section</h5>
    <table style="width:100%">
        <thead>
            <tr>
                <th  style="padding:8px;text-align:left;border: 1px solid black;">PLO</th>
                <th  style="padding:8px;text-align:left;border: 1px solid black;">Total Students</th>
                <th  style="padding:8px;text-align:left;border: 1px solid black;">Number of Students Attained PLO Above 50%</th>
                <th  style="padding:8px;text-align:left;border: 1px solid black;">Percentage Above 50%</th>
                <th  style="padding:8px;text-align:left;border: 1px solid black;">Percentage Average</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($plo_data as $data) { ?>
                <tr>
                    <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['plo']; ?></td>
                    <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['total_students']; ?></td>
                    <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo $data['students_above_50']; ?></td>
                    <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo number_format($data['percentage_above_50'], 2) . '%'; ?></td>
                    <td style="padding:8px;text-align:left;border: 1px solid black;"><?php echo number_format($data['average_attainment'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <h5>PLO Attainment graph for this Course Section</h5>
   <div class="chart-container">
        <img src="{{ $plo_chart }}">
    </div>
   
</body>
</html>
