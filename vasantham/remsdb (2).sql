-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 05:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8989898980, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-01-02 07:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblcity`
--

CREATE TABLE `tblcity` (
  `ID` int(10) NOT NULL,
  `CountryID` int(5) DEFAULT NULL,
  `StateID` int(5) NOT NULL,
  `CityName` varchar(120) DEFAULT NULL,
  `EnterDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcity`
--

INSERT INTO `tblcity` (`ID`, `CountryID`, `StateID`, `CityName`, `EnterDate`) VALUES
(1, 1, 2, 'Aligarh', '2024-09-03 11:29:25'),
(2, 1, 2, 'Varanasi', '2024-09-03 11:29:25'),
(3, 1, 2, 'Allahabad', '2024-09-03 11:29:25'),
(4, 1, 2, 'Ghaziabad', '2024-09-03 11:29:25'),
(5, 2, 2, 'New Castle', '2024-09-03 11:29:25'),
(6, 1, 2, 'Varanasi', '2024-09-03 11:29:25'),
(7, 2, 2, 'Mount Gambier', '2024-09-03 11:29:25'),
(8, 2, 2, 'Whyalla', '2024-09-03 11:29:25'),
(9, 2, 2, 'Brisbane', '2024-09-03 11:29:25'),
(10, 16, 16, 'Los Angeles', '2024-09-03 11:29:25'),
(11, 16, 16, 'San Francisco', '2024-09-03 11:29:25'),
(12, 16, 16, 'Miami', '2024-09-03 11:29:25'),
(13, 16, 16, 'Orlando', '2024-09-03 11:29:25'),
(14, 16, 16, 'queens', '2024-09-03 11:29:25'),
(15, 7, 18, 'ABC', '2024-09-03 11:29:25'),
(16, 1, 1, 'Patna', '2024-09-03 11:29:25'),
(18, 1, 4, 'New Delhi', '2024-09-03 11:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `tblcountry`
--

CREATE TABLE `tblcountry` (
  `ID` int(10) NOT NULL,
  `CountryName` varchar(120) DEFAULT NULL,
  `EnterDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcountry`
--

INSERT INTO `tblcountry` (`ID`, `CountryName`, `EnterDate`) VALUES
(2, 'Australia', '2024-01-02 07:21:04'),
(3, 'Brazil', '2024-01-02 07:21:04'),
(4, 'China', '2024-01-02 07:21:04'),
(5, 'Germany', '2024-01-02 07:21:04'),
(6, 'Ireland', '2024-01-02 07:21:04'),
(7, 'Japan', '2024-01-02 07:21:04'),
(8, 'Kenya', '2024-01-02 07:21:04'),
(9, 'Malaysia', '2024-01-02 07:21:04'),
(10, 'Russia', '2024-01-02 07:21:04'),
(11, 'Singapore', '2024-01-02 07:21:04'),
(12, 'South Africa', '2024-01-02 07:21:04'),
(13, 'Thailand', '2024-01-02 07:21:04'),
(14, 'Turkey', '2024-01-02 07:21:04'),
(15, 'UK', '2024-01-02 07:21:04'),
(16, 'USA', '2024-01-02 07:21:04'),
(17, 'Zimbabwe', '2024-01-02 07:21:04'),
(18, 'Vietnam', '2024-01-02 07:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `ID` int(11) NOT NULL,
  `PropertyID` int(10) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `MobileNumber` bigint(10) NOT NULL,
  `Message` mediumtext NOT NULL,
  `EnquiryNumber` varchar(200) NOT NULL,
  `EnquiryDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(10) DEFAULT NULL,
  `Remark` varchar(200) DEFAULT NULL,
  `RemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`ID`, `PropertyID`, `FullName`, `Email`, `MobileNumber`, `Message`, `EnquiryNumber`, `EnquiryDate`, `Status`, `Remark`, `RemarkDate`) VALUES
(2, 2, 'Ramesh Kumar', 'ramesh@gmail.com', 8989889898, 'Give me best prices of this property', '295692123', '2024-01-03 11:58:27', NULL, NULL, '2024-01-06 04:35:21'),
(3, 2, 'Akash', 'akash@gmail.com', 5656565656, 'hgfhf gy f ', '611895685', '2024-01-03 16:02:03', NULL, NULL, '2024-01-06 04:35:32'),
(4, 4, 'Simple user', 'testuser2@gmail.com', 1231231231, 'Test Enquiry', '558385754', '2024-01-02 19:00:26', 'Answer', 'This is for testing', '2024-01-03 19:28:09'),
(5, 2, 'Simple user', 'testuser2@gmail.com', 1231231231, 'I want some discount on this property.', '203492977', '2024-01-03 19:33:22', NULL, NULL, '2024-01-06 04:36:03'),
(6, 2, 'Amit', 'amit@gmail.om', 123123, 'kjsdjksjfksfsd', '151390361', '2024-01-03 18:31:47', NULL, NULL, '2024-01-06 04:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PropertyId` int(11) NOT NULL,
  `UserRemark` mediumtext NOT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Is_Publish` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`id`, `UserId`, `PropertyId`, `UserRemark`, `PostingDate`, `Is_Publish`) VALUES
(1, 3, 1, 'This review is for testing.', '2024-01-04 19:15:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(120) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About Us', '<b><font color=\"#003399\">Real Estate Management System</font></b><div><br></div><div><b><font color=\"#003399\">Our Vision:</font></b></div><div><span style=\"color: rgb(170, 170, 170); font-family: Poppins, sans-serif;\">Propin ipsum dolor sit amet, consectetur adipisicing elited eiusmod tempore incidid ut labor et dolore magna aliquaut enim ad minim veniam.</span><br></div><div><span style=\"color: rgb(170, 170, 170); font-family: Poppins, sans-serif;\"><br></span></div><div><span style=\"font-family: Poppins, sans-serif;\"><b style=\"\"><font color=\"#003399\">Our Goal:</font></b></span></div><div><span style=\"color: rgb(170, 170, 170); font-family: Poppins, sans-serif;\">Duis aute viele irure dolor in reprer volupta velite esse cilume dolore eu fugiat nulla pariatur. Excepteur sint occae cupidat non proident.</span><span style=\"color: rgb(170, 170, 170); font-family: Poppins, sans-serif;\"><b><br></b></span></div><div><br></div>', 'info@gmsil.com', 8989899898, '2024-01-04 05:10:58'),
(2, 'contactus', 'Contact Us', 'D-204, Hole Town South West,<div>Delhi-110096,India</div>', 'info@gmail.com', 8529631235, '2024-01-04 05:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblproperty`
--

