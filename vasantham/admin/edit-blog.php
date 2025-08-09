<?php
session_start();
include('includes/dbconnection.php');

if(strlen($_SESSION['remsaid'])==0){
    header('location:logout.php');
}

$id = intval($_GET['id']);
$msg = "";

if(isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $status = $_POST['status'];

    $image = $_POST['old_image'];
    if(!empty($_FILES['image']['name'])) {
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/blogs/".$image);
    }

    $query = "UPDATE tblblogs SET BlogTitle='$title', BlogDescription='$desc', BlogImage='$image', Status='$status' WHERE ID=$id";
    if(mysqli_query($con, $query)) {
        $msg = "Blog updated successfully";
    } else {
        $msg = "Error: " . mysqli_error($con);
    }
}

$res = mysqli_query($con, "SELECT * FROM tblblogs WHERE ID=$id");
$data = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Blog</title>
<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>
<div class="dashboard-wrapper">
<div class="container-fluid">
<h3>Edit Blog</h3>
<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>
<form method="post" enctype="multipart/form-data">
<div class="form-group">
<label>Title</label>
<input type="text" name="title" class="form-control" value="<?php echo $data['BlogTitle']; ?>" required>
</div>
<div class="form-group">
<label>Description</label>
<textarea name="description" class="form-control" rows="6" required><?php echo $data['BlogDescription']; ?></textarea>
</div>
<div class="form-group">
<label>Current Image</label><br>
<?php if($data['BlogImage']) { ?>
<img src="../assets/images/blogs/<?php echo $data['BlogImage']; ?>" height="100">
<?php } ?>
<input type="hidden" name="old_image" value="<?php echo $data['BlogImage']; ?>">
</div>
<div class="form-group">
<label>New Image</label>
<input type="file" name="image" class="form-control">
</div>
<div class="form-group">
<label>Status</label>
<select name="status" class="form-control">
<option value="Active" <?php if($data['Status']=='Active') echo 'selected'; ?>>Active</option>
<option value="Inactive" <?php if($data['Status']=='Inactive') echo 'selected'; ?>>Inactive</option>
</select>
</div>
<button type="submit" name="submit" class="btn btn-primary">Update Blog</button>
</form>
</div>
</div>
</body>
</html>
