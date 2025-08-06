<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    
    <!-- Basic Page Needs
    <!-- Stylesheets -->
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Stylesheets
    ============================================= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title>Vasantham Realty | Home Page</title>
</head>

<body>
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>
        <!-- <hr /> --> <!-- Remove or comment out this line -->
        <!-- Hero Search
============================================= -->
        <style>
/* --- Hero Banner Styles --- */
.hero-banner {
    position: relative;
    width: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #260844;
    overflow: hidden;
    margin-top: 0;
    box-shadow: 0 8px 32px rgba(38,8,68,0.10);
}
.hero-banner .carousel {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 1;
}
.hero-banner .carousel .slide--item,
.hero-banner .carousel .slide--item .bg-section {
    height: 100vh;
    min-height: 500px;
}
.hero-banner .carousel img {
    width: 100vw;
    height: 100vh;
    object-fit: cover;
    filter: brightness(0.6) blur(0.5px);
    transition: filter 0.3s;
}
.hero-banner .banner-content {
    position: relative;
    z-index: 2;
    width: 100%;
    text-align: center;
    color: #fff;
    padding: 0 20px;
}
.hero-banner h1 {
    color: #FFD700;
    font-size: 3.2rem;
    font-weight: 800;
    letter-spacing: 2px;
    text-shadow: 0 4px 24px rgba(38,8,68,0.25);
    margin-bottom: 0.5em;
    line-height: 1.1;
    font-family: 'Poppins', 'Open Sans', Arial, sans-serif;
    animation: fadeInDown 1s;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px);}
    to { opacity: 1; transform: translateY(0);}
}

/* --- Search Form Styles --- */
.search-properties-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(38,8,68,0.16);
    padding: 36px 28px 20px 28px;
    margin: -70px auto 48px auto;
    max-width: 950px;
    position: relative;
    z-index: 10;
    border: 1px solid #f2f2f2;
    transition: box-shadow 0.2s;
}
.search-properties-card:hover {
    box-shadow: 0 12px 40px rgba(38,8,68,0.22);
}
.search-properties-card .form-group {
    margin-bottom: 18px;
}
.search-properties-card input[type="submit"] {
    background-color: #260844; /* Solid dark violet */
    color: #fff;
    font-weight: 700;
    border: none;
    box-shadow: 0 2px 8px rgba(38,8,68,0.10);
    letter-spacing: 1px;
    cursor: pointer;
    transition: background-color 0.2s, box-shadow 0.2s;
}

.search-properties-card input[type="submit"]:hover {
    background-color: #3d0e7e; /* Slightly lighter on hover */
    box-shadow: 0 4px 16px rgba(38,8,68,0.18);
}

.search-properties-card select {
    background-image: url('data:image/svg+xml;utf8,<svg fill="gray" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 18px 18px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .search-properties-card {
        padding: 20px 8px 10px 8px;
        margin: -40px auto 24px auto;
    }
    .hero-banner h1 {
        font-size: 2.1rem;
    }
}
@media (max-width: 767px) {
    .hero-banner {
        min-height: 120px !important;
        height: 120px !important;
    }
    .hero-banner .mobile-banner-img {
        display: block !important;
        width: 100vw !important;
        height: 120px !important;
        object-fit: cover;
        object-position: top;
    }
    .hero-banner .carousel {
        display: none !important;
    }
    .hero-banner .banner-content {
        top: 50%;
        transform: translateY(-50%);
        position: absolute;
        width: 100%;
        padding: 0 10px;
    }
}
@media (min-width: 768px) {
    .hero-banner .mobile-banner-img {
        display: none !important;
    }
}

<style>
/* --- Latest Properties Carousel Card Styles --- */
.property-item {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 32px rgba(38,8,68,0.10);
    margin-bottom: 36px;
    padding: 0;
    overflow: hidden;
    border: 1px solid #ece9f3;
    transition: box-shadow 0.25s, transform 0.18s;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}
.property-item:hover {
    box-shadow: 0 12px 40px rgba(38,8,68,0.18);
    transform: translateY(-4px) scale(1.01);
}
.property--img {
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
    border-radius: 18px 18px 0 0;
    background: #f2f2f2;
}
.property--img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
    border-radius: 18px 18px 0 0;
}
.property-item:hover .property--img img {
    transform: scale(1.06);
}
.property--status {
    position: absolute;
    top: 16px;
    left: 16px;
    background: #260844;
    color: #fff;
    border-radius: 8px;
    padding: 5px 16px;
    font-size: 1rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(38,8,68,0.10);
    z-index: 2;
    letter-spacing: 0.5px;
}
.property--content {
    padding: 22px 24px 16px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}
