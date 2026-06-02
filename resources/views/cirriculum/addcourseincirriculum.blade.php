<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Course Curriculum</title>      
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <style>
            .drag_side_panel {
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
                background-color: #f9f9f9;
            }
            .side-panel {
                list-style-type: none;
                padding: 0;
            }
            .side-panel li {
                padding: 10px;
                border-bottom: 1px solid #ddd;
                cursor: pointer;
            }
            .side-panel li:hover {
                background-color: #f1f1f1;
            }
            .side-panel li a {
                text-decoration: none;
                color: #333;
                display: block;
            }
            .button-group {
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
            .button-group button {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
            }
            .button-group button i {
                pointer-events: none;
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
									<li class="breadcrumb-item active">Add Course in Curriculum</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="container">
                        <div class="row mt-5">
                            <div class="col-xl-6">
                                <div class="form-group row">
                                    <label for="semester" class="col-lg-3 col-form-label">Select Semester</label>
                                    <div class="col-lg-9">
                                        <!-- <select id="semester" name="semester" class="form-control" onchange="getCourse('{{route('getcoursebysemester')}}')"> -->
                                        <select id="semester" name="semester" class="form-control">
                                            <option value="" selected>- Select -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                        <span class="text-danger" id="span_semester"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <input type="hidden" name="cirriculum_id" id="cirriculum_id" value="{{$cirriculum->id}}"/>
                            <input type="hidden" name="course" id="course"/>
                            <input type="hidden" name="deleted_course" id="deleted_course"/>

                            <!-- <div class="col-sm-5">
                                <div class="drag_side_panel">
                                    <ul class="side-panel course_side_bar" style="height: 500px; overflow-y: auto;">
                                        @foreach ($course as $cou)
                                            <li class="team_members" id="{{$cou->id}}" value="1">
                                                <a id="{{$cou->id}}" onclick="changecolor('{{$cou->id}}')">{{ $cou->name . ' (' . $cou->code . ')' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div> -->
                            <div class="col-sm-5">
                                <input type="text" id="search" placeholder="Search for courses..." onkeyup="filterCourses()" style="width: 100%; margin-bottom: 10px; padding: 5px; box-sizing: border-box;">
                                <div class="drag_side_panel">
                                    <ul class="side-panel course_side_bar" id="courseList" style="height: 500px; overflow-y: auto;">
                                        @foreach ($course as $cou)
                                            <li class="team_members" id="{{$cou->id}}" value="1">
                                                <a id="{{$cou->id}}" onclick="changecolor('{{$cou->id}}')">{{ $cou->name . ' (' . $cou->code . ')' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                            <div class="col-sm-2 text-center">
                                <div class="button-group mt-5">
                                    <button id="add_team" class="btn btn-primary btn-sm middle_add_button"><i class="fas fa-plus"></i></button>
                                    <button id="delete_team" class="btn btn-danger btn-sm middle_remove_button"><i class="fas fa-minus"></i></button>
                                    <button type="button" id="save_course_cirri" class="btn btn-success btn-sm middle_add_button" onclick="save_data('{{route('addcoursecirriculum')}}')"><i class="fas fa-save"></i></button>
                                    <button type="button" onclick="window.location='{{ route("managecirriculum") }}'" class="btn btn-danger btn-sm middle_remove_button"><i class="fas fa-times"></i></button>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="drag_side_panel">
                                    <ul class="side-panel course_side_bar added_team_members_temp" id="added_team_members_temp" style="height: 500px; overflow-y: auto;">
                                    </ul>
                                </div>
                                <span class="text-danger" id="span_course"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h5 class="mt-4"> Curriculum Courses </h5>
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Course Code</th>
                                            <th>Curriculum Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cirriculum_course as $ccs) { ?>
                                            <tr>
                                                <th> Semester {{ $ccs }}</th>
                                            </tr> 
                                            
                                            <?php  $c_course = $CirriculumCourseObject::with(['cirriculum','course'])->where('semester', $ccs)->wherecirriculum_id($id)->get(); ?>
                                            
                                            <?php foreach ($c_course as $cc) { ?>

                                            <tr>
                                                <?php if($cc->course) {?> 
                                                    <td><a >{{ $cc->course->name }}</a></td>
                                                <?php }else{?>
                                                    <td>-</td>
                                                <?php }?>

                                                <?php if($cc->course) {?> 
                                                    <td><a >{{ $cc->course->code }}</a></td>
                                                <?php }else{?>
                                                    <td>-</td>
                                                <?php }?>

                                                <?php if($cc->cirriculum) {?> 
                                                    <td><a >{{ $cc->cirriculum->name }}</a></td>
                                                <?php }else{?>
                                                    <td>-</td>
                                                <?php }?>

                                                <td>
                                                    <?php if($cc->course) {?> 
                                                        <?php if($cc->course->status == 1) {?>
                                                            <span class="badge bg-inverse-success">Active</span>
                                                        <?php }else {?>
                                                                <span class="badge bg-inverse-danger">InActive</span>
                                                        <?php }?>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right">
                                                    <a class="btn btn-primary btn-sm" style="color: white;"  onclick="openDeleteModel('{{$cc->id}}')">Remove</a>
                                                </td>

                                            </tr>
                                            <?php } ?>

                                        <?php } ?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
				</div>		
                <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Remove Course from Road-Map</h3>
                                    <p>Are you sure want to remove course?</p>
                                </div>
                                <input type="hidden" name="id" value="" id="delete_id">
                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="javascript:void(0);" onclick="deleteData('{{ route('removecoursecirriculum') }}')" class="btn btn-primary continue-btn">Remove</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
			</div>
        @endsection

        @section('script')
        <!-- script for drag drop list by button -->
        <script>
            $(document).on('click','#add_team',function(e){
                e.preventDefault();
                //$('#added_team_members_temp').css('display','block');
                var id = $(".team_members .active").attr('id');
                var name = $(".team_members .active").text();
                id = id+'abc';
                send_id = "'"+id+"'";
                var function_id = $('#added_team_members_temp li').map(function () {
                    return $.trim($(this).children("a").attr('id'));
                }).get();

                if (id == undefined)
                    return false;

                if ($.inArray(id, function_id) != -1)
                {

                } else{
                    
                    let courses = $("#course").val();
                    if(courses){ 
                        $("#course").val(courses+','+id);
                    }else{
                        $("#course").val(id);
                    }
                    
                    $("#added_team_members_temp").append('<li type="text" id="'+id+'" class="team_temp_members"><a class="" onclick="changecolor('+send_id+')">'+name+'</a></li>');
                }
                /*
                    var id = $(this).val();
                    var name = $(this).text();
                    var input_data = '<li type="text" id="'+id+'" class="team_temp_members"><a href="#" class="" id="'+id+'">'+name+'<span class="remove_team_temp_members"  style="float:right;">Ã—</span></a></li>'; 
                    $('#added_team_members_temp').append(input_data); 
                */
            });

            $(document).on("click", ".team_temp_members a", function () {
                $(".team_members a").removeClass("active");
                $(this).addClass("active");
            });

            $(document).on("click", ".team_members a", function () {
                //    $("a").removeClass("active");
                //    $(this).children("a").addClass("active");
                $(".team_members a").removeClass("active");
                $(this).addClass("active");
            });

            var delete_team_id = [];
            $(document).on("click", "#delete_team", function (e) {
                e.preventDefault();
                var ele = $(".team_temp_members .active").closest('li').remove();
                delete_team_id.push( ele.attr('val'));
                    let course = $("#course").val();
                    if(course){
                        courses = course.split(',');
                    }
                    let course_array = '';
                    let checker = 0;
                    const deleted_id = $("#deleted_course").val();
                    for (let index = 0; index < courses.length; index++) {
                        if(deleted_id != courses[index]){
                            if(index == 0){
                                course_array += courses[index];
                            }else{
                                if(checker == courses.length ){
                                    course_array = course_array.split(',');
                                    if(course_array.length == 1){
                                        course_array = courses[index];
                                    }else{
                                        course_array += ','+courses[index];
                                    }
                                }else{
                                    course_array += ','+courses[index];
                                }
                            }
                        }
                        checker++;
                    }
                    $("#course").val(course_array);
            });

            var global = '';
            function changecolor(option){
                
                $("#"+option).css("background-color","yellow");
                $("#deleted_course").val(option);
                if(!global){
                    global = option;
                }else{
                    $("#"+global).css("background-color","white");
                    global = option;
                }
            }

            function save_data(siteurl){
                let courses_values = $("#course").val();
                let semester = $("#semester").val();
                if(!semester) 
				{
					$('#span_semester').text('Please Select Semester');
				}
				
                let cirriculum_id = $("#cirriculum_id").val();

                if(courses_values && semester && cirriculum_id){
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });     
                    $.ajax({
                        type: "POST",
                        url: siteurl,
                        data: {
                            courses_values: courses_values,
                            semester: semester,
                            cirriculum_id: cirriculum_id,
                        },
                        success: function(response){
                            location.reload();
                        }
                    });
                }else{
                    if(!courses_values){
                        $('#span_course').text('Course is not selected');
                    }else if(!semester){
                        $('#span_semester').text('Please Select Semester');
                    }else{
                        $('#span_course').text('Course is not selected');
                        $('#span_semester').text('Please Select Semester');
                    }
                }
            }


            function getCourse(siteurl){
					jQuery.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						}
					});   
                    const semester = $('#semester').val();
					const cirriculum_id = $('#cirriculum_id').val();  
					$.ajax({
						type: "POST",
						url: siteurl,
						data: {
							id: semester,
							cirriculum_id: cirriculum_id,
							flag: 'li',
						},
						success: function(response){
                            $('#added_team_members_temp').html(response);
						}
					});
				}


                function filterCourses() {
                    // Get the value of the search input field
                    var input = document.getElementById('search');
                    var filter = input.value.toLowerCase();
                    
                    // Get the ul element containing the course list
                    var ul = document.getElementById("courseList");
                    
                    // Get all the li elements inside the ul
                    var li = ul.getElementsByTagName('li');
                    
                    // Loop through all list items and hide those that don't match the search query
                    for (var i = 0; i < li.length; i++) {
                        var a = li[i].getElementsByTagName("a")[0];
                        if (a.innerHTML.toLowerCase().indexOf(filter) > -1) {
                            li[i].style.display = "";
                        } else {
                            li[i].style.display = "none";
                        }
                    }
                }


        </script>

        @endsection

