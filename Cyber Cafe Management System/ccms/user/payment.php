<?php
session_start();
include '../includes/dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessions']) && is_array($_POST['sessions'])) {
    $selected_sessions = array_map('intval', $_POST['sessions']);
    $session_ids_string = implode(',', $selected_sessions);
    $method = mysqli_real_escape_string($con, $_POST['method']);
    $mpesa_code = mysqli_real_escape_string($con, $_POST['mpesa_code']);

    // Fetch total amount from DB
    $res = mysqli_query($con, "SELECT SUM(amount_due) AS total FROM service_usage WHERE id IN ($session_ids_string)");
    $row = mysqli_fetch_assoc($res);
    $total_paid = $row['total'];

    // Convert session IDs to valid JSON
    $session_ids_json = json_encode($selected_sessions); // e.g. [2,3] → "[2,3]"

    // Safety check
    if (empty($method) || empty($mpesa_code) || empty($session_ids_json) || empty($total_paid)) {
        die("❌ Missing payment details. Please go back and try again.");
    }

    // Insert payment
    $insert = "INSERT INTO payments (user_id, session_ids, method, mpesa_code, amount_paid)
               VALUES ($user_id, '$session_ids_json', '$method', '$mpesa_code', $total_paid)";
    if (mysqli_query($con, $insert)) {
        // Mark sessions as paid
        mysqli_query($con, "UPDATE service_usage SET paid = 1 WHERE id IN ($session_ids_string)");

        echo "<script>alert('✅ Payment recorded successfully.'); window.location='usage_history.php';</script>";
        exit();
    } else {
        die("❌ Payment insert failed: " . mysqli_error($con));
    }
}

// Fetch unpaid completed sessions
$query = "SELECT su.*, s.name AS service_name FROM service_usage su 
          JOIN services s ON su.service_id = s.ID 
          WHERE su.user_id = $user_id 
          AND su.end_time IS NOT NULL 
          AND su.amount_due > 0 
          AND su.paid = 0 
          ORDER BY su.id DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Make Payment</title>
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/user_sidebar.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="content mt-3">
    <div class="container">
        <h3 class="mb-3">Pending Payments</h3>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Payment successful. Thank you!</div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <form method="POST">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Service</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Amount Due (Ksh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php $total += $row['amount_due']; ?>
                            <tr>
                                <td><input type="checkbox" name="sessions[]" value="<?= $row['id'] ?>"></td>
                                <td><?= htmlspecialchars($row['service_name']) ?></td>
                                <td><?= $row['start_time'] ?></td>
                                <td><?= $row['end_time'] ?></td>
                                <td><?= number_format($row['amount_due'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="mb-3">
                    <strong>Total Payable: Ksh <?= number_format($total, 2) ?></strong>
                </div>

                <div class="card p-3 mb-3">
                    <h5>M-Pesa Payment Details</h5>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select class="form-control" name="method" required>
                            <option value="till">Till Number</option>
                            <option value="paybill">Paybill Number</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Transaction Code</label>
                        <input type="text" name="mpesa_code" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Pay Selected</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">You have no unpaid sessions.</div>
        <?php endif; ?>
    </div>
</div>

<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script>
    document.getElementById('select-all').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[name="sessions[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
</body>
</html>
