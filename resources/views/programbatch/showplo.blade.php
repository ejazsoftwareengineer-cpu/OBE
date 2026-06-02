<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title> PLO </title>      
        <style>
            tr {

                max-width: 60px !important;
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
                            <h3 class="page-title">PLO </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">PLO</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a href="{{route('showprogrambatch',$id)}}" class="nav-link ">View</a></li>
                                <li class="nav-item"><a href="{{route('showplo',$id)}}" class="nav-link active">PLO List</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                   
                    <div id="clo_view" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mb-0">
                                    <div class="col-auto float-right ml-auto" style="padding: 10px 10px 10px 10px;">
                                            <a href="{{ route('addplo',$id) }}" class="btn add-btn"><i class="fa fa-plus"></i> Add PLO</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-stripped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>WA Code</th>
                                                        <th>Name</th>
                                                        <th>PEO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($plos as $plo)
                                                        <tr>
                                                            
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $plo->code  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $plo->wa_code  }} </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">{{ $plo->name  }} </a>
                                                                </h2>
                                                            </td>
                                                          
                                                                <?php if($plo->peo){ ?>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="#">{{ $plo->peo->code  }} </a>
                                                                        </h2>    
                                                                    </td>
                                                                <?php } else {?>
                                                                    <td>
                                                                        -
                                                                    </td>
                                                                <?php }?>
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

        @endsection
