<?php
session_start();
include '../includes/dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Usage History</title>
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/user_sidebar.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">My Service Usage History</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration (min)</th>
                            <th>Amount (Ksh)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT su.*, s.name AS service_name FROM service_usage su 
                              JOIN services s ON su.service_id = s.ID 
                              WHERE su.user_id = $userid ORDER BY su.id DESC";
                    $result = mysqli_query($con, $query);
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['service_name']) . "</td>";
                        echo "<td>" . $row['start_time'] . "</td>";
                        echo "<td>" . ($row['end_time'] ? $row['end_time'] : '<span class="text-warning">In Progress</span>') . "</td>";
                        echo "<td>" . ($row['duration_minutes'] !== null ? $row['duration_minutes'] : '-') . "</td>";
                        echo "<td>" . ($row['amount_due'] !== null ? number_format($row['amount_due'], 2) : '-') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
