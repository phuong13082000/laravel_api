-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2025 at 02:47 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_ecom_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_line` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pincode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `country` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mobile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Dashboard', 'fa-bar-chart', '/', NULL, NULL, NULL),
(2, 0, 9, 'Admin', 'fa-tasks', '', NULL, NULL, '2025-06-08 10:00:37'),
(3, 2, 10, 'Users', 'fa-users', 'auth/users', NULL, NULL, '2025-06-08 10:00:37'),
(4, 2, 11, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, '2025-06-08 10:00:37'),
(5, 2, 12, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, '2025-06-08 10:00:37'),
(6, 2, 13, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, '2025-06-08 10:00:37'),
(7, 2, 14, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, '2025-06-08 10:00:37'),
(8, 13, 4, 'Category', 'fa-bars', 'data/category', '*', '2025-05-17 11:00:57', '2025-06-08 09:59:42'),
(9, 13, 6, 'Product', 'fa-bars', 'data/product', '*', '2025-05-20 08:56:59', '2025-06-08 10:00:37'),
(10, 0, 7, 'User', 'fa-bars', 'user', '*', '2025-05-20 09:51:04', '2025-06-08 10:00:37'),
(11, 0, 8, 'Order', 'fa-bars', 'order', '*', '2025-05-24 09:51:15', '2025-06-08 10:00:37'),
(12, 13, 3, 'Brand', 'fa-bars', 'data/brand', '*', '2025-06-06 08:36:30', '2025-06-08 09:59:32'),
(13, 0, 2, 'Data', 'fa-bars', 'data', '*', '2025-06-08 09:58:49', '2025-06-08 09:59:12'),
(14, 13, 5, 'Tag', 'fa-bars', 'data/tag', '*', '2025-06-08 10:00:12', '2025-06-08 10:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `admin_operation_log`
--

DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE IF NOT EXISTS `admin_operation_log` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE IF NOT EXISTS `admin_permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
(1, 'All permission', '*', '', '*', NULL, NULL),
(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2025-05-17 10:56:42', '2025-05-17 10:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_menu`
--

DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE IF NOT EXISTS `admin_role_menu` (
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL),
(1, 8, NULL, NULL),
(1, 9, NULL, NULL),
(1, 10, NULL, NULL),
(1, 11, NULL, NULL),
(1, 12, NULL, NULL),
(1, 13, NULL, NULL),
(1, 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_permissions`
--

DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE IF NOT EXISTS `admin_role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role_users`
--

DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE IF NOT EXISTS `admin_role_users` (
  `role_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$iJP.vmH2Ulczi3zc4ZSdG.okEqgsm/RS0o78wJ34XnJLSMnAQ.MbO', 'Administrator', NULL, 'Q9JNojea6eilfgdXkaBvpH4lGB7omI1CIQJqlGeOzMRRGLxACJy8GBvanCIP', '2025-05-17 10:56:42', '2025-05-17 10:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_permissions`
--

DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE IF NOT EXISTS `admin_user_permissions` (
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `slug`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Acne', 'acne', NULL, NULL, '2025-06-06 08:41:42', '2025-06-06 08:41:42'),
(2, 'Grune Erde', 'grune-erde', NULL, NULL, '2025-06-06 08:42:14', '2025-06-06 08:42:14'),
(3, 'Albiro', 'albiro', NULL, NULL, '2025-06-06 08:42:20', '2025-06-06 08:42:20'),
(4, 'Ronhill', 'ronhill', NULL, NULL, '2025-06-06 08:42:25', '2025-06-06 08:42:25'),
(5, 'Oddmolly', 'oddmolly', NULL, NULL, '2025-06-06 08:42:30', '2025-06-06 08:42:30'),
(6, 'Boudestijn', 'boudestijn', NULL, NULL, '2025-06-06 08:42:35', '2025-06-06 08:42:35'),
(7, 'Rosch creative culture', 'rosch-creative-culture', NULL, NULL, '2025-06-06 08:42:42', '2025-06-06 08:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `icon`, `color`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(28, 'Sportswear', 'sportswear', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:07:57', '2025-05-24 11:08:31'),
(29, 'Mens', 'mens', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:08:53', '2025-05-24 11:08:53'),
(30, 'Womens', 'womens', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:09:49', '2025-05-24 11:09:49'),
(31, 'Kids', 'kids', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:09:58', '2025-05-24 11:09:58'),
(32, 'Fashion', 'fashion', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:07', '2025-05-24 11:10:07'),
(33, 'Households', 'households', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:15', '2025-05-24 11:10:15'),
(34, 'Interiors', 'interiors', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:20', '2025-05-24 11:10:20'),
(35, 'Clothing', 'clothing', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:26', '2025-05-24 11:10:26'),
(36, 'Bags', 'bags', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:32', '2025-05-24 11:10:32'),
(37, 'Shoes', 'shoes', NULL, NULL, NULL, NULL, NULL, '2025-05-24 11:10:38', '2025-05-24 11:10:38'),
(38, 'Nike', 'nike', NULL, NULL, NULL, NULL, 28, '2025-05-24 11:10:59', '2025-05-24 11:10:59'),
(39, 'Under Armour', 'under-armour', NULL, NULL, NULL, NULL, 28, '2025-05-24 11:11:13', '2025-05-24 11:11:13'),
(40, 'Adidas', 'adidas', NULL, NULL, NULL, NULL, 28, '2025-05-24 11:11:25', '2025-05-24 11:11:25'),
(41, 'Puma', 'puma', NULL, NULL, NULL, NULL, 28, '2025-05-24 11:11:32', '2025-05-24 11:11:32'),
(42, 'ASICS', 'asics', NULL, NULL, NULL, NULL, 28, '2025-05-24 11:11:40', '2025-05-24 11:11:40'),
(43, 'Fendi', 'fendi', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:13:48', '2025-05-24 11:13:48'),
(44, 'Guess', 'guess', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:13:56', '2025-05-24 11:13:56'),
(45, 'Valentino', 'valentino', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:15:37', '2025-05-24 11:15:37'),
(46, 'Dior', 'dior', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:15:44', '2025-05-24 11:15:44'),
(47, 'Versace', 'versace', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:15:53', '2025-05-24 11:15:53'),
(48, 'Armani', 'armani', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:16:00', '2025-05-24 11:16:00'),
(49, 'Prada', 'prada', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:16:10', '2025-05-24 11:16:10'),
(50, 'Dolce and Gabbana', 'dolce-and-gabbana', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:16:19', '2025-05-24 11:16:19'),
(51, 'Chanel', 'chanel', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:16:28', '2025-05-24 11:16:28'),
(52, 'Gucci', 'gucci', NULL, NULL, NULL, NULL, 29, '2025-05-24 11:16:35', '2025-05-24 11:16:35'),
(53, 'Fendi', 'fendi', NULL, NULL, NULL, NULL, 30, '2025-05-24 11:16:49', '2025-05-24 11:16:49'),
(54, 'Guess', 'guess', NULL, NULL, NULL, NULL, 30, '2025-05-24 11:16:57', '2025-05-24 11:16:57'),
(55, 'Valentino', 'valentino', NULL, NULL, NULL, NULL, 30, '2025-05-24 11:17:05', '2025-05-24 11:17:05'),
(56, 'Dior', 'dior', NULL, NULL, NULL, NULL, 30, '2025-05-24 11:17:19', '2025-05-24 11:17:19'),
(57, 'Versace', 'versace', NULL, NULL, NULL, NULL, 30, '2025-05-24 11:17:26', '2025-05-24 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_06_160639_create_personal_access_tokens_table', 2),
(5, '2016_01_04_173148_create_admin_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_id` int UNSIGNED NOT NULL,
  `paymentMethod` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subTotalAmt` int NOT NULL DEFAULT '0',
  `totalAmt` int NOT NULL DEFAULT '0',
  `invoiceReceipt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `stripe_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `checkout_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category_id` int UNSIGNED DEFAULT NULL,
  `brand_id` int UNSIGNED DEFAULT NULL,
  `unit` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stock` int DEFAULT NULL,
  `price` int UNSIGNED DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `more_details` json DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `image`, `category_id`, `brand_id`, `unit`, `stock`, `price`, `discount`, `description`, `more_details`, `publish`, `created_at`, `updated_at`) VALUES
(3, 'Easy Polo Black Edition', 'easy-polo-black-edition', 'product/61ef979b0f27ae035a083f5d7c71648e.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:20:27', '2025-05-28 07:20:27'),
(4, 'Easy Polo Black Edition 2', 'easy-polo-black-edition-2', 'product/c43582b6b34745331a87d8432eeec49b.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:21:13', '2025-05-28 07:21:13'),
(5, 'Easy Polo Black Edition 3', 'easy-polo-black-edition-3', 'product/9937fd3204789be211880e7e34cde09f.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:21:43', '2025-05-28 07:21:43'),
(6, 'Easy Polo Black Edition 4', 'easy-polo-black-edition-4', 'product/728a97c4431d774fd9ca1ac893878e78.jpg', NULL, NULL, '1', 10, 56, 0, NULL, '{\"product-new\": \"1\"}', 1, '2025-05-28 07:23:57', '2025-05-28 14:59:35'),
(7, 'Easy Polo Black Edition 5', 'easy-polo-black-edition-5', 'product/97692a09a5c699d1d5cc9e781d23d8e2.jpg', NULL, NULL, '1', 10, 56, 10, NULL, '{\"product-sale\": \"1\"}', 1, '2025-05-28 07:24:21', '2025-05-28 07:27:41'),
(8, 'Easy Polo Black Edition 6', 'easy-polo-black-edition-6', 'product/a3242d76f6f3089db2b8e10f65c3c5d7.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:24:47', '2025-05-28 07:24:47'),
(9, 'Easy Polo Black Edition 7', 'easy-polo-black-edition-7', 'product/5f68a59e79b6a36f0567fa56a407c243.jpg', 28, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:30:26', '2025-05-28 07:30:41'),
(10, 'Easy Polo Black Edition 8', 'easy-polo-black-edition-8', 'product/dec1061c242f506b70be66c55efdd0d8.jpg', 28, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:31:05', '2025-05-28 07:31:13'),
(11, 'Easy Polo Black Edition 9', 'easy-polo-black-edition-9', 'product/7d9355c3bfcbba431fb650d759d5ad1f.jpg', 28, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:31:36', '2025-05-28 07:31:36'),
(12, 'Easy Polo Black Edition 10', 'easy-polo-black-edition-10', 'product/1022248802c0dcec07f92a941ab75938.jpg', 28, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 07:31:58', '2025-05-28 07:31:58'),
(13, 'Easy Polo Black Edition 11', 'easy-polo-black-edition-10', 'product/fe9f1ec0c64fe38e6699333971e5bc01.jpg', 29, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:01:51', '2025-05-28 08:02:14'),
(14, 'Easy Polo Black Edition 12', 'easy-polo-black-edition-12', 'product/338662a3f0afabbe10feefd9acaa8175.jpg', 29, NULL, '1', 10, 56, NULL, NULL, NULL, 1, '2025-05-28 08:02:42', '2025-05-28 08:02:42'),
(15, 'Easy Polo Black Edition 13', 'easy-polo-black-edition-13', 'product/a9360966764fdf2e8995f32441c433cc.jpg', 29, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:03:08', '2025-05-28 08:03:08'),
(16, 'Easy Polo Black Edition 14', 'easy-polo-black-edition-14', 'product/eda01b2adeecf6a3afdc7cee94651b99.jpg', 29, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:03:42', '2025-05-28 08:03:52'),
(17, 'Easy Polo Black Edition 15', 'easy-polo-black-edition-15', 'product/6974c37efec0690a9087344fe7c1b1db.jpg', 30, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:06:04', '2025-05-28 08:06:04'),
(18, 'Easy Polo Black Edition 16', 'easy-polo-black-edition-16', 'product/06b9f24050afc9994dd3f29fde0f57b9.jpg', 30, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:06:25', '2025-05-28 08:06:25'),
(19, 'Easy Polo Black Edition 17', 'easy-polo-black-edition-17', 'product/81c73e0840443c9f3c50239d7734c09c.jpg', 30, NULL, NULL, 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:10:41', '2025-05-28 08:10:41'),
(20, 'Easy Polo Black Edition 18', 'easy-polo-black-edition-18', 'product/75efc2362434a7ce52dba7c4bca0b5a2.jpg', 30, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 08:11:05', '2025-05-28 08:11:05'),
(21, 'Easy Polo Black Edition 19', 'easy-polo-black-edition-19', 'product/399e41653d39e918234ccb6d8cd4705e.jpg', 31, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:10:02', '2025-05-28 09:10:02'),
(22, 'Easy Polo Black Edition 20', 'easy-polo-black-edition-20', 'product/b4648b2f6264cf5b829d93429fb72730.jpg', 31, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:10:28', '2025-05-28 09:10:28'),
(23, 'Easy Polo Black Edition 21', 'easy-polo-black-edition-21', 'product/3b5bb4ada6ba1eff3858abe96d41ce59.jpg', 31, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:10:47', '2025-05-28 09:10:47'),
(24, 'Easy Polo Black Edition 22', 'easy-polo-black-edition-22', 'product/e9c24334ddcacbce0a5ef4d1077ee7a6.jpg', 31, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:11:05', '2025-05-28 09:11:05'),
(25, 'Easy Polo Black Edition 23', 'easy-polo-black-edition-23', 'product/8882edb63abac8f94b57daa274b7eafc.jpg', 32, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:11:28', '2025-05-28 09:11:28'),
(26, 'Easy Polo Black Edition 24', 'easy-polo-black-edition-24', 'product/59bbd18e8211e50b5f52f98598c950ae.jpg', 32, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:11:50', '2025-05-28 09:11:50'),
(27, 'Easy Polo Black Edition 25', 'easy-polo-black-edition-25', 'product/22968bfebe69d56cdeef54abbefe0d0a.jpg', 32, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:12:10', '2025-05-28 09:12:10'),
(28, 'Easy Polo Black Edition 26', 'easy-polo-black-edition-26', 'product/f401a7d6b26367e5f6881d88cf39dd93.jpg', 32, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-28 09:12:34', '2025-05-28 09:12:34'),
(29, 'Easy Polo Black Edition 27', 'easy-polo-black-edition-27', 'product/7b6185f2dc3c3a60a880e8afdb737aa9.jpg', 33, NULL, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"1\"}', 1, '2025-05-28 09:19:02', '2025-05-28 09:19:02'),
(30, 'Easy Polo Black Edition 28', 'easy-polo-black-edition-28', 'product/f572ed038593d4a5ca52fd1357e26522.jpg', 33, NULL, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"1\"}', 1, '2025-05-28 09:19:26', '2025-05-28 09:19:26'),
(31, 'Easy Polo Black Edition 29', 'easy-polo-black-edition-29', 'product/b8432a3759a4a95836d6d00118d987f8.jpg', 33, NULL, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"1\"}', 1, '2025-05-28 09:19:45', '2025-05-28 09:19:45'),
(32, 'Easy Polo Black Edition 30', 'easy-polo-black-edition-30', 'product/735949effd5e94864024c0fc46604108.jpg', 33, NULL, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"2\"}', 1, '2025-05-28 09:20:14', '2025-05-28 09:20:14'),
(33, 'Easy Polo Black Edition 31', 'easy-polo-black-edition-31', 'product/1af5432351cb3dc11eb96e60b71703df.jpg', 33, NULL, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"2\"}', 1, '2025-05-28 09:20:37', '2025-05-28 09:20:37'),
(34, 'Easy Polo Black Edition 32', 'easy-polo-black-edition-32', 'product/efe0a108c4521bb918003d2f0b2bcb48.jpg', 33, 1, '1', 10, 56, 0, NULL, '{\"product-recommend\": \"2\"}', 1, '2025-05-28 09:20:55', '2025-06-06 09:54:47'),
(35, 'Easy Polo Black Edition 33', 'easy-polo-black-edition-33', 'product/3e3c0420df6d74326d650a7eb4215a50.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 05:59:07', '2025-05-29 05:59:07'),
(36, 'Easy Polo Black Edition 34', 'easy-polo-black-edition-34', 'product/8a45c887c876a1c46346959655f55ecc.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 05:59:25', '2025-05-29 05:59:25'),
(37, 'Easy Polo Black Edition 35', 'easy-polo-black-edition-35', 'product/7dc4d3e4c85790b3dd9c0d6d84ecde1d.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 05:59:45', '2025-05-29 05:59:45'),
(38, 'Easy Polo Black Edition 36', 'easy-polo-black-edition-36', 'product/e04b2cbad9ca886a3f4c528efa97af31.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 06:00:11', '2025-05-29 06:00:11'),
(39, 'Easy Polo Black Edition 37', 'easy-polo-black-edition-37', 'product/708357d5444e9924df894e775e7bb655.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 06:00:28', '2025-05-29 06:00:28'),
(40, 'Easy Polo Black Edition 38', 'easy-polo-black-edition-38', 'product/542a942fa4d6fe99e9714b0d4ff0daf8.jpg', NULL, NULL, '1', 10, 56, 0, NULL, NULL, 1, '2025-05-29 06:00:44', '2025-05-29 06:00:44'),
(41, 'Anne Klein Sleeveless Color block Scuba', 'anne-klein-sleeveless-color-block-scuba', 'product/895f0a316779f44667f616efeff31eda.jpg', 30, 2, '1', 10, 59, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', NULL, 1, '2025-06-07 07:43:23', '2025-06-07 07:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tag 1', 'tag-1', NULL, '2025-06-08 10:01:32', '2025-06-08 10:01:32'),
(2, 'Tag 2', 'tag-2', NULL, '2025-06-08 10:01:38', '2025-06-08 10:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `tag_products`
--

DROP TABLE IF EXISTS `tag_products`;
CREATE TABLE IF NOT EXISTS `tag_products` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag_products`
--

INSERT INTO `tag_products` (`id`, `tag_id`, `product_id`) VALUES
(1, 1, 41),
(2, 2, 41);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
