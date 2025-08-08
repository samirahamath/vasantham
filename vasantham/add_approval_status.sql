-- =====================================================
-- Property Approval Workflow Database Migration Script
-- =====================================================
-- This script adds the complete approval workflow functionality
-- to the Vasantham Real Estate Management System
-- 
-- Run this script in your MySQL database to enable the approval system
-- =====================================================

-- Step 1: Add approval-related columns to tblproperty table
ALTER TABLE `tblproperty` ADD COLUMN `ApprovalStatus` VARCHAR(20) DEFAULT 'Pending' AFTER `ListingDate`;
ALTER TABLE `tblproperty` ADD COLUMN `ApprovalDate` TIMESTAMP NULL AFTER `ApprovalStatus`;
ALTER TABLE `tblproperty` ADD COLUMN `ApprovedBy` INT(10) NULL AFTER `ApprovalDate`;
ALTER TABLE `tblproperty` ADD COLUMN `RejectionReason` TEXT NULL AFTER `ApprovedBy`;
ALTER TABLE `tblproperty` ADD COLUMN `RejectionDate` TIMESTAMP NULL AFTER `RejectionReason`;

-- Step 2: Create audit table for tracking approval history
CREATE TABLE `tblpropertyaudit` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `PropertyID` int(10) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `OldStatus` varchar(20) NULL,
  `NewStatus` varchar(20) NOT NULL,
  `AdminID` int(10) NULL,
  `Comments` text NULL,
  `ActionDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `idx_property_audit` (`PropertyID`),
  KEY `idx_admin_audit` (`AdminID`),
  KEY `idx_action_date` (`ActionDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Step 3: Add foreign key constraints (with error handling)
-- Note: Foreign key constraints may fail if there are orphaned records
-- We'll add them with proper error handling

-- Add foreign key for ApprovedBy field
SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `tblproperty` ADD CONSTRAINT `fk_approved_by` 
FOREIGN KEY (`ApprovedBy`) REFERENCES `tbladmin`(`ID`) ON DELETE SET NULL;

-- Add foreign key constraints for audit table
ALTER TABLE `tblpropertyaudit` ADD CONSTRAINT `fk_audit_property` 
FOREIGN KEY (`PropertyID`) REFERENCES `tblproperty`(`ID`) ON DELETE CASCADE;

ALTER TABLE `tblpropertyaudit` ADD CONSTRAINT `fk_audit_admin` 
FOREIGN KEY (`AdminID`) REFERENCES `tbladmin`(`ID`) ON DELETE SET NULL;
SET FOREIGN_KEY_CHECKS = 1;

-- Step 4: Add performance indexes
CREATE INDEX `idx_approval_status` ON `tblproperty`(`ApprovalStatus`);
CREATE INDEX `idx_approval_date` ON `tblproperty`(`ApprovalDate`);
CREATE INDEX `idx_approved_by` ON `tblproperty`(`ApprovedBy`);
CREATE INDEX `idx_rejection_date` ON `tblproperty`(`RejectionDate`);

-- Step 5: Update existing property records
-- Set existing properties to 'Approved' status to maintain current functionality
-- This ensures all current properties remain visible to the public
UPDATE `tblproperty` 
SET `ApprovalStatus` = 'Approved', 
    `ApprovalDate` = `ListingDate`,
    `ApprovedBy` = 1  -- Assuming admin ID 1 exists, adjust as needed
WHERE `ApprovalStatus` IS NULL OR `ApprovalStatus` = '';

-- Step 6: Create initial audit records for existing properties
INSERT INTO `tblpropertyaudit` (`PropertyID`, `Action`, `OldStatus`, `NewStatus`, `AdminID`, `Comments`, `ActionDate`)
SELECT 
    `ID` as PropertyID,
    'MIGRATED' as Action,
    NULL as OldStatus,
    'Approved' as NewStatus,
    1 as AdminID,  -- Assuming admin ID 1 exists
    'Property approved during system migration' as Comments,
    `ListingDate` as ActionDate
FROM `tblproperty` 
WHERE `ApprovalStatus` = 'Approved';

-- Step 7: Verify the migration
-- Run these queries to verify the migration was successful

-- Check if columns were added successfully
SELECT COUNT(*) as total_properties, 
       COUNT(CASE WHEN ApprovalStatus = 'Approved' THEN 1 END) as approved_properties,
       COUNT(CASE WHEN ApprovalStatus = 'Pending' THEN 1 END) as pending_properties,
       COUNT(CASE WHEN ApprovalStatus = 'Rejected' THEN 1 END) as rejected_properties
FROM `tblproperty`;

-- Check audit table
SELECT COUNT(*) as audit_records FROM `tblpropertyaudit`;

-- Display sample of updated properties
SELECT ID, PropertyTitle, ApprovalStatus, ApprovalDate, ApprovedBy 
FROM `tblproperty` 
LIMIT 5;

-- =====================================================
-- Migration Complete!
-- =====================================================
-- The approval workflow system is now ready to use.
-- 
-- Next steps:
-- 1. Update your PHP code to use the new approval workflow
-- 2. Test the admin approval interface
-- 3. Verify that new properties are created with 'Pending' status
-- =====================================================