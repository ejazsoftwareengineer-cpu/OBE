@extends('layouts.backend.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Course Status Report</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('status.report') }}" id="validationForm">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Institute</label>
                                        <div class="col-lg-9">
                                            <select id="institute_id" name="institute_id" class="select" onchange="getProgram('{{route('getinstitutebyprogram')}}')">
                                                <option value="">- Select -</option>
                                                @foreach ($institute as $ins)
                                                    <option value="{{ $ins->id }}" {{ request('institute_id') == $ins->id ? 'selected' : '' }}>{{ $ins->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Programs</label>
                                        <div class="col-lg-9">
                                            <select id="program_id" name="program_id" class="select">
                                                <option value="">- Select -</option>
                                                {{-- AJAX will populate this or keep existing selection if available --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Session <span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <select name="session_id" class="select">
                                                <option value=""> Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>{{ $session->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-info">View Report</button>
                                <a href="{{ route('managereport') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        
                    </div>

                    @if(!empty($courseOffers))
                    <div class="card-body border-top">
                        <div class="row mb-3">
                            <div class="col text-right">
                                <button type="submit" name="export" value="1" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export to Excel
                                </button>
                            </div>
                        </div>
                        </form> {{-- Close form here to include export button --}}
                        <div id="reportResult" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Code</th>
                                        <th>Section</th>
                                        <th>Instructor</th>
                                        <!-- <th>CLOs</th> -->
                                      
                                        <th class="text-center">Enrolled Students</th>
                                        <th class="text-center">Questions</th>
                                        <th class="text-center">Students Attempt (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courseOffers as $offer)
                                        <tr>
                                            <td class="text-nowrap"><strong>{{ $offer->course->name ?? $offer->name }}</strong></td>
                                            <td>{{ $offer->course->code ?? '-' }}</td>
                                            <td>{{ $offer->section }}</td>
                                            <td>{{ $offer->teacher->name ?? '-' }}</td>
                                            <!-- <td style="max-width: 200px; overflow-wrap: break-word;">{{ $offer->clo_codes ?: 'N/A' }}</td> -->
                                             <td class="text-center">{{ $offer->total_enrolled }}</td>
                                            <td class="text-center">{{ $offer->total_questions }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $offer->attempt_percentage >= 70 ? 'badge-success' : ($offer->attempt_percentage >= 40 ? 'badge-warning' : 'badge-danger') }}" style="font-size: 0.9rem;">
                                                    {{ $offer->attempt_percentage }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    {{-- Fetch programs based on institute selection --}}
    function getProgram(siteurl){
        const id = $('#institute_id').val();
        if(id) {
            $.post(siteurl, {id: id, flag: 'option', _token: '{{ csrf_token() }}'}, function(data){
                $('#program_id').html(data);
            });
        }
    }

    {{-- Pre-load program if institute is already selected --}}
    $(document).ready(function() {
        const instituteId = $('#institute_id').val();
        if(instituteId) {
            const programId = "{{ request('program_id') }}";
            $.post("{{route('getinstitutebyprogram')}}", {id: instituteId, flag: 'option', _token: '{{ csrf_token() }}'}, function(data){
                $('#program_id').html(data);
                if(programId) {
                    $('#program_id').val(programId).trigger('change');
                }
            });
        }
    });
</script>
@endsection