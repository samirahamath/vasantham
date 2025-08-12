<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CPoppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <title>Vasantham Realty | Home Page</title>
</head>

<body>
    <div id="wrapper" class="wrapper clearfix">
        <?php include_once('includes/header.php');?>
        
        <!-- Banner Slider Section -->
        <section id="banner-slider" class="banner-slider">
            <div class="owl-carousel banner-carousel">
                <?php
                $bannerQuery = mysqli_query($con, "SELECT * FROM tblbanner WHERE Status='Active' ORDER BY DisplayOrder ASC");
                while($banner = mysqli_fetch_array($bannerQuery)) {
                ?>
                <div class="banner-slide">
                    <div class="banner-image">
                        <img src="assets/images/banners/<?php echo $banner['BannerImage']; ?>" alt="<?php echo $banner['BannerName']; ?>">
                        <div class="banner-overlay"></div>
                    </div>
                    <div class="banner-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                                    <?php if(!empty($banner['BannerTitle'])) { ?>
                                    <h1 class="banner-title" data-animation="fadeInUp" data-delay="300ms">
                                        <?php echo $banner['BannerTitle']; ?>
                                    </h1>
                                    <?php } ?>
                                    
                                    <?php if(!empty($banner['BannerSubtitle'])) { ?>
                                    <p class="banner-subtitle" data-animation="fadeInUp" data-delay="500ms">
                                        <?php echo $banner['BannerSubtitle']; ?>
                                    </p>
                                    <?php } ?>
                                    
                                    <?php if(!empty($banner['ButtonText']) && !empty($banner['ButtonLink'])) { ?>
                                    <div class="banner-actions" data-animation="fadeInUp" data-delay="700ms">
                                        <a href="<?php echo $banner['ButtonLink']; ?>" class="btn btn-banner">
                                            <?php echo $banner['ButtonText']; ?>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>

        <style>
        /* ===== RESPONSIVE CSS FRAMEWORK ===== */
        
        /* Cross-browser compatibility and vendor prefixes */
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        
        /* Smooth scrolling for all browsers */
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* CSS Custom Properties for Responsive Design */
        :root {
            /* Responsive spacing */
            --spacing-xs: clamp(0.5rem, 2vw, 1rem);
            --spacing-sm: clamp(1rem, 3vw, 1.5rem);
            --spacing-md: clamp(1.5rem, 4vw, 2rem);
            --spacing-lg: clamp(2rem, 5vw, 3rem);
            --spacing-xl: clamp(3rem, 6vw, 4rem);
            
            /* Responsive typography */
            --font-size-xs: clamp(0.75rem, 2vw, 0.875rem);
            --font-size-sm: clamp(0.875rem, 2.5vw, 1rem);
            --font-size-base: clamp(1rem, 3vw, 1.125rem);
            --font-size-lg: clamp(1.125rem, 3.5vw, 1.25rem);
            --font-size-xl: clamp(1.25rem, 4vw, 1.5rem);
            --font-size-2xl: clamp(1.5rem, 4.5vw, 2rem);
            --font-size-3xl: clamp(2rem, 5vw, 2.5rem);
            
            /* Container widths */
            --container-mobile: 100%;
            --container-tablet: 750px;
            --container-desktop: 1140px;
            
            /* Breakpoints */
            --mobile-small: 320px;
            --mobile-large: 480px;
            --tablet: 768px;
            --desktop: 992px;
        }
        
        /* Mobile-First Base Styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-size: var(--font-size-base);
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Responsive Utility Classes */
        .responsive-container {
            width: 100%;
            max-width: var(--container-mobile);
            margin: 0 auto;
            padding: 0 var(--spacing-sm);
        }
        
        @media (min-width: 768px) {
            .responsive-container {
                max-width: var(--container-tablet);
            }
        }
        
        @media (min-width: 992px) {
            .responsive-container {
                max-width: var(--container-desktop);
            }
        }
        
        /* Touch-friendly elements */
        .touch-target {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Responsive text utilities */
        .text-responsive-sm { font-size: var(--font-size-sm); }
        .text-responsive-base { font-size: var(--font-size-base); }
        .text-responsive-lg { font-size: var(--font-size-lg); }
        .text-responsive-xl { font-size: var(--font-size-xl); }
        
        /* Responsive spacing utilities */
        .spacing-xs { margin: var(--spacing-xs); }
        .spacing-sm { margin: var(--spacing-sm); }
        .spacing-md { margin: var(--spacing-md); }
        .spacing-lg { margin: var(--spacing-lg); }
        
        .p-responsive-xs { padding: var(--spacing-xs); }
        .p-responsive-sm { padding: var(--spacing-sm); }
        .p-responsive-md { padding: var(--spacing-md); }
        .p-responsive-lg { padding: var(--spacing-lg); }
        
        /* Mobile-first responsive grid helpers */
        .mobile-stack > * {
            width: 100%;
            margin-bottom: var(--spacing-sm);
        }
        
        @media (min-width: 768px) {
            .mobile-stack {
                display: flex;
                gap: var(--spacing-md);
            }
            .mobile-stack > * {
                margin-bottom: 0;
            }
        }
        
        /* Responsive image base */
        img {
            max-width: 100%;
            height: auto;
        }
        
        /* Tablet-specific layout optimizations */
        @media (min-width: 768px) and (max-width: 991px) {
            .container {
                padding-left: 20px;
                padding-right: 20px;
            }
            
            /* Tablet property carousel optimization */
            .carousel[data-slide-rs="2"] .property-item {
                margin-bottom: 30px;
            }
            
            /* Tablet services section */
            .services-section .col-md-4 {
                margin-bottom: 30px;
            }
            
            /* Tablet testimonials */
            .testimonials-section .container {
                padding-left: 30px;
                padding-right: 30px;
            }
            
            /* Tablet CTA section */
            .cta .container {
                padding-left: 40px;
                padding-right: 40px;
            }
            
            /* Tablet navigation improvements */
            .touch-target {
                min-height: 48px;
                min-width: 48px;
            }
        }
        
        /* Orientation change handling */
        @media (orientation: landscape) and (max-height: 500px) {
            .banner-slide {
                height: 80vh;
                min-height: 350px;
            }
            
            .banner-title {
                font-size: clamp(1.5rem, 4vw, 2.5rem);
                margin-bottom: 10px;
            }
            
            .banner-subtitle {
                font-size: clamp(0.9rem, 2.5vw, 1.1rem);
                margin-bottom: 15px;
            }
            
            .banner-actions {
                margin-top: 20px;
            }
        }
        
        @media (orientation: portrait) and (max-width: 767px) {
            .search-properties-card {
                margin: -40px 10px 20px 10px;
            }
        }
        
        @media (orientation: landscape) and (max-width: 767px) {
            .search-properties-card {
                margin: -30px 20px 30px 20px;
                padding: 20px 15px;
            }
            
            .search-properties-card .row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .search-properties-card .col-xs-12 {
                flex: 1;
                min-width: 200px;
            }
        }
        
        /* Smooth transitions for orientation changes */
        .banner-slide,
        .banner-title,
        .banner-subtitle,
        .search-properties-card {
            transition: all 0.3s ease;
        }
        
        /* Performance optimizations for mobile */
        @media (max-width: 767px) {
            /* Reduce animations on mobile for better performance */
            .property-item:hover {
                transform: translateY(-2px) scale(1.005);
            }
            
            .service-card:hover,
            .testimonial-card:hover {
                transform: translateY(-2px) scale(1.01);
            }
            
            /* Optimize image rendering */
            .banner-image img,
            .property--img img {
                image-rendering: optimizeQuality;
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
            }
            
            /* Reduce box-shadow complexity on mobile */
            .property-item,
            .service-card,
            .testimonial-card,
            .search-properties-card {
                box-shadow: 0 4px 16px rgba(38,8,68,0.08);
            }
            
            .property-item:hover,
            .service-card:hover,
            .testimonial-card:hover {
                box-shadow: 0 6px 20px rgba(38,8,68,0.12);
            }
        }
        
        /* Critical above-the-fold optimization */
        .banner-slider {
            will-change: transform;
        }
        
        .banner-image img {
            loading: eager; /* Load banner images immediately */
        }
        
        .property--img img {
            loading: lazy; /* Lazy load property images */
        }
        
        /* Optimize carousel performance */
        .owl-carousel {
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        
        /* Responsive testing and debugging utilities */
        .responsive-debug {
            position: fixed;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            z-index: 9999;
            border-radius: 4px;
            display: none;
        }
        
        /* Show debug info in development */
        .responsive-debug.show {
            display: block;
        }
        
        .responsive-debug::after {
            content: 'Mobile';
        }
        
        @media (min-width: 480px) {
            .responsive-debug::after {
                content: 'Mobile Large';
            }
        }
        
        @media (min-width: 768px) {
            .responsive-debug::after {
                content: 'Tablet';
            }
        }
        
        @media (min-width: 992px) {
            .responsive-debug::after {
                content: 'Desktop';
            }
        }
        
        /* Accessibility testing helpers */
        .touch-test {
            outline: 2px dashed transparent;
        }
        
        .touch-test:focus,
        .touch-test:hover {
            outline: 2px dashed #C29425;
        }
        
        /* Ensure all interactive elements are accessible */
        a, button, input, select, textarea, [role="button"] {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
        }
        
        @media (max-width: 767px) {
            /* Mobile touch target validation */
            a:not(.btn), button:not(.btn) {
                padding: 8px;
            }
        }
        
        /* Cross-browser compatibility and final polish */
        
        /* Flexbox fallbacks for older browsers */
        .mobile-stack {
            display: block;
        }
        
        @supports (display: flex) {
            @media (min-width: 768px) {
                .mobile-stack {
                    display: flex;
                }
            }
        }
        
        /* CSS Grid fallbacks */
        @supports not (display: grid) {
            .responsive-grid {
                display: block;
            }
            
            .responsive-grid > * {
                float: left;
                width: 100%;
            }
            
            @media (min-width: 768px) {
                .responsive-grid > * {
                    width: 50%;
                }
            }
            
            @media (min-width: 992px) {
                .responsive-grid > * {
                    width: 33.333%;
                }
            }
        }
        
        /* Enhanced focus styles for accessibility */
        a:focus,
        button:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #C29425;
            outline-offset: 2px;
        }
        
        /* Reduced motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .banner-title {
                text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            }
            
            .btn-banner {
                border: 2px solid #000;
            }
        }
        
        /* Print styles */
        @media print {
            .banner-carousel .owl-nav,
            .banner-carousel .owl-dots,
            .footer-social {
                display: none !important;
            }
            
            .banner-slide {
                height: auto !important;
                min-height: auto !important;
            }
            
            body {
                font-size: 12pt !important;
                line-height: 1.4 !important;
            }
        }
        
        /* Final responsive polish */
        
        /* Ensure images never break layout */
        img {
            max-width: 100%;
            height: auto;
            -ms-interpolation-mode: bicubic;
        }
        
        /* Prevent horizontal scrolling */
        body {
            overflow-x: hidden;
        }
        
        /* Smooth transitions for all interactive elements */
        a, button, input, select, textarea {
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }
        
        /* Optimize font rendering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        
        /* ===== END RESPONSIVE FRAMEWORK ===== */
        
        /* Banner Slider Styles */
        .banner-slider {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .banner-slide {
            position: relative;
            height: 50vh;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (min-width: 768px) {
            .banner-slide {
                height: 60vh;
                min-height: 400px;
            }
        }
        
        @media (min-width: 992px) {
            .banner-slide {
                height: 70vh;
                min-height: 500px;
            }
        }

        .banner-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .banner-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(38,8,68,0.7) 0%, rgba(38,8,68,0.4) 100%);
            z-index: 2;
        }

        .banner-content {
            position: relative;
            z-index: 3;
            width: 100%;
            color: white;
            text-align: center;
            padding: 0 20px;
        }

        .banner-title {
            color: #FFD700;
            font-size: clamp(1.8rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: clamp(1px, 0.5vw, 2px);
            text-shadow: 0 4px 24px rgba(0,0,0,0.3);
            margin-bottom: var(--spacing-sm);
            line-height: 1.2;
            font-family: 'Poppins', sans-serif;
        }

        .banner-subtitle {
            color: #ffffff;
            font-size: clamp(1rem, 3vw, 1.3rem);
            font-weight: 400;
            margin-bottom: var(--spacing-md);
            text-shadow: 0 2px 12px rgba(0,0,0,0.3);
            line-height: 1.5;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .banner-actions {
            margin-top: 40px;
        }

        .btn-banner {
            background: linear-gradient(135deg, #C29425 0%, #FFD700 100%);
            color: #260844;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 15px 35px;
            border-radius: 30px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 8px 25px rgba(194,148,37,0.3);
        }

        .btn-banner:hover {
            background: linear-gradient(135deg, #FFD700 0%, #C29425 100%);
            color: #260844;
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(194,148,37,0.4);
            text-decoration: none;
        }

        /* Owl Carousel Custom Styles */
        .banner-carousel .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            z-index: 4;
            transform: translateY(-50%);
        }

        .banner-carousel .owl-nav button {
            position: absolute;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            width: 65px;
            height: 65px;
            font-size: 22px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            outline: none;
        }

        .banner-carousel .owl-nav button.owl-prev {
            left: 25px;
        }

        .banner-carousel .owl-nav button.owl-next {
            right: 25px;
        }

        .banner-carousel .owl-nav button:hover {
            background: rgba(194,148,37,0.9);
            border-color: #FFD700;
            transform: scale(1.15);
            box-shadow: 0 8px 25px rgba(194,148,37,0.4);
        }

        .banner-carousel .owl-nav button:active {
            transform: scale(1.05);
        }

        .banner-carousel .owl-nav button span {
            font-size: 24px;
            line-height: 1;
        }

        /* Custom arrow icons */
        .banner-carousel .owl-nav button.owl-prev::before {
            content: '‹';
            font-size: 32px;
            font-weight: bold;
            line-height: 1;
        }

        .banner-carousel .owl-nav button.owl-next::before {
            content: '›';
            font-size: 32px;
            font-weight: bold;
            line-height: 1;
        }

        .banner-carousel .owl-dots {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 4;
            display: flex;
            gap: 12px;
        }

        .banner-carousel .owl-dots .owl-dot {
            display: inline-block;
            margin: 0;
        }

        .banner-carousel .owl-dots .owl-dot span {
            display: block;
            width: 14px;
            height: 14px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .banner-carousel .owl-dots .owl-dot.active span,
        .banner-carousel .owl-dots .owl-dot:hover span {
            background: #FFD700;
            border-color: #FFD700;
            transform: scale(1.4);
            box-shadow: 0 4px 15px rgba(255,215,0,0.4);
        }

        /* Responsive Navigation Styles */
        @media (max-width: 991px) {
            .banner-carousel .owl-nav button {
                width: 55px;
                height: 55px;
                font-size: 18px;
            }
            
            .banner-carousel .owl-nav button.owl-prev {
                left: 20px;
            }
            
            .banner-carousel .owl-nav button.owl-next {
                right: 20px;
            }

            .banner-carousel .owl-nav button.owl-prev::before,
            .banner-carousel .owl-nav button.owl-next::before {
                font-size: 28px;
            }
        }

        @media (max-width: 767px) {
            .banner-carousel .owl-nav button {
                width: 45px;
                height: 45px;
                font-size: 16px;
            }
            
            .banner-carousel .owl-nav button.owl-prev {
                left: 15px;
            }
            
            .banner-carousel .owl-nav button.owl-next {
                right: 15px;
            }

            .banner-carousel .owl-nav button.owl-prev::before,
            .banner-carousel .owl-nav button.owl-next::before {
                font-size: 24px;
            }

            .banner-carousel .owl-dots {
                bottom: 20px;
            }

            .banner-carousel .owl-dots .owl-dot span {
                width: 12px;
                height: 12px;
            }
        }

        @media (max-width: 480px) {
            .banner-carousel .owl-nav button {
                width: 40px;
                height: 40px;
            }

            .banner-carousel .owl-nav button.owl-prev::before,
            .banner-carousel .owl-nav button.owl-next::before {
                font-size: 20px;
            }
        }

        /* Tablet-specific optimizations */
        @media (min-width: 768px) and (max-width: 991px) {
            .banner-content {
                padding: 0 30px;
            }
            
            .btn-banner {
                padding: 14px 30px;
                font-size: 1.1rem;
            }
            
            .search-properties-card {
                margin: -60px auto 40px auto;
                padding: 30px 25px;
            }
            
            .search-properties-card .form-group {
                margin-bottom: 20px;
            }
            
            .search-properties-card select,
            .search-properties-card input[type="submit"] {
                padding: 12px 15px;
                font-size: 1rem;
            }
        }

        /* Mobile banner button optimization */
        @media (max-width: 767px) {
            .btn-banner {
                padding: 12px 25px;
                font-size: 1rem;
            }
            
            .banner-carousel .owl-nav button {
                display: none;
            }
        }

        /* Search Form Styles - Updated positioning */
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
            background-color: #260844;
            color: #fff;
            font-weight: 700;
            border: none;
            box-shadow: 0 2px 8px rgba(38,8,68,0.10);
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s;
        }

        .search-properties-card input[type="submit"]:hover {
            background-color: #3d0e7e;
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

        /* Mobile-first responsive search form */
        @media (max-width: 767px) {
            .search-properties-card {
                margin: -50px auto 30px auto;
                padding: 20px 15px;
                border-radius: 12px;
            }
            
            .search-properties-card .form-group {
                margin-bottom: 15px;
            }
            
            .search-properties-card select,
            .search-properties-card input[type="submit"] {
                width: 100%;
                padding: 14px 15px;
                font-size: 16px; /* Prevents zoom on iOS */
                border-radius: 8px;
                border: 1px solid #ddd;
                min-height: 44px; /* Touch-friendly */
            }
            
            .search-properties-card input[type="submit"] {
                margin-top: 10px;
                font-weight: 700;
                letter-spacing: 1px;
            }
        }

        @media (max-width: 480px) {
            .search-properties-card {
                margin: -40px 15px 20px 15px;
                padding: 15px 12px;
            }
            
            .search-properties-card select,
            .search-properties-card input[type="submit"] {
                padding: 12px 15px;
                font-size: 16px;
            }
        }

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
    font-size: clamp(1rem, 2.8vw, 1.18rem);
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
    color: #1b1919ff;
    font-size: 0.98rem;
   
}
.property--features .feature {
    font-weight: 600;
    color: #260844;
    margin-right: 2px;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .property--img {
        height: 180px;
    }
    .property--content {
        padding: 18px 16px 14px 16px;
    }
    .property-item {
        border-radius: 12px;
        margin-bottom: 24px;
    }
}

@media (max-width: 767px) {
    .property--img {
        height: 160px;
    }
    .property--content {
        padding: 16px 14px 12px 14px;
    }
    .property--features ul {
        gap: 12px;
        flex-wrap: wrap;
    }
    .property--features li {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .property--img {
        height: 140px;
        border-radius: 10px 10px 0 0;
    }
    .property--content {
        padding: 14px 12px 10px 12px;
    }
    .property--features ul {
        gap: 8px;
    }
    .property-item {
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .property--status {
        padding: 4px 12px;
        font-size: 0.9rem;
    }
}
/* --- Services Section --- */
.services-section {
    background: #faf9ff;
}
.section-title {
    color: #260844;
    font-weight: 800;
    font-size: clamp(1.5rem, 4vw, 2.2rem);
    margin-bottom: var(--spacing-xs);
    letter-spacing: clamp(0.5px, 0.3vw, 1px);
}
.section-subtitle {
    color: #555;
    font-size: clamp(1rem, 2.5vw, 1.08rem);
    margin-bottom: var(--spacing-md);
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
/* Enhanced Services Section Mobile Optimization */
@media (max-width: 991px) {
    .service-card {
        min-height: 280px;
        padding: 24px 16px 20px 16px;
        margin-bottom: 24px;
    }
    .testimonial-card {
        min-height: 260px;
        padding: 22px 8px 16px 8px;
    }
    .testimonials-row {
        gap: 12px;
    }
    .service-icon {
        font-size: 2.4rem;
        margin-bottom: 16px;
    }
}

@media (max-width: 767px) {
    .service-card {
        min-height: 240px;
        padding: 20px 15px 16px 15px;
        margin-bottom: 20px;
        border-radius: 12px;
    }
    .service-icon {
        font-size: 2.2rem;
        margin-bottom: 14px;
    }
    .service-card h4 {
        font-size: clamp(1.1rem, 3vw, 1.2rem);
        margin-bottom: 10px;
    }
    .service-card p {
        font-size: clamp(0.95rem, 2.5vw, 1.05rem);
        line-height: 1.5;
    }
}

@media (max-width: 480px) {
    .service-card {
        min-height: 200px;
        padding: 16px 12px 14px 12px;
        margin-bottom: 16px;
        border-radius: 10px;
    }
    .service-icon {
        font-size: 2rem;
        margin-bottom: 12px;
    }
    .testimonial-card {
        min-height: 180px;
        padding: 14px 4px 10px 4px;
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
    font-size: clamp(1.2rem, 4vw, 2.1rem);
    font-weight: 700;
    margin-bottom: var(--spacing-md);
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

<!-- Search Form -->
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
    
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script>
    $(document).ready(function(){
        // Orientation change handling
        function handleOrientationChange() {
            // Force layout recalculation
            $('.banner-carousel').trigger('refresh.owl.carousel');
            $('.testimonials-carousel').trigger('refresh.owl.carousel');
            
            // Adjust banner height on orientation change
            setTimeout(function() {
                $(window).trigger('resize');
            }, 100);
        }
        
        // Listen for orientation changes
        $(window).on('orientationchange', function() {
            setTimeout(handleOrientationChange, 300);
        });
        
        // Handle resize events for smooth transitions with throttling
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                $('.banner-carousel').trigger('refresh.owl.carousel');
                $('.testimonials-carousel').trigger('refresh.owl.carousel');
            }, 250);
        });
        
        // Performance optimization: Reduce carousel autoplay on mobile
        var isMobile = window.innerWidth <= 767;
        var autoplayTimeout = isMobile ? 8000 : 6000;
        
        // Responsive testing utilities
        function addResponsiveDebugger() {
            if (!$('.responsive-debug').length) {
                $('body').append('<div class="responsive-debug"></div>');
            }
        }
        
        // Test touch interactions
        function testTouchTargets() {
            $('a, button, input, select').each(function() {
                var $el = $(this);
                var height = $el.outerHeight();
                var width = $el.outerWidth();
                
                if (height < 44 || width < 44) {
                    console.warn('Touch target too small:', $el[0], 'Size:', width + 'x' + height);
                }
            });
        }
        
        // Test responsive breakpoints
        function testBreakpoints() {
            var width = $(window).width();
            var breakpoint = '';
            
            if (width < 480) breakpoint = 'Mobile Small';
            else if (width < 768) breakpoint = 'Mobile Large';
            else if (width < 992) breakpoint = 'Tablet';
            else breakpoint = 'Desktop';
            
            console.log('Current breakpoint:', breakpoint, 'Width:', width);
        }
        
        // Run tests on load and resize
        testTouchTargets();
        testBreakpoints();
        
        $(window).on('resize', function() {
            testBreakpoints();
        });
        
        // Final enhancements and progressive enhancement
        
        // Add loading states for better UX
        $('.banner-carousel').on('initialized.owl.carousel', function() {
            $('.banner-slider').addClass('loaded');
        });
        
        // Enhance form accessibility
        $('select, input').on('focus', function() {
            $(this).closest('.form-group').addClass('focused');
        }).on('blur', function() {
            $(this).closest('.form-group').removeClass('focused');
        });
        
        // Add smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 600);
            }
        });
        
        // Lazy loading enhancement for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Add viewport height fix for mobile browsers
        function setViewportHeight() {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
        
        setViewportHeight();
        $(window).on('resize orientationchange', setViewportHeight);
        
        // Banner Carousel with enhanced navigation
        $(".banner-carousel").owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: autoplayTimeout,
            autoplayHoverPause: true,
            animateOut: isMobile ? 'slideOutLeft' : 'fadeOut',
            animateIn: isMobile ? 'slideInRight' : 'fadeIn',
            smartSpeed: isMobile ? 600 : 800,
            navText: ['', ''], // Empty strings since we're using CSS ::before content
            lazyLoad: true,
            responsive: {
                0: { 
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 8000
                },
                768: { 
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 6000
                }
            }
        });

        // Add keyboard navigation for banner
        $(document).keydown(function(e) {
            if (e.keyCode == 37) { // Left arrow key
                $('.banner-carousel').trigger('prev.owl.carousel');
            }
            if (e.keyCode == 39) { // Right arrow key
                $('.banner-carousel').trigger('next.owl.carousel');
            }
        });

        // Add touch/swipe support for mobile
        $('.banner-carousel').on('touchstart', function(e) {
            this.touchStartX = e.originalEvent.touches[0].clientX;
        });

        $('.banner-carousel').on('touchmove', function(e) {
            e.preventDefault();
        });

        $('.banner-carousel').on('touchend', function(e) {
            var touchEndX = e.originalEvent.changedTouches[0].clientX;
            var touchStartX = this.touchStartX;
            
            if (touchEndX < touchStartX - 50) {
                $(this).trigger('next.owl.carousel');
            }
            if (touchEndX > touchStartX + 50) {
                $(this).trigger('prev.owl.carousel');
            }
        });

        // Testimonials Carousel
        $(".testimonials-carousel").owlCarousel({
            items: 2,
            loop: true,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            margin: 24,
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
