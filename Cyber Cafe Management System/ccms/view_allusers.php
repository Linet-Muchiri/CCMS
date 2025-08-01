<?php
session_start();
include 'includes/dbconnection.php';

if (!isset($_SESSION['ccmsaid'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Users</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="content mt-3">
    <div class="container">
        <h4>All Registered Users</h4>

        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a href="view_user.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
                            <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr><td colspan="5" class="text-center">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
