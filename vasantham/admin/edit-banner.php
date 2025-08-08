<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('../includes/banner-functions.php');

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
}

// Get banner ID from URL
$bannerId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($bannerId <= 0) {
    header('location:manage-banners.php');
    exit;
}

// Initialize managers
$bannerManager = new BannerManager($con);
$imageUploader = new ImageUploadHandler();

// Get banner details
$bannerData = $bannerManager->getBannerById($bannerId);
if(!$bannerData) {
    header('location:manage-banners.php');
    exit;
}

// Handle form submission
if(isset($_POST['submit'])) {
    $bannerName = trim($_POST['bannername']);
    $bannerDescription = trim($_POST['bannerdescription']);
    $replaceImage = isset($_POST['replace_image']) && $_POST['replace_image'] == '1';
    
    // Validate form data
    if(empty($bannerName)) {
        $error = "Banner name is required";
    } else {
        $newImageFilename = null;
        $imageUploadSuccess = true;
        $imageError = '';
        
        // Handle image replacement if requested
        if($replaceImage && !empty($_FILES['bannerimage']['name'])) {
            $uploadResult = $imageUploader->uploadBannerImage($_FILES['bannerimage']);
            
            if($uploadResult['success']) {
                $newImageFilename = $uploadResult['filename'];
                // Store old image filename for deletion after successful update
                $oldImageFilename = $bannerData['BannerImage'];
            } else {
                $imageUploadSuccess = false;
                $imageError = $uploadResult['error'];
            }
        }
        
        // Update banner if no image upload errors
        if($imageUploadSuccess) {
            $updateResult = $bannerManager->updateBanner($bannerId, $bannerName, $bannerDescription, $newImageFilename);
            
            if($updateResult) {
                // Delete old image if new image was uploaded successfully
                if($newImageFilename && isset($oldImageFilename)) {
                    $imageUploader->deleteBannerImage($oldImageFilename);
                }
                
                $msg = "Banner updated successfully";
                // Refresh banner data
                $bannerData = $bannerManager->getBannerById($bannerId);
            } else {
                // Delete uploaded image if database update failed
                if($newImageFilename) {
                    $imageUploader->deleteBannerImage($newImageFilename);
                }
                $error = "Error updating banner in database";
            }
        } else {
            $error = "Image upload failed: " . $imageError;
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
    <title>Edit Banner || REMS</title>
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
        .current-image {
            max-width: 300px;
            max-height: 200px;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
        }
        .current-image img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 4px;
        }
        .form-group label {
            font-weight: 600;
        }
        .required {
            color: red;
        }
        .image-replacement-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }
        .checkbox-custom {
            transform: scale(1.2);
            margin-right: 8px;
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
                                <h3 class="mb-2">Edit Banner</h3>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="dashboard.php" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="manage-banners.php" class="breadcrumb-link">Banner Management</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
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
                                <a href="manage-banners.php" class="btn btn-sm btn-outline-success">Back to Banner List</a>
                                <a href="add-banner.php" class="btn btn-sm btn-outline-primary">Add New Banner</a>
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

                    <!-- Edit Banner Form -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Banner Details</h5>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" id="bannerForm">
                                        <div class="form-group">
                                            <label for="bannername">Banner Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="bannername" name="bannername" 
                                                   placeholder="Enter banner name (e.g., Welcome Banner, Property Showcase)" 
                                                   value="<?php echo htmlspecialchars($bannerData['BannerName']); ?>" 
                                                   required maxlength="255">
                                            <small class="form-text text-muted">This name is for admin reference only and won't be displayed on the website.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="bannerdescription">Banner Description</label>
                                            <textarea class="form-control" id="bannerdescription" name="bannerdescription" 
                                                      rows="4" placeholder="Enter banner description or alt text (optional)"><?php echo htmlspecialchars($bannerData['BannerDescription']); ?></textarea>
                                            <small class="form-text text-muted">This description can be used as alt text for accessibility and SEO purposes.</small>
                                        </div>

                                        <!-- Current Image Display -->
                                        <div class="form-group">
                                            <label>Current Banner Image</label>
                                            <div class="current-image">
                                                <img src="../assets/images/banners/<?php echo $bannerData['BannerImage']; ?>" 
                                                     alt="<?php echo htmlspecialchars($bannerData['BannerName']); ?>"
                                                     onerror="this.src='../assets/images/no-image.jpg'">
                                                <div class="image-preview-text">
                                                    <strong>Current Image:</strong> <?php echo htmlspecialchars($bannerData['BannerImage']); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Image Replacement Section -->
                                        <div class="image-replacement-section">
                                            <div class="form-group mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox-custom" id="replace_image" name="replace_image" value="1">
                                                    <label class="custom-control-label" for="replace_image">
                                                        <strong>Replace current image with a new one</strong>
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted">Check this box if you want to upload a new image to replace the current one.</small>
                                            </div>

                                            <div id="imageUploadSection" style="display: none;">
                                                <div class="form-group">
                                                    <label for="bannerimage">New Banner Image</label>
                                                    <input type="file" class="form-control-file" id="bannerimage" name="bannerimage" 
                                                           accept="image/jpeg,image/jpg,image/png,image/gif">
                                                    <small class="form-text text-muted">
                                                        Supported formats: JPG, JPEG, PNG, GIF. Maximum size: 5MB. 
                                                        Recommended dimensions: 1920x600px for best results.
                                                    </small>
                                                    
                                                    <!-- New Image Preview -->
                                                    <div id="newImagePreview" class="image-preview" style="display: none;">
                                                        <img id="previewImg" src="" alt="New Image Preview">
                                                        <div class="image-preview-text">New Image Preview</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-save"></i> Update Banner
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
                            <!-- Banner Info -->
                            <div class="card">
                                <h5 class="card-header bg-light">
                                    <i class="fas fa-info-circle"></i> Banner Information
                                </h5>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <?php if($bannerData['Status'] == 'Active') { ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-secondary">Inactive</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Display Order:</strong></td>
                                            <td><?php echo $bannerData['DisplayOrder']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td><?php echo date('M d, Y', strtotime($bannerData['CreationDate'])); ?></td>
                                        </tr>
                                        <?php if($bannerData['UpdationDate']) { ?>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td><?php echo date('M d, Y', strtotime($bannerData['UpdationDate'])); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                            <!-- Guidelines -->
                            <div class="card mt-3">
                                <h5 class="card-header bg-light">
                                    <i class="fas fa-lightbulb"></i> Edit Guidelines
                                </h5>
                                <div class="card-body">
                                    <h6><i class="fas fa-edit text-primary"></i> Editing Options</h6>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-check text-success"></i> Update name and description anytime</li>
                                        <li><i class="fas fa-check text-success"></i> Keep existing image unchanged</li>
                                        <li><i class="fas fa-check text-success"></i> Replace image optionally</li>
                                        <li><i class="fas fa-check text-success"></i> Changes take effect immediately</li>
                                    </ul>

                                    <h6><i class="fas fa-image text-warning"></i> Image Replacement</h6>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-arrow-right text-muted"></i> Check the replacement box first</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Upload follows same rules as adding</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Old image will be deleted automatically</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Preview new image before saving</li>
                                    </ul>

                                    <h6><i class="fas fa-shield-alt text-info"></i> Safety Features</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-right text-muted"></i> Original image preserved if upload fails</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Database rollback on errors</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Validation prevents corruption</li>
                                        <li><i class="fas fa-arrow-right text-muted"></i> Audit trail maintained</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card mt-3">
                                <h5 class="card-header bg-light">
                                    <i class="fas fa-bolt"></i> Quick Actions
                                </h5>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <?php if($bannerData['Status'] == 'Active') { ?>
                                            <a href="manage-banners.php?action=deactivate&id=<?php echo $bannerId; ?>" 
                                               class="btn btn-warning btn-sm"
                                               onclick="return confirm('Deactivate this banner?')">
                                                <i class="fas fa-eye-slash"></i> Deactivate Banner
                                            </a>
                                        <?php } else { ?>
                                            <a href="manage-banners.php?action=activate&id=<?php echo $bannerId; ?>" 
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Activate this banner?')">
                                                <i class="fas fa-eye"></i> Activate Banner
                                            </a>
                                        <?php } ?>
                                        
                                        <a href="manage-banners.php?action=delete&id=<?php echo $bannerId; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this banner? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i> Delete Banner
                                        </a>
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
        // Toggle image upload section based on checkbox
        document.getElementById('replace_image').addEventListener('change', function() {
            const uploadSection = document.getElementById('imageUploadSection');
            const bannerImageInput = document.getElementById('bannerimage');
            const preview = document.getElementById('newImagePreview');
            
            if (this.checked) {
                uploadSection.style.display = 'block';
                bannerImageInput.required = true;
            } else {
                uploadSection.style.display = 'none';
                bannerImageInput.required = false;
                bannerImageInput.value = '';
                preview.style.display = 'none';
            }
        });

        // Image preview functionality for new image
        document.getElementById('bannerimage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('newImagePreview');
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
            const replaceImage = document.getElementById('replace_image').checked;
            const bannerImage = document.getElementById('bannerimage').files[0];
            
            if (!bannerName) {
                alert('Please enter a banner name.');
                e.preventDefault();
                return false;
            }
            
            if (replaceImage && !bannerImage) {
                alert('Please select a new image or uncheck the replacement option.');
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            if (replaceImage) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Banner & Image...';
            } else {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Banner...';
            }
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>