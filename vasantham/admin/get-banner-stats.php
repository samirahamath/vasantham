<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check admin authentication
if (strlen($_SESSION['remsaid']) == 0) {
    echo json_encode(['error' => 'Session expired']);
    exit;
}

// Include banner functions
include('../includes/banner-functions.php');

// Get banner statistics
$bannerManager = new BannerManager($con);
$stats = $bannerManager->getBannerStatistics();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($stats);
?>