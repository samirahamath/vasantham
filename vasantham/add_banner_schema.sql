-- Banner Management System Database Schema
-- Execute this script to add banner management functionality

-- Create banner table
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create banner audit table for tracking changes
CREATE TABLE `tblbanneraudit` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BannerID` int(10) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `OldValues` text NULL,
  `NewValues` text NULL,
  `AdminID` int(10) NOT NULL,
  `ActionDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`BannerID`) REFERENCES `tblbanner`(`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`AdminID`) REFERENCES `tbladmin`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some sample banners (optional - for testing)
INSERT INTO `tblbanner` (`BannerName`, `BannerImage`, `BannerDescription`, `Status`, `DisplayOrder`, `CreatedBy`) VALUES
('Welcome Banner', '7.jpg', 'Main welcome banner for homepage', 'Active', 1, 1),
('Property Showcase', '8.jpg', 'Showcase of premium properties', 'Active', 2, 1),
('Investment Opportunities', '9.jpg', 'Investment opportunities banner', 'Active', 3, 1);

-- Create banner images directory (Note: This needs to be created manually on the server)
-- Directory: vasantham/assets/images/banners/