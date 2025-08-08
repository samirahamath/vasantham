# Design Document

## Overview

The Banner Management System enhances the existing Vasantham Real Estate Management System by providing administrators with a comprehensive interface to manage homepage banners dynamically. The system integrates seamlessly with the existing PHP/MySQL architecture and admin theme, allowing for easy banner creation, editing, deletion, and status management without requiring code changes to the frontend.

## Architecture

### Current System Architecture
- **Frontend**: PHP-based web application with HTML/CSS/JavaScript
- **Backend**: PHP with procedural programming approach
- **Database**: MySQL (MariaDB) with database name `remsdb`
- **Admin Interface**: Existing admin theme with sidebar navigation
- **File Structure**: Modular approach with separate admin and public sections

### Enhanced Architecture Components
- **Banner Management Engine**: Core logic for CRUD operations on banners
- **Image Upload Handler**: Secure file upload and management system
- **Admin Interface Integration**: Seamless integration with existing admin theme
- **Homepage Banner Display**: Dynamic banner loading on the public homepage
- **Status Management**: Active/inactive banner control system

## Components and Interfaces

### 1. Database Schema Enhancement

#### New `tblbanner` Table
```sql
CREATE TABLE `tblbanner` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BannerName` varchar(255) NOT NULL,
  `BannerImage` varchar(255) NOT NULL,
  `BannerDescription` text NULL,
  `Status` varchar(20) DEFAULT 'Active',
  `DisplayOrder` int(5) DEFAULT 1,
  `CreatedBy` int(10) NOT NULL,
  `CreationDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`CreatedBy`) REFERENCES `tbladmin`(`ID`),
  INDEX `idx_status` (`Status`),
  INDEX `idx_display_order` (`DisplayOrder`)
);
```

#### Banner Audit Table (Optional)
```sql
CREATE TABLE `tblbanneraudit` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BannerID` int(10) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `OldValues` text NULL,
  `NewValues` text NULL,
  `AdminID` int(10) NOT NULL,
  `ActionDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`BannerID`) REFERENCES `tblbanner`(`ID`),
  FOREIGN KEY (`AdminID`) REFERENCES `tbladmin`(`ID`)
);
```

### 2. Core PHP Components

#### BannerManager Class
```php
class BannerManager {
    private $connection;
    
    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }
    
    public function addBanner($bannerName, $bannerImage, $description, $adminId) {
        // Insert new banner into database
        // Handle image upload
        // Set default display order
        // Log audit trail
    }
    
    public function updateBanner($bannerId, $bannerName, $description, $newImage = null) {
        // Update banner details
        // Handle image replacement if provided
        // Update modification timestamp
        // Log audit trail
    }
    
    public function deleteBanner($bannerId) {
        // Remove banner from database
        // Delete associated image file
        // Log audit trail
    }
    
    public function toggleBannerStatus($bannerId, $status) {
        // Update banner status (Active/Inactive)
        // Log audit trail
    }
    
    public function getAllBanners($activeOnly = false) {
        // Return banners with optional status filter
        // Order by DisplayOrder
    }
    
    public function reorderBanners($bannerOrders) {
        // Update display order for multiple banners
        // Validate order values
    }
}
```

#### ImageUploadHandler Class
```php
class ImageUploadHandler {
    private $uploadPath;
    private $allowedTypes;
    private $maxFileSize;
    
    public function __construct() {
        $this->uploadPath = 'assets/images/banners/';
        $this->allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $this->maxFileSize = 5 * 1024 * 1024; // 5MB
    }
    
    public function uploadBannerImage($file) {
        // Validate file type and size
        // Generate unique filename
        // Move uploaded file to banner directory
        // Return filename or error
    }
    
    public function deleteBannerImage($filename) {
        // Remove image file from server
        // Handle file not found gracefully
    }
    
    public function validateImage($file) {
        // Check file type, size, and validity
        // Return validation result
    }
}
```

### 3. Enhanced User Interfaces

#### Admin Sidebar Integration
- **Menu Item**: "Banner Management" in admin sidebar
- **Sub-menu Items**: 
  - "View Banners" - List all banners
  - "Add Banner" - Create new banner
  - "Banner Settings" - Global banner configuration

#### Banner List Interface (`admin/manage-banners.php`)
- **Table View**: Display banners with thumbnail, name, status, and actions
- **Action Buttons**: Edit, Delete, Activate/Deactivate for each banner
- **Bulk Actions**: Select multiple banners for batch operations
- **Search and Filter**: Filter by status, search by name
- **Pagination**: Handle large numbers of banners efficiently

#### Add/Edit Banner Interface (`admin/add-banner.php`, `admin/edit-banner.php`)
- **Form Fields**: Banner name, image upload, description
- **Image Preview**: Show current image (for edit) or preview (for add)
- **Validation**: Client-side and server-side validation
- **Progress Indicator**: Upload progress for large images

#### Banner Reorder Interface
- **Drag and Drop**: Intuitive reordering interface
- **Visual Feedback**: Clear indication of current order
- **Save Changes**: Batch update of display orders

### 4. File Structure Enhancements

