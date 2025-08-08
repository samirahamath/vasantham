<?php
// Test script for banner deletion functionality
// This file can be removed after testing

session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (strlen($_SESSION['remsaid']==0)) {
  header('location:logout.php');
}

echo "<h2>Banner Deletion Functionality Test</h2>";

// Check if banner table exists
$tableExists = false;
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if($checkTable && mysqli_num_rows($checkTable) > 0) {
    $tableExists = true;
    include('../includes/banner-functions.php');
    echo "<p>✓ Banner table exists</p>";
} else {
    echo "<p>✗ Banner table does not exist</p>";
    exit;
}

// Test banner manager initialization
$bannerManager = new BannerManager($con);
echo "<p>✓ BannerManager initialized</p>";

// Test getting all banners
$allBanners = $bannerManager->getAllBanners();
echo "<p>✓ Found " . count($allBanners) . " banners in database</p>";

// Test getting banner statistics
$stats = $bannerManager->getBannerStatistics();
echo "<p>✓ Banner statistics: Total: {$stats['total']}, Active: {$stats['active']}, Inactive: {$stats['inactive']}</p>";

// List all banners
if(!empty($allBanners)) {
    echo "<h3>Current Banners:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Image</th><th>Status</th><th>Order</th><th>Test Delete</th></tr>";
    
    foreach($allBanners as $banner) {
        echo "<tr>";
        echo "<td>{$banner['ID']}</td>";
        echo "<td>{$banner['BannerName']}</td>";
        echo "<td>{$banner['BannerImage']}</td>";
        echo "<td>{$banner['Status']}</td>";
        echo "<td>{$banner['DisplayOrder']}</td>";
        echo "<td><a href='?test_delete={$banner['ID']}' onclick='return confirm(\"Test delete banner {$banner['BannerName']}?\")'>Test Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test deletion if requested
if(isset($_GET['test_delete'])) {
    $bannerId = intval($_GET['test_delete']);
    echo "<h3>Testing Deletion of Banner ID: $bannerId</h3>";
    
    // Get banner details first
    $bannerData = $bannerManager->getBannerById($bannerId);
    if($bannerData) {
        echo "<p>Banner found: {$bannerData['BannerName']}</p>";
        echo "<p>Status: {$bannerData['Status']}</p>";
        echo "<p>Image: {$bannerData['BannerImage']}</p>";
        
        // Check if image file exists
        $imagePath = "../assets/images/banners/" . $bannerData['BannerImage'];
        if(file_exists($imagePath)) {
            echo "<p>✓ Image file exists at: $imagePath</p>";
        } else {
            echo "<p>⚠ Image file not found at: $imagePath</p>";
        }
        
        // Test the deletion
        $result = $bannerManager->deleteBanner($bannerId);
        if($result['success']) {
            echo "<p>✓ Deletion successful: {$result['message']}</p>";
            if(isset($result['partial'])) {
                echo "<p>⚠ Partial deletion (database only)</p>";
            }
        } else {
            echo "<p>✗ Deletion failed: {$result['message']}</p>";
        }
    } else {
        echo "<p>✗ Banner not found</p>";
    }
}

echo "<br><a href='manage-banners.php'>← Back to Banner Management</a>";
?>