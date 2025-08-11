<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $property_type = $_POST['property_type'];
    $location = $_POST['location'];
    $budget = $_POST['budget'];
    $purpose = $_POST['purpose'];
    $bedrooms = $_POST['bedrooms'];
    $additional = $_POST['additional'];
    $message = $_POST['message'];
    // Insert into DB
    $query = mysqli_query($con, "INSERT INTO tblenquiry (FullName, Phone, Email, PropertyType, Location, Budget, Purpose, Bedrooms, Additional, Message) VALUES ('$fullname', '$phone', '$email', '$property_type', '$location', '$budget', '$purpose', '$bedrooms', '$additional', '$message')");
    if($query) {
        echo "<script>alert('Your enquiry has been submitted successfully. We will contact you soon.');</script>";
        echo "<script>window.location.href='for-enquiry.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again. MySQL Error: ".mysqli_error($con)."');</script>";
    }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Property Enquiry</title>
</head>
<body>
<div id="wrapper" class="wrapper clearfix">
    <?php include_once('includes/header.php');?>
    <hr />
    <section id="for-enquiry" class="contact contact-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                    <div class="heading heading-2 mb-55 text-center">
                        <h2 class="heading--title">Property Enquiry Form</h2>
                        <p class="heading--desc">Fill in your requirements and our team will get in touch with you soon.</p>
                    </div>
                    <form id="enquiryForm" name="enquiryform" method="post" action="">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="fullname">Full Name *</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" maxlength="10" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="property_type">Property Type *</label>
                                    <input type="text" class="form-control" name="property_type" id="property_type" placeholder="e.g. Apartment, Villa, Land, Commercial" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="location">Location / Area Preference</label>
                                    <input type="text" class="form-control" name="location" id="location" placeholder="Enter preferred location or area">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="budget">Budget Range</label>
                                    <input type="text" class="form-control" name="budget" id="budget" placeholder="e.g. 30-50 Lakhs">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="purpose">Purpose *</label>
                                    <input type="text" class="form-control" name="purpose" id="purpose" placeholder="e.g. Buy, Rent, Lease, Invest" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="bedrooms">Number of Bedrooms</label>
                                    <input type="text" class="form-control" name="bedrooms" id="bedrooms" placeholder="e.g. 1BHK, 2BHK, 3BHK, 4BHK+ or NA">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="additional">Additional Requirements</label>
                                    <input type="text" class="form-control" name="additional" id="additional" placeholder="e.g. Pool, Parking, Furnished">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="message">Message / Comments</label>
                                    <textarea class="form-control" name="message" id="message" rows="4" placeholder="Any special notes or preferences"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" name="submit" class="btn btn-lg" style="background-color: #260844; border-color: #260844;">Submit Enquiry</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include_once('includes/footer.php');?>
</div>
<script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/functions.js"></script>
<script>
    document.getElementById('enquiryForm').addEventListener('submit', function(e) {
        var fullname = document.getElementById('fullname').value.trim();
        var phone = document.getElementById('phone').value.trim();
        var email = document.getElementById('email').value.trim();
        if (fullname === '') {
            alert('Please enter your full name');
            e.preventDefault();
            return false;
        }
        if (phone.length !== 10 || !/^\d+$/.test(phone)) {
            alert('Please enter a valid 10-digit phone number');
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
