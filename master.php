<?php
/**
 * Created by PhpStorm.
 * User: troot
 * Date: 1/4/15
 * Time: 2:04 AM
 */
$base_url="http://localhost/hms/";

$ses = new \sessionManager\sessionManager();
//$ses->start();
$name=$ses->Get("name");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $GLOBALS['title'];?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $base_url;?>dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url;?>dist/css/datepicker.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo $base_url;?>dist/css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo $base_url;?>dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $base_url;?>dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo $base_url;?>dist/css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $base_url;?>dist/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $base_url;?>dist/css/dataTable.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $base_url;?>dist/css/timepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $base_url;?>dist/css/calendar.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $base_url;?>dist/css/custom_2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $base_url;?>dist/css/app.css" rel="stylesheet" type="text/css">

   
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img alt="HMS" class="pull-left" src="<?php echo $base_url.'site/images/logonav.png'?>"><a class="navbar-brand titlehms" href="<?php echo $base_url.'dashboard.php'?>">Hostel Management System</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <li>
                <h5 class="titlehms"><?php echo $name?></h5>
            </li>

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">

                    <li><a href="<?php echo $base_url;?>ui/setting/adduser.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo $base_url;?>logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?php echo $base_url.'dashboard.php';?>"><i class="fa fa-2x fa-dashboard fa-fw"></i> <p class="text-success">Dashboard</p></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-text fa-fw"></i> <p class="text-success">Attendence Record</p></a>
                        <ul class="nav nav-second-level">
                            
                            <li>
                                <a href="<?php echo $base_url.'ui/attendence/list.php'?>"> <p class="text-success">Attendence List View</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/attendence/view.php'?>"> <p class="text-success">Attendence View</p></a>
                            </li>

                        </ul>
                    </li>
                    
                    <li>
                        <a href="#"><i class="fa fa-money fa-fw"></i> <p class="text-success">Costs</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/cost/add.php'?>"> <p class="text-success">Add New</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/cost/view.php'?>"> <p class="text-success">List View</p></a>
                            </li>


                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> <p class="text-success">Student Info</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/studentManage/admission.php'?>"> <p class="text-success">Admission</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/studentManage/studentlist.php'?>"> <p class="text-success">Student List</p></a>
                            </li>

                            <li>
                                <a href="<?php echo $base_url.'ui/studentManage/deposit.php'?>"> <p class="text-success">Deposit</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/studentManage/seatalocation.php'?>"> <p class="text-success">Seat Alocation</p></a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-money fa-fw"></i> <p class="text-success">Student Payments via</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/stdpayment/add.php'?>"> <p class="text-success">Add</p></a>
                            </li>

                            <li>
                                <a href="<?php echo $base_url.'ui/stdpayment/view.php'?>"> <p class="text-success">View</p></a>
                            </li>

                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> <p class="text-success">Employee Info</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/employee/add.php'?>"> <p class="text-success">Add New</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/employee/view.php'?>"> <p class="text-success">List view</p></a>
                            </li>


                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-dollar fa-fw"></i> <p class="text-success">Payments to</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/payment/create.php'?>"> <p class="text-success">Add New</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/payment/view.php'?>"> <p class="text-success">List View</p></a>
                            </li>

                        </ul>
                    </li>

                    
                    <li>
                        <a href="#"><i class="fa fa-list-alt fa-fw"></i><p class="text-success">Notice Board </p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/notice/create.php'?>"><p class="text-success">Notice Add/List</p></a>
                            </li>



                        </ul>
                    </li>

                    
                    <li>

                        <a href="#"><i class="fa fa-gears fa-fw"></i><p class="text-success">General Info</p></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base_url.'ui/setup/fees.php'?>"><p class="text-success">Fees</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/setup/mealrate.php'?>"><p class="text-success">Meal Rate</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/setup/timeset.php'?>"><p class="text-success">Time Set</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/setup/block.php'?>"><p class="text-success">Blocks</p></a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url.'ui/setup/room.php'?>"><p class="text-success">Rooms</p></a>
                            </li>

                        </ul>
                    </li>


                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
