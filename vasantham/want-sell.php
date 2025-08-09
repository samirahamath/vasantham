<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $city = $_POST['city'];
    $message = $_POST['message'];

    $query = mysqli_query($con, "INSERT INTO tblwanttosell(YourName, YourMobile, YourPhone, YourEmail, Address, Location, City, YourMessage) 
                                 VALUES('$name', '$mobile', '$phone', '$email', '$address', '$location', '$city', '$message')");
    
    if($query)
    {
        echo "<script>alert('Your request has been submitted successfully. We will contact you soon.');</script>";
        echo "<script>window.location.href='want-sell.php'</script>";
    }
    else
    {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <title>Real Estate Management System || Want to Sell</title>
</head>

<body>
    <!-- Document Wrapper -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>

        <hr />
        
      

        <!-- Want to Sell Form Section -->
        <section id="want-sell" class="contact contact-1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                        <div class="heading heading-2 mb-55 text-center">
                            <h2 class="heading--title">Sell Your Property</h2>
                            <p class="heading--desc">Provide your property details and contact information. Our experts will evaluate your property and provide you with the best selling options.</p>
                        </div>
                        
                        <form id="sellForm" name="sellform" method="post" action="">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number *</label>
                                        <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="Enter your mobile number" pattern="[0-9]{10}" maxlength="10" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="address">Property Address</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter complete property address">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="location">Location/Area</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter location or area name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter city name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="message">Additional Information</label>
                                        <textarea class="form-control" name="message" id="message" rows="5" placeholder="Tell us about your property (type, size, age, special features, expected price range, etc.)"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" name="submit" class="btn btn-lg" style="background-color: #260844; border-color: #260844;">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once('includes/footer.php');?>
    </div>

    <!-- Footer Scripts -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
    
    <script>
        // Form validation
        document.getElementById('sellForm').addEventListener('submit', function(e) {
            var mobile = document.getElementById('mobile').value;
            var email = document.getElementById('email').value;
            var name = document.getElementById('name').value;
            
            if (name.trim() === '') {
                alert('Please enter your name');
                e.preventDefault();
                return false;
            }
            
            if (mobile.length !== 10 || !/^\d+$/.test(mobile)) {
                alert('Please enter a valid 10-digit mobile number');
                e.preventDefault();
                return false;
            }
            
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address');
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>