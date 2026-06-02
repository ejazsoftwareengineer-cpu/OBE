<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Permissions</title>      
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
                                <li class="breadcrumb-item active">Permissions</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ route('addpermission') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Permission</a>
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
                                                <th>Name</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="profile.html" class="avatar"><img alt="" src="assets/img/profiles/avatar-09.jpg"></a>
                                                            <a href="#">{{ $permission->name  }} </a>
                                                        </h2>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                @if ($permission->status === 1) 
                                                                    <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                @else
                                                                <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                @endif
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="changeStatus('{{ route('changepermissionstatus') }}','{{$permission->id}}','1')"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('{{ route('changepermissionstatus') }}','{{$permission->id}}','0')"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{route('editpermission',$permission->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <!-- <a class="dropdown-item" href="javascript:void(0);" onclick="openDeleteModel('{{$permission->id}}')"><i class="fa fa-trash-o m-r-5"></i> Delete</a> -->
                                                            </div>
                                                        </div>
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
                                        <a href="javascript:void(0);" onclick="deleteData('{{ route('destroypermission') }}')" class="btn btn-primary continue-btn">Delete</a>
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

        @endsection
