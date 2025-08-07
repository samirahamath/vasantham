<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['signup']))
{
    $fname=$_POST['fullname'];
    $mobno=$_POST['mobilenumber'];
    $email=$_POST['email'];
    $usertype=$_POST['usertype'];
    $password=md5($_POST['password']);

    $ret=mysqli_query($con, "select Email from tbluser where Email='$email'");
    $result=mysqli_fetch_array($ret);
    if($result>0){
        echo "<script>alert('This email already associated with another account');</script>";
    }
    else{
        $query=mysqli_query($con, "insert into tbluser(FullName, Email, MobileNumber, Password,UserType) value('$fname', '$email','$mobno', '$password','$usertype' )");
        if ($query) {
            echo "<script>alert('You have successfully registered');</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
        else
        {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Real Estate Management System">
    <link href="assets/images/logo/favicon.png" rel="icon">
    <title>Real Estate Management System - Register</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    
    <!-- Document Wrapper -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php'); ?>
        <hr />
        
        <!-- Page Title -->
        <section id="page-title" style="margin-top:-3%" class="page-title bg-overlay bg-overlay-dark2">
            <!-- <div class="bg-section">
                <img src="assets/images/page-titles/1.jpg" alt="Background" />
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <div class="title title-1 text-center">
                            <div class="title--content">
                                <div class="title--heading">
                                    <h1>Register</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Register</li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div> -->
        </section>
        
        <!-- Register Form -->
        <section id="register-form" class="register-form" style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:#f5f8fd;">
            <div class="container">
                <div class="row justify-content-center align-items-center" style="min-height:80vh;">
                    <!-- Form Column -->
                    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="w-100" style="max-width:420px;">
                            <div class="text-center mb-4">
                                <img src="assets/images/logo/vr_logobg.png" alt="Logo" width="120" height="90" class="mb-2">
                                <h3 class="form--title mb-1" style="font-weight:700;">Register New Agent</h3>
                                <p class="text-muted mb-0">Create your account</p>
                            </div>
                            <form class="mb-0" method="post" name="signup">
                                <div class="form-group mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control form-control-lg" name="fullname" id="fullname" required placeholder="Enter your full name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" name="email" id="email" required placeholder="Enter your email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="mobilenumber" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control form-control-lg" name="mobilenumber" id="mobilenumber" maxlength="10" required placeholder="Enter your mobile number">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control form-control-lg" name="password" id="password" required placeholder="Enter your password">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label d-block">Register as:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usertype" id="broker" value="1" checked>
                                        <label class="form-check-label" for="broker">Broker</label>
                                    </div>
                                    <!--
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usertype" id="owner" value="2">
                                        <label class="form-check-label" for="owner">Owner</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usertype" id="user" value="3">
                                        <label class="form-check-label" for="user">User</label>
                                    </div>
                                    -->
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="signup" class="btn btn-primary btn-lg w-100">Register</button>
                                </div>
                                <div class="form-group text-center mb-0">
                                    <span class="text-muted">Already have an account?</span>
                                    <a href="agent_login.php" class="text-decoration-none link-custom">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Image & Quote Column -->
                    <div class="col-12 col-lg-6 d-flex flex-column align-items-center justify-content-center mt-100 mt-lg-0 mb-5">
                        <img src="assets/images/page-titles/agent_login_pic.jpg" alt="Agent Register" style="width:100%;max-width:500px;height:380px;object-fit:cover; border-radius:1rem; margin-bottom:20px;">
                        <div class="w-100 text-center mt-3 mb-4" style="font-size:1.1rem; color:#22223b;">
                            <i class="fas fa-quote-left" style="color:#2ec4b6;"></i>
                            <span style="font-style:italic;">"Join our network. Every great journey begins with a single registration."</span>
                            <i class="fas fa-quote-right" style="color:#2ec4b6;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php include_once('includes/footer.php'); ?>
    </div>
    
    <!-- Scripts -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html>