-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: e-ticaret-crud
-- ------------------------------------------------------
-- Server version	8.4.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brand_models`
--

DROP TABLE IF EXISTS `brand_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand_models` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NOT NULL,
  `updated_at` timestamp(6) NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY `fk_brand_uuid` (`brand_uuid`),
  CONSTRAINT `fk_brand_uuid` FOREIGN KEY (`brand_uuid`) REFERENCES `brands` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NOT NULL,
  `updated_at` timestamp(6) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `category_name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `idx_categories_category_name` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `comment_text` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `user_uuid` (`user_uuid`),
  KEY `product_uuid` (`product_uuid`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `image` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `image_name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  KEY `product_uuid` (`product_uuid`),
  KEY `idx_location` (`location`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `order_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `uuit_UNIQUE` (`uuid`),
  KEY `fk_order_items_product_uuid` (`product_uuid`),
  KEY `fk_order_items_order_uuid` (`order_uuid`),
  CONSTRAINT `fk_order_items_order_uuid` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_product_uuid` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status` (
  `status` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`status`),
  UNIQUE KEY `status_UNIQUE` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_uuid` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipment_uuid` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` int NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  KEY `fk_order_user_uuid` (`user_uuid`),
  KEY `fk_order_payment_uuid` (`payment_uuid`),
  KEY `fk_order_status` (`status`),
  KEY `fk_order_shipment_uuid` (`shipment_uuid`),
  CONSTRAINT `fk_order_payment_uuid` FOREIGN KEY (`payment_uuid`) REFERENCES `payments` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_shipment_uuid` FOREIGN KEY (`shipment_uuid`) REFERENCES `shipments` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_status` FOREIGN KEY (`status`) REFERENCES `order_status` (`status`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_user_uuid` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `method` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`method`),
  UNIQUE KEY `method_UNIQUE` (`method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` int NOT NULL,
  `method` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(6) NOT NULL,
  `updated_at` timestamp(6) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  KEY `fk_payment_user_uuid` (`user_uuid`),
  KEY `method_INDEX` (`method`),
  CONSTRAINT `fk_payment_user_uuid` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `category_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `fk_category_uuid` (`category_uuid`),
  KEY `fk_product_uuid` (`product_uuid`),
  CONSTRAINT `fk_category_uuid` FOREIGN KEY (`category_uuid`) REFERENCES `categories` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_uuid` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_search`
--

DROP TABLE IF EXISTS `product_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_search` (
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`product_uuid`),
  FULLTEXT KEY `full_text_idx` (`brand`,`model`,`header`,`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_subscriber`
--

DROP TABLE IF EXISTS `product_subscriber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_subscriber` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `fk_user_uuid` (`user_uuid`),
  KEY `fk_product_uuid` (`product_uuid`) USING BTREE,
  CONSTRAINT `fk_user_uuid` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_uuid` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_uuid` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `model_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `prev_price` int DEFAULT NULL,
  `rate` int DEFAULT NULL,
  `stockquantity` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `fk_model_uuid` (`model_uuid`),
  KEY `fk_brand_uuid2` (`brand_uuid`),
  CONSTRAINT `fk_brand_uuid2` FOREIGN KEY (`brand_uuid`) REFERENCES `brands` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_model_uuid` FOREIGN KEY (`model_uuid`) REFERENCES `brand_models` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rates` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `rate_num` int NOT NULL,
  `product_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  KEY `user_uuid` (`user_uuid`),
  KEY `product_uuid` (`product_uuid`),
  CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rates_ibfk_2` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipment_types`
--

DROP TABLE IF EXISTS `shipment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipment_types` (
  `type` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipments` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_title` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_owner_name` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_owner_surname` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `full_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address_country` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_province` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_district` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `address_zipcode` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  KEY `fk_shipment_type` (`type`),
  KEY `status_INDEX` (`status`),
  CONSTRAINT `fk_shipment_type` FOREIGN KEY (`type`) REFERENCES `shipment_types` (`type`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `uuid` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `email_activation_code` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `is_user_activated` tinyint(1) NOT NULL,
  `user_role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `forgetten_password_activation_code` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `unique_users_email` (`email`),
  KEY `index_users_email_activation_code` (`email_activation_code`),
  KEY `index_users_forgetten_password_activation_code` (`forgetten_password_activation_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-31 15:14:24
