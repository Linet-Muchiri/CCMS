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
    <title>Payment History</title>
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
                <strong class="card-title">My Payment History</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button class="btn btn-primary" onclick="printTable()">🖨️ Print Receipt</button>
                    <button class="btn btn-success" onclick="exportTableToCSV('payment_history.csv')">📁 Export CSV</button>
                    <button class="btn btn-danger" onclick="exportTableToPDF()">📄 Export PDF</button>
                </div>
                <table class="table table-bordered" id="paymentTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Amount Paid (Ksh)</th>
                            <th>Payment Method</th>
                            <th>M-Pesa Code</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM payments WHERE user_id = $userid ORDER BY paid_at DESC";
                    $result = mysqli_query($con, $query);
                    $count = 1;
                    $currentDate = "";

                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = date('Y-m-d', strtotime($row['paid_at']));
                        if ($date !== $currentDate) {
                            echo "<tr><td colspan='5'><strong>Date: $date</strong></td></tr>";
                            $currentDate = $date;
                        }

                        echo "<tr>
                            <td>" . $count++ . "</td>
                            <td>" . number_format($row['amount_paid'], 2) . "</td>
                            <td>" . htmlspecialchars($row['method']) . "</td>
                            <td>" . htmlspecialchars($row['mpesa_code']) . "</td>
                            <td>" . $row['paid_at'] . "</td>
                        </tr>";
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

<script>
function printTable() {
    const printContents = document.getElementById("paymentTable").outerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

function exportTableToCSV(filename) {
    let csv = [];
    const rows = document.querySelectorAll("#paymentTable tr");
    for (let row of rows) {
        const cols = row.querySelectorAll("td, th");
        let rowData = Array.from(cols).map(col => `"${col.innerText}"`).join(",");
        csv.push(rowData);
    }

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}

function exportTableToPDF() {
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write(`<html><head><title>Payment History</title>`);
    printWindow.document.write(`<link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">`);
    printWindow.document.write(`</head><body>`);
    printWindow.document.write(document.getElementById("paymentTable").outerHTML);
    printWindow.document.write(`</body></html>`);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>

</body>
</html>
