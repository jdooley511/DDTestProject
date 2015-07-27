-- Create Schema
CREATE SCHEMA IF NOT EXISTS ddtest;

-- Create Daily Ads Table
CREATE TABLE IF NOT EXISTS `ddtest`.`dailyads` (
  `DailyAds_ID` INT NOT NULL AUTO_INCREMENT,
  `Ad_ID` INT NULL,
  `Date` DATE NULL,
  `Views` INT NULL,
  `Deleted` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`DailyAds_ID`));

-- Create Leads Table
CREATE TABLE IF NOT EXISTS `ddtest`.`lead` (
  `Lead_ID` INT NOT NULL,
  `BirthDate` DATE NULL,
  `Ad_ID` INT NULL,
  `State` VARCHAR(5) NULL,
  `CreatedAt` DATETIME NULL,
  `Deleted` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`Lead_ID`));

ALTER TABLE `ddtest`.`lead` 
CHANGE COLUMN `Lead_ID` `Lead_ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ;

-- Create Orders Table
CREATE TABLE IF NOT EXISTS `ddtest`.`orders` (
  `Orders_ID` INT NOT NULL AUTO_INCREMENT,
  `Lead_ID` INT UNSIGNED NULL,
  `UnitPrice` DECIMAL(16,2) NULL,
  `Quantity` INT NULL,
  `ShippingCost` DECIMAL(16,2) NULL,
  `Deleted` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`Orders_ID`));

ALTER TABLE `ddtest`.`orders` 
ADD INDEX `lead_fk_1_idx` (`Lead_ID` ASC);
ALTER TABLE `ddtest`.`orders` 
ADD CONSTRAINT `lead_fk_1`
  FOREIGN KEY (`Lead_ID`)
  REFERENCES `ddtest`.`lead` (`Lead_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;





