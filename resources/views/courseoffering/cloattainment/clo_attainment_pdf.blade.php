<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CLO Attainment PDF</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:3px; text-align:center; }
        th.sticky-header { background:#f0f0f0; }
        .text-left { text-align:left; }
        .blue { color:blue; }
        .red { color:red; }
        .bg-grey { background:#e5ecec; }
        .zoom-out {
            transform: scale(0.65);      /* Reduce size to 75% */
            transform-origin: top left;  /* Anchor scaling */
        }
    </style>
</head>

<body>
<div style="width: 100%; overflow: hidden; margin-bottom: 10px;">
    <img style="width: 150px;float: right;" src="data:image/png;base64,{{ base64_encode(file_get_contents('https://obe.riphah.edu.pk/assets/img/riphah-logo.png')) }}"/>
    <h4 class="zero-margin-padding">Class Room Combined Result (OBE) - CLO Attainment</h4>

    <h5 class="zero-margin-padding">
        Course: {{ $course_offering->course->code ?? '' }} - {{ $course_offering->course->name ?? '' }}
    </h5>

    <h5 class="zero-margin-padding">
        Teacher: {{ $course_offering->teacher->name ?? '' }}
    </h5>

    <h5 class="zero-margin-padding">
        Session: {{ $course_offering->sesssion->title ?? '' }}
    </h5>
</div>

<hr>
<div class="zoom-out">

<table>
    <thead>

    <!-- ROW 1: CLO Codes -->
    <tr>
        <th colspan="2" class="sticky-header" style="text-align:center;">CLO</th>
        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('question_id','cqi_question_id')
                    ->distinct()
                    ->get();
                $question_count = $questions->count();
                $clo_code = $courseofferclo::select('code')->whereId($clo->clo_id)->first();
            @endphp

            <th class="sticky-header" colspan="{{ $question_count }}" style="text-align:center;">
                {{ $clo_code->code ?? '-' }}
            </th>

            <th class="sticky-header" rowspan="4" style="text-align:center;background-color:#e5ecec;">Weighted Total</th>
            <th class="sticky-header" rowspan="4" style="text-align:center;background-color:#e5ecec;">CLO<br>Achieved</th>
        @endforeach
    </tr>

    <!-- ROW 2: Activity Names -->
    <tr>
        <th class="sticky-header" colspan="2" style="text-align:center;">Activity</th>

        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('activity_id','cqi_activity_id','question_flag','question_id','cqi_question_id')
                    ->distinct()
                    ->get();
            @endphp

            @foreach($questions as $q)
                <th class="sticky-header" style="text-align:center;">
                    @if($q->question_flag == 1)
                        {{ $q->activity->assesment_name ?? '-' }}
                    @else
                        {{ $q->cqiActivity->assesment->name ?? '-' }}
                    @endif
                </th>
            @endforeach
        @endforeach
    </tr>

    <!-- ROW 3: Question Names -->
    <tr>
        <th class="sticky-header" colspan="2" style="text-align:center;"></th>

        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('question_id','cqi_question_id','question_flag')
                    ->distinct()
                    ->get();
            @endphp

            @foreach($questions as $q)
                <th class="sticky-header" style="text-align:center;">
                    {{ $q->question->name ?? $q->cqiQuestion->question_name ?? '-' }}
                </th>
            @endforeach
        @endforeach
    </tr>

    <!-- ROW 4: CLO Weight % -->
    <tr>
        <th class="sticky-header" colspan="2" style="text-align:center;">CLO Weight %</th>

        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('obe_weight','question_flag','question_id','cqi_question_id')
                    ->distinct()
                    ->get();
            @endphp

            @foreach($questions as $q)
                <th class="sticky-header" style="text-align:center;">
                    {{ $q->obe_weight ?? 0 }}
                </th>
            @endforeach
        @endforeach
    </tr>

    <!-- ROW 5: KPI 50% -->
    <tr>
        <th class="sticky-header" colspan="2" style="text-align:center;"></th>

        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('question_id','cqi_question_id')
                    ->distinct()
                    ->get();
            @endphp

            @foreach($questions as $q)
                <th class="sticky-header" style="text-align:center;"></th>
            @endforeach

            <th class="sticky-header" colspan="2" style="text-align:center;background-color:#e5ecec;">KPI 50%</th>
        @endforeach
    </tr>

    <!-- ROW 6: Max Marks -->
    <tr>
        <th style="width:210px;text-align:left;">Registration No.</th>
        <th style="width:150px;text-align:left;">Name</th>

        @foreach($clos as $clo)
            @php
                $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                    ->where('clo_id', $clo->clo_id)
                    ->select('max_marks','question_flag','question_id','cqi_question_id')
                    ->distinct()
                    ->get();
            @endphp

            @foreach($questions as $q)
                <td style="width:30px;text-align:center;">
                    {{ $q->max_marks ?? 0 }}
                </td>
            @endforeach

            <th style="width:30px;text-align:center;background-color:#e5ecec;"></th>
            <th style="width:20px;text-align:center;background-color:#e5ecec;"></th>
        @endforeach
    </tr>

</thead>


   <tbody>
    @foreach($enrolledstudent as $student)
        <tr>
            <!-- Registration No -->
            <td style="vertical-align: top;width:210px;text-align:left;">
                {{ $student->student->registration_no }}
            </td>

            <!-- Student Name -->
            <td style="vertical-align: top;width:150px;text-align:left;">
                {{ $student->student->name }}
            </td>

            @foreach($clos as $clo)

                @php
                    $questions = $StudentQuestionAttainment::where('courseoffer_id', $id)
                        ->where('clo_id', $clo->clo_id)
                        ->select('question_flag','question_id','cqi_question_id')
                        ->distinct()
                        ->get();
                @endphp

                @foreach($questions as $q)
                    @php
                        $mark = $StudentQuestionAttainment::where('student_id', $student->student->id)
                            ->where('clo_id', $clo->clo_id)
                            ->where('question_flag', $q->question_flag)
                            ->where('question_id', $q->question_id)
                            ->where(function($query) use ($q) {
                                $query->where('question_id', $q->question_id)
                                      ->orWhere('cqi_question_id', $q->cqi_question_id);
                            })
                            ->first();
                    @endphp

                    <td style="vertical-align: top;width:30px;text-align:center;">
                        {{ $mark->obtained_marks ?? '-' }}
                    </td>
                @endforeach

                @php
                    $cloAtt = $StudentCloAttainment::where('student_id', $student->student->id)
                        ->where('clo_id', $clo->clo_id)
                        ->first();

                    $color = ($cloAtt && $cloAtt->achieved_flag == 'Y') ? 'blue' : 'red';
                    $flag = ($cloAtt && $cloAtt->achieved_flag == 'Y') ? 'Y' : 'N';
                @endphp

                <!-- Weighted Total -->
                <td style="vertical-align: top;width:30px;text-align:center;background-color:#e5ecec;">
                    <span style="color:{{ $color }}">{{ $cloAtt->weighted_total ?? '-' }}</span>
                </td>

                <!-- CLO Achieved -->
                <td style="vertical-align: top;width:20px;text-align:center;background-color:#e5ecec;">
                    <span style="color:{{ $color }}">{{ $flag }}</span>
                </td>

            @endforeach
        </tr>
    @endforeach
</tbody>

</table>
</div>

<br><br>

<h3>CLO Summary</h3>

<table>
    <thead>
        <tr>
            <th>CLO</th>
            <th>Total Students</th>
            <th>Students ≥ 50%</th>
            <th>Percentage ≥ 50%</th>
            <th>Average (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clo_data as $d)
            <tr>
                <td>{{ $d['clo'] }}</td>
                <td>{{ $d['total_students'] }}</td>
                <td>{{ $d['students_above_50'] }}</td>
                <td>{{ $d['percentage_above_50'] }}%</td>
                <td>{{ $d['average_attainment'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<h3>Attainment Chart</h3>
@if(!empty($chartImage))
    <div style="text-align:center; margin-bottom:20px;">
        <img src="{{ $chartImage }}" style="width: 90%; max-width:700px; height:auto;">
    </div>
@endif
</body>
</html>
