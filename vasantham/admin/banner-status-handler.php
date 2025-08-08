<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('../includes/banner-functions.php');

// Check admin authentication
if (strlen($_SESSION['remsaid']) == 0) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Set content type to JSON
header('Content-Type: application/json');

// Check if banner table exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
}

if (!$tableExists) {
    echo json_encode(['success' => false, 'message' => 'Banner system not initialized']);
    exit;
}

// Initialize banner manager
$bannerManager = new BannerManager($con);

// Handle POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'toggle_status':
        handleToggleStatus($bannerManager);
        break;
        
    case 'bulk_toggle_status':
        handleBulkToggleStatus($bannerManager);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

/**
 * Handle individual banner status toggle
 */
function handleToggleStatus($bannerManager) {
    $bannerId = intval($_POST['banner_id'] ?? 0);
    $newStatus = $_POST['new_status'] ?? '';
    
    // Validate inputs
    if ($bannerId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid banner ID']);
        return;
    }
    
    if (!in_array($newStatus, ['Active', 'Inactive'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value']);
        return;
    }
    
    // Get banner details before update
    $banner = $bannerManager->getBannerById($bannerId);
    if (!$banner) {
        echo json_encode(['success' => false, 'message' => 'Banner not found']);
        return;
    }
    
    // Update banner status
    $result = $bannerManager->toggleBannerStatus($bannerId, $newStatus);
    
    if ($result) {
        // Get updated statistics
        $stats = $bannerManager->getBannerStatistics();
        
        // Check for edge case - all banners deactivated
        $warning = null;
        if ($newStatus === 'Inactive' && $stats['active'] === 0) {
            $warning = 'Warning: All banners are now inactive. Your homepage may not display any banners.';
        }
        
        $actionText = $newStatus === 'Active' ? 'activated' : 'deactivated';
        $message = "Banner \"{$banner['BannerName']}\" has been {$actionText} successfully.";
        
        echo json_encode([
            'success' => true,
            'message' => $message,
            'stats' => $stats,
            'warning' => $warning
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update banner status. Please try again.'
        ]);
    }
}

/**
 * Handle bulk banner status toggle
 */
function handleBulkToggleStatus($bannerManager) {
    $bannerIds = $_POST['banner_ids'] ?? [];
    $newStatus = $_POST['new_status'] ?? '';
    
    // Validate inputs
    if (empty($bannerIds) || !is_array($bannerIds)) {
        echo json_encode(['success' => false, 'message' => 'No banners selected']);
        return;
    }
    
    if (!in_array($newStatus, ['Active', 'Inactive'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value']);
        return;
    }
    
    // Sanitize banner IDs
    $bannerIds = array_map('intval', $bannerIds);
    $bannerIds = array_filter($bannerIds, function($id) { return $id > 0; });
    
    if (empty($bannerIds)) {
        echo json_encode(['success' => false, 'message' => 'Invalid banner IDs']);
        return;
    }
    
    // Update each banner status
    $successCount = 0;
    $failedBanners = [];
    
    foreach ($bannerIds as $bannerId) {
        $result = $bannerManager->toggleBannerStatus($bannerId, $newStatus);
        if ($result) {
            $successCount++;
        } else {
            $failedBanners[] = $bannerId;
        }
    }
    
    // Get updated statistics
    $stats = $bannerManager->getBannerStatistics();
    
    // Check for edge case - all banners deactivated
    $warning = null;
    if ($newStatus === 'Inactive' && $stats['active'] === 0) {
        $warning = 'Warning: All banners are now inactive. Your homepage may not display any banners.';
    }
    
    // Prepare response message
    $actionText = $newStatus === 'Active' ? 'activated' : 'deactivated';
    
    if ($successCount === count($bannerIds)) {
        $message = "{$successCount} banner(s) have been {$actionText} successfully.";
        echo json_encode([
            'success' => true,
            'message' => $message,
            'stats' => $stats,
            'warning' => $warning
        ]);
    } else if ($successCount > 0) {
        $failedCount = count($failedBanners);
        $message = "{$successCount} banner(s) {$actionText} successfully, but {$failedCount} failed.";
        echo json_encode([
            'success' => true,
            'message' => $message,
            'stats' => $stats,
            'warning' => $warning,
            'partial' => true
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Failed to {$actionText} any banners. Please try again."
        ]);
    }
}

/**
 * Log banner status change for audit trail
 */
function logStatusChange($bannerManager, $bannerId, $oldStatus, $newStatus, $adminId) {
    $bannerManager->logAudit($bannerId, 'STATUS_CHANGED', 
        json_encode(['Status' => $oldStatus]), 
        json_encode(['Status' => $newStatus]), 
        $adminId
    );
}
?>