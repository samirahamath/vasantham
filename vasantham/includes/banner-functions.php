<?php
// Banner Management Functions
// This file contains all the core functions for banner management

class BannerManager {
    private $connection;
    
    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }
    
    // Add new banner
    public function addBanner($bannerName, $bannerImage, $description, $adminId) {
        $bannerName = mysqli_real_escape_string($this->connection, $bannerName);
        $bannerImage = mysqli_real_escape_string($this->connection, $bannerImage);
        $description = mysqli_real_escape_string($this->connection, $description);
        $adminId = (int)$adminId;
        
        // Get next display order
        $orderQuery = mysqli_query($this->connection, "SELECT MAX(DisplayOrder) as maxOrder FROM tblbanner");
        $orderResult = mysqli_fetch_assoc($orderQuery);
        $displayOrder = ($orderResult['maxOrder'] ?? 0) + 1;
        
        $query = "INSERT INTO tblbanner (BannerName, BannerImage, BannerDescription, Status, DisplayOrder, CreatedBy) 
                  VALUES ('$bannerName', '$bannerImage', '$description', 'Active', $displayOrder, $adminId)";
        
        if (mysqli_query($this->connection, $query)) {
            $bannerId = mysqli_insert_id($this->connection);
            $this->logAudit($bannerId, 'CREATED', null, json_encode([
                'BannerName' => $bannerName,
                'BannerImage' => $bannerImage,
                'Status' => 'Active'
            ]), $adminId);
            return $bannerId;
        }
        return false;
    }
    
    // Update banner
    public function updateBanner($bannerId, $bannerName, $description, $newImage = null) {
        $bannerId = (int)$bannerId;
        $bannerName = mysqli_real_escape_string($this->connection, $bannerName);
        $description = mysqli_real_escape_string($this->connection, $description);
        
        // Get old values for audit
        $oldData = $this->getBannerById($bannerId);
        
        $query = "UPDATE tblbanner SET BannerName='$bannerName', BannerDescription='$description'";
        if ($newImage) {
            $newImage = mysqli_real_escape_string($this->connection, $newImage);
            $query .= ", BannerImage='$newImage'";
        }
        $query .= " WHERE ID=$bannerId";
        
        if (mysqli_query($this->connection, $query)) {
            $this->logAudit($bannerId, 'UPDATED', json_encode($oldData), json_encode([
                'BannerName' => $bannerName,
                'BannerDescription' => $description,
                'BannerImage' => $newImage ?? $oldData['BannerImage']
            ]), $_SESSION['remsaid']);
            return true;
        }
        return false;
    }
    
    // Delete banner with enhanced error handling
    public function deleteBanner($bannerId) {
        $bannerId = (int)$bannerId;
        
        // Get banner data before deletion
        $bannerData = $this->getBannerById($bannerId);
        if (!$bannerData) return ['success' => false, 'message' => 'Banner not found'];
        
        $imagePath = "../assets/images/banners/" . $bannerData['BannerImage'];
        $imageExists = file_exists($imagePath);
        
        // Delete from database first
        $query = "DELETE FROM tblbanner WHERE ID=$bannerId";
        if (mysqli_query($this->connection, $query)) {
            $imageDeleted = true;
            
            // Try to delete image file
            if ($imageExists) {
                $imageDeleted = unlink($imagePath);
            }
            
            // Log audit trail
            $this->logAudit($bannerId, 'DELETED', json_encode($bannerData), null, $_SESSION['remsaid']);
            
            if ($imageDeleted) {
                return ['success' => true, 'message' => 'Banner deleted successfully'];
            } else {
                return ['success' => true, 'message' => 'Banner deleted from database, but image file could not be removed', 'partial' => true];
            }
        }
        
        return ['success' => false, 'message' => 'Error deleting banner from database: ' . mysqli_error($this->connection)];
    }
    
    // Toggle banner status
    public function toggleBannerStatus($bannerId, $status) {
        $bannerId = (int)$bannerId;
        $status = mysqli_real_escape_string($this->connection, $status);
        
        $oldData = $this->getBannerById($bannerId);
        
        $query = "UPDATE tblbanner SET Status='$status' WHERE ID=$bannerId";
        if (mysqli_query($this->connection, $query)) {
            $this->logAudit($bannerId, 'STATUS_CHANGED', json_encode($oldData), json_encode([
                'Status' => $status
            ]), $_SESSION['remsaid']);
            return true;
        }
        return false;
    }
    
    // Get all banners
    public function getAllBanners($activeOnly = false) {
        $query = "SELECT b.*, a.AdminName as CreatedByName 
                  FROM tblbanner b 
                  LEFT JOIN tbladmin a ON b.CreatedBy = a.ID";
        
        if ($activeOnly) {
            $query .= " WHERE b.Status = 'Active'";
        }
        
        $query .= " ORDER BY b.DisplayOrder ASC, b.CreationDate DESC";
        
        $result = mysqli_query($this->connection, $query);
        $banners = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $banners[] = $row;
            }
        }
        
        return $banners;
    }
    
    // Get banner by ID
    public function getBannerById($bannerId) {
        $bannerId = (int)$bannerId;
        $query = "SELECT * FROM tblbanner WHERE ID=$bannerId";
        $result = mysqli_query($this->connection, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
    
    // Reorder banners
    public function reorderBanners($bannerOrders) {
        foreach ($bannerOrders as $bannerId => $order) {
            $bannerId = (int)$bannerId;
            $order = (int)$order;
            
            $query = "UPDATE tblbanner SET DisplayOrder=$order WHERE ID=$bannerId";
            mysqli_query($this->connection, $query);
        }
        
        $this->logAudit(0, 'REORDERED', null, json_encode($bannerOrders), $_SESSION['remsaid']);
        return true;
    }
    
    // Get banner statistics
    public function getBannerStatistics() {
        $stats = [];
        
        // Total banners
        $totalQuery = mysqli_query($this->connection, "SELECT COUNT(*) as total FROM tblbanner");
        $stats['total'] = mysqli_fetch_assoc($totalQuery)['total'];
        
        // Active banners
        $activeQuery = mysqli_query($this->connection, "SELECT COUNT(*) as active FROM tblbanner WHERE Status='Active'");
        $stats['active'] = mysqli_fetch_assoc($activeQuery)['active'];
        
        // Inactive banners
        $stats['inactive'] = $stats['total'] - $stats['active'];
        
        return $stats;
    }
    
    // Check if all banners are inactive (edge case)
    public function areAllBannersInactive() {
        $stats = $this->getBannerStatistics();
        return $stats['total'] > 0 && $stats['active'] === 0;
    }
    
    // Get banner status summary for admin dashboard
    public function getStatusSummary() {
        $stats = $this->getBannerStatistics();
        $summary = [
            'total' => $stats['total'],
            'active' => $stats['active'],
            'inactive' => $stats['inactive'],
            'all_inactive' => $this->areAllBannersInactive(),
            'percentage_active' => $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100, 1) : 0
        ];
        
        return $summary;
    }
    
    // Log audit trail
    public function logAudit($bannerId, $action, $oldValues, $newValues, $adminId) {
        $bannerId = (int)$bannerId;
        $action = mysqli_real_escape_string($this->connection, $action);
        $oldValues = $oldValues ? mysqli_real_escape_string($this->connection, $oldValues) : 'NULL';
        $newValues = $newValues ? mysqli_real_escape_string($this->connection, $newValues) : 'NULL';
        $adminId = (int)$adminId;
        
        $query = "INSERT INTO tblbanneraudit (BannerID, Action, OldValues, NewValues, AdminID) 
                  VALUES ($bannerId, '$action', " . ($oldValues === 'NULL' ? 'NULL' : "'$oldValues'") . ", " . 
                  ($newValues === 'NULL' ? 'NULL' : "'$newValues'") . ", $adminId)";
        
        mysqli_query($this->connection, $query);
    }
}

// Image Upload Handler Class
class ImageUploadHandler {
    private $uploadPath;
    private $allowedTypes;
    private $maxFileSize;
    
    public function __construct() {
        $this->uploadPath = '../assets/images/banners/';
        $this->allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $this->maxFileSize = 5 * 1024 * 1024; // 5MB
        
        // Create directory if it doesn't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }
    
    public function uploadBannerImage($file) {
        // Validate file
        $validation = $this->validateImage($file);
        if ($validation !== true) {
            return ['success' => false, 'error' => $validation];
        }
        
        // Generate unique filename
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'banner_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = $this->uploadPath . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload file'];
        }
    }
    
    public function deleteBannerImage($filename) {
        $filePath = $this->uploadPath . $filename;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return true; // File doesn't exist, consider it deleted
    }
    
    public function validateImage($file) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return 'No file uploaded';
        }
        
        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            return 'File size too large. Maximum size is 5MB';
        }
        
        // Check file type
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedTypes)) {
            return 'Invalid file type. Allowed types: ' . implode(', ', $this->allowedTypes);
        }
        
        // Check if it's actually an image
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            return 'File is not a valid image';
        }
        
        return true;
    }
}

// Helper functions for backward compatibility
function getAllBanners($con, $activeOnly = false) {
    $bannerManager = new BannerManager($con);
    return $bannerManager->getAllBanners($activeOnly);
}

function getBannerStatistics($con) {
    $bannerManager = new BannerManager($con);
    return $bannerManager->getBannerStatistics();
}
?>