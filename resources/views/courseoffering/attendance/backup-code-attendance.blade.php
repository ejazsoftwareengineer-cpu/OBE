                
            <?php 
            $studentAttendances = StudentAttendance::with(['student:id,name', 'course_offer'])
            ->where('course_offer_id', $id)
            ->whereNotNull('mark_date')
            ->orderBy('mark_date')
            ->get();

        $groupedByMarkDate = [];
        foreach ($studentAttendances as $attendance) {
            $markDate = $attendance->mark_date;
            if (!array_key_exists($markDate, $groupedByMarkDate)) {
                $groupedByMarkDate[$markDate] = [];
            }
            $groupedByMarkDate[$markDate][] = $attendance->toArray();
        }
        $mark_date = StudentAttendance::select('mark_date')->wherecourse_offer_id($id)->groupBy('mark_date')->get(); 
        $students = StudentAttendance::select('student_id')->wherecourse_offer_id($id)->get(); 
        
        return view('courseoffering.attendance.attendance',compact('id','students','mark_date','groupedByMarkDate')); ?>
                <div class="tab-content">

                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Course Students Attendance</h4>
                                    <div class="mb-2">
                                        <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#today_attendance_students"> Mark Today Attendence
                                        </a>
                                        <a href="{{ route('addstudent') }}" class="btn btn-info mr-2">
                                            <i class="fa fa-edit"></i> Mark Existing Attendance
                                        </a> 
                                    </div>
                                </div>    
                                <?php $studentIds = $students->pluck('student_id')->toArray(); ?>
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                @foreach ($groupedByMarkDate as $markDate => $attendances)
                                                    <th>{{ $markDate }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupedByMarkDate as $markDate => $attendances)
                                                @foreach ($attendances as $key => $attendance)
                                                    <tr>
                                                        <td>{{ $attendance['student']['name'] }}</td>
                                                        @foreach ($groupedByMarkDate as $date => $data)
                                                            <td>
                                                                <?php if ($markDate === $date && in_array($attendance['student']['id'], $studentIds)) {?>
                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info"><i class="fa fa-check text-success"></i></a> 
                                                                <?php }else{ ?>
                                                                    <i class="fa fa-close text-danger"></i>
                                                                <?php } ?>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View PEO -->
                </div>


                <!-- new old table -->



                <?php 
                $student_attendances = StudentAttendance::with(['student', 'course_offer'])
                ->where('course_offer_id', $id)
                ->orderBy('mark_date')
                ->get();
                ?>
                <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="d-flex justify-content-between align-items-center" style="padding: 10px 0px 0px 10px;">
                                        <h4 class="mb-0">Course Students Attendance</h4>
                                       
                                    </div>    
                                    
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Registration No.</th>
                                                        <th>Name</th>
                                                        <th>Section</th>
                                                        <th class="text-center">Student Status</th>
                                                        <th>Grade</th>
                                                        <th class="text-center">Mark Attendance </th>
                                                        <!-- <th>Mark Attendance </th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($student_attendances as $es)
                                                        <tr style="border-top: outset;">
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->student->registration_no  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->student->name  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $es->course_offer->section ?? '-'  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                    @if ($es->student->status === 1)
                                                                        <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                    @else
                                                                        <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#"> - </a>
                                                                </h2>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="checkbox-action">
                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox" class="attendance-checkbox" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','1','{{$id}}')" <?php echo $es->attendance === '1' ? 'checked' : ''; ?>>
                                                                        <span class="checkmark"></span> Present
                                                                    </label> |
                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox" class="attendance-checkbox" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','2','{{$id}}')" <?php echo $es->attendance === '2' ? 'checked' : ''; ?>>
                                                                        <span class="checkmark"></span> Absent
                                                                    </label> |
                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox" class="attendance-checkbox" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','0','{{$id}}')" <?php echo !in_array($es->attendance, ['1', '2']) ? 'checked' : ''; ?>>
                                                                        <span class="checkmark"></span> Pending
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <!-- <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                        <?php if($es->attendance === '1') {?>
                                                                            <i class="fa fa-dot-circle-o text-purple"></i> Present
                                                                        <?php } elseif($es->attendance === '2') {?>
                                                                            <i class="fa fa-dot-circle-o text-red"></i> Absent
                                                                        <?php } else {?>
                                                                            <i class="fa fa-dot-circle-o text-info"></i> Pending
                                                                        <?php }?>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','1','{{$id}}')"><i class="fa fa-dot-circle-o text-purple"></i> Present</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="changeAttendanceStatus('{{ route('changeattendencestatus') }}','{{$es->student->id}}','2','{{$id}}')"><i class="fa fa-dot-circle-o text-info"></i> Absent</a>
                                                                    </div>
                                                                </div>
                                                            </td> -->
                                                        </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

 <!-- <label class="radio-container mr-2" style="border: 1px solid gainsboro;">
                                <span class="radiomark"></span> Pending
                                <input type="radio" class="attendance-radio" name="attendance_<?=$ess->student->id;?>" onclick="changeAttendanceStatus('<?= route('changeattendencestatus');?>','<?= $ess->student->id;?>','0','<?=$id;?>', '<?= $mark_date;?>')" <?php echo $a->isEmpty() || !in_array($a->first()->attendance, ['1', '2']) ? 'checked' : ''; ?>>
                            </label> -->
                        