<style>
    body {
        font-size: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
        word-wrap: break-word;
    }
</style>
Student wise Program Outcome (PLO) Attainment <br>
<br>
Program :  {{ $program_name }} <br>
Session :  {{ $session }} <br>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Reg No</th>
            @foreach($prog_plos as $plo)
                <th>{{ $plo->code }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['reg_no'] }}</td>
                @foreach($prog_plos as $plo)
                    <td>
                        @if(isset($student['plos'][$plo->id]))
                            @php
                                $vals = $student['plos'][$plo->id];
                                $sum = array_sum($vals);
                                $count = count($vals);
                                $divisor = $count * 100;
                                $attainment = ($divisor > 0) ? round(($sum / $divisor) * 100, 2) : 0;
                            @endphp
                             {{-- {{ implode(', ', $vals) }} <br> --}}
                            <strong>{{ $attainment }}</strong>
                        @else
                            -
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