.property--info {
    margin-bottom: 12px;
}
.property--title a {
    color: #260844;
    font-weight: 700;
    font-size: 1.18rem;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: color 0.2s;
    line-height: 1.3;
}
.property--title a:hover {
    color: #C29425;
}
.property--location {
    color: #555;
    font-size: 1rem;
    margin-bottom: 4px;
    margin-top: 4px;
}
.property--price {
    color: #C29425;
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 8px;
}
.property--features ul {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
    display: flex;
    gap: 18px;
}
.property--features li {
    color: #444;
    font-size: 0.98rem;
    background: #f7f6fb;
    border-radius: 6px;
    padding: 4px 10px;
    margin-right: 4px;
}
.property--features .feature {
    font-weight: 600;
    color: #260844;
    margin-right: 2px;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .property--img {
        height: 160px;
    }
    .property--content {
        padding: 14px 10px 10px 10px;
    }
    .property-item {
        border-radius: 12px;
    }
}
@media (max-width: 600px) {
    .property--img {
        height: 110px;
        border-radius: 10px 10px 0 0;
    }
    .property--title a {
        font-size: 1rem;
    }
    .property--features ul {
        gap: 8px;
    }
    .property-item {
        border-radius: 8px;
    }
}
/* --- Services Section --- */
.services-section {
    background: #faf9ff;
}
.section-title {
    color: #260844;
    font-weight: 800;
    font-size: 2.2rem;
    margin-bottom: 10px;
    letter-spacing: 1px;
}
.section-subtitle {
    color: #555;
    font-size: 1.08rem;
    margin-bottom: 30px;
}
.service-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(38,8,68,0.08);
    padding: 36px 22px 28px 22px;
    margin-bottom: 30px;
    transition: box-shadow 0.2s, transform 0.2s;
    min-height: 320px;
}
.service-card:hover {
    box-shadow: 0 8px 32px rgba(38,8,68,0.14);
    transform: translateY(-4px) scale(1.03);
}
.service-icon {
    font-size: 2.8rem;
    color: #C29425;
    margin-bottom: 18px;
}
.service-card h4 {
    color: #260844;
    font-weight: 700;
    margin-bottom: 12px;
}
.service-card p {
    color: #555;
    font-size: 1.05rem;
}

/* --- Testimonials Section --- */
.testimonials-section {
    background: #fff;
}
.testimonials-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 24px;
}
.testimonial-card {
    background: #faf9ff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(38,8,68,0.08);
    padding: 32px 22px 24px 22px;
    margin-bottom: 30px;
    text-align: center;
    transition: box-shadow 0.2s, transform 0.2s;
    min-height: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.testimonial-card:hover {
    box-shadow: 0 8px 32px rgba(38,8,68,0.14);
    transform: translateY(-4px) scale(1.03);
}
.testimonial-avatar img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 18px;
    border: 3px solid #C29425;
}
.testimonial-text {
    color: #444;
    font-size: 1.08rem;
    font-style: italic;
    margin-bottom: 18px;
}
.testimonial-name {
    color: #260844;
    font-weight: 700;
    margin-bottom: 2px;
}
.testimonial-role {
    color: #C29425;
    font-size: 0.98rem;
    font-weight: 600;
}
.testimonials-carousel .owl-nav {
    display: flex;
    justify-content: center;
    margin-top: 18px;
    gap: 18px;
}
.testimonials-carousel .owl-nav button {
    background: #260844;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    font-size: 1.5rem;
    transition: background 0.2s;
    outline: none;
}
.testimonials-carousel .owl-nav button:hover {
    background: #C29425;
    color: #fff;
}
@media (max-width: 991px) {
    .service-card, .testimonial-card {
        min-height: 260px;
        padding: 22px 8px 16px 8px;
    }
    .testimonials-row {
        gap: 12px;
    }
}
@media (max-width: 600px) {
    .service-card, .testimonial-card {
        min-height: 180px;
        padding: 14px 4px 10px 4px;
    }
    .section-title {
        font-size: 1.3rem;
    }
}

/* Professional BG Section */


.cta {
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
    padding bottom: 60px; /* Add this line or increase value as needed */
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
    opacity: 0.35;
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
        display: flex;
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
    }
