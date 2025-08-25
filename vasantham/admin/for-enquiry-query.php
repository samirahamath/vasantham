<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
    header('location:logout.php');
    exit();
}
// Handle status toggle (Reviewed / Not Reviewed)
if (isset($_GET['toggle']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // normalize incoming toggle value
    $currentStatus = $_GET['toggle'] === 'Reviewed' ? 'Reviewed' : 'Not Reviewed';
    $newStatus = $currentStatus === 'Reviewed' ? 'Not Reviewed' : 'Reviewed';
    mysqli_query($con, "UPDATE tblforenquiry SET Status='".mysqli_real_escape_string($con,$newStatus)."' WHERE ID='$id'");
    header('Location: for-enquiry-query.php');
    exit();
}

// optional delete handler (runs before output)
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM tblforenquiry WHERE ID='$id'");
    header('Location: for-enquiry-query.php');
    exit();
}

// fetch rows
$result = mysqli_query($con, "SELECT * FROM tblforenquiry ORDER BY EnquiryDate DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <title>Real Estate Management System || Manage Enquiries</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
         <?php include_once('includes/header.php');?>
        <?php include_once('includes/sidebar.php');?>
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Manage For Enquiries</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Enquiries</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Manage Enquiries</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first" id="forEnquiryTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Property Type</th>
                                                <th>Location</th>
                                                <th>Budget</th>
                                                <th>Purpose</th>
                                                <th>Bedrooms</th>
                                                <th>Additional</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['ID']; ?></td>
                                                <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['PropertyType']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Location']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Budget']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Purpose']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Bedrooms']); ?></td>
                                                <td><?php echo htmlspecialchars($row['Additional']); ?></td>
                                                <td><?php echo nl2br(htmlspecialchars($row['Message'])); ?></td>
                                                <td><?php echo $row['EnquiryDate']; ?></td>
                                                <td>
                                                    <a href="for-enquiry-query.php?toggle=<?php echo urlencode($row['Status'] ?: 'Not Reviewed'); ?>&id=<?php echo $row['ID']; ?>" class="btn btn-sm btn-<?php echo ($row['Status']==='Reviewed')?'warning':'success'; ?>">
                                                        <?php echo ($row['Status']==='Reviewed') ? 'Mark Not Reviewed' : 'Mark Reviewed'; ?>
                                                    </a>
                                                    <a href="for-enquiry-query.php?delete=1&id=<?php echo $row['ID']; ?>"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Delete this enquiry? This action cannot be undone.');">
                                                       Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
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
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
    <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#forEnquiryTable').DataTable();
    });
    </script>
</body>
</html>
