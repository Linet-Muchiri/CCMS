<?php
session_start();
include '../includes/dbconnection.php';
$msg = ""; // default message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Email already registered.";
    } else {
        $insert = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
        if (mysqli_query($con, $insert)) {
            $_SESSION['user_id'] = mysqli_insert_id($con);
            $_SESSION['ccmsuid'] = $_SESSION['user_id'];
            $_SESSION['full_name'] = $full_name;
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>CCMS User Registration</title>
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body class="bg-dark" style="background-image: url('images/bg.jpg');">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <h3 style="color: white">Cyber Cafe Management System</h3>
                    <hr color="red"/>
                </div>
                <div class="login-form">
                    <form action="" method="post">
                        <p style="font-size:16px; color:red" align="center"><?php echo $msg; ?></p>

                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="checkbox">
                            <label class="pull-right">
                                <a href="login.php">Login</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
