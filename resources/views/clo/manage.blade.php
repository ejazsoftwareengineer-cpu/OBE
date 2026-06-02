<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Course Learning Outcomes</title>
        <style>
           
           table tbody>tr>:nth-child(2), 
           table tbody>tr>:nth-child(3),
           table tbody>tr>:nth-child(4),
           table tbody>tr>:nth-child(5),
           table tbody>tr>:nth-child(6) {
               text-align : right; !important
           }
       </style>
        @extends('layouts.backend.app')

        @section('content')

       <!-- Page Wrapper -->
        <div class="page-wrapper">
			
            <!-- Page Content -->
            <div class="content container-fluid">
                    
                <x-alert></x-alert>
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Course Learning Outcomes</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                                <a href="{{ route('addcourselearningoutcome') }}" class="btn add-btn "><i class="fa fa-plus"></i> Add CLO</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card mb-0">
                            <div class="card-body">
                            <div class="table-responsive">
                                    <table class="datatable table table-stripped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Program</th>
                                                <th>Course</th>
                                                <th class="text-right">CLO </th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $c)
                                                <tr>
                                                    <?php $course = $course_object::select('id','program_id','name','code')->whereid($c->course_id)->first(); 
                                                    // print_r($course->program_id);
                                                    // exit;
                                                    $program_id = $course->program_id ?? 'null';
                                                    ?>
                                                    <?php $program = $program_object::select('id','name')->whereid($program_id)->first(); ?>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="#">{{ $program->name ?? ' -'}} </a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="#">{{ $course->name ?? ''}} - {{ $course->code ?? ''}} </a>
                                                        </h2>
                                                    </td>
                                                    <?php $clos = $clo_object::select('id','code')->wherecourse_id($c->course_id)->get(); ?>
                                                    <td>

                                                        <?php $codes= []; foreach($clos as $clo){
                                                            $codes[] = $clo->code ?? '';?>
                                                        <?php } echo implode(',', $codes)?>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-success btn-sm" href="{{route('editcourselearningoutcome',$c->course_id)}}">Edit</a>
                                                        <a class="btn btn-primary btn-sm" href="{{route('showcourselearningoutcome',$c->course_id)}}">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
            
          <!-- Modal -->
          <!-- /Modal -->
            
        </div>
        <!-- /Page Wrapper -->
        @endsection

        @section('script')
        <script>
                // $(document).ready(function(){
                //     $.fn.dataTable.ext.errMode = 'none';
                //     var table = $('.yajra-datatable').DataTable({
                //         processing: true,
                //         serverSide: true,
                //         ajax: "{{ route('getclo') }}",
                //         columns: [
                //             {data: 'course', name: 'course'},
                //             {data: 'code', name: 'code'},
                //             {data: 'description', name: 'description'},
                //             {data: 'type', name: 'type'},
                //             {data: 'status', name: 'status'},
                //             {data: 'action', name: 'action', orderable: false, searchable: false},
                //         ],
                //     });
                    
                // });
            </script>
        @endsection
