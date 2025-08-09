<?php
session_start();
include('includes/dbconnection.php');
include('includes/blog-functions.php');

if(strlen($_SESSION['remsaid'])==0){
    header('location:logout.php');
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $blogManager = new BlogManager($con);
    $blog = $blogManager->getBlogById($id);

    if($blog) {
        // delete image
        if(!empty($blog['BlogImage']) && file_exists("../assets/images/blogs/".$blog['BlogImage'])) {
            unlink("../assets/images/blogs/".$blog['BlogImage']);
        }
        $blogManager->deleteBlog($id);
        $_SESSION['success_msg'] = "Blog deleted successfully.";
    } else {
        $_SESSION['error_msg'] = "Blog not found.";
    }
}
header("Location: manage-blogs.php");
exit;
