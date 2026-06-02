<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="robots" content="noindex, nofollow">
        <title> Course Offering </title>      
        
        <style>
            .position-relative {
                position: relative;
            }

            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 2rem;
                color: rgba(0, 0, 0, 0.2);
                pointer-events: none;
                z-index: 1;
                text-align: center;
            }

            .disabled-link {
                pointer-events: none;
            }

            .form-group, .review-header {
                position: relative;
            }

            .review-header .watermark {
                font-size: 3rem;
            }
        </style>
        @extends('layouts.backend.app')

        @section('content')
        <!-- Page Wrapper -->
        <div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
            
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Offered Course</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Name : {{$course_offering->course->name ?? ' - '}} </li>
                            </ul>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Course Code : {{$course_offering->course->code ?? ' - '}}</li>
                            </ul>
                            
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Teacher : {{$course_offering->teacher->name ?? 'Not Selected'}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showcourseoffering',$id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showcourseofferingactivities',$id)}}" class="nav-link ">Class Activities</a></li>
                                <!-- <li class="nav-item"><a href="{{route('showcourseofferingclo',$id)}}" class="nav-link ">CLO List</a></li> -->
                                <li class="nav-item"><a href="{{route('showcourseofferingstudent',$id)}}" class="nav-link ">Students</a></li> 
                                <li class="nav-item"><a href="{{route('showenrolledstudentattendance',$id)}}" class="nav-link ">Mark Attendance</a></li>
                                <li class="nav-item"><a href="{{route('showenrolledstudentassessment',$id)}}" class="nav-link active">Mark Assessment</a></li>
                                <li class="nav-item"><a href="{{route('showecloattainment',$id)}}" class="nav-link ">CLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showeploattainment',$id)}}" class="nav-link ">PLO Attainment</a></li>
                                <li class="nav-item"><a href="{{route('showcqi',$id)}}" class="nav-link ">CQI</a></li>
                                <li class="nav-item"><a href="{{route('showweight',$id)}}" class="nav-link ">Adjust Weight</a></li>
                            </ul>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <x-alert></x-alert>
                <div class="tab-content">
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                   
                                <!-- <div class="container"> -->
                                    <!-- Download Template Section -->
                                    <!-- <div class="review-header text-center mt-2 mb-5 position-relative"> -->
                                        <!-- <h3 class="review-title">Lock Your Assessment</h3>
                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8 d-flex align-items-center">
                                                <label class="col-sm-9">
                                                    Please lock your assessment after entering student marks. 
                                                    Once locked, marks cannot be changed from the teacher portal. 
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <button id="lockBtn" class="btn btn-danger ml-2">
                                                    Lock Assessment
                                                </button>
                                            </div>
                                        </div> -->

                                        <!-- Progress Bar (hidden initially) -->
                                        <!-- <div id="progressWrapper" class="mt-4" style="display:none;">
                                            <div class="progress">
                                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                                    role="progressbar" style="width: 0%">0%</div>
                                            </div>
                                            <p class="mt-2">Processing... please wait</p>
                                        </div>
                                    </div> -->

                                    <!-- Download Template Section -->
                                    <div class="review-header text-center mt-2 mb-5 position-relative">
                                        <h3 class="review-title">Download Template</h3>
                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8 d-flex align-items-center">
                                                <label class="col-sm-9">Download the Excel template to enter and upload student's assessment marks. <span class="text-danger">*</span></label>
                                                <a href="{{route('downloadexceltesttemplate',$id)}}" class="btn btn-primary">Download Template</a>
                                                <!-- <a href="{{route('showweight',$id)}}" class="btn btn-primary disabled-link">Download Template</a> -->
                                            </div>
                                        </div>
                                        <!-- <div class="watermark">Coming Soon</div> -->
                                    </div>

                                    @if(auth()->user()->email === 'muhammad.ejaz@riphah.edu.pk')
                                    <!-- <div class="review-header text-center mt-2 mb-5 position-relative">
                                        <h3 class="review-title">Download Test Template</h3>

                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8 d-flex align-items-center">
                                                <label class="col-sm-9">
                                                    Download the Excel template to enter and upload student's assessment marks.
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <a href="{{ route('downloadexceltesttemplate', $id) }}" class="btn btn-primary">
                                                    Download Test Template
                                                </a>
                                            </div>
                                        </div>
                                    </div> -->
 <!-- Upload Excel Section -->
                                    <!-- <div class="review-header text-center mt-2 mb-5 position-relative">
                                        <h3 class="review-title">Upload Test Excel</h3>
                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8">
                                                <label class="col-sm-12">Upload the filled Excel file with all assessment marks <span class="text-danger">*</span></label>
                                                <form action="{{ route('uploadtestassessment') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                                    @csrf
                                                    
                                                    <input type="hidden" name="course_offer_id" value="{{ $id }}">
                                                    <input type="file" name="assessment_file"  class="form-control col-sm-8 mr-2" >
                                                    <button type="submit" class="btn btn-primary" >Upload</button>
                                                 <button type="submit" class="btn btn-primary disabled-link" disabled>Upload</button>  
                                                </form>
                                                
                                            </div>
                                        </div>
                                         <div class="watermark">Coming Soon</div>  
                                    </div> -->

                                    @endif
                                    
                                    <!-- Upload Excel Section -->
                                    <div class="review-header text-center mt-2 mb-5 position-relative">
                                        <h3 class="review-title">Upload Excel</h3>
                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8">
                                                <label class="col-sm-12">Upload the filled Excel file with all assessment marks <span class="text-danger">*</span></label>
                                                <form action="{{ route('uploadtestassessment') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                                    @csrf
                                                    
                                                    <input type="hidden" name="course_offer_id" value="{{ $id }}">
                                                    <input type="file" name="assessment_file"  class="form-control col-sm-8 mr-2" >
                                                    <button type="submit" class="btn btn-primary" >Upload</button>
                                                    <!-- <button type="submit" class="btn btn-primary disabled-link" disabled>Upload</button> -->
                                                </form>
                                                
                                            </div>
                                        </div>
                                        <!-- <div class="watermark">Coming Soon</div> -->
                                    </div>

                                    
                                <!-- </div> -->
                                <!-- Add Outcome Section -->
                                <div class="review-header text-center">
                                        <h3 class="review-title">Add Outcome (Manual)</h3>
                                        <div class="row mt-4 justify-content-center">
                                            <div class="form-group col-sm-8 d-flex align-items-center">
                                                <label class="col-sm-4">Select Class Activity <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select id="classactivity_id" class="form-control" onchange="getQuestion('{{route('getoutcomeviewbyactivity')}}','{{$id}}')">
                                                        <option value="">- Select Class Activity -</option>
                                                        @foreach ($classactivity as $ca)
                                                            <option value="{{ $ca->id }}">{{ $ca->assesment_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form  method="POST" action="{{ route('storeoutcome') }}" class="mb-5">
                                            @csrf
                                            <input type="hidden" name="classactivity_id" id="model-classactivity_id">
                                            <input type="hidden" name="courseoffer_id" value="<?=$id;?>">
                                            <div class="table-responsive" id="outcome-table">
                                                
                                            </div>
                                            
                                        </div>
                                    </div>

                                   
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View PEO -->
                </div>
            </div>
            <!-- /Page Content -->
            <!-- Modal -->
            
            <!-- / Modal -->

            
        </div>
        <!-- /Page Wrapper -->
        
        @endsection

        @section('script')
            <script>
				function getQuestion(siteurl,courseoffer_id){
					const classactivity_id = $('#classactivity_id').val();
					$('#outcome-table').html('');
					getDropDownData(siteurl, classactivity_id, courseoffer_id);
				}
				
				function getDropDownData(siteurl, classactivity_id, courseoffer_id){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});     
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: classactivity_id,
							courseoffer_id: courseoffer_id,
						},
						success: function(response){
                            $('#model-classactivity_id').val(classactivity_id);
                            $('#outcome-table').html(response);
						}
					});
				}

                                
                document.addEventListener("DOMContentLoaded", function () {
                    const lockBtn = document.getElementById("lockBtn");
                    const progressWrapper = document.getElementById("progressWrapper");
                    const progressBar = document.getElementById("progressBar");

                    lockBtn.addEventListener("click", function () {
                        // Show progress bar
                        progressWrapper.style.display = "block";
                        let progress = 0;

                        // Simulated progress animation
                        const interval = setInterval(() => {
                            if (progress >= 100) { // stop at 90 until request completes
                                clearInterval(interval);
                                 setTimeout(() => {
                                    location.reload();
                                }, 1000);

                                return;
                            } else {
                                progress += 10;
                                progressBar.style.width = progress + "%";
                                progressBar.textContent = progress + "%";
                            }
                        }, 400);

                        // Send actual request
                        fetch("{{ route('lockassessment', $id) }}", {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then(response => {
                            if (response.redirected) {
                                window.location.href = response.url; // redirect on success
                            }
                        })
                        .catch(() => {
                            alert("Something went wrong!");
                            progressWrapper.style.display = "none";
                        });
                    });
                });
				
			</script>
        @endsection
