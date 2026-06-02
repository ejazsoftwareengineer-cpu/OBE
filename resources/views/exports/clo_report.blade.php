<table border="1" style="border-collapse: collapse; width: 100%; border: 1px solid #000000;">
@php
    $questions_all = [];
    foreach($clos as $clo) {
        $questions_all[$clo->clo_id] = \App\Models\ActivityQuestion::with('classActivity')
            ->where('courseoffer_id', $id)
            ->where('clo_id', $clo->clo_id)
            ->get();
    }
    $colors = ['#d9edf7', '#dff0d8', '#fcf8e3', '#f2dede'];
@endphp
    <!-- TITLE SECTION (Rows 1-3) -->
    <tr>
        <td colspan="100" style="text-align:center; font-size:18px; font-weight:bold; height: 30px; vertical-align: middle; background-color: #f8f9fa;">
            CLO Attainment Report (Template for Marks Entry)
        </td>
    </tr>
    <tr>
        <td colspan="100" style="text-align:center; font-weight: bold; background-color: #f8f9fa;">
            Course: {{ $course_offering->course->name ?? '-' }} ({{ $course_offering->course->code ?? '-' }})
        </td>
    </tr>
    <tr>
        <td colspan="100" style="text-align:center; font-weight: bold; background-color: #f8f9fa;">
            Teacher: {{ $course_offering->teacher->name ?? '-' }}
        </td>
    </tr>

    <!-- METADATA SECTION (Rows 4-6) - Color coded by CLO -->
    <thead>
        <tr>
            <th colspan="2" style="background-color: #e2e3e5; border: 1px solid #000000; font-weight: bold;">Activity ID</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="border: 1px solid #000000; background-color: {{ $bgColor }};">{{ $q->id ?? '-' }}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            <th colspan="2" style="background-color: #e2e3e5; border: 1px solid #000000; font-weight: bold;">Question ID</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="border: 1px solid #000000; background-color: {{ $bgColor }};">{{ $q->id ?? '-' }}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            <th colspan="2" style="background-color: #e2e3e5; border: 1px solid #000000; font-weight: bold;">CLO ID</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="border: 1px solid #000000; background-color: {{ $bgColor }};">{{ $clo->clo_id }}</th>
                @endforeach
            @endforeach
        </tr>

        <!-- VISIBLE HEADER SECTION (Rows 7-12) -->
        <tr>
            <th colspan="2" style="text-align:center; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">CLO SECTION</th>
            @foreach($clos as $index => $clo)
                @php
                    $bgColor = $colors[$index % 4];
                    $question_count = count($questions_all[$clo->clo_id]);
                    $clo_code = \App\Models\CourseOfferClo::select('code')->whereId($clo->clo_id)->first();
                @endphp
                <th colspan="{{ $question_count }}" style="text-align:center; background-color: {{ $bgColor }}; border: 2px solid #000000; font-weight: bold; font-size: 14px;">
                    {{ $clo_code->code ?? '-' }}
                </th>
            @endforeach
        </tr>

        <!-- Row 8: Activity Names -->
        <tr>
            <th colspan="2" style="text-align:center; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Activity</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="text-align:center; background-color: {{ $bgColor }}; font-weight: bold; border: 1px solid #000000;">
                        {{ $q->classActivity->assesment_name ?? '-' }}
                    </th>
                @endforeach
            @endforeach
        </tr>

        <!-- Row 9: Question Names -->
        <tr>
            <th colspan="2" style="text-align:center; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Question</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="text-align:center; background-color: {{ $bgColor }}; font-weight: bold; border: 1px solid #000000;">
                        {{ $q->question_name ?? '-' }}
                    </th>
                @endforeach
            @endforeach
        </tr>

        <!-- Row 10: CLO Weight % -->
        <tr>
            <th colspan="2" style="text-align:center; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">CLO Weight %</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="text-align:center; background-color: {{ $bgColor }}; border: 1px solid #000000;">
                        {{ $q->obe_weight ?? 0 }}
                    </th>
                @endforeach
            @endforeach
        </tr>

        <!-- Row 11: Empty row -->
        <tr>
            <th colspan="2" style="text-align:center; background-color: #f2f2f2; border: 1px solid #000000;"></th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="text-align:center; border: 1px solid #000000; background-color: {{ $bgColor }};"></th>
                @endforeach
            @endforeach
        </tr>

        <!-- Row 12: Max Marks header line -->
        <tr>
            <th style="text-align:left; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Registration No.</th>
            <th style="text-align:left; background-color: #f2f2f2; font-weight: bold; border: 1px solid #000000;">Name</th>
            @foreach($clos as $index => $clo)
                @php $bgColor = $colors[$index % 4]; @endphp
                @foreach($questions_all[$clo->clo_id] as $q)
                    <th style="text-align:center; background-color: {{ $bgColor }}; font-weight: bold; border: 1px solid #000000;">
                        {{ $q->max_mark ?? 0 }}
                    </th>
                @endforeach
            @endforeach
        </tr>
    </thead>

    <!-- BODY SECTION (Row 13+) -->
    <tbody>
        @foreach($enrolledstudent as $student)
            <tr>
                <td style="border: 1px solid #000000; padding: 5px; background-color: #ffffff;">{{ $student->student->registration_no ?? '-' }}</td>
                <td style="border: 1px solid #000000; padding: 5px; background-color: #ffffff;">{{ $student->student->name ?? '-' }}</td>

                @foreach($clos as $index => $clo)
                    @php $bgColor = $colors[$index % 4]; @endphp
                    @foreach($questions_all[$clo->clo_id] as $q)
                        @php
                            // Fetch outcome using ActivityQuestion ID
                            $outcome = $standard_assessments[$student->student_id][$q->id][$clo->clo_id][0]->outcome ?? '';
                        @endphp
                        <td style="text-align:center; border: 1px solid #000000; background-color: {{ $bgColor }};">
                            {{ $outcome }}
                        </td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
 