```
vasantham/
├── admin/
│   ├── manage-banners.php (New)
│   ├── add-banner.php (New)
│   ├── edit-banner.php (New)
│   ├── delete-banner.php (New)
│   ├── banner-actions.php (New)
│   └── includes/
│       └── sidebar.php (Modified)
├── assets/
│   └── images/
│       └── banners/ (New directory)
├── includes/
│   ├── banner-functions.php (New)
│   └── image-upload.php (New)
├── index.php (Modified)
└── banner-display.php (New - for dynamic banner loading)
```

### 5. Homepage Integration

#### Dynamic Banner Loading
```php
// In index.php, replace static banner carousel with dynamic loading
$bannerManager = new BannerManager($con);
$activeBanners = $bannerManager->getAllBanners(true);

if (!empty($activeBanners)) {
    // Generate carousel slides dynamically
    foreach ($activeBanners as $banner) {
        // Create slide HTML with banner image and details
    }
} else {
    // Display default banner or hide section
}
```

## Data Models

### Banner Entity
```
Banner {
    ID: Primary key
    BannerName: Display name for admin reference
    BannerImage: Filename of uploaded image
    BannerDescription: Optional description/alt text
    Status: Active/Inactive
    DisplayOrder: Order of appearance (1, 2, 3...)
    CreatedBy: Admin who created the banner
    CreationDate: When banner was created
    UpdationDate: Last modification timestamp
}
```

### Banner States
```
Active -> Banner is visible on homepage
Inactive -> Banner is hidden from homepage but preserved in system
```

### File Naming Convention
```
banner_[timestamp]_[random].[extension]
Example: banner_20241208_abc123.jpg
```

## Error Handling

### File Upload Errors
- **File Too Large**: Display size limit and current file size
- **Invalid File Type**: Show allowed file types
- **Upload Failed**: Generic upload error with retry option
- **Disk Space**: Handle insufficient server storage

### Database Errors
- **Connection Issues**: Graceful degradation with user-friendly messages
- **Constraint Violations**: Validate data before database operations
- **Duplicate Names**: Handle banner name uniqueness if required

### Image Processing Errors
- **Corrupt Images**: Validate image integrity before saving
- **Missing Images**: Handle cases where image files are deleted manually
- **Permission Issues**: Check file system permissions

## Security Considerations

### File Upload Security
- **File Type Validation**: Strict checking of file extensions and MIME types
- **File Size Limits**: Prevent large file uploads that could impact server
- **Filename Sanitization**: Generate safe filenames to prevent path traversal
- **Image Validation**: Verify uploaded files are actually images

### Access Control
- **Admin Authentication**: Verify admin session for all banner operations
- **Permission Levels**: Ensure only authorized admins can manage banners
- **CSRF Protection**: Implement tokens for state-changing operations

### Data Validation
- **Input Sanitization**: Clean all user inputs before database operations
- **SQL Injection Prevention**: Use prepared statements
- **XSS Prevention**: Sanitize output data

## Performance Considerations

### Image Optimization
- **Image Compression**: Automatically compress uploaded images
- **Multiple Sizes**: Generate thumbnail versions for admin interface
- **Lazy Loading**: Implement lazy loading for banner images
- **CDN Integration**: Option to serve images from CDN

### Database Optimization
- **Indexing**: Proper indexes on Status and DisplayOrder columns
- **Query Optimization**: Efficient queries for banner retrieval
- **Caching**: Cache active banners to reduce database queries

### Frontend Performance
- **Image Preloading**: Preload banner images for smooth transitions
- **Carousel Optimization**: Efficient carousel implementation
- **Mobile Optimization**: Responsive images for different screen sizes

## Testing Strategy

### Unit Testing
- **Banner CRUD Operations**: Test all banner management functions
- **Image Upload**: Test file upload and validation logic
- **Status Management**: Test banner activation/deactivation

### Integration Testing
- **Admin Interface**: Test complete banner management workflow
- **Homepage Display**: Verify banners appear correctly on homepage
- **File System**: Test image upload and deletion operations

### User Acceptance Testing
- **Admin Workflow**: Test admin banner management experience
- **Homepage Display**: Verify banner display on public homepage
- **Error Handling**: Test error scenarios and recovery

### Security Testing
- **File Upload Security**: Test malicious file upload attempts
- **Access Control**: Verify unauthorized access prevention
- **Input Validation**: Test various input scenarios

## Implementation Phases

### Phase 1: Database and Core Functions
- Create tblbanner table and related structures
- Implement BannerManager and ImageUploadHandler classes
- Create basic CRUD operations for banners

### Phase 2: Admin Interface
- Add banner management menu to admin sidebar
- Create banner list, add, and edit interfaces
- Implement image upload functionality

### Phase 3: Homepage Integration
- Modify index.php to load banners dynamically
- Implement banner carousel with database-driven content
- Add fallback for when no active banners exist

### Phase 4: Advanced Features
- Implement banner reordering functionality
- Add banner status management (activate/deactivate)
- Create audit trail and logging system

### Phase 5: Polish and Optimization
- Add image optimization and thumbnail generation
- Implement advanced search and filtering
- Add bulk operations and performance optimizations