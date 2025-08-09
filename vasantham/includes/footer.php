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

/* Responsive */
@media (max-width: 768px) {
  .footer-top {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-links ul {
    columns: 1;
  }

  .footer-right {
    margin-top: 30px;
  }
}
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
