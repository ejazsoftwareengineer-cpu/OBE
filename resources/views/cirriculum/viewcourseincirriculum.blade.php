<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Curriculum Courses</title>      

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
									<li class="breadcrumb-item active">Curriculum Courses</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
                    <!-- Data Table -->
                   
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0">
									<thead>
										<tr>
											<th>Course Name</th>
											<th>Course Code</th>
											<th>Curriculum Name</th>
											<th>Status</th>
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
                                            </tr>
                                            <?php } ?>

                                        <?php } ?>
									</tbody>
                                    
								</table>
							</div>
						</div>
					</div>
				</div>			
			</div>
        @endsection

        @section('script')

        @endsection