\end{code}
.cta .col-xs-12.col-sm-12.col-md-6.col-md-offset-3 {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
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
/* ...existing code... */
</style>

<section id="heroSearch" class="hero-banner">
    <!-- Banner/Carousel for desktop/tablet -->
    <div class="carousel slider-navs" data-slide="1" data-slide-rs="1" data-autoplay="true" data-nav="true" data-dots="false" data-space="0" data-loop="true" data-speed="800">
        <!-- Slide #1 -->
        <div class="slide--item">
            <div class="bg-section">
                <img src="assets/images/slider/slide-bg/7.jpg" alt="background">
            </div>
        </div>
        <!-- Slide #2 -->
        <div class="slide--item bg-overlay bg-overlay-dark3">
            <div class="bg-section">
                <img src="assets/images/slider/slide-bg/8.jpg" alt="background">
            </div>
        </div>
        <!-- Slide #3 -->
        <div class="slide--item bg-overlay bg-overlay-dark3">
            <div class="bg-section">
                <img src="assets/images/slider/slide-bg/9.jpg" alt="background">
            </div>
        </div>
    </div>
    <!-- Static banner image for mobile -->
    <img class="mobile-banner-img" src="assets/images/slider/slide-bg/7.jpg" alt="background" style="display:none; filter:brightness(0.6);">
    <!-- Banner Content -->
    <div class="banner-content">
        <h1>Find Your Favorite Property</h1>
    </div>
</section>

<!-- Search Form BELOW the banner -->
<div class="container">
    <div class="search-properties-card">
        <form class="mb-0" method="post" name="search" action="property-search.php">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <select name="city" id="city" required>
                            <option value="">Select City</option>
                            <?php
                            $query=mysqli_query($con,"select distinct City from  tblproperty");
                            while($row=mysqli_fetch_array($query))
                            {
                            ?>
                            <option value="<?php echo $row['City'];?>"><?php echo $row['City'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <select name="type" id="type" required>
                            <option value="">Select Property Type</option>
                            <?php $query1=mysqli_query($con,"select distinct Type from tblproperty");
                            while($row1=mysqli_fetch_array($query1))
                            {
                            ?>      
                            <option value="<?php echo $row1['Type'];?>"><?php echo $row1['Type'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <select name="status" id="status" required>
                            <option value="">Select Any Status</option>
                            <?php
                            $query2=mysqli_query($con,"select distinct Status from  tblproperty");
                            while($row2=mysqli_fetch_array($query2))
                            {
                            ?>
                            <option value="<?php echo $row2['Status'];?>"><?php echo $row2['Status'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <input type="submit" value="Search" name="search" class="btn btn--primary btn--block">
                </div>
            </div>
        </form>
    </div>
</div>

        <!-- properties-carousel
============================================= -->
        <section id="properties-carousel" class="properties-carousel pt-90 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="heading heading-2 text-center mb-70">
                            <h2 class="heading--title">Latest Properties</h2>
                        </div>
                        <!-- .heading-title end -->
                    </div>
                    <!-- .col-md-12 end -->
                </div>
                <!-- .row end -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="carousel carousel-dots" data-slide="3" data-slide-rs="2" data-autoplay="true" data-nav="false" data-dots="true" data-space="25" data-loop="true" data-speed="800">
                            <!-- .property-item #1 -->
                            <?php
                      
$query=mysqli_query($con,"select * from tblproperty order by rand() limit 9");
while($row=mysqli_fetch_array($query))
{
?>
                            <div class="property-item">
                                <div class="property--img">
                                    <a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
                        <img src="propertyimages/<?php echo $row['FeaturedImage'];?>" alt="<?php echo $row['PropertyTitle'];?>" width='380' height='300'>
                        <span class="property--status"><?php echo $row['Status'];?></span>
                        </a>
                                </div>
                                <div class="property--content">
                                    <div class="property--info">
                                        <h5 class="property--title"><a href="single-property-detail.php?proid=<?php echo $row['ID'];?>">
    <?php echo $row['PropertyTitle'];?></a></h5>
                                        <p class="property--location"><?php echo $row['Address'];?>&nbsp;
<?php echo $row['City'];?>&nbsp;
<?php echo $row['State'];?>&nbsp;  
<?php echo $row['Country'];?></p>
                                        <p class="property--price"><?php echo $row['RentorsalePrice'];?></p>
                                    </div>
                                    <!-- .property-info end -->
                                    <div class="property--features">
                                        <ul class="list-unstyled mb-0">
                                            <li><span class="feature">Beds:</span><span class="feature-num"><?php echo $row['Bedrooms'];?></span></li>
                                            <li><span class="feature">Baths:</span><span class="feature-num"><?php echo $row['Bathrooms'];?></span></li>
                                            <li><span class="feature">Area:</span><span class="feature-num"><?php echo $row['Area'];?></span></li>
                                        </ul>
                                    </div>
                                    <!-- .property-features end -->
                                </div>
                            </div>
                            <?php } ?>


                        </div>
                        <!-- .carousel end -->
                    </div>
                    <!-- .col-md-12 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container -->
        </section>
        <!-- #properties-carousel  end  -->

        <!-- Feature



        <!-- Services Section -->
<section id="services" class="services-section pt-90 pb-60">
    <div class="container">
        <div class="row text-center mb-50">
            <div class="col-xs-12">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">We offer a wide range of real estate services to help you buy, sell, or rent your property with ease.</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-home"></i></div>
                    <h4>Property Buying</h4>
                    <p>Find your dream home from our extensive property listings with expert guidance at every step.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-building"></i></div>
                    <h4>Property Selling</h4>
                    <p>Sell your property quickly and at the best price with our marketing and negotiation expertise.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-key"></i></div>
                    <h4>Property Renting</h4>
                    <p>Rent out your property or find the perfect rental with our trusted network and support.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-search"></i></div>
                    <h4>Property Valuation</h4>
                    <p>Get accurate and professional property valuation reports to make informed decisions.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-gavel"></i></div>
                    <h4>Legal Assistance</h4>
                    <p>Receive expert le    gal advice and support for all your real estate transactions and documentation.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="fa fa-handshake-o"></i></div>
                    <h4>Loan Consulting</h4>
                    <p>Our team helps you find the best home loan options and guides you through the approval process.</p>
                </div>
            </div>
        </div>
    </div>
</section>

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

<section id="testimonials" class="testimonials-section pt-90 pb-90">
    <di class="container">
        <div class="row text-center mb-50">
            <div class="col-xs-12">
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-subtitle">Real stories from happy buyers, sellers, and renters.</p>
            </div>
        </div>
<div class="owl-carousel testimonials-carousel">
    <div class="testimonial-card">
        <div class="testimonial-avatar">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Client">
        </div>
        <p class="testimonial-text">"Vasantham Realty made buying our first home a breeze. The team was professional, patient, and always available!"</p>
        <h5 class="testimonial-name">Priya S.</h5>
        <span class="testimonial-role">Home Buyer</span>
    </div>
    <div class="testimonial-card">
        <div class="testimonial-avatar">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client">
        </div>
        <p class="testimonial-text">"I sold my property above market price thanks to their expert marketing. Highly recommended!"</p>
        <h5 class="testimonial-name">Ramesh K.</h5>
        <span class="testimonial-role">Seller</span>
    </div>
    <div class="testimonial-card">
        <div class="testimonial-avatar">
            <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Client">
        </div>
        <p class="testimonial-text">"The rental process was smooth and transparent. I found the perfect apartment in no time."</p>
        <h5 class="testimonial-name">Anita M.</h5>
        <span class="testimonial-role">Renter</span>
    </div>
    <div class="testimonial-card">
        <div class="testimonial-avatar">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Client">
        </div>
        <p class="testimonial-text">"Excellent service and very friendly staff. I highly recommend Vasantham Realty for all your property needs."</p>
        <h5 class="testimonial-name">Chandran P.</h5>
        <span class="testimonial-role">Tenant</span>
    </div>
    <div class="testimonial-card">
        <div class="testimonial-avatar">
            <img src="https://randomuser.me/api/portraits/men/77.jpg" alt="Client">
        </div>
        <p class="testimonial-text">"They helped me find a great investment property. The process was smooth and transparent."</p>
        <h5 class="testimonial-name">Krishna S.</h5>
        <span class="testimonial-role">Investor</span>
    </div>
</div>
        </div>
        <!-- .row end -->
    </div>
    <!-- .container end --> 
<!-- CTA Section: Full width, left to right -->


<?php include_once('includes/footer.php');?>
    
    <!-- #wrapper end -->

    <!-- Footer Scripts
============================================= -->
    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
$(document).ready(function(){
    $(".testimonials-carousel").owlCarousel({
        items: 2, // Show 2 at a time
        loop: true,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        margin: 24, // Add space between cards
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ],
        responsive: {
            0: { items: 1 },
            768: { items: 2 }
        }
    });
});
</script>
</body>

</html>
