<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Roles</title>
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
                                <li class="breadcrumb-item active">Roles</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ route('addrole') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Role</a>
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
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="#">{{ $role->name  }} </a>
                                                        </h2>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                @if ($role->status === 1)
                                                                    <i class="fa fa-dot-circle-o text-purple"></i> Active
                                                                @else
                                                                <i class="fa fa-dot-circle-o text-info"></i>InActive
                                                                @endif
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="changeStatus('{{ route('changerolestatus') }}','{{$role->id}}','1')"><i class="fa fa-dot-circle-o text-purple"></i> Active</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="changeStatus('{{ route('changerolestatus') }}','{{$role->id}}','0')"><i class="fa fa-dot-circle-o text-info"></i> Inactive</a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="text-right">
                                                        <a class="btn btn-success btn-sm" href="{{route('editrole',$role->id)}}">Edit</a>
                                                        <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="openPermissionModel('{{route('rolehaspermission')}}','{{$role->id}}')">Permission</a>
                                                        <!-- <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="{{route('editrole',$role->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="openPermissionModel('{{route('rolehaspermission')}}','{{$role->id}}')"><i class="fa fa-pencil m-r-5"></i> Permission</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="openDeleteModel('{{$role->id}}')"><i class="fa fa-trash-o m-r-5"></i> Delete</a> 
                                                            </div>
                                                        </div> -->
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


            <!-- Edit User Modal -->
				<div id="manage_permission" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Manage Permission</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
                                <div class="table-responsive m-t-15">
                                    <table class="table table-striped custom-table">
                                        <input type="hidden" name="id" value="" id="role_id">
                                        <thead>
                                            <tr>
                                                <th>Module Permission</th>
                                                <th class="text-center">All</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Write</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="permissiontable">

                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div>
					</div>
				</div>
			<!-- /Edit User Modal -->

        </div>
        <!-- /Page Wrapper -->
        @endsection

        @section('script')
            <script>
                $('#manage_permission').on('hidden.bs.modal', function () {
                    location.reload();
                })
                
            </script>
        @endsection
