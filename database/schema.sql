-- ===================================================================
-- AuraEdition database schema
-- Generated from auraedition.mwb (MySQL Workbench model)
-- Target: MySQL 8.x, InnoDB, utf8mb4
--
-- Usage: mysql -u root -p < database/schema.sql
-- Note: foreign keys use default RESTRICT; application code deletes
--       child rows explicitly before parents.
-- ===================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `auraedition`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `auraedition`;

-- ---- makes ----
CREATE TABLE `makes` (
  `make_id` INT NOT NULL AUTO_INCREMENT,
  `make_name` VARCHAR(100) NOT NULL,
  `make_image` VARCHAR(255) NULL DEFAULT '/Projects/AuraEdition/products/img/makes1.jpg',
  PRIMARY KEY (`make_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- model ----
CREATE TABLE `model` (
  `model_id` INT NOT NULL AUTO_INCREMENT,
  `model_name` VARCHAR(100) NOT NULL,
  `model_make_id` INT NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `model_make_id_idx` (`model_make_id`),
  CONSTRAINT `model_make_id` FOREIGN KEY (`model_make_id`) REFERENCES `makes` (`make_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- users ----
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(45) NOT NULL,
  `lname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `hashed_password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `registerd_date` DATETIME NULL DEFAULT NULL,
  `password_reset_token` VARCHAR(255) NULL DEFAULT NULL,
  `password_reset_expires` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- user_addresses ----
CREATE TABLE `user_addresses` (
  `address_id` INT NOT NULL AUTO_INCREMENT,
  `address_user_id` INT NOT NULL,
  `address` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(45) NULL DEFAULT NULL,
  `state` VARCHAR(45) NULL DEFAULT NULL,
  `country` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `address_user_id` (`address_user_id`),
  CONSTRAINT `address_user_id` FOREIGN KEY (`address_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- vehicles ----
CREATE TABLE `vehicles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `make_id` INT NOT NULL,
  `model_id` INT NOT NULL,
  `description` TEXT NOT NULL,
  `stock` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_featured` TINYINT NULL DEFAULT '0',
  `is_popular` TINYINT NULL DEFAULT '0',
  `status` ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  KEY `make_id` (`make_id`),
  KEY `model_id` (`model_id`),
  CONSTRAINT `make_id` FOREIGN KEY (`make_id`) REFERENCES `makes` (`make_id`),
  CONSTRAINT `model_id` FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- vehicle_images ----
CREATE TABLE `vehicle_images` (
  `image_id` INT NOT NULL AUTO_INCREMENT,
  `image_vehicle_id` INT NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `is_primary` TINYINT NULL DEFAULT '0',
  `uploaded_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `image_vehicle_id` (`image_vehicle_id`),
  CONSTRAINT `image_vehicle_id` FOREIGN KEY (`image_vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- carts ----
CREATE TABLE `carts` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `cart_user_idx` (`user_id`),
  CONSTRAINT `cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- cart_items ----
CREATE TABLE `cart_items` (
  `cart_item_id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  KEY `vehicle_idx` (`vehicle_id`),
  KEY `cart_id_idx` (`cart_id`),
  CONSTRAINT `cart_item_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  CONSTRAINT `cart_item_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- orders ----
CREATE TABLE `orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending','shipped','delivered') NULL DEFAULT 'pending',
  `orderd_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- order_items ----
CREATE TABLE `order_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_id_idx` (`vehicle_id`),
  KEY `order_id_idx` (`order_id`),
  CONSTRAINT `order_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_item_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---- wishlist_items ----
CREATE TABLE `wishlist_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `wishlist_user_id` (`user_id`),
  KEY `wishlist_vehicle_id` (`vehicle_id`),
  CONSTRAINT `wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `wishlist_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
