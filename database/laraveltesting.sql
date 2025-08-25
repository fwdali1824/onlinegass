-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2025 at 09:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laraveltesting`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:13:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"view.admin.dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"view.customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"create.customers\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"create.employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"edit.employee\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"manage.employees\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:23:\"manage.product.category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"manage.product.list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"manage.roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:12:\"manage.chats\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:11:\"users.chats\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:11;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:9:\"users.pos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"users.pos.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"Customers\";s:1:\"c\";s:3:\"web\";}}}', 1751302317);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'hi', '2025-06-29 04:39:12', '2025-06-29 04:39:12'),
(2, 1, 8, 'hello', '2025-06-29 04:42:17', '2025-06-29 04:42:17'),
(3, 1, 9, 'hi', '2025-06-29 04:53:14', '2025-06-29 04:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `credits`
--

CREATE TABLE `credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total_balance` decimal(10,2) NOT NULL,
  `type` enum('add','deduct') NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_17_095021_create_product_categories_table', 1),
(5, '2025_06_17_095039_create_products_table', 1),
(6, '2025_06_17_095619_create_orders_table', 1),
(7, '2025_06_17_095947_create_orders_issues_table', 1),
(8, '2025_06_17_100039_create_payments_table', 1),
(9, '2025_06_17_100211_create_credits_table', 1),
(10, '2025_06_17_100313_create_referals_table', 1),
(11, '2025_06_28_190826_create_wallet_users_table', 2),
(12, '2025_06_28_190835_create_wallet_user_transactions_table', 2),
(13, '2025_06_29_055519_create_permission_tables', 3),
(14, '2025_06_29_092952_create_chats_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `delivery_person_id` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total_amount` text NOT NULL,
  `payment_status` enum('unpaid','paid','partial') NOT NULL DEFAULT 'unpaid',
  `payment_method` enum('cod','online') NOT NULL DEFAULT 'cod',
  `status` enum('pending','confirmed','out_for_delivery','delivered','cancelled','returned') NOT NULL DEFAULT 'pending',
  `delivery_address` varchar(255) NOT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `orderid` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `delivery_person_id`, `quantity`, `price`, `total_amount`, `payment_status`, `payment_method`, `status`, `delivery_address`, `delivery_date`, `notes`, `orderid`, `product_id`, `created_at`, `updated_at`) VALUES
(12, '1', NULL, '1', '9,300', '9,300.00', 'unpaid', 'cod', 'pending', '1232', '2025-07-01', '123', 'ORD-20250628190504-415', 4, '2025-06-28 14:05:04', '2025-06-28 14:05:04'),
(13, '9', NULL, '1', '9,300', '9,300.00', 'unpaid', 'online', 'pending', '221kjsjkldas', '2023-02-22', 'kjljkldkjaskda', 'ORD-20250629095241-750', 4, '2025-06-29 04:52:41', '2025-06-29 04:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders_issues`
--

CREATE TABLE `orders_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `type` enum('wrong_delivery','damaged_cylinder','missing_item','other') NOT NULL,
  `description` text DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `resolved_at` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `qty` decimal(8,2) NOT NULL,
  `method` enum('cod','online') NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_at` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view.admin.dashboard', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(2, 'view.customers', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(3, 'create.customers', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(4, 'create.employee', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(5, 'edit.employee', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(6, 'manage.employees', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(7, 'manage.product.category', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(8, 'manage.product.list', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(9, 'manage.roles', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(11, 'manage.chats', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(12, 'users.chats', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(13, 'users.pos', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57'),
(14, 'users.pos.invoice', 'web', '2025-06-29 06:14:57', '2025-06-29 06:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` text DEFAULT NULL,
  `product_category` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `is_cylinder` tinyint(1) NOT NULL DEFAULT 1,
  `cylinder_type` enum('domestic','commercial','industrial') NOT NULL DEFAULT 'domestic',
  `cylinder_material` varchar(255) DEFAULT NULL,
  `cylinder_capacity` varchar(255) DEFAULT NULL,
  `cylinder_pressure` varchar(255) DEFAULT NULL,
  `status` enum('active','discontinued') NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `product_category`, `weight`, `price`, `stock`, `is_cylinder`, `cylinder_type`, `cylinder_material`, `cylinder_capacity`, `cylinder_pressure`, `status`, `description`, `created_at`, `updated_at`) VALUES
