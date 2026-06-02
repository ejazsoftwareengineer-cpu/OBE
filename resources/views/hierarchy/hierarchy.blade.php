<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        
        <title>Hierarchy</title>
        <style>
            body {
                font-size : 1.9375rem !important;
            }
           .tree, .tree ul {
                margin:0;
                padding:0;
                list-style:none
            }
            .tree ul {
                margin-left:1em;
                position:relative
            }
            .tree ul ul {
                margin-left:.5em
            }
            .tree ul:before {
                content:"";
                display:block;
                width:0;
                position:absolute;
                top:0;
                bottom:0;
                left:0;
                border-left:1px solid
            }
            .tree li {
                margin:0;
                padding:0 1em;
                line-height:2em;
                color:#369;
                font-weight:700;
                position:relative
            }
            .tree ul li:before {
                content:"";
                display:block;
                width:10px;
                height:0;
                border-top:1px solid;
                margin-top:-1px;
                position:absolute;
                top:1em;
                left:0
            }
            .tree ul li:last-child:before {
                background:#fff;
                height:auto;
                top:1em;
                bottom:0
            }
            .indicator {
                margin-right:5px;
            }
            .tree li a {
                text-decoration: none;
                color:#369;
            }
            .tree li button, .tree li button:active, .tree li button:focus {
                text-decoration: none;
                color:#369;
                border:none;
                background:transparent;
                margin:0px 0px 0px 0px;
                padding:0px 0px 0px 0px;
                outline: 0;
            }
            .organization{
                margin-top:3% !important;
            } 
            .organization-text{
                background-color: #FF0055;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
            }
            
            .campus{
                margin-top:3% !important;
            }
            
            .campus-text{
                margin-top:20px;
                background-color: green;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
            }

            .institute{
                margin-top:3% !important;
            }
            .institute-text{
                margin-top:20px;
                background-color: brown;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
            }
            
            .department{
                margin-top:3% !important;
            }
            .department-text{
                margin-top:20px;
                background-color: #564e76;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
            }

            .program{
                margin-top:3% !important;
            }
            .program-text{
                margin-top:20px;
                background-color: #399d81;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
            }

            .programbatch{
                margin-top:3% !important;
            }
            .programbatch-text{
                margin-top:20px;
                background-color: #199f48;
                padding: 10px 10px 10px 10px;
                color: white !important;
                border-radius: 5px;
                font-size: 15px;
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
                        <div class="col" style="margin-top: -43px">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="font-size: initial;">Dashboard</a></li>
                                <li class="breadcrumb-item active" style="font-size: initial;">Hierarchy</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                          
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="container" style="margin-top:30px;background-color: snow;">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="tree1">
                               <?php foreach($data as $org) {?>
                                <li class="organization"><a class="organization-text" title="Organization" href="javascript:void(0);"><?php echo $org->name ?></a>
                                    <ul>
                                        <?php foreach($org->campus as $cam) {?>
                                            <li class="campus"><a class="campus-text" href="javascript:void(0);" title="Campus/Region"><?php echo $cam->name ?></a>
                                                <ul>
                                                    <?php foreach($cam->institute as $fac) {?>
                                                        <li class="institute"><a class="institute-text" href="javascript:void(0);" title="Institute/Faculty/Department"><?php echo $fac->name ?></a>
                                                            <ul>
                                                                <?php $prog = $program::whereRaw("FIND_IN_SET(?, institute_id)", [$fac->id])->get();?>
                                                                <?php foreach($prog as $pro) {?>
                                                                    <li class="program"><a class="program-text" href="javascript:void(0);" title="Program"><?php echo $pro->name ?></a>
                                                                        
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
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

            $(document).ready(function() {
                $.fn.extend({
                    treed: function (o) {
                    
                    var openedClass = 'glyphicon-minus-sign';
                    var closedClass = 'glyphicon-plus-sign';
                    
                    if (typeof o != 'undefined'){
                        if (typeof o.openedClass != 'undefined'){
                        openedClass = o.openedClass;
                        }
                        if (typeof o.closedClass != 'undefined'){
                        closedClass = o.closedClass;
                        }
                    };
                    
                        //initialize each of the top levels
                        var tree = $(this);
                        tree.addClass("tree");
                        tree.find('li').has("ul").each(function () {
                            var branch = $(this); //li with children ul
                            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
                            branch.addClass('branch');
                            branch.on('click', function (e) {
                                if (this == e.target) {
                                    var icon = $(this).children('i:first');
                                    icon.toggleClass(openedClass + " " + closedClass);
                                    $(this).children().children().toggle();
                                }
                            })
                            branch.children().children().toggle();
                        });
                        //fire event from the dynamically added icon
                    tree.find('.branch .indicator').each(function(){
                        $(this).on('click', function () {
                            $(this).closest('li').click();
                        });
                    });
                        //fire event to open branch if the li contains an anchor instead of text
                        tree.find('.branch>a').each(function () {
                            $(this).on('click', function (e) {
                                $(this).closest('li').click();
                                e.preventDefault();
                            });
                        });
                        //fire event to open branch if the li contains a button instead of text
                        tree.find('.branch>button').each(function () {
                            $(this).on('click', function (e) {
                                $(this).closest('li').click();
                                e.preventDefault();
                            });
                        });
                    }
                });

                //Initialization of treeviews

                $('#tree1').treed();

                $('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

                $('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

            });
        </script>
        @endsection
