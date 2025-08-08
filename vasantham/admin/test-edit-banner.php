<?php
// Test script to verify edit banner functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/dbconnection.php');
include('../includes/banner-functions.php');

echo "<h2>Testing Edit Banner Functionality</h2>";

// Test 1: Check if BannerManager class exists and works
echo "<h3>Test 1: BannerManager Class</h3>";
try {
    $bannerManager = new BannerManager($con);
    echo "✓ BannerManager class instantiated successfully<br>";
    
    // Test getting all banners
    $banners = $bannerManager->getAllBanners();
    echo "✓ getAllBanners() method works - Found " . count($banners) . " banners<br>";
    
    if (count($banners) > 0) {
        $testBanner = $banners[0];
        echo "✓ Test banner found: ID=" . $testBanner['ID'] . ", Name=" . $testBanner['BannerName'] . "<br>";
        
        // Test getBannerById
        $bannerById = $bannerManager->getBannerById($testBanner['ID']);
        if ($bannerById) {
            echo "✓ getBannerById() method works<br>";
        } else {
            echo "✗ getBannerById() method failed<br>";
        }
    } else {
        echo "ℹ No banners found in database for testing<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Error with BannerManager: " . $e->getMessage() . "<br>";
}

// Test 2: Check if ImageUploadHandler class exists
echo "<h3>Test 2: ImageUploadHandler Class</h3>";
try {
    $imageUploader = new ImageUploadHandler();
    echo "✓ ImageUploadHandler class instantiated successfully<br>";
    
    // Check if upload directory exists
    $uploadPath = '../assets/images/banners/';
    if (is_dir($uploadPath)) {
        echo "✓ Upload directory exists: $uploadPath<br>";
        if (is_writable($uploadPath)) {
            echo "✓ Upload directory is writable<br>";
        } else {
            echo "⚠ Upload directory is not writable<br>";
        }
    } else {
        echo "⚠ Upload directory does not exist: $uploadPath<br>";
    }
    
} catch (Exception $e) {
    echo "✗ Error with ImageUploadHandler: " . $e->getMessage() . "<br>";
}

// Test 3: Check database table structure
echo "<h3>Test 3: Database Table Structure</h3>";
$tableCheck = mysqli_query($con, "SHOW TABLES LIKE 'tblbanner'");
if ($tableCheck && mysqli_num_rows($tableCheck) > 0) {
    echo "✓ tblbanner table exists<br>";
    
    // Check table structure
    $structureQuery = mysqli_query($con, "DESCRIBE tblbanner");
    if ($structureQuery) {
        echo "✓ Table structure accessible<br>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = mysqli_fetch_assoc($structureQuery)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "✗ tblbanner table does not exist<br>";
}

// Test 4: Check if edit-banner.php file exists and is accessible
echo "<h3>Test 4: Edit Banner File</h3>";
if (file_exists('edit-banner.php')) {
    echo "✓ edit-banner.php file exists<br>";
    if (is_readable('edit-banner.php')) {
        echo "✓ edit-banner.php file is readable<br>";
    } else {
        echo "✗ edit-banner.php file is not readable<br>";
    }
} else {
    echo "✗ edit-banner.php file does not exist<br>";
}

echo "<h3>Test Summary</h3>";
echo "All core components for edit banner functionality have been tested.<br>";
echo "If you see any ✗ or ⚠ symbols above, those issues need to be addressed.<br>";
echo "<br><a href='edit-banner.php?id=1'>Test Edit Banner Interface (if banner ID 1 exists)</a><br>";
echo "<a href='manage-banners.php'>Go to Banner Management</a><br>";
?>