<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');
include('../includes/banner-functions.php');

// Fix session check logic
if (!isset($_SESSION['remsaid']) || strlen($_SESSION['remsaid']) == 0) {
  header('location:logout.php');
  exit();
}

// Initialize error and msg variables to avoid undefined variable warnings
$error = '';
$msg = '';

if(isset($_POST['submit'])) {
    $bannerName = $_POST['bannername'];
    $bannerDescription = isset($_POST['bannerdescription']) ? $_POST['bannerdescription'] : '';
    $adminId = $_SESSION['remsaid'];

    // Ensure BannerManager and ImageUploadHandler classes exist
    if (!class_exists('BannerManager') || !class_exists('ImageUploadHandler')) {
        $error = "Required classes are missing. Please check your includes.";
    } else {
        // Initialize managers
        $bannerManager = new BannerManager($con);
        $imageUploader = new ImageUploadHandler();

        // Validate form data
        if(empty($bannerName)) {
            $error = "Banner name is required";
        } else {
            $bannerImageFilename = '';
            // Only upload if file is selected
            if(isset($_FILES['bannerimage']) && !empty($_FILES['bannerimage']['name'])) {
                $uploadResult = $imageUploader->uploadBannerImage($_FILES['bannerimage']);
                if($uploadResult['success']) {
                    $bannerImageFilename = $uploadResult['filename'];
                } else {
                    $error = $uploadResult['error'];
                }
            }
            // Always provide a value for BannerImage (use a default if not uploaded)
            if($bannerImageFilename === '') {
                $bannerImageFilename = 'default.jpg'; // Make sure this file exists in your banners folder
            }
            // Use empty($error) to check for errors
            if(empty($error)) {
                // Add banner to database (BannerImage will never be empty)
                $bannerId = $bannerManager->addBanner(
                    $bannerName,
                    $bannerImageFilename,
                    $bannerDescription,
                    $adminId
                );
                if($bannerId) {
                    $msg = "Banner added successfully";
                    echo "<script>alert('Banner added successfully'); window.location='manage-banners.php';</script>";
                    exit();
                } else {
                    $error = "Error adding banner to database: " . mysqli_error($con);
                    // Delete uploaded image if database insert failed
                    if($bannerImageFilename && $bannerImageFilename !== 'default.jpg') $imageUploader->deleteBannerImage($bannerImageFilename);
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <title>Add Banner || REMS</title>
    <style>
        .image-preview {
            max-width: 300px;
            max-height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-top: 10px;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 4px;
        }
        .image-preview-text {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }
        .form-group label {
            font-weight: 600;
        }
        .required {
            color: red;
        }
    </style>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php include_once('includes/header.php');?>
        <?php include_once('includes/sidebar.php');?>
        
        <div class="dashboard-wrapper">
            <div class="dashboard-finance">
                <div class="container-fluid dashboard-content">
                    <!-- Page header -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h3 class="mb-2">Add New Banner</h3>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="manage-banners.php" class="breadcrumb-link">Banner Management</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <?php if(isset($msg)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo $msg; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="mt-2">
                                <a href="manage-banners.php" class="btn btn-sm btn-outline-success">View All Banners</a>
                                <a href="add-banner.php" class="btn btn-sm btn-outline-primary">Add Another Banner</a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if(isset($error)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <!-- Add Banner Form -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Banner Details</h5>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" id="bannerForm">
                                        <input type="hidden" name="submit" value="1" />
                                        <div class="form-group">
                                            <label for="bannername">Banner Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="bannername" name="bannername" 
                                                   placeholder="Enter banner name (e.g., Welcome Banner, Property Showcase)" 
                                                   value="<?php echo isset($bannerName) ? htmlspecialchars($bannerName) : ''; ?>" 
                                                   required maxlength="255">
                                            <small class="form-text text-muted">This name is for admin reference only and won't be displayed on the website.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="bannerimage">Banner Image <span class="required">*</span></label>
                                            <input type="file" class="form-control-file" id="bannerimage" name="bannerimage" 
                                                   accept="image/jpeg,image/jpg,image/png,image/gif" required>
                                            <small class="form-text text-muted">
                                                Supported formats: JPG, JPEG, PNG, GIF. Maximum size: 5MB. 
                                                Recommended dimensions: 1920x600px for best results. (Optional)
                                            </small>
                                            
                                            <!-- Image Preview -->
                                            <div id="imagePreview" class="image-preview" style="display: none;">
                                                <img id="previewImg" src="" alt="Preview">
                                                <div class="image-preview-text">Image Preview</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="bannerdescription">Banner Description</label>
                                            <textarea class="form-control" id="bannerdescription" name="bannerdescription" 
                                                      rows="4" placeholder="Enter banner description or alt text (optional)"><?php echo isset($bannerDescription) ? htmlspecialchars($bannerDescription) : ''; ?></textarea>
                                            <small class="form-text text-muted">This description can be used as alt text for accessibility and SEO purposes.</small>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-save"></i> Add Banner
                                            </button>
                                            <a href="manage-banners.php" class="btn btn-secondary btn-lg ml-2">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Help Panel -->
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header bg-light">
                                    <i class="fas fa-info-circle"></i> Banner Guidelines
                                </h5>
                                <div class="card-body">
                                    <h6><i class="fas fa-image text-primary"></i> Image Requirements</h6>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-check text-success"></i> Format: JPG, PNG, GIF</li>
                                        <li><i class="fas fa-check text-success"></i> Max size: 5MB</li>
                                        <li><i class="fas fa-check text-success"></i> Recommended: 1920x600px</li>
                                        <li><i class="fas fa-check text-success"></i> Aspect ratio: 16:5</li>
                                    </ul>

                                    <h6><i class="fas fa-lightbulb text-warning"></i> Best Practices</h6>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-arrow-right text-muted"></i> Use high-quality images</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Ensure text is readable</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Optimize for mobile viewing</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Keep file size reasonable</li>
                                    </ul>

                                    <h6><i class="fas fa-cog text-info"></i> After Adding</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-right text-muted"></i> Banner will be active by default</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Appears immediately on homepage</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Can be reordered later</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Can be deactivated anytime</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Current Banner Stats -->
                            <div class="card mt-3">
                                <h5 class="card-header bg-light">
                                    <i class="fas fa-chart-bar"></i> Current Statistics
                                </h5>
                                <div class="card-body">
                                    <?php 
                                    $bannerManager = new BannerManager($con);
                                    $stats = $bannerManager->getBannerStatistics();
                                    ?>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-primary"><?php echo $stats['total']; ?></h4>
                                            <small class="text-muted">Total Banners</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-success"><?php echo $stats['active']; ?></h4>
                                            <small class="text-muted">Active Banners</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include_once('includes/footer.php');?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/libs/js/main-js.js"></script>

    <script>
        // Image preview functionality
        document.getElementById('bannerimage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (file) {
                // Validate file size (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size too large. Maximum size is 5MB.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Invalid file type. Please select a JPG, PNG, or GIF image.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Form validation
        document.getElementById('bannerForm').addEventListener('submit', function(e) {
            const bannerName = document.getElementById('bannername').value.trim();
            // const bannerImage = document.getElementById('bannerimage').files[0];
            
            if (!bannerName) {
                alert('Please enter a banner name.');
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Banner...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>