<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    
<!-- sulaiman sulai asdfghjk-->
    <!-- Fonts
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Stylesheets
    ============================================= -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
/* Page Title Section */
#page-title {
    position: relative;
    min-height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, #260844 60%, #c29425 100%);
    overflow: hidden;
}
#page-title .bg-section img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.35;
    position: absolute;
    top: 0; left: 0; z-index: 0;
}
#page-title .title--heading h1 {
    font-size: 2.8rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: 2px;
    margin-bottom: 10px;
    text-shadow: 0 4px 24px rgba(38,8,68,0.25);
}
#page-title .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
    color: #fff;
}
#page-title .breadcrumb li,
#page-title .breadcrumb li a {
    color: #fff;
    font-weight: 500;
    font-size: 1.05rem;
}
#page-title .breadcrumb li.active {
    color: #C29425;
}

/* About Section */
#about {
    padding: 60px 0 40px 0;
    background: #fff;
}
.about--img img {
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(38,8,68,0.13);
    margin-bottom: 18px;
    max-width: 100%;
    height: auto;
}
.heading.heading-3 .heading--title {
    font-size: 2.1rem;
    font-weight: 700;
    color: #260844;
    margin-bottom: 18px;
    letter-spacing: 1px;
}
.about--panel {
    background: #f7f6fb;
    border-radius: 12px;
    padding: 28px 24px;
    box-shadow: 0 2px 12px rgba(38,8,68,0.06);
    font-size: 1.08rem;
    color: #333;
    line-height: 1.7;
    margin-bottom: 18px;
}
@media (max-width: 991px) {
    #about .about--img {
        margin-bottom: 24px;
        text-align: center;
    }
    #about .col-xs-12 {
        text-align: center;
    }
}

/* CTA Section */
.cta.cta-1 {
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    background: #260844;
    overflow: hidden;
    color: #fff;
    z-index: 1;
    padding: 70px 0 60px 0;
}
.cta .bg-section {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 0;
    overflow: hidden;
}
.cta .bg-section img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.32;
}
.cta .container, .cta .row, .cta [class^="col-"] {
    position: relative;
    z-index: 2;
}
.cta h3 {
    color: #fff;
    font-size: 2.1rem;
    font-weight: 700;
    margin-bottom: 24px;
    text-shadow: 0 2px 12px rgba(38,8,68,0.18);
}
.cta .btn--primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #C29425;
    color: #fff;
    font-weight: 700;
    border-radius: 6px;
    padding: 12px 36px;
    font-size: 1.1rem;
    border: none;
    transition: background 0.2s;
    margin-top: 10px;
    box-shadow: 0 2px 12px rgba(38,8,68,0.10);
}
.cta .btn--primary:hover {
    background: #a07a1c;
    color: #fff;
}
@media (max-width: 767px) {
    .cta h3 {
        font-size: 1.2rem;
    }
    .cta .btn--primary {
        padding: 8px 18px;
        font-size: 1rem;
    }
}


</style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title>Real Estate Management System|| About Us</title>
</head>

<body>
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>

            <hr />
        <!-- Page Title #1
============================================ -->
        <section id="page-title" style="margin-top:-3%" class="page-title bg-overlay bg-overlay-dark2">
            <div class="bg-section">
                <img src="assets/images/page-titles/1.jpg" width="100%" height="220" alt="Background" />
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <div class="title title-1 text-center">
                            <div class="title--content">
                                <div class="title--heading">
                                    <h1>About</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">About</li>
                                </ol>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- .title end -->
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
            </div>
            <!-- .container end -->
        </section>
        <!-- #page-title end -->

        <!-- about #1
============================================= -->
        <section id="about" class="about bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5">
                        <div class="about--img"><img class="img-responsive" src="assets/images/about/real-estate.jpg" width="350" height="350" alt="about img"></div>
                    </div>
                    <!-- .col-md-5 -->
                    <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-1">
                        <?php

                    
$ret=mysqli_query($con,"select * from tblpage where PageType='aboutus'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                        <div class="heading heading-3">
                            <h2 class="heading--title"><?php echo $row['PageTitle'];?></h2>
                        </div>
                        <!-- .heading-title end -->
                        <div class="about--panel">
                            
                            <p><?php  echo $row['PageDescription'];?></p>
                        </div>
                        <!-- .about-panel end -->
                       
                        <!-- .about-panel end -->
                    </div>
                   <?php } ?>
                </div>
                
            </div>
            <!-- .container -->
        </section>
        <!-- #about end -->


      

<section id="cta" class="cta cta-1 text-center bg-overlay bg-overlay-dark pt-90">
    <div class="bgg-section">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                <h3>Join our professional team & agents to start selling your house</h3>
                <a href="contact.php" class="btn btn--primary">Contact</a>
            </div>
            <!-- .col-md-6 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</section>
        <!-- #cta1 end -->
        <!-- Footer #1
============================================= -->
        <?php include_once('includes/footer.php');?>
       
    </div>
    <!-- #wrapper end -->

    <!-- Footer Scripts
============================================= -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
</body>

</html>