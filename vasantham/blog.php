<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Fetch all active blogs
$query = "SELECT * FROM tblblogs WHERE Status='Active' ORDER BY CreationDate DESC";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="assets/css/external.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f7fa;
        }

        /* DailyGlam Blog Layout */
        .dailyglam-container {
            max-width: 1400px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 50px rgba(0,0,0,0.1);
            border-radius: 20px;
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Header Section */
        .blog-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
            position: relative;
        }

        .blog-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="80" r="2" fill="white" opacity="0.1"/><circle cx="40" cy="60" r="1" fill="white" opacity="0.05"/></svg>');
        }

        .blog-header-content {
            position: relative;
            z-index: 2;
        }

        .blog-main-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .blog-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Main Content Layout */
        .blog-main-content {
            padding: 40px;
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Blog Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .blog-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .blog-card-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .blog-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog-card:hover .blog-card-image img {
            transform: scale(1.05);
        }

        .blog-card-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.1) 100%);
        }

        .blog-card-content {
            padding: 25px;
        }

        .blog-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .blog-card-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog-card-title a:hover {
            color: #3498db;
        }

        .blog-card-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .blog-card-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog-card-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .read-more-btn:hover {
            background: linear-gradient(135deg, #2980b9, #1f5f8b);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            color: white;
            text-decoration: none;
        }



        /* No blogs message */
        .no-blogs {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .no-blogs i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dailyglam-container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .blog-header {
                padding: 40px 20px;
            }
            
            .blog-main-title {
                font-size: 2.5rem;
            }
            
            .blog-main-content {
                padding: 20px;
            }
            
            .blog-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            .blog-card-meta {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }
            
            .blog-card-content {
                padding: 20px;
            }
        }

        /* Animation */
        .blog-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .blog-card:nth-child(1) { animation-delay: 0.1s; }
        .blog-card:nth-child(2) { animation-delay: 0.2s; }
        .blog-card:nth-child(3) { animation-delay: 0.3s; }
        .blog-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <title>DailyGlam Blog - Latest Stories & Insights</title>
</head>

<body>
<div id="wrapper" class="wrapper clearfix">
    <?php include_once('includes/header.php'); ?>

    <!-- DailyGlam Blog Container -->
    <div class="dailyglam-container">
        <!-- Blog Header -->
        

        <!-- Main Content -->
        <div class="blog-main-content">
            <div class="section-header">
                <h2 class="section-title">Latest Stories</h2>
                <p class="section-subtitle">Discover inspiring stories, insights, and experiences that shape our world</p>
            </div>

            <?php if ($result && $result->num_rows > 0) { ?>
                <div class="blog-grid">
                    <?php while ($blog = $result->fetch_assoc()) { ?>
                        <article class="blog-card">
                            <?php if ($blog['BlogImage']) { ?>
                                <div class="blog-card-image">
                                    <img src="assets/images/blogs/<?php echo htmlspecialchars($blog['BlogImage']); ?>" 
                                         alt="<?php echo htmlspecialchars($blog['BlogTitle']); ?>">
                                </div>
                            <?php } ?>
                            
                            <div class="blog-card-content">
                                <h3 class="blog-card-title">
                                    <a href="single-blog.php?id=<?php echo $blog['ID']; ?>">
                                        <?php echo htmlspecialchars($blog['BlogTitle']); ?>
                                    </a>
                                </h3>
                                
                                <div class="blog-card-meta">
                                    <div class="blog-card-meta-item">
                                        <i class="fas fa-user"></i>
                                        <span><?php echo htmlspecialchars($blog['CreatedByName'] ?: 'Admin'); ?></span>
                                    </div>
                                    <div class="blog-card-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo date('M d, Y', strtotime($blog['CreationDate'])); ?></span>
                                    </div>
                                </div>
                                
                                <div class="blog-card-excerpt">
                                    <?php
                                        $desc = strip_tags($blog['BlogDescription']);
                                        echo strlen($desc) > 150 ? substr($desc, 0, 150) . '...' : $desc;
                                    ?>
                                </div>
                                
                                <a href="single-blog.php?id=<?php echo $blog['ID']; ?>" class="read-more-btn">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="no-blogs">
                    <i class="fas fa-book-open"></i>
                    <h3>No Stories Yet</h3>
                    <p>We're working on bringing you amazing stories. Check back soon!</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    // Add smooth hover effects and animations
    document.addEventListener('DOMContentLoaded', function() {
        // Animate blog cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all blog cards
        document.querySelectorAll('.blog-card').forEach(card => {
            observer.observe(card);
        });

        // Add click tracking for analytics (optional)
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // You can add analytics tracking here
                console.log('Blog read more clicked:', this.href);
            });
        });

        // Smooth scroll for internal links
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

    // Add loading state for images
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.style.display = 'none';
        });
    });
</script
</body>
</html>
