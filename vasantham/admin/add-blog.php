<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['remsaid'] == 0)) {
    header('location:logout.php');
    exit;
}

$msg = $error = '';
if (isset($_POST['submit'])) {
    $title = trim($_POST['BlogTitle']);
    $desc = trim($_POST['BlogDescription']);
    $status = isset($_POST['Status']) && $_POST['Status'] === 'Active' ? 'Active' : 'Inactive';
    $createdBy = isset($_SESSION['adminname']) ? $_SESSION['adminname'] : 'Admin';

    // Handle image upload
    $imageName = null;
    if (!empty($_FILES['BlogImage']['name'])) {
        $img = $_FILES['BlogImage'];
        $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $imageName = uniqid('blog_', true) . '.' . $ext;
            $uploadPath = "../assets/images/blogs/" . $imageName;
            if (!is_dir("../assets/images/blogs/")) {
                mkdir("../assets/images/blogs/", 0777, true);
            }
            if (!move_uploaded_file($img['tmp_name'], $uploadPath)) {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid image format. Allowed: jpg, jpeg, png, gif, webp.";
        }
    }

    if (!$error) {
        $stmt = $con->prepare("INSERT INTO tblblogs (BlogTitle, BlogDescription, BlogImage, Status, CreatedByName) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $desc, $imageName, $status, $createdBy);
        if ($stmt->execute()) {
            $msg = "Blog added successfully!";
        } else {
            $error = "Database error: " . $con->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <title>Add Blog || REMS</title>
    <style>
        body { background: #f4f6f9; }
        .form-section {
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            margin-top: 2rem;
        }
        .img-preview {
            max-width: 180px;
            max-height: 120px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #e3e3e3;
            background: #fafbfc;
            display: block;
        }
        .custom-file-label {
            overflow: hidden;
        }
        .page-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem 2rem 1rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        }
        .btn-primary {
            background: linear-gradient(90deg, #007bff 60%, #0056b3 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3 60%, #007bff 100%);
        }
        .form-group label {
            font-weight: 500;
        }
        .alert {
            border-radius: 8px;
        }
        .required-star { color: #dc3545; }
    </style>
</head>
<body>
<div class="dashboard-main-wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="page-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1"><i class="fas fa-pen-nib text-primary"></i> Add New Blog</h3>
                            <small class="text-muted">Fill the form below to create a new blog post.</small>
                        </div>
                        <a href="manage-blogs.php" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Blog List
                        </a>
                    </div>
                    <div class="form-section">
                        <?php if ($msg) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo $msg; ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php } ?>
                        <form method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <label for="BlogTitle">Blog Title <span class="required-star">*</span></label>
                                <input type="text" name="BlogTitle" id="BlogTitle" class="form-control" required maxlength="255" placeholder="Enter blog title" value="<?php echo isset($_POST['BlogTitle']) ? htmlspecialchars($_POST['BlogTitle']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="BlogDescription">Blog Description <span class="required-star">*</span></label>
                                <textarea name="BlogDescription" id="BlogDescription" class="form-control" rows="7" required placeholder="Write your blog content here..."><?php echo isset($_POST['BlogDescription']) ? htmlspecialchars($_POST['BlogDescription']) : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="BlogImage">Blog Image</label>
                                <div class="custom-file">
                                    <input type="file" name="BlogImage" id="BlogImage" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label" for="BlogImage">Choose image...</label>
                                </div>
                                <img id="imgPreview" class="img-preview d-none" alt="Image Preview">
                                <small class="form-text text-muted">Supported formats: jpg, jpeg, png, gif, webp.</small>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="statusActive" name="Status" value="Active" class="custom-control-input" <?php if(isset($_POST['Status']) && $_POST['Status']=='Active') echo 'checked'; ?>>
                                        <label class="custom-control-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="statusInactive" name="Status" value="Inactive" class="custom-control-input" <?php if(!isset($_POST['Status']) || $_POST['Status']=='Inactive') echo 'checked'; ?>>
                                        <label class="custom-control-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-plus"></i> Add Blog
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script>
    // Show filename in custom file input
    $('#BlogImage').on('change', function(){
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
        const [file] = this.files;
        if (file) {
            $('#imgPreview').removeClass('d-none').attr('src', URL.createObjectURL(file));
        } else {
            $('#imgPreview').addClass('d-none').attr('src', '');
        }
    });
</script>
</body>
</html>
