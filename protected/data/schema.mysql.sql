SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';



-- -----------------------------------------------------
-- Table `atgps`.`device_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`device_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `modem_ID` INT(16) NOT NULL ,
  `gps_datetime` VARCHAR(14) NOT NULL ,
  `longitude` DECIMAL(9,7) NOT NULL ,
  `latitude` DECIMAL(9,7) NOT NULL ,
  `speed` INT(3) NOT NULL ,
  `direction` DECIMAL(6,3) NOT NULL ,
  `altitude` INT(11) NOT NULL ,
  `satellites` INT NOT NULL ,
  `messageID` INT(11) NOT NULL ,
  `input_status` INT(11) NOT NULL ,
  `output_status` INT(11) NOT NULL ,
  `analog_input1` DECIMAL(6,3) NOT NULL ,
  `analog_input2` DECIMAL(6,3) NOT NULL ,
  `rtc_datetime` VARCHAR(14) NOT NULL ,
  `mileage` INT(11) NOT NULL ,
  `speed_cam` INT(3) NULL COMMENT 'Km/h' ,
  `rpm_cam` INT(5) NULL ,
  `engine_temp_cam` INT(4) NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ' ,
  `fuel_level_cam` INT(3) NULL ,
  `fuel_rate_cam` INT(4) NULL ,
  `fuel_temp_cam` INT(4) NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ' ,
  `oil_press_cam` INT(5) NULL COMMENT '(KPa) ##### x 0.69' ,
  `acc_pedal_cam` INT(3) NULL COMMENT '%' ,
  `axel_weight_cam` INT(5) NULL COMMENT 'Kg' ,
  `odometer_cam` INT(11) NULL COMMENT 'Km' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 1241
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `atgps`.`device_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`device_type` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type_ar` VARCHAR(45) NULL ,
  `type_en` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`device`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`device` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `modem_ID` VARCHAR(45) NOT NULL ,
  `device_type_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `modem_ID_UNIQUE` (`modem_ID` ASC) ,
  INDEX `fk_device_device_type` (`device_type_id` ASC) ,
  CONSTRAINT `fk_device_device_type`
    FOREIGN KEY (`device_type_id` )
    REFERENCES `atgps`.`device_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`company`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`company` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `address` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`driver`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`driver` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `dob` DATE NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`user_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`user_type` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `level` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  `fullname` VARCHAR(45) NULL ,
  `title` VARCHAR(45) NULL ,
  `company_id` INT NOT NULL ,
  `user_type_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_company1` (`company_id` ASC) ,
  INDEX `fk_user_user_type1` (`user_type_id` ASC) ,
  CONSTRAINT `fk_user_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `atgps`.`company` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_user_type1`
    FOREIGN KEY (`user_type_id` )
    REFERENCES `atgps`.`user_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`vehcile_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`vehcile_type` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type_ar` VARCHAR(45) NULL ,
  `type_en` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`vehcile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`vehcile` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `device_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `serial` INT(11) NULL ,
  `model` VARCHAR(45) NULL ,
  `colour` VARCHAR(45) NULL ,
  `vehcile_type_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_vehcile_device1` (`device_id` ASC) ,
  INDEX `fk_vehcile_vehcile_type1` (`vehcile_type_id` ASC) ,
  CONSTRAINT `fk_vehcile_device1`
    FOREIGN KEY (`device_id` )
    REFERENCES `atgps`.`device` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehcile_vehcile_type1`
    FOREIGN KEY (`vehcile_type_id` )
    REFERENCES `atgps`.`vehcile_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `atgps`.`vehcile_drivers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `atgps`.`vehcile_drivers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `vehcile_id` INT NOT NULL ,
  `driver_id` INT NOT NULL ,
  `from` DATETIME NULL COMMENT 'dat' ,
  `to` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_vehcile_drivers_vehcile1` (`vehcile_id` ASC) ,
  INDEX `fk_vehcile_drivers_driver1` (`driver_id` ASC) ,
  CONSTRAINT `fk_vehcile_drivers_vehcile1`
    FOREIGN KEY (`vehcile_id` )
    REFERENCES `atgps`.`vehcile` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehcile_drivers_driver1`
    FOREIGN KEY (`driver_id` )
    REFERENCES `atgps`.`driver` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