CREATE TABLE `tblproperty` (
  `ID` int(10) NOT NULL,
  `UserID` char(20) DEFAULT NULL,
  `PropertyTitle` mediumtext DEFAULT NULL,
  `PropertDescription` mediumtext DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL,
  `Bedrooms` varchar(200) DEFAULT NULL,
  `Bathrooms` varchar(200) DEFAULT NULL,
  `Floors` varchar(200) DEFAULT NULL,
  `Garages` varchar(200) DEFAULT NULL,
  `Area` varchar(50) DEFAULT NULL,
  `Size` varchar(50) DEFAULT NULL,
  `RentorsalePrice` varchar(120) DEFAULT NULL,
  `BeforePricelabel` varchar(120) DEFAULT NULL,
  `AfterPricelabel` varchar(120) DEFAULT NULL,
  `PropertyID` varchar(120) DEFAULT NULL,
  `CenterCooling` char(4) DEFAULT NULL,
  `Balcony` char(4) DEFAULT NULL,
  `PetFriendly` char(4) DEFAULT NULL,
  `Barbeque` char(4) DEFAULT NULL,
  `FireAlarm` char(4) DEFAULT NULL,
  `ModernKitchen` char(4) DEFAULT NULL,
  `Storage` char(4) DEFAULT NULL,
  `Dryer` char(4) DEFAULT NULL,
  `Heating` char(4) DEFAULT NULL,
  `Pool` char(4) DEFAULT NULL,
  `Laundry` char(4) DEFAULT NULL,
  `Sauna` char(4) DEFAULT NULL,
  `Gym` char(4) DEFAULT NULL,
  `Elevator` char(4) DEFAULT NULL,
  `DishWasher` char(4) DEFAULT NULL,
  `EmergencyExit` char(4) DEFAULT NULL,
  `FeaturedImage` varchar(200) DEFAULT NULL,
  `GalleryImage1` varchar(200) DEFAULT NULL,
  `GalleryImage2` varchar(200) DEFAULT NULL,
  `GalleryImage3` varchar(200) DEFAULT NULL,
  `GalleryImage4` varchar(200) DEFAULT NULL,
  `GalleryImage5` varchar(200) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Country` varchar(200) DEFAULT NULL,
  `City` varchar(220) DEFAULT NULL,
  `State` varchar(200) DEFAULT NULL,
  `ZipCode` varchar(200) DEFAULT NULL,
  `Neighborhood` varchar(200) DEFAULT NULL,
  `ListingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblproperty`
--

INSERT INTO `tblproperty` (`ID`, `UserID`, `PropertyTitle`, `PropertDescription`, `Type`, `Status`, `Location`, `Bedrooms`, `Bathrooms`, `Floors`, `Garages`, `Area`, `Size`, `RentorsalePrice`, `BeforePricelabel`, `AfterPricelabel`, `PropertyID`, `CenterCooling`, `Balcony`, `PetFriendly`, `Barbeque`, `FireAlarm`, `ModernKitchen`, `Storage`, `Dryer`, `Heating`, `Pool`, `Laundry`, `Sauna`, `Gym`, `Elevator`, `DishWasher`, `EmergencyExit`, `FeaturedImage`, `GalleryImage1`, `GalleryImage2`, `GalleryImage3`, `GalleryImage4`, `GalleryImage5`, `Address`, `Country`, `City`, `State`, `ZipCode`, `Neighborhood`, `ListingDate`) VALUES
(1, '1', '2 BHK Builder Floor', 'There two bed room with wide balcony.\r\n2. Drawing room with fall ceiling & Texture Paint\r\n3. Modern and modular kitchen with chimney and other\r\nattachments.\r\n4. two bath room with tile work upto roof height and branded\r\nfittings.\r\n5. Car parking and lift available.\r\n6. Wall to wall pop , texture paint & tiles work on front elevation.\r\n7. Vitrified tiles flooring, Kalinga wire, Branded\r\nelectrical fittings.\r\n8. Separate electric and water connections with appropriate\r\nsupply.\r\n9. Building structure according to height with branded fittings\r\nand a', 'Apartments', 'Sale', 'Uttam Nagar East', '2', '2', '1 (Out of 4 Floors)', '1 Covered', '520 sq ft', '500 sq ft', '24.1 Lac', '23 lac', '25 lac', '629126491', '0', '0', '0', '0', '1', '0', '0', '0', '0', '1', '1', '0', '1', '0', '1', '1', '94d39c9ea3bacd079a48607a45d06e6d1565936640.jpg', 'bb2e708549fa0abc3608aeb12243a5471565937233.jpg', 'c65756e6c9ec41e207d132375b324c441565937949.jpg', '42be96d2f93056d5a5b106a9abed40051565937999.jpg', '338c3a6332a0200a77b7bfe0e9ea54721565938082.jpg', 'af63798a7deebebd06af935925cba9fb1565938126jpeg', 'Uttam Nagar ', '1', 'Patna', '5', '110096', 'uttam nagar east metro station', '2024-01-03 06:40:47'),
(2, '2', '3 BHK 800 Sq-ft Flat', 'This project looks stunning and it is developed with the attention to all the small details. You will always receive compliments for the embedded classy effect crafted in Rahil Homes. Rahil Homes is one of the popular residential projects that are located in Sector 24, Rohini, New Delhi. This project offers 1, 2, 3 & 4 BHK Builder Floor Flats with basic amenities for the comfort of residents. It is close to market and many educational institutions.', 'Apartments', 'Sale', 'Rohini Sector 24', '3', '2', '1 (Out of 4 Floors)', 'Yes', '800 sqft', '796 sqft', '68 lack', '65 lac', '69 lac', '850464384', '1', '1', '1', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'image5.jpg', 'cff8ad28cf40ebf4fbdd383fe546098d1565329707.jpg', '7fdc1a630c238af0815181f9faa190f51565329707.jpg', '5fb637257132ad8e014dff431326a5ac1565329707.jpg', 'b37cef0d9aff875f77888c297150b1421565329707.jpg', 'cff8ad28cf40ebf4fbdd383fe546098d1565329707.jpg', 'Sector 24 ', '1', 'Delhi', '4', '110096', 'sector 24 metro', '2024-01-03 06:40:47'),
(3, '1', '1Bedroom 1Bath', 'Very Nice House Park Facing Xu 1 New House All Facility Are Available Fully Green Area Very Close To Pari Chaowk Near Metro Additional Details : Having A Provision To Park 1 Cars. You Can Easily Park Your Car Inside The Compound There Is Also A Separate Washroom For Domestic Help. The House Has Boring Supply. The Kitchen Has Been Built With Modular Fittings.', 'Houses', 'Sale', 'Greater Noida', '1', '1', '1', '1 Covered, 1 Open', '67 Sq. Meter', '60 Sq. Meter  ', '43 Lac', '42 lac', '44 lac', '118245832', '0', '0', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '386bb628f5a3da130210ee422d57422e1565679999jpeg', 'f1d9313ad97dcfd6e2b37dbf805a5b4f1565679999jpeg', 'd4e6271f4e62bb1f7cf10004553f3efe1565679999.jpg', '1e6ae4ada992769567b71815f124fac51565679999.jpg', 'efc1a80c391be252d7d777a437f868701565679999.jpg', '588b11ad7a92d13777fe0be3adf633bf1565679999.jpg', 'Sector Xu-I Gr Noida, , Aligarh, U P', '1', 'Aligarh', '2', '4464644', 'Near Crossing Republic School', '2024-01-03 06:40:47'),
(4, '4', '5Bedrooms 6Baths', 'Prime location\r\nWalking distance from galleria market & iffco metro station\r\nElite designer villa\r\n5bhk\r\nWest facing\r\nHuge drawing and dinning\r\nGym area\r\nVrv system\r\nItalian marble in drawing room, rooms and bathroom\r\nModular kitchen & wardrobes with german fittings\r\nBathroom fittings of queo & kohler\r\nTerrace garden with bar and service counter and gazebo\r\nFront two side lawn with landscaping and gazebo\r\nWater body and fountain in the backyard\r\nServant room\r\n4 reserved car parking\r\nReady to move in for more details call us...', 'Villas', 'Sale', 'Sushant Lok Phase - 1', '5', '7', '3 floors', '2 Covered, 2 Open', '250.84 sq mtr', '245.76 sq mtr', '5.49 cr', '4.49 cr', '6.49 cr', '869693774', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'af63798a7deebebd06af935925cba9fb1565680584jpeg', '31d460256ad31331e4d59d1377b2556b1565680584jpeg', 'd3a2a650c3ca6d9a7886a9e403bca6901565680584jpeg', 'd3812a144fafaa264821a7b1154ae44c1565680584jpeg', '0ac462ac57b106b3c62e8a310c2afe931565680584jpeg', 'c584f57049e5155743d83a21a0971b741565680584jpeg', 'A Block, Sushant Lok Phase - 1', '13', 'Varanasi', '', '221001', 'Near Kendriya Vidalya', '2024-01-03 06:40:47'),
(5, '2', '5 BHK Residential House 4830 sqft', 'Non-Vegetarians, Without Company Lease, Pets allowed', 'Houses', 'Rent', 'Vasant Vihar', '5', '6', 'Ground (Out of 1 Floors)', '2 Covered, 2 Open', '4830 sq ft', '4200 sq ft', '45000', '43000', '48000', '131599041', '1', '1', '0', '0', '1', '1', '1', '0', '0', '1', '0', '0', '0', '1', '0', '1', 'b8a1a89aa25d962639c36371b8728c571565681197.jpg', 'af63798a7deebebd06af935925cba9fb1565681197jpeg', '31d460256ad31331e4d59d1377b2556b1565681197jpeg', 'b3dc4d2ca49fca95b80b4a2c66c833b81565681197.jpg', 'd4e6271f4e62bb1f7cf10004553f3efe1565681197.jpg', '0ac462ac57b106b3c62e8a310c2afe931565681197jpeg', 'D-510,', '7', 'queens', '18', '4654646', 'XYZ', '2024-01-03 06:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `tblpropertytype`
--

CREATE TABLE `tblpropertytype` (
  `ID` int(10) NOT NULL,
  `PropertType` varchar(120) DEFAULT NULL,
  `EnterDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpropertytype`
--

INSERT INTO `tblpropertytype` (`ID`, `PropertType`, `EnterDate`) VALUES
(2, 'Houses', '2024-01-02 06:32:20'),
(3, 'Offices', '2024-01-02 06:32:20'),
(4, 'Villas', '2024-01-02 06:32:20'),
(5, 'Lands', '2024-01-02 06:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `tblstate`
--

CREATE TABLE `tblstate` (
  `ID` int(10) NOT NULL,
  `CountryID` int(5) DEFAULT NULL,
  `StateName` varchar(120) DEFAULT NULL,
  `EnterDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstate`
--

INSERT INTO `tblstate` (`ID`, `CountryID`, `StateName`, `EnterDate`) VALUES
(1, 1, 'Madhya Pradesh', '2024-01-03 10:48:36'),
(2, 1, 'Uttar Pradesh', '2024-01-03 10:48:36'),
(3, 1, 'Tamilnadu', '2024-01-03 10:48:36'),
(4, 1, 'Delhi/NCR', '2024-01-03 10:48:36'),
(5, 1, 'Bihar', '2024-01-03 10:48:36'),
(6, 1, 'Uttrakhand', '2024-01-03 10:48:36'),
(7, 2, 'New South Wales', '2024-01-03 10:48:36'),
(8, 2, 'Queensland', '2024-01-03 10:48:36'),
(9, 2, 'South Australia', '2024-01-03 10:48:36'),
(10, 2, 'Victoria', '2024-01-03 10:48:36'),
(11, 2, 'Tasmania', '2024-01-03 10:48:36'),
(12, 16, 'California', '2024-01-03 10:48:36'),
(13, 16, 'Florida', '2024-01-03 10:48:36'),
(14, 16, 'New York', '2024-01-03 10:48:36'),
(15, 16, 'New Mexico', '2024-01-03 10:48:36'),
(16, 16, 'New Jersey.', '2024-01-03 10:48:36'),
(17, 16, 'Virginia', '2024-01-03 10:48:36'),
(18, 7, 'Tokyo', '2024-01-03 10:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `UserType` int(5) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Aboutme` mediumtext DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FullName`, `Email`, `MobileNumber`, `Password`, `UserType`, `PostingDate`, `Aboutme`, `UpdationDate`) VALUES
(1, 'Test', 'test@gmail.com', 8596234569, 'f925916e2754e5e03f75dd58a5733251', 1, '2024-08-03 15:50:08', 'I am Mahesh.\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercit.\r\n', '2024-01-03 18:23:45'),
(2, 'Rajesh Singh', 'raj@gmail.com', 4446464646, '202cb962ac59075b964b07152d234b70', 2, '2024-08-03 15:50:08', '', '2024-01-03 18:24:07'),
(3, 'Akash', 'akash@gmail.com', 5656565656, '202cb962ac59075b964b07152d234b70', 3, '2024-08-03 15:50:08', 'NA', '2024-01-03 18:24:07'),
(4, 'Test user', 'testuser@gmail.com', 1234567890, 'f925916e2754e5e03f75dd58a5733251', 1, '2024-08-03 15:50:08', 'Test', '2024-01-03 18:24:07'),
(5, 'Simple user', 'testuser2@gmail.com', 1231231231, 'f925916e2754e5e03f75dd58a5733251', 3, '2024-08-03 15:50:08', 'I am looking for 2 BHK', '2024-01-03 18:24:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcity`
--
ALTER TABLE `tblcity`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcountry`
--
ALTER TABLE `tblcountry`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblproperty`
--
ALTER TABLE `tblproperty`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpropertytype`
--
ALTER TABLE `tblpropertytype`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblstate`
--
ALTER TABLE `tblstate`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcity`
--
ALTER TABLE `tblcity`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblcountry`
--
ALTER TABLE `tblcountry`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblproperty`
--
ALTER TABLE `tblproperty`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblpropertytype`
--
ALTER TABLE `tblpropertytype`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblstate`
--
ALTER TABLE `tblstate`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
