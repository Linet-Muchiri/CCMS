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
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    $stmt = $con->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $email, $user_id);

    if ($stmt->execute()) {
        $msg = "User updated successfully.";
    } else {
        $msg = "Update failed. Try again.";
    }
}

// Fetch user details
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
    <title>Edit User - CCMS</title>
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
                <strong>Edit User</strong>
                <a href="manage_users.php" class="btn btn-secondary btn-sm float-right">← Back</a>
            </div>
            <div class="card-body">
                <?php if ($msg): ?>
                    <div class="alert alert-info"><?php echo $msg; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($user['full_name']); ?>">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
