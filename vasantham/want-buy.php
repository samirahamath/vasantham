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

    $query = mysqli_query($con, "INSERT INTO tblwanttobuy(YourName, YourMobile, YourPhone, YourEmail, Address, Location, City, YourMessage) 
                                 VALUES('$name', '$mobile', '$phone', '$email', '$address', '$location', '$city', '$message')");
    
    if($query)
    {
        echo "<script>alert('Your request has been submitted successfully. We will contact you soon.');</script>";
        echo "<script>window.location.href='want-buy.php'</script>";
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

    <title>Real Estate Management System || Want to Buy</title>
</head>

<body>
    <!-- Document Wrapper -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>

        <hr />
        
        <!-- Page Title -->
        <!-- <section id="page-title" style="margin-top:-3%" class="page-title bg-overlay bg-overlay-dark2">
            <div class="bg-section">
                <img src="assets/images/page-titles/1.jpg" alt="Background" />
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <div class="title title-1 text-center">
                            <div class="title--content">
                                <div class="title--heading">
                                    <h1>Want to Buy</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Want to Buy</li>
                                </ol>
                                <p class="contact-title-desc" style="margin-top:15px;">
                                    Looking for your dream property? Tell us your requirements and we'll help you find the perfect match.
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Want to Buy Form Section -->
        <section id="want-buy" class="contact contact-1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                        <div class="heading heading-2 mb-55 text-center">
                            <h2 class="heading--title">Find Your Dream Property</h2>
                            <p class="heading--desc">Tell us about your property requirements and budget. Our experts will search and present you with the best available options that match your needs.</p>
                        </div>
                        
                        <form id="buyForm" name="buyform" method="post" action="">
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
                                        <label for="address">Current Address</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter your current address">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="location">Preferred Location/Area</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter preferred location or area">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="city">Preferred City</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter preferred city">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="message">Property Requirements</label>
                                        <textarea class="form-control" name="message" id="message" rows="5" placeholder="Please specify your requirements (property type, budget range, number of bedrooms, preferred amenities, etc.)"></textarea>
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
                
                <!-- Additional Information Section
                <div class="row" style="margin-top: 50px;">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="feature-box feature-box-style2 text-center">
                            <div class="feature-box-icon">
                                <i class="fa fa-search"></i>
                            </div>
                            <div class="feature-box-content">
                                <h3>Property Search</h3>
                                <p>We'll search through our extensive database to find properties that match your criteria.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="feature-box feature-box-style2 text-center">
                            <div class="feature-box-icon">
                                <i class="fa fa-handshake-o"></i>
                            </div>
                            <div class="feature-box-content">
                                <h3>Personalized Service</h3>
                                <p>Our dedicated agents will work with you to understand your needs and preferences.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="feature-box feature-box-style2 text-center">
                            <div class="feature-box-icon">
                                <i class="fa fa-shield"></i>
                            </div>
                            <div class="feature-box-content">
                                <h3>Verified Properties</h3>
                                <p>All properties in our listings are verified and legally cleared for your peace of mind.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
</section>
</div>

        <?php include_once('includes/footer.php');?>
    </div>

    <!-- Footer Scripts -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
    
    <script>
        // Form validation
        document.getElementById('buyForm').addEventListener('submit', function(e) {
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