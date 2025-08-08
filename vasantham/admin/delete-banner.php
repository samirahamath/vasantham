<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
}

// Check if banner table exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
    include('../includes/banner-functions.php');
}

$response = ['success' => false, 'message' => ''];

if($tableExists && isset($_POST['banner_id'])) {
    $bannerId = intval($_POST['banner_id']);
    $bannerManager = new BannerManager($con);
    
    // Get banner details before deletion
    $bannerData = $bannerManager->getBannerById($bannerId);
    
    if(!$bannerData) {
        $response['message'] = 'Banner not found';
    } else {
        // Check if banner is active and warn user
        if($bannerData['Status'] == 'Active') {
            // Count total active banners
            $activeBanners = $bannerManager->getAllBanners(true);
            $activeCount = count($activeBanners);
            
            if($activeCount == 1) {
                $response['message'] = 'Warning: This is the only active banner. Deleting it will leave no banners on the homepage.';
                $response['warning'] = true;
            } else {
                $response['message'] = 'Warning: This banner is currently active and displayed on the homepage.';
                $response['warning'] = true;
            }
        }
        
        // If user confirmed deletion, proceed with deletion
        if(isset($_POST['confirm_delete'])) {
            $imagePath = "../assets/images/banners/" . $bannerData['BannerImage'];
            $imageExists = file_exists($imagePath);
            
            // Attempt to delete from database first
            $query = "DELETE FROM tblbanner WHERE ID = $bannerId";
            if(mysqli_query($con, $query)) {
                // Database deletion successful
                $imageDeleted = true;
                
                // Try to delete image file
                if($imageExists) {
                    $imageDeleted = unlink($imagePath);
                    if(!$imageDeleted) {
                        // Log the file deletion failure
                        error_log("Failed to delete banner image: " . $imagePath);
                    }
                }
                
                // Log audit trail
                $bannerManager->logAudit($bannerId, 'DELETED', json_encode($bannerData), null, $_SESSION['remsaid']);
                
                if($imageDeleted || !$imageExists) {
                    $response['success'] = true;
                    $response['message'] = 'Banner deleted successfully';
                } else {
                    $response['success'] = true;
                    $response['message'] = 'Banner deleted from database, but image file could not be removed. Please check file permissions.';
                    $response['partial'] = true;
                }
            } else {
                $response['message'] = 'Error deleting banner from database: ' . mysqli_error($con);
                error_log("Database error deleting banner ID $bannerId: " . mysqli_error($con));
            }
        } else if($bannerData['Status'] == 'Active') {
            // Return warning for active banner without confirmation
            $response['needs_confirmation'] = true;
        }
    }
} else {
    $response['message'] = 'Invalid request or banner system not available';
}

// Return JSON response for AJAX requests
if(isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// For non-AJAX requests, redirect back with message
if($response['success']) {
    $_SESSION['success_msg'] = $response['message'];
} else {
    $_SESSION['error_msg'] = $response['message'];
}

header('location:manage-banners.php');
exit;
?>