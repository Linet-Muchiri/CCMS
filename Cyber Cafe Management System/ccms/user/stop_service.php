<?php
session_start();
include('../includes/dbconnection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT su.id, su.start_time, s.rate_per_minute FROM service_usage su
          JOIN services s ON su.service_id = s.id
          WHERE su.user_id = $user_id AND su.end_time IS NULL
          LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "No active session found.";
    exit();
}

$usage_id = $row['id'];
$start_time = strtotime($row['start_time']);
$end_time = time();
$duration = ceil(($end_time - $start_time) / 60); // in minutes
$rate = $row['rate_per_minute'];
$amount_due = $duration * $rate;

$end_time_sql = date("Y-m-d H:i:s", $end_time);

$update = "UPDATE service_usage 
           SET end_time = '$end_time_sql', duration_minutes = $duration, amount_due = $amount_due 
           WHERE id = $usage_id";

if (mysqli_query($con, $update)) {
    header("Location: usage_history.php");
    exit();
} else {
    echo "Error stopping session.";
}
?>
