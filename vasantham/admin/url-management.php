<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  } else{
?>
<!doctype html>
<html lang="en">
<head>
    <title>Real Estate Management System || Manage URLs</title>
    <!-- Bootstrap CSS -->
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
                            <h2 class="pageheader-title">Manage URLs</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage URLs</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table: Example URL Links (Static) -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">URL Links</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>URL Name</th>
                                                <th>URL Link</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Agent Login</td>
                                                <td><a href="https://vasanthamrealty.com/agent_login.php" target="_blank">https://vasanthamrealty.com/agent_login.php</a></td>
                                                <td>Internal</td>
                                                <td>
                                                    <a href="https://vasanthamrealty.com/agent_login.php" target="_blank" class="btn btn-success btn-sm">Open</a>
                                                    <button class="btn btn-info btn-sm" onclick="copyToClipboard('https://vasanthamrealty.com/agent_login.php')">Copy</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Webmail</td>
                                                <td><a href="https://vasanthamrealty.com/webmail" target="_blank">https://vasanthamrealty.com/webmail</a></td>
                                                <td>External</td>
                                                <td>
                                                    <a href="https://vasanthamrealty.com/webmail" target="_blank" class="btn btn-success btn-sm">Open</a>
                                                    <button class="btn btn-info btn-sm" onclick="copyToClipboard('https://vasanthamrealty.com/webmail')">Copy</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Website</td>
                                                <td><a href="https://vasanthamrealty.com/" target="_blank">https://vasanthamrealty.com/</a></td>
                                                <td>External</td>
                                                <td>
                                                    <a href="https://vasanthamrealty.com/" target="_blank" class="btn btn-success btn-sm">Open</a>
                                                    <button class="btn btn-info btn-sm" onclick="copyToClipboard('https://vasanthamrealty.com/')">Copy</button>
                                                </td>
                                            </tr>
                                            
    <script>
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard: ' + text);
            }, function(err) {
                alert('Could not copy text: ' + err);
            });
        } else {
            // fallback for older browsers
            var tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Copied to clipboard: ' + text);
        }
    }
    </script>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
<?php } ?>
