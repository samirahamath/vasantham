<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
  } else{

// Handle form submission
if(isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $mobilenumber = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $last4 = substr($mobilenumber, -4);
    $agentid = 'VR' . $last4;
    $query = mysqli_query($con, "INSERT INTO tbluser (FullName, MobileNumber, Email, Password, UserType, AgentID) VALUES ('$fullname', '$mobilenumber', '$email', '$password', '1', '$agentid')");
    if($query) {
        $msg = "Agent registered successfully. Agent ID: $agentid";
    } else {
        $msg = "Error: Could not register agent.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Add Agent | Admin</title>
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
                            <h4 class="mb-0">Add New Agent</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($msg)) { echo '<div class="alert alert-info">'.$msg.'</div>'; } ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobilenumber">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-success">Register Agent</button>
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
<?php } ?>
