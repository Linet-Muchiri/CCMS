<?php
session_start();
include 'includes/dbconnection.php';

if (!isset($_SESSION['ccmsaid'])) {
    header('Location: logout.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h3>Invalid user ID.</h3>";
    exit();
}

$user_id = intval($_GET['id']);
$query = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");

if (!$query || mysqli_num_rows($query) == 0) {
    echo "<h3>User not found.</h3>";
    exit();
}

$user = mysqli_fetch_assoc($query);
?>

<!doctype html>
<html lang="en">
<head>
    <title>View User - CCMS</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include_once 'includes/sidebar.php'; ?>
<?php include_once 'includes/header.php'; ?>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">User Details</strong>
                <a href="manage_users.php" class="btn btn-sm btn-secondary float-right">← Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Registered On</th>
                        <td>
                            <?php
                            echo isset($user['reg_date']) ? htmlspecialchars($user['reg_date']) : (isset($user['created_at']) ? htmlspecialchars($user['created_at']) : 'N/A');
                            ?>
                        </td>
                    </tr>
                </table>

                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this user?');">Delete</a>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
