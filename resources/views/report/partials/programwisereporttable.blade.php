<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Program PLO Report</h5>
        <small>Program: {{ $program_name }} | Session: {{ $session }}</small>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reg No</th>
                    @foreach($prog_plos as $plo)
                        <th>{{ $plo->title ?? 'PLO '.$plo->id }}</th>
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
                                    {{ implode(", ", $student['plos'][$plo->id]) }} %
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
