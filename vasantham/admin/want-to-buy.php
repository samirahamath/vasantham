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
    <title>Want to Buy | Admin</title>
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
                        <h2 class="pageheader-title">Want to Buy Enquiries</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Want to Buy Enquiries</h5>
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
                                            <th>Review Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Replace 'tblwanttobuy' with your actual table name for want-to-buy enquiries
$q = "SELECT * FROM tblwanttobuy ORDER BY ID DESC";
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
    // Add review status column with button
    if (isset($row['IsReviewed']) && $row['IsReviewed']) {
        echo '<td><button class="btn btn-success btn-sm" disabled>Reviewed</button></td>';
    } else {
        echo '<td><button class="btn btn-warning btn-sm review-btn" data-id="' . $row['ID'] . '">Not Reviewed</button></td>';
    }
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

    // AJAX for review button
    $(document).on('click', '.review-btn', function() {
        var btn = $(this);
        var id = btn.data('id');
        $.ajax({
            url: 'update-review-status.php',
            type: 'POST',
            data: { id: id, type: 'buy' },
            success: function(response) {
                if (response.trim() === 'success') {
                    btn.removeClass('btn-warning review-btn').addClass('btn-success').text('Reviewed').prop('disabled', true);
                } else {
                    alert('Failed to update status.');
                }
            }
        });
    });
});
</script>
</body>
</html>
