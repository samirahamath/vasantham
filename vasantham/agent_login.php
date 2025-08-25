<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

//code for login
if(isset($_POST['signin']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $query=mysqli_query($con,"select ID,UserType,Email from tbluser where Email='$email' && Password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
        $_SESSION['ut']=$ret['UserType'];
        $_SESSION['remsuid']=$ret['ID'];
        $_SESSION['uemail']=$ret['Email'];
        
        header('location:index.php');
    }
    else{
        echo "<script>alert('Invalid Details');</script>";
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
    <title>Real Estate Management System - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            <!-- Optional: Add a nice background or keep it minimal -->
        </section>
        
        <!-- Login Form Section -->
        <section id="login-form" class="login-form" style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:#f5f8fd;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height:80vh;">
            <!-- Form Column -->
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                <div class="w-100" style="max-width:420px;">
                    <div class="text-center mb-4">
                        <img src="assets/images/logo/vr_logobg.png" alt="Logo" width="120" height="90" class="mb-2">
                        <h3 class="form--title mb-1" style="font-weight:700;">Realtor Login</h3>
                        <p class="text-muted mb-0">Sign in to your account</p>
                    </div>
                    <form class="mb-0" method="post" name="signin">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email" required placeholder="Enter your email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" name="password" id="password" required placeholder="Enter your password">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="signin" class="btn btn-primary btn-lg w-100">Sign In</button>
                        </div>
                        <div class="form-group text-center mb-2">
                            <!-- <a href="forgot-password.php" class="text-decoration-none link-custom">Forgot your password?</a> -->
                        </div>
                        <!-- <div class="form-group text-center mb-0">
                            <span class="text-muted">Don't have an account?</span>
                            <a href="register.php" class="text-decoration-none link-custom">Register Now</a>
                        </div> -->
                    </form>
                </div>
            </div>
            <!-- Image & Quote Column -->
            <div class="col-12 col-lg-6 d-flex flex-column align-items-center justify-content-center mt-5 mt-lg-0 mb-5">
                <img src="assets/images/page-titles/agent_login_pic.jpg" alt="Agent Login" style="width:100%;max-width:500px;height:380px;object-fit:cover; border-radius:1rem; margin-bottom:20px;">
                <div class="w-100 text-center mt-3 mb-4" style="font-size:1.1rem; color:#22223b;">
                    <i class="fas fa-quote-left" style="color:#2ec4b6;"></i>
                    <span style="font-style:italic;">"Unlock your potential. Every great journey begins with a single login."</span>
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