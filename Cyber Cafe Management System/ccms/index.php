<?php
session_start();

// Auto-redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
if (isset($_SESSION['user_id'])) {
    header("Location: user/services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cyber Café Management System</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <style>
        body {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .panel {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .panel h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .btn-lg {
            width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="panel">
    <h1>Cyber Café Management System</h1>
    <p>Please choose how you want to log in:</p>
    <a href="login.php" class="btn btn-primary btn-lg">
        <i class="fa fa-user-shield"></i> Admin Login
    </a><br>
    <a href="user/login.php" class="btn btn-success btn-lg">
        <i class="fa fa-user"></i> User Login
    </a>
</div>

</body>
</html>
