<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Program Educational Objective</title>
        <style>
           
           table tbody>tr>:nth-child(2), 
           table tbody>tr>:nth-child(3),
           table tbody>tr>:nth-child(4),
           table tbody>tr>:nth-child(5) {
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
                                <li class="breadcrumb-item active">Program Educational Objective</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                                <a href="{{ route('addprogrameducationobjective') }}" class="btn add-btn "><i class="fa fa-plus"></i> Add PEO</a>
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
                                                <th>PEO Code</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($program as $p)
                                                <tr>
                                                    <?php $programs = $program_object::select('id','name','institute_id')->whereid($p->program_id)->first(); ?>
                                                    
                                                    <td  class="text-left">
                                                        <h2 class="table-avatar">
                                                            <a href="#">{{ $programs->name ?? ''}}</a>
                                                        </h2>
                                                    </td>
                                                    <?php $peos = $peo_object::select('id','code')->whereprogram_id($p->program_id)->get(); ?>
                                                    <td class="text-left">

                                                        <?php $codes= []; foreach($peos as $peo){
                                                            $codes[] = $peo->code ?? '';?>
                                                        <?php } echo implode(',', $codes)?>
                                                    </td>
                                                   
                                                    <td class="text-right">
                                                        <a class="btn btn-success btn-sm" href="{{route('editprogrameducationobjective',$p->program_id)}}">Edit</a>
                                                        <a class="btn btn-primary btn-sm" href="{{route('showprogrameducationobjective',$p->program_id)}}">View</a>
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
            
            
            <!-- Delete Leave Modal 
            <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Leave</h3>
                                <p>Are you sure want to delete this leave?</p>
                            </div>
                            <input type="hidden" name="id" value="" id="delete_id">
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" onclick="deleteData('{{ route('destroyprogram') }}')" class="btn btn-primary continue-btn">Delete</a>
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
             /Delete Leave Modal -->
            
        </div>
        <!-- /Page Wrapper -->
        @endsection

        @section('script')
            <script>
                $(document).ready(function(){
                    $.fn.dataTable.ext.errMode = 'none';
                    var table = $('.yajra-datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('getpeo') }}",
                        columns: [
                            {data: 'program', name: 'program'},
                            {data: 'code', name: 'code'},
                            {data: 'description', name: 'description'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                        ],
                    });
                });
            </script>
        @endsection
