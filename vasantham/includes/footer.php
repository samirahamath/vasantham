<style>
    .footer-modern {
  background-color: #1a1a1a;
  color: #eee;
  padding-top: 30px;
  font-family: 'Poppins', sans-serif;
}

.footer-top {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 40px;
  border-bottom: 1px solid #444;
  padding-bottom: 60px;
}

.footer-left, .footer-links, .footer-right {
  flex: 1 1 300px;
  min-width: 250px;
}

.footer-left h4,
.footer-links h4 {
  font-size: 1.2rem;
  color: #fff;
  margin-bottom: 16px;
}

.footer-desc {
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 20px;
  color: #ccc;
}

.footer-contact {
  padding: 0;
  list-style: none;
  margin: 0 0 20px 0;
}

.footer-contact li {
  font-size: 0.9rem;
  color: #ccc;
  margin-bottom: 6px;
}

.footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
  columns: 2;
}

.footer-links ul li {
  margin-bottom: 8px;
}

.footer-links ul li a {
  color: #ccc;
  text-decoration: none;
  transition: color 0.2s ease;
}

.footer-links ul li a:hover {
  color: #C29425;
}

.footer-right {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.footer-image {
  width: 100%;
  max-width: 280px;
  border-radius: 8px;
  margin-bottom: 18px;
}

.footer-social {
  display: flex;
  gap: 16px;
  justify-content: center;
}

.footer-social .social-icon {
  color: #ccc;
  font-size: 1.4rem;
  transition: color 0.3s;
  text-decoration: none;
}

.footer-social .social-icon:hover {
  color: #C29425;
}

/* Footer Bottom */
.footer-bottom {
  padding: 18px 0;
  font-size: 0.9rem;
  background: #111;
  color: #aaa;
  margin-top: 40px;
}

/* Mobile responsive styles removed - footer will maintain desktop layout on all devices */

/* ===== MOBILE-ONLY FOOTER DESIGN ===== */

/* Hide mobile footer on desktop */
.mobile-footer {
  display: none;
}

/* Show mobile footer only on mobile devices */
@media (max-width: 768px) {
  /* Hide desktop footer on mobile */
  .footer-modern {
    display: none !important;
  }
  
  /* Show mobile footer */
  .mobile-footer {
    display: block;
    background: linear-gradient(135deg, #260844 0%, #1a1a1a 100%);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    padding: 0;
    margin: 0;
  }
  
  .mobile-footer-container {
    padding: 30px 15px 0;
  }
  
  /* Mobile Footer Header */
  .mobile-footer-header {
    text-align: center;
    padding: 25px 0;
    border-bottom: 1px solid rgba(194,148,37,0.3);
    margin-bottom: 25px;
  }
  
  .mobile-footer-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
  }
  
  .mobile-footer-logo img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #C29425;
    margin-right: 12px;
  }
  
  .mobile-footer-title {
    color: #C29425;
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
  }
  
  .mobile-footer-tagline {
    color: #ccc;
    font-size: 0.9rem;
    margin: 8px 0 0 0;
  }
  
  /* Mobile Quick Actions */
  .mobile-quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 25px;
  }
  
  .mobile-action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 10px;
    background: rgba(194,148,37,0.1);
    border: 1px solid rgba(194,148,37,0.3);
    border-radius: 12px;
    color: #C29425;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    min-height: 60px;
  }
  
  .mobile-action-btn i {
    margin-right: 8px;
    font-size: 1.1rem;
  }
  
  .mobile-action-btn:hover {
    background: rgba(194,148,37,0.2);
    color: #FFD700;
    transform: translateY(-2px);
    text-decoration: none;
  }
  
  /* Mobile Contact Info */
  .mobile-contact-section {
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
  }
  
  .mobile-contact-title {
    color: #C29425;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
  }
  
  .mobile-contact-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .mobile-contact-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  
  .mobile-contact-item:last-child {
    border-bottom: none;
  }
  
  .mobile-contact-item i {
    color: #C29425;
    width: 25px;
    margin-right: 12px;
    font-size: 1rem;
  }
  
  .mobile-contact-item span,
  .mobile-contact-item a {
    color: #ccc;
    font-size: 0.9rem;
    text-decoration: none;
    line-height: 1.4;
  }
  
  .mobile-contact-item a:hover {
    color: #C29425;
  }
  
  /* Mobile Navigation Links */
  .mobile-nav-section {
    margin-bottom: 25px;
  }
  
  .mobile-nav-title {
    color: #C29425;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
  }
  
  .mobile-nav-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
  }
  
  .mobile-nav-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    color: #ccc;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    min-height: 45px;
  }
  
  .mobile-nav-link:hover {
    background: rgba(194,148,37,0.1);
    color: #C29425;
    text-decoration: none;
  }
  
  .mobile-nav-link::before {
    content: '→';
    color: #C29425;
    margin-right: 8px;
    font-weight: bold;
  }
  
  /* Mobile Social Media */
  .mobile-social-section {
    text-align: center;
    margin-bottom: 25px;
  }
  
  .mobile-social-title {
    color: #C29425;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
  }
  
  .mobile-social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
  }
  
  .mobile-social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(194,148,37,0.1);
    border: 2px solid rgba(194,148,37,0.3);
    border-radius: 50%;
    color: #C29425;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
  }
  
  .mobile-social-icon:hover {
    background: #C29425;
    color: #260844;
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 8px 20px rgba(194,148,37,0.3);
  }
  
  /* Mobile Footer Bottom */
  .mobile-footer-bottom {
    background: rgba(0,0,0,0.3);
    padding: 20px 15px;
    text-align: center;
    border-top: 1px solid rgba(194,148,37,0.2);
  }
  
  .mobile-footer-copyright {
    color: #aaa;
    font-size: 0.85rem;
    margin: 0;
  }
  
  .mobile-footer-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 10px;
  }
  
  .mobile-footer-links a {
    color: #aaa;
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.3s ease;
  }
  
  .mobile-footer-links a:hover {
    color: #C29425;
  }
}

