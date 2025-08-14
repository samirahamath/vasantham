<?php
session_start();
include('includes/dbconnection.php');

if(strlen($_SESSION['remsaid'])==0){
    header('location:logout.php');
}

$id = intval($_GET['id']);
$msg = "";
$msgType = "";

if(isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $status = $_POST['status'];

    $image = $_POST['old_image'];
    if(!empty($_FILES['image']['name'])) {
        // Validate image file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if(in_array($file_extension, $allowed_types)) {
            $image = time().'_'.$_FILES['image']['name'];
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/blogs/".$image)) {
                // Delete old image if exists
                if($data['BlogImage'] && file_exists("../assets/images/blogs/".$data['BlogImage'])) {
                    unlink("../assets/images/blogs/".$data['BlogImage']);
                }
            } else {
                $msg = "Failed to upload image";
                $msgType = "danger";
            }
        } else {
            $msg = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
            $msgType = "danger";
        }
    }

    if(empty($msg)) {
        $query = "UPDATE tblblogs SET BlogTitle='$title', BlogDescription='$desc', BlogImage='$image', Status='$status' WHERE ID=$id";
        if(mysqli_query($con, $query)) {
            $msg = "Blog updated successfully!";
            $msgType = "success";
        } else {
            $msg = "Error: " . mysqli_error($con);
            $msgType = "danger";
        }
    }
}

$res = mysqli_query($con, "SELECT * FROM tblblogs WHERE ID=$id");
$data = mysqli_fetch_assoc($res);

if(!$data) {
    header('location:manage-blogs.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Blog - REMS Admin</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    
    <style>
        .blog-edit-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 20px;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .current-image-container {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .current-image-container img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
           999px;
        }
        
        .file-input-label {
            background: #f8f9fa
shed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
        }
        
        .file-input-label:hover {
            background: #e9ecef;
            border-color: #667eea;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-cancel {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .image-preview {
            max-width: 200px;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <?php include_once('includes/header.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>
        
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="mb-0">
                                <i class="fas fa-edit mr-2"></i>Edit Blog Post
                            </h2>
                            <p class="mb-0 mt-2">Update your blog content and settings</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="manage-blogs.php" class="btn btn-light">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Blogs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <?php if($msg): ?>
                <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show" role="alert">
                    <i class="fas fa-<?php echo $msgType == 'success' ? 'check-circle' : 'exclamation-triangle'; ?> mr-2"></i>
                    <?php echo $msg; ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <!-- Edit Form -->
                <div class="blog-edit-container">
                    <form method="post" enctype="multipart/form-data" id="editBlogForm">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Blog Title -->
                                <div class="form-group">
                                    <label for="title">
                                        <i class="fas fa-heading mr-2"></i>Blog Title
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title"
                                           class="form-control" 
                                           value="<?php echo htmlspecialchars($data['BlogTitle']); ?>" 
                                           required
                                           placeholder="Enter blog title">
                                </div>

                                <!-- Blog Description -->
                                <div class="form-group">
                                    <label for="description">
                                        <i class="fas fa-align-left mr-2"></i>Blog Content
                                    </label>
                                    <textarea name="description" 
                                              id="description"
                                              class="form-control summernote" 
                                              rows="10" 
                                              required
                                              placeholder="Write your blog content here..."><?php echo htmlspecialchars($data['BlogDescription']); ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Current Image -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-image mr-2"></i>Current Image
                                    </label>
                                    <div class="current-image-container">
                                        <?php if($data['BlogImage'] && file_exists("../assets/images/blogs/".$data['BlogImage'])): ?>
                                            <img src="../assets/images/blogs/<?php echo $data['BlogImage']; ?>" 
                                                 class="image-preview" 
                                                 alt="Current blog image">
                                            <p class="mt-2 mb-0 text-muted">Current Image</p>
                                        <?php else: ?>
                                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No image uploaded</p>
                                        <?php endif; ?>
                                    </div>
                                    <input type="hidden" name="old_image" value="<?php echo $data['BlogImage']; ?>">
                                </div>

                                <!-- New Image Upload -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-upload mr-2"></i>Upload New Image
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" 
                                               name="image" 
                                               id="imageInput"
                                               accept="image/*">
                                        <label for="imageInput" class="file-input-label">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                            <p class="mb-0">Click to upload new image</p>
                                            <small class="text-muted">JPG, JPEG, PNG, GIF (Max 5MB)</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-toggle-on mr-2"></i>Status
                                    </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" <?php if($data['Status']=='Active') echo 'selected'; ?>>
                                            Active
                                        </option>
                                        <option value="Inactive" <?php if($data['Status']=='Inactive') echo 'selected'; ?>>
                                            Inactive
                                        </option>
                                    </select>
                                    <small class="form-text text-muted">
                                        Current: <span class="status-badge <?php echo $data['Status']=='Active' ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $data['Status']; ?>
                                        </span>
                                    </small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="form-group mt-4">
                                    <button type="submit" name="submit" class="btn btn-primary btn-update btn-block">
                                        <i class="fas fa-save mr-2"></i>Update Blog
                                    </button>
                                    <a href="manage-blogs.php" class="btn btn-cancel btn-block mt-2">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/summernote/summernote-bs4.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // File input preview
            $('#imageInput').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('.current-image-container').html(`
                            <img src="${e.target.result}" class="image-preview" alt="New image preview">
                            <p class="mt-2 mb-0 text-success">New Image Preview</p>
                        `);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form validation
            $('#editBlogForm').submit(function(e) {
                const title = $('#title').val().trim();
                const description = $('.summernote').summernote('code');
                
                if (title.length < 3) {
                    alert('Blog title must be at least 3 characters long');
                    e.preventDefault();
                    return false;
                }
                
                if (description.length < 10) {
                    alert('Blog content must be at least 10 characters long');
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>
</html>