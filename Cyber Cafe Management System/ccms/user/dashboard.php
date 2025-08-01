<?php include('auth.php'); ?>
<!DOCTYPE html>
<html>
<head><title>User Dashboard</title>

    <link rel="apple-touch-icon" href="apple-icon.png">
   


    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  </head>

<body>
  <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
  <ul>
    <li><a href="services.php">Browse Services</a></li>
    <li><a href="payment.php">Make Payment</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
