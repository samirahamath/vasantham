CREATE TABLE `tblblogs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BlogTitle` varchar(255) NOT NULL,
  `BlogDescription` text NOT NULL,
  `BlogImage` varchar(255) DEFAULT NULL,
  `Status` enum('Active','Inactive') DEFAULT 'Inactive',
  `CreationDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  `CreatedByName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
);
