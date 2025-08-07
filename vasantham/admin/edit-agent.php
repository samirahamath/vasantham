<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  exit();
}

// Fetch agent details
if (!isset($_GET['id'])) {
    echo '<script>alert("No agent selected.");window.location.href="manage-agents.php";</script>';
    exit();
}
$id = intval($_GET['id']);
$query = mysqli_query($con, "SELECT * FROM tbluser WHERE ID='$id' AND UserType='1'");
$agent = mysqli_fetch_assoc($query);
if (!$agent) {
    echo '<script>alert("Agent not found.");window.location.href="manage-agents.php";</script>';
    exit();
}

// Handle update
if (isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $mobilenumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $last4 = substr($mobilenumber, -4);
    $agentid = 'VR' . $last4;
    $update = mysqli_query($con, "UPDATE tbluser SET FullName='$fullname', MobileNumber='$mobilenumber', Email='$email', Password='$password', AgentID='$agentid' WHERE ID='$id'");
    if ($update) {
        echo '<script>alert("Agent updated successfully.");window.location.href="manage-agents.php";</script>';
        exit();
    } else {
        $msg = "Failed to update agent.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Edit Agent | Admin</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
</head>
<body>
<div class="dashboard-main-wrapper">
    <?php include_once('includes/header.php');?>
    <?php include_once('includes/sidebar.php');?>
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Edit Agent</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($msg)) { echo '<div class="alert alert-danger">'.$msg.'</div>'; } ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($agent['FullName']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobilenumber">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo htmlspecialchars($agent['MobileNumber']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($agent['Email']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($agent['Password']); ?>" required>
                                </div>
                                <button type="submit" name="update" class="btn btn-success">Update Agent</button>
                                <a href="manage-agents.php" class="btn btn-secondary">Back</a>
                            </form>
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
</body>
</html>
