<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PLO Attainment - {{ $course_offering->course->code ?? '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; font-size: 9px; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { float: right; width: 80px; }
        .summary-table th { background-color: #ddd; }
        .text-left { text-align: left !important; }
        .bg-light { background-color: #e5ecec; }
        .text-blue { color: blue; }
        .text-red { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://riphah.edu.pk/wp-content/uploads/2023/08/riphah-logo.png" class="logo" alt="Logo">
        <h2>Class Room Combined Result (OBE) - PLO Attainment</h2>
        <p><strong>Course:</strong> {{ $course_offering->course->code ?? '' }} - {{ $course_offering->course->name ?? '' }}</p>
        <p><strong>Teacher:</strong> {{ $course_offering->teacher->name ?? 'Not Selected' }}</p>
        <p><strong>Session:</strong> Spring 2025</p>
    </div>

    <!-- Table 1: Detailed PLO Attainment -->
    <table>
        <thead>
            <tr>
                <th rowspan="5" colspan="2">Registration No. / Name</th>
                @foreach($plos as $plo)
                    @php
                        $plo_code = $ploObject::where('id', $plo->plo_id)->first();
                        $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                            ->where('course_id', $course_id)->where('plo_id', $plo->plo_id)
                            ->groupBy('clo_id')->get();
                        $colspan = 0;
                        foreach($clo_usedinplo as $c) {
                            $colspan += $activityquestion::where('courseoffer_id', $id)->where('clo_id', $c->clo_id)->count();
                            $colspan += $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $c->clo_id)->count();
                        }
                    @endphp
                    <th colspan="{{ $colspan }}" style="background:#ddd">{{ $plo_code->code ?? 'PLO' }}</th>
                    <th rowspan="5" class="bg-light">Weighted Total</th>
                    <th rowspan="5" class="bg-light">PLO Achieved</th>
                @endforeach
            </tr>
            <tr>
                @foreach($plos as $plo)
                    @php
                        $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                            ->where('course_id', $course_id)->where('plo_id', $plo->plo_id)
                            ->groupBy('clo_id')->get();
                    @endphp
                    @foreach($clo_usedinplo as $clo)
                        @php
                            $questions = $activityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                        @endphp
                        @foreach($questions as $q)
                            <th>{{ $assesment::find($q->classActivity->assesment_id)->name ?? '--' }}</th>
                        @endforeach
                        @foreach($cqiquestions as $q)
                            <th>{{ $assesment::find($q->cqiclassactivity->assesment_id)->name ?? '--' }}</th>
                        @endforeach
                    @endforeach
                @endforeach
            </tr>
            <!-- Repeat other header rows if needed (Question, CLO, Weight) -->
            <tr>
                @foreach($plos as $plo)
                    @php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)->where('plo_id', $plo->plo_id)->groupBy('clo_id')->get(); @endphp
                    @foreach($clo_usedinplo as $clo)
                        @php
                            $questions = $activityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                        @endphp
                        @foreach($questions as $q) <th>{{ $q->question_name }}</th> @endforeach
                        @foreach($cqiquestions as $q) <th>{{ $q->question_name }}</th> @endforeach
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach($plos as $plo)
                    @php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)->where('plo_id', $plo->plo_id)->groupBy('clo_id')->get(); @endphp
                    @foreach($clo_usedinplo as $clo)
                        @php
                            $questions = $activityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $clo_code = $courseofferclo::where('id', $clo->clo_id)->first()->code ?? '';
                        @endphp
                        @foreach($questions as $q) <th>{{ $clo_code }}</th> @endforeach
                        @foreach($cqiquestions as $q) <th>CLO{{ $q->clo_id }}</th> @endforeach
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach($plos as $plo)
                    @php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)->where('plo_id', $plo->plo_id)->groupBy('clo_id')->get(); @endphp
                    @foreach($clo_usedinplo as $clo)
                        @php
                            $questions = $activityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                        @endphp
                        @foreach($questions as $q) <th>{{ $q->obe_weight ? $q->obe_weight.'.00' : '' }}</th> @endforeach
                        @foreach($cqiquestions as $q) <th>{{ $q->obe_weight ? $q->obe_weight.'.00' : '' }}</th> @endforeach
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach($plos as $plo)
                    @php $clo_usedinplo = $plobycoursesectionclo::select('clo_id')->where('course_id', $course_id)->where('plo_id', $plo->plo_id)->groupBy('clo_id')->get(); @endphp
                    @foreach($clo_usedinplo as $clo)
                        @php
                            $questions = $activityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                            $cqiquestions = $cqiactivityquestion::where('courseoffer_id', $id)->where('clo_id', $clo->clo_id)->get();
                        @endphp
                        @foreach($questions as $q) <th>{{ $q->max_mark }}.00</th> @endforeach
                        @foreach($cqiquestions as $q) <th>{{ $q->max_mark }}.00</th> @endforeach
                    @endforeach
                    <th colspan="2" class="bg-light">KPI 50%</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($enrolledstudent as $student)
                <tr>
                    <td class="text-left"><strong>{{ $student->student->registration_no }}</strong></td>
                    <td class="text-left">{{ $student->student->name }}</td>
                    @foreach($plos as $plo)
                        @php
                            $clo_usedinplo = $plobycoursesectionclo::select('clo_id')
                                ->where('course_id', $course_id)->where('plo_id', $plo->plo_id)
                                ->groupBy('clo_id')->get();
                            $questions = $StudentQuestionPloAttainment::where('courseoffer_id', $id)
                                ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                                ->select('question_id','cqi_question_id','question_flag')->distinct()->get();
                        @endphp
                        @foreach($questions as $q)
                            @php
                                $mark = $StudentQuestionPloAttainment::where('student_id', $student->student->id)
                                    ->whereIn('clo_id', $clo_usedinplo->pluck('clo_id'))
                                    ->where('question_flag', $q->question_flag)
                                    ->where('question_id', $q->question_id)
                                    ->where(function($query) use ($q) {
                                        $query->where('question_id', $q->question_id)
                                              ->orWhere('cqi_question_id', $q->cqi_question_id);
                                    })->first();
                            @endphp
                            <td>{{ $mark->obtained_marks ?? '-' }}</td>
                        @endforeach
                        @php
                            $plo_att = $StudentPloAttainment::where('student_id', $student->student->id)
                                ->where('plo_id', $plo->plo_id)->where('courseoffer_id', $id)->first();
                            $color = ($plo_att && $plo_att->achieved_flag == 'Y') ? 'blue' : 'red';
                            $flag = ($plo_att && $plo_att->achieved_flag == 'Y') ? 'Y' : 'N';
                        @endphp
                        <td class="bg-light" style="color:{{ $color }}">{{ $plo_att->weighted_total ?? '-' }}</td>
                        <td class="bg-light" style="color:{{ $color }}">{{ $flag }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Table 2: PLO Summary -->
    <h3>PLO Summary</h3>
    <table class="summary-table">
        <thead>
            <tr>
                <th>PLO</th>
                <th>Total Students</th>
                <th>Students ≥ 50%</th>
                <th>Percentage ≥ 50%</th>
                <th>Average (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plo_data as $item)
                <tr>
                    <td>{{ $item['plo'] }}</td>
                    <td>{{ $item['total_students'] }}</td>
                    <td>{{ $item['students_above_50'] }}</td>
                    <td>{{ $item['percentage_above_50'] }}%</td>
                    <td>{{ $item['average_attainment'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Chart -->
    <h3>PLO Attainment Chart</h3>
    <div style="text-align:center;">
        <img src="{{ $chartUrl }}" alt="PLO Attainment Chart" style="width:100%; max-width:900px;">
    </div>
</body>
</html>