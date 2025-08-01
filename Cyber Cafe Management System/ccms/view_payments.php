<?php
session_start();
include 'includes/dbconnection.php';

// Admin session check
if (!isset($_SESSION['ccmsaid'])) {
    header("Location: login.php");
    exit();
}

// Fetch all payments + user info
$query = "
    SELECT p.*, u.full_name 
    FROM payments p 
    JOIN users u ON p.user_id = u.id 
    ORDER BY p.paid_at DESC
";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Payments</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="content mt-3">
    <div class="container">
        <h3>All Payments</h3>

        <div class="mb-3">
            <input type="text" id="filterInput" placeholder="Search by user or date..." class="form-control">
        </div>

        <div class="mb-2">
            <button onclick="window.print()" class="btn btn-secondary btn-sm">🖨️ Print</button>
            <button onclick="exportTableToCSV('payments.csv')" class="btn btn-success btn-sm">📁 Export CSV</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="paymentsTable">
                <thead class="thead-dark">
                    <tr>
                        <th>User</th>
                        <th>Amount Paid</th>
                        <th>Method</th>
                        <th>M-Pesa Code</th>
                        <th>Date</th>
                        <th>Session Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td>Ksh <?= number_format($row['amount_paid'], 2) ?></td>
                            <td><?= ucfirst($row['method']) ?></td>
                            <td><?= htmlspecialchars($row['mpesa_code']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($row['paid_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailsModal<?= $row['id'] ?>">View</button>

                                <!-- Modal -->
                                <div class="modal fade" id="detailsModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Session Details for <?= htmlspecialchars($row['full_name']) ?></h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    <?php
                                                    $session_ids_raw = $row['session_ids'];
                                                    $session_ids = json_decode($session_ids_raw, true);

                                                    if (!empty($session_ids) && is_array($session_ids)) {
                                                        $session_id_string = implode(',', array_map('intval', $session_ids));
                                                        $session_query = "
                                                            SELECT su.*, s.name AS service_name 
                                                            FROM service_usage su 
                                                            JOIN services s ON su.service_id = s.ID 
                                                            WHERE su.id IN ($session_id_string)
                                                        ";
                                                        $session_result = mysqli_query($con, $session_query);

                                                        if (mysqli_num_rows($session_result) > 0) {
                                                            while ($session = mysqli_fetch_assoc($session_result)) {
                                                                echo "<li><strong>" . htmlspecialchars($session['service_name']) . "</strong> ({$session['start_time']} - {$session['end_time']}) - Ksh " . number_format($session['amount_due'], 2) . "</li>";
                                                            }
                                                        } else {
                                                            echo "<li>No matching sessions found.</li>";
                                                        }
                                                    } else {
                                                        echo "<li>Invalid session data.</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filter table
    document.getElementById("filterInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#paymentsTable tbody tr");
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Export CSV
    function exportTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#paymentsTable tr");
        rows.forEach(row => {
            const cols = row.querySelectorAll("td, th");
            const rowData = Array.from(cols).map(col => `"${col.innerText.trim()}"`);
            csv.push(rowData.join(","));
        });
        downloadCSV(csv.join("\n"), filename);
    }

    function downloadCSV(csv, filename) {
        const blob = new Blob([csv], { type: "text/csv" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
    }
</script>
</body>
</html>
