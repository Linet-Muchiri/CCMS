<?php
session_start();
include_once('includes/dbconnection.php');

// Redirect if not admin
if (!isset($_SESSION['ccmsaid'])) {
    header('Location: login.php');
    exit();
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Manage Users - CCMS</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Left Sidebar -->
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div id="right-panel" class="right-panel">
        <?php include_once('includes/header.php'); ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <h1>Manage Users</h1>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">All Registered Users</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
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
                                $ret = mysqli_query($con, "SELECT * FROM users ORDER BY created_at DESC");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <a href="view_user.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if (mysqli_num_rows($ret) == 0) {
                                    echo '<tr><td colspan="6" class="text-center text-muted">No users found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
