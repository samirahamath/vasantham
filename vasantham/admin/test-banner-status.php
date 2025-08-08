<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

// Simple test to verify banner status management functionality
echo "<h2>Banner Status Management Test</h2>";

// Check if banner table exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
    include('../includes/banner-functions.php');
    echo "<p style='color: green;'>✓ Banner table exists</p>";
} else {
    echo "<p style='color: red;'>✗ Banner table does not exist. Please run the schema script first.</p>";
    exit;
}

// Test banner manager initialization
try {
    $bannerManager = new BannerManager($con);
    echo "<p style='color: green;'>✓ BannerManager initialized successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to initialize BannerManager: " . $e->getMessage() . "</p>";
    exit;
}

// Test getting banner statistics
try {
    $stats = $bannerManager->getBannerStatistics();
    echo "<p style='color: green;'>✓ Banner statistics retrieved:</p>";
    echo "<ul>";
    echo "<li>Total banners: {$stats['total']}</li>";
    echo "<li>Active banners: {$stats['active']}</li>";
    echo "<li>Inactive banners: {$stats['inactive']}</li>";
    echo "</ul>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to get banner statistics: " . $e->getMessage() . "</p>";
}

// Test edge case detection
try {
    $allInactive = $bannerManager->areAllBannersInactive();
    if ($allInactive) {
        echo "<p style='color: orange;'>⚠ Warning: All banners are inactive!</p>";
    } else {
        echo "<p style='color: green;'>✓ At least one banner is active</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to check inactive status: " . $e->getMessage() . "</p>";
}

// Test getting all banners
try {
    $allBanners = $bannerManager->getAllBanners();
    echo "<p style='color: green;'>✓ Retrieved " . count($allBanners) . " banners</p>";
    
    if (!empty($allBanners)) {
        echo "<h3>Banner List:</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Name</th><th>Status</th><th>Display Order</th><th>Created</th></tr>";
        
        foreach ($allBanners as $banner) {
            $statusColor = $banner['Status'] === 'Active' ? 'green' : 'gray';
            echo "<tr>";
            echo "<td>{$banner['ID']}</td>";
            echo "<td>{$banner['BannerName']}</td>";
            echo "<td style='color: {$statusColor}; font-weight: bold;'>{$banner['Status']}</td>";
            echo "<td>{$banner['DisplayOrder']}</td>";
            echo "<td>" . date('Y-m-d H:i', strtotime($banner['CreationDate'])) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Failed to get banners: " . $e->getMessage() . "</p>";
}

// Test file structure
$requiredFiles = [
    'banner-status-handler.php',
    'assets/js/banner-status.js',
    '../includes/banner-functions.php'
];

echo "<h3>File Structure Check:</h3>";
foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ {$file} exists</p>";
    } else {
        echo "<p style='color: red;'>✗ {$file} missing</p>";
    }
}

// Test directory structure
$requiredDirs = [
    '../assets/images/banners/'
];

echo "<h3>Directory Structure Check:</h3>";
foreach ($requiredDirs as $dir) {
    if (is_dir($dir)) {
        echo "<p style='color: green;'>✓ {$dir} exists</p>";
        if (is_writable($dir)) {
            echo "<p style='color: green;'>✓ {$dir} is writable</p>";
        } else {
            echo "<p style='color: orange;'>⚠ {$dir} is not writable</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ {$dir} missing</p>";
    }
}

echo "<hr>";
echo "<p><strong>Test completed.</strong> If all items show green checkmarks, the banner status management system is ready to use.</p>";
echo "<p><a href='manage-banners.php'>Go to Banner Management</a></p>";
?>