(4, 'Steel Cylinder – 6 kg', 'http://127.0.0.1:8000/storage/products/P7MLAod1CwM5ZYachvnsnAEbC7rL1sxnQo6ZLMRI.png', '3', '6 kg', '9300', 100, 1, 'domestic', NULL, NULL, NULL, 'active', '*The price is inclusive of 6 kg LPG\n', '2025-06-21 12:43:02', '2025-06-26 13:23:19'),
(6, 'Composite Fiberglass Cylinder – 10 kg', 'http://127.0.0.1:8000/storage/products/P7MLAod1CwM5ZYachvnsnAEbC7rL1sxnQo6ZLMRI.png', '3', '10 kg', '15000', 100, 1, 'domestic', NULL, NULL, NULL, 'active', '*The price is inclusive of 10 kg LPG', '2025-06-21 12:43:02', '2025-06-26 13:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Gas Cylinder Refilling', '2025-06-21 12:37:05', '2025-06-21 12:37:05'),
(4, 'Cylinder + Refilling', '2025-06-21 12:37:51', '2025-06-21 12:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `referals`
--

CREATE TABLE `referals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` varchar(255) NOT NULL,
  `referred_id` varchar(255) NOT NULL,
  `status` enum('pending','completed','invalid') NOT NULL DEFAULT 'pending',
  `referrer_bonus` decimal(8,2) NOT NULL DEFAULT 0.00,
  `referred_bonus` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-06-29 05:56:28', '2025-06-29 05:56:28'),
(2, 'Sales', 'web', '2025-06-29 05:56:28', '2025-06-29 05:56:28'),
(3, 'Delivery', 'web', '2025-06-29 05:56:28', '2025-06-29 05:56:28'),
(4, 'Customers', 'web', '2025-06-29 05:56:28', '2025-06-29 05:56:28'),
(5, 'POS', 'web', '2025-06-29 03:11:28', '2025-06-29 03:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(11, 1),
(12, 1),
(12, 4),
(13, 1),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('t2J6jwtrueSsyfSi4Fqn6aRTUEv6SR93fK8GMVBJ', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoicm1LU0dLQ2RVVW9Ja1BhcktMYTM5NXROUEgwVTY5SlBqQkRHdkRheiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MTIxMzYyMzt9czoxNjoicG9zX2ludm9pY2VfZGF0YSI7YTozOntzOjQ6ImNhcnQiO2E6MTp7aTo2O2E6Njp7czoyOiJpZCI7aTo2O3M6NDoibmFtZSI7czozOToiQ29tcG9zaXRlIEZpYmVyZ2xhc3MgQ3lsaW5kZXIg4oCTIDEwIGtnIjtzOjU6ImltYWdlIjtzOjgzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3RvcmFnZS9wcm9kdWN0cy9QN01MQW9kMUN3TTVaWWFjaHZuc25BRWJDN3JMMXN4blFvNlpMTVJJLnBuZyI7czoxMToiZGVzY3JpcHRpb24iO3M6MzY6IipUaGUgcHJpY2UgaXMgaW5jbHVzaXZlIG9mIDEwIGtnIExQRyI7czo1OiJwcmljZSI7czo1OiIxNTAwMCI7czo4OiJxdWFudGl0eSI7aToxO319czo1OiJ0b3RhbCI7aToxNTAwMDtzOjQ6InRpbWUiO3M6ODoiMTE6NDggUE0iO319', 1751225180);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `connection_type` enum('domestic','commercial') NOT NULL DEFAULT 'domestic',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `profile`, `email`, `email_verified_at`, `password`, `phone_number`, `cnic`, `address_line_1`, `address_line_2`, `city`, `province`, `postal_code`, `role`, `connection_type`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, 'admin@email.com', '2025-06-17 05:28:00', '$2y$12$oBq9X00e2MDzZSJI.NNppuHqgrzgn2bRc8QIVmxTEnwyx.wDMZfgi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 'domestic', 1, 'RPBOCtBfHY', '2025-06-17 05:28:00', '2025-06-17 05:28:00'),
(8, 'fawad 2121', 'http://127.0.0.1:8000/storage/profiles/DUptG3IWO6jtKnQSFriIwRrNaxM76nQGRAu2FN3B.png', 'fawad21212@gmil.com', NULL, '$2y$12$5Xqpgr/pnbqApURfLikUeOzCs9jP9Uy/Mv2SoYmUZBge7wy7gwF2u', 'Esse culpa in atque', '120202022', 'Atque officia nulla ', 'Et qui enim rerum vo', 'Eveniet quae nulla ', 'Deserunt qui sit ma', 'Corporis vel ullamco', 'sales', 'domestic', 1, NULL, '2025-06-17 12:29:05', '2025-06-17 13:25:03'),
(9, 'customer', '', 'cus@yopmail.com', NULL, '$2y$12$S70yGS4QWn0o4tjQolYCvehxXybqQ/KjYW65nthsIYXVu3yu6rWsS', '29801289021398', '38938902318', 'lahore', 'islamabad', '2132', '762178', 'uuiu', 'customer', 'domestic', 1, NULL, '2025-06-29 04:51:33', '2025-06-29 04:51:33'),
(10, 'customer1', NULL, 'customer1@email.com', NULL, '$2y$12$XDPwRSg4qWBCc1RHc7eKZu/fTWmPON0ByEzMx1RmCkCTliGZV9SZe', NULL, '2889001983019', '9889809', '089098089', '2223', NULL, '0098080', 'customer', 'domestic', 1, NULL, '2025-06-29 14:19:28', '2025-06-29 14:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` text NOT NULL,
  `acount_number` text DEFAULT NULL,
  `acount_name` text DEFAULT NULL,
  `type` enum('topup','purchase','refund') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `user_id`, `amount`, `transaction_id`, `acount_number`, `acount_name`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 10.00, 'TXN-6860426DCFDB5', NULL, NULL, 'topup', '2025-06-28 14:28:45', '2025-06-28 14:28:45'),
(2, 9, 20000.00, 'TXN-68610CCB03F30', NULL, NULL, 'topup', '2025-06-29 04:52:11', '2025-06-29 04:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_users`
--

CREATE TABLE `wallet_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balance` text NOT NULL,
  `last_transaction` text DEFAULT NULL,
  `user_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_users`
--

INSERT INTO `wallet_users` (`id`, `created_at`, `updated_at`, `balance`, `last_transaction`, `user_id`) VALUES
(1, '2025-06-28 14:27:50', '2025-06-28 14:28:45', '10', '10', '1'),
(2, '2025-06-29 04:52:11', '2025-06-29 04:52:11', '20000', '20000', '9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `credits`
--
ALTER TABLE `credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_issues`
--
ALTER TABLE `orders_issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referals`
--
ALTER TABLE `referals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  ADD UNIQUE KEY `users_cnic_unique` (`cnic`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_users`
--
ALTER TABLE `wallet_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `credits`
--
ALTER TABLE `credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders_issues`
--
ALTER TABLE `orders_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referals`
--
ALTER TABLE `referals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_users`
--
ALTER TABLE `wallet_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
