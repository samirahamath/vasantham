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
    <title>All Enquiries | Admin</title>
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
                        <h2 class="pageheader-title">All Enquiries</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">All Enquiries</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>SNO</th>
                                            <th>Agent ID</th>
                                            <th>Agent Name</th>
                                            <th>Customer Name</th>
                                            <th>Property Title</th>
                                            <th>Property ID</th>
                                            <th>Mobile Number</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Handle the reviewed status update
if (isset($_GET['reviewed']) && isset($_GET['id'])) {
    $enquiry_id = (int)$_GET['id'];
    $status = ($_GET['reviewed'] == '1') ? 'Read' : 'Unread';
    $update_query = "UPDATE tblenquiry SET Status = '$status' WHERE ID = $enquiry_id";
    mysqli_query($con, $update_query);
    // Redirect to avoid resubmission
    echo "<script>window.location.href='all-enquiries.php'</script>";
    exit();
}

// Fetch all enquiries with agent details (through property relationship)
$q = "SELECT e.*, 
             u.AgentID, 
             u.FullName as AgentName, 
             p.PropertyTitle,
             p.PropertyID as PropertyCode,
             e.FullName as CustomerName,
             e.Status
      FROM tblenquiry e
      LEFT JOIN tblproperty p ON e.PropertyID = p.ID
      LEFT JOIN tbluser u ON p.UserID = u.ID
      ORDER BY e.ID DESC";
$ret = mysqli_query($con, $q);
$cnt = 1;
while ($row = mysqli_fetch_array($ret)) {
    $reviewed = !empty($row['Status']) && ($row['Status'] == 'Read' || $row['Status'] == 'Answered');
    echo '<tr>';
    echo '<td>' . $cnt . '</td>';
    echo '<td>' . (!empty($row['AgentID']) ? htmlspecialchars($row['AgentID']) : '-') . '</td>';
    echo '<td>' . (!empty($row['AgentName']) ? htmlspecialchars($row['AgentName']) : '-') . '</td>';
    echo '<td>' . htmlspecialchars($row['CustomerName']) . '</td>';
    echo '<td>' . htmlspecialchars($row['PropertyTitle']) . '</td>';
    echo '<td>' . (!empty($row['PropertyCode']) ? htmlspecialchars($row['PropertyCode']) : '-') . '</td>';
    echo '<td>' . htmlspecialchars($row['MobileNumber']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Message']) . '</td>';
    echo '<td>';
    if ($reviewed) {
        echo '<button class="btn btn-success btn-sm" disabled>Reviewed</button>';
    } else {
        echo '<a href="all-enquiries.php?reviewed=1&id=' . $row['ID'] . '" class="btn btn-primary btn-sm">Mark as Reviewed</a>';
    }
    echo '</td>';
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
