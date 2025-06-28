-- AuraEdition Database Schema for InfinityFree
-- Modified version that works with existing InfinityFree database
-- Import this file to create the database structure

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(45) CHARACTER SET 'utf8mb3' NOT NULL,
  `lname` VARCHAR(45) CHARACTER SET 'utf8mb3' NOT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8mb3' NOT NULL,
  `hashed_password` VARCHAR(255) CHARACTER SET 'utf8mb3' NOT NULL,
  `role` ENUM('user', 'admin') CHARACTER SET 'utf8mb3' NOT NULL DEFAULT 'user',
  `registerd_date` DATETIME NULL DEFAULT NULL,
  `password_reset_token` VARCHAR(255) NULL DEFAULT NULL,
  `password_reset_expires` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY USING BTREE (`id`),
  UNIQUE INDEX `UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `carts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`cart_id`),
  INDEX `cart_user_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `cart_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `makes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `makes` (
  `make_id` INT NOT NULL AUTO_INCREMENT,
  `make_name` VARCHAR(100) CHARACTER SET 'utf8mb3' NOT NULL,
  `make_image` VARCHAR(255) CHARACTER SET 'utf8mb3' NULL DEFAULT '/Projects/AuraEdition/products/img/makes1.jpg',
  PRIMARY KEY (`make_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `model`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `model` (
  `model_id` INT NOT NULL AUTO_INCREMENT,
  `model_name` VARCHAR(100) CHARACTER SET 'utf8mb3' NOT NULL,
  `model_make_id` INT NOT NULL,
  PRIMARY KEY (`model_id`),
  INDEX `model_make_id_idx` (`model_make_id` ASC) VISIBLE,
  CONSTRAINT `model_make_id`
    FOREIGN KEY (`model_make_id`)
    REFERENCES `makes` (`make_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `vehicles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) CHARACTER SET 'utf8mb3' NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `make_id` INT NOT NULL,
  `model_id` INT NOT NULL,
  `description` TEXT CHARACTER SET 'utf8mb3' NOT NULL,
  `stock` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_featured` TINYINT NULL DEFAULT '0',
  `is_popular` TINYINT NULL DEFAULT '0',
  `status` ENUM('ACTIVE', 'INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY USING BTREE (`id`),
  INDEX `make_id` (`make_id` ASC) VISIBLE,
  INDEX `model_id` (`model_id` ASC) VISIBLE,
  CONSTRAINT `make_id`
    FOREIGN KEY (`make_id`)
    REFERENCES `makes` (`make_id`),
  CONSTRAINT `model_id`
    FOREIGN KEY (`model_id`)
    REFERENCES `model` (`model_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `cart_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_item_id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  INDEX `vehicle_idx` (`vehicle_id` ASC) VISIBLE,
  INDEX `cart_id_idx` (`cart_id` ASC) VISIBLE,
  CONSTRAINT `cart_id`
    FOREIGN KEY (`cart_id`)
    REFERENCES `carts` (`cart_id`),
  CONSTRAINT `cart_item_vehicle`
    FOREIGN KEY (`vehicle_id`)
    REFERENCES `vehicles` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 54
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'shipped', 'delivered') CHARACTER SET 'utf8mb3' NULL DEFAULT 'pending',
  `orderd_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `user_id_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 30
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `order_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `vehicle_id_idx` (`vehicle_id` ASC) VISIBLE,
  INDEX `order_id_idx` (`order_id` ASC) VISIBLE,
  CONSTRAINT `order_id`
    FOREIGN KEY (`order_id`)
    REFERENCES `orders` (`order_id`),
  CONSTRAINT `vehicle_id`
    FOREIGN KEY (`vehicle_id`)
    REFERENCES `vehicles` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 29
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `user_addresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `address_id` INT NOT NULL AUTO_INCREMENT,
  `address_user_id` INT NOT NULL,
  `address` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(45) NULL DEFAULT NULL,
  `state` VARCHAR(45) NULL DEFAULT NULL,
  `country` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  INDEX `address_user_id` (`address_user_id` ASC) VISIBLE,
  CONSTRAINT `address_user_id`
    FOREIGN KEY (`address_user_id`)
    REFERENCES `users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `vehicle_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicle_images` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `image_vehicle_id` INT NOT NULL,
  `image_path` VARCHAR(255) CHARACTER SET 'utf8mb3' NOT NULL,
  `is_primary` TINYINT(1) NULL DEFAULT '0',
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_id`),
  INDEX `image_vehicle_id_idx` (`image_vehicle_id` ASC) VISIBLE,
  CONSTRAINT `image_vehicle_id`
    FOREIGN KEY (`image_vehicle_id`)
    REFERENCES `vehicles` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb3;

-- -----------------------------------------------------
-- Table `wishlist_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wishlist_items` (
  `wishlist_item_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wishlist_item_id`),
  INDEX `wishlist_user_id_idx` (`user_id` ASC) VISIBLE,
  INDEX `wishlist_vehicle_id_idx` (`vehicle_id` ASC) VISIBLE,
  CONSTRAINT `wishlist_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`),
  CONSTRAINT `wishlist_vehicle_id`
    FOREIGN KEY (`vehicle_id`)
    REFERENCES `vehicles` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb3;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS; 