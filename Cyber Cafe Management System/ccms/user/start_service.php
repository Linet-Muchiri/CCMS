<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include('../includes/dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid access method.";
    exit();
}

// Validate service_id input
if (!isset($_POST['service_id']) || !is_numeric($_POST['service_id'])) {
    echo "Invalid or missing service ID.";
    exit();
}

$user_id = $_SESSION['user_id'];
$service_id = intval($_POST['service_id']);

// Check if the user already has an ongoing session
$check_sql = "SELECT * FROM service_usage WHERE user_id = ? AND end_time IS NULL";
$stmt_check = $con->prepare($check_sql);
$stmt_check->bind_param("i", $user_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "⚠️ You already have a running session. Please stop it before starting a new one.";
    exit();
}

// Record start time
$start_time = date("Y-m-d H:i:s");

// Insert new service usage session
$insert_sql = "INSERT INTO service_usage (user_id, service_id, start_time) VALUES (?, ?, ?)";
$stmt_insert = $con->prepare($insert_sql);
$stmt_insert->bind_param("iis", $user_id, $service_id, $start_time);

if ($stmt_insert->execute()) {
    header("Location: usage_history.php");
    exit();
} else {
    echo "❌ Error starting service: " . $con->error;
    exit();
}
?>
