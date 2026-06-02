<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Manage Reports</title>      
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
                                        <li class="breadcrumb-item active">Manage Reports</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-md-12">
                                <div class="card p-4">
                                    <h5 class="breadcrumb-item active"> Program Wise Reports</h5>

                                    <div class="row mt-3">
                                        
                                        <div class="col-md-6 mb-2">
                                            <a href="{{ route('programwiseplo') }}" class="d-block text-black text-decoration-none border p-3 rounded shadow-sm">
                                                Program Based PLO's 
                                            </a>
                                        </div>
                                           
                                        <div class="col-md-6 mb-2">
                                            <a href="{{ route('status.report') }}" class="d-block text-black text-decoration-none border p-3 rounded shadow-sm">
                                                Status  Report                                       </a>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <a href="#" class="d-block text-black text-decoration-none border p-3 rounded shadow-sm">
                                                Comming Soon
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <a href="#" class="d-block text-black text-decoration-none border p-3 rounded shadow-sm">
                                                Comming Soon
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <a href="#" class="d-block text-black text-decoration-none border p-3 rounded shadow-sm">
                                                Comming Soon
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                </div>			
            </div>

        @endsection

        @section('script')

        @endsection
