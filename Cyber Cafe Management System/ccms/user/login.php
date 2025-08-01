<?php
session_start();
include '../includes/dbconnection.php';
$msg = ""; // prevent undefined warning

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        // ✅ Session variables for user pages
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ccmsuid'] = $user['id']; // 👈 Fixes logout issue in user panel
        $_SESSION['full_name'] = $user['full_name'];
        
        header("Location: index.php");
        exit();
    } else {
        $msg = "Invalid email or password.";
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>CCMS User Login</title>
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
                    <form action="" method="post" name="login">
                        <p style="font-size:16px; color:red" align="center"><?php echo $msg; ?></p>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Email" required name="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <div class="checkbox">
                            <label class="pull-right">
                                <a href="register.php">Register</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name="login">Sign in</button>
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
