

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLO's Attainment</title>
    <style>
        @page {
            size: 30.5in 20in; /* Set the page size to letter (8.5 x 11 inches) */
            margin: 1cm; /* Set margins for the printed page */
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            /* background-color: #333; */
            color: #333;
            text-align: center;
            padding: 4px;
        }

        .content {
            padding: 20px;
        }

        .table-container {
            width: 100%; /* Set the width of the table container */
        }

        table {
            width: 100%; /* Set the width of the table */
            border-collapse: collapse; /* Ensure borders are collapsed */
            font-size: 10px; /* Set the font size for the entire table */
        }

        th, td {
            border: 1px solid #ddd; /* Add borders to table cells */
            padding: 8px; /* Add padding to table cells */
            text-align: left; /* Set text alignment */
            font-size: 10px; /* Set the font size for table header and data cells */
        }

        .footer {
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        .zero-margin-padding {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="content">
        <img style="width: 150px;float: right;" src="data:image/png;base64,{{ base64_encode(file_get_contents('https://obe.riphah.edu.pk/public/assets/img/riphah-logo.png')) }}"/>
        <h4 class="zero-margin-padding">Class Room Combined Result(OBE) - CLO Attainment</h4>
        <h5 class="zero-margin-padding">Course : {{$courseoffer->course->code ?? ''}} - {{$courseoffer->course->name ?? ''}}</h5>
        <h5 class="zero-margin-padding">Course Section : {{$courseoffer->course->code ?? ''}} - {{$courseoffer->sesssion->title ?? ''}}</h5>
        <h5 class="zero-margin-padding">Teacher : {{$courseoffer->teacher->name ?? ''}}</h5>
        <h5 class="zero-margin-padding">Semester : {{$courseoffer->sesssion->title ?? ''}}</h5>
        <h5>Session : {{ $courseoffer->sesssion->title ?? ''}}</h5>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center; border:1px solid grey; ">CLO</th>
                        <?php $c_i = 1;?>
                        <?php foreach($clos as $clo){?>
                            <?php $clo_usedinquestion = $activityquestion::where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->count();
                                ?>
                                <?php $cqi_clo_usedinquestion = $cqiactivityquestion::where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->count();
                                ?>
                            <th colspan="{{$clo_usedinquestion+$cqi_clo_usedinquestion}}" style="text-align:center; border:1px solid grey;; ">CLO{{$c_i}}</th>
                            <th rowspan="4" style="text-align:center; border:1px solid grey;;background-color:#e5ecec; "> Weighted Total</th>
                            <th rowspan="4" style="text-align:center; border:1px solid grey;;background-color:#e5ecec; "> CLO<br>Achieved</th>
                            <?php $c_i++;?>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center; border:1px solid grey; ">Activity</th>
                        
                        <?php foreach($clos as $clo){?>
                            <?php $questions = $activityquestion::with('classActivity')->select('id','activity_id')->where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->get();
                                ?>
                            <?php foreach($questions as $q){ $assesment = $q->classActivity->assesment ?? null; 
                                
                                    ?>
                                
                                <?php //$assesment_name = $assesment::select('id','name')->where('id', $assesment->name)
                                // ->first();
                                ?>
                                <th style="text-align:center;  border:1px solid grey;">{{ $q->classActivity->assesment_name ?? '-' }}</th>
                            <?php } ?>
                            
                            <!-- Cqi -->
                            <?php $cqiquestions = $cqiactivityquestion::with('cqiclassactivity')->select('id','cqi_activity_id')->where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->get();
                                ?>
                            <?php foreach($cqiquestions as $cq){ 
                                $cqiassesment =  $cq->cqiclassactivity->assesment;
                                ?>
                                
                                <?php // $cqiassesment = $assesment::select('id','name')->where('id', $cqiassesment->name)
                                ?>
                                <th style="text-align:center;  border:1px solid grey;"><a href="javascript:void(0);">{{ $cqiassesment->name }}</a></th>
                            <?php } ?>
                            <!-- End Cqi -->
                        <?php } ?>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center; border:1px solid grey; "></th>
                        <?php $q_i = 1;?>
                        <?php foreach($clos as $clo){?>
                            <?php $questions = $activityquestion::select('id','question_name','name')->where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->get();
                                ?>

                                <?php foreach($questions as $q){?>
                                    <th style="text-align:center; border:1px solid grey; ">{{$q->name}}</th>
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
                            <?php $q_i++;?>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center; border:1px solid grey; ">CLO Weight %</th>
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
                                    <th style="text-align:center; border:1px solid grey; ">{{$obe_weight}}</th>
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
                                    <th style="text-align:center; border:1px solid grey; "><a href="javascript:void(0);">{{$cqi_obe_weight}}</a></th>
                                <?php } ?>
                                        <!-- End Cqi -->
                            <?php $w_i++;?>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align:center; border:1px solid grey; "></th>
                        <?php $q_i = 1;?>
                        <?php foreach($clos as $clo){?>
                            <?php $questions = $activityquestion::select('id')->where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->get();
                                ?>
                                
                                <?php foreach($questions as $q){?>
                                    <th style="text-align:center; border:1px solid grey; "></th>
                                <?php } ?>
                                <!-- Cqi -->
                                <?php $cqiquestions = $cqiactivityquestion::select('id')->where('courseoffer_id', $id)
                                ->where('clo_id', $clo->clo_id)
                                ->get();
                                ?>
                                
                                <?php foreach($cqiquestions as $cq){?>
                                    <th style="text-align:center; border:1px solid grey; "></th>
                                <?php } ?>
                                    <!-- End Cqi -->
                                <th colspan="2" style="text-align:center; border:1px solid grey;;background-color:#e5ecec; "> KPI 50%</th>
                            <?php $q_i++;?>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th style="width:100px; text-align:left;">Registration No.</th>
                        <th style="width:100px; text-align:left;">Name</th>
                        
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
                                    <th style=" text-align:center;">{{$q->max_mark}}.00</th>
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
                                    <th style=" text-align:center;"><a href="javascript:void(0);">{{$cq->max_mark}}</a></th>
                                <?php } ?>
                                <!-- End Cqi -->
                                <th style=" text-align:center;background-color:#e5ecec;"></th>
                                <th style=" text-align:center;background-color:#e5ecec;"></th>
                            
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     
                    foreach($enrolledstudent as $student){?>
                        <tr>
                            <td style="vertical-align: top;width:100px; text-align:left;"><a>{{$student->student->registration_no}}</a></td>
                            <td style="vertical-align: top;width:100px; text-align:left;">{{$student->student->name}}</td>
                            <?php $s_i = 1;?>
                            <?php foreach($clos as $clo){?>
                                <?php $questions = $activityquestion::select('id','activity_id','obe_weight','max_mark')->where('courseoffer_id', $id)
                                    ->where('clo_id', $clo->clo_id)
                                    ->get();
                                    $totalAverageOutcome = 0;
                                    ?>
                                     <?php $weight=0; ?>
                                    <?php foreach($questions as $q){?>
                                        <?php $outcomes = $studentassessment::select('id','outcome')
                                            ->where('clo_id', $clo->clo_id)
                                            ->where('student_id', $student->student->id)
                                            ->where('question_id', $q->id)
                                            ->where('activity_id', $q->activity_id)
                                            ->where('courseoffer_id', $id)
                                            ->first();
                                            if($q->obe_weight && $outcomes !== null){
                                                $averageOutcome = ($outcomes->outcome / $q->max_mark) * $q->obe_weight;
                                                $totalAverageOutcome += $averageOutcome;

                                                $weight += $q->obe_weight;
                                            }
                                            ?>
                                        <td style="vertical-align: top;width:10px; text-align:center;">{{$outcomes->outcome ?? 0}} </td>
                                    <?php } ?>   
                                    <?php $cqiquestions = $cqiactivityquestion::select('id','cqi_activity_id','obe_weight','max_mark')->where('courseoffer_id', $id)
                                        ->where('clo_id', $clo->clo_id)
                                        ->get();
                                    ?>
                                    <?php foreach($cqiquestions as $cq){ ?>
                                        <?php $cqioutcomes = $cqistudentassessment::select('id','outcome')
                                            ->where('clo_id', $clo->clo_id)
                                            ->where('student_id', $student->student->id)
                                            ->where('cqi_question_id', $cq->id)
                                            ->where('cqi_activity_id', $cq->cqi_activity_id)
                                            ->where('courseoffer_id', $id)
                                            ->first();
                                            if($cq->obe_weight && $cqioutcomes !== null){
                                                $cqiaverageOutcome = ($cqioutcomes->outcome / $cq->max_mark) * $cq->obe_weight;
                                                $totalAverageOutcome += $cqiaverageOutcome;
                                                $weight += $cq->obe_weight;
                                            }
                                        ?>
                                        
                                        <td style="vertical-align: top;width:10px; text-align:center;">{{$cqioutcomes->outcome ?? ''}} </td>
                                    <?php } ?>

                                    <?php 
                                        if ($weight == 0) {
                                            $totalAverageOutcome_new = 0; // or set a default value
                                        } else {
                                            $totalAverageOutcome_new = ($totalAverageOutcome / $weight) * 100;
                                        }
                                
                                    ?>
                                    <?php    
                                        $color = 'red'; 
                                        $flag = 'N';
                                        if($totalAverageOutcome_new >= 50){
                                            $color = 'blue';
                                            $flag = 'Y';
                                        }
                                    ?>

                                    <td style="vertical-align: top;width:10px; text-align:center;background-color:#e5ecec;"> <span style="color:{{$color}}">{{ number_format($totalAverageOutcome_new, 2) }}</span></td>
                                    <td style="vertical-align: top;width:10px; text-align:center;background-color:#e5ecec;">{{$flag}}</td>
                                <?php $s_i++;?>
                            <?php } ?>
                        </tr>
                    
                    <?php } 
                    ?>
                </tbody>
            </table>
        </div>
        <style>
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
        </style>
       

        <h5>CLO Attainment criteria in graph, 50% of Students. 50 of Marks for this Course Section</h5>
        <table>
            <thead>
                <tr>
                    <th>CLO</th>
                    <th>Total Students</th>
                    <th>Number of Students Attained CLO Above 50%</th>
                    <th>Percentage Above 50%</th>
                    <th>Percentage Average</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clo_data as $data) { ?>
                    <tr>
                        <td><?php echo $data['clo']; ?></td>
                        <td><?php echo $data['total_students']; ?></td>
                        <td><?php echo $data['students_above_50']; ?></td>
                        <td><?php echo number_format($data['percentage_above_50'], 2) . '%'; ?></td>
                        <td><?php echo number_format($data['average_attainment'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>
        CLO Attainment graph for this Course Section
        </h5>
        <img src="{{ $clo_chart }}" alt="CLO Attainment Chart">
     
</body>
</html>
