<?php
session_start();
include 'includes/dbconnection.php';

// Redirect if not logged in
if (!isset($_SESSION['ccmsaid'])) {
    header('Location: logout.php');
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Manage Old Users</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>

    <div class="content mt-3">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Old Users (Registered 1+ Months Ago)</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Registered On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT * FROM users 
                                WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 MONTH) 
                                AND status = 'active'
                                ORDER BY created_at DESC
                            ";
                            $ret = mysqli_query($con, $query);
                            $cnt = 1;

                            while ($row = mysqli_fetch_array($ret)) {
                                echo '<tr>';
                                echo '<td>' . $cnt++ . '</td>';
                                echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                echo '<td>' . date('d M Y', strtotime($row['created_at'])) . '</td>';
                                echo '<td>';
                                echo '<a href="view_user.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">View</a> ';
                                echo '<a href="edit_user.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a> ';
                                echo '<a href="delete_user.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to deactivate this user?\')" class="btn btn-danger btn-sm">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            if (mysqli_num_rows($ret) == 0) {
                                echo '<tr><td colspan="6" class="text-center">No users found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
