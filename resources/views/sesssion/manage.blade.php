<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Sesssion</title>
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
                                <li class="breadcrumb-item active">Sesssion</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                        <?php if($edit_permission == true || $check_all_permission == true){ ?>
                            <!-- <th class="text-right">Actions</th>  -->
                            <a href="{{ route('addsession') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Session</a>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                <div class="alert alert-success alert-dismissible">
                    <strong>Alert!</strong> System Have Only One <strong>Active</strong> Session.
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card mb-0">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="sesssion-datatable" class="yajra-datatable table table-stripped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th class="text-right">Duration</th>
                                                <th class="text-right">Type</th>
                                                <th class="text-right">Status</th>
                                                <?php if($edit_permission == true || $check_all_permission == true){ ?><th class="text-right">Actions</th> <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
            
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
                        ajax: "{{ route('getsesssions') }}",
                        columns: [
                            {data: 'title', name: 'title'},
                            {data: 'duration', name: 'duration'},
                            {data: 'type', name: 'type'},
                            {data: 'status', name: 'status'},
                            <?php if($edit_permission == true || $check_all_permission == true){ ?>
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                            <?php } ?>
                        ],
                    });
                });
            </script>
        @endsection
