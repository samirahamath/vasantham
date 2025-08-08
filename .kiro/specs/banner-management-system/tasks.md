# Implementation Plan

- [x] 1. Set up database schema for banner management


  - Create database migration script to add tblbanner table with all required columns
  - Create tblbanneraudit table for tracking banner changes and admin actions
  - Add necessary indexes for performance optimization on Status and DisplayOrder columns
  - Create banner images directory structure in assets/images/banners/
  - _Requirements: 1.3, 2.2, 5.1, 7.1_


- [ ] 2. Create core banner management functions
  - Write PHP functions for adding new banners including database insertion and image upload
  - Write PHP functions for updating banner details with optional image replacement
  - Implement function to delete banners including database removal and file cleanup
  - Create function to toggle banner status between Active and Inactive
  - Write function to retrieve banners with optional filtering by status
  - Implement banner reordering functionality to update display order
  - _Requirements: 1.3, 3.3, 4.2, 5.2, 5.3, 7.3_


- [ ] 3. Implement secure image upload handling
  - Create image upload class with file type validation and size limits
  - Implement secure filename generation to prevent path traversal attacks
  - Add image validation to ensure uploaded files are legitimate images
  - Create function to delete banner images from server when banners are removed
  - Add image compression and optimization for better performance


  - _Requirements: 1.3, 1.5, 3.4_

- [ ] 4. Add banner management menu to admin sidebar
  - Modify admin sidebar to include "Banner Management" menu item
  - Add sub-menu items for "View Banners", "Add Banner", and banner settings


  - Ensure proper admin authentication and permission checks for banner menu access
  - Style menu items to match existing admin theme design
  - _Requirements: 1.1_

- [ ] 5. Create banner list interface for admin
  - Build admin page to display all banners in a table format with thumbnails
  - Add action buttons for Edit, Delete, and Activate/Deactivate for each banner



  - Implement search functionality to find banners by name
  - Add filtering options to show Active, Inactive, or All banners
  - Create pagination system for handling large numbers of banners
  - Display banner creation date, status, and display order information
  - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

- [ ] 6. Build add banner interface
  - Create form with fields for banner name, image upload, and description
  - Add client-side validation for required fields and file types
  - Implement image preview functionality before form submission
  - Add server-side validation and error handling for form submission
  - Display success message and redirect to banner list after successful addition
  - Handle upload errors with user-friendly error messages
  - _Requirements: 1.2, 1.3, 1.4, 1.5_

- [x] 7. Build edit banner interface





  - Create edit form pre-filled with existing banner details
  - Allow updating banner name and description while preserving existing image
  - Implement optional image replacement with preview of current and new images
  - Add validation to ensure data integrity during updates
  - Display success message after successful banner update
  - Handle cases where image replacement fails gracefully
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5_
-

- [x] 8. Implement banner deletion functionality




  - Create delete confirmation dialog to prevent accidental deletions
  - Implement backend logic to remove banner from database and delete image file
  - Add warning if attempting to delete an active banner currently displayed
  - Display success message after successful deletion and refresh banner list
  - Handle cases where image file deletion fails but database deletion succeeds
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5_

- [x] 9. Add banner status management








  - Create toggle buttons or links to activate/deactivate banners from the banner list
  - Implement backend logic to update banner status in database
  - Add visual indicators (badges, colors) to clearly show banner status
  - Display confirmation messages when banner status is changed
  - Handle edge case where all banners are deactivated
  - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5_

- [ ] 10. Modify homepage to display banners dynamically







  - Update index.php to load active banners from database instead of static images
  - Replace hardcoded carousel slides with dynamic banner generation
  - Implement fallback display when no active banners are available
  - Ensure banner images load properly with correct paths and alt text
  - Maintain existing carousel functionality and styling
  - Add error handling for missing or corrupted banner images
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5_

- [ ] 11. Implement banner reordering functionality
  - Add display order column to banner list interface showing current order
  - Create drag-and-drop interface or up/down arrow buttons for reordering
  - Implement AJAX functionality to update banner order without page refresh
  - Add backend logic to update DisplayOrder values in database
  - Ensure homepage reflects new banner order immediately after changes
  - Handle reordering failures with error messages and order reversion
  - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_

- [ ] 12. Add comprehensive error handling and validation
  - Implement proper error handling for all database operations related to banner management
  - Add validation for admin permissions before allowing banner operations
  - Create user-friendly error messages for banner management failures
  - Add file system error handling for image upload and deletion operations
  - Implement logging for all banner-related errors and system events
  - _Requirements: 1.5, 3.4, 4.5, 5.4_

- [ ] 13. Create banner audit trail and logging system
  - Implement comprehensive logging for all banner actions including timestamps and admin details
  - Create audit trail viewing functionality for administrators to track banner history
  - Add banner change history display showing complete timeline of modifications
  - Log image upload, replacement, and deletion activities
  - Implement data retention policies for audit logs and banner history
  - _Requirements: 2.3, 3.3, 4.2, 5.4_

- [ ] 14. Write comprehensive tests for banner management system
  - Create unit tests for all banner management functions including CRUD operations
  - Write integration tests for the complete banner workflow from creation to homepage display
  - Implement tests for image upload, validation, and file handling operations
  - Create tests for banner status management and reordering functionality
  - Test error scenarios including file upload failures and database errors
  - _Requirements: 1.3, 2.1, 6.1_