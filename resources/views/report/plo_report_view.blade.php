<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>View Program PLO Report</title> 
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
        @extends('layouts.backend.app')

        @section('content')

            <div class="page-wrapper">
			
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">View Program PLO Report</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
                            <button type="button" onclick="window.location='{{ route('managereport') }}'" class="btn btn-danger">Cancel</button>
                            <button type="button" onclick="window.location='{{ route('programwiseplo') }}'" class="btn btn-danger">Back</button>
							<div class="card">
								

                                <?php if(!empty($students)){ ?>
                                    <div id="reportResult" class="mt-4">
                                      
                                        Program :  {{ $program_name ?? '-' }} <br>
                                        Session :  {{ $session ?? '-' }} <br>
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

                                                                        // Convert attainment to float
                                                                        $sum = array_sum(array_map(fn($v) => (float)$v['attainment'], $vals));
                                                                        $count = count($vals);
                                                                        $divisor = $count * 100;
                                                                        $attainment = ($divisor > 0) ? round(($sum / $divisor) * 100, 2) : 0;

                                                                        // Filter only those courses with attainment < 50
                                                                        $lowAttainmentCourses = array_filter($vals, fn($v) => (float)$v['attainment'] < 50);
                                                                    @endphp

                                                                    @if($attainment < 50)
                                                                        <a href="javascript:void(0)" 
                                                                        class="text-danger fw-bold view-details" 
                                                                        data-courses='@json(array_values($lowAttainmentCourses))'>
                                                                        {{ $attainment }}
                                                                        </a>
                                                                    @else
                                                                        <strong class="text-success">{{ $attainment }}</strong>
                                                                    @endif
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
                                <?php }else{ ?>
                                    No Data Found
                                <?php } ?>

							</div>
						</div>
					</div>
				
				</div>			
			</div>
            <!-- Course Details Modal -->
            <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-2xl shadow-lg">
                    
                    <!-- Modal Header -->
                    <div class="modal-header bg-warning text-dark rounded-top-2xl">
                        <h5 class="modal-title fw-bold" id="courseModalLabel">Low Attainment - Course Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p class="text-muted">Below are the courses contributing to this low attainment:</p>
                        <ul id="courseList" class="list-group list-group-flush"></ul>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-lg" data-bs-dismiss="modal">Close</button>
                    </div>

                    </div>
                </div>
                </div>

        @endsection

        @section('script')

            <script>
                function submitForm(type) {
                    const form = document.getElementById('validationForm');
                    // alert(1)
                    if (type === 'pdf') {
                        form.action = "{{ route('printprogramwisereportpdf') }}";
                        form.submit();
                    } else if (type === 'excel') {
                        form.action = "{{ route('printprogramwisereportexcel') }}";
                        form.submit();
                    } else if (type === 'view') {
                        form.action = "{{ route('printprogramwisereportview') }}";
                        form.submit();
                    }
                }
                function getProgram(siteurl){
                    const institute_id = $('#institute_id').val();
                    $('#program_id').html('');
                    getDropDownData(siteurl, institute_id, 'program',null);
                }
                function getDropDownData(siteurl, id, condition,cirriculum_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: id,
							cirriculum_id: cirriculum_id,
							flag: 'option',
						},
						success: function(response){
							if(condition ==='program'){
								$('#program_id').html(response);
							}
						}
					});
				}
                
document.addEventListener("DOMContentLoaded", function() {
    const modalElement = document.getElementById('courseModal');
    const courseModal = new bootstrap.Modal(modalElement);

    document.querySelectorAll(".view-details").forEach(function(el) {
        el.addEventListener("click", function() {
            let courses = JSON.parse(this.dataset.courses);
            let list = document.getElementById("courseList");
            list.innerHTML = "";

            if (courses.length === 0) {
                list.innerHTML = `<li class="list-group-item text-muted">No low attainment courses found.</li>`;
            } else {
                courses.forEach(function(c) {
                    let li = document.createElement("li");
                    li.className = "list-group-item d-flex justify-content-between align-items-center";
                    li.innerHTML = `
                        <span>
                            <strong>${c.course}</strong> 
                            (PLO: ${c.plo_code}) 
                            - Attainment: <span class="text-danger">${c.attainment}%</span>
                        </span>
                        <a href="https://obe.riphah.edu.pk/view-courseoffering/${c.course_offer}" 
                           target="_blank" class="btn btn-sm btn-outline-primary rounded-lg">
                            View
                        </a>
                    `;
                    list.appendChild(li);
                });
            }

            courseModal.show();
        });
    });
});
</script>


        @endsection
