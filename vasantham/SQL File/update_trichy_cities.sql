-- Purpose: Replace existing tblcity entries with Trichy local area names
-- Run this after importing the base remsdb schema.

START TRANSACTION;

-- Remove existing city data (resets auto increment too)
TRUNCATE TABLE `tblcity`;

-- Detect dynamic IDs for India and Tamil Nadu (supports large master datasets)
SET @INDIA_ID := (SELECT ID FROM tblcountry WHERE CountryName LIKE 'India%' LIMIT 1);
SET @TN_STATE_ID := (SELECT ID FROM tblstate WHERE StateName LIKE 'Tamil%' LIMIT 1);

-- Fallbacks if not found
SET @INDIA_ID := IFNULL(@INDIA_ID, 1);
SET @TN_STATE_ID := IFNULL(@TN_STATE_ID, 3);

-- Insert Trichy & surrounding localities (auto ID)
INSERT INTO `tblcity` (CountryID, StateID, CityName, EnterDate) VALUES
(@INDIA_ID, @TN_STATE_ID, 'Palakarai',            NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Chatram',              NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Central Bus Stand',    NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Thillai Nagar',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Srirangam',            NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Cantonment',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Tennur',               NOW()),
(@INDIA_ID, @TN_STATE_ID, 'KK Nagar',             NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Crawford',             NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Edamalaipatti Pudur',  NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Ariyamangalam',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Bheema Nagar',         NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Ramalinga Nagar',      NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kattur',               NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Woraiyur',             NOW()),
-- ~20 km ring
(@INDIA_ID, @TN_STATE_ID, 'Golden Rock',          NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Ponmalai',             NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Navalurkottapattu',    NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Pirattiyur',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Melapudur',            NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Ganapathy Nagar',      NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Bharathidasan Nagar',  NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kailasapuram (BHEL)',  NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Manachanallur',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Samayapuram',          NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Thuvakudi',            NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Jeeyapuram',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Panayakurichi',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Bikshandarkoil',       NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kulumani',             NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Mathur (Airport)',     NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Keeranur Road',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kottapattu',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Panruti (Trichy)',     NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Allithurai',           NOW()),
-- 20–25 km extension
(@INDIA_ID, @TN_STATE_ID, 'Thiruverumbur',        NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Lalgudi',              NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Mutharasanallur',      NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Koothappar',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Mannarpuram',          NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Senthaneerpuram',      NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Gundur',               NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kondayampettai',       NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Nachikurichi',         NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Vayalur',              NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Mambalasalai',         NOW()),
(@INDIA_ID, @TN_STATE_ID, 'K.Kallikudi',          NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Navalpattu',           NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Thiruparaithurai',     NOW()),
(@INDIA_ID, @TN_STATE_ID, 'Kolli Malai Foothills',NOW());

-- Reset AUTO_INCREMENT (optional)
ALTER TABLE `tblcity` AUTO_INCREMENT=1;

COMMIT;

-- Usage:
-- 1. Import your original remsdb (2).sql (or existing database schema).
-- 2. Run this script.
-- 3. Application will now list only Trichy local areas as cities (matching actual Tamil Nadu & India IDs automatically).
