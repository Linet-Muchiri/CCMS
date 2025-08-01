<?php
session_start();
include 'includes/dbconnection.php';

// Admin authentication check
if (!isset($_SESSION['ccmsaid'])) {
    header('Location: logout.php');
    exit();
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h3>Invalid request. No user ID provided.</h3>";
    exit();
}

$user_id = intval($_GET['id']);

// Optional: Prevent admin from deleting their own user (if applicable)
// if ($user_id == $_SESSION['ccmsaid']) {
//     echo "<h3>You cannot delete your own account.</h3>";
//     exit();
// }

// Delete query
$stmt = $con->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Redirect back to user management with success message
    $_SESSION['delete_msg'] = "User deleted successfully.";
    header("Location: manage_users.php");
    exit();
} else {
    echo "<h3>Failed to delete user. Please try again.</h3>";
}
?>
