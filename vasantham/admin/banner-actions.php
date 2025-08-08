<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check admin authentication
if (strlen($_SESSION['remsaid']) == 0) {
    if (isset($_POST['ajax'])) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please login again.']);
        exit;
    } else {
        header('location:logout.php');
        exit;
    }
}

// Include banner functions
include('../includes/banner-functions.php');

// Initialize response
$response = ['success' => false, 'message' => 'Invalid request'];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bannerManager = new BannerManager($con);
    
    // Handle different actions
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'toggle_status':
                $response = handleToggleStatus($bannerManager, $_POST);
                break;
                
            case 'bulk_status':
                $response = handleBulkStatus($bannerManager, $_POST);
                break;
                
            default:
                $response = ['success' => false, 'message' => 'Unknown action'];
                break;
        }
    }
}

// Return JSON response for AJAX requests
if (isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Redirect for non-AJAX requests
if ($response['success']) {
    $_SESSION['success_msg'] = $response['message'];
} else {
    $_SESSION['error_msg'] = $response['message'];
}
header('location:manage-banners.php');
exit;

/**
 * Handle individual banner status toggle
 */
function handleToggleStatus($bannerManager, $postData) {
    if (!isset($postData['banner_id']) || !isset($postData['new_status'])) {
        return ['success' => false, 'message' => 'Missing required parameters'];
    }
    
    $bannerId = intval($postData['banner_id']);
    $newStatus = trim($postData['new_status']);
    
    // Validate status
    if (!in_array($newStatus, ['Active', 'Inactive'])) {
        return ['success' => false, 'message' => 'Invalid status value'];
    }
    
    // Get banner details
    $banner = $bannerManager->getBannerById($bannerId);
    if (!$banner) {
        return ['success' => false, 'message' => 'Banner not found'];
    }
    
    // Check if this is the last active banner being deactivated
    $allInactive = false;
    if ($newStatus === 'Inactive') {
        $stats = $bannerManager->getBannerStatistics();
        if ($stats['active'] <= 1) {
            $allInactive = true;
        }
    }
    
    // Update banner status
    if ($bannerManager->toggleBannerStatus($bannerId, $newStatus)) {
        $actionText = $newStatus === 'Active' ? 'activated' : 'deactivated';
        $message = "Banner '{$banner['BannerName']}' has been {$actionText} successfully.";
        
        return [
            'success' => true, 
            'message' => $message,
            'all_inactive' => $allInactive,
            'new_status' => $newStatus
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to update banner status. Please try again.'];
    }
}

/**
 * Handle bulk status change
 */
function handleBulkStatus($bannerManager, $postData) {
    if (!isset($postData['banner_ids']) || !isset($postData['new_status'])) {
        return ['success' => false, 'message' => 'Missing required parameters'];
    }
    
    $bannerIds = $postData['banner_ids'];
    $newStatus = trim($postData['new_status']);
    
    // Validate inputs
    if (!is_array($bannerIds) || empty($bannerIds)) {
        return ['success' => false, 'message' => 'No banners selected'];
    }
    
    if (!in_array($newStatus, ['Active', 'Inactive'])) {
        return ['success' => false, 'message' => 'Invalid status value'];
    }
    
    $successCount = 0;
    $failCount = 0;
    $processedBanners = [];
    
    // Process each banner
    foreach ($bannerIds as $bannerId) {
        $bannerId = intval($bannerId);
        $banner = $bannerManager->getBannerById($bannerId);
        
        if ($banner) {
            if ($bannerManager->toggleBannerStatus($bannerId, $newStatus)) {
                $successCount++;
                $processedBanners[] = $banner['BannerName'];
            } else {
                $failCount++;
            }
        } else {
            $failCount++;
        }
    }
    
    // Generate response message
    if ($successCount > 0 && $failCount === 0) {
        $actionText = $newStatus === 'Active' ? 'activated' : 'deactivated';
        $message = "Successfully {$actionText} {$successCount} banner(s).";
        
        // Check if all banners are now inactive
        $allInactive = false;
        if ($newStatus === 'Inactive') {
            $stats = $bannerManager->getBannerStatistics();
            if ($stats['active'] === 0) {
                $allInactive = true;
            }
        }
        
        return [
            'success' => true, 
            'message' => $message,
            'processed_count' => $successCount,
            'all_inactive' => $allInactive
        ];
    } elseif ($successCount > 0 && $failCount > 0) {
        $actionText = $newStatus === 'Active' ? 'activated' : 'deactivated';
        $message = "Partially successful: {$actionText} {$successCount} banner(s), failed to process {$failCount} banner(s).";
        
        return [
            'success' => true, 
            'message' => $message,
            'processed_count' => $successCount,
            'failed_count' => $failCount
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to update any banners. Please try again.'];
    }
}

/**
 * Log banner action for audit trail
 */
function logBannerAction($con, $action, $bannerId, $details) {
    $adminId = $_SESSION['remsaid'];
    $action = mysqli_real_escape_string($con, $action);
    $details = mysqli_real_escape_string($con, $details);
    
    $query = "INSERT INTO tblbanneraudit (BannerID, Action, NewValues, AdminID) 
              VALUES ($bannerId, '$action', '$details', $adminId)";
    
    mysqli_query($con, $query);
}
?>