<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Want to Sell | Admin</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div class="dashboard-main-wrapper">
    <?php include_once('includes/header.php');?>
    <?php include_once('includes/sidebar.php');?>
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Want to Sell Enquiries</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Want to Sell Enquiries</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>SNO</th>
                                            <th>Your Name</th>
                                            <th>Your Mobile</th>
                                            <th>Your Phone</th>
                                            <th>Your Email</th>
                                            <th>Address</th>
                                            <th>Location</th>
                                            <th>City</th>
                                            <th>Your Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Replace 'tblwanttosell' with your actual table name for want-to-sell enquiries
$q = "SELECT * FROM tblwanttosell ORDER BY ID DESC";
$ret = mysqli_query($con, $q);
$cnt = 1;
while ($row = mysqli_fetch_array($ret)) {
    echo '<tr>';
    echo '<td>' . $cnt . '</td>';
    echo '<td>' . htmlspecialchars($row['YourName']) . '</td>';
    echo '<td>' . htmlspecialchars($row['YourMobile']) . '</td>';
    echo '<td>' . htmlspecialchars($row['YourPhone']) . '</td>';
    echo '<td>' . htmlspecialchars($row['YourEmail']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Address']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Location']) . '</td>';
    echo '<td>' . htmlspecialchars($row['City']) . '</td>';
    echo '<td>' . htmlspecialchars($row['YourMessage']) . '</td>';
    echo '</tr>';
    $cnt++;
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
    </div>
</div>
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('.first').DataTable({
        "pageLength": 10,
        "ordering": true,
        "searching": true,
        "lengthChange": true,
        "info": true
    });
});
</script>
</body>
</html>
