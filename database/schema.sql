SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `coffee-shop`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `coffee-shop`;

-- =========================
-- admin_users
-- =========================
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_users` VALUES
(2,'abc123@gmail.com','abc123','abc123','2025-12-03 14:20:19'),
(3,'abc1234@gmail.com','abc123','abc1234','2025-12-03 14:20:19'),
(4,'admin@coffeeshop.com','$2y$10$u/ERjvS5U/sZedD4TOf/uOSTKTRyzr/iRUeHsD5hi31lUsVxZ3tge','Admin User','2025-12-03 14:29:01');

-- =========================
-- customers
-- =========================
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customers` VALUES
(1,'abc@gmail.com','$2y$10$O9Qa/LvBFDyvKk87gfgG1ODO/omf3o8OXAJ8shBJzW9Lj.Wf/OKqK','abc','0705623877','2025-12-03 14:16:48','2025-12-03 14:16:48');

-- =========================
-- menu_items
-- =========================
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255),
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_items` VALUES
(1,'Espresso','Strong and bold espresso shot','Coffee',400.00,'img_69319f7f3c251_1764859775.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:34:19'),
(2,'Cappuccino','Espresso with steamed milk and foam','Coffee',550.00,'img_69319f14ea1e0_1764859668.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:33:39'),
(3,'Latte','Espresso with steamed milk','Coffee',700.00,'img_69319f8d9c67c_1764859789.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:35:01'),
(4,'Americano','Espresso diluted with hot water','Coffee',400.00,'img_69319e4e4511c_1764859470.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:33:25'),
(5,'Mocha','Espresso with chocolate and steamed milk','Coffee',600.00,'img_69319fa228095_1764859810.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:35:17'),
(6,'Croissant','Buttery French pastry','Food',650.00,'img_6931a001d406a_1764859905.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:36:34'),
(7,'Sandwich','Fresh sandwich with various fillings','Food',850.00,'img_6931a059bc3c2_1764859993.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:37:07'),
(8,'Salad','Fresh garden salad with dressing','Food',480.00,'img_6931a04d9f433_1764859981.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:36:50'),
(9,'Brownie','Chocolate brownie','Dessert',370.00,'img_69319fbac0f3f_1764859834.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:35:47'),
(10,'Cheesecake','Creamy cheesecake slice','Dessert',600.00,'img_69319fcd046bb_1764859853.jpeg',1,'2025-12-03 13:59:53','2025-12-04 15:36:10'),
(22,'Bambo Biriyani','00','Food',4500.00,NULL,1,'2025-12-05 03:54:31','2025-12-05 03:54:31');

-- =========================
-- orders
-- =========================
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `total_price` decimal(10,2) NOT NULL,
  `delivery_address` text,
  `table_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` VALUES
(1,1,'Takeaway','Pending',6.25,'',0,'2025-12-03 14:26:10','2025-12-03 14:26:10'),
(2,1,'Delivery','Completed',2.75,'no 123, kiriella',0,'2025-12-03 14:26:38','2025-12-03 14:42:37'),
(3,1,'Takeaway','Processing',10.00,'',0,'2025-12-03 14:41:40','2025-12-05 04:21:36'),
(4,1,'Dine-in','Pending',2.75,'',1,'2025-12-03 17:08:19','2025-12-03 17:08:19'),
(5,1,'Delivery','Pending',2.75,'sfsdf sdfs df',0,'2025-12-03 18:03:07','2025-12-03 18:03:07'),
(6,1,'Delivery','Completed',1350.00,'test ,test',0,'2025-12-05 04:17:22','2025-12-05 04:18:38');

-- =========================
-- order_items
-- =========================
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `menu_item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `special_requests` text,
  `item_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` VALUES
(1,1,14,1,'',2.75,'2025-12-03 14:26:10'),
(2,1,2,1,'',3.50,'2025-12-03 14:26:10'),
(3,2,14,1,'',2.75,'2025-12-03 14:26:38'),
(4,3,21,1,'',10.00,'2025-12-03 14:41:40'),
(5,4,4,1,'',2.75,'2025-12-03 17:08:19'),
(6,5,4,1,'',2.75,'2025-12-03 18:03:07'),
(7,6,4,2,'',400.00,'2025-12-05 04:17:22'),
(8,6,2,1,'',550.00,'2025-12-05 04:17:22');

-- =========================
-- reservations
-- =========================
DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `table_id` int NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `number_of_guests` int NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reservations` VALUES
(1,1,7,'2025-12-05','09:15:00',7,'0','2025-12-03 14:46:18','2025-12-03 14:46:18'),
(2,1,2,'2025-12-06','12:40:00',2,'0','2025-12-03 17:09:05','2025-12-03 17:09:05'),
(3,1,8,'2025-12-19','13:35:00',1,'0','2025-12-03 18:04:59','2025-12-03 18:04:59'),
(4,1,7,'2025-12-12','10:15:00',3,'0','2025-12-04 15:46:37','2025-12-04 15:46:37');

-- =========================
-- tables
-- =========================
DROP TABLE IF EXISTS `tables`;
CREATE TABLE `tables` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_number` int NOT NULL,
  `capacity` int NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_number` (`table_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tables` VALUES
(1,1,2,1,'2025-12-03 13:59:52'),
(2,2,2,1,'2025-12-03 13:59:52'),
(3,3,4,1,'2025-12-03 13:59:52'),
(4,4,4,1,'2025-12-03 13:59:52'),
(5,5,6,1,'2025-12-03 13:59:52'),
(6,6,6,1,'2025-12-03 13:59:52'),
(7,7,8,1,'2025-12-03 13:59:52'),
(8,8,8,1,'2025-12-03 13:59:52');

COMMIT;
