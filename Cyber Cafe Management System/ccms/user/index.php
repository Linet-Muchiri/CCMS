<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>User Dashboard</title>

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet'>
</head>
<body>

    <?php include_once('../includes/user_sidebar.php'); ?>

    <div id="right-panel" class="right-panel">

        <?php include_once('../includes/header.php'); ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>User Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <!-- Example: Services -->
            <div class="col-sm-6 col-lg-6">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <h3 class="mb-0">7</h3>
                        <p class="text-light">Available Services</p>
                        <div class="chart-wrapper px-3" style="height:70px;">
                            <canvas id="widgetChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Example: Payments -->
            <div class="col-sm-6 col-lg-6">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <h3 class="mb-0">Ksh 0.00</h3>
                        <p class="text-light">Total Payments Made</p>
                        <div class="chart-wrapper px-0" style="height:70px;">
                            <canvas id="widgetChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.content -->

    </div><!-- /#right-panel -->

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
