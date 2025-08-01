<?php
session_start();
include('../includes/dbconnection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>CCMS - Services</title>

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include('../includes/user_sidebar.php'); ?>

    <div id="right-panel" class="right-panel">
        <?php include('../includes/header.php'); ?>

        <div class="breadcrumbs">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Available Services</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Choose a Service to Start</strong>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Rate (KES/min)</th>
                                <th>Start</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($con, "SELECT * FROM services");
                            $cnt = 1;
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td><?php echo $cnt++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td>KES <?php echo number_format($row['rate_per_minute'], 2); ?></td>
                                <td>
                                    <form action="start_service.php" method="POST" onsubmit="return confirm('Start this service?');">
                                        <input type="hidden" name="service_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Start</button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($query) == 0): ?>
                            <tr><td colspan="4">No services available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