@media (max-width: 480px) {
  .mobile-footer-container {
    padding: 25px 10px 0;
  }
  
  .mobile-quick-actions {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  
  .mobile-nav-grid {
    grid-template-columns: 1fr;
    gap: 6px;
  }
  
  .mobile-social-icons {
    gap: 12px;
  }
  
  .mobile-social-icon {
    width: 42px;
    height: 42px;
    font-size: 1rem;
  }
  
  .mobile-footer-links {
    flex-direction: column;
    gap: 8px;
  }
}

/* ===== END MOBILE-ONLY FOOTER ===== */
</style>

<!-- Link Font Awesome (Social Icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<footer id="footer" class="footer-modern">
  <div class="container">
    <div class="footer-top">
      <!-- Left: About + Contact -->
      <div class="footer-left">
        <h4>About Us</h4>
        <p class="footer-desc">
          Vasantham Realty is a leading real estate agency in Tiruchirappalli, Tamil Nadu, specializing in residential and commercial properties. With a commitment to excellence and customer satisfaction, we help clients find their dream homes and investment opportunities.
      </p>
        <h4>Hours</h4>
        <ul class="footer-contact">
          <li>Mon - Sun: 10 AM - 06 PM</li>
          <li>Site Visiting : Anytime </li>
         
        </ul>
        <ul class="footer-contact">
          <!-- <li><strong>Phone:</strong> +45 677 8993000 223</li> -->
            <li><strong>Email:</strong> <a href="mailto:office@vasanthamrealty.com" style="color: #ccc; text-decoration: underline;">office@vasanthamrealty.com</a></li>
            <li><strong>Address:</strong> <a href="https://www.google.com/maps/place/10%C2%B047'38.4%22N+78%C2%B040'42.8%22E/@10.7940053,78.6759807,17z/data=!3m1!4b1!4m4!3m3!8m2!3d10.794!4d78.6785556?entry=ttu&g_ep=EgoyMDI1MDcyOS4wIKXMDSoASAFQAw%3D%3D" target="_blank" style="color: #ccc; text-decoration: underline;">192, 1st St, Ponnagar Extension, Karumandapam, Tiruchirappalli, Tamil Nadu 620001, India</a></li>
          </ul>
      </div>

      <!-- Center: Useful Links -->
      <div class="footer-links">
        <div>
          <h4>Useful Links</h4>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="properties-grid.php">Properties</a></li>
            <li><a href="testimonials.php">Testimonials</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="featured-properties.php">Featured Properties</a></li>
            <li><a href="want-sell.php">Want to Sell</a></li>
            <li><a href="want-buy.php">Want to Buy</a></li>
            <li><a href="join-us.php">Join Us</a></li>
          </ul>
        </div>
      </div>

      <!-- Right: Image + Social -->
      <div class="footer-right">
        <img src="assets/images/logo/vr_logobg.png" width="180" height="150" alt="Promo" class="footer-image">
        <div class="footer-social">
          <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a> 
          <a href="https://www.google.com/maps/place/10%C2%B047'38.4%22N+78%C2%B040'42.8%22E/@10.7940053,78.6759807,17z/data=!3m1!4b1!4m4!3m3!8m2!3d10.794!4d78.6785556?entry=ttu&g_ep=EgoyMDI1MDcyOS4wIKXMDSoASAFQAw%3D%3D" class="social-icon"><i class="fa fa-map"></i></a>   
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom text-center">
    <p>© <?php echo date("Y"); ?> Vasantham Realty. All Rights Reserved.</p>
  </div>
</footer>

<!-- Mobile-Only Footer (Hidden on Desktop) -->
<footer class="mobile-footer">
  <div class="mobile-footer-container">
    
    <!-- Mobile Footer Header -->
    <div class="mobile-footer-header">
      <div class="mobile-footer-logo">
        <img src="assets/images/logo/vr_logo.jpg" alt="Vasantham Realty Logo">
        <div>
          <h3 class="mobile-footer-title">Vasantham Realty</h3>
          <p class="mobile-footer-tagline">Your Dream Home Partner</p>
        </div>
      </div>
    </div>
    
    <!-- Mobile Quick Actions -->
    <div class="mobile-quick-actions">
      <a href="tel:+919876543210" class="mobile-action-btn">
        <i class="fas fa-phone"></i>
        <span>Call Now</span>
      </a>
      <a href="mailto:office@vasanthamrealty.com" class="mobile-action-btn">
        <i class="fas fa-envelope"></i>
        <span>Email Us</span>
      </a>
      <a href="https://wa.me/919876543210" class="mobile-action-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span>WhatsApp</span>
      </a>
      <a href="https://www.google.com/maps/place/10%C2%B047'38.4%22N+78%C2%B040'42.8%22E/@10.7940053,78.6759807,17z/data=!3m1!4b1!4m4!3m3!8m2!3d10.794!4d78.6785556?entry=ttu&g_ep=EgoyMDI1MDcyOS4wIKXMDSoASAFQAw%3D%3D" class="mobile-action-btn" target="_blank">
        <i class="fas fa-map-marker-alt"></i>
        <span>Location</span>
      </a>
    </div>
    
    <!-- Mobile Contact Info -->
    <div class="mobile-contact-section">
      <h4 class="mobile-contact-title">Contact Information</h4>
      <ul class="mobile-contact-list">
        <li class="mobile-contact-item">
          <i class="fas fa-clock"></i>
          <span>Mon - Sun: 10 AM - 06 PM</span>
        </li>
        <li class="mobile-contact-item">
          <i class="fas fa-eye"></i>
          <span>Site Visiting: Anytime</span>
        </li>
        <li class="mobile-contact-item">
          <i class="fas fa-envelope"></i>
          <a href="mailto:office@vasanthamrealty.com">office@vasanthamrealty.com</a>
        </li>
        <li class="mobile-contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Tiruchirappalli, Tamil Nadu</span>
        </li>
      </ul>
    </div>
    
    <!-- Mobile Navigation Links -->
    <div class="mobile-nav-section">
      <h4 class="mobile-nav-title">Quick Links</h4>
      <div class="mobile-nav-grid">
        <a href="index.php" class="mobile-nav-link">Home</a>
        <a href="about.php" class="mobile-nav-link">About Us</a>
        <a href="services.php" class="mobile-nav-link">Services</a>
        <a href="properties-grid.php" class="mobile-nav-link">Properties</a>
        <a href="blog.php" class="mobile-nav-link">Blog</a>
        <a href="contact.php" class="mobile-nav-link">Contact</a>
        <a href="testimonials.php" class="mobile-nav-link">Testimonials</a>
        <a href="faq.php" class="mobile-nav-link">FAQ</a>
      </div>
    </div>
    
    <!-- Mobile Social Media -->
    <div class="mobile-social-section">
      <h4 class="mobile-social-title">Follow Us</h4>
      <div class="mobile-social-icons">
        <a href="#" class="mobile-social-icon" title="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="mobile-social-icon" title="Twitter">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="mobile-social-icon" title="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="mobile-social-icon" title="YouTube">
          <i class="fab fa-youtube"></i>
        </a>
        <a href="https://www.google.com/maps/place/10%C2%B047'38.4%22N+78%C2%B040'42.8%22E/@10.7940053,78.6759807,17z/data=!3m1!4b1!4m4!3m3!8m2!3d10.794!4d78.6785556?entry=ttu&g_ep=EgoyMDI1MDcyOS4wIKXMDSoASAFQAw%3D%3D" class="mobile-social-icon" title="Location" target="_blank">
          <i class="fas fa-map-marker-alt"></i>
        </a>
      </div>
    </div>
    
  </div>
  
  <!-- Mobile Footer Bottom -->
  <div class="mobile-footer-bottom">
    <p class="mobile-footer-copyright">© <?php echo date("Y"); ?> Vasantham Realty. All Rights Reserved.</p>
    <div class="mobile-footer-links">
      <a href="privacy-policy.php">Privacy Policy</a>
      <a href="terms-conditions.php">Terms & Conditions</a>
      <a href="sitemap.php">Sitemap</a>
    </div>
  </div>
</footer>
