SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user_roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_roles` (
  `role_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(100) NULL DEFAULT NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_name` VARCHAR(100) NULL DEFAULT NULL ,
  `user_full_name` VARCHAR(255) NULL DEFAULT NULL ,
  `user_password` VARCHAR(45) NULL DEFAULT NULL ,
  `user_email` VARCHAR(45) NULL DEFAULT NULL ,
  `user_pob` VARCHAR(100) NULL ,
  `user_dob` DATE NULL ,
  `user_role_role_id` INT(11) NULL ,
  `user_is_deleted` TINYINT(1) NULL DEFAULT 0 ,
  `user_input_date` TIMESTAMP NULL DEFAULT NULL ,
  `user_last_update` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`user_id`) ,
  INDEX `fk_user_user_role1_idx` (`user_role_role_id` ASC) ,
  CONSTRAINT `fk_user_user_role1`
    FOREIGN KEY (`user_role_role_id` )
    REFERENCES `user_roles` (`role_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `logs` (
  `log_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `log_date` TIMESTAMP NULL DEFAULT NULL ,
  `log_action` VARCHAR(45) NULL DEFAULT NULL ,
  `log_module` VARCHAR(45) NULL DEFAULT NULL ,
  `log_info` TEXT NULL DEFAULT NULL ,
  `user_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `fk_g_activity_log_g_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_g_activity_log_g_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;


-- -----------------------------------------------------
-- Table `ci_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ci_session` (
  `id` VARCHAR(40) NOT NULL ,
  `ip_address` VARCHAR(45) NOT NULL ,
  `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `data` BLOB NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `ci_sessions_timestamp` (`timestamp` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `province`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `province` (
  `province_id` INT NOT NULL AUTO_INCREMENT ,
  `province_name` VARCHAR(100) NULL ,
  PRIMARY KEY (`province_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kabupaten`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kabupaten` (
  `kabupaten_id` INT NOT NULL AUTO_INCREMENT ,
  `kabupaten_name` VARCHAR(100) NULL ,
  `province_province_id` INT NULL ,
  PRIMARY KEY (`kabupaten_id`) ,
  INDEX `fk_kabupaten_province1_idx` (`province_province_id` ASC) ,
  CONSTRAINT `fk_kabupaten_province1`
    FOREIGN KEY (`province_province_id` )
    REFERENCES `province` (`province_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `merchants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `merchants` (
  `merchant_id` INT NOT NULL AUTO_INCREMENT ,
  `password` VARCHAR(100) NULL ,
  `merchant_name` VARCHAR(100) NULL ,
  `merchant_phone` VARCHAR(20) NULL ,
  `phone_is_whatshapp` TINYINT(1) NULL ,
  `merchant_address` TEXT NULL ,
  `merchant_email` VARCHAR(45) NULL ,
  `merchant_logo` VARCHAR(100) NULL ,
  `merchant_cover` VARCHAR(100) NULL ,
  `merchant_description` TEXT NULL ,
  `merchant_web` VARCHAR(100) NULL ,
  `merchant_facebook` VARCHAR(45) NULL ,
  `merchant_twitter` VARCHAR(45) NULL ,
  `merchant_pob` VARCHAR(45) NULL ,
  `merchant_dob` DATE NULL ,
  `merchant_is_active` TINYINT(1) NULL DEFAULT 0 ,
  `merchant_package` ENUM('Bronze', 'Silver', 'Gold') NULL ,
  `merchant_owner_name` VARCHAR(100) NULL ,
  `merchant_owner_phone` VARCHAR(20) NULL ,
  `merchant_owner_ktp` VARCHAR(100) NULL ,
  `merchant_is_deleted` TINYINT(1) NULL ,
  `province_province_id` INT NULL ,
  `kabupaten_kabupaten_id` INT NULL ,
  `merchant_input_date` TIMESTAMP NULL ,
  `merchant_last_update` TIMESTAMP NULL ,
  PRIMARY KEY (`merchant_id`) ,
  INDEX `fk_merchants_kabupaten1_idx` (`kabupaten_kabupaten_id` ASC) ,
  INDEX `fk_merchants_province1_idx` (`province_province_id` ASC) ,
  CONSTRAINT `fk_merchants_kabupaten1`
    FOREIGN KEY (`kabupaten_kabupaten_id` )
    REFERENCES `kabupaten` (`kabupaten_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_merchants_province1`
    FOREIGN KEY (`province_province_id` )
    REFERENCES `province` (`province_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `galleries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `galleries` (
  `gallery_id` INT NOT NULL AUTO_INCREMENT ,
  `gallery_title` VARCHAR(255) NULL ,
  `gallery_desc` TEXT NULL ,
  `gallery_is_image` TINYINT(1) NULL ,
  `gallery_image` VARCHAR(255) NULL ,
  `gallery_video` VARCHAR(255) NULL ,
  `merchants_merchant_id` INT NULL ,
  PRIMARY KEY (`gallery_id`) ,
  INDEX `fk_galleries_merchants1_idx` (`merchants_merchant_id` ASC) ,
  CONSTRAINT `fk_galleries_merchants1`
    FOREIGN KEY (`merchants_merchant_id` )
    REFERENCES `merchants` (`merchant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `merchants_logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `merchants_logs` (
  `log_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `log_date` TIMESTAMP NULL DEFAULT NULL ,
  `log_action` VARCHAR(45) NULL DEFAULT NULL ,
  `log_module` VARCHAR(45) NULL DEFAULT NULL ,
  `log_info` TEXT NULL DEFAULT NULL ,
  `merchants_merchant_id` INT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `fk_merchants_logs_merchants1_idx` (`merchants_merchant_id` ASC) ,
  CONSTRAINT `fk_merchants_logs_merchants1`
    FOREIGN KEY (`merchants_merchant_id` )
    REFERENCES `merchants` (`merchant_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_swedish_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
