<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>

<style>
/* ===== MODERN RESPONSIVE HEADER DESIGN ===== */

/* Header Base Styles */
.modern-header {
    background: linear-gradient(135deg, #260844 0%, #3d0e7e 100%);
    box-shadow: 0 2px 20px rgba(38,8,68,0.15);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.3s ease;
}

.modern-header.scrolled {
    background: rgba(38,8,68,0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 30px rgba(38,8,68,0.2);
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    max-width: 1200px;
    margin: 0 auto;
    height: 80px;
}

/* Logo Styles */
.header-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    z-index: 1001;
}

.header-logo img {
    height: 60px;
    width: 60px;
    border-radius: 50%;
    border: 2px solid #C29425;
    transition: transform 0.3s ease;
}

.header-logo:hover img {
    transform: scale(1.05);
}

.logo-text {
    margin-left: 12px;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 700;
    display: none;
}

/* Desktop Navigation */
.desktop-nav {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 30px;
}

.desktop-nav li {
    position: relative;
}

.desktop-nav a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    padding: 8px 0;
    text-transform: capitalize;
    transition: all 0.3s ease;
    position: relative;
}

.desktop-nav a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #C29425;
    transition: width 0.3s ease;
}

.desktop-nav a:hover::after,
.desktop-nav a.active::after {
    width: 100%;
}

.desktop-nav a:hover {
    color: #C29425;
}

/* CTA Button */
.header-cta {
    background: linear-gradient(135deg, #C29425 0%, #FFD700 100%);
    color: #260844;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(194,148,37,0.3);
    color: #260844;
    text-decoration: none;
}

/* Mobile Menu Toggle */
.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
    padding: 8px;
    border: none;
    background: none;
    z-index: 1001;
}

.mobile-menu-toggle span {
    width: 25px;
    height: 3px;
    background: #fff;
    margin: 3px 0;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.mobile-menu-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.mobile-menu-toggle.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* Mobile Navigation */
.mobile-nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: linear-gradient(135deg, #260844 0%, #3d0e7e 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: 1000;
}

.mobile-nav.active {
    transform: translateX(0);
}

.mobile-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
}

.mobile-nav-list li {
    margin: 20px 0;
}

.mobile-nav-list a {
    color: #fff;
    text-decoration: none;
    font-size: 1.5rem;
    font-weight: 600;
    text-transform: capitalize;
    transition: all 0.3s ease;
    display: block;
    padding: 15px 30px;
    border-radius: 10px;
}

.mobile-nav-list a:hover {
    color: #C29425;
    background: rgba(255,255,255,0.1);
    transform: translateX(10px);
}

/* User Account Dropdown */
.user-account {
    position: relative;
}

.user-account-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    padding: 8px 15px;
    border-radius: 20px;
    background: rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.user-account-toggle:hover {
    background: rgba(194,148,37,0.2);
    color: #C29425;
    text-decoration: none;
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1002;
}

.user-account:hover .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-dropdown a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 5px;
}

.user-dropdown a:hover {
    background: #f8f9fa;
    color: #260844;
}

/* Responsive Design */
@media (max-width: 991px) {
    .header-container {
        padding: 0 15px;
    }
    
    .desktop-nav {
        gap: 20px;
    }
    
    .desktop-nav a {
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .desktop-nav {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: flex;
    }
    
    .header-container {
        height: 70px;
    }
    
    .header-logo img {
        height: 50px;
        width: 50px;
    }
    
    .logo-text {
        display: block;
        font-size: 1.1rem;
    }
    
    .header-cta {
        display: none;
    }
}

@media (max-width: 480px) {
    .header-container {
        padding: 0 10px;
        height: 65px;
    }
    
    .header-logo img {
        height: 45px;
        width: 45px;
    }
    
    .logo-text {
        font-size: 1rem;
    }
    
    .mobile-nav-list a {
        font-size: 1.3rem;
        padding: 12px 25px;
    }
}

/* Animation for smooth page load */
.modern-header {
    animation: slideDown 0.5s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
    }
    to {
        transform: translateY(0);
    }
}

/* ===== END MODERN RESPONSIVE HEADER ===== */
</style>
<header class="modern-header" id="modern-header">
    <div class="header-container">
        <!-- Logo -->
        <a href="index.php" class="header-logo">
            <img src="assets/images/logo/vr_logo.jpg" alt="Vasantham Realty Logo">
            <span class="logo-text">Vasantham Realty</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav">
            <li><a href="index.php" class="nav-link">Home</a></li>
            <li><a href="about.php" class="nav-link">About Us</a></li>
            <li><a href="services.php" class="nav-link">Services</a></li>
            <li><a href="blog.php" class="nav-link">Blog</a></li>
            <li><a href="properties-grid.php" class="nav-link">Properties</a></li>
            <li><a href="contact.php" class="nav-link">Contact</a></li>
        </nav>

        <!-- Right Side Actions -->
        <div class="header-actions">
            <?php if (empty($_SESSION['remsuid'])) { ?>
                <a href="for-enquiry.php" class="header-cta">
                    <i class="fa fa-phone"></i>
                    <span>For Enquiry</span>
                </a>
            <?php } else { ?>
                <div class="user-account">
                    <a href="#" class="user-account-toggle">
                        <i class="fa fa-user-circle"></i>
                        <span>My Account</span>
                    </a>
                    <div class="user-dropdown">
                        <a href="user-profile.php">
                            <i class="fa fa-user"></i>
                            <span>Agent Profile</span>
                        </a>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav" id="mobile-nav">
        <ul class="mobile-nav-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="properties-grid.php">Properties</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (empty($_SESSION['remsuid'])) { ?>
                <li><a href="for-enquiry.php"><i class="fa fa-phone"></i> For Enquiry</a></li>
            <?php } else { ?>
                <li><a href="user-profile.php"><i class="fa fa-user"></i> Agent Profile</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<script>
// Modern Header JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('modern-header');
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Mobile menu toggle
    mobileToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        mobileNav.classList.toggle('active');
        document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
    });
    
    // Close mobile menu when clicking on links
    document.querySelectorAll('.mobile-nav-list a').forEach(link => {
        link.addEventListener('click', function() {
            mobileToggle.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
    
    // Active navigation highlighting
    const currentPage = window.location.pathname.split('/').pop();
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage || 
            (currentPage === '' && link.getAttribute('href') === 'index.php')) {
            link.classList.add('active');
        }
    });
    
    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            mobileToggle.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>