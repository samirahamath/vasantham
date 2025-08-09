<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blog_id <= 0) {
    header('Location: blog.php');
    exit();
}

// Fetch blog details
$query = "SELECT * FROM tblblogs WHERE ID = ? AND Status = 'Active'";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: blog.php');
    exit();
}

$blog = $result->fetch_assoc();

// Fetch related blogs (excluding current blog)
$related_query = "SELECT * FROM tblblogs WHERE ID != ? AND Status = 'Active' ORDER BY CreationDate DESC LIMIT 3";
$related_stmt = $con->prepare($related_query);
$related_stmt->bind_param("i", $blog_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($blog['BlogDescription']), 0, 160)); ?>">
    
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
            background: #f8f9fa;
        }

        /* Single Blog Container */
        .single-blog-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        /* Blog Header */
        .blog-hero {
            position: relative;
            height: 500px;
            overflow: hidden;
        }

        .blog-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
            display: flex;
            align-items: flex-end;
            padding: 40px;
        }

        .blog-hero-content {
            color: white;
            max-width: 800px;
        }

        .blog-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            gap: 25px;
            font-size: 1rem;
            opacity: 0.9;
        }

        .blog-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .blog-meta i {
            font-size: 1.1rem;
        }

        /* Blog Content */
        .blog-content {
            padding: 50px 40px;
        }

        .blog-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            max-width: 800px;
            margin: 0 auto;
        }

        .blog-description p {
            margin-bottom: 20px;
        }

        /* Navigation */
        .blog-navigation {
            background: #f8f9fa;
            padding: 30px 40px;
            border-top: 1px solid #e9ecef;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .nav-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            color: white;
            text-decoration: none;
        }

        .nav-btn.back-btn {
            background: #95a5a6;
            box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3);
        }

        .nav-btn.back-btn:hover {
            background: #7f8c8d;
            box-shadow: 0 6px 20px rgba(149, 165, 166, 0.4);
        }

        /* Related Blogs Section */
        .related-blogs {
            background: #f8f9fa;
            padding: 50px 40px;
            border-top: 1px solid #e9ecef;
        }

        .related-blogs-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 40px;
        }

        .related-blogs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .related-blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .related-blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .related-blog-image {
            height: 180px;
            overflow: hidden;
        }

        .related-blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-blog-card:hover .related-blog-image img {
            transform: scale(1.05);
        }

        .related-blog-content {
            padding: 20px;
        }

        .related-blog-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .related-blog-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .related-blog-title a:hover {
            color: #3498db;
        }

        .related-blog-date {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .related-blog-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .single-blog-container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .blog-hero {
                height: 300px;
            }
            
            .blog-hero-overlay {
                padding: 20px;
            }
            
            .blog-title {
                font-size: 2rem;
            }
            
            .blog-meta {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .blog-content {
                padding: 30px 20px;
            }
            
            .blog-navigation {
                padding: 20px;
            }
            
            .nav-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .related-blogs {
                padding: 30px 20px;
            }
            
            .related-blogs-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        /* Default image for blogs without images */
        .default-blog-image {
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        /* Animation */
        .single-blog-container {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <title><?php echo htmlspecialchars($blog['BlogTitle']); ?> - DailyGlam Blog</title>
</head>

<body>
<div id="wrapper" class="wrapper clearfix">
    <?php include_once('includes/header.php'); ?>

    <!-- Single Blog Container -->
    <div class="single-blog-container">
        <!-- Blog Hero Section -->
        <div class="blog-hero">
            <?php if ($blog['BlogImage'] && file_exists('assets/images/blogs/' . $blog['BlogImage'])) { ?>
                <img src="assets/images/blogs/<?php echo htmlspecialchars($blog['BlogImage']); ?>" 
                     alt="<?php echo htmlspecialchars($blog['BlogTitle']); ?>" 
                     class="blog-hero-image">
            <?php } else { ?>
                <div class="blog-hero-image default-blog-image">
                    <i class="fas fa-newspaper"></i>
                </div>
            <?php } ?>
            
            <div class="blog-hero-overlay">
                <div class="blog-hero-content">
                    <h1 class="blog-title"><?php echo htmlspecialchars($blog['BlogTitle']); ?></h1>
                    <div class="blog-meta">
                        <div class="blog-meta-item">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($blog['CreatedByName'] ?: 'Admin'); ?></span>
                        </div>
                        <div class="blog-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span><?php echo date('F d, Y', strtotime($blog['CreationDate'])); ?></span>
                        </div>
                        <div class="blog-meta-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo date('g:i A', strtotime($blog['CreationDate'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Content -->
        <div class="blog-content">
            <div class="blog-description">
                <?php echo nl2br(htmlspecialchars($blog['BlogDescription'])); ?>
            </div>
        </div>

        <!-- Blog Navigation -->
        <div class="blog-navigation">
            <div class="nav-buttons">
                <a href="blog.php" class="nav-btn back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Blog
                </a>
                
                <div class="social-share">
                    <!-- You can add social sharing buttons here if needed -->
                </div>
            </div>
        </div>

        <!-- Related Blogs Section -->
        <?php if ($related_result && $related_result->num_rows > 0) { ?>
            <div class="related-blogs">
                <h3 class="related-blogs-title">Related Stories</h3>
                <div class="related-blogs-grid">
                    <?php while ($related_blog = $related_result->fetch_assoc()) { ?>
                        <article class="related-blog-card">
                            <?php if ($related_blog['BlogImage'] && file_exists('assets/images/blogs/' . $related_blog['BlogImage'])) { ?>
                                <div class="related-blog-image">
                                    <img src="assets/images/blogs/<?php echo htmlspecialchars($related_blog['BlogImage']); ?>" 
                                         alt="<?php echo htmlspecialchars($related_blog['BlogTitle']); ?>">
                                </div>
                            <?php } else { ?>
                                <div class="related-blog-image default-blog-image" style="height: 180px; font-size: 2rem;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            <?php } ?>
                            
                            <div class="related-blog-content">
                                <h4 class="related-blog-title">
                                    <a href="single-blog.php?id=<?php echo $related_blog['ID']; ?>">
                                        <?php echo htmlspecialchars($related_blog['BlogTitle']); ?>
                                    </a>
                                </h4>
                                <div class="related-blog-date">
                                    <?php echo date('M d, Y', strtotime($related_blog['CreationDate'])); ?>
                                </div>
                                <div class="related-blog-excerpt">
                                    <?php
                                        $desc = strip_tags($related_blog['BlogDescription']);
                                        echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                                    ?>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for navigation
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

        // Add loading state for images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
            
            img.addEventListener('error', function() {
                // Replace with default image on error
                const defaultDiv = document.createElement('div');
                defaultDiv.className = 'default-blog-image';
                defaultDiv.innerHTML = '<i class="fas fa-newspaper"></i>';
                defaultDiv.style.height = this.style.height || '100%';
                this.parentNode.replaceChild(defaultDiv, this);
            });
        });

        // Add click tracking for related blogs
        document.querySelectorAll('.related-blog-card a').forEach(link => {
            link.addEventListener('click', function() {
                console.log('Related blog clicked:', this.href);
            });
        });
    });
</script>

</body>
</html>