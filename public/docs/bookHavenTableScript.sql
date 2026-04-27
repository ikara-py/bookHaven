-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema book_haven
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema book_haven
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `book_haven` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `book_haven` ;

-- -----------------------------------------------------
-- Table `book_haven`.`authors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`authors` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `profile_image` VARCHAR(255) NULL DEFAULT NULL,
  `country` VARCHAR(255) NULL DEFAULT NULL,
  `date_of_birth` DATE NULL DEFAULT NULL,
  `date_of_death` DATE NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `cover` VARCHAR(255) NULL DEFAULT NULL,
  `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `categories_parent_id_foreign` (`parent_id` ASC) VISIBLE,
  CONSTRAINT `categories_parent_id_foreign`
    FOREIGN KEY (`parent_id`)
    REFERENCES `book_haven`.`categories` (`id`)
    ON DELETE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `profile_image` VARCHAR(255) NULL DEFAULT NULL,
  `role` ENUM('admin', 'buyer', 'seller', 'buyer_seller') NOT NULL DEFAULT 'buyer',
  `gender` ENUM('male', 'female') NULL DEFAULT NULL,
  `status` ENUM('active', 'suspended') NOT NULL DEFAULT 'active',
  `date_of_birth` DATE NULL DEFAULT NULL,
  `city` VARCHAR(255) NULL DEFAULT NULL,
  `country` VARCHAR(255) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `bio` TEXT NULL DEFAULT NULL,
  `is_verified` TINYINT(1) NOT NULL DEFAULT '0',
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`books`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`books` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` BIGINT UNSIGNED NOT NULL,
  `category_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `author_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `isbn` VARCHAR(255) NULL DEFAULT NULL,
  `cover` VARCHAR(255) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `original_price` DECIMAL(10,2) NULL DEFAULT NULL,
  `stock` INT UNSIGNED NOT NULL,
  `publication_year` YEAR NULL DEFAULT NULL,
  `language` VARCHAR(255) NOT NULL DEFAULT 'en',
  `page_count` INT UNSIGNED NULL DEFAULT NULL,
  `pdf_path` VARCHAR(255) NULL DEFAULT NULL,
  `rating` DOUBLE NOT NULL DEFAULT '0',
  `views` INT UNSIGNED NOT NULL DEFAULT '0',
  `downloads` INT UNSIGNED NOT NULL DEFAULT '0',
  `type` ENUM('physical', 'digital') NOT NULL DEFAULT 'physical',
  `status` ENUM('active', 'inactive', 'sold', 'rejected') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `books_isbn_unique` (`isbn` ASC) VISIBLE,
  INDEX `books_seller_id_foreign` (`seller_id` ASC) VISIBLE,
  INDEX `books_category_id_foreign` (`category_id` ASC) VISIBLE,
  INDEX `books_author_id_foreign` (`author_id` ASC) VISIBLE,
  CONSTRAINT `books_author_id_foreign`
    FOREIGN KEY (`author_id`)
    REFERENCES `book_haven`.`authors` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `books_category_id_foreign`
    FOREIGN KEY (`category_id`)
    REFERENCES `book_haven`.`categories` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `books_seller_id_foreign`
    FOREIGN KEY (`seller_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 42
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`wishlists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`wishlists` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `wishlists_user_id_foreign` (`user_id` ASC) VISIBLE,
  CONSTRAINT `wishlists_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`book_wishlists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`book_wishlists` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `wishlist_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `book_wishlists_wishlist_id_book_id_unique` (`wishlist_id` ASC, `book_id` ASC) VISIBLE,
  INDEX `book_wishlists_book_id_foreign` (`book_id` ASC) VISIBLE,
  CONSTRAINT `book_wishlists_book_id_foreign`
    FOREIGN KEY (`book_id`)
    REFERENCES `book_haven`.`books` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `book_wishlists_wishlist_id_foreign`
    FOREIGN KEY (`wishlist_id`)
    REFERENCES `book_haven`.`wishlists` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`carts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`carts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `carts_user_id_foreign` (`user_id` ASC) VISIBLE,
  CONSTRAINT `carts_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`cart_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`cart_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL DEFAULT '0',
  `price` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cart_items_cart_id_book_id_unique` (`cart_id` ASC, `book_id` ASC) VISIBLE,
  INDEX `cart_items_book_id_foreign` (`book_id` ASC) VISIBLE,
  CONSTRAINT `cart_items_book_id_foreign`
    FOREIGN KEY (`book_id`)
    REFERENCES `book_haven`.`books` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `cart_items_cart_id_foreign`
    FOREIGN KEY (`cart_id`)
    REFERENCES `book_haven`.`carts` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`coupons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`coupons` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(255) NOT NULL,
  `type` ENUM('fixed', 'percent') NOT NULL,
  `value` DECIMAL(12,2) NOT NULL,
  `min_order_amount` DECIMAL(12,2) NOT NULL DEFAULT '0.00',
  `starts_at` DATETIME NULL DEFAULT NULL,
  `expires_at` DATETIME NULL DEFAULT NULL,
  `use_limit` INT NULL DEFAULT NULL,
  `used_count` INT NOT NULL DEFAULT '0',
  `is_active` TINYINT(1) NOT NULL DEFAULT '1',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `coupons_code_unique` (`code` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`orders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'paid', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
  `shipping_address` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `coupon_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `discount_amount` DECIMAL(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  INDEX `orders_user_id_foreign` (`user_id` ASC) VISIBLE,
  INDEX `orders_coupon_id_foreign` (`coupon_id` ASC) VISIBLE,
  CONSTRAINT `orders_coupon_id_foreign`
    FOREIGN KEY (`coupon_id`)
    REFERENCES `book_haven`.`coupons` (`id`)
    ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`order_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`order_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `seller_id` BIGINT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'shipped', 'delivered') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `order_items_order_id_foreign` (`order_id` ASC) VISIBLE,
  INDEX `order_items_book_id_foreign` (`book_id` ASC) VISIBLE,
  INDEX `order_items_seller_id_foreign` (`seller_id` ASC) VISIBLE,
  CONSTRAINT `order_items_book_id_foreign`
    FOREIGN KEY (`book_id`)
    REFERENCES `book_haven`.`books` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign`
    FOREIGN KEY (`order_id`)
    REFERENCES `book_haven`.`orders` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `order_items_seller_id_foreign`
    FOREIGN KEY (`seller_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 34
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`payments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(255) NOT NULL,
  `transaction_id` VARCHAR(255) NULL DEFAULT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `payments_order_id_foreign` (`order_id` ASC) VISIBLE,
  CONSTRAINT `payments_order_id_foreign`
    FOREIGN KEY (`order_id`)
    REFERENCES `book_haven`.`orders` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`reviews`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`reviews` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL,
  `comment` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `reviews_user_id_book_id_unique` (`user_id` ASC, `book_id` ASC) VISIBLE,
  INDEX `reviews_book_id_foreign` (`book_id` ASC) VISIBLE,
  CONSTRAINT `reviews_book_id_foreign`
    FOREIGN KEY (`book_id`)
    REFERENCES `book_haven`.`books` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 104
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `book_haven`.`seller_profiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `book_haven`.`seller_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `store_name` VARCHAR(255) NOT NULL,
  `store_description` TEXT NULL DEFAULT NULL,
  `rating` VARCHAR(255) NOT NULL DEFAULT '0',
  `is_approved` TINYINT(1) NOT NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `seller_profiles_user_id_foreign` (`user_id` ASC) VISIBLE,
  CONSTRAINT `seller_profiles_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `book_haven`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
