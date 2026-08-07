-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 06, 2026 at 05:08 AM
-- Server version: 10.11.18-MariaDB-cll-lve
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `its24k_waima`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usertype_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reject_message` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `verify` varchar(10) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `usertype_id`, `name`, `email`, `username`, `password`, `region`, `country`, `country_id`, `status_id`, `reject_message`, `created_by`, `language_id`, `created_at`, `updated_at`, `otp`, `otp_expires_at`, `verify`, `device_id`, `image`) VALUES
(100, 1, 'agent 1', 'agent@gmail.com', NULL, '$2y$12$ss6DW8JjbAC6x62CQ2L.quMbKc.hGylS4K9qzcyMxebbqJ0SbyowW', NULL, NULL, 1, 2, NULL, NULL, 1, '2025-12-15 15:52:25', '2026-05-20 21:15:04', '234408', '2025-12-15 09:52:02', 'yes', 'fa_jM8H-SoiSnzBFsuNmED:APA91bEgTYYpH3i8O-HGyxgjd61caRmtwfB4zuewbtZoxQYmI7lfmA7tQ0Ps99cSjXDDaFi5w4LzMALZB0UMtG-GOAQhX_MF6aUtD6ChX9MJs-f_6-5tyKM', '1765791722_10043.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `agent_translations`
--

CREATE TABLE `agent_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agriculture_forms`
--

CREATE TABLE `agriculture_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seed_name` varchar(255) DEFAULT NULL,
  `variety_name` varchar(255) DEFAULT NULL,
  `enumerator_name` varchar(255) DEFAULT NULL,
  `enumerator_phone` varchar(20) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `altitude` varchar(50) DEFAULT NULL,
  `accuracy` varchar(50) DEFAULT NULL,
  `seed_id` bigint(20) UNSIGNED DEFAULT NULL,
  `precocity` varchar(255) DEFAULT NULL,
  `fruit_color` varchar(255) DEFAULT NULL,
  `fruit_shape` varchar(255) DEFAULT NULL,
  `plant_height` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `variety_type` varchar(255) DEFAULT NULL,
  `seed_category` varchar(255) DEFAULT NULL,
  `other_recommendations` text DEFAULT NULL,
  `other_recommendations_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agriculture_forms`
--

INSERT INTO `agriculture_forms` (`id`, `seed_name`, `variety_name`, `enumerator_name`, `enumerator_phone`, `company_name`, `manager_name`, `position`, `city`, `region`, `address`, `phone`, `mobile`, `email`, `latitude`, `longitude`, `altitude`, `accuracy`, `seed_id`, `precocity`, `fruit_color`, `fruit_shape`, `plant_height`, `registration_number`, `variety_type`, `seed_category`, `other_recommendations`, `other_recommendations_photo`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'lokesh', 'csdkcnksdc', 'fivo', 'Lokesh PAndey', 'php', 'Noida', 'Uttar Pradesh', 'Vionod electronic', '08527424594', '08527424594', 'lokeshpandey9456@gmail.com', '25', '25', '15', '15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 12:55:35', '2025-10-09 12:55:35'),
(2, NULL, NULL, 'tmia', '08527424594', 'fivo', 'Lokesh', 'php', 'Noida', 'Andaman and Nicobar Islands', 'Vionod electronic', '08527424594', '08527424594', 'lokeshpandey9456@gmail.com', '25', '25', '15', '15', 8, 'Noida', 'dtryfgk', 'hgjkl', 'vhgjkl', 'hjk', 'jhkl', NULL, 'dhjbvdfjv', '1759992675_unnamed.png', '2025-10-09 13:51:15', '2025-10-09 13:51:15'),
(3, NULL, NULL, 'ravi', '85274245942', 'test', 'lokesh', 'shcjs', '+556', '655', '65465', '65465', '65465', 'lokeshpandey9456@gmail.com', '565', '561654', '5645', '654', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 16:20:02', '2025-10-09 16:20:02'),
(4, NULL, NULL, 'av', '8527424594', 'test', 'php', 'fivo', 'noid', 'contry', 'noid', '08527424594', '08527424594', 'lokeshpandey9456@gmail.com', '25', '25', '15', '15', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-10 14:33:49', '2025-10-10 14:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `allcomplementary`
--

CREATE TABLE `allcomplementary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `table_record_id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `allcomplementary`
--

INSERT INTO `allcomplementary` (`id`, `product_id`, `table_record_id`, `table_name`, `title`, `country_id`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 2, 123, 'animal_feeds', NULL, NULL, 'complementryfile/XBqiVB66n2clQaW3_1764318400.pdf', '2025-11-28 15:26:40', '2025-11-28 15:26:40'),
(2, 2, 123, 'animal_feeds', NULL, NULL, 'complementryfile/AJGqyd4yj5DxUtlR_1764653475.pdf', '2025-12-02 12:31:15', '2025-12-02 12:31:15'),
(3, 1, 52, 'veterinary_products', 'dscjbh', NULL, 'complementryfile/04fp35Me7tbr5oZu_1764849779.pdf', '2025-12-04 19:02:59', '2025-12-04 19:02:59'),
(4, 2, 124, 'animal_feeds', 'hjv', NULL, 'complementryfile/mHWVj4FFS6R5HW6f_1764850284.pdf', '2025-12-04 19:11:24', '2025-12-04 19:11:24'),
(5, 1, 75, 'veterinary_products', 'test', NULL, 'complementryfile/3rj9VOq4XEPuXB7u_1766383591.pdf', '2025-12-22 13:06:31', '2025-12-22 13:06:31'),
(6, 1, 100055, 'veterinary_products', 'a', NULL, 'complementryfile/9MmydljodITjlQbH_1770064159.php', '2026-02-03 03:29:19', '2026-02-03 03:29:19'),
(7, 8, 100066, 'seed_forms', '12', NULL, 'complementryfile/aNVN15mzM1C8ocaj_1770064176.ShTMl', '2026-02-03 03:29:36', '2026-02-03 03:29:36'),
(8, 8, 100066, 'seed_forms', '12', NULL, 'complementryfile/CnD5Sz4NLsNmANWh_1770064176.ShTMl', '2026-02-03 03:29:36', '2026-02-03 03:29:36'),
(9, 8, 100066, 'seed_forms', '12', NULL, 'complementryfile/ZANKILB6ywmvHCX9_1770064192.PHP', '2026-02-03 03:29:52', '2026-02-03 03:29:52'),
(10, 8, 100066, 'seed_forms', '12', NULL, 'complementryfile/GHbyYfr2vsl1Tp11_1770064208.php', '2026-02-03 03:30:09', '2026-02-03 03:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `allproduct`
--

CREATE TABLE `allproduct` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_type` varchar(100) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `allproduct`
--

INSERT INTO `allproduct` (`id`, `form_type`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'seed_form', 20, '2025-10-22 19:02:12', '2025-10-22 19:02:12'),
(2, 'animal_feed', 40, '2025-10-22 19:02:30', '2025-10-22 19:02:30'),
(3, 'bio_stimulant', 15, '2025-10-22 19:02:44', '2025-10-22 19:02:44'),
(4, 'inorganic_soil_conditioner', 10, '2025-10-22 19:03:21', '2025-10-22 19:03:21'),
(5, 'synthetic_pesticide', 11, '2025-10-22 19:03:32', '2025-10-22 19:03:32'),
(6, 'organic_amendment', 19, '2025-10-22 19:03:41', '2025-10-22 19:03:41'),
(7, 'synthetic_pesticide', 12, '2025-10-22 19:03:49', '2025-10-22 19:03:49'),
(8, 'veterinary_product', 25, '2025-10-22 19:03:58', '2025-10-22 19:03:58'),
(9, 'mineral_fertilizer', 38, '2025-10-22 19:12:45', '2025-10-22 19:12:45'),
(10, 'mineral_fertilizer', 39, '2025-10-22 19:13:22', '2025-10-22 19:13:22'),
(11, 'mineral_fertilizer', 40, '2025-10-22 19:13:53', '2025-10-22 19:13:53'),
(12, 'animal_feed', 41, '2025-10-22 19:15:06', '2025-10-22 19:15:06'),
(13, 'seed_form', 21, '2025-10-23 15:16:14', '2025-10-23 15:16:14'),
(14, 'seed_form', 22, '2025-10-23 15:16:59', '2025-10-23 15:16:59'),
(15, 'organic_amendment', 20, '2025-10-23 15:49:46', '2025-10-23 15:49:46'),
(16, 'organic_amendment', 22, '2025-10-23 17:04:49', '2025-10-23 17:04:49'),
(17, 'organic_amendment', 23, '2025-10-23 17:04:53', '2025-10-23 17:04:53'),
(18, 'organic_amendment', 24, '2025-10-23 17:39:45', '2025-10-23 17:39:45'),
(19, 'organic_amendment', 25, '2025-10-24 02:49:45', '2025-10-24 02:49:45'),
(20, 'organic_amendment', 26, '2025-10-24 02:50:51', '2025-10-24 02:50:51'),
(21, 'organic_amendment', 27, '2025-10-24 02:51:55', '2025-10-24 02:51:55'),
(22, 'organic_amendment', 28, '2025-10-24 02:58:44', '2025-10-24 02:58:44'),
(23, 'organic_amendment', 29, '2025-10-24 03:04:02', '2025-10-24 03:04:02'),
(24, 'organic_amendment', 30, '2025-10-24 03:04:29', '2025-10-24 03:04:29'),
(25, 'organic_amendment', 31, '2025-10-24 04:00:03', '2025-10-24 04:00:03'),
(26, 'organic_amendment', 32, '2025-10-24 04:00:45', '2025-10-24 04:00:45'),
(27, 'organic_amendment', 33, '2025-10-24 04:05:02', '2025-10-24 04:05:02'),
(28, 'organic_amendment', 34, '2025-10-24 04:08:28', '2025-10-24 04:08:28'),
(29, 'organic_amendment', 35, '2025-10-24 04:11:36', '2025-10-24 04:11:36'),
(30, 'organic_amendment', 36, '2025-10-24 04:16:58', '2025-10-24 04:16:58'),
(31, 'organic_amendment', 37, '2025-10-24 04:19:19', '2025-10-24 04:19:19'),
(32, 'organic_amendment', 38, '2025-10-24 04:20:34', '2025-10-24 04:20:34'),
(33, 'organic_amendment', 39, '2025-10-24 04:42:52', '2025-10-24 04:42:52'),
(34, 'organic_amendment', 40, '2025-10-24 05:21:29', '2025-10-24 05:21:29'),
(35, 'organic_amendment', 41, '2025-10-24 05:23:47', '2025-10-24 05:23:47'),
(36, 'organic_amendment', 42, '2025-10-24 05:29:30', '2025-10-24 05:29:30'),
(37, 'organic_amendment', 43, '2025-10-24 05:38:32', '2025-10-24 05:38:32'),
(38, 'animal_feed', 43, '2025-10-24 05:41:17', '2025-10-24 05:41:17'),
(39, 'animal_feed', 44, '2025-10-24 05:41:40', '2025-10-24 05:41:40'),
(40, 'animal_feed', 45, '2025-10-24 05:43:39', '2025-10-24 05:43:39'),
(41, 'seed_form', 27, '2025-10-24 13:26:18', '2025-10-24 13:26:18'),
(42, 'veterinary_product', 28, '2025-10-24 13:26:59', '2025-10-24 13:26:59'),
(43, 'organic_amendment', 44, '2025-10-24 13:53:02', '2025-10-24 13:53:02'),
(44, 'bio_stimulant', 17, '2025-10-24 14:17:10', '2025-10-24 14:17:10'),
(45, 'animal_feed', 46, '2025-10-24 14:42:41', '2025-10-24 14:42:41'),
(46, 'animal_feed', 47, '2025-10-24 14:43:00', '2025-10-24 14:43:00'),
(47, 'animal_feed', 48, '2025-10-24 14:57:51', '2025-10-24 14:57:51'),
(48, 'animal_feed', 49, '2025-10-24 15:00:46', '2025-10-24 15:00:46'),
(49, 'animal_feed', 50, '2025-10-24 15:03:00', '2025-10-24 15:03:00'),
(50, 'animal_feed', 51, '2025-10-24 15:04:53', '2025-10-24 15:04:53'),
(51, 'animal_feed', 52, '2025-10-24 15:05:29', '2025-10-24 15:05:29'),
(52, 'animal_feed', 53, '2025-10-24 15:07:34', '2025-10-24 15:07:34'),
(53, 'animal_feed', 54, '2025-10-24 15:15:52', '2025-10-24 15:15:52'),
(54, 'seed_form', 28, '2025-10-24 15:22:45', '2025-10-24 15:22:45'),
(55, 'animal_feed', 55, '2025-10-24 15:27:27', '2025-10-24 15:27:27'),
(56, 'animal_feed', 56, '2025-10-24 15:32:52', '2025-10-24 15:32:52'),
(57, 'animal_feed', 57, '2025-10-24 15:32:59', '2025-10-24 15:32:59'),
(58, 'animal_feed', 58, '2025-10-24 15:35:53', '2025-10-24 15:35:53'),
(59, 'animal_feed', 59, '2025-10-24 15:37:49', '2025-10-24 15:37:49'),
(60, 'animal_feed', 60, '2025-10-24 15:39:36', '2025-10-24 15:39:36'),
(61, 'animal_feed', 61, '2025-10-24 15:42:15', '2025-10-24 15:42:15'),
(62, 'animal_feed', 62, '2025-10-24 15:42:22', '2025-10-24 15:42:22'),
(63, 'animal_feed', 63, '2025-10-24 15:43:58', '2025-10-24 15:43:58'),
(64, 'animal_feed', 64, '2025-10-24 15:44:13', '2025-10-24 15:44:13'),
(65, 'animal_feed', 65, '2025-10-24 15:45:46', '2025-10-24 15:45:46'),
(66, 'animal_feed', 66, '2025-10-24 15:46:35', '2025-10-24 15:46:35'),
(67, 'lcwc', 67, '2025-10-24 15:46:58', '2025-10-24 15:46:58'),
(68, 'animal_feed', 68, '2025-10-24 15:55:30', '2025-10-24 15:55:30'),
(69, 'animal_feed', 69, '2025-10-24 15:56:02', '2025-10-24 15:56:02'),
(70, 'animal_feed', 70, '2025-10-24 15:56:54', '2025-10-24 15:56:54'),
(71, 'animal_feed', 71, '2025-10-24 15:57:39', '2025-10-24 15:57:39'),
(72, 'animal_feed', 72, '2025-10-24 15:58:22', '2025-10-24 15:58:22'),
(73, 'seed_form', 29, '2025-10-24 16:06:42', '2025-10-24 16:06:42'),
(74, 'seed_form', 30, '2025-10-24 16:07:20', '2025-10-24 16:07:20'),
(75, 'seed_form', 31, '2025-10-24 16:13:17', '2025-10-24 16:13:17'),
(76, 'seed_form', 32, '2025-10-24 16:14:40', '2025-10-24 16:14:40'),
(77, 'seed_form', 33, '2025-10-24 16:20:21', '2025-10-24 16:20:21'),
(78, 'animal_feed', 73, '2025-10-24 16:21:07', '2025-10-24 16:21:07'),
(79, 'bio_stimulant', 18, '2025-10-24 16:24:06', '2025-10-24 16:24:06'),
(80, 'bio_stimulant', 19, '2025-10-24 16:28:34', '2025-10-24 16:28:34'),
(81, 'bio_stimulant', 20, '2025-10-24 16:31:22', '2025-10-24 16:31:22'),
(82, 'inorganic_soil_conditioner', 12, '2025-10-24 16:36:13', '2025-10-24 16:36:13'),
(83, 'inorganic_soil_conditioner', 13, '2025-10-24 16:43:27', '2025-10-24 16:43:27'),
(84, 'seed_form', 34, '2025-10-24 16:49:07', '2025-10-24 16:49:07'),
(85, 'animal_feed', 74, '2025-10-24 16:49:23', '2025-10-24 16:49:23'),
(86, 'bio_stimulant', 21, '2025-10-24 16:51:44', '2025-10-24 16:51:44'),
(87, 'bio_stimulant', 22, '2025-10-24 17:03:33', '2025-10-24 17:03:33'),
(88, 'bio_stimulant', 23, '2025-10-24 17:04:07', '2025-10-24 17:04:07'),
(89, 'bio_stimulant', 24, '2025-10-24 17:04:09', '2025-10-24 17:04:09'),
(90, 'bio_stimulant', 25, '2025-10-24 17:04:54', '2025-10-24 17:04:54'),
(91, 'animal_feed', 75, '2025-10-24 17:06:30', '2025-10-24 17:06:30'),
(92, 'bio_stimulant', 26, '2025-10-24 17:09:40', '2025-10-24 17:09:40'),
(93, 'seed_form', 35, '2025-10-24 17:24:31', '2025-10-24 17:24:31'),
(94, 'seed_form', 8, '2025-10-24 17:40:30', '2025-10-24 17:40:30'),
(95, 'seed_form', 8, '2025-10-24 17:41:15', '2025-10-24 17:41:15'),
(96, 'seed_form', 8, '2025-10-24 17:41:30', '2025-10-24 17:41:30'),
(97, 'seed_form', 8, '2025-10-24 17:42:44', '2025-10-24 17:42:44'),
(98, 'seed_form', 8, '2025-10-24 17:43:29', '2025-10-24 17:43:29'),
(99, 'seed_form', 8, '2025-10-24 17:44:56', '2025-10-24 17:44:56'),
(100, 'animal_feed', 2, '2025-10-24 17:47:13', '2025-10-24 17:47:13'),
(101, 'bio_stimulant', 5, '2025-10-24 17:51:38', '2025-10-24 17:51:38'),
(102, 'inorganic_soil_conditioner', 4, '2025-10-24 17:51:58', '2025-10-24 17:51:58'),
(103, 'bio_stimulant', 5, '2025-10-24 17:57:18', '2025-10-24 17:57:18'),
(104, 'inorganic_soil_conditioner', 4, '2025-10-24 17:58:27', '2025-10-24 17:58:27'),
(105, 'mineral_fertilizer', 1, '2025-10-24 18:06:01', '2025-10-24 18:06:01'),
(106, 'mineral_fertilizer', 1, '2025-10-24 18:09:52', '2025-10-24 18:09:52'),
(107, 'organic_amendment', 6, '2025-10-24 18:12:29', '2025-10-24 18:12:29'),
(108, 'synthetic_pesticide', 3, '2025-10-24 18:14:02', '2025-10-24 18:14:02'),
(109, 'seed_form', 8, '2025-10-24 18:42:19', '2025-10-24 18:42:19'),
(110, 'seed_form', 8, '2025-10-24 18:42:46', '2025-10-24 18:42:46'),
(111, 'seed_form', 8, '2025-10-24 18:44:00', '2025-10-24 18:44:00'),
(112, 'seed_form', 8, '2025-10-24 18:44:06', '2025-10-24 18:44:06'),
(113, 'seed_form', 8, '2025-10-24 18:45:17', '2025-10-24 18:45:17'),
(114, 'seed_form', 8, '2025-10-24 18:45:32', '2025-10-24 18:45:32'),
(115, 'animal_feed', 2, '2025-10-24 19:27:35', '2025-10-24 19:27:35'),
(116, 'animal_feed', 2, '2025-10-24 19:34:04', '2025-10-24 19:34:04'),
(117, 'seed_form', 8, '2025-10-24 19:48:40', '2025-10-24 19:48:40'),
(118, 'animal_feed', 2, '2025-10-24 19:48:49', '2025-10-24 19:48:49'),
(119, 'bio_stimulant', 5, '2025-10-24 19:49:07', '2025-10-24 19:49:07'),
(120, 'inorganic_soil_conditioner', 4, '2025-10-24 19:49:18', '2025-10-24 19:49:18'),
(121, 'mineral_fertilizer', 44, '2025-10-24 19:49:30', '2025-10-24 19:49:30'),
(122, 'organic_amendment', 6, '2025-10-24 19:49:51', '2025-10-24 19:49:51'),
(123, 'synthetic_pesticide', 3, '2025-10-24 19:50:03', '2025-10-24 19:50:03'),
(124, 'seed_form', 8, '2025-10-24 20:10:16', '2025-10-24 20:10:16'),
(125, 'seed_form', 8, '2025-10-24 20:46:09', '2025-10-24 20:46:09'),
(126, 'seed_form', 8, '2025-10-24 20:55:23', '2025-10-24 20:55:23'),
(127, 'seed_form', 8, '2025-10-24 20:55:27', '2025-10-24 20:55:27'),
(128, 'seed_form', 8, '2025-10-24 20:57:00', '2025-10-24 20:57:00'),
(129, 'seed_form', 8, '2025-10-24 20:58:13', '2025-10-24 20:58:13'),
(130, 'seed_form', 8, '2025-10-24 20:58:16', '2025-10-24 20:58:16'),
(131, 'seed_form', 8, '2025-10-24 20:58:27', '2025-10-24 20:58:27'),
(132, 'seed_form', 8, '2025-10-24 21:00:32', '2025-10-24 21:00:32'),
(133, 'seed_form', 8, '2025-10-24 21:00:35', '2025-10-24 21:00:35'),
(134, 'seed_form', 8, '2025-10-24 21:04:06', '2025-10-24 21:04:06'),
(135, 'seed_form', 8, '2025-10-24 21:05:43', '2025-10-24 21:05:43'),
(136, 'seed_form', 8, '2025-10-24 21:05:47', '2025-10-24 21:05:47'),
(137, 'animal_feed', 2, '2025-10-24 21:06:32', '2025-10-24 21:06:32'),
(138, 'organic_amendment', 6, '2025-10-24 22:52:38', '2025-10-24 22:52:38'),
(139, 'organic_amendment', 6, '2025-10-24 22:54:11', '2025-10-24 22:54:11'),
(140, 'organic_amendment', 6, '2025-10-24 22:54:23', '2025-10-24 22:54:23'),
(141, 'organic_amendment', 6, '2025-10-24 22:54:57', '2025-10-24 22:54:57'),
(142, 'animal_feed', 2, '2025-10-24 23:50:04', '2025-10-24 23:50:04'),
(143, 'seed_form', 8, '2025-10-24 23:52:22', '2025-10-24 23:52:22'),
(144, 'bio_stimulant', 5, '2025-10-24 23:53:01', '2025-10-24 23:53:01'),
(145, 'inorganic_soil_conditioner', 4, '2025-10-24 23:53:55', '2025-10-24 23:53:55'),
(146, 'mineral_fertilizer', 45, '2025-10-24 23:55:10', '2025-10-24 23:55:10'),
(147, 'mineral_fertilizer', 46, '2025-10-24 23:57:17', '2025-10-24 23:57:17'),
(148, 'organic_amendment', 6, '2025-10-24 23:58:43', '2025-10-24 23:58:43'),
(149, 'organic_amendment', 6, '2025-10-24 23:59:23', '2025-10-24 23:59:23'),
(150, 'synthetic_pesticide', 3, '2025-10-25 00:00:11', '2025-10-25 00:00:11'),
(151, 'mineral_fertilizer', 47, '2025-10-25 00:36:20', '2025-10-25 00:36:20'),
(152, 'seed_form', 8, '2025-10-25 00:37:23', '2025-10-25 00:37:23'),
(153, 'mineral_fertilizer', 48, '2025-10-25 00:39:16', '2025-10-25 00:39:16'),
(154, 'mineral_fertilizer', 1, '2025-10-25 00:52:47', '2025-10-25 00:52:47'),
(155, 'seed_form', 8, '2025-10-25 00:57:04', '2025-10-25 00:57:04'),
(156, 'seed_form', 8, '2025-10-25 02:15:42', '2025-10-25 02:15:42'),
(157, 'synthetic_pesticide', 3, '2025-10-25 09:39:48', '2025-10-25 09:39:48'),
(158, 'veterinary_product', 29, '2025-10-25 09:47:17', '2025-10-25 09:47:17'),
(159, 'seed_form', 8, '2025-10-25 09:52:40', '2025-10-25 09:52:40'),
(160, 'animal_feed', 2, '2025-10-25 09:53:30', '2025-10-25 09:53:30'),
(161, 'mineral_fertilizer', 50, '2025-10-25 09:56:32', '2025-10-25 09:56:32'),
(162, 'seed_form', 8, '2025-10-25 10:00:03', '2025-10-25 10:00:03'),
(163, 'animal_feed', 2, '2025-10-25 10:00:28', '2025-10-25 10:00:28'),
(164, 'bio_stimulant', 5, '2025-10-25 10:00:41', '2025-10-25 10:00:41'),
(165, 'inorganic_soil_conditioner', 4, '2025-10-25 10:00:56', '2025-10-25 10:00:56'),
(166, 'organic_amendment', 6, '2025-10-25 10:01:32', '2025-10-25 10:01:32'),
(167, 'synthetic_pesticide', 3, '2025-10-25 10:01:52', '2025-10-25 10:01:52'),
(168, 'mineral_fertilizer', 51, '2025-10-25 10:03:02', '2025-10-25 10:03:02'),
(169, 'bio_stimulant', 5, '2025-10-25 10:54:04', '2025-10-25 10:54:04'),
(170, 'inorganic_soil_conditioner', 4, '2025-10-25 10:58:42', '2025-10-25 10:58:42'),
(171, 'mineral_fertilizer', 52, '2025-10-25 11:02:36', '2025-10-25 11:02:36'),
(172, 'organic_amendment', 6, '2025-10-25 11:14:01', '2025-10-25 11:14:01'),
(173, 'synthetic_pesticide', 3, '2025-10-25 11:28:25', '2025-10-25 11:28:25'),
(174, 'veterinary_product', 1, '2025-10-25 11:33:48', '2025-10-25 11:33:48'),
(175, 'veterinary_product', 1, '2025-10-25 12:25:36', '2025-10-25 12:25:36'),
(176, 'seed_form', 8, '2025-10-25 17:44:42', '2025-10-25 17:44:42'),
(177, 'seed_form', 8, '2025-10-25 17:49:48', '2025-10-25 17:49:48'),
(178, 'seed_form', 8, '2025-10-25 17:54:11', '2025-10-25 17:54:11'),
(179, 'seed_form', 8, '2025-10-25 17:57:18', '2025-10-25 17:57:18'),
(180, 'seed_form', 8, '2025-10-25 17:58:38', '2025-10-25 17:58:38'),
(181, 'mineral_fertilizer', 53, '2025-10-25 18:04:47', '2025-10-25 18:04:47'),
(182, 'mineral_fertilizer', 54, '2025-10-25 18:10:25', '2025-10-25 18:10:25'),
(183, 'seed_form', 8, '2025-10-25 18:10:33', '2025-10-25 18:10:33'),
(184, 'animal_feed', 2, '2025-10-25 18:15:24', '2025-10-25 18:15:24'),
(185, 'bio_stimulant', 5, '2025-10-25 18:18:34', '2025-10-25 18:18:34'),
(186, 'bio_stimulant', 5, '2025-10-25 18:20:40', '2025-10-25 18:20:40'),
(187, 'inorganic_soil_conditioner', 4, '2025-10-25 18:23:39', '2025-10-25 18:23:39'),
(188, 'mineral_fertilizer', 7, '2025-10-25 18:25:37', '2025-10-25 18:25:37'),
(189, 'organic_amendment', 6, '2025-10-25 18:27:41', '2025-10-25 18:27:41'),
(190, 'synthetic_pesticide', 3, '2025-10-25 18:29:40', '2025-10-25 18:29:40'),
(191, 'veterinary_product', 1, '2025-10-25 18:32:12', '2025-10-25 18:32:12'),
(192, 'seed_form', 8, '2025-10-25 20:36:24', '2025-10-25 20:36:24'),
(193, 'seed_form', 8, '2025-10-27 18:01:33', '2025-10-27 18:01:33'),
(194, 'veterinary_product', 1, '2025-10-28 14:24:07', '2025-10-28 14:24:07'),
(195, 'seed_form', 8, '2025-10-28 18:27:54', '2025-10-28 18:27:54'),
(196, 'seed_form', 8, '2025-10-28 18:49:42', '2025-10-28 18:49:42'),
(197, 'animal_feed', 2, '2025-10-28 18:51:56', '2025-10-28 18:51:56'),
(198, 'animal_feed', 2, '2025-10-28 18:52:15', '2025-10-28 18:52:15'),
(199, 'organic_amendment', 6, '2025-10-28 19:09:26', '2025-10-28 19:09:26'),
(200, 'synthetic_pesticide', 3, '2025-10-28 19:09:42', '2025-10-28 19:09:42'),
(201, 'veterinary_product', 1, '2025-10-28 19:09:58', '2025-10-28 19:09:58'),
(202, 'bio_stimulant', 5, '2025-10-28 19:17:07', '2025-10-28 19:17:07'),
(203, 'animal_feed', 2, '2025-10-28 19:37:06', '2025-10-28 19:37:06'),
(204, 'veterinary_product', 1, '2025-10-28 19:45:05', '2025-10-28 19:45:05'),
(205, 'organic_amendment', 6, '2025-10-28 19:54:33', '2025-10-28 19:54:33'),
(206, 'animal_feed', 2, '2025-10-28 19:58:48', '2025-10-28 19:58:48'),
(207, 'bio_stimulant', 5, '2025-10-28 20:21:58', '2025-10-28 20:21:58'),
(208, 'organic_amendment', 6, '2025-10-28 20:28:54', '2025-10-28 20:28:54'),
(209, 'organic_amendment', 6, '2025-10-28 20:29:40', '2025-10-28 20:29:40'),
(210, 'animal_feed', 2, '2025-10-29 15:14:15', '2025-10-29 15:14:15'),
(211, 'animal_feed', 2, '2025-10-29 15:16:45', '2025-10-29 15:16:45'),
(212, 'animal_feed', 2, '2025-10-29 15:18:40', '2025-10-29 15:18:40'),
(213, 'veterinary_product', 1, '2025-10-30 15:48:15', '2025-10-30 15:48:15'),
(214, 'animal_feed', 2, '2025-10-30 16:24:37', '2025-10-30 16:24:37'),
(215, 'veterinary_product', 1, '2025-10-30 16:30:19', '2025-10-30 16:30:19'),
(216, 'synthetic_pesticide', 3, '2025-10-30 16:34:02', '2025-10-30 16:34:02'),
(217, 'seed_form', 8, '2025-10-30 16:50:24', '2025-10-30 16:50:24'),
(218, 'animal_feed', 2, '2025-10-30 17:16:41', '2025-10-30 17:16:41'),
(219, 'seed_form', 8, '2025-10-30 17:42:25', '2025-10-30 17:42:25'),
(220, 'organic_amendment', 6, '2025-10-30 17:44:37', '2025-10-30 17:44:37'),
(221, 'animal_feed', 2, '2025-10-30 17:59:31', '2025-10-30 17:59:31'),
(222, 'bio_stimulant', 5, '2025-10-30 18:02:21', '2025-10-30 18:02:21'),
(223, 'veterinary_product', 1, '2025-10-30 18:18:37', '2025-10-30 18:18:37'),
(224, 'veterinary_product', 1, '2025-10-30 18:19:26', '2025-10-30 18:19:26'),
(225, 'bio_stimulant', 5, '2025-10-30 18:29:40', '2025-10-30 18:29:40'),
(226, 'bio_stimulant', 5, '2025-10-30 18:50:17', '2025-10-30 18:50:17'),
(227, 'bio_stimulant', 5, '2025-10-30 18:50:29', '2025-10-30 18:50:29'),
(228, 'inorganic_soil_conditioner', 4, '2025-10-30 18:52:30', '2025-10-30 18:52:30'),
(229, 'inorganic_soil_conditioner', 4, '2025-10-30 18:56:19', '2025-10-30 18:56:19'),
(230, 'inorganic_soil_conditioner', 4, '2025-10-30 18:59:42', '2025-10-30 18:59:42'),
(231, 'inorganic_soil_conditioner', 4, '2025-10-30 18:59:54', '2025-10-30 18:59:54'),
(232, 'veterinary_product', 1, '2025-10-31 20:57:56', '2025-10-31 20:57:56'),
(233, 'veterinary_product', 1, '2025-10-31 21:06:19', '2025-10-31 21:06:19'),
(234, 'seed_form', 8, '2025-10-31 21:10:07', '2025-10-31 21:10:07'),
(235, 'animal_feed', 2, '2025-11-03 16:07:45', '2025-11-03 16:07:45'),
(236, 'animal_feed', 2, '2025-11-03 16:08:02', '2025-11-03 16:08:02'),
(237, 'seed_form', 8, '2025-11-04 17:37:39', '2025-11-04 17:37:39'),
(238, 'bio_stimulant', 5, '2025-11-04 19:21:56', '2025-11-04 19:21:56'),
(239, 'inorganic_soil_conditioner', 4, '2025-11-04 19:31:52', '2025-11-04 19:31:52'),
(240, 'mineral_fertilizer', 57, '2025-11-04 19:46:08', '2025-11-04 19:46:08'),
(241, 'seed_form', 8, '2025-11-04 20:24:56', '2025-11-04 20:24:56'),
(242, 'seed_form', 8, '2025-11-04 20:46:04', '2025-11-04 20:46:04'),
(243, 'synthetic_pesticide', 3, '2025-11-04 20:59:24', '2025-11-04 20:59:24'),
(244, 'organic_amendment', 6, '2025-11-05 09:32:32', '2025-11-05 09:32:32'),
(245, 'organic_amendment', 6, '2025-11-05 09:55:02', '2025-11-05 09:55:02'),
(246, 'seed_form', 8, '2025-11-05 19:03:18', '2025-11-05 19:03:18'),
(247, 'veterinary_product', 1, '2025-11-05 19:04:18', '2025-11-05 19:04:18'),
(248, 'mineral_fertilizer', 58, '2025-11-05 19:05:11', '2025-11-05 19:05:11'),
(249, 'organic_amendment', 6, '2025-11-05 19:06:47', '2025-11-05 19:06:47'),
(250, 'bio_stimulant', 5, '2025-11-05 19:07:13', '2025-11-05 19:07:13'),
(251, 'inorganic_soil_conditioner', 4, '2025-11-05 19:07:35', '2025-11-05 19:07:35'),
(252, 'synthetic_pesticide', 3, '2025-11-05 20:06:02', '2025-11-05 20:06:02'),
(253, 'animal_feed', 2, '2025-11-06 20:29:11', '2025-11-06 20:29:11'),
(254, 'inorganic_soil_conditioner', 4, '2025-11-06 20:31:15', '2025-11-06 20:31:15'),
(255, 'inorganic_soil_conditioner', 4, '2025-11-06 20:38:44', '2025-11-06 20:38:44'),
(256, 'inorganic_soil_conditioner', 4, '2025-11-06 21:05:51', '2025-11-06 21:05:51'),
(257, 'inorganic_soil_conditioner', 4, '2025-11-06 21:07:15', '2025-11-06 21:07:15'),
(258, 'inorganic_soil_conditioner', 4, '2025-11-06 21:10:23', '2025-11-06 21:10:23'),
(259, 'inorganic_soil_conditioner', 4, '2025-11-06 21:47:40', '2025-11-06 21:47:40'),
(260, 'inorganic_soil_conditioner', 4, '2025-11-06 21:49:24', '2025-11-06 21:49:24'),
(261, 'inorganic_soil_conditioner', 4, '2025-11-06 21:52:35', '2025-11-06 21:52:35'),
(262, 'inorganic_soil_conditioner', 4, '2025-11-06 22:00:01', '2025-11-06 22:00:01'),
(263, 'inorganic_soil_conditioner', 4, '2025-11-06 22:01:09', '2025-11-06 22:01:09'),
(264, 'seed_form', 8, '2025-11-06 22:28:21', '2025-11-06 22:28:21'),
(265, 'bio_stimulant', 5, '2025-11-07 12:27:18', '2025-11-07 12:27:18'),
(266, 'synthetic_pesticide', 3, '2025-11-07 12:37:14', '2025-11-07 12:37:14'),
(267, 'seed_form', 8, '2025-11-07 12:37:26', '2025-11-07 12:37:26'),
(268, 'animal_feed', 2, '2025-11-07 12:37:55', '2025-11-07 12:37:55'),
(269, 'veterinary_product', 1, '2025-11-07 12:45:10', '2025-11-07 12:45:10'),
(270, 'organic_amendment', 6, '2025-11-07 12:47:10', '2025-11-07 12:47:10'),
(271, 'inorganic_soil_conditioner', 4, '2025-11-07 13:07:17', '2025-11-07 13:07:17'),
(272, 'inorganic_soil_conditioner', 4, '2025-11-07 13:07:56', '2025-11-07 13:07:56'),
(273, 'inorganic_soil_conditioner', 4, '2025-11-07 15:50:27', '2025-11-07 15:50:27'),
(274, 'inorganic_soil_conditioner', 4, '2025-11-07 15:51:21', '2025-11-07 15:51:21'),
(275, 'inorganic_soil_conditioner', 4, '2025-11-07 16:02:38', '2025-11-07 16:02:38'),
(276, 'inorganic_soil_conditioner', 4, '2025-11-07 16:14:28', '2025-11-07 16:14:28'),
(277, 'inorganic_soil_conditioner', 4, '2025-11-07 16:18:43', '2025-11-07 16:18:43'),
(278, 'inorganic_soil_conditioner', 4, '2025-11-07 16:19:18', '2025-11-07 16:19:18'),
(279, 'inorganic_soil_conditioner', 4, '2025-11-07 16:28:14', '2025-11-07 16:28:14'),
(280, 'inorganic_soil_conditioner', 4, '2025-11-07 16:34:49', '2025-11-07 16:34:49'),
(281, 'inorganic_soil_conditioner', 4, '2025-11-07 16:39:25', '2025-11-07 16:39:25'),
(282, 'inorganic_soil_conditioner', 4, '2025-11-07 16:54:34', '2025-11-07 16:54:34'),
(283, 'inorganic_soil_conditioner', 4, '2025-11-07 16:55:06', '2025-11-07 16:55:06'),
(284, 'inorganic_soil_conditioner', 4, '2025-11-07 17:00:42', '2025-11-07 17:00:42'),
(285, 'inorganic_soil_conditioner', 4, '2025-11-07 17:06:31', '2025-11-07 17:06:31'),
(286, 'seed_form', 8, '2025-11-07 17:34:30', '2025-11-07 17:34:30'),
(287, 'seed_form', 8, '2025-11-07 17:37:20', '2025-11-07 17:37:20'),
(288, 'seed_form', 8, '2025-11-07 17:47:41', '2025-11-07 17:47:41'),
(289, 'seed_form', 8, '2025-11-07 17:58:25', '2025-11-07 17:58:25'),
(290, 'seed_form', 8, '2025-11-07 18:03:53', '2025-11-07 18:03:53'),
(291, 'synthetic_pesticide', 3, '2025-11-07 18:40:51', '2025-11-07 18:40:51'),
(292, 'seed_form', 8, '2025-11-07 18:58:49', '2025-11-07 18:58:49'),
(293, 'seed_form', 8, '2025-11-07 19:00:13', '2025-11-07 19:00:13'),
(294, 'seed_form', 8, '2025-11-07 19:00:47', '2025-11-07 19:00:47'),
(295, 'seed_form', 8, '2025-11-07 19:01:20', '2025-11-07 19:01:20'),
(296, 'seed_form', 8, '2025-11-07 19:28:34', '2025-11-07 19:28:34'),
(297, 'seed_form', 8, '2025-11-07 19:29:45', '2025-11-07 19:29:45'),
(298, 'seed_form', 8, '2025-11-07 19:34:16', '2025-11-07 19:34:16'),
(299, 'seed_form', 8, '2025-11-07 19:39:40', '2025-11-07 19:39:40'),
(300, 'seed_form', 8, '2025-11-07 19:40:00', '2025-11-07 19:40:00'),
(301, 'seed_form', 8, '2025-11-07 19:43:07', '2025-11-07 19:43:07'),
(302, 'seed_form', 8, '2025-11-07 20:00:41', '2025-11-07 20:00:41'),
(303, 'seed_form', 8, '2025-11-07 20:02:00', '2025-11-07 20:02:00'),
(304, 'animal_feed', 2, '2025-11-12 18:33:28', '2025-11-12 18:33:28'),
(305, 'animal_feed', 2, '2025-11-13 01:38:05', '2025-11-13 01:38:05'),
(306, 'animal_feed', 2, '2025-11-13 09:11:13', '2025-11-13 09:11:13'),
(307, 'synthetic_pesticide', 3, '2025-11-13 09:13:06', '2025-11-13 09:13:06'),
(308, 'inorganic_soil_conditioner', 4, '2025-11-13 09:15:54', '2025-11-13 09:15:54'),
(309, 'inorganic_soil_conditioner', 4, '2025-11-13 09:16:08', '2025-11-13 09:16:08'),
(310, 'inorganic_soil_conditioner', 4, '2025-11-13 09:16:21', '2025-11-13 09:16:21'),
(311, 'animal_feed', 2, '2025-11-13 09:28:09', '2025-11-13 09:28:09'),
(312, 'synthetic_pesticide', 3, '2025-11-13 09:31:13', '2025-11-13 09:31:13'),
(313, 'inorganic_soil_conditioner', 4, '2025-11-13 09:32:08', '2025-11-13 09:32:08'),
(314, 'inorganic_soil_conditioner', 4, '2025-11-13 09:32:15', '2025-11-13 09:32:15'),
(315, 'inorganic_soil_conditioner', 4, '2025-11-13 09:32:27', '2025-11-13 09:32:27'),
(316, 'seed_form', 8, '2025-11-13 11:32:18', '2025-11-13 11:32:18'),
(317, 'inorganic_soil_conditioner', 4, '2025-11-13 11:36:59', '2025-11-13 11:36:59'),
(318, 'inorganic_soil_conditioner', 4, '2025-11-13 11:37:31', '2025-11-13 11:37:31'),
(319, 'seed_form', 8, '2025-11-13 11:45:51', '2025-11-13 11:45:51'),
(320, 'veterinary_product', 1, '2025-11-13 11:49:16', '2025-11-13 11:49:16'),
(321, 'inorganic_soil_conditioner', 4, '2025-11-13 12:00:08', '2025-11-13 12:00:08'),
(322, 'inorganic_soil_conditioner', 4, '2025-11-13 12:00:19', '2025-11-13 12:00:19'),
(323, 'inorganic_soil_conditioner', 4, '2025-11-13 12:00:26', '2025-11-13 12:00:26'),
(324, 'inorganic_soil_conditioner', 4, '2025-11-13 12:00:33', '2025-11-13 12:00:33'),
(325, 'inorganic_soil_conditioner', 4, '2025-11-13 12:01:21', '2025-11-13 12:01:21'),
(326, 'inorganic_soil_conditioner', 4, '2025-11-13 12:01:29', '2025-11-13 12:01:29'),
(327, 'veterinary_product', 1, '2025-11-13 13:35:06', '2025-11-13 13:35:06'),
(328, 'seed_form', 8, '2025-11-13 14:02:39', '2025-11-13 14:02:39'),
(329, 'inorganic_soil_conditioner', 4, '2025-11-13 14:05:28', '2025-11-13 14:05:28'),
(330, 'inorganic_soil_conditioner', 4, '2025-11-13 14:05:33', '2025-11-13 14:05:33'),
(331, 'animal_feed', 2, '2025-11-13 14:38:24', '2025-11-13 14:38:24'),
(332, 'animal_feed', 2, '2025-11-13 14:47:23', '2025-11-13 14:47:23'),
(333, 'inorganic_soil_conditioner', 4, '2025-11-13 16:26:38', '2025-11-13 16:26:38'),
(334, 'inorganic_soil_conditioner', 4, '2025-11-13 16:28:43', '2025-11-13 16:28:43'),
(335, 'inorganic_soil_conditioner', 4, '2025-11-13 16:32:16', '2025-11-13 16:32:16'),
(336, 'veterinary_product', 1, '2025-11-13 16:50:36', '2025-11-13 16:50:36'),
(337, 'animal_feed', 2, '2025-11-13 16:51:18', '2025-11-13 16:51:18'),
(338, 'synthetic_pesticide', 3, '2025-11-13 16:52:13', '2025-11-13 16:52:13'),
(339, 'seed_form', 8, '2025-11-13 16:55:10', '2025-11-13 16:55:10'),
(340, 'bio_stimulant', 5, '2025-11-13 17:03:49', '2025-11-13 17:03:49'),
(341, 'bio_stimulant', 5, '2025-11-13 17:04:44', '2025-11-13 17:04:44'),
(342, 'bio_stimulant', 5, '2025-11-13 17:14:10', '2025-11-13 17:14:10'),
(343, 'mineral_fertilizer', 7, '2025-11-13 17:22:24', '2025-11-13 17:22:24'),
(344, 'mineral_fertilizer', 7, '2025-11-13 17:23:15', '2025-11-13 17:23:15'),
(345, 'organic_amendment', 6, '2025-11-13 18:05:21', '2025-11-13 18:05:21'),
(346, 'bio_stimulant', 5, '2025-11-13 18:37:43', '2025-11-13 18:37:43'),
(347, 'mineral_fertilizer', 7, '2025-11-13 18:51:40', '2025-11-13 18:51:40'),
(348, 'veterinary_product', 1, '2025-11-13 18:56:14', '2025-11-13 18:56:14'),
(349, 'animal_feed', 2, '2025-11-14 13:59:23', '2025-11-14 13:59:23'),
(350, 'seed_form', 8, '2025-11-17 17:41:49', '2025-11-17 17:41:49'),
(351, 'seed_form', 8, '2025-11-17 17:56:13', '2025-11-17 17:56:13'),
(352, 'seed_form', 8, '2025-11-17 17:58:02', '2025-11-17 17:58:02'),
(353, 'seed_form', 8, '2025-11-17 18:13:11', '2025-11-17 18:13:11'),
(354, 'animal_feed', 2, '2025-11-17 20:50:29', '2025-11-17 20:50:29'),
(355, 'animal_feed', 2, '2025-11-17 20:59:45', '2025-11-17 20:59:45'),
(356, 'bio_stimulant', 5, '2025-11-18 17:26:43', '2025-11-18 17:26:43'),
(357, 'animal_feed', 2, '2025-11-18 20:36:39', '2025-11-18 20:36:39'),
(358, 'animal_feed', 2, '2025-11-19 08:54:26', '2025-11-19 08:54:26'),
(359, 'bio_stimulant', 5, '2025-11-19 08:55:25', '2025-11-19 08:55:25'),
(360, 'inorganic_soil_conditioner', 4, '2025-11-19 08:56:51', '2025-11-19 08:56:51'),
(361, 'mineral_fertilizer', 7, '2025-11-19 08:57:31', '2025-11-19 08:57:31'),
(362, 'organic_amendment', 6, '2025-11-19 08:58:28', '2025-11-19 08:58:28'),
(363, 'synthetic_pesticide', 3, '2025-11-19 08:59:18', '2025-11-19 08:59:18'),
(364, 'veterinary_product', 1, '2025-11-19 09:00:00', '2025-11-19 09:00:00'),
(365, 'synthetic_pesticide', 3, '2025-11-19 15:40:38', '2025-11-19 15:40:38'),
(366, 'inorganic_soil_conditioner', 4, '2025-11-19 17:21:49', '2025-11-19 17:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `animalfeed_testing`
--

CREATE TABLE `animalfeed_testing` (
  `id` int(11) UNSIGNED NOT NULL,
  `form_type` varchar(255) DEFAULT 'animal_feed',
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `language_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `Typeoffeed` varchar(255) DEFAULT NULL,
  `afrm` varchar(255) DEFAULT NULL,
  `afPhysicalform` varchar(255) DEFAULT NULL,
  `afdm` varchar(255) DEFAULT NULL,
  `afEnergy` varchar(255) DEFAULT NULL,
  `afcp` varchar(255) DEFAULT NULL,
  `afsp` varchar(255) DEFAULT NULL,
  `affs` varchar(255) DEFAULT NULL,
  `afWholesalePrice` decimal(10,2) DEFAULT NULL,
  `afsemiwholesalePrice` decimal(10,2) DEFAULT NULL,
  `afretailPrice` decimal(10,2) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL COMMENT 'QR code image path',
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animalfeed_testing`
--

INSERT INTO `animalfeed_testing` (`id`, `form_type`, `product_id`, `created_by`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `language_id`, `title`, `Typeoffeed`, `afrm`, `afPhysicalform`, `afdm`, `afEnergy`, `afcp`, `afsp`, `affs`, `afWholesalePrice`, `afsemiwholesalePrice`, `afretailPrice`, `qr_code_path`, `otherRecommendationsPhoto`, `created_at`, `updated_at`) VALUES
(138, 'animal_feed', 2, 1, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '89%', '2 800 kcal/kg', '16%', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-15 17:11:03', '2025-12-17 07:36:13'),
(139, 'animal_feed', 2, NULL, 191, 100, 2, NULL, 1, 'yuuu', 'Start of breeding', 'bsb', 'Granules', 'hdh', 'bsb', '16', NULL, 'bsb', 28.00, 139.00, 12.00, 'qrcodes/animalfeed_139.png', NULL, '2025-12-15 18:37:22', '2025-12-15 19:05:08'),
(140, 'animal_feed', NULL, NULL, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '89%', '2 800 kcal/kg', '16%', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 13:43:44', '2025-12-18 13:43:44'),
(141, 'animal_feed', NULL, NULL, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '89%', '2 800 kcal/kg', '16%', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 13:45:23', '2025-12-18 13:45:23'),
(142, 'animal_feed', NULL, NULL, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '0.89', '2 800 kcal/kg', '0.16', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 13:45:23', '2025-12-18 13:45:23'),
(143, 'animal_feed', 2, 1, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '89%', '2 800 kcal/kg', '16%', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 13:49:24', '2025-12-18 13:49:24'),
(144, 'animal_feed', 2, 1, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '0.89', '2 800 kcal/kg', '0.16', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 13:49:24', '2025-12-18 13:49:24'),
(100004, 'animal_feed', 2, 1, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '89%', '2 800 kcal/kg', '16%', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 14:29:07', '2025-12-18 14:29:07'),
(100005, 'animal_feed', 2, 1, 191, NULL, 2, NULL, NULL, NULL, 'Dairy cow', 'Maize bran, cottonseed cake, mineral premix', 'Pellet', '0.89', '2 800 kcal/kg', '0.16', '3 months', '2', 17000.00, 1700.00, 17000.00, NULL, NULL, '2025-12-18 14:29:07', '2025-12-18 14:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `animal_feeds`
--

CREATE TABLE `animal_feeds` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(255) DEFAULT 'animal_feed',
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `product_master_id` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `language_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `Typeoffeed` varchar(255) DEFAULT NULL,
  `afrm` varchar(255) DEFAULT NULL,
  `afPhysicalform` varchar(255) DEFAULT NULL,
  `afdm` varchar(255) DEFAULT NULL,
  `afEnergy` varchar(255) DEFAULT NULL,
  `afcp` varchar(255) DEFAULT NULL,
  `afsp` varchar(255) DEFAULT NULL,
  `affs` varchar(255) DEFAULT NULL,
  `afWholesalePrice` decimal(10,2) DEFAULT NULL,
  `afsemiwholesalePrice` decimal(10,2) DEFAULT NULL,
  `afretailPrice` decimal(10,2) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL COMMENT 'QR code image path',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal_feeds`
--

INSERT INTO `animal_feeds` (`id`, `parent_id`, `live_id`, `form_type`, `product_id`, `product_master_id`, `created_by`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `language_id`, `title`, `localProductName`, `Typeoffeed`, `afrm`, `afPhysicalform`, `afdm`, `afEnergy`, `afcp`, `afsp`, `affs`, `afWholesalePrice`, `afsemiwholesalePrice`, `afretailPrice`, `qr_code_path`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(148, NULL, 0, 'animal_feed', 2, NULL, NULL, 193, 1, 1, NULL, 1, 'animal geed', NULL, 'Filling', 'feed', 'Flour', '55', 're', '13', NULL, 'lid', 555.00, 320.00, 100.00, 'qrcodes/animalfeed_148.png', '2025-12-19 14:10:32', '2025-12-19 14:10:32', 'uploads/animal_feeds/animal_feed_1766128232_6944fa68bacdc.png'),
(100003, NULL, 0, 'animal_feed', 2, NULL, 11, 191, 1, 2, NULL, 1, 'Premium Cow Feed', NULL, 'Cattle Feed', 'Yes', 'Pellet', '90%', 'High', '18%', '12%', '8%', 125.00, 125.00, 10.00, 'qrcodes/animalfeed_100003.png', '2025-12-24 16:20:50', '2025-12-29 10:36:03', 'uploads/animal_feeds/animal_feed_1766568050_694bb072a010c.png'),
(100006, NULL, 0, 'animal_feed', 2, NULL, NULL, 191, 1, 2, NULL, 1, '666', NULL, 'Poulet', 'uuuu', 'Farine', 'ggg', 'fff', 'tt', NULL, '56', 5555.00, 6777.00, 667.00, 'qrcodes/animalfeed_100006.png', '2026-02-11 00:01:34', '2026-02-11 00:01:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `animal_feed_fields`
--

CREATE TABLE `animal_feed_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `animal_feed_fields`
--

INSERT INTO `animal_feed_fields` (`id`, `label`, `name`, `type`, `options`, `required`) VALUES
(1, 'Type of feed', 'Typeoffeed', 'select', '[\"Chick start\",\"Chicken\",\"Layers\",\"Chair\",\"All ruminants\",\"Dairy cow\",\"Filling\",\"Equid\",\"Pigs\",\"Other\"]', 1),
(2, 'Raw materials', 'afrm', 'text', NULL, 1),
(3, 'Physical form', 'afPhysicalform', 'select', '[\"Pellet\",\"Flour\",\"Crumb\"]', 1),
(4, '% Dry matter (DM)', 'afdm', 'text', NULL, 0),
(5, '% Energy (UF, kcal)', 'afEnergy', 'text', NULL, 0),
(6, '% Crude protein', 'afcp', 'text', NULL, 0),
(7, 'Storage period', 'afsp', 'text', NULL, 0),
(8, 'Feed supplements', 'affs', 'text', NULL, 0),
(9, 'Average wholesale price', 'afWholesalePrice', 'number', NULL, 1),
(10, 'Average semi-wholesale price', 'afsemiwholesalePrice', 'number', NULL, 1),
(11, 'Average retail price', 'afretailPrice', 'number', NULL, 1),
(12, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 0),
(13, 'Local produt name', 'localProductName', 'text', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `animal_feed_translations`
--

CREATE TABLE `animal_feed_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `animal_feed_id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Typeoffeed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afrm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afPhysicalform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afdm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afEnergy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afcp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afsp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afWholesalePrice` decimal(10,2) DEFAULT NULL,
  `afsemiwholesalePrice` decimal(10,2) DEFAULT NULL,
  `afretailPrice` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_type_id` text DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `language_id` varchar(10) NOT NULL DEFAULT 'en',
  `currency` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `image`, `user_type_id`, `country_id`, `created_at`, `updated_at`, `created_by`, `status`, `language_id`, `currency`) VALUES
(26, 'NPK 15-15-15 Fertilizer – Certified Agricultural Quality', 'We offer high-quality NPK 15-15-15 fertilizer, suitable for major staple and horticultural crops (maize, rice, sorghum, vegetables). This offer targets farmers, farmer cooperatives, and agricultural traders seeking transparent and reliable access to agricultural inputs through the WAIMA platform.', 'uploads/announcements/1768916255_696f851f97abc.png', '2', 2, '2026-01-20 20:37:35', '2026-01-20 20:37:35', NULL, 'Active', 'fr', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_translations`
--

CREATE TABLE `announcement_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bio_stimulants`
--

CREATE TABLE `bio_stimulants` (
  `id` int(11) NOT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(255) DEFAULT 'bio_stimulants',
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `trade_name` varchar(255) NOT NULL,
  `physical_form` varchar(50) NOT NULL,
  `biostimulant_product` varchar(100) NOT NULL,
  `re_registration` varchar(255) NOT NULL,
  `n` float DEFAULT NULL,
  `p2` float DEFAULT NULL,
  `k2` float DEFAULT NULL,
  `zn` float DEFAULT NULL,
  `ca` float DEFAULT NULL,
  `mg` float DEFAULT NULL,
  `s` float DEFAULT NULL,
  `b` float DEFAULT NULL,
  `mo` float DEFAULT NULL,
  `action_mode` varchar(255) DEFAULT NULL,
  `wholesale_price` decimal(10,2) NOT NULL,
  `semiwholesale_price` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bio_stimulants`
--

INSERT INTO `bio_stimulants` (`id`, `localProductName`, `parent_id`, `live_id`, `form_type`, `product_id`, `product_master_id`, `trade_name`, `physical_form`, `biostimulant_product`, `re_registration`, `n`, `p2`, `k2`, `zn`, `ca`, `mg`, `s`, `b`, `mo`, `action_mode`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `qr_code_path`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `created_by`, `language_id`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(100025, NULL, NULL, 0, 'bio_stimulant', 5, NULL, 'Bio Power Plus', 'Liquid', 'Plant Growth', 'REG-12345', 2.5, 1.2, 3.1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1250.00, 1350.00, 1500.00, 'qrcodes/bio_100025.png', 191, 1, 1, NULL, 1, 1, '2025-12-24 16:34:34', '2025-12-24 16:34:34', 'uploads/bio_stimulant/bio_1766568874_694bb3aad30b2.png'),
(100026, NULL, 100025, 0, 'bio_stimulant', 5, NULL, 'Bio Power Plus LLP', 'Liquid', 'Plant Growth', 'REG-12345', 2.5, 1.2, 3.1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1250.00, 1350.00, 1500.00, 'qrcodes/bio_100026.png', 191, 1, 1, NULL, 1, 1, '2025-12-24 16:35:13', '2025-12-24 16:35:13', 'uploads/bio_stimulant/bio_1766568913_694bb3d18c817.png'),
(100027, NULL, NULL, 0, 'bio_stimulants', 5, NULL, 'Bio Power Plus', 'Liquid', 'Purified plant extracts', '12', 2, 2, 2, 2, 2, 2, 2, 2, 2, '2', 2.00, 2.00, 2.00, 'qrcodes/biostimulant_100027.png', NULL, NULL, 1, NULL, 1, 1, '2026-03-31 12:53:14', '2026-03-31 12:53:14', 'uploads/biostimulants/biostimulant_1774936394.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bio_stimulants_fields`
--

CREATE TABLE `bio_stimulants_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bio_stimulants_fields`
--

INSERT INTO `bio_stimulants_fields` (`id`, `label`, `name`, `type`, `options`, `required`) VALUES
(1, 'Trade Name', 'trade_name', 'text', NULL, 1),
(2, 'Physical form', 'physical_form', 'select', '[\"Liquid\",\"Solid granules\",\"Powder\"]', 1),
(3, 'Biostimulant product', 'biostimulant_product', 'select', '[\"Bacteria\",\"Mushrooms\",\"Yeast\",\"Purified plant extracts\",\"Vitamins\",\"Rock powder\"]', 1),
(4, 'ReRegistration Number', 're_registration', 'text', NULL, 1),
(5, '% N', 'n', 'number', NULL, 0),
(6, '% P2O5', 'p2', 'number', NULL, 0),
(7, '% K2O', 'k2', 'number', NULL, 0),
(8, '% Zn', 'zn', 'number', NULL, 0),
(9, '% Ca', 'ca', 'number', NULL, 0),
(10, '% Mg', 'mg', 'number', NULL, 0),
(11, '% S', 's', 'number', NULL, 0),
(12, '% B', 'b', 'number', NULL, 0),
(13, '% Mo', 'mo', 'number', NULL, 0),
(14, 'Mode of action', 'action_mode', 'text', NULL, 0),
(15, 'Average wholesale price', 'wholesale_price', 'number', NULL, 1),
(16, 'Average semi-wholesale price', 'semiwholesale_price', 'number', NULL, 1),
(17, 'Average retail price', 'retail_price', 'number', NULL, 1),
(18, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1),
(19, 'Local produt name', 'localProductName', 'text', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bio_stimulant_translations`
--

CREATE TABLE `bio_stimulant_translations` (
  `id` int(11) NOT NULL,
  `bio_stimulant_id` int(11) NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `physical_form` varchar(50) DEFAULT NULL,
  `biostimulant_product` varchar(100) DEFAULT NULL,
  `re_registration` varchar(255) DEFAULT NULL,
  `action_mode` varchar(255) DEFAULT NULL,
  `n` decimal(10,2) DEFAULT NULL,
  `p2` decimal(10,2) DEFAULT NULL,
  `k2` decimal(10,2) DEFAULT NULL,
  `zn` decimal(10,2) DEFAULT NULL,
  `ca` decimal(10,2) DEFAULT NULL,
  `mg` decimal(10,2) DEFAULT NULL,
  `s` decimal(10,2) DEFAULT NULL,
  `b` decimal(10,2) DEFAULT NULL,
  `mo` decimal(10,2) DEFAULT NULL,
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `semiwholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `currency`, `language_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Sierra Leone', 'SLE', 'SLL', NULL, NULL, '2025-10-01 01:33:13', '2025-10-01 01:33:13'),
(2, 'Ivory Coast', 'CL', 'XOF', NULL, NULL, '2025-10-01 01:33:13', '2025-10-01 01:33:13'),
(12, 'Senegal', 'SE', 'USD', NULL, NULL, '2026-02-11 00:37:38', '2026-04-06 17:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `usertype_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `usertype_id`, `country_id`, `file_path`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'tets', 3, NULL, 'documents/tets_1763111665.pdf', NULL, '2025-11-14 16:14:25', '2025-11-14 16:14:25'),
(3, 'eflk', 3, NULL, 'documents/eflk_1764302536.pdf', NULL, '2025-11-28 11:02:16', '2025-11-28 11:02:16'),
(4, 'test', 1, NULL, 'documents/test_1766383407.pdf', NULL, '2025-12-22 13:03:27', '2025-12-22 13:03:27'),
(5, 'test', 2, 1, 'documents/test_1766459543.pdf', NULL, '2025-12-23 10:12:23', '2025-12-23 10:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `enqerytype`
--

CREATE TABLE `enqerytype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enqerytype`
--

INSERT INTO `enqerytype` (`id`, `name`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'Price Request', 1, '2025-12-01 11:21:28', '2025-12-01 11:21:28'),
(2, 'Availability Request', 1, '2025-12-01 11:21:28', '2025-12-01 11:21:28'),
(3, 'Other', 1, '2025-12-01 11:21:28', '2025-12-01 11:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_messages`
--

CREATE TABLE `enquiry_messages` (
  `id` int(11) NOT NULL,
  `enquiry_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('farmer','supplier') NOT NULL,
  `customer_inqer` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seen_by_farmer` tinyint(1) DEFAULT 0,
  `seen_by_supplier` tinyint(1) DEFAULT 0,
  `seen_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
-- Table structure for table `farmer_enquiries`
--

CREATE TABLE `farmer_enquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `enquiry_type` int(11) NOT NULL,
  `customer_inqer` varchar(255) DEFAULT NULL,
  `supplier_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`supplier_id`)),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `language_id` int(11) NOT NULL DEFAULT 1,
  `seen_by_farmer` tinyint(1) DEFAULT 0,
  `seen_by_supplier` tinyint(1) DEFAULT 0,
  `seen_at` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `reply_message` text DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `like_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = no action, 1 = like, 2 = dislike'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer_enquiries`
--

INSERT INTO `farmer_enquiries` (`id`, `name`, `email`, `mobile_no`, `enquiry_type`, `customer_inqer`, `supplier_id`, `status`, `language_id`, `seen_by_farmer`, `seen_by_supplier`, `seen_at`, `description`, `image`, `pdf`, `reply_message`, `replied_at`, `created_by`, `created_at`, `updated_at`, `like_status`) VALUES
(82, 'farmer1', 'farmer@gmail.com', '89595988659898', 3, '2', '[-1]', 0, 2, 0, 0, NULL, 'Ce produit est ii disponible?', NULL, NULL, NULL, NULL, 194, '2026-02-10 23:50:45', '2026-02-10 23:50:45', 0),
(83, 'Ado', 'adinbloukounon@gmail.com', '00221773887212', 8, '2', '[-1]', 0, 2, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 197, '2026-02-11 01:04:54', '2026-02-11 01:04:54', 0),
(84, 'farmer1', 'farmer@gmail.com', '89595988659898', 8, '2', '[-1]', 0, 2, 0, 0, NULL, 'A qui envoyer la commade', NULL, NULL, NULL, NULL, 194, '2026-02-11 01:05:57', '2026-02-11 01:05:57', 0),
(85, 'test1 test 1', 'avialex85@gmail.com', '7042031901', 8, '2', '[191]', 0, 1, 0, 1, '2026-04-02 09:29:47', 'gchchvjvkbkbkbjc tpugkgigoy fjgigig', 'uploads/enquiry_images/TUkYKrsfk16mAcREH6iqVja0NYbSIr83bvktAKFw.jpg', NULL, NULL, NULL, 198, '2026-03-14 12:02:36', '2026-04-02 16:29:47', 0),
(86, 'farmer1', 'farmer@gmail.com', '89595988659898', 2, '2', '[-1]', 0, 1, 0, 0, NULL, 'Hye I want buy this product', NULL, NULL, NULL, NULL, 194, '2026-05-20 22:32:25', '2026-05-20 22:32:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `form_structures`
--

CREATE TABLE `form_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `form_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`form_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Images`
--

INSERT INTO `Images` (`id`, `parent_id`, `name`, `description`, `image_path`) VALUES
(11, NULL, 'test', 'sdcds', '[\"https:\\/\\/fivoflow.com\\/wclm\\/public\\/uploads\\/1765780484_UF124SJ.jpg\",\"https:\\/\\/fivoflow.com\\/wclm\\/public\\/uploads\\/1765780490_UF1233O.jpg\",\"https:\\/\\/fivoflow.com\\/wclm\\/public\\/uploads\\/1765780495_UF141SV.jpg\"]');

-- --------------------------------------------------------

--
-- Table structure for table `inorganic_soil_conditioners`
--

CREATE TABLE `inorganic_soil_conditioners` (
  `id` int(11) NOT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `conditioner_type` varchar(255) NOT NULL,
  `form_type` varchar(50) NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `physical_form` varchar(50) NOT NULL,
  `trade_name` varchar(255) NOT NULL,
  `raw_material` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `wholesale_price` decimal(10,2) NOT NULL,
  `semiwholesale_price` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inorganic_soil_conditioners`
--

INSERT INTO `inorganic_soil_conditioners` (`id`, `localProductName`, `parent_id`, `live_id`, `conditioner_type`, `form_type`, `product_id`, `product_master_id`, `physical_form`, `trade_name`, `raw_material`, `other`, `function`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `qr_code_path`, `created_by`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(80, NULL, NULL, 0, 'Lime', 'inorganic_soil_conditioner', 4, NULL, 'Liquid', 'SoilFix Lime', 'Limestone', 'pH correction', 'pH correction', 6500.00, 6500.00, 6500.00, NULL, 1, 191, NULL, 1, NULL, '2025-12-15 17:17:37', '2025-12-22 10:07:06', NULL),
(100032, NULL, NULL, 0, 'Gypsum', 'inorganic_soil_conditioner', 4, NULL, 'Powder', 'Soil Boost', 'Calcium', NULL, 'Improve soil', 100.00, 115.00, 130.00, 'qrcodes/inorganic_100032.png', 1, 191, 1, 1, NULL, '2025-12-24 16:42:22', '2025-12-24 16:42:22', 'uploads/inorganic_soil_conditioner/inorganic_1766569342_694bb57e96184.png'),
(100033, NULL, 100032, 0, 'Gypsum gride', 'inorganic_soil_conditioner', 4, NULL, 'Powder', 'Soil Boost', 'Calcium', NULL, 'Improve soil', 100.00, 115.00, 130.00, 'qrcodes/inorganic_100033.png', 1, 191, 1, 1, NULL, '2025-12-24 16:42:57', '2025-12-24 16:42:57', 'uploads/inorganic_soil_conditioner/inorganic_1766569377_694bb5a174d26.png');

-- --------------------------------------------------------

--
-- Table structure for table `inorganic_soil_conditioner_fields`
--

CREATE TABLE `inorganic_soil_conditioner_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('text','number','select') NOT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inorganic_soil_conditioner_fields`
--

INSERT INTO `inorganic_soil_conditioner_fields` (`id`, `label`, `name`, `type`, `options`, `required`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Conditioner Type', 'conditioner_type', 'text', NULL, 1, 1, NULL, NULL),
(2, 'Physical Form', 'physical_form', 'select', '[\"Liquid\",\"Solid\",\"Powder\"]', 1, 1, NULL, NULL),
(3, 'Trade Name', 'trade_name', 'text', NULL, 1, 1, NULL, NULL),
(4, 'Raw Material', 'raw_material', 'select', '[\"Limestone\",\"Slate\",\"Gypsum\",\"Glauconite\",\"Other\"]', 0, 1, NULL, NULL),
(5, 'Other', 'other', 'text', NULL, 0, 1, NULL, NULL),
(6, 'Function', 'function', 'text', NULL, 0, 1, NULL, NULL),
(7, 'Average Wholesale Price', 'wholesale_price', 'number', NULL, 1, 1, NULL, NULL),
(8, 'Average Semi-Wholesale Price', 'semiwholesale_price', 'number', NULL, 1, 1, NULL, NULL),
(9, 'Average Retail Price', 'retail_price', 'number', NULL, 1, 1, NULL, NULL),
(10, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', '', NULL, 0, 1, NULL, NULL),
(11, 'Local produt name', 'localProductName', 'text', NULL, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inorganic_soil_conditioner_translations`
--

CREATE TABLE `inorganic_soil_conditioner_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inorganic_soil_conditioner_id` int(11) NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `conditioner_type` varchar(255) DEFAULT NULL,
  `physical_form` varchar(50) DEFAULT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `raw_material` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `semiwholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `lang_code` varchar(5) NOT NULL,
  `lang_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `lang_code`, `lang_name`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', NULL, NULL),
(2, 'fr', 'French', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_admin`
--

CREATE TABLE `master_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_admin`
--

INSERT INTO `master_admin` (`id`, `name`, `email`, `phone`, `language_id`, `country_id`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '08800658501', NULL, NULL, '$2y$12$kY38Lnz1b8wdiqb6pLfMROjETe/3aXpN8LCWLhtRIlQQvSGGaho9C', '2025-10-25 15:09:45', '2025-11-27 18:14:35'),
(3, 'country', 'country@gmail.com', NULL, NULL, 2, '$2y$12$VIrI3dDHoCdWOH08yScAwOaMyappG4TroLdN1HW9JFrZx5LjG8kz2', '2025-11-22 17:38:42', '2025-11-22 17:38:42'),
(9, 'conuntry', 'country1@gmail.com', '9971827689', NULL, 2, '$2y$12$pXz2XCLhlBMvFX7b7i296.2a3hgHLHXWsnjy.I/NzNa/2.S7RyFSK', '2025-12-22 12:57:00', '2025-12-22 12:57:00');

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
(4, '2025_10_01_011445_add_username_to_users_table', 2),
(5, '2025_10_01_011524_create_usertype_table', 3),
(6, '2025_10_01_011613_add_usertype_id_to_users_table', 4),
(7, '2025_10_01_011702_create_countries_table', 5),
(8, '2025_10_01_011818_add_country_id_to_users_table', 6),
(9, '2025_10_01_021935_create_type_table', 7),
(10, '2025_10_01_024138_add_createdby_status_to_announcements_table', 8),
(11, '2025_10_01_025128_create_suppliers_table', 9),
(12, '2025_10_01_030011_add_details_to_suppliers_table', 10),
(13, '2025_10_01_030531_create_agents_table', 11),
(14, '2025_10_01_113253_create_languages_table', 12),
(15, '2025_10_01_113834_add_language_id_to_users_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `mineral_fertilizers`
--

CREATE TABLE `mineral_fertilizers` (
  `id` int(11) NOT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) NOT NULL DEFAULT 'mineral_fertilizer',
  `title` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `fertilizer_type` varchar(255) NOT NULL,
  `fertilizer_registration` varchar(255) NOT NULL,
  `physical_form` varchar(50) NOT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `n` decimal(5,2) DEFAULT NULL,
  `p2` decimal(5,2) DEFAULT NULL,
  `k2` decimal(5,2) DEFAULT NULL,
  `zn` decimal(5,2) DEFAULT NULL,
  `ca` decimal(5,2) DEFAULT NULL,
  `mg` decimal(5,2) DEFAULT NULL,
  `s` decimal(5,2) DEFAULT NULL,
  `b` decimal(5,2) DEFAULT NULL,
  `mo` decimal(5,2) DEFAULT NULL,
  `application_rate` varchar(255) DEFAULT NULL,
  `fertilizer_wholesale_price` decimal(10,2) NOT NULL,
  `fertilizer_semiwholesale_price` decimal(10,2) NOT NULL,
  `fertilizer_retail_price` decimal(10,2) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mineral_fertilizers`
--

INSERT INTO `mineral_fertilizers` (`id`, `localProductName`, `parent_id`, `live_id`, `form_type`, `title`, `product_id`, `product_master_id`, `fertilizer_type`, `fertilizer_registration`, `physical_form`, `trade_name`, `n`, `p2`, `k2`, `zn`, `ca`, `mg`, `s`, `b`, `mo`, `application_rate`, `fertilizer_wholesale_price`, `fertilizer_semiwholesale_price`, `fertilizer_retail_price`, `qr_code_path`, `created_by`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `language_id`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(100050, NULL, NULL, 0, 'mineral_fertilizers', '', 7, NULL, 'mineral', '12434', 'Solid granules', 'urea', 67.00, 676.00, 122.00, 32.00, 22.00, 434.00, 33.00, 3.00, 55.00, '10', 34.00, 200.00, 100.00, NULL, 1, 191, 1, 1, NULL, 1, '2025-12-23 18:26:20', '2025-12-23 18:26:20', 'uploads/mineral_fertilizer/fertilizer_1766489180_694a7c5c88725.png'),
(100051, NULL, NULL, 0, 'mineral_fertilizers', '', 7, NULL, 'mineral', '12434', 'Solid granules', 'urea', 67.00, 676.00, 122.00, 32.00, 22.00, 434.00, 33.00, 3.00, 55.00, '10', 34.00, 200.00, 100.00, NULL, 1, 191, 1, 1, NULL, 1, '2025-12-23 18:29:11', '2025-12-23 18:29:11', 'uploads/mineral_fertilizer/fertilizer_1766489351_694a7d078052c.png'),
(100057, NULL, NULL, 0, 'mineral_fertilizer', NULL, 7, NULL, 'mineral', '12434', 'Solid granules', 'urea', 67.00, 676.00, 122.00, 32.00, 22.00, 434.00, 33.00, 3.00, 55.00, '10', 34.00, 200.00, 100.00, 'qrcodes/fertilizer_100057.png', 1, 1, 1, 1, NULL, 1, '2025-12-26 15:27:09', '2026-04-02 09:45:47', 'uploads/mineral_fertilizer/fertilizer_1766737629_694e46ddd850c.png'),
(100058, NULL, 100057, 0, 'mineral_fertilizer', NULL, 7, NULL, 'mineral', '12434', 'Solid granules', 'urea', 67.00, 676.00, 122.00, 32.00, 22.00, 434.00, 33.00, 3.00, 55.00, '10', 340.00, 200.00, 100.00, 'qrcodes/fertilizer_100058.png', 1, 191, 1, 1, NULL, 1, '2025-12-26 15:28:07', '2025-12-26 15:28:07', 'uploads/mineral_fertilizer/fertilizer_1766737687_694e471719f3a.png');

-- --------------------------------------------------------

--
-- Table structure for table `mineral_fertilizer_fields`
--

CREATE TABLE `mineral_fertilizer_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('text','number','select') NOT NULL DEFAULT 'text',
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mineral_fertilizer_fields`
--

INSERT INTO `mineral_fertilizer_fields` (`id`, `label`, `name`, `type`, `options`, `required`, `created_at`, `updated_at`) VALUES
(1, 'Brand Name', 'brand_name', 'text', NULL, 1, NULL, NULL),
(2, 'Composition', 'composition', 'text', NULL, 1, NULL, NULL),
(3, 'Manufacturing Date', 'mfg_date', 'text', NULL, 0, NULL, NULL),
(4, 'Expiry Date', 'expiry_date', 'text', NULL, 0, NULL, NULL),
(5, 'Packaging Size (Kg/Ltr)', 'pack_size', 'number', NULL, 0, NULL, NULL),
(6, 'Organic/Inorganic', 'organic_type', 'select', '[\"Organic\",\"Inorganic\"]', 1, NULL, NULL),
(7, 'Price', 'price', 'number', NULL, 1, NULL, NULL),
(8, 'Type of fertilizer', 'fertilizer_type', 'text', NULL, 1, NULL, NULL),
(9, 'Registration number', 'fertilizer_registration', 'text', NULL, 1, NULL, NULL),
(10, 'Physical form', 'physical_form', 'select', '[\"Liquid\",\"Solid granules\",\"Powder\"]', 1, NULL, NULL),
(11, 'Trade name', 'trade_name', 'text', NULL, 0, NULL, NULL),
(12, '% N', 'n', 'text', NULL, 0, NULL, NULL),
(13, '% P205', 'p2', 'number', NULL, 0, NULL, NULL),
(14, '% K20', 'k2', 'number', NULL, 0, NULL, NULL),
(15, '% Zn', 'zn', 'text', NULL, 0, NULL, NULL),
(16, '% Ca', 'ca', 'text', NULL, 0, NULL, NULL),
(17, '% Mg', 'mg', 'text', NULL, 0, NULL, NULL),
(18, '% S', 's', 'text', NULL, 0, NULL, NULL),
(19, '% B', 'b', 'text', NULL, 0, NULL, NULL),
(20, '% Mo', 'mo', 'text', NULL, 0, NULL, NULL),
(21, 'Application rate per hectare', 'application_rate', 'text', NULL, 0, NULL, NULL),
(22, 'Average wholesale prices', 'fertilizer_wholesale_price', 'text', NULL, 1, NULL, NULL),
(23, 'Average semi-wholesalers price', 'fertilizer_semiwholesale_price', 'text', NULL, 1, NULL, NULL),
(24, 'Average retail prices', 'fertilizer_retail_price', 'text', NULL, 1, NULL, NULL),
(25, 'Local produt name', 'localProductName', 'text', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mineral_fertilizer_translations`
--

CREATE TABLE `mineral_fertilizer_translations` (
  `id` int(11) NOT NULL,
  `mineral_fertilizer_id` int(11) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `fertilizer_type` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `fertilizer_registration` varchar(255) NOT NULL,
  `physical_form` varchar(50) NOT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `application_rate` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mineral_fertilizer_translations`
--

INSERT INTO `mineral_fertilizer_translations` (`id`, `mineral_fertilizer_id`, `language_id`, `fertilizer_type`, `title`, `fertilizer_registration`, `physical_form`, `trade_name`, `application_rate`, `supplier_id`, `agent_id`, `created_by`, `created_at`, `updated_at`) VALUES
(33, 26, 2, 'NPK', 'Super Growth Fertilizer', 'REG12345', 'Granular', 'SuperGrow', '50kg/ha', 5, 3, NULL, '2025-10-18 09:16:23', '2025-10-18 09:16:23'),
(34, 27, 1, 'NPK', 'Super Growth Fertilizer', 'REG12345', 'Granular', 'SuperGrow', '50kg/ha', 5, 3, NULL, '2025-10-18 09:30:53', '2025-10-18 09:30:53'),
(35, 33, 1, 'NPK', 'Default Fertilizer', 'REG12345', 'Granular', 'SuperGrow', '50kg/ha', 5, 3, NULL, '2025-10-18 09:36:32', '2025-10-18 09:36:32'),
(36, 35, 1, 'NPK', NULL, 'REG12345', 'Granular', 'SuperGrow', '50kg/ha', 5, 3, NULL, '2025-10-18 09:41:13', '2025-10-18 09:41:13'),
(37, 36, 1, 'NPK', NULL, 'REG12345', 'Granular', 'SuperGrow', '50kg/ha', 5, 3, NULL, '2025-10-18 09:47:54', '2025-10-18 09:47:54'),
(38, 41, 1, 'all', NULL, '85', 'Powder', '12', '12', NULL, NULL, 80, '2025-10-23 16:46:36', '2025-10-23 16:46:36'),
(39, 41, 2, 'tous', NULL, '85', 'Poudre', '12', '12', NULL, NULL, 80, '2025-10-23 16:46:38', '2025-10-23 16:46:38'),
(40, 52, 1, 'red', NULL, 'r85', 'Solid granules', '1', '1', NULL, NULL, 1, '2025-10-25 11:02:37', '2025-10-25 11:02:37'),
(41, 52, 2, 'rouge', NULL, 'r85', 'Granulés solides', '1', '1', NULL, NULL, 1, '2025-10-25 11:02:40', '2025-10-25 11:02:40'),
(42, 57, 1, '1', NULL, '1', 'Liquid', '1', '1', 57, 6, 1, '2025-11-04 19:46:09', '2025-11-04 19:46:09'),
(43, 57, 2, '1', NULL, '1', 'Liquide', '1', '1', 57, 6, 1, '2025-11-04 19:46:10', '2025-11-04 19:46:10'),
(44, 58, 1, '1', NULL, '1', 'Liquid', '1', '1', 73, NULL, 1, '2025-11-05 19:05:12', '2025-11-05 19:05:12'),
(45, 58, 2, '1', NULL, '1', 'Liquide', '1', '1', 73, NULL, 1, '2025-11-05 19:05:12', '2025-11-05 19:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0 COMMENT '0 = unread, 1 = read',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(26, 'New Bio Stimulant Added', 'Bio Stimulant yene has been added.', 1, '2025-12-08 20:48:32', '2025-12-10 10:23:46'),
(27, 'New Inorganic Soil Conditioner Added', 'Product Yene has been added.', 1, '2025-12-08 21:17:52', '2025-12-10 10:12:58'),
(28, 'New Mineral Fertilizer Added', 'Mineral Fertilizer tea has been added.', 1, '2025-12-08 21:21:04', '2025-12-10 10:15:51'),
(29, 'New Organic Amendment Added', 'Organic Amendment 838 has been added.', 1, '2025-12-08 22:24:09', '2025-12-09 10:04:49'),
(30, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-08 23:55:00', '2025-12-09 10:04:54'),
(31, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:03:11', '2025-12-09 10:05:00'),
(32, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:11:42', '2025-12-09 10:05:02'),
(33, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:16:14', '2025-12-09 10:05:11'),
(34, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:26:03', '2025-12-09 10:05:14'),
(35, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:26:18', '2025-12-09 10:05:09'),
(36, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-09 00:26:19', '2025-12-09 10:04:20'),
(37, 'New Organic Amendment Added', 'Organic Amendment Yene has been added.', 1, '2025-12-09 01:01:15', '2025-12-10 09:23:12'),
(38, 'New Veterinary Product Added', 'Product name1 has been added.', 1, '2025-12-09 01:23:05', '2025-12-10 09:22:48'),
(39, 'New Synthetic Pesticide Added', 'Pesticide synthetic has been added.', 1, '2025-12-09 01:26:13', '2025-12-10 09:27:03'),
(40, 'New Bio Stimulant Added', 'Bio Stimulant biosimulants has been added.', 1, '2025-12-09 01:29:49', '2025-12-09 10:04:12'),
(41, 'New Mineral Fertilizer Added', 'Mineral Fertilizer urea has been added.', 1, '2025-12-09 01:31:11', '2025-12-10 09:16:57'),
(42, 'New Animal Feed Added', 'Animal Feed 300 has been added.', 1, '2025-12-09 01:34:34', '2025-12-09 10:03:51'),
(43, 'New Product Added', 'Add product maize - seed variety has been added.', 1, '2025-12-09 01:40:44', '2025-12-09 10:05:23'),
(44, 'New Product Added', 'Add product maize - seed variety has been added.', 1, '2025-12-09 01:40:55', '2025-12-09 10:04:04'),
(45, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-09 02:07:18', '2025-12-09 13:56:46'),
(46, 'New Animal Feed Added', 'Animal Feed animal has been added.', 1, '2025-12-09 12:41:09', '2025-12-09 13:56:43'),
(47, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-09 23:38:37', '2025-12-10 09:31:40'),
(48, 'New Animal Feed Added', 'Animal Feed 345 has been added.', 1, '2025-12-10 00:34:32', '2025-12-10 09:31:33'),
(49, 'New Organic Amendment Added', 'Organic Amendment yene has been added.', 1, '2025-12-10 00:38:42', '2025-12-10 10:09:52'),
(50, 'New Product Added', 'Add product maize - high has been added.', 1, '2025-12-10 00:39:50', '2025-12-10 11:21:18'),
(51, 'New Mineral Fertilizer Added', 'Mineral Fertilizer urea has been added.', 1, '2025-12-10 00:40:31', '2025-12-10 09:32:20'),
(52, 'New Synthetic Pesticide Added', 'Pesticide loris has been added.', 1, '2025-12-10 01:14:44', '2025-12-10 09:32:23'),
(53, 'New Organic Amendment Added', 'Organic Amendment ye has been added.', 1, '2025-12-10 01:43:12', '2025-12-10 09:32:26'),
(54, 'New Organic Amendment Added', 'Organic Amendment ABC Brand has been added.', 1, '2025-12-10 02:27:55', '2025-12-10 09:43:37'),
(55, 'New Inorganic Soil Conditioner Added', 'Product test has been added.', 1, '2025-12-10 02:35:01', '2025-12-10 10:07:26'),
(56, 'New Inorganic Soil Conditioner Added', 'Product test has been added.', 1, '2025-12-10 02:35:01', '2025-12-10 10:08:04'),
(57, 'New Product Added', 'Add product seedsuuplier - 829 has been added.', 1, '2025-12-10 11:33:56', '2025-12-11 09:28:45'),
(58, 'New Animal Feed Added', 'Animal Feed jdn has been added.', 1, '2025-12-10 11:35:15', '2025-12-11 09:28:39'),
(59, 'New Synthetic Pesticide Added', 'Pesticide 9282 has been added.', 1, '2025-12-10 11:36:16', '2025-12-11 09:28:36'),
(60, 'New Inorganic Soil Conditioner Added', 'Product ndnd has been added.', 1, '2025-12-10 11:37:13', '2025-12-11 09:28:33'),
(61, 'New Organic Amendment Added', 'Organic Amendment dbd has been added.', 1, '2025-12-10 11:39:55', '2025-12-11 09:28:26'),
(62, 'New Veterinary Product Added', 'Product ndnd has been added.', 1, '2025-12-10 11:42:24', '2025-12-11 09:28:24'),
(63, 'New Bio Stimulant Added', 'Bio Stimulant govdhan has been added.', 1, '2025-12-10 12:22:25', '2025-12-11 09:28:48'),
(64, 'New Bio Stimulant Added', 'Bio Stimulant govdhan has been added.', 1, '2025-12-10 12:22:28', '2025-12-11 09:28:31'),
(65, 'New Mineral Fertilizer Added', 'Mineral Fertilizer SuperGrow has been added.', 1, '2025-12-10 12:23:30', '2025-12-11 09:28:18'),
(66, 'New Mineral Fertilizer Added', 'Mineral Fertilizer SuperGrow has been added.', 1, '2025-12-10 12:26:01', '2025-12-11 09:28:15'),
(67, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-10 12:33:05', '2025-12-11 09:28:41'),
(68, 'New Product Added', 'Add product orange - high qbs has been added.', 1, '2025-12-10 12:46:29', '2025-12-11 09:28:10'),
(69, 'New Mineral Fertilizer Added', 'Mineral Fertilizer kci has been added.', 1, '2025-12-10 12:48:47', '2025-12-11 09:28:03'),
(70, 'New Veterinary Product Added', 'Product test has been added.', 1, '2025-12-10 15:55:07', '2025-12-11 09:28:00'),
(71, 'New Synthetic Pesticide Added', 'Pesticide gene has been added.', 1, '2025-12-13 18:28:06', '2025-12-13 20:05:19'),
(72, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-14 22:29:25', '2025-12-15 08:09:09'),
(73, 'New Veterinary Product Added', 'Product VetoGuard Oxytetracycline 20% has been added.', 1, '2025-12-15 16:34:06', '2025-12-15 16:35:30'),
(74, 'New Product Added', 'Add product Maize - Debanyuman Hybrid 12 has been added.', 1, '2025-12-15 16:54:46', '2025-12-15 16:55:36'),
(75, 'New Organic Amendment Added', 'Organic Amendment AgroCompost Plus has been added.', 1, '2025-12-15 17:13:05', '2025-12-15 17:14:41'),
(76, 'New Animal Feed Added', 'Animal Feed yuuu has been added.', 1, '2025-12-15 18:37:22', '2025-12-15 20:22:39'),
(77, 'New Veterinary Product Added', 'Product hdh has been added.', 1, '2025-12-15 18:56:52', '2025-12-15 19:04:54'),
(78, 'New Animal Feed Added', 'Animal Feed dj has been added.', 1, '2025-12-16 17:38:15', '2025-12-17 09:12:52'),
(79, 'New Animal Feed Added', 'Animal Feed 99 has been added.', 1, '2025-12-16 17:48:42', '2025-12-17 09:12:42'),
(80, 'New Inorganic Soil Conditioner Added', 'Product dhd has been added.', 1, '2025-12-16 18:02:04', '2025-12-17 09:12:39'),
(81, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-16 18:33:26', '2025-12-17 09:12:35'),
(82, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-16 18:38:29', '2025-12-17 09:12:16'),
(83, 'New Organic Amendment Added', 'Organic Amendment 13 has been added.', 1, '2025-12-16 18:43:35', '2025-12-17 09:12:31'),
(84, 'New Organic Amendment Added', 'Organic Amendment 1 has been added.', 1, '2025-12-16 18:51:45', '2025-12-17 09:12:28'),
(85, 'New Synthetic Pesticide Added', 'Pesticide 1111 has been added.', 1, '2025-12-16 19:16:00', '2025-12-17 09:12:26'),
(86, 'New Veterinary Product Added', 'Product 1 has been added.', 1, '2025-12-16 19:27:43', '2025-12-17 09:12:21'),
(87, 'New Veterinary Product Added', 'Product prod has been added.', 1, '2025-12-18 15:32:10', '2025-12-19 09:49:41'),
(88, 'New Animal Feed Added', 'Animal Feed input has been added.', 1, '2025-12-18 15:32:51', '2025-12-19 09:49:52'),
(89, 'New Product Added', 'Add product Maize - red has been added.', 1, '2025-12-19 02:34:39', '2025-12-19 09:49:49'),
(90, 'New Veterinary Product Added', 'Product bdb has been added.', 1, '2025-12-19 10:02:18', '2025-12-19 10:40:17'),
(91, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-19 10:19:14', '2025-12-19 10:40:14'),
(92, 'New Animal Feed Added', 'Animal Feed 838 has been added.', 1, '2025-12-19 10:27:41', '2025-12-19 10:40:09'),
(93, 'New Organic Amendment Added', 'Organic Amendment 1 has been added.', 1, '2025-12-19 10:32:34', '2025-12-19 10:40:06'),
(94, 'New Synthetic Pesticide Added', 'Pesticide 1111 has been added.', 1, '2025-12-19 10:35:49', '2025-12-19 10:40:02'),
(95, 'New Veterinary Product Added', 'Product 1 has been added.', 1, '2025-12-19 10:38:11', '2025-12-19 10:39:59'),
(96, 'New Animal Feed Added', 'Animal Feed animal geed has been added.', 1, '2025-12-19 14:10:32', '2025-12-19 17:35:33'),
(97, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-19 20:50:25', '2025-12-19 20:50:49'),
(98, 'New Animal Feed Added', 'Animal Feed inp has been added.', 1, '2025-12-20 14:48:42', '2025-12-24 12:13:29'),
(99, 'New Agent Created', 'Agent test has been added.', 1, '2025-12-22 12:54:25', '2025-12-22 12:55:58'),
(100, 'New Veterinary Product Added', 'Product 12 has been added.', 1, '2025-12-22 13:29:51', '2025-12-22 13:30:11'),
(101, 'New Animal Feed Added', 'Animal Feed jd has been added.', 1, '2025-12-22 13:39:46', '2025-12-22 13:39:56'),
(102, 'New Veterinary Product Added', 'Product vet has been added.', 1, '2025-12-22 17:55:14', '2025-12-24 12:13:27'),
(103, 'New Veterinary Product Added', 'Product hd has been added.', 1, '2025-12-22 18:11:19', '2025-12-22 18:31:24'),
(104, 'New Synthetic Pesticide Added', 'Pesticide 35d has been added.', 1, '2025-12-22 18:17:00', '2025-12-24 12:13:25'),
(105, 'New Organic Amendment Added', 'Organic Amendment ey has been added.', 1, '2025-12-22 18:20:53', '2025-12-24 12:13:22'),
(106, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 18:56:23', '2025-12-24 12:13:20'),
(107, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 19:39:07', '2025-12-24 12:13:17'),
(108, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 19:45:28', '2025-12-23 19:34:19'),
(109, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 19:46:18', '2025-12-23 19:31:18'),
(110, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 19:52:19', '2025-12-23 18:30:03'),
(111, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 has been added.', 1, '2025-12-22 19:57:23', '2025-12-23 18:29:58'),
(112, 'New Mineral Fertilizer Added', 'Mineral Fertilizer 1 added.', 1, '2025-12-22 20:01:52', '2025-12-23 17:59:42'),
(113, 'New Product Added', 'Add product tamto - Hybrid-101 has been added.', 1, '2025-12-24 16:06:11', '2025-12-24 16:45:39'),
(114, 'New Animal Feed Added', 'Animal Feed Premium Cow Feed has been added.', 1, '2025-12-24 16:20:50', '2025-12-24 16:28:12'),
(115, 'New Product Added', 'Product  added.', 1, '2025-12-24 16:58:05', '2025-12-27 12:18:57'),
(116, 'Product Update Pending', 'Product  update sent for approval.', 1, '2025-12-24 16:58:53', '2025-12-27 12:19:12'),
(117, 'New Organic Amendment Added', 'Organic Amendment GreenBoost has been added.', 1, '2025-12-24 17:14:39', '2025-12-27 12:19:07'),
(118, 'New Synthetic Pesticide Added', 'Pesticide Super Pesticide has been added.', 1, '2025-12-24 17:25:21', '2025-12-27 12:19:09'),
(119, 'New Veterinary Product Added', 'Product SuperVet has been added.', 1, '2025-12-24 17:34:57', '2025-12-27 12:18:52'),
(120, 'Synthetic Pesticide Updated', 'Pesticide Super Pesticide has been updated.', 1, '2025-12-24 17:43:20', '2025-12-27 12:19:04'),
(121, 'Veterinary Product Updated', 'Product SuperVet has been updated.', 1, '2025-12-24 17:51:29', '2025-12-27 12:18:50'),
(122, 'Product Update Pending', 'Product  update sent for approval. Live ID: ', 1, '2025-12-24 18:15:30', '2025-12-27 12:19:02'),
(123, 'New Product Added', 'Product  added.', 1, '2025-12-26 15:27:09', '2025-12-27 12:18:47'),
(124, 'Product Update Pending', 'Product  update sent for approval.', 1, '2025-12-26 15:28:07', '2025-12-27 12:19:00'),
(125, 'New Animal Feed Added', 'Animal Feed 666 has been added.', 1, '2026-02-11 00:01:34', '2026-02-11 00:07:00'),
(126, 'New Animal Feed Added', 'Animal Feed 46 has been added.', 1, '2026-03-04 01:57:01', '2026-03-06 16:52:53'),
(127, 'New Animal Feed Added', 'Animal Feed 443 has been added.', 1, '2026-03-04 04:14:42', '2026-03-06 16:52:50'),
(128, 'New Veterinary Product Added', 'Product Fede has been added.', 1, '2026-03-07 02:52:04', '2026-03-07 10:15:35'),
(129, 'New Veterinary Product Added', 'Product dad has been added.', 1, '2026-03-07 02:56:24', '2026-03-07 10:15:32'),
(130, 'New Veterinary Product Added', 'Product ddd has been added.', 1, '2026-03-07 13:11:07', '2026-03-11 11:59:02'),
(131, 'New Animal Feed Added', 'Animal Feed ghj has been added.', 1, '2026-03-07 23:44:19', '2026-03-10 11:52:01'),
(132, 'New Veterinary Product Added', 'Product dhu has been added.', 1, '2026-03-13 17:00:29', '2026-03-17 11:34:54'),
(133, 'New Veterinary Product Added', 'Product 55 has been added.', 1, '2026-03-13 18:02:22', '2026-03-17 11:34:50'),
(134, 'New Veterinary Product Added', 'Product test has been added.', 1, '2026-04-03 17:45:06', '2026-04-03 21:00:42'),
(135, 'New Animal Feed Added', 'Animal Feed 2 has been added.', 1, '2026-04-03 18:09:31', '2026-04-03 21:00:38'),
(136, 'New Veterinary Product Added', 'Product twudbdu has been added.', 1, '2026-04-03 18:16:41', '2026-04-03 21:00:33'),
(137, 'New Veterinary Product Added', 'Product twudbdu has been added.', 1, '2026-04-03 18:17:05', '2026-04-03 21:00:30'),
(138, 'New Animal Feed Added', 'Animal Feed 6282 has been added.', 1, '2026-04-03 18:21:53', '2026-04-03 21:00:45'),
(139, 'New Synthetic Pesticide Added', 'Pesticide new has been added.', 1, '2026-04-03 18:30:31', '2026-04-03 21:00:27'),
(140, 'New Veterinary Product Added', 'Product 82838 has been added.', 1, '2026-04-03 19:26:27', '2026-04-03 21:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `onboarding_contents`
--

CREATE TABLE `onboarding_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title1` varchar(255) NOT NULL,
  `title2` varchar(255) NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `onboarding_contents`
--

INSERT INTO `onboarding_contents` (`id`, `title1`, `title2`, `language_id`, `image`, `created_at`, `updated_at`) VALUES
(5, 'Track Your\\nFarm\\n', 'Using Waima', 1, '1762174354.png', '2025-11-03 19:52:34', '2025-11-03 19:52:34'),
(6, 'Track Your\\nFarm\\n', '3', 1, '1762175183.jpg', '2025-11-03 20:06:23', '2025-11-03 20:06:23'),
(7, 'Track Your\\nFarm\\n', '3', 1, '1762175416.jpg', '2025-11-03 20:10:16', '2025-11-03 20:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'pending', 1, '2025-12-18 08:57:53', '2025-12-18 08:57:53'),
(2, 'confirmed', 1, '2025-12-18 08:57:53', '2025-12-18 08:57:53'),
(3, 'rejected', 1, '2025-12-18 08:57:53', '2025-12-18 08:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `organic_amendments`
--

CREATE TABLE `organic_amendments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `organic_type` varchar(255) NOT NULL,
  `physical_form` varchar(255) NOT NULL,
  `trade_name` varchar(255) NOT NULL,
  `country_origin` varchar(255) NOT NULL,
  `bio_label` varchar(255) NOT NULL,
  `n` int(11) NOT NULL DEFAULT 0,
  `p2` int(11) NOT NULL DEFAULT 0,
  `k2` int(11) NOT NULL DEFAULT 0,
  `cao` int(11) NOT NULL DEFAULT 0,
  `mgo` int(11) NOT NULL DEFAULT 0,
  `cn_ratio` varchar(255) DEFAULT NULL,
  `raw_material` longtext NOT NULL DEFAULT '[]',
  `raw_material_other` varchar(255) DEFAULT NULL,
  `arsenic_content` varchar(50) DEFAULT NULL,
  `copper_content` varchar(10) DEFAULT NULL,
  `chromium_content` varchar(10) DEFAULT NULL,
  `lead_content` decimal(10,2) DEFAULT NULL,
  `wholesale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `semiwholesale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `retail_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organic_amendments`
--

INSERT INTO `organic_amendments` (`id`, `localProductName`, `parent_id`, `live_id`, `form_type`, `product_id`, `product_master_id`, `organic_type`, `physical_form`, `trade_name`, `country_origin`, `bio_label`, `n`, `p2`, `k2`, `cao`, `mgo`, `cn_ratio`, `raw_material`, `raw_material_other`, `arsenic_content`, `copper_content`, `chromium_content`, `lead_content`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `qr_code_path`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `created_by`, `language_id`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(83, NULL, NULL, 0, 'organic_amendment', 6, NULL, 'Compost', 'Solid Granules', 'AgroCompost Plus', 'Cote d\'Ivoire', 'Compost', 2, 1, 2, 2, 2, '14', '\"[\\\"Agro-industrial by-products\\\"]\"', 'Yes', 'Yes', 'Yes', 'Yes', 1.00, 5000.00, 7000.00, 8500.00, 'qrcodes/organic_83.png', 191, 1, 3, 'fail', NULL, 1, '2025-12-15 17:13:05', '2025-12-23 10:30:54', NULL),
(100052, NULL, NULL, 0, 'organic_amendment', 6, NULL, 'Compost test', 'Powder', 'GreenBoost', 'India', 'BioCertified', 5, 2, 3, 2, 1, '12:1', '\"[\\\"Cow Manure\\\"]\"', 'Some other material', 'Low', '0.02', '0.01', 1.00, 100.00, 120.00, 150.00, 'qrcodes/organic_100052.png', 191, 1, 1, NULL, 1, 1, '2025-12-24 17:14:39', '2025-12-24 17:15:22', 'uploads/organic_amendments/organic_1766571322_694bbd3a995da.png');

-- --------------------------------------------------------

--
-- Table structure for table `organic_amendment_fields`
--

CREATE TABLE `organic_amendment_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `organic_amendment_fields`
--

INSERT INTO `organic_amendment_fields` (`id`, `label`, `name`, `type`, `options`, `required`) VALUES
(1, 'Organic Type', 'organic_type', 'select', '{\"Manure\":\"Manure\",\"Compost\":\"Compost\",\"Other\":\"Other\"}', 1),
(2, 'Physical Form', 'physical_form', 'select', '{\"Solid\":\"Solid\",\"Liquid\":\"Liquid\"}', 1),
(3, 'Trade Name', 'trade_name', 'text', NULL, 0),
(4, 'Country of Origin', 'country_origin', 'text', NULL, 0),
(5, 'Bio Label', 'bio_label', 'text', NULL, 0),
(6, 'N %', 'n', 'text', NULL, 0),
(7, 'P2O5 %', 'p2', 'text', NULL, 0),
(8, 'K2O %', 'k2', 'text', NULL, 0),
(9, 'CaO %', 'cao', 'text', NULL, 0),
(10, 'MgO %', 'mgo', 'text', NULL, 0),
(11, 'C:N Ratio', 'cn_ratio', 'text', NULL, 0),
(12, 'Raw Material', 'raw_material', 'checkbox', '{\"Cow Dung\":\"Cow Dung\",\"Compost\":\"Compost\",\"Vermicompost\":\"Vermicompost\",\"Others\":\"Others\"}', 0),
(13, 'Raw Material Other', 'raw_material_other', 'text', NULL, 0),
(14, 'Arsenic Content (ppm)', 'arsenic_content', 'text', NULL, 0),
(15, 'Wholesale Price', 'wholesale_price', 'number', NULL, 1),
(16, 'Semi-Wholesale Price', 'semiwholesale_price', 'number', NULL, 1),
(17, 'Retail Price', 'retail_price', 'number', NULL, 1),
(18, 'Local produt name', 'localProductName', 'text', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `organic_amendment_translations`
--

CREATE TABLE `organic_amendment_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organic_amendment_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `organic_type` varchar(255) DEFAULT NULL,
  `physical_form` varchar(255) DEFAULT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `country_origin` varchar(255) DEFAULT NULL,
  `bio_label` varchar(255) DEFAULT NULL,
  `cn_ratio` varchar(255) DEFAULT NULL,
  `raw_material` longtext DEFAULT NULL,
  `raw_material_other` varchar(255) DEFAULT NULL,
  `arsenic_content` varchar(50) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organic_amendment_translations`
--

INSERT INTO `organic_amendment_translations` (`id`, `organic_amendment_id`, `language_id`, `organic_type`, `physical_form`, `trade_name`, `country_origin`, `bio_label`, `cn_ratio`, `raw_material`, `raw_material_other`, `arsenic_content`, `supplier_id`, `agent_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '1161', 'Liquid', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Yes', NULL, NULL, 1, '2025-10-14 20:25:47', '2025-10-14 20:25:47'),
(2, 5, 2, '1161', 'Liquide', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Oui', NULL, NULL, 1, '2025-10-14 20:25:48', '2025-10-14 20:25:48'),
(3, 5, 12, '1161', 'तरल', 'परीक्षा', '14', '14', '223', '[\"Crop residues\"]', '1', 'हाँ', NULL, NULL, 1, '2025-10-14 20:25:48', '2025-10-14 20:25:48'),
(4, 6, 1, '1161', 'Liquid', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Yes', NULL, NULL, 1, '2025-10-14 20:25:49', '2025-10-14 20:25:49'),
(5, 5, 13, '1161', 'مائع', 'ٹیسٹ', '14', '14', '223', '[\"Crop residues\"]', '1', 'ہاں', NULL, NULL, 1, '2025-10-14 20:25:49', '2025-10-14 20:25:49'),
(6, 6, 2, '1161', 'Liquide', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Oui', NULL, NULL, 1, '2025-10-14 20:25:50', '2025-10-14 20:25:50'),
(7, 6, 12, '1161', 'तरल', 'परीक्षा', '14', '14', '223', '[\"Crop residues\"]', '1', 'हाँ', NULL, NULL, 1, '2025-10-14 20:25:50', '2025-10-14 20:25:50'),
(8, 6, 13, '1161', 'مائع', 'ٹیسٹ', '14', '14', '223', '[\"Crop residues\"]', '1', 'ہاں', NULL, NULL, 1, '2025-10-14 20:25:51', '2025-10-14 20:25:51'),
(9, 7, 1, '1161', 'Liquid', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Yes', NULL, NULL, 1, '2025-10-14 20:25:53', '2025-10-14 20:25:53'),
(10, 7, 2, '1161', 'Liquide', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Oui', NULL, NULL, 1, '2025-10-14 20:25:54', '2025-10-14 20:25:54'),
(11, 7, 12, '1161', 'तरल', 'परीक्षा', '14', '14', '223', '[\"Crop residues\"]', '1', 'हाँ', NULL, NULL, 1, '2025-10-14 20:25:55', '2025-10-14 20:25:55'),
(12, 7, 13, '1161', 'مائع', 'ٹیسٹ', '14', '14', '223', '[\"Crop residues\"]', '1', 'ہاں', NULL, NULL, 1, '2025-10-14 20:25:55', '2025-10-14 20:25:55'),
(13, 8, 1, '1161', 'Liquid', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Yes', NULL, NULL, 1, '2025-10-14 20:26:46', '2025-10-14 20:26:46'),
(14, 8, 2, '1161', 'Liquide', 'test', '14', '14', '223', '[\"Crop residues\"]', '1', 'Oui', NULL, NULL, 1, '2025-10-14 20:26:47', '2025-10-14 20:26:47'),
(15, 8, 12, '1161', 'तरल', 'परीक्षा', '14', '14', '223', '[\"Crop residues\"]', '1', 'हाँ', NULL, NULL, 1, '2025-10-14 20:26:48', '2025-10-14 20:26:48'),
(16, 8, 13, '1161', 'مائع', 'ٹیسٹ', '14', '14', '223', '[\"Crop residues\"]', '1', 'ہاں', NULL, NULL, 1, '2025-10-14 20:26:49', '2025-10-14 20:26:49'),
(17, 21, 1, 'hjsdk', 'Liquid', 'witefall', 'pk', 'pk', '1', '[\"Crop residues\"]', 'test', 'Yes', NULL, NULL, 1, '2025-10-23 16:45:04', '2025-10-23 16:45:04'),
(18, 21, 2, 'hjsdk', 'Liquide', 'chute des témoins', 'pk', 'pk', '1', '[\"Crop residues\"]', 'test', 'Oui', NULL, NULL, 1, '2025-10-23 16:45:06', '2025-10-23 16:45:06'),
(19, 54, 1, 'shine', 'Liquid', '1', '1', '1', '1', '[\"Crop residues\"]', '1', 'Yes', 38, 3, 1, '2025-10-25 11:14:02', '2025-10-25 11:14:02'),
(20, 54, 2, 'briller', 'Liquide', '1', '1', '1', '1', '[\"Crop residues\"]', '1', 'Oui', 38, 3, 1, '2025-10-25 11:14:03', '2025-10-25 11:14:03'),
(21, 61, 1, 'to', 'Liquid', 'test', 'pk', 'pk', '1', '[\"Crop residues\"]', '1', 'Yes', 57, 6, 1, '2025-11-05 09:32:33', '2025-11-05 09:32:33'),
(22, 61, 2, 'à', 'Liquide', 'test', 'pk', 'pk', '1', '[\"Crop residues\"]', '1', 'Oui', 57, 6, 1, '2025-11-05 09:32:34', '2025-11-05 09:32:34'),
(23, 62, 1, 'Manure', 'Solid', '1', '1', '1', '1', '[\"Cow Dung\"]', '1', '1', 57, 6, 1, '2025-11-05 09:55:03', '2025-11-05 09:55:03'),
(24, 62, 2, 'Fumier', 'Solide', '1', '1', '1', '1', '[\"Cow Dung\"]', '1', '1', 57, 6, 1, '2025-11-05 09:55:06', '2025-11-05 09:55:06'),
(25, 63, 1, 'Manure', 'Solid', 'mast', 'pk', 'sbc', '1', '[\"Cow Dung\"]', '1', '1', 72, NULL, 1, '2025-11-05 19:06:48', '2025-11-05 19:06:48'),
(26, 63, 2, 'Fumier', 'Solide', 'mât', 'pk', 'csb', '1', '[\"Cow Dung\"]', '1', '1', 72, NULL, 1, '2025-11-05 19:06:50', '2025-11-05 19:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('pandeylokesh9682@gmail.com', '$2y$12$.BBp4SqgVnmIjVsRc.lH..N8fJ1me13zHZdKzn8TmIENR9nOUJeKi', '2025-10-01 21:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `pre_orders`
--

CREATE TABLE `pre_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_type` enum('pickup','delivery') NOT NULL DEFAULT 'delivery'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pre_orders`
--

INSERT INTO `pre_orders` (`id`, `farmer_id`, `supplier_id`, `product_id`, `quantity`, `location`, `description`, `status`, `created_at`, `updated_at`, `order_type`) VALUES
(26, 194, 191, 134, 6.00, 'eth', 'test 4556', 'pending', '2025-12-23 17:40:40', '2025-12-23 17:40:40', 'pickup'),
(27, 194, 191, 134, 3.00, 'io', 'oo', 'pending', '2025-12-23 17:44:51', '2025-12-23 17:44:51', 'pickup'),
(28, 194, 191, 139, 2.00, 'noida', 'hs', 'pending', '2025-12-23 18:04:46', '2025-12-23 18:04:46', 'delivery'),
(29, 194, 191, 139, 8.00, 'tets', 'ndjdfb', 'pending', '2025-12-23 18:06:03', '2025-12-23 18:06:03', 'delivery'),
(30, 194, 191, 134, 4.00, 'rt', 'tet', 'pending', '2025-12-23 20:17:22', '2025-12-23 20:17:22', 'pickup'),
(31, 198, 191, 100061, 2.00, 'test area', 'looking for product 5 ton', 'pending', '2026-03-14 12:01:38', '2026-03-14 12:01:38', 'pickup'),
(32, 194, 191, 100061, 4.00, 'St House', '50 kgs of tomato is required', 'pending', '2026-05-20 21:11:44', '2026-05-20 21:11:44', 'delivery');

-- --------------------------------------------------------

--
-- Table structure for table `pre_order_supplier_responses`
--

CREATE TABLE `pre_order_supplier_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pre_order_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `available_quantity` decimal(10,2) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_histories`
--

CREATE TABLE `price_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `wholesalePrice` decimal(10,2) DEFAULT NULL,
  `semiwholesalePrice` decimal(10,2) DEFAULT NULL,
  `retailPrice` decimal(10,2) DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `add_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `changed_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `price_histories`
--

INSERT INTO `price_histories` (`id`, `product_id`, `supplier_id`, `wholesalePrice`, `semiwholesalePrice`, `retailPrice`, `updated_by`, `add_product_id`, `changed_at`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 20.00, 2.00, 2.00, NULL, NULL, '2025-11-18 16:09:15', '2025-11-19 16:09:15', '2025-11-20 14:17:29'),
(2, 8, NULL, 20.00, 225.00, 2.00, NULL, NULL, '2025-11-19 16:09:49', '2025-11-19 16:09:49', '2025-11-20 14:17:17'),
(3, 2, 1, 100.50, 120.00, 1501.00, 80, NULL, '2025-11-19 16:56:36', '2025-11-19 16:56:36', '2025-11-19 16:56:36'),
(4, 2, 1, 100.50, 120.00, 1501.00, NULL, NULL, '2025-11-19 16:58:08', '2025-11-19 16:58:08', '2025-11-19 16:58:08'),
(5, 2, 1, 100.50, 120.00, 15001.00, NULL, NULL, '2025-11-19 16:58:42', '2025-11-19 16:58:42', '2025-11-19 16:58:42'),
(6, 5, 37, 100.00, 120.00, 150.00, NULL, NULL, '2025-11-19 17:05:25', '2025-11-19 17:05:25', '2025-11-19 17:05:25'),
(7, 5, 37, 100.00, 120.00, 150.00, NULL, NULL, '2025-11-19 17:06:42', '2025-11-19 17:06:42', '2025-11-19 17:06:42'),
(8, 5, 37, 1000.00, 120.00, 150.00, NULL, NULL, '2025-11-19 17:07:11', '2025-11-19 17:07:11', '2025-11-19 17:07:11'),
(9, 4, 103, 200.50, 220.75, 250.00, 1, 73, '2025-11-19 17:28:14', '2025-11-19 17:28:14', '2025-11-19 17:28:14'),
(10, 7, 5, 10000.00, 1200.00, 1500.00, 1, 63, '2025-11-19 17:32:32', '2025-11-19 17:32:32', '2025-11-19 17:32:32'),
(11, 7, 5, 10000.00, 1200.00, 1500.00, 1, 63, '2025-11-19 17:33:13', '2025-11-19 17:33:13', '2025-11-19 17:33:13'),
(12, 7, 5, 55.00, 1200.00, 1500.00, 1, 63, '2025-11-19 17:33:31', '2025-11-19 17:33:31', '2025-11-19 17:33:31'),
(13, 6, 37, 100.00, 120.00, 150.00, 1, 67, '2025-11-19 17:36:07', '2025-11-19 17:36:07', '2025-11-19 17:36:07'),
(14, 6, 37, 100.00, 120.00, 150.00, 1, 67, '2025-11-19 17:36:30', '2025-11-19 17:36:30', '2025-11-19 17:36:30'),
(15, 6, 37, 1080.00, 120.00, 150.00, 1, 67, '2025-11-19 17:37:03', '2025-11-19 17:37:03', '2025-11-19 17:37:03'),
(16, 6, 37, 1080.00, 120.00, 150.00, 1, 67, '2025-11-19 17:37:06', '2025-11-19 17:37:06', '2025-11-19 17:37:06'),
(17, 6, 37, 1080.00, 120.00, 150.00, 1, 67, '2025-11-19 17:37:08', '2025-11-19 17:37:08', '2025-11-19 17:37:08'),
(18, 6, 37, 1080.00, 120.00, 150.00, 1, 67, '2025-11-19 17:37:13', '2025-11-19 17:37:13', '2025-11-19 17:37:13'),
(19, 3, 37, 150.50, 160.75, 175.00, 1, 32, '2025-11-19 17:44:37', '2025-11-19 17:44:37', '2025-11-19 17:44:37'),
(20, 3, 37, 150.50, 160.75, 175.00, 1, 32, '2025-11-19 17:45:05', '2025-11-19 17:45:05', '2025-11-19 17:45:05'),
(21, 3, 37, 150.50, 160.75, 1705.00, 1, 32, '2025-11-19 17:45:26', '2025-11-19 17:45:26', '2025-11-19 17:45:26'),
(22, 1, 1, 10000.00, 120.00, 150.00, 1, 51, '2025-11-19 17:54:14', '2025-11-19 17:54:14', '2025-11-19 17:54:14'),
(23, 2, 1, 100.50, 1220.00, 15001.00, 80, 120, '2025-11-19 17:56:36', '2025-11-19 17:56:36', '2025-11-19 17:56:36'),
(24, 8, NULL, 20.00, 225.00, 2.00, 1, 111, '2025-11-19 18:02:04', '2025-11-19 18:02:04', '2025-11-19 18:02:04'),
(25, 2, 1, 100.50, 12220.00, 15001.00, 80, 121, '2025-11-21 09:03:46', '2025-11-21 09:03:46', '2025-11-21 09:03:46'),
(26, 2, 72, 567.00, 4.00, 33.00, NULL, 122, '2025-11-27 19:24:10', '2025-11-27 19:24:10', '2025-11-27 19:24:10'),
(27, 2, 108, 120.00, 100.00, 50.00, NULL, 123, '2025-11-27 19:25:15', '2025-11-27 19:25:15', '2025-11-27 19:25:15'),
(28, 8, 148, 250.00, 300.00, 350.00, NULL, 86, '2025-11-27 19:27:07', '2025-11-27 19:27:07', '2025-11-27 19:27:07'),
(29, 1, 72, 2.00, 2.00, 2.00, 1, 44, '2025-11-27 19:57:53', '2025-11-27 19:57:53', '2025-11-27 19:57:53'),
(30, 8, 1, 2.00, 2.00, 2.00, 1, 113, '2025-12-01 20:25:56', '2025-12-01 20:25:56', '2025-12-01 20:25:56'),
(31, 1, 152, 22.00, 22.00, 323.00, 1, 52, '2025-12-02 22:00:37', '2025-12-02 22:00:37', '2025-12-02 22:00:37'),
(32, 2, 152, 5.00, 4.00, 7.00, NULL, 124, '2025-12-03 17:42:48', '2025-12-03 17:42:48', '2025-12-03 17:42:48'),
(33, 1, 152, 22.00, 22.00, 323.00, 1, 52, '2025-12-04 01:59:38', '2025-12-04 01:59:38', '2025-12-04 01:59:38'),
(34, 1, 152, 22.00, 22.00, 323.00, 1, 52, '2025-12-04 01:59:38', '2025-12-04 01:59:38', '2025-12-04 01:59:38'),
(35, 8, 1, 2.00, 2.00, 2.00, 1, 114, '2025-12-04 14:01:24', '2025-12-04 14:01:24', '2025-12-04 14:01:24'),
(36, 8, 1, 2.00, 2.00, 2.00, 1, 115, '2025-12-04 15:59:04', '2025-12-04 15:59:04', '2025-12-04 15:59:04'),
(37, 8, NULL, 2.00, 2.00, 2.00, 1, 116, '2025-12-04 15:59:56', '2025-12-04 15:59:56', '2025-12-04 15:59:56'),
(38, 8, NULL, 2.00, 2.00, 2.00, 1, 117, '2025-12-04 20:27:22', '2025-12-04 20:27:22', '2025-12-04 20:27:22'),
(39, 7, 107, 58.00, 85.00, 58.00, 1, 64, '2025-12-06 09:45:22', '2025-12-06 09:45:22', '2025-12-06 09:45:22'),
(40, 1, 164, 12.00, 12.00, 16.00, 1, 53, '2025-12-06 10:13:39', '2025-12-06 10:13:39', '2025-12-06 10:13:39'),
(41, 2, 165, 20.00, 15.00, 12.00, NULL, 125, '2025-12-06 10:47:29', '2025-12-06 10:47:29', '2025-12-06 10:47:29'),
(42, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-07 11:24:39', '2025-12-07 11:24:39', '2025-12-07 11:24:39'),
(43, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 08:54:12', '2025-12-08 08:54:12', '2025-12-08 08:54:12'),
(44, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 08:58:29', '2025-12-08 08:58:29', '2025-12-08 08:58:29'),
(45, 3, 165, 12.00, 12.00, 13.00, 1, 33, '2025-12-08 08:59:47', '2025-12-08 08:59:47', '2025-12-08 08:59:47'),
(46, 3, 165, 12.00, 12.00, 13.00, 1, 33, '2025-12-08 09:00:20', '2025-12-08 09:00:20', '2025-12-08 09:00:20'),
(47, 1, 169, 4627.00, 8383.00, 138.00, 1, 54, '2025-12-08 12:32:31', '2025-12-08 12:32:31', '2025-12-08 12:32:31'),
(48, 1, 169, 4627.00, 8383.00, 138.00, 1, 54, '2025-12-08 12:33:28', '2025-12-08 12:33:28', '2025-12-08 12:33:28'),
(49, 8, 169, 277.00, 727.00, 62.00, NULL, 119, '2025-12-08 12:36:42', '2025-12-08 12:36:42', '2025-12-08 12:36:42'),
(50, 8, 169, 187.00, 788.00, 89.00, NULL, 120, '2025-12-08 12:46:13', '2025-12-08 12:46:13', '2025-12-08 12:46:13'),
(51, 8, 169, 187.00, 788.00, 89.00, NULL, 120, '2025-12-08 12:47:25', '2025-12-08 12:47:25', '2025-12-08 12:47:25'),
(52, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 12:58:38', '2025-12-08 12:58:38', '2025-12-08 12:58:38'),
(53, 3, 165, 12.00, 25.00, 13.00, 1, 33, '2025-12-08 13:08:47', '2025-12-08 13:08:47', '2025-12-08 13:08:47'),
(54, 1, 165, 12.00, 12.00, 16.00, 1, 53, '2025-12-08 13:10:10', '2025-12-08 13:10:10', '2025-12-08 13:10:10'),
(55, 1, 165, 12.00, 100.00, 16.00, 1, 53, '2025-12-08 13:10:37', '2025-12-08 13:10:37', '2025-12-08 13:10:37'),
(56, 1, 165, 12.00, 100.00, 16.00, 1, 53, '2025-12-08 13:11:20', '2025-12-08 13:11:20', '2025-12-08 13:11:20'),
(57, 1, 172, 12.00, 478.00, 456.00, 1, 55, '2025-12-08 16:15:56', '2025-12-08 16:15:56', '2025-12-08 16:15:56'),
(58, 1, 172, 12.00, 478.00, 456.00, 1, 56, '2025-12-08 16:15:56', '2025-12-08 16:15:56', '2025-12-08 16:15:56'),
(59, 3, 172, 20.00, 1000.00, 200.00, 1, 34, '2025-12-08 16:16:53', '2025-12-08 16:16:53', '2025-12-08 16:16:53'),
(60, 1, 165, 12.00, 102.00, 16.00, 1, 53, '2025-12-08 16:18:09', '2025-12-08 16:18:09', '2025-12-08 16:18:09'),
(61, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 16:18:40', '2025-12-08 16:18:40', '2025-12-08 16:18:40'),
(62, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 16:19:46', '2025-12-08 16:19:46', '2025-12-08 16:19:46'),
(63, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 17:16:33', '2025-12-08 17:16:33', '2025-12-08 17:16:33'),
(64, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 17:20:14', '2025-12-08 17:20:14', '2025-12-08 17:20:14'),
(65, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 17:20:40', '2025-12-08 17:20:40', '2025-12-08 17:20:40'),
(66, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 17:25:52', '2025-12-08 17:25:52', '2025-12-08 17:25:52'),
(67, 8, 169, 765.00, 7373.00, 2838.00, NULL, 121, '2025-12-08 17:26:09', '2025-12-08 17:26:09', '2025-12-08 17:26:09'),
(68, 2, 172, 8.00, 8.00, 8.00, NULL, 126, '2025-12-08 20:20:58', '2025-12-08 20:20:58', '2025-12-08 20:20:58'),
(69, 1, 165, 7272.00, 2727.00, 4627.00, 1, 57, '2025-12-08 20:23:19', '2025-12-08 20:23:19', '2025-12-08 20:23:19'),
(70, 3, 168, 7272.00, 7272.00, 6272.00, 1, 35, '2025-12-08 20:23:55', '2025-12-08 20:23:55', '2025-12-08 20:23:55'),
(71, 4, 174, 6272.00, 6272.00, 5262.00, 1, 74, '2025-12-08 20:24:31', '2025-12-08 20:24:31', '2025-12-08 20:24:31'),
(72, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-08 20:27:05', '2025-12-08 20:27:05', '2025-12-08 20:27:05'),
(73, 8, 174, 988.00, 7272.00, 627.00, NULL, 122, '2025-12-08 20:29:32', '2025-12-08 20:29:32', '2025-12-08 20:29:32'),
(74, 8, 174, 988.00, 7272.00, 627.00, NULL, 122, '2025-12-08 20:31:46', '2025-12-08 20:31:46', '2025-12-08 20:31:46'),
(75, 8, 174, 988.00, 7272.00, 627.00, NULL, 122, '2025-12-08 20:32:18', '2025-12-08 20:32:18', '2025-12-08 20:32:18'),
(76, 1, 165, 12.00, 900.00, 16.00, 1, 53, '2025-12-08 20:33:01', '2025-12-08 20:33:01', '2025-12-08 20:33:01'),
(77, 5, 172, 434.00, 566.00, 23.00, NULL, NULL, '2025-12-08 20:48:32', '2025-12-08 20:48:32', '2025-12-08 20:48:32'),
(78, 5, 172, 434.00, 566.00, 23.00, NULL, NULL, '2025-12-08 20:50:06', '2025-12-08 20:50:06', '2025-12-08 20:50:06'),
(79, 5, 172, 434.00, 70.00, 23.00, NULL, NULL, '2025-12-08 20:51:15', '2025-12-08 20:51:15', '2025-12-08 20:51:15'),
(80, 5, 172, 434.00, 78.00, 23.00, NULL, NULL, '2025-12-08 20:56:18', '2025-12-08 20:56:18', '2025-12-08 20:56:18'),
(81, 5, 172, 434.00, 100.00, 23.00, NULL, NULL, '2025-12-08 20:56:18', '2025-12-08 20:56:18', '2025-12-08 20:56:18'),
(82, 5, 172, 434.00, 100.00, 23.00, NULL, NULL, '2025-12-08 21:03:35', '2025-12-08 21:03:35', '2025-12-08 21:03:35'),
(83, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:08:33', '2025-12-08 21:08:33', '2025-12-08 21:08:33'),
(84, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-08 21:10:56', '2025-12-08 21:10:56', '2025-12-08 21:10:56'),
(85, 4, 173, 300.00, 111.00, 100.00, 1, 75, '2025-12-08 21:17:52', '2025-12-08 21:17:52', '2025-12-08 21:17:52'),
(86, 7, 173, 244.00, 300.00, 200.00, 1, 66, '2025-12-08 21:21:04', '2025-12-08 21:21:04', '2025-12-08 21:21:04'),
(87, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:23:29', '2025-12-08 21:23:29', '2025-12-08 21:23:29'),
(88, 1, 165, 12.00, 1928.00, 16.00, 1, 53, '2025-12-08 21:23:52', '2025-12-08 21:23:52', '2025-12-08 21:23:52'),
(89, 7, 173, 244.00, 300.00, 200.00, 1, 65, '2025-12-08 21:24:04', '2025-12-08 21:24:04', '2025-12-08 21:24:04'),
(90, 3, 172, 20.00, 1000.00, 200.00, 1, 34, '2025-12-08 21:24:12', '2025-12-08 21:24:12', '2025-12-08 21:24:12'),
(91, 7, 173, 244.00, 3000.00, 200.00, 1, 65, '2025-12-08 21:24:34', '2025-12-08 21:24:34', '2025-12-08 21:24:34'),
(92, 1, 165, 12.00, 1928.00, 16.00, 1, 53, '2025-12-08 21:25:51', '2025-12-08 21:25:51', '2025-12-08 21:25:51'),
(93, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:30:55', '2025-12-08 21:30:55', '2025-12-08 21:30:55'),
(94, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:31:16', '2025-12-08 21:31:16', '2025-12-08 21:31:16'),
(95, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:33:26', '2025-12-08 21:33:26', '2025-12-08 21:33:26'),
(96, 1, 88, 12.00, 134.00, 16.00, 1, 53, '2025-12-08 21:33:59', '2025-12-08 21:33:59', '2025-12-08 21:33:59'),
(97, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:42:06', '2025-12-08 21:42:06', '2025-12-08 21:42:06'),
(98, 8, 168, 1000.00, 8000.00, 1000.00, NULL, 118, '2025-12-08 21:47:46', '2025-12-08 21:47:46', '2025-12-08 21:47:46'),
(99, 8, 174, 988.00, 7272.00, 627.00, 1, 122, '2025-12-08 21:54:00', '2025-12-08 21:54:00', '2025-12-08 21:54:00'),
(100, 7, 173, 244.00, 3000.00, 200.00, 1, 65, '2025-12-08 21:54:21', '2025-12-08 21:54:21', '2025-12-08 21:54:21'),
(101, 8, 174, 2.00, 2.00, 2.00, 1, 122, '2025-12-08 21:54:37', '2025-12-08 21:54:37', '2025-12-08 21:54:37'),
(102, 7, 173, 244.00, 3000.00, 200.00, 1, 65, '2025-12-08 21:54:41', '2025-12-08 21:54:41', '2025-12-08 21:54:41'),
(103, 8, 174, 2.00, 2.00, 2.00, 1, 122, '2025-12-08 21:54:46', '2025-12-08 21:54:46', '2025-12-08 21:54:46'),
(104, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-08 21:57:33', '2025-12-08 21:57:33', '2025-12-08 21:57:33'),
(105, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:17:04', '2025-12-08 22:17:04', '2025-12-08 22:17:04'),
(106, 4, 174, 6272.00, 6272.00, 5262.00, 1, 74, '2025-12-08 22:18:34', '2025-12-08 22:18:34', '2025-12-08 22:18:34'),
(107, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:22:40', '2025-12-08 22:22:40', '2025-12-08 22:22:40'),
(108, 6, 168, 828.00, 8282.00, 828.00, NULL, 69, '2025-12-08 22:24:09', '2025-12-08 22:24:09', '2025-12-08 22:24:09'),
(109, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:28:44', '2025-12-08 22:28:44', '2025-12-08 22:28:44'),
(110, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:36:34', '2025-12-08 22:36:34', '2025-12-08 22:36:34'),
(111, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:37:33', '2025-12-08 22:37:33', '2025-12-08 22:37:33'),
(112, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:38:00', '2025-12-08 22:38:00', '2025-12-08 22:38:00'),
(113, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:39:43', '2025-12-08 22:39:43', '2025-12-08 22:39:43'),
(114, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:41:00', '2025-12-08 22:41:00', '2025-12-08 22:41:00'),
(115, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:42:58', '2025-12-08 22:42:58', '2025-12-08 22:42:58'),
(116, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:44:03', '2025-12-08 22:44:03', '2025-12-08 22:44:03'),
(117, 1, 88, 12.00, 9.00, 16.00, 1, 53, '2025-12-08 22:46:51', '2025-12-08 22:46:51', '2025-12-08 22:46:51'),
(118, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-08 22:54:26', '2025-12-08 22:54:26', '2025-12-08 22:54:26'),
(119, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-08 23:12:19', '2025-12-08 23:12:19', '2025-12-08 23:12:19'),
(120, 4, 174, 6272.00, 6272.00, 5262.00, 1, 74, '2025-12-08 23:19:50', '2025-12-08 23:19:50', '2025-12-08 23:19:50'),
(121, 4, 174, 6272.00, 6272.00, 5262.00, 1, 74, '2025-12-08 23:24:13', '2025-12-08 23:24:13', '2025-12-08 23:24:13'),
(122, 6, 12, 500.00, 450.00, 550.00, 1, 70, '2025-12-08 23:55:00', '2025-12-08 23:55:00', '2025-12-08 23:55:00'),
(123, 6, 12, 500.00, 450.00, 550.00, 1, 71, '2025-12-09 00:03:11', '2025-12-09 00:03:11', '2025-12-09 00:03:11'),
(124, 6, 12, 500.00, 450.00, 550.00, 1, 72, '2025-12-09 00:11:42', '2025-12-09 00:11:42', '2025-12-09 00:11:42'),
(125, 6, 12, 500.00, 450.00, 550.00, 1, 73, '2025-12-09 00:16:14', '2025-12-09 00:16:14', '2025-12-09 00:16:14'),
(126, 6, 12, 500.00, 450.00, 550.00, 1, 74, '2025-12-09 00:26:03', '2025-12-09 00:26:03', '2025-12-09 00:26:03'),
(127, 6, 12, 500.00, 450.00, 550.00, 1, 75, '2025-12-09 00:26:18', '2025-12-09 00:26:18', '2025-12-09 00:26:18'),
(128, 6, 12, 500.00, 450.00, 550.00, 1, 76, '2025-12-09 00:26:19', '2025-12-09 00:26:19', '2025-12-09 00:26:19'),
(129, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-09 00:29:51', '2025-12-09 00:29:51', '2025-12-09 00:29:51'),
(130, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-09 00:31:04', '2025-12-09 00:31:04', '2025-12-09 00:31:04'),
(131, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-09 00:37:12', '2025-12-09 00:37:12', '2025-12-09 00:37:12'),
(132, 6, 173, 882.00, 888.00, 777.00, NULL, 68, '2025-12-09 00:50:23', '2025-12-09 00:50:23', '2025-12-09 00:50:23'),
(133, 6, 173, 456.00, 122.00, 10.00, NULL, 77, '2025-12-09 01:01:15', '2025-12-09 01:01:15', '2025-12-09 01:01:15'),
(134, 6, 173, 456.00, 122.00, 10.00, NULL, 77, '2025-12-09 01:19:38', '2025-12-09 01:19:38', '2025-12-09 01:19:38'),
(135, 6, 173, 456.00, 122.00, 10.00, NULL, 77, '2025-12-09 01:20:06', '2025-12-09 01:20:06', '2025-12-09 01:20:06'),
(136, 6, 173, 456.00, 122.00, 10.00, NULL, 77, '2025-12-09 01:20:21', '2025-12-09 01:20:21', '2025-12-09 01:20:21'),
(137, 1, 172, 400.00, 40.00, 12.00, 1, 58, '2025-12-09 01:23:05', '2025-12-09 01:23:05', '2025-12-09 01:23:05'),
(138, 1, 172, 400.00, 40.00, 12.00, 1, 58, '2025-12-09 01:23:22', '2025-12-09 01:23:22', '2025-12-09 01:23:22'),
(139, 1, 172, 400.00, 40.00, 12.00, 1, 58, '2025-12-09 01:23:44', '2025-12-09 01:23:44', '2025-12-09 01:23:44'),
(140, 3, 172, 30.00, 89.00, 67.00, 1, 36, '2025-12-09 01:26:13', '2025-12-09 01:26:13', '2025-12-09 01:26:13'),
(141, 5, 173, 400.00, 70.00, 100.00, NULL, NULL, '2025-12-09 01:29:49', '2025-12-09 01:29:49', '2025-12-09 01:29:49'),
(142, 7, 172, 4000.00, 300.00, 100.00, 1, 67, '2025-12-09 01:31:11', '2025-12-09 01:31:11', '2025-12-09 01:31:11'),
(143, 5, 173, 400.00, 70.00, 100.00, NULL, NULL, '2025-12-09 01:31:58', '2025-12-09 01:31:58', '2025-12-09 01:31:58'),
(144, 2, 173, 200.00, 100.00, 100.00, NULL, 127, '2025-12-09 01:34:34', '2025-12-09 01:34:34', '2025-12-09 01:34:34'),
(145, 2, 173, 200.00, 100.00, 100.00, NULL, 127, '2025-12-09 01:35:00', '2025-12-09 01:35:00', '2025-12-09 01:35:00'),
(146, 8, 173, 400.00, 500.00, 10.00, NULL, 123, '2025-12-09 01:40:44', '2025-12-09 01:40:44', '2025-12-09 01:40:44'),
(147, 8, 173, 400.00, 500.00, 10.00, NULL, 124, '2025-12-09 01:40:55', '2025-12-09 01:40:55', '2025-12-09 01:40:55'),
(148, 8, 173, 400.00, 500.00, 10.00, NULL, 123, '2025-12-09 01:43:15', '2025-12-09 01:43:15', '2025-12-09 01:43:15'),
(149, 1, 179, 200.00, 300.00, 1233.00, 1, 59, '2025-12-09 02:07:18', '2025-12-09 02:07:18', '2025-12-09 02:07:18'),
(150, 2, 179, 100.00, 123.00, 100.00, NULL, 128, '2025-12-09 12:41:09', '2025-12-09 12:41:09', '2025-12-09 12:41:09'),
(151, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-09 23:38:37', '2025-12-09 23:38:37', '2025-12-09 23:38:37'),
(152, 2, 181, 87.00, 56.00, 123.00, NULL, 129, '2025-12-10 00:34:32', '2025-12-10 00:34:32', '2025-12-10 00:34:32'),
(153, 6, 181, 1000.00, 300.00, 10.00, NULL, 78, '2025-12-10 00:38:42', '2025-12-10 00:38:42', '2025-12-10 00:38:42'),
(154, 8, 181, 40.00, 45.00, 1000.00, NULL, 125, '2025-12-10 00:39:50', '2025-12-10 00:39:50', '2025-12-10 00:39:50'),
(155, 7, 181, 55.00, 40.00, 100.00, 1, 68, '2025-12-10 00:40:31', '2025-12-10 00:40:31', '2025-12-10 00:40:31'),
(156, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-10 00:41:27', '2025-12-10 00:41:27', '2025-12-10 00:41:27'),
(157, 8, 181, 40.00, 45.00, 1000.00, NULL, 125, '2025-12-10 00:41:54', '2025-12-10 00:41:54', '2025-12-10 00:41:54'),
(158, 7, 181, 55.00, 40.00, 100.00, 1, 68, '2025-12-10 00:42:15', '2025-12-10 00:42:15', '2025-12-10 00:42:15'),
(159, 6, 181, 1000.00, 300.00, 10.00, NULL, 78, '2025-12-10 00:43:13', '2025-12-10 00:43:13', '2025-12-10 00:43:13'),
(160, 2, 181, 87.00, 56.00, 123.00, NULL, 129, '2025-12-10 01:02:37', '2025-12-10 01:02:37', '2025-12-10 01:02:37'),
(161, 3, 181, 100.00, 23.00, 10.00, 1, 37, '2025-12-10 01:14:44', '2025-12-10 01:14:44', '2025-12-10 01:14:44'),
(162, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-10 01:24:27', '2025-12-10 01:24:27', '2025-12-10 01:24:27'),
(163, 6, 181, 78.00, 88.00, 56.00, NULL, 79, '2025-12-10 01:43:12', '2025-12-10 01:43:12', '2025-12-10 01:43:12'),
(164, 6, 181, 78.00, 88.00, 56.00, NULL, 79, '2025-12-10 02:18:06', '2025-12-10 02:18:06', '2025-12-10 02:18:06'),
(165, 6, NULL, 500.00, 450.00, 550.00, 1, 80, '2025-12-10 02:27:55', '2025-12-10 02:27:55', '2025-12-10 02:27:55'),
(166, 4, 181, 100.00, 350.00, 100.00, 1, 76, '2025-12-10 02:35:01', '2025-12-10 02:35:01', '2025-12-10 02:35:01'),
(167, 4, 181, 100.00, 350.00, 100.00, 1, 77, '2025-12-10 02:35:01', '2025-12-10 02:35:01', '2025-12-10 02:35:01'),
(168, 8, 182, 229.00, 12.00, 12.00, NULL, 126, '2025-12-10 11:33:56', '2025-12-10 11:33:56', '2025-12-10 11:33:56'),
(169, 2, 182, 102.00, 10.00, 10.00, NULL, 130, '2025-12-10 11:35:15', '2025-12-10 11:35:15', '2025-12-10 11:35:15'),
(170, 3, 182, 9292.00, 9282.00, 8383.00, 1, 38, '2025-12-10 11:36:16', '2025-12-10 11:36:16', '2025-12-10 11:36:16'),
(171, 4, 182, 1929.00, 9292.00, 192.00, 1, 78, '2025-12-10 11:37:13', '2025-12-10 11:37:13', '2025-12-10 11:37:13'),
(172, 4, 182, 1929.00, 9292.00, 192.00, 1, 78, '2025-12-10 11:37:38', '2025-12-10 11:37:38', '2025-12-10 11:37:38'),
(173, 6, 191, 124.00, 888.00, 8283.00, NULL, 81, '2025-12-10 11:39:55', '2025-12-10 11:39:55', '2025-12-26 13:31:46'),
(174, 1, 182, 134.00, 92992.00, 8282.00, 1, 61, '2025-12-10 11:42:24', '2025-12-10 11:42:24', '2025-12-10 11:42:24'),
(175, 8, 182, 229.00, 12.00, 12.00, NULL, 126, '2025-12-10 11:42:51', '2025-12-10 11:42:51', '2025-12-10 11:42:51'),
(176, 1, 182, 134.00, 92992.00, 8282.00, 1, 61, '2025-12-10 11:43:11', '2025-12-10 11:43:11', '2025-12-10 11:43:11'),
(177, 3, 182, 9292.00, 9282.00, 8383.00, 1, 38, '2025-12-10 11:43:41', '2025-12-10 11:43:41', '2025-12-10 11:43:41'),
(178, 6, 182, 124.00, 888.00, 8283.00, NULL, 81, '2025-12-10 11:44:05', '2025-12-10 11:44:05', '2025-12-10 11:44:05'),
(179, 6, 182, 124.00, 888.00, 8283.00, NULL, 81, '2025-12-10 11:44:32', '2025-12-10 11:44:32', '2025-12-10 11:44:32'),
(180, 4, 182, 1929.00, 9292.00, 192.00, 1, 78, '2025-12-10 11:45:03', '2025-12-10 11:45:03', '2025-12-10 11:45:03'),
(181, 2, 182, 102.00, 10.00, 10.00, NULL, 130, '2025-12-10 11:45:39', '2025-12-10 11:45:39', '2025-12-10 11:45:39'),
(182, 5, 182, 1000.00, 120.00, 150.00, NULL, NULL, '2025-12-10 12:22:25', '2025-12-10 12:22:25', '2025-12-10 12:22:25'),
(183, 5, 182, 1000.00, 120.00, 150.00, NULL, NULL, '2025-12-10 12:22:28', '2025-12-10 12:22:28', '2025-12-10 12:22:28'),
(184, 7, 182, 55.00, 1200.00, 1500.00, 1, 69, '2025-12-10 12:23:30', '2025-12-10 12:23:30', '2025-12-10 12:23:30'),
(185, 7, 182, 55.00, 1200.00, 1500.00, 1, 70, '2025-12-10 12:26:01', '2025-12-10 12:26:01', '2025-12-10 12:26:01'),
(186, 1, 181, 1233.00, 123.00, 100.00, 1, 62, '2025-12-10 12:33:05', '2025-12-10 12:33:05', '2025-12-10 12:33:05'),
(187, 8, 181, 200.00, 100.00, 2000.00, NULL, 127, '2025-12-10 12:46:29', '2025-12-10 12:46:29', '2025-12-10 12:46:29'),
(188, 7, 181, 300.00, 299.00, 199.00, 1, 71, '2025-12-10 12:48:47', '2025-12-10 12:48:47', '2025-12-10 12:48:47'),
(189, 1, 181, 300.00, 45.00, 1000.00, 1, 63, '2025-12-10 15:55:07', '2025-12-10 15:55:07', '2025-12-10 15:55:07'),
(190, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-13 01:53:49', '2025-12-13 01:53:49', '2025-12-13 01:53:49'),
(191, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-13 01:53:49', '2025-12-13 01:53:49', '2025-12-13 01:53:49'),
(192, 1, 181, 100.00, 500.00, 100.00, 1, 60, '2025-12-13 01:54:16', '2025-12-13 01:54:16', '2025-12-13 01:54:16'),
(193, 3, 181, 1000.00, 2000.00, 100.00, 1, 39, '2025-12-13 18:28:06', '2025-12-13 18:28:06', '2025-12-13 18:28:06'),
(194, 1, 182, 700.00, 30.00, 100.00, 1, 64, '2025-12-14 22:29:25', '2025-12-14 22:29:25', '2025-12-14 22:29:25'),
(195, 1, 191, 2000.00, 3000.00, 3000.00, 1, 69, '2025-12-15 16:34:06', '2025-12-15 16:34:06', '2025-12-15 16:34:06'),
(196, 8, 190, 200.00, 200.00, 560.00, NULL, 133, '2025-12-15 16:54:46', '2025-12-15 16:54:46', '2025-12-15 16:54:46'),
(197, 8, 190, 200.00, 200.00, 560.00, NULL, 133, '2025-12-15 16:55:26', '2025-12-15 16:55:26', '2025-12-15 16:55:26'),
(198, 8, 190, 200.00, 200.00, 560.00, NULL, 133, '2025-12-15 17:03:41', '2025-12-15 17:03:41', '2025-12-15 17:03:41'),
(199, 6, 190, 5000.00, 7000.00, 8500.00, NULL, 83, '2025-12-15 17:13:05', '2025-12-15 17:13:05', '2025-12-15 17:13:05'),
(200, 2, 191, 28.00, 139.00, 12.00, NULL, 139, '2025-12-15 18:37:22', '2025-12-15 18:37:22', '2025-12-15 18:37:22'),
(201, 1, 191, 99.00, 66.00, 88.00, 1, 70, '2025-12-15 18:56:52', '2025-12-15 18:56:52', '2025-12-15 18:56:52'),
(202, 2, 190, 1.00, 1.00, 1.00, NULL, 140, '2025-12-16 17:38:15', '2025-12-16 17:38:15', '2025-12-16 17:38:15'),
(203, 2, 190, 888.00, 88.00, 88.00, NULL, 141, '2025-12-16 17:48:42', '2025-12-16 17:48:42', '2025-12-16 17:48:42'),
(204, 4, 190, 0.00, 99.00, 99.00, 1, 81, '2025-12-16 18:02:04', '2025-12-16 18:02:04', '2025-12-16 18:02:04'),
(205, 4, 190, 0.00, 99.00, 99.00, 1, 81, '2025-12-16 18:02:26', '2025-12-16 18:02:26', '2025-12-16 18:02:26'),
(206, 4, 190, 8.00, 82.00, 82.00, 1, 82, '2025-12-16 18:08:37', '2025-12-16 18:08:37', '2025-12-16 18:08:37'),
(207, 4, 190, 99.00, 9.00, 9.00, 1, 83, '2025-12-16 18:13:11', '2025-12-16 18:13:11', '2025-12-16 18:13:11'),
(208, 4, 190, 1.00, 11.00, 1.00, 1, 84, '2025-12-16 18:22:52', '2025-12-16 18:22:52', '2025-12-16 18:22:52'),
(209, 7, 190, 1.00, 1.00, 1.00, 1, 74, '2025-12-16 18:33:26', '2025-12-16 18:33:26', '2025-12-16 18:33:26'),
(210, 7, 190, 1.00, 1.00, 1.00, 1, 74, '2025-12-16 18:36:17', '2025-12-16 18:36:17', '2025-12-16 18:36:17'),
(211, 7, 190, 1.00, 1.00, 1.00, 1, 74, '2025-12-16 18:38:08', '2025-12-16 18:38:08', '2025-12-16 18:38:08'),
(212, 7, 190, 1.00, 1.00, 1.00, 1, 75, '2025-12-16 18:38:29', '2025-12-16 18:38:29', '2025-12-16 18:38:29'),
(213, 6, 190, 13.00, 12.00, 1.00, NULL, 84, '2025-12-16 18:43:35', '2025-12-16 18:43:35', '2025-12-16 18:43:35'),
(214, 6, 190, 1.00, 1.00, 1.00, 1, 85, '2025-12-16 18:51:45', '2025-12-16 18:51:45', '2025-12-16 18:51:45'),
(215, 3, 190, 1.00, 1.00, 1.00, 1, 43, '2025-12-16 19:09:00', '2025-12-16 19:09:00', '2025-12-16 19:09:00'),
(216, 3, 190, 1.00, 1.00, 1.00, 1, 44, '2025-12-16 19:16:00', '2025-12-16 19:16:00', '2025-12-16 19:16:00'),
(217, 1, 190, 1.00, 1.00, 11.00, 1, 72, '2025-12-16 19:27:43', '2025-12-16 19:27:43', '2025-12-16 19:27:43'),
(218, 5, 190, 1.00, 1111.00, 1.00, 1, 57, '2025-12-16 19:41:49', '2025-12-16 19:41:49', '2025-12-16 19:41:49'),
(219, 1, 193, 33.00, 444.00, 100.00, 1, 73, '2025-12-18 15:32:10', '2025-12-18 15:32:10', '2025-12-18 15:32:10'),
(220, 2, 193, 120.00, 45.00, 100.00, NULL, 142, '2025-12-18 15:32:52', '2025-12-18 15:32:52', '2025-12-18 15:32:52'),
(221, 8, 193, 33456.00, 678.00, 12.00, NULL, 138, '2025-12-19 02:34:39', '2025-12-19 02:34:39', '2025-12-19 02:34:39'),
(222, 1, 191, 83.00, 88.00, 78.00, 1, 75, '2025-12-19 10:02:18', '2025-12-19 10:02:18', '2025-12-19 10:02:18'),
(223, 4, 191, 1.00, 11.00, 1.00, 1, 86, '2025-12-19 10:06:30', '2025-12-19 10:06:30', '2025-12-19 10:06:30'),
(224, 7, 190, 1.00, 1.00, 1.00, 1, 76, '2025-12-19 10:19:14', '2025-12-19 10:19:14', '2025-12-19 10:19:14'),
(225, 2, 191, 182.00, 12.00, 182.00, NULL, 146, '2025-12-19 10:27:41', '2025-12-19 10:27:41', '2025-12-19 10:27:41'),
(226, 6, 190, 1.00, 1.00, 1.00, 1, 87, '2025-12-19 10:32:34', '2025-12-19 10:32:34', '2025-12-19 10:32:34'),
(227, 3, 190, 1.00, 1.00, 1.00, 1, 46, '2025-12-19 10:35:49', '2025-12-19 10:35:49', '2025-12-19 10:35:49'),
(228, 1, 190, 1.00, 1.00, 11.00, 1, 76, '2025-12-19 10:38:11', '2025-12-19 10:38:11', '2025-12-19 10:38:11'),
(229, 2, 193, 555.00, 320.00, 100.00, NULL, 148, '2025-12-19 14:10:32', '2025-12-19 14:10:32', '2025-12-19 14:10:32'),
(230, 1, 193, 223.00, 456.00, 100.00, 1, 77, '2025-12-19 20:50:25', '2025-12-19 20:50:25', '2025-12-19 20:50:25'),
(231, 1, 191, 2000.00, 3000.00, 3000.00, 1, 69, '2025-12-19 22:58:36', '2025-12-19 22:58:36', '2025-12-19 22:58:36'),
(232, 2, 194, 899.00, 111.00, 282.00, NULL, 100001, '2025-12-20 14:48:42', '2025-12-20 14:48:42', '2025-12-20 14:48:42'),
(233, 2, 194, 899.00, 111.00, 282.00, NULL, 100001, '2025-12-20 14:49:37', '2025-12-20 14:49:37', '2025-12-20 14:49:37'),
(234, 1, 196, 82.00, 13.00, 12.00, 1, 100051, '2025-12-22 13:29:51', '2025-12-22 13:29:51', '2025-12-22 13:29:51'),
(235, 1, 196, 82.00, 13.00, 12.00, 1, 100051, '2025-12-22 13:33:54', '2025-12-22 13:33:54', '2025-12-22 13:33:54'),
(236, 2, 191, 12.00, 12.00, 12.00, NULL, 100002, '2025-12-22 13:39:46', '2025-12-22 13:39:46', '2025-12-22 13:39:46'),
(237, 2, 191, 12.00, 12.00, 12.00, NULL, 100002, '2025-12-22 13:41:17', '2025-12-22 13:41:17', '2025-12-22 13:41:17'),
(238, 1, 193, 90.00, 1000.00, 100.00, 1, 100052, '2025-12-22 17:55:14', '2025-12-22 17:55:14', '2025-12-22 17:55:14'),
(239, 1, 191, 72.00, 8.00, 9.00, 1, 100053, '2025-12-22 18:11:19', '2025-12-22 18:11:19', '2025-12-22 18:11:19'),
(240, 3, 191, 13.00, 67.00, 92.00, 1, 100051, '2025-12-22 18:17:00', '2025-12-22 18:17:00', '2025-12-22 18:17:00'),
(241, 6, 191, 88.00, 76.00, 7.00, NULL, 100051, '2025-12-22 18:20:53', '2025-12-22 18:20:53', '2025-12-22 18:20:53'),
(242, 4, 191, 667.00, 777.00, 66.00, 1, 100031, '2025-12-22 18:29:52', '2025-12-22 18:29:52', '2025-12-22 18:29:52'),
(243, 5, 191, 1.00, 1.00, 1.00, 1, 100020, '2025-12-22 18:48:19', '2025-12-22 18:48:19', '2025-12-22 18:48:19'),
(244, 5, 191, 1.00, 1.00, 1.00, 1, 100020, '2025-12-22 18:49:37', '2025-12-22 18:49:37', '2025-12-22 18:49:37'),
(245, 7, 191, 1.00, 1.00, 1.00, 1, 100041, '2025-12-22 18:56:23', '2025-12-22 18:56:23', '2025-12-22 18:56:23'),
(246, 7, 191, 1.00, 1.00, 1.00, 1, 100042, '2025-12-22 19:39:07', '2025-12-22 19:39:07', '2025-12-22 19:39:07'),
(247, 7, 191, 1.00, 1.00, 1.00, 1, 100043, '2025-12-22 19:45:28', '2025-12-22 19:45:28', '2025-12-22 19:45:28'),
(248, 7, 191, 1.00, 1.00, 1.00, 1, 100044, '2025-12-22 19:46:18', '2025-12-22 19:46:18', '2025-12-22 19:46:18'),
(249, 7, 191, 1.00, 1.00, 1.00, 1, 100045, '2025-12-22 19:52:19', '2025-12-22 19:52:19', '2025-12-22 19:52:19'),
(250, 7, 191, 1.00, 1.00, 1.00, 1, 100046, '2025-12-22 19:57:23', '2025-12-22 19:57:23', '2025-12-22 19:57:23'),
(251, 7, 191, 1.00, 1.00, 1.00, 1, 100047, '2025-12-22 20:01:52', '2025-12-22 20:01:52', '2025-12-22 20:01:52'),
(252, 5, 191, 88.00, 8.00, 8.00, 1, 100021, '2025-12-23 16:34:32', '2025-12-23 16:34:32', '2025-12-23 16:34:32'),
(253, 2, 191, 17000.00, 1700.00, 17000.00, NULL, 138, '2025-12-23 16:47:26', '2025-12-23 16:47:26', '2025-12-23 16:47:26'),
(254, 5, 191, 66.00, 636.00, 77.00, 1, 100023, '2025-12-23 16:50:47', '2025-12-23 16:50:47', '2025-12-23 16:50:47'),
(255, 7, 191, 758.00, 185.00, 1285.00, 1, 100052, '2025-12-23 19:27:39', '2025-12-23 19:27:39', '2025-12-23 19:27:39'),
(256, 5, 191, 44.00, 45.00, 100.00, 1, 100024, '2025-12-23 20:09:53', '2025-12-23 20:09:53', '2025-12-23 20:09:53'),
(257, 8, 191, 1.00, 12.00, 12.00, 1, 100060, '2025-12-24 16:06:11', '2025-12-24 16:06:11', '2025-12-24 16:06:11'),
(258, 8, 191, 1.00, 12.00, 12.00, 1, 100061, '2025-12-24 16:09:53', '2025-12-24 16:09:53', '2025-12-24 16:09:53'),
(259, 2, 191, 125.00, 125.00, 10.00, 11, 100003, '2025-12-24 16:20:50', '2025-12-24 16:20:50', '2025-12-24 16:20:50'),
(260, 2, 191, 125.00, 125.00, 10.00, 11, 100004, '2025-12-24 16:21:31', '2025-12-24 16:21:31', '2025-12-24 16:21:31'),
(261, 5, 191, 1250.00, 1350.00, 1500.00, 1, 100025, '2025-12-24 16:34:34', '2025-12-24 16:34:34', '2025-12-24 16:34:34'),
(262, 5, 191, 1250.00, 1350.00, 1500.00, 1, 100025, '2025-12-24 16:35:13', '2025-12-24 16:35:13', '2025-12-24 16:35:13'),
(263, 5, 191, 1250.00, 1350.00, 1500.00, 1, 100026, '2025-12-24 16:35:13', '2025-12-24 16:35:13', '2025-12-24 16:35:13'),
(264, 4, 191, 100.00, 115.00, 130.00, 1, 100032, '2025-12-24 16:42:22', '2025-12-24 16:42:22', '2025-12-24 16:42:22'),
(265, 4, 191, 100.00, 115.00, 130.00, 1, 100032, '2025-12-24 16:42:57', '2025-12-24 16:42:57', '2025-12-24 16:42:57'),
(266, 4, 191, 100.00, 115.00, 130.00, 1, 100033, '2025-12-24 16:42:57', '2025-12-24 16:42:57', '2025-12-24 16:42:57'),
(267, 7, 191, 1.00, 1.00, 1.00, 1, 100053, '2025-12-24 16:50:52', '2025-12-24 16:50:52', '2025-12-24 16:50:52'),
(268, 7, 191, 1.00, 1.00, 1.00, 1, 100054, '2025-12-24 16:58:05', '2025-12-24 16:58:05', '2025-12-24 16:58:05'),
(269, 7, 191, 1.00, 1.00, 1.00, 1, 100054, '2025-12-24 16:58:53', '2025-12-24 16:58:53', '2025-12-24 16:58:53'),
(270, 7, 191, 1.00, 1.00, 1.00, 1, 100055, '2025-12-24 16:58:53', '2025-12-24 16:58:53', '2025-12-24 16:58:53'),
(271, 6, 191, 100.00, 120.00, 150.00, 1, 100052, '2025-12-24 17:14:39', '2025-12-24 17:14:39', '2025-12-24 17:14:39'),
(272, 6, 191, 100.00, 120.00, 150.00, 1, 100052, '2025-12-24 17:15:22', '2025-12-24 17:15:22', '2025-12-24 17:15:22'),
(273, 3, 191, 1500.00, 2000.00, 15200.00, 1, 100052, '2025-12-24 17:25:21', '2025-12-24 17:25:21', '2025-12-24 17:25:21'),
(274, 3, 191, 1500.00, 2000.00, 15200.00, 1, 100052, '2025-12-24 17:25:44', '2025-12-24 17:25:44', '2025-12-24 17:25:44'),
(275, 1, 191, 120.00, 1230.00, 1250.00, 1, 100054, '2025-12-24 17:34:57', '2025-12-24 17:34:57', '2025-12-24 17:34:57'),
(276, 1, 191, 120.00, 1230.00, 1250.00, 1, 100054, '2025-12-24 17:35:52', '2025-12-24 17:35:52', '2025-12-24 17:35:52'),
(277, 1, 191, 120.00, 1230.00, 1250.00, 1, 100055, '2025-12-24 17:35:52', '2025-12-24 17:35:52', '2025-12-24 17:35:52'),
(278, 3, 191, 1500.00, 2000.00, 15200.00, 1, 100053, '2025-12-24 17:43:20', '2025-12-24 17:43:20', '2025-12-24 17:43:20'),
(279, 3, 191, 1500.00, 2000.00, 15200.00, 1, 100054, '2025-12-24 17:43:20', '2025-12-24 17:43:20', '2025-12-24 17:43:20'),
(280, 1, 191, 120.00, 1230.00, 1250.00, 1, 100054, '2025-12-24 17:51:29', '2025-12-24 17:51:29', '2025-12-24 17:51:29'),
(282, 7, 191, 1.00, 1.00, 1.00, 1, 100054, '2025-12-24 18:15:30', '2025-12-24 18:15:30', '2025-12-24 18:15:30'),
(283, 7, 191, 1.00, 1.00, 1.00, 1, 100056, '2025-12-24 18:15:30', '2025-12-24 18:15:30', '2025-12-24 18:15:30'),
(285, 8, 191, 1.00, 12.00, 12.00, 1, 100063, '2025-12-24 18:25:16', '2025-12-24 18:25:16', '2025-12-24 18:25:16'),
(286, 8, 191, 15000.00, 200.00, 560.00, 1, 100064, '2025-12-24 19:24:43', '2025-12-24 19:24:43', '2025-12-24 19:24:43'),
(287, 8, 193, 33456.00, 678.00, 12.00, 1, 100065, '2025-12-24 19:30:56', '2025-12-24 19:30:56', '2025-12-24 19:30:56'),
(288, 8, 193, 33456.00, 678.00, 12.00, 1, 100066, '2025-12-26 15:22:04', '2025-12-26 15:22:04', '2025-12-26 15:22:04'),
(289, 7, 191, 34.00, 200.00, 100.00, 1, 100057, '2025-12-26 15:27:09', '2025-12-26 15:27:09', '2025-12-26 15:27:09'),
(290, 7, 191, 34.00, 200.00, 100.00, 1, 100057, '2025-12-26 15:28:07', '2025-12-26 15:28:07', '2025-12-26 15:28:07'),
(291, 7, 191, 340.00, 200.00, 100.00, 1, 100058, '2025-12-26 15:28:07', '2025-12-26 15:28:07', '2025-12-26 15:28:07'),
(292, 2, 191, 5555.00, 6777.00, 667.00, NULL, 100006, '2026-02-11 00:01:34', '2026-02-11 00:01:34', '2026-02-11 00:01:34'),
(293, 2, 191, 654.00, 45.00, 45.00, NULL, 100007, '2026-03-04 01:57:01', '2026-03-04 01:57:01', '2026-03-04 01:57:01'),
(294, 2, 191, 343.00, 554.00, 434.00, NULL, 100008, '2026-03-04 04:14:42', '2026-03-04 04:14:42', '2026-03-04 04:14:42'),
(295, 1, 191, 222.00, 333.00, 33.00, 1, 100056, '2026-03-07 02:52:04', '2026-03-07 02:52:04', '2026-03-07 02:52:04'),
(296, 1, 191, 44.00, 22.00, 11.00, 1, 100057, '2026-03-07 02:56:24', '2026-03-07 02:56:24', '2026-03-07 02:56:24'),
(297, 8, 191, 15000.00, 200.00, 560.00, NULL, 100068, '2026-03-07 02:59:02', '2026-03-07 02:59:02', '2026-03-07 02:59:02'),
(298, 8, 191, 15000.00, 200.00, 560.00, NULL, 100069, '2026-03-07 02:59:53', '2026-03-07 02:59:53', '2026-03-07 02:59:53'),
(299, 8, 191, 1.00, 12.00, 12.00, NULL, 100070, '2026-03-07 03:00:43', '2026-03-07 03:00:43', '2026-03-07 03:00:43'),
(300, 1, 191, 22.00, 33.00, 11.00, 1, 100058, '2026-03-07 13:11:07', '2026-03-07 13:11:07', '2026-03-07 13:11:07'),
(301, 2, 191, 344.00, 6.00, 23.00, NULL, 100009, '2026-03-07 23:44:19', '2026-03-07 23:44:19', '2026-03-07 23:44:19'),
(302, 1, 191, 222.00, 6666.00, 334.00, 1, 100062, '2026-03-13 17:00:29', '2026-03-13 17:00:29', '2026-03-13 17:00:29'),
(303, 1, 191, 3455.00, 34.00, 22.00, 1, 100063, '2026-03-13 18:02:22', '2026-03-13 18:02:22', '2026-03-13 18:02:22'),
(304, 1, 191, 990.00, 8.00, 6.00, 1, 100064, '2026-04-03 17:45:06', '2026-04-03 17:45:06', '2026-04-03 17:45:06'),
(305, 1, 191, 990.00, 8.00, 6.00, 1, 100064, '2026-04-03 17:58:03', '2026-04-03 17:58:03', '2026-04-03 17:58:03'),
(306, 1, 191, 990.00, 8.00, 6.00, 1, 100064, '2026-04-03 18:05:05', '2026-04-03 18:05:05', '2026-04-03 18:05:05'),
(307, 2, 191, 23.00, 12.00, 1112.00, NULL, 100012, '2026-04-03 18:09:31', '2026-04-03 18:09:31', '2026-04-03 18:09:31'),
(308, 1, 191, 9272.00, 134.00, 1737.00, 1, 100065, '2026-04-03 18:16:41', '2026-04-03 18:16:41', '2026-04-03 18:16:41'),
(309, 1, 191, 9272.00, 134.00, 1737.00, 1, 100066, '2026-04-03 18:17:05', '2026-04-03 18:17:05', '2026-04-03 18:17:05'),
(310, 2, 191, 936.00, 928.00, 96.00, NULL, 100013, '2026-04-03 18:21:53', '2026-04-03 18:21:53', '2026-04-03 18:21:53'),
(311, 2, 191, 344.00, 6.00, 23.00, NULL, 100014, '2026-04-03 18:23:32', '2026-04-03 18:23:32', '2026-04-03 18:23:32'),
(312, 3, 191, 5.00, 33.00, 22.00, 1, 100055, '2026-04-03 18:30:31', '2026-04-03 18:30:31', '2026-04-03 18:30:31'),
(313, 3, 191, 5.00, 33.00, 22.00, 1, 100055, '2026-04-03 18:32:00', '2026-04-03 18:32:00', '2026-04-03 18:32:00'),
(314, 1, 191, 88282.00, 83828.00, 8282.00, 1, 100067, '2026-04-03 19:26:26', '2026-04-03 19:26:26', '2026-04-03 19:26:26'),
(315, 1, 191, 9272.00, 134.00, 1737.00, 1, 100066, '2026-04-03 19:27:23', '2026-04-03 19:27:23', '2026-04-03 19:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `language_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policies`
--

INSERT INTO `privacy_policies` (`id`, `title`, `description`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2025-11-04 15:34:39', '2025-11-04 15:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Apple', NULL, 1, '2026-03-31 03:26:45', '2026-03-31 03:26:45'),
(2, '2', NULL, 1, '2026-03-31 10:27:00', '2026-03-31 10:27:00'),
(3, 'ma', NULL, 1, '2026-03-31 10:45:09', '2026-03-31 10:45:09'),
(4, '13', NULL, 1, '2026-04-03 21:28:08', '2026-04-03 21:28:08'),
(5, 'cd', NULL, 1, '2026-04-03 21:32:58', '2026-04-03 21:32:58'),
(7, '212', NULL, 1, '2026-04-03 21:41:42', '2026-04-03 21:41:42'),
(8, '2323233', NULL, 1, '2026-04-03 14:52:46', '2026-04-03 14:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_likes`
--

CREATE TABLE `product_likes` (
  `id` int(11) NOT NULL,
  `product_type` varchar(50) DEFAULT NULL,
  `product_row_id` int(11) NOT NULL COMMENT 'The ID of that table row',
  `product_id` int(11) NOT NULL COMMENT 'Common product_id',
  `user_id` int(11) NOT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `like_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = no action, 1 = like, 2 = dislike',
  `created_by` int(11) NOT NULL COMMENT 'User ID',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_likes`
--

INSERT INTO `product_likes` (`id`, `product_type`, `product_row_id`, `product_id`, `user_id`, `device_token`, `like_status`, `created_by`, `created_at`, `updated_at`) VALUES
(20, NULL, 139, 2, 194, NULL, 2, 194, '2025-12-16 12:45:39', '2025-12-23 17:58:41'),
(21, NULL, 138, 2, 194, NULL, 2, 194, '2025-12-16 12:50:25', '2025-12-19 22:15:05'),
(22, NULL, 69, 1, 194, NULL, 2, 194, '2025-12-16 12:50:38', '2025-12-19 22:15:09'),
(23, NULL, 69, 1, 195, NULL, 1, 195, '2025-12-16 13:14:23', '2025-12-16 13:14:28'),
(24, NULL, 139, 2, 195, NULL, 1, 195, '2025-12-16 13:14:24', '2025-12-16 13:14:29'),
(25, NULL, 133, 8, 195, NULL, 1, 195, '2025-12-18 17:36:58', '2025-12-18 17:37:15'),
(26, NULL, 134, 8, 194, NULL, 2, 194, '2025-12-18 20:20:06', '2025-12-24 07:31:58'),
(27, NULL, 133, 8, 194, NULL, 2, 194, '2025-12-18 20:23:14', '2025-12-19 22:15:13'),
(28, NULL, 138, 8, 194, NULL, 2, 194, '2025-12-19 22:14:48', '2025-12-24 07:32:00'),
(29, NULL, 75, 1, 194, NULL, 2, 194, '2025-12-22 14:25:13', '2025-12-22 20:41:22'),
(30, NULL, 100051, 1, 194, NULL, 2, 194, '2025-12-22 20:34:12', '2025-12-22 20:41:27'),
(31, NULL, 134, 8, 195, NULL, 1, 195, '2025-12-23 14:57:25', '2025-12-23 15:07:52'),
(32, NULL, 41, 3, 194, NULL, 2, 194, '2025-12-23 15:16:21', '2025-12-24 07:32:04'),
(33, NULL, 100048, 7, 195, NULL, 2, 195, '2025-12-23 15:19:35', '2025-12-23 15:21:40'),
(34, NULL, 100048, 7, 194, NULL, 2, 194, '2025-12-23 15:20:14', '2025-12-23 17:57:25'),
(35, NULL, 100061, 8, 194, NULL, 1, 194, '2026-02-10 23:46:20', '2026-04-06 20:43:25'),
(36, NULL, 100003, 2, 194, NULL, 1, 194, '2026-05-20 22:33:15', '2026-05-20 22:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `commune` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name_en`, `name_fr`, `country_id`, `name`, `commune`, `district`, `created_at`, `updated_at`) VALUES
(9, NULL, NULL, 2, 'Bas-Sassandra District', 'Bas-Sassandra District', 'Bas-Sassandra District', '2025-11-18 22:07:32', '2026-01-05 18:09:26'),
(10, NULL, NULL, 2, 'Abidjan Autonomous District', 'Abidjan Autonomous District', 'Abidjan Autonomous District', '2025-11-18 22:08:30', '2026-01-05 18:09:10'),
(13, NULL, NULL, 1, 'Eastern Province', 'Eastern Province', 'Eastern Province', '2025-11-19 19:31:17', '2026-01-05 18:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `seed`
--

CREATE TABLE `seed` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `language_id` int(11) DEFAULT 1,
  `related_table_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seed`
--

INSERT INTO `seed` (`id`, `name`, `language_id`, `related_table_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Veterinary Products', 1, NULL, '1761369775_category8.png', '2025-10-25 12:22:55', '2025-10-25 12:22:55'),
(2, 'Animal Feed', 1, NULL, '1761369690_category7.png', '2025-10-25 12:21:30', '2025-10-25 12:21:30'),
(3, 'Synthetic Pesticides', 1, NULL, '1761369618_category6.png', '2025-10-25 12:20:18', '2025-10-25 12:20:18'),
(4, 'Inorganic Soil Conditioners', 1, NULL, '1761369557_category5.png', '2025-10-25 12:19:17', '2025-10-25 12:19:17'),
(5, 'Biostimulants', 1, NULL, '1761369489_category4.png', '2025-10-25 12:18:09', '2025-10-25 12:18:09'),
(6, 'Organic Amendments', 1, NULL, '1761369415_category3.png', '2025-10-25 12:16:55', '2025-10-25 12:16:55'),
(7, 'Mineral Fertilizers', 1, NULL, '1761369281_category2.png', '2025-10-25 12:14:41', '2025-10-25 12:14:41'),
(8, 'Seeds', 1, NULL, '1761369345_category1.png', '2025-10-25 12:15:45', '2025-10-25 12:15:45'),
(9, 'Produits vétérinaires', 2, 1, '1761369775_category8.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(10, 'Aliments pour animaux', 2, 2, '1761369690_category7.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(11, 'Pesticides synthétiques', 2, 3, '1761369618_category6.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(12, 'Amendements inorganiques', 2, 4, '1761369557_category5.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(13, 'Biostimulants', 2, 5, '1761369489_category4.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(14, 'Amendements organiques', 2, 6, '1761369415_category3.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(15, 'Engrais minéraux', 2, 7, '1761369281_category2.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00'),
(16, 'Graines', 2, 8, '1761369345_category1.png', '2025-11-11 12:28:00', '2025-11-11 12:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `seed_fields`
--

CREATE TABLE `seed_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `local_product_name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `seed_fields`
--

INSERT INTO `seed_fields` (`id`, `label`, `name`, `local_product_name`, `type`, `options`, `required`) VALUES
(1, 'Crop name', 'cropName', NULL, 'text', NULL, 1),
(2, 'Verity name', 'verityName', NULL, 'text', NULL, 1),
(3, 'Breeder\'s name', 'breederName', NULL, 'text', NULL, 0),
(4, 'Country of origin', 'countryOrigin', NULL, 'text', NULL, 0),
(5, 'Registration number', 'registrationNumber', NULL, 'text', NULL, 1),
(6, 'Type of variety', 'varietyType', NULL, 'select', '[\"Hybrid\",\"selfPollinated\",\"openPollinatedVariety\"]', 1),
(7, 'Seed category', 'seedCategory', NULL, 'text', NULL, 0),
(8, 'Precocity', 'precocity', NULL, 'text', NULL, 0),
(9, 'Fruit color', 'fruitColor', NULL, 'text', NULL, 0),
(10, 'Fruit shape', 'fruitShape', NULL, 'text', NULL, 0),
(11, 'Leaf length', 'leafLength', NULL, 'text', NULL, 0),
(12, 'Leaf color', 'leafColor', NULL, 'text', NULL, 0),
(13, 'Plant height (cm)', 'plantHeight', NULL, 'text', NULL, 0),
(14, 'Plant habit', 'plantHabit', NULL, 'select', '[\"erected\",\"semiErect\",\"bushy\",\"virgate\",\"intracate\",\"divaricate\",\"surckers\",\"coppiceShoots\",\r\n   \"lignotuber\",\"epiphytes\",\"decumbent\",\"procumbent\",\"prostrate\",\"stoloniferous\",\"rhizomatous\",\"pendent\"]', 1),
(15, 'Biotic resistance', 'bioticResistance', NULL, 'text', NULL, 0),
(16, 'Abiotic resistance', 'abioticResistance', NULL, 'text', NULL, 0),
(17, 'Inherent Nutritional Value', 'InherentNutritionalValue', NULL, 'select', '[\"Rich in Beta-carotene\",\"Rich in Vitamin C\",\"Rich in Iron\",\"Rich in Antioxidant\",\"Other\"]', 1),
(18, 'Other', 'other', NULL, 'text', NULL, 0),
(19, 'Yield (t/ha)', 'yield', NULL, 'text', NULL, 0),
(20, 'Other recommendations', 'otherRecommendations', NULL, 'text', NULL, 0),
(21, 'Other recommendations (photo)', 'otherRecommendationsPhoto', NULL, 'file', NULL, 0),
(22, 'Average wholesale prices', 'wholesalePrice', NULL, 'number', NULL, 1),
(23, 'Average semi-wholesalers price', 'semiwholesalePrice', NULL, 'number', NULL, 1),
(24, 'Average retail prices', 'retailPrice', NULL, 'number', NULL, 1),
(25, 'Local produt name', 'localProductName', NULL, 'text', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seed_fields_english_french`
--

CREATE TABLE `seed_fields_english_french` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `language_id` tinyint(1) NOT NULL DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `seed_fields_english_french`
--

INSERT INTO `seed_fields_english_french` (`id`, `product_id`, `language_id`, `label`, `name`, `type`, `options`, `required`, `form_type`) VALUES
(1, 8, 1, 'Crop Name', 'cropName', 'text', NULL, 1, ''),
(2, 8, 1, 'Variety Name', 'verityName', 'text', NULL, 1, ''),
(3, 8, 1, 'Breeder Name', 'breederName', 'text', NULL, 1, ''),
(4, 8, 1, 'Country of Origin', 'countryOrigin', 'text', NULL, 1, ''),
(5, 8, 1, 'Registration Number', 'registrationNumber', 'text', NULL, 1, ''),
(6, 8, 1, 'Variety Type', 'varietyType', 'radio', '[\"Hybrid\",\"Self-pollinated\",\"Open-pollinated variety\"]', 1, ''),
(7, 8, 1, 'Seed Category', 'seedCategory', 'text', NULL, 1, ''),
(8, 8, 1, 'Earliness', 'precocity', 'text', NULL, 1, ''),
(9, 8, 1, 'Fruit Color', 'fruitColor', 'text', NULL, 1, ''),
(10, 8, 1, 'Fruit Shape', 'fruitShape', 'text', NULL, 1, ''),
(11, 8, 1, 'Leaf Length', 'leafLength', 'text', NULL, 1, ''),
(12, 8, 1, 'Leaf Color', 'leafColor', 'text', NULL, 1, ''),
(13, 8, 1, 'Plant Height', 'plantHeight', 'text', NULL, 1, ''),
(14, 8, 1, 'Plant Habit', 'plantHabit', 'radio', '[\"Upright\",\"Semi-upright\",\"Bushy\",\"Virginal\",\"Trailing\",\"Divaricate\",\"Sucker\",\"Coptic shoots\",\"Lignotuber\",\"Epiphytes\",\"Decumbent\",\"Apron\",\"Prostrate\",\"Stoloniferous\",\"Rhizomatous\",\"Pendant\"]', 1, ''),
(15, 8, 1, 'Biotic Resistance', 'bioticResistance', 'text', NULL, 1, ''),
(16, 8, 1, 'Abiotic Resistance', 'abioticResistance', 'text', NULL, 1, ''),
(17, 8, 1, 'Inherent Nutritional Value', 'InherentNutritionalValue', 'radio', '[\"Rich in beta-carotene\",\"Rich in vitamin C\",\"Rich in iron\",\"Rich in antioxidants\",\"Other\"]', 1, ''),
(18, 8, 1, 'Yield (t/ha)', 'yield', 'text', NULL, 1, ''),
(19, 8, 1, 'Other Recommendations (Text)', 'otherRecommendations', 'text', NULL, 1, ''),
(20, 8, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(21, 8, 1, 'Average Wholesale Prices', 'wholesalePrice', 'text', NULL, 1, ''),
(22, 8, 1, 'Average Semi-Wholesale Prices', 'semiwholesalePrice', 'text', NULL, 1, ''),
(23, 8, 1, 'Average Retail Prices', 'retailPrice', 'text', NULL, 1, ''),
(24, 8, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(25, 8, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(26, 8, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(27, 8, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(28, 8, 2, 'Nom de la culture', 'cropName', 'text', NULL, 1, ''),
(29, 8, 2, 'Nom de la variété', 'verityName', 'text', NULL, 1, ''),
(30, 8, 2, 'Nom de l\'obtenteur', 'breederName', 'text', NULL, 1, ''),
(31, 8, 2, 'Pays d\'origine', 'countryOrigin', 'text', NULL, 1, ''),
(32, 8, 2, 'Numéro d\'enregistrement', 'registrationNumber', 'text', NULL, 1, ''),
(33, 8, 2, 'Type de variété', 'varietyType', 'radio', '[\"Hybride\",\"Autogame\",\"Variété à pollinisation libre\"]', 1, ''),
(34, 8, 2, 'Catégorie de semences', 'seedCategory', 'text', NULL, 1, ''),
(35, 8, 2, 'Précocité', 'earliness', 'text', NULL, 1, ''),
(36, 8, 2, 'Couleur du fruit', 'fruitColor', 'text', NULL, 1, ''),
(37, 8, 2, 'Forme du fruit', 'fruitShape', 'text', NULL, 1, ''),
(38, 8, 2, 'Longueur des feuilles', 'leafLength', 'text', NULL, 1, ''),
(39, 8, 2, 'Couleur des feuilles', 'leafColor', 'text', NULL, 1, ''),
(40, 8, 2, 'Hauteur de la plante', 'plantHeight', 'text', NULL, 1, ''),
(41, 8, 2, 'Port de la plante', 'plantHabit', 'radio', '[\"Dressé\",\"Semi-dressé\",\"Buissonneux\",\"Virginal\",\"Entraînant\",\"Divariqué\",\"Drageonnant\",\"Pousses de taillis\",\"Lignotubercule\",\"Épiphytes\",\"Décombant\",\"Tablier\",\"Prostré\",\"Stolonifère\",\"Rhizomateux\",\"Pendant\"]', 1, ''),
(42, 8, 2, 'Résistance biotique', 'bioticResistance', 'text', NULL, 1, ''),
(43, 8, 2, 'Résistance abiotique', 'abioticResistance', 'text', NULL, 1, ''),
(44, 8, 2, 'Valeur nutritionnelle inhérente', 'nutritional_value', 'radio', '[\"Riche en bêta-carotène\",\"Riche en vitamine C\",\"Riche en fer\",\"Riche en antioxydants\",\"Autre\"]', 1, ''),
(45, 8, 2, 'Rendement (t/ha)', 'yield', 'text', NULL, 1, ''),
(46, 8, 2, 'Autres recommandations (texte)', 'other', 'text', NULL, 1, ''),
(47, 8, 2, 'Autres recommandations (photo)', 'otherRecommendations', 'file', NULL, 1, ''),
(48, 8, 2, 'Prix de gros moyen', 'wholesalePrice', 'text', NULL, 1, ''),
(49, 8, 2, 'Prix semi-grossiste moyen', 'semiwholesalePrice', 'text', NULL, 1, ''),
(50, 8, 2, 'Prix de détail moyen', 'retailPrice', 'text', NULL, 1, ''),
(51, 8, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(52, 8, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(53, 8, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(54, 8, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(55, 7, 1, 'Type of fertilizer*', 'fertilizer_type', 'text', NULL, 1, ''),
(56, 7, 1, 'Registration number*', 'fertilizer_registration', 'text', NULL, 1, ''),
(57, 7, 1, 'Physical form*', 'physical_form', 'radio', '[\"Liquid\",\"Solid granules\",\"Powder\"]', 1, ''),
(58, 7, 1, 'Trade name (Urea, NPK, TSP, KCl, etc.)', 'trade_name', 'text', NULL, 0, ''),
(59, 7, 1, '% N', 'n', 'number', NULL, 0, ''),
(60, 7, 1, '% P?O?', 'p2', 'number', NULL, 0, ''),
(61, 7, 1, '% K?O', 'k2', 'number', NULL, 0, ''),
(62, 7, 1, '% Zn', 'zn', 'number', NULL, 0, ''),
(63, 7, 1, '% Ca', 'ca', 'number', NULL, 0, ''),
(64, 7, 1, '% Mg', 'mg', 'number', NULL, 0, ''),
(65, 7, 1, '% S', 's', 'number', NULL, 0, ''),
(66, 7, 1, '% B', 'b', 'number', NULL, 0, ''),
(67, 7, 1, '% Mo', 'mo', 'number', NULL, 0, ''),
(68, 7, 1, 'Application rate per hectare', 'application_rate', 'text', NULL, 0, ''),
(69, 7, 1, 'Average wholesale prices by packaging type', 'fertilizer_wholesale_price', 'number', NULL, 1, ''),
(70, 7, 1, 'Average semi-wholesalers price by packaging type', 'fertilizer_semiwholesale_price', 'number', NULL, 1, ''),
(71, 7, 1, 'Average retail prices by packaging type', 'fertilizer_retail_price', 'number', NULL, 1, ''),
(72, 7, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(73, 7, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(74, 7, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(75, 7, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(76, 7, 2, 'Type d\'engrais (exemple : 15-15-15)', 'fertilizer_type', 'text', NULL, 1, ''),
(77, 7, 2, 'Numéro d\'enregistrement', 'fertilizer_registration', 'text', NULL, 1, ''),
(78, 7, 2, 'Forme physique', 'physical_form', 'radio', '[\"Liquide\",\"Granulés solides\",\"Poudre\"]', 1, ''),
(79, 7, 2, 'Nom commercial (urée, NPK, TSP, KCI, etc.)', 'trade_name', 'text', NULL, 0, ''),
(80, 7, 2, '% N', 'n', 'number', NULL, 0, ''),
(81, 7, 2, '% P?O?', 'p2', 'number', NULL, 0, ''),
(82, 7, 2, '% K?O', 'k2', 'number', NULL, 0, ''),
(83, 7, 2, '% Zn', 'zn', 'number', NULL, 0, ''),
(84, 7, 2, '% Ca', 'ca', 'number', NULL, 0, ''),
(85, 7, 2, '% Mg', 'mg', 'number', NULL, 0, ''),
(86, 7, 2, '% S', 's', 'number', NULL, 0, ''),
(87, 7, 2, '% B', 'b', 'number', NULL, 0, ''),
(88, 7, 2, '% Mo', 'mo', 'number', NULL, 0, ''),
(89, 7, 2, 'Dose d\'application par hectare', 'application_rate', 'text', NULL, 0, ''),
(90, 7, 2, 'Prix de gros moyen par type d\'emballage', 'fertilizer_wholesale_price', 'number', NULL, 1, ''),
(91, 7, 2, 'Prix semi-grossiste moyen par type d\'emballage', 'fertilizer_semiwholesale_price', 'number', NULL, 1, ''),
(92, 7, 2, 'Prix de détail moyen par type d\'emballage', 'fertilizer_retail_price', 'number', NULL, 1, ''),
(93, 7, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(94, 7, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(95, 7, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(96, 7, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(97, 6, 1, 'Type of organic amendment (compost, vermicompost, bokashi, etc.)', 'organic_type', 'text', NULL, 1, ''),
(98, 6, 1, 'Physical form', 'physical_form', 'radio', '[\"Liquid\",\"Solid Granules\",\"Powder\"]', 1, ''),
(99, 6, 1, 'Trade Name', 'trade_name', 'text', NULL, 1, ''),
(100, 6, 1, 'Country of Origin', 'country_origin', 'text', NULL, 1, ''),
(101, 6, 1, 'Organic Label Name, if applicable', 'bio_label', 'text', NULL, 1, ''),
(102, 6, 1, '%N', 'n', 'number', NULL, 1, ''),
(103, 6, 1, '%P205', 'p2', 'number', NULL, 1, ''),
(104, 6, 1, '%K20', 'k2', 'number', NULL, 1, ''),
(105, 6, 1, '%Cao', 'cao', 'number', NULL, 1, ''),
(106, 6, 1, '%Mg0', 'mgo', 'number', NULL, 1, ''),
(107, 6, 1, 'C/N', 'cn_ratio', 'text', NULL, 1, ''),
(108, 6, 1, 'Raw material', 'raw_material', 'checkbox', '[\"Crop residues\",\n    \"Agro-industrial by-products\",\n    \"Slurry\",\n    \"Manure\",\n    \"Animal manure\",\n    \"Other\"\n]', 1, ''),
(109, 6, 1, 'Arsenic content less than 10 mg/kg', 'raw_material_other', 'radio', '[\"Yes\",\"No\"]', 1, ''),
(110, 6, 1, 'Cadmium content less than 5 mg/kg', 'arsenic_content', 'radio', '[\"Yes\",\"No\"]', 1, ''),
(111, 6, 1, 'Chromium content less than 50 mg/kg', 'chromium_content', 'radio', '[\"Yes\",\"No\"]', 1, ''),
(112, 6, 1, 'Copper content less than 300 mg/kg', 'copper_content', 'radio', '[\"Yes\",\"No\"]', 1, ''),
(113, 6, 1, 'Lead content less than 100 mg/kg', 'lead_content', 'radio', '[\"Yes\",\"No\"]', 1, ''),
(114, 6, 1, 'Average wholesale prices by packaging type', 'wholesale_price', 'text', NULL, 1, ''),
(115, 6, 1, 'Average semi-wholesale price by packaging type', 'semiwholesale_price', 'text', NULL, 1, ''),
(116, 6, 1, 'Average retail prices by packaging type', 'retail_price', 'text', NULL, 1, ''),
(117, 6, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(118, 6, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(119, 6, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(120, 6, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(121, 6, 2, 'Type d\'amendement organique (compost, lombricompost, bokashi, etc.)', 'organic_type', 'text', NULL, 1, ''),
(122, 6, 2, 'Forme physique', 'physical_form', 'radio', '[\"Liquide\",\"Granulés solides\",\"Poudre\"]', 1, ''),
(123, 6, 2, 'Nom commercial', 'trade_name', 'text', NULL, 1, ''),
(124, 6, 2, 'Pays d\'origine', 'country_origin', 'text', NULL, 1, ''),
(125, 6, 2, 'Nom de l\'étiquette biologique, le cas échéant', 'bio_label', 'text', NULL, 1, ''),
(126, 6, 2, '%N', 'n', 'number', NULL, 1, ''),
(127, 6, 2, '%P205', 'p2', 'number', NULL, 1, ''),
(128, 6, 2, '%K20', 'k2', 'number', NULL, 1, ''),
(129, 6, 2, '%Cao', 'cao', 'number', NULL, 1, ''),
(130, 6, 2, '%Mg0', 'mgo', 'number', NULL, 1, ''),
(131, 6, 2, 'C/N', 'cn_ratio', 'number', NULL, 1, ''),
(132, 6, 2, 'Matière première', 'raw_material', 'checkbox', '[\n        \"Crop residues\",\n        \"Agro-industrial by-products\",\n        \"Slurry\",\n        \"Manure\",\n        \"Animal manure\",\n        \"Other\"\n    ]', 1, ''),
(133, 6, 2, 'Teneur en arsenic inférieure à 10 mg/kg', 'raw_material_other', 'radio', '[\"Oui\",\"Non\"]', 1, ''),
(134, 6, 2, 'Teneur en cadmium inférieure à 5 mg/kg', 'arsenic_content', 'radio', '[\"Oui\",\"Non\"]', 1, ''),
(135, 6, 2, 'Teneur en chrome inférieure à 50 mg/kg', 'chromium_content', 'radio', '[\"Oui\",\"Non\"]', 1, ''),
(136, 6, 2, 'Teneur en cuivre inférieure à 300 mg/kg', 'copper_content', 'radio', '[\"Oui\",\"Non\"]', 1, ''),
(137, 6, 2, 'Teneur en plomb inférieure à 100 mg/kg', 'lead_content', 'radio', '[\"Oui\",\"Non\"]', 1, ''),
(138, 6, 2, 'Prix de gros moyen par type d\'emballage', 'wholesale_price', 'text', NULL, 1, ''),
(139, 6, 2, 'Prix de semi-gros moyen par type d\'emballage', 'semiwholesale_price', 'text', NULL, 1, ''),
(140, 6, 2, 'Prix de détail moyen par type d\'emballage', 'retail_price', 'text', NULL, 1, ''),
(141, 6, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(142, 6, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(143, 6, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(144, 6, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(145, 5, 1, 'Trade name', 'trade_name', 'text', NULL, 1, ''),
(146, 5, 1, 'Physical Form', 'physical_form', 'radio', '[\"Liquid\",\"Solid Granules\",\"Powder\"]', 1, ''),
(147, 5, 1, 'Biostimulants product name', 'biostimulant_product', 'radio', '[\"Bacteria\",\"Fungi\",\"Yeast\",\"Purified Plant Extracts\",\"Vitamins\",\"Rock Powder\"]', 1, ''),
(148, 5, 1, 'Registration number', 're_registration', 'text', NULL, 1, ''),
(149, 5, 1, '%N', 'n', 'text', NULL, 1, ''),
(150, 5, 1, '%P205', 'p2', 'text', NULL, 1, ''),
(151, 5, 1, '%K20', 'k2', 'text', NULL, 1, ''),
(152, 5, 1, '%Zn', 'zn', 'text', NULL, 1, ''),
(153, 5, 1, '%Ca', 'ca', 'text', NULL, 1, ''),
(154, 5, 1, '%Mg', 'mg', 'text', NULL, 1, ''),
(155, 5, 1, '%S', 's', 'text', NULL, 1, ''),
(156, 5, 1, '8%', 'b', 'text', NULL, 1, ''),
(157, 5, 1, '%Mo', 'mo', 'text', NULL, 1, ''),
(158, 5, 1, 'Mode of Action', 'action_mode', 'text', NULL, 1, ''),
(159, 5, 1, 'Average Wholesale Prices by Packaging Type', 'wholesale_price', 'text', NULL, 1, ''),
(160, 5, 1, 'Average Semi-Wholesale Prices by Packaging Type', 'semiwholesale_price', 'text', NULL, 1, ''),
(161, 5, 1, 'Average Retail Prices by Packaging Type', 'retail_price', 'text', NULL, 1, ''),
(162, 5, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(163, 5, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(164, 5, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(165, 5, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(166, 5, 2, 'Nom commercial', 'trade_name', 'text', NULL, 1, ''),
(167, 5, 2, 'Forme physique', 'physical_form', 'radio', '[\"Liquide\",\"Granulés solides\",\"Poudre\"]', 1, ''),
(168, 5, 2, 'Nom du produit biostimulant', 'biostimulant_product', 'radio', '[\"Bactéries\",\"Champignons\",\"Levure\",\"Extraits végétaux purifiés\",\"Vitamines\",\"Poudre de roche\"]', 1, ''),
(169, 5, 2, 'Numéro d\'enregistrement', 're_registration', 'text', NULL, 1, ''),
(170, 5, 2, '%N', 'n', 'text', NULL, 1, ''),
(171, 5, 2, '%P205', 'p2', 'text', NULL, 1, ''),
(172, 5, 2, '%K20', 'k2', 'text', NULL, 1, ''),
(173, 5, 2, '%Zn', 'zn', 'text', NULL, 1, ''),
(174, 5, 2, '%Ca', 'ca', 'text', NULL, 1, ''),
(175, 5, 2, '%Mg', 'mg', 'text', NULL, 1, ''),
(176, 5, 2, '%S', 's', 'text', NULL, 1, ''),
(177, 5, 2, '8%', 'b', 'text', NULL, 1, ''),
(178, 5, 2, '%Mo', 'mo', 'text', NULL, 1, ''),
(179, 5, 2, 'Mode d\'action', 'action_mode', 'text', NULL, 1, ''),
(180, 5, 2, 'Prix de gros moyen par type d\'emballage', 'wholesale_price', 'text', NULL, 1, ''),
(181, 5, 2, 'Prix semi-grossiste moyen par type d\'emballage', 'semiwholesale_price', 'text', NULL, 1, ''),
(182, 5, 2, 'Prix de détail moyen par type d\'emballage', 'retail_price', 'text', NULL, 1, ''),
(183, 5, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(184, 5, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(185, 5, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(186, 5, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(187, 4, 1, 'Conditioner type (example: lime, gypsum)', 'conditioner_type', 'text', NULL, 1, ''),
(188, 4, 1, 'Physical Form', 'physical_form', 'radio', '[\"Liquid\",\"Solid\",\"Powder\"]', 1, ''),
(189, 4, 1, 'Trade name', 'trade_name', 'text', NULL, 1, ''),
(190, 4, 1, 'Raw material', 'raw_material', 'radio', '[\"Limestone\",\"Slate\",\"Gypsum\",\"Glauconite\",\"Other\"]', 1, ''),
(191, 4, 1, 'Function', 'function', 'text', NULL, 1, ''),
(192, 4, 1, 'Average wholesale price by packaging type', 'wholesale_price', 'text', NULL, 1, ''),
(193, 4, 1, 'Average semi-wholesale price by packaging type', 'semiwholesale_price', 'text', NULL, 1, ''),
(194, 4, 1, 'Average retail price by packaging type', 'retail_price', 'text', NULL, 1, ''),
(195, 4, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(196, 4, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(197, 4, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(198, 4, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(199, 4, 2, 'Type de conditionneur (exemple : chaux, gypse)', 'conditioner_type', 'text', NULL, 1, ''),
(200, 4, 2, 'Forme physique', 'physical_form', 'radio', '[\"Liquide\",\"Granulé\",\"Poudre\"]', 1, ''),
(201, 4, 2, 'Nom commercial', 'trade_name', 'text', NULL, 1, ''),
(202, 4, 2, 'Matière première', 'raw_material', 'radio', '[\"Calcaire\",\"Ardoise\",\"Gypse\",\"Glauconite\",\"Autre\"]', 1, ''),
(203, 4, 2, 'Fonction', 'function', 'text', NULL, 1, ''),
(204, 4, 2, 'Prix de gros moyen par type d\'emballage', 'wholesale_price', 'text', NULL, 1, ''),
(205, 4, 2, 'Prix semi-grossiste moyen par type d\'emballage', 'semiwholesale_price', 'text', NULL, 1, ''),
(206, 4, 2, 'Prix de détail moyen par type d\'emballage', 'retail_price', 'text', NULL, 1, ''),
(207, 4, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(208, 4, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(209, 4, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(210, 4, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(211, 3, 1, 'Trade Name', 'trade_name', 'text', NULL, 1, ''),
(212, 3, 1, 'Active ingredient(s)', 'active_ingredient', 'radio', '[\"Deltamethrin 24 g/day\",\"Acetamiprid 32 g/day\",\"Glyphosate 360 g/day\",\"Other\"]', 1, ''),
(213, 3, 1, 'Formulation', 'formulation', 'radio', '[\"A: Aerosol\",\"D or DU: Dust or Powder\",\"E or EC: Emulsifiable Concentrate\",\"F: Flowable Paste\",\"G or GR: Granule\",\"P: Tablet\",\"S: Solution\",\"SC: Sprayable Concentrate\",\"SP: Soluble Powder\",\"ULC: Ultra Low Volume Concentrate\",\"WDG: Water Dispersible Granules\",\"W or WP: Wettable Powder\",\"WS: Water Soluble Concentrate\"]', 1, ''),
(214, 3, 1, 'Registration number', 'registration_number', 'text', NULL, 1, ''),
(215, 3, 1, 'Function', 'function', 'radio', '[\"Non-selective systemic herbicide\",\"Rice herbicide\",\"Cotton herbicide\",\"Post-emergence corn herbicide\",\"Rice insecticide\",\"Larval biopesticide\",\"Other\"]', 1, ''),
(216, 3, 1, 'Toxicological class and number', 'toxicological_class_number', 'text', NULL, 1, ''),
(217, 3, 1, 'Approval number', 'approval_number', 'text', NULL, 1, ''),
(218, 3, 1, 'Average wholesale price by packaging type', 'wholesale_price', 'text', NULL, 1, ''),
(219, 3, 1, 'Average semi-wholesale price by packaging type', 'semiwholesale_price', 'text', NULL, 1, ''),
(220, 3, 1, 'Average retail price by packaging type', 'retail_price', 'text', NULL, 1, ''),
(221, 3, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(222, 3, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(223, 3, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(224, 3, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(225, 3, 2, 'Nom commercial', 'trade_name', 'text', NULL, 1, ''),
(226, 3, 2, 'Ingrédient(s) actif(s)', 'active_ingredient', 'radio', '[\"Deltaméthrine 24 j/1\",\"Acétamipride 32 g/1\",\"Glyphosate 360 g/1\",\"Autre\"]', 1, ''),
(227, 3, 2, 'Formulation', 'formulation', 'radio', '[\"A : Aérosol\",\"D ou DU : Poussière ou poudre\",\"E ou EC : Concentré émulsifiable\",\"F : Pâte fluide\",\"G ou GR : Granulé\",\"P : Pastille\",\"S : Solution\",\"SC : Concentré pulvérisable\",\"SP : Poudre soluble\",\"ULC : Concentré à très faible volume\",\"WDG : Granulés hydrodispersibles\",\"W ou WP : Poudre mouillable\",\"WS : Concentré hydrosoluble\"]', 1, ''),
(228, 3, 2, 'Numéro d\'enregistrement', 'registration_number', 'text', NULL, 1, ''),
(229, 3, 2, 'Fonction', 'function', 'radio', '[\"Herbicide systémique non sélectif\",\"Herbicide pour le riz\",\"Herbicide pour le coton\",\"Herbicide de post-levée pour le maïs\",\"Insecticide pour le riz\",\"Biopesticide larvaire\",\"Autre\"]', 1, ''),
(230, 3, 2, 'Classe et numéro toxicologiques', 'toxicological_class_number', 'text', NULL, 1, ''),
(231, 3, 2, 'Numéro d\'agrément', 'approval_number', 'text', NULL, 1, ''),
(232, 3, 2, 'Prix de gros moyen par type d\'emballage', 'wholesale_price', 'text', NULL, 1, ''),
(233, 3, 2, 'Prix semi-grossiste moyen par type d\'emballage', 'semiwholesale_price', 'text', NULL, 1, ''),
(234, 3, 2, 'Prix de détail moyen par type d\'emballage', 'retail_price', 'text', NULL, 1, ''),
(235, 3, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(236, 3, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(237, 3, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(238, 3, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(239, 2, 1, 'Type of animal feed', 'Typeoffeed', 'radio', '[\"Start of breeding\",\"Chicken\",\"Layers\",\"Breast\",\"All ruminants\",\"Dairy cow\",\"Filling\",\"Horses\",\"Pigs\",\"Others\"]', 1, ''),
(240, 2, 1, 'Raw materials (inputs used in the production of animal feed)', 'title', 'text', NULL, 1, ''),
(241, 2, 1, 'Physical form (granules, flour, crumbs)', 'afPhysicalform', 'radio', '[\"Granules\",\"Flour\",\"Crumbs\"]', 1, ''),
(242, 2, 1, '% Dry Matter (DM)', 'afdm', 'text', NULL, 1, ''),
(243, 2, 1, '% Energy (UF, kcal)', 'afEnergy', 'text', NULL, 1, ''),
(244, 2, 1, '% Crude Protein', 'afcp', 'text', NULL, 1, ''),
(245, 2, 1, 'Shelf Life', 'affs', 'text', NULL, 1, ''),
(246, 2, 1, 'Feed Supplements', 'afrm', 'text', NULL, 1, ''),
(247, 2, 1, 'Average Wholesale Prices by Packaging Type', 'afsemiwholesalePrice', 'text', NULL, 1, ''),
(248, 2, 1, 'Average Semi-Wholesale Prices by Packaging Type', 'afWholesalePrice', 'text', NULL, 1, ''),
(249, 2, 1, 'Average Retail Prices by Packaging Type', 'afretailPrice', 'text', NULL, 1, ''),
(250, 2, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(251, 2, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(252, 2, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(253, 2, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(254, 2, 2, 'Type d\'alimentation animale', 'Typeoffeed', 'radio', '[\"Début de l\'élevage\",\"Poulet\",\"Pondeuses\",\"Chaise\",\"Tous les ruminants\",\"Vache laitière\",\"Remplissage\",\"Équidés\",\"Porcs\",\"Autres\"]', 1, ''),
(255, 2, 2, 'Matières premières (intrants utilisés dans la production d\'aliments pour animaux)', 'title', 'text', NULL, 1, ''),
(256, 2, 2, 'Forme physique (granulés, farine, miettes)', 'afPhysicalform', 'radio', '[\"Granulés\",\"Farine\",\"Miettes\"]', 1, ''),
(257, 2, 2, '% Matière sèche (MS)', 'afdm', 'text', NULL, 1, ''),
(258, 2, 2, '% Énergie (UF, kcal)', 'afEnergy', 'text', NULL, 1, ''),
(259, 2, 2, '% Protéines brutes', 'afcp', 'text', NULL, 1, ''),
(260, 2, 2, 'Durée de conservation', 'affs', 'text', NULL, 1, ''),
(261, 2, 2, 'Compléments alimentaires', 'afrm', 'text', NULL, 1, ''),
(262, 2, 2, 'Prix de gros moyen par type d\'emballage', 'afsemiwholesalePrice', 'text', NULL, 1, ''),
(263, 2, 2, 'Prix semi-grossiste moyen par type d\'emballage', 'afWholesalePrice', 'text', NULL, 1, ''),
(264, 2, 2, 'Prix de détail moyen par type d\'emballage', 'afretailPrice', 'text', NULL, 1, ''),
(265, 2, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(266, 2, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(267, 2, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(268, 2, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(269, 1, 1, 'Veterinary Product Name', 'product_name', 'text', NULL, 1, ''),
(270, 1, 1, 'Name of Manufacturing Laboratory (information on the laboratory that markets the product: Bayer, Zeotis, Vetoquinol, Ceva, etc.)', 'manufacturing_lab', 'text', NULL, 1, ''),
(271, 1, 1, 'Active Ingredient', 'active_substance', 'text', NULL, 1, ''),
(272, 1, 1, 'Registration Number', 'registration_number', 'text', NULL, 1, ''),
(273, 1, 1, 'Therapeutic class', 'therapeutic_class', 'radio', '[\"Pest Control\",\"Antibiotics\",\"Vaccines\",\"Others\"]', 1, ''),
(274, 1, 1, 'Dosage', 'dosage', 'text', NULL, 1, ''),
(275, 1, 1, 'Pharmaceutical form', 'pharmaceutical_form', 'text', NULL, 1, ''),
(276, 1, 1, 'Route of administration', 'route_of_administration', 'text', NULL, 1, ''),
(277, 1, 1, 'Target animals', 'targeted_animals', 'text', NULL, 1, ''),
(278, 1, 1, 'Withdrawal period', 'waiting_period', 'text', NULL, 1, ''),
(279, 1, 1, 'Expiration date', 'expiry_date', 'date', NULL, 1, ''),
(280, 1, 1, 'Transport and storage conditions (vaccines at room temperature, do not expose to sunlight)', 'transport_storage_requirements', 'text', NULL, 1, ''),
(281, 1, 1, 'Average wholesale prices by type of packaging', 'wholesale_price', 'text', NULL, 1, ''),
(282, 1, 1, 'Average semi-wholesaler selling prices by type of packaging', 'semiwholesale_price', 'text', NULL, 1, ''),
(283, 1, 1, 'Average retail selling prices by type of packaging', 'retail_price', 'text', NULL, 1, ''),
(284, 1, 1, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(285, 1, 1, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(286, 1, 1, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(287, 1, 1, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(288, 1, 2, 'Nom du produit vétérinaire', 'product_name', 'text', NULL, 1, ''),
(289, 1, 2, 'Nom du laboratoire de fabrication (informations sur le laboratoire qui commercialise le produit : Bayer, Zeotis, Vetoquinol, Ceva, etc.)', 'manufacturing_lab', 'text', NULL, 1, ''),
(290, 1, 2, 'Substance active', 'active_substance', 'text', NULL, 1, ''),
(291, 1, 2, 'Numéro d\'enregistrement', 'registration_number', 'text', NULL, 1, ''),
(292, 1, 2, 'Classe thérapeutique', 'therapeutic_class', 'radio', '[\"Lutte antiparasitaire\",\"Antibiotiques\",\"Vaccins\",\"Autres\"]', 1, ''),
(293, 1, 2, 'Posologie', 'dosage', 'text', NULL, 1, ''),
(294, 1, 2, 'Forme pharmaceutique', 'pharmaceutical_form', 'text', NULL, 1, ''),
(295, 1, 2, 'Voie d\'administration', 'route_of_administration', 'text', NULL, 1, ''),
(296, 1, 2, 'Animaux ciblés', 'targeted_animals', 'text', NULL, 1, ''),
(297, 1, 2, 'Délai d\'attente', 'waiting_period', 'text', NULL, 1, ''),
(298, 1, 2, 'Date de péremption', 'expiry_date', 'date', NULL, 1, ''),
(299, 1, 2, 'Conditions de transport et de stockage (vaccins à température ambiante, ne pas exposer au soleil)', 'transport_storage_requirements', 'text', NULL, 1, ''),
(300, 1, 2, 'Prix de gros moyen par type d\'emballage', 'wholesale_price', 'text', NULL, 1, ''),
(301, 1, 2, 'Prix de vente moyen des semi-grossistes par type d\'emballage', 'semiwholesale_price', 'text', NULL, 1, ''),
(302, 1, 2, 'Prix de vente au détail moyen par type d\'emballage', 'retail_price', 'text', NULL, 1, ''),
(303, 1, 2, 'Product ID', 'product_id', 'hidden', NULL, 1, ''),
(304, 1, 2, 'Supplier ID', 'supplier_id', 'hidden', NULL, 0, ''),
(305, 1, 2, 'Agent ID', 'agent_id', 'hidden', NULL, 0, ''),
(306, 1, 2, 'Created By', 'created_by', 'hidden', NULL, 0, ''),
(307, 4, 1, 'Other', 'other', 'text', NULL, 0, 'input'),
(308, 4, 2, 'Autre', 'other', 'text', NULL, 0, 'input'),
(311, 7, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(312, 7, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, '7'),
(313, 6, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(314, 6, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(315, 5, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(316, 5, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(317, 4, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(318, 4, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(319, 3, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(320, 3, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(321, 2, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(322, 2, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(323, 1, 1, 'Other Recommendations (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(324, 1, 2, 'Other Recommendationsfr (Photo)', 'otherRecommendationsPhoto', 'file', NULL, 1, ''),
(325, 1, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(326, 2, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(327, 3, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(328, 4, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(329, 5, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(330, 6, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(331, 7, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(332, 8, 1, 'Local Product Name', 'localProductName', 'text', NULL, 0, 'form'),
(333, 1, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(334, 2, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(335, 3, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(336, 4, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(337, 5, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(338, 6, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(339, 7, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form'),
(340, 8, 2, 'Nom du produit local', 'localProductName', 'text', NULL, 0, 'form');

-- --------------------------------------------------------

--
-- Table structure for table `seed_forms`
--

CREATE TABLE `seed_forms` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `cropName` varchar(255) NOT NULL,
  `verityName` varchar(255) NOT NULL,
  `breederName` varchar(255) DEFAULT NULL,
  `countryOrigin` varchar(255) DEFAULT NULL,
  `registrationNumber` varchar(255) NOT NULL,
  `varietyType` varchar(255) DEFAULT NULL,
  `seedCategory` varchar(255) DEFAULT NULL,
  `precocity` varchar(255) DEFAULT NULL,
  `fruitColor` varchar(255) DEFAULT NULL,
  `fruitShape` varchar(255) DEFAULT NULL,
  `leafLength` varchar(255) DEFAULT NULL,
  `leafColor` varchar(255) DEFAULT NULL,
  `plantHeight` varchar(255) DEFAULT NULL,
  `plantHabit` varchar(255) DEFAULT NULL,
  `bioticResistance` varchar(255) DEFAULT NULL,
  `abioticResistance` varchar(255) DEFAULT NULL,
  `InherentNutritionalValue` text DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `yield` varchar(255) DEFAULT NULL,
  `otherRecommendations` text DEFAULT NULL,
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL,
  `wholesalePrice` decimal(10,2) NOT NULL,
  `semiwholesalePrice` decimal(10,2) NOT NULL,
  `retailPrice` decimal(10,2) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_master_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seed_forms`
--

INSERT INTO `seed_forms` (`id`, `parent_id`, `live_id`, `form_type`, `title`, `localProductName`, `product_id`, `language_id`, `qr_code_path`, `cropName`, `verityName`, `breederName`, `countryOrigin`, `registrationNumber`, `varietyType`, `seedCategory`, `precocity`, `fruitColor`, `fruitShape`, `leafLength`, `leafColor`, `plantHeight`, `plantHabit`, `bioticResistance`, `abioticResistance`, `InherentNutritionalValue`, `other`, `yield`, `otherRecommendations`, `otherRecommendationsPhoto`, `wholesalePrice`, `semiwholesalePrice`, `retailPrice`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `created_by`, `created_at`, `updated_at`, `product_master_id`) VALUES
(133, NULL, 0, 'seed_form', '1', NULL, 8, 1, 'qrcodes/seedform_133.png', 'Maize', 'Debanyuman Hybrid 12', 'IER Mali', 'Mali', 'REG-ML-2024-0021', 'Hybrid', 'Certified', '95 Days', 'Yellow', 'Semi-Flattened', 'NA', 'Dark Green', '180cm', 'Upright', 'Tolerant to Striga', 'Heat Tolerant', 'Rich in iron', NULL, '5.2t/ha', 'NA', 'uploads/seed_images/1765792526_10046.jpg', 15000.00, 200.00, 560.00, 191, 1, 0, 'fail', NULL, '2025-12-15 16:54:46', '2026-05-20 21:15:52', NULL),
(134, NULL, 0, 'seed_form', '11', NULL, 8, 1, 'qrcodes/seedform_133.png', 'Maize', 'Debanyuman Hybrid 12', 'IER Mali', 'Mali', 'REG-ML-2024-0021', 'Hybrid', 'Certified', '95 Days', 'Yellow', 'Semi-Flattened', 'NA', 'Dark Green', '180cm', 'Upright', 'Tolerant to Striga', 'Heat Tolerant', 'Rich in iron', NULL, '5.2t/ha', 'NA', 'uploads/seed_images/1765792526_10046.jpg', 15000.00, 200.00, 560.00, 191, 1, 0, NULL, NULL, '2025-12-15 16:54:46', '2025-12-24 19:27:50', NULL),
(138, NULL, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_138.png', 'Maize', 'pink', 'IER Mali', 'rty', '455677', 'Open-pollinated variety', 'red', 'dfg', 'red', 'ova', '344', 'red', '56', 'Coptic shoots', '55', '233', 'Rich in iron', NULL, '56', 'tes', 'uploads/seed_images/1766086479_1000039053.png', 33456.00, 678.00, 12.00, 193, 1, 0, NULL, NULL, '2025-12-19 02:34:39', '2025-12-24 19:32:44', NULL),
(100060, NULL, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100060.png', 'tamto', 'Hybrid-101', 'ABC Seeds', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'red', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', 'uploads/seed_images/1766567171_Screenshot 2025-12-24 115545.png', 1.00, 12.00, 12.00, 191, 1, 0, NULL, 1, '2025-12-24 16:06:11', '2025-12-24 18:50:01', NULL),
(100061, NULL, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100061.png', 'tamto', 'Hybrid-101', 'ABC Seeds test', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'red', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', 'uploads/seed_images/1766567393_Screenshot 2025-12-24 115545.png', 1.00, 12.00, 12.00, 191, 1, 2, NULL, 1, '2025-12-24 16:09:53', '2025-12-24 11:51:25', NULL),
(100063, 100061, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100063.png', 'tamto', 'Hybrid-101', 'ABC Seeds test', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'red', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', 'uploads/seed_images/1766575516_Screenshot 2025-12-24 115545.png', 1.00, 12.00, 12.00, 191, 1, 2, NULL, 1, '2025-12-24 18:25:16', '2025-12-24 11:51:50', NULL),
(100064, 134, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100064.png', 'tamto', 'Hybrid-101', 'ABC Seeds test', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'red', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', 'uploads/seed_images/1766579083_Screenshot 2025-12-24 115545.png', 1.00, 12.00, 12.00, 191, 1, 2, NULL, 1, '2025-12-24 19:24:43', '2025-12-24 19:27:50', NULL),
(100065, 138, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100065.png', 'tamto', 'Hybrid-101', 'ABC Seeds test', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'pink', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', 'uploads/seed_images/1766579456_Screenshot 2025-12-24 115545.png', 1.00, 12.00, 12.00, 191, 1, 3, 'fail', 1, '2025-12-24 19:30:56', '2025-12-24 19:32:44', NULL),
(100066, 138, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100066.png', 'tamto', 'Hybrid-101', 'ABC Seeds test', 'uk', 'Hybrid-101', 'Hybrid', 'Certified', NULL, 'red', 'Early', '12cm', '12', '12', '12', '12', '12', 'High Vitamin C', '12', '125', 'test', '/tmp/phpRE6BT0', 1.00, 12.00, 12.00, 191, 1, 2, NULL, 1, '2025-12-26 15:22:04', '2026-01-18 14:02:47', NULL),
(100067, NULL, 0, 'seed_form', 'deded ede', NULL, 8, 1, 'qrcodes/seedform_100067.png', 'deded ede', 'dedede', 'ed', NULL, '3333', 'selfPollinated', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'semiErect', NULL, NULL, 'Rich in Beta-carotene', NULL, NULL, NULL, NULL, 7.00, 3.00, 8.00, NULL, NULL, 1, NULL, 1, '2026-02-11 00:25:47', '2026-02-11 00:25:47', NULL),
(100068, 133, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100068.png', 'Maize 1', 'Debanyuman Hybrid 12', 'IER Mali', 'Mali', 'REG-ML-2024-0021', 'Hybrid', 'Certified', '95 Days', 'Yellow', 'Semi-Flattened', 'NA', 'Dark Green', '180cm', 'Upright', 'Tolerant to Striga', 'Heat Tolerant', 'Rich in iron', NULL, '5.2t/ha', 'NA', 'uploads/seed_images/1765792526_10046.jpg', 15000.00, 200.00, 560.00, 191, 1, 1, NULL, NULL, '2026-03-07 02:59:02', '2026-03-07 02:59:02', NULL),
(100069, 133, 0, 'seed_form', NULL, NULL, 8, 1, 'qrcodes/seedform_100069.png', 'Maize 1', 'Debanyuman Hybrid 12', 'IER Mali', 'Mali', 'REG-ML-2024-0021', 'Hybrid', 'Certified', '95 Days', 'Yellow', 'Semi-Flattened', 'NA', 'Dark Green', '180cm', 'Upright', 'Tolerant to Striga', 'Heat Tolerant', 'Rich in iron', NULL, '5.2t/ha', 'NA', '/tmp/php00fDN0', 15000.00, 200.00, 560.00, 191, 1, 2, NULL, NULL, '2026-03-07 02:59:53', '2026-05-20 21:15:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seed_form_translations`
--

CREATE TABLE `seed_form_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seed_form_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `form_type` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cropName` varchar(255) DEFAULT NULL,
  `verityName` varchar(255) DEFAULT NULL,
  `breederName` varchar(255) DEFAULT NULL,
  `countryOrigin` varchar(255) DEFAULT NULL,
  `registrationNumber` varchar(255) DEFAULT NULL,
  `varietyType` varchar(255) DEFAULT NULL,
  `seedCategory` varchar(255) DEFAULT NULL,
  `precocity` varchar(255) DEFAULT NULL,
  `fruitColor` varchar(255) DEFAULT NULL,
  `fruitShape` varchar(255) DEFAULT NULL,
  `leafLength` varchar(255) DEFAULT NULL,
  `leafColor` varchar(255) DEFAULT NULL,
  `plantHeight` varchar(255) DEFAULT NULL,
  `plantHabit` varchar(255) DEFAULT NULL,
  `bioticResistance` varchar(255) DEFAULT NULL,
  `abioticResistance` varchar(255) DEFAULT NULL,
  `InherentNutritionalValue` text DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `yield` varchar(255) DEFAULT NULL,
  `otherRecommendations` text DEFAULT NULL,
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL,
  `wholesalePrice` decimal(10,2) DEFAULT NULL,
  `semiwholesalePrice` decimal(10,2) DEFAULT NULL,
  `retailPrice` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seed_form_translations`
--

INSERT INTO `seed_form_translations` (`id`, `seed_form_id`, `language_id`, `form_type`, `title`, `cropName`, `verityName`, `breederName`, `countryOrigin`, `registrationNumber`, `varietyType`, `seedCategory`, `precocity`, `fruitColor`, `fruitShape`, `leafLength`, `leafColor`, `plantHeight`, `plantHabit`, `bioticResistance`, `abioticResistance`, `InherentNutritionalValue`, `other`, `yield`, `otherRecommendations`, `otherRecommendationsPhoto`, `wholesalePrice`, `semiwholesalePrice`, `retailPrice`, `supplier_id`, `agent_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 8, 1, NULL, NULL, 'apple', 'apple', 'apple', 'apple', 'up 85', 'Hybrid', 'matter', '85', '85', '85', 'test', 'red', '10', 'erected', 'dgfh', '', 'Rich in Iron', '112', '120', 'झसब्द', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-14 20:40:17', '2025-10-14 20:40:17'),
(2, 8, 2, NULL, NULL, 'pomme', 'pomme', 'pomme', 'pomme', 'jusqu\'à 85', 'Hybride', 'matière', '85', '85', '85', 'test', 'rouge', '10', 'érigé', 'dgfh', '', 'Rich in Iron', '112', '120', 'झसब्द', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-14 20:40:23', '2025-10-14 20:40:23'),
(3, 8, 12, NULL, NULL, 'सेब', 'सेब', 'सेब', 'सेब', 'ऊपर 85', 'हाइब्रिड', 'मामला', '85', '85', '85', 'परीक्षा', 'लाल', '10', 'निर्माण किया', 'डीजीएफएच', '', 'Rich in Iron', '112', '120', 'jhsbd', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-14 20:40:27', '2025-10-14 20:40:27'),
(4, 8, 13, NULL, NULL, 'سیب', 'سیب', 'سیب', 'سیب', '85 تک', 'ہائبرڈ', 'معاملہ', '85', '85', '85', 'ٹیسٹ', 'سرخ', '10', 'کھڑا کیا', 'ڈی جی ایف ایچ', '', 'Rich in Iron', '112', '120', 'झसब्द', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-14 20:40:37', '2025-10-14 20:40:37'),
(5, 9, 1, NULL, NULL, 'Ritika', 'rare', 'rare', 'itknfsjd', '18', 'Hybrid', '12', '85', '1', 'red', '14', '14', '14', 'erected', '14', '', 'Rich in Vitamin C', 'lemaon', '12', '121', NULL, NULL, NULL, NULL, 37, NULL, 1, '2025-10-16 18:35:47', '2025-10-16 18:35:47'),
(6, 9, 2, NULL, NULL, 'Ritika', 'rare', 'rare', 'itknfsjd', '18', 'Hybride', '12', '85', '1', 'rouge', '14', '14', '14', 'érigé', '14', '', 'Rich in Vitamin C', 'citron', '12', '121', NULL, NULL, NULL, NULL, 37, NULL, 1, '2025-10-16 18:35:51', '2025-10-16 18:35:51'),
(7, 9, 12, NULL, NULL, 'रितिका', 'दुर्लभ', 'दुर्लभ', 'itknfsjd', '18', 'हाइब्रिड', '12', '85', '1', 'लाल', '14', '14', '14', 'निर्माण किया', '14', '', 'Rich in Vitamin C', 'नींबू', '12', '121', NULL, NULL, NULL, NULL, 37, NULL, 1, '2025-10-16 18:35:53', '2025-10-16 18:35:53'),
(8, 9, 13, NULL, NULL, 'ریتیکا', 'شاذ و نادر', 'شاذ و نادر', 'itknfsjd', '18', 'ہائبرڈ', '12', '85', '1', 'سرخ', '14', '14', '14', 'کھڑا کیا', '14', '', 'Rich in Vitamin C', 'لیموں', '12', '121', NULL, NULL, NULL, NULL, 37, NULL, 1, '2025-10-16 18:35:58', '2025-10-16 18:35:58'),
(9, 10, 1, NULL, 'My Seed Form', 'Wheat', 'PBW 343', 'ICAR', 'India', '12345', 'Advanced', 'Seed', 'Medium', 'Yellow', 'Long', '30 cm', 'Green', '1 meter', 'Upright', 'Pest resistant', 'Drought tolerant', 'Protein,Vitamin A', 'High yield', '50 quintals/hectare', 'Irrigation required', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:16:09', '2025-10-16 19:16:09'),
(10, 10, 2, NULL, 'Mon formulaire de semences', 'Blé', 'PBW 343', 'ICAR', 'Inde', '12345', 'Avancé', 'Graine', 'Moyen', 'Jaune', 'Long', '30 cm', 'Vert', '1 mètre', 'Droit', 'Résistant aux parasites', 'Tolérant à la sécheresse', 'Protein,Vitamin A', 'Rendement élevé', '50 quintaux/hectare', 'Irrigation requise', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:16:24', '2025-10-16 19:16:24'),
(11, 10, 12, NULL, 'मेरा बीज रूप', 'गेहूँ', 'पीबीडब्ल्यू 343', 'आईसीएआर', 'भारत', '12345', 'विकसित', 'बीज', 'मध्यम', 'पीला', 'लंबा', '30 सेमी', 'हरा', '1 मीटर', 'ईमानदार', 'कीट प्रतिरोधी', 'सहनीय सूखा', 'Protein,Vitamin A', 'उच्च उपज', '50 क्विंटल/हेक्टेयर', 'सिंचाई की आवश्यकता है', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:16:32', '2025-10-16 19:16:32'),
(12, 10, 13, NULL, 'میرے بیج کی شکل', 'گندم', 'PBW 343', 'آئی سی اے آر', 'ہندوستان', '12345', 'اعلی درجے کی', 'بیج', 'میڈیم', 'پیلے رنگ', 'لمبا', '30 سینٹی میٹر', 'سبز', '1 میٹر', 'سیدھا', 'کیڑوں سے مزاحم', 'خشک سالی برداشت کرنا', 'Protein,Vitamin A', 'اعلی پیداوار', '50 کوئنٹل/ہیکٹر', 'آبپاشی کی ضرورت ہے', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:16:52', '2025-10-16 19:16:52'),
(13, 11, 1, NULL, 'My Seed Form', 'Wheat', 'PBW 343', 'ICAR', 'India', '12345', 'Advanced', 'Seed', 'Medium', 'Yellow', 'Long', '30 cm', 'Green', '1 meter', 'Upright', 'Pest resistant', 'Drought tolerant', 'Protein,Vitamin A', 'High yield', '50 quintals/hectare', 'Irrigation required', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:36:42', '2025-10-16 19:36:42'),
(14, 11, 2, NULL, 'Mon formulaire de semences', 'Blé', 'PBW 343', 'ICAR', 'Inde', '12345', 'Avancé', 'Graine', 'Moyen', 'Jaune', 'Long', '30 cm', 'Vert', '1 mètre', 'Droit', 'Résistant aux parasites', 'Tolérant à la sécheresse', 'Protein,Vitamin A', 'Rendement élevé', '50 quintaux/hectare', 'Irrigation requise', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:36:44', '2025-10-16 19:36:44'),
(15, 11, 12, NULL, 'मेरा बीज रूप', 'गेहूँ', 'पीबीडब्ल्यू 343', 'आईसीएआर', 'भारत', '12345', 'विकसित', 'बीज', 'मध्यम', 'पीला', 'लंबा', '30 सेमी', 'हरा', '1 मीटर', 'ईमानदार', 'कीट प्रतिरोधी', 'सहनीय सूखा', 'Protein,Vitamin A', 'उच्च उपज', '50 क्विंटल/हेक्टेयर', 'सिंचाई की आवश्यकता है', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:36:46', '2025-10-16 19:36:46'),
(16, 11, 13, NULL, 'میرے بیج کی شکل', 'گندم', 'PBW 343', 'آئی سی اے آر', 'ہندوستان', '12345', 'اعلی درجے کی', 'بیج', 'میڈیم', 'پیلے رنگ', 'لمبا', '30 سینٹی میٹر', 'سبز', '1 میٹر', 'سیدھا', 'کیڑوں سے مزاحم', 'خشک سالی برداشت کرنا', 'Protein,Vitamin A', 'اعلی پیداوار', '50 کوئنٹل/ہیکٹر', 'آبپاشی کی ضرورت ہے', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-16 19:36:48', '2025-10-16 19:36:48'),
(17, 12, 1, NULL, 'My Seed Form', 'Wheat', 'PBW 343', 'ICAR', 'India', '12345', 'Advanced', 'Seed', 'Medium', 'Yellow', 'Long', '30 cm', 'Green', '1 meter', 'Upright', 'Pest resistant', 'Drought tolerant', 'Protein,Vitamin A', 'High yield', '50 quintals/hectare', 'Irrigation required', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-17 12:57:03', '2025-10-17 12:57:03'),
(18, 12, 2, NULL, 'Mon formulaire de semences', 'Blé', 'PBW 343', 'ICAR', 'Inde', '12345', 'Avancé', 'Graine', 'Moyen', 'Jaune', 'Long', '30 cm', 'Vert', '1 mètre', 'Droit', 'Résistant aux parasites', 'Tolérant à la sécheresse', 'Protein,Vitamin A', 'Rendement élevé', '50 quintaux/hectare', 'Irrigation requise', NULL, NULL, NULL, NULL, 37, 2, 1, '2025-10-17 12:57:07', '2025-10-17 12:57:07'),
(19, 13, 1, NULL, 'Wheat Golden Variety', 'Wheat', 'Gold King', 'ICAR Delhi', 'India', 'REG-98765', 'Hybrid', 'Certified', '120 days', 'Light Brown', 'Round', 'Medium', 'Dark Green', '110 cm', 'erected', 'Fungal resistance', 'Drought tolerance', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Performs well in rainfed areas', '40 quintal/ha', 'Use organic fertilizer during sowing', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 16:28:11', '2025-10-17 16:28:11'),
(20, 13, 2, NULL, 'Variété de blé doré', 'Blé', 'Roi d\'or', 'ICAR Delhi', 'Inde', 'REG-98765', 'Hybride', 'Agréé', '120 jours', 'Marron clair', 'Rond', 'Moyen', 'Vert foncé', '110cm', 'érigé', 'Résistance fongique', 'Tolérance à la sécheresse', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Fonctionne bien dans les zones pluviales', '40 quintaux/ha', 'Utiliser un engrais organique lors du semis', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 16:28:28', '2025-10-17 16:28:28'),
(21, 14, 1, NULL, 'Wheat Golden Variety', 'Wheat', 'Gold King', 'ICAR Delhi', 'India', 'REG-98765', 'Hybrid', 'Certified', '120 days', 'Light Brown', 'Round', 'Medium', 'Dark Green', '110 cm', 'erected', 'Fungal resistance', 'Drought tolerance', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Performs well in rainfed areas', '40 quintal/ha', 'Use organic fertilizer during sowing', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 16:42:10', '2025-10-17 16:42:10'),
(22, 14, 2, NULL, 'Variété de blé doré', 'Blé', 'Roi d\'or', 'ICAR Delhi', 'Inde', 'REG-98765', 'Hybride', 'Agréé', '120 jours', 'Marron clair', 'Rond', 'Moyen', 'Vert foncé', '110cm', 'érigé', 'Résistance fongique', 'Tolérance à la sécheresse', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Fonctionne bien dans les zones pluviales', '40 quintaux/ha', 'Utiliser un engrais organique lors du semis', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 16:42:12', '2025-10-17 16:42:12'),
(23, 15, 1, NULL, 'Wheat Golden Variety', 'Wheat', 'Gold King', 'ICAR Delhi', 'India', 'REG-98765', 'Hybrid', 'Certified', '120 days', 'Light Brown', 'Round', 'Medium', 'Dark Green', '110 cm', 'erected', 'Fungal resistance', 'Drought tolerance', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Performs well in rainfed areas', '40 quintal/ha', 'Use organic fertilizer during sowing', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 18:02:49', '2025-10-17 18:02:49'),
(24, 15, 2, NULL, 'Variété de blé doré', 'Blé', 'Roi d\'or', 'ICAR Delhi', 'Inde', 'REG-98765', 'Hybride', 'Agréé', '120 jours', 'Marron clair', 'Rond', 'Moyen', 'Vert foncé', '110cm', 'érigé', 'Résistance fongique', 'Tolérance à la sécheresse', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Fonctionne bien dans les zones pluviales', '40 quintaux/ha', 'Utiliser un engrais organique lors du semis', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 18:02:51', '2025-10-17 18:02:51'),
(25, 16, 1, NULL, NULL, 'Wheat', 'Gold King', 'ICAR Delhi', 'India', 'REG-98765', 'Hybrid', 'Certified', '120 days', 'Light Brown', 'Round', 'Medium', 'Dark Green', '110 cm', 'erected', 'Fungal resistance', 'Drought tolerance', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Performs well in rainfed areas', '40 quintal/ha', 'Use organic fertilizer during sowing', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 19:21:45', '2025-10-17 19:21:45'),
(26, 16, 2, NULL, NULL, 'Blé', 'Roi d\'or', 'ICAR Delhi', 'Inde', 'REG-98765', 'Hybride', 'Agréé', '120 jours', 'Marron clair', 'Rond', 'Moyen', 'Vert foncé', '110cm', 'érigé', 'Résistance fongique', 'Tolérance à la sécheresse', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Fonctionne bien dans les zones pluviales', '40 quintaux/ha', 'Utiliser un engrais organique lors du semis', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 19:21:47', '2025-10-17 19:21:47'),
(27, 17, 1, NULL, NULL, 'Wheat', 'Gold King', 'ICAR Delhi', 'India', 'REG-98765', 'Hybrid', 'Certified', '120 days', 'Light Brown', 'Round', 'Medium', 'Dark Green', '110 cm', 'erected', 'Fungal resistance', 'Drought tolerance', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Performs well in rainfed areas', '40 quintal/ha', 'Use organic fertilizer during sowing', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 19:27:29', '2025-10-17 19:27:29'),
(28, 17, 2, NULL, NULL, 'Blé', 'Roi d\'or', 'ICAR Delhi', 'Inde', 'REG-98765', 'Hybride', 'Agréé', '120 jours', 'Marron clair', 'Rond', 'Moyen', 'Vert foncé', '110cm', 'érigé', 'Résistance fongique', 'Tolérance à la sécheresse', 'Rich in Beta-carotene,Rich in Iron,Rich in Antioxidant', 'Fonctionne bien dans les zones pluviales', '40 quintaux/ha', 'Utiliser un engrais organique lors du semis', NULL, NULL, NULL, NULL, 37, 3, 1, '2025-10-17 19:27:31', '2025-10-17 19:27:31'),
(29, 23, 1, NULL, NULL, 'red', 'red', 'red', 'red', '85', 'Hybrid', 'is', 'jwj', 'jwj', 'jj', 'j', 'j', 'j', 'semiErect', 'j', 'j', 'Rich in Iron', '12', '12', '12', NULL, NULL, NULL, NULL, 42, NULL, 1, '2025-10-23 17:53:02', '2025-10-23 17:53:02'),
(30, 23, 2, NULL, NULL, 'rouge', 'rouge', 'rouge', 'rouge', '85', 'Hybride', 'est', 'jwj', 'jwj', 'jj', 'j', 'j', 'j', 'semi-dressé', 'j', 'j', 'Rich in Iron', '12', '12', '12', NULL, NULL, NULL, NULL, 42, NULL, 1, '2025-10-23 17:53:06', '2025-10-23 17:53:06'),
(31, 24, 1, NULL, NULL, 'gent', 'agent', 'gent', 'agent', 'up85', 'Hybrid', 'red zone', '85', 'red', 'red', 'red', 'red', '10', 'yard', 'red', '12', 'Rich in Beta-carotene', '12', '21', '12', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-23 18:03:48', '2025-10-23 18:03:48'),
(32, 24, 2, NULL, NULL, 'monsieur', 'agent', 'monsieur', 'agent', 'jusqu\'à85', 'Hybride', 'zone rouge', '85', 'rouge', 'rouge', 'rouge', 'rouge', '10', 'cour', 'rouge', '12', 'Rich in Beta-carotene', '12', '21', '12', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-10-23 18:03:51', '2025-10-23 18:03:51'),
(33, 25, 1, NULL, NULL, 'test', 'tets', 'test', 'ttst', '8', 'Hybrid', 'test', '1', '1', '1', '', '22', '2', 'yard', '2', '2', 'Rich in Beta-carotene', '1', '1', '1', NULL, NULL, NULL, NULL, 37, 7, 1, '2025-10-23 18:22:45', '2025-10-23 18:22:45'),
(34, 25, 2, NULL, NULL, 'test', 'tetons', 'test', 'ttst', '8', 'Hybride', 'test', '1', '1', '1', '', '22', '2', 'cour', '2', '2', 'Rich in Beta-carotene', '1', '1', '1', NULL, NULL, NULL, NULL, 37, 7, 1, '2025-10-23 18:22:48', '2025-10-23 18:22:48'),
(35, 26, 1, NULL, NULL, '24', '24', '24', '24', '24', 'Hybrid', 'red', 'red', 'red', 'red', '10', '101', '10', 'stoloniferous', '10', '10', 'Other', '10', '1', '10', NULL, NULL, NULL, NULL, 41, 6, 1, '2025-10-24 10:19:11', '2025-10-24 10:19:11'),
(36, 26, 2, NULL, NULL, '24', '24', '24', '24', '24', 'Hybride', 'rouge', 'rouge', 'rouge', 'rouge', '10', '101', '10', 'stolonifère', '10', '10', 'Other', '10', '1', '10', NULL, NULL, NULL, NULL, 41, 6, 1, '2025-10-24 10:19:14', '2025-10-24 10:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `seed_translates`
--

CREATE TABLE `seed_translates` (
  `id` int(11) NOT NULL,
  `seed_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `translated_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `seed_translates`
--

INSERT INTO `seed_translates` (`id`, `seed_id`, `language_id`, `translated_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Veterinary Products', '2025-10-14 15:23:55', '2025-10-14 15:23:55'),
(2, 1, 2, 'Produits vétérinaires', '2025-10-14 15:23:56', '2025-10-14 15:23:56'),
(3, 2, 1, 'Animal Feed', '2025-10-14 15:23:56', '2025-10-14 15:23:56'),
(4, 2, 2, 'Alimentation animale', '2025-10-14 15:23:56', '2025-10-14 15:23:56'),
(5, 3, 1, 'Synthetic Pesticides', '2025-10-14 15:23:57', '2025-10-14 15:23:57'),
(6, 3, 2, 'Pesticides synthétiques', '2025-10-14 15:23:57', '2025-10-14 15:23:57'),
(7, 4, 1, 'Inorganic Soil Conditioners', '2025-10-14 15:23:58', '2025-10-14 15:23:58'),
(8, 4, 2, 'Conditionneurs de sol inorganiques', '2025-10-14 15:23:58', '2025-10-14 15:23:58'),
(9, 5, 1, 'Biostimulants', '2025-10-14 15:23:59', '2025-10-14 15:23:59'),
(10, 5, 2, 'Biostimulants', '2025-10-14 15:23:59', '2025-10-14 15:23:59'),
(11, 6, 1, 'Organic Amendments', '2025-10-14 15:23:59', '2025-10-14 15:23:59'),
(12, 6, 2, 'Amendements organiques', '2025-10-14 15:24:00', '2025-10-14 15:24:00'),
(13, 7, 1, 'Mineral Fertilizers', '2025-10-14 15:24:00', '2025-10-14 15:24:00'),
(14, 7, 2, 'Engrais minéraux', '2025-10-14 15:24:00', '2025-10-14 15:24:00'),
(15, 8, 1, 'Seeds', '2025-10-14 15:24:01', '2025-10-14 15:24:01'),
(16, 8, 2, 'Graines', '2025-10-14 15:24:01', '2025-10-14 15:24:01'),
(17, 1, 12, 'पशु चिकित्सा उत्पाद', '2025-10-14 15:27:49', '2025-10-14 15:27:49'),
(18, 1, 13, 'ویٹرنری مصنوعات', '2025-10-14 15:27:49', '2025-10-14 15:27:49'),
(19, 2, 12, 'जानवरों का चारा', '2025-10-14 15:27:50', '2025-10-14 15:27:50'),
(20, 2, 13, 'جانوروں کا کھانا', '2025-10-14 15:27:50', '2025-10-14 15:27:50'),
(21, 3, 12, 'सिंथेटिक कीटनाशक', '2025-10-14 15:27:51', '2025-10-14 15:27:51'),
(22, 3, 13, 'مصنوعی کیڑے مار دوا', '2025-10-14 15:27:51', '2025-10-14 15:27:51'),
(23, 4, 12, 'अकार्बनिक मृदा कंडीशनर', '2025-10-14 15:27:51', '2025-10-14 15:27:51'),
(24, 4, 13, 'غیر نامیاتی مٹی کنڈیشنر', '2025-10-14 15:27:51', '2025-10-14 15:27:51'),
(25, 5, 12, 'बायोस्टिमुलेंट', '2025-10-14 15:27:52', '2025-10-14 15:27:52'),
(26, 5, 13, 'بایوسٹیمولینٹس', '2025-10-14 15:27:52', '2025-10-14 15:27:52'),
(27, 6, 12, 'जैविक संशोधन', '2025-10-14 15:27:53', '2025-10-14 15:27:53'),
(28, 6, 13, 'نامیاتی ترامیم', '2025-10-14 15:27:53', '2025-10-14 15:27:53'),
(29, 7, 12, 'खनिज उर्वरक', '2025-10-14 15:27:53', '2025-10-14 15:27:53'),
(30, 7, 13, 'معدنی کھاد', '2025-10-14 15:27:54', '2025-10-14 15:27:54'),
(31, 8, 12, 'बीज', '2025-10-14 15:27:54', '2025-10-14 15:27:54'),
(32, 8, 13, 'بیج', '2025-10-14 15:27:54', '2025-10-14 15:27:54'),
(33, 21, 1, 'lokesh pandey', '2025-10-25 12:01:25', '2025-10-25 12:01:25'),
(34, 21, 2, 'Lokesh Pandey', '2025-10-25 12:01:27', '2025-10-25 12:01:27'),
(35, 22, 1, 'Veterinary Products', '2025-10-25 12:04:57', '2025-10-25 12:04:57'),
(36, 22, 2, 'Produits vétérinaires', '2025-10-25 12:04:59', '2025-10-25 12:04:59'),
(37, 78, 1, 'Mineral Fertilizers', '2025-10-25 12:14:42', '2025-10-25 12:14:42'),
(38, 78, 2, 'Engrais minéraux', '2025-10-25 12:14:42', '2025-10-25 12:14:42'),
(39, 89, 1, 'Seeds', '2025-10-25 12:15:45', '2025-10-25 12:15:45'),
(40, 89, 2, 'Graines', '2025-10-25 12:15:46', '2025-10-25 12:15:46'),
(41, 90, 1, 'Organic Amendments', '2025-10-25 12:16:55', '2025-10-25 12:16:55'),
(42, 90, 2, 'Amendements organiques', '2025-10-25 12:16:56', '2025-10-25 12:16:56'),
(43, 91, 1, 'Biostimulants', '2025-10-25 12:18:09', '2025-10-25 12:18:09'),
(44, 91, 2, 'Biostimulants', '2025-10-25 12:18:09', '2025-10-25 12:18:09'),
(45, 92, 1, 'Inorganic Soil Conditioners', '2025-10-25 12:19:18', '2025-10-25 12:19:18'),
(46, 92, 2, 'Conditionneurs de sol inorganiques', '2025-10-25 12:19:19', '2025-10-25 12:19:19'),
(47, 93, 1, 'Synthetic Pesticides', '2025-10-25 12:20:19', '2025-10-25 12:20:19'),
(48, 93, 2, 'Pesticides synthétiques', '2025-10-25 12:20:20', '2025-10-25 12:20:20'),
(49, 94, 1, 'Animal Feed', '2025-10-25 12:21:30', '2025-10-25 12:21:30'),
(50, 94, 2, 'Alimentation animale', '2025-10-25 12:21:30', '2025-10-25 12:21:30'),
(51, 95, 1, 'Veterinary Products', '2025-10-25 12:22:55', '2025-10-25 12:22:55'),
(52, 95, 2, 'Produits vétérinaires', '2025-10-25 12:22:55', '2025-10-25 12:22:55');

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
('MZVApRUxxFByjej8W3MfQHiPLlY8PbE4cr2uoCFO', NULL, '106.219.121.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUXJJb2cyTjBSMkpSb2swbnhIUk5UR0Ftb0JLTUwxYVBnSzVEcUhRSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHBzOi8vZml2b2Zsb3cuY29tL3djbG0vcHVibGljL2FkbWluL2Fubm91bmNlbWVudHMvY291bnRyeSI7fXM6MTQ6Im1hc3RlcmFkbWluX2lkIjtpOjM7czo4OiJ1c2VyVHlwZSI7czoxMzoiQ291bnRyeS1BZG1pbiI7czoxMDoiY291bnRyeV9pZCI7aToyO30=', 1779778311);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pending', NULL, NULL),
(2, 'Active', NULL, NULL),
(3, 'Dined', NULL, NULL),
(5, 'Supplier Review', '2025-12-04 08:49:28', '2025-12-04 08:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usertype_id` bigint(20) UNSIGNED NOT NULL DEFAULT 2,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `manager_name` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_entity_registration` varchar(255) DEFAULT NULL,
  `employer_identification_number` varchar(255) DEFAULT NULL,
  `seed_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`seed_id`)),
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reject_message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `verify` varchar(10) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `enumerator_last_name` varchar(100) DEFAULT NULL,
  `enumerator_first_name` varchar(100) DEFAULT NULL,
  `enumerator_whatsapp` varchar(20) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `altitude` decimal(10,2) DEFAULT NULL,
  `accuracy` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `usertype_id`, `country_id`, `company_name`, `manager_name`, `name`, `position`, `image`, `city`, `region`, `address`, `phone`, `mobile`, `email`, `created_by`, `language_id`, `state_entity_registration`, `employer_identification_number`, `seed_id`, `status_id`, `reject_message`, `created_at`, `updated_at`, `password`, `otp`, `otp_expires_at`, `verify`, `device_id`, `enumerator_last_name`, `enumerator_first_name`, `enumerator_whatsapp`, `latitude`, `longitude`, `altitude`, `accuracy`) VALUES
(1, 2, 2, 'Company 11', 'Supplier Rain', 'Supplier Rain', 'Chief Supplier', '1773722520_69b8db98d35c9.png', 'Freetown', '[\"9\"]', 'Freetown', '789456123', '78945613', 'rain1234@gmail.com', NULL, 1, NULL, NULL, NULL, 1, NULL, '2026-03-17 11:42:01', '2026-03-17 11:42:01', '$2y$12$xYQUVrlTVubykGRCtbBDoe9UbHi/TcNGJyZtjVy6yx32pMs4nBWJC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 2, 2, 'Company 1', 'Supplier Jon', 'Supplier John', 'Chief Supplier', NULL, 'Abijan', '[\"9\"]', 'noid', '8889996669', '7779990669', 'supplier@gmail.com', 100, 1, '123346', '167885', '[\"6, 3, 1, 8\"]', 2, NULL, '2025-12-15 16:27:29', '2026-05-20 21:21:20', '$2y$12$1ZenT97.yKoUenvksh7H3uK0oMoyRLD00qlIjOHR5L3vtKBFrMANK', '503489', '2026-03-11 19:35:33', 'yes', 'fa_jM8H-SoiSnzBFsuNmED:APA91bEgTYYpH3i8O-HGyxgjd61caRmtwfB4zuewbtZoxQYmI7lfmA7tQ0Ps99cSjXDDaFi5w4LzMALZB0UMtG-GOAQhX_MF6aUtD6ChX9MJs-f_6-5tyKM', NULL, NULL, NULL, 28.5357404, 77.2174472, 188.00, 11.71),
(197, 2, 2, 'tt', 'tt', 'tt', 'Manager', '1771916968_1000043020.jpg', NULL, NULL, NULL, '22456555', NULL, 'tt@gmail.com', NULL, 1, NULL, NULL, NULL, 1, NULL, '2026-02-24 14:09:28', '2026-02-24 14:09:28', '$2y$12$Xl43/7duYXvlW.zwpthypetFgJGCAX0PrLd7Vwj0v7O0RAA4ISMC.', '872108', '2026-02-24 07:19:28', NULL, 'dwbyk4EjSPqJZDS877HvfA:APA91bFgEeOn-GwHWkIEmMUm0wHhlSuyetgxmaWGLqgGP0Lv1-8A56m8KlO5IVejZ8awZjmDH3ejIeDSEvuYNMy1qp8BWx8FvAn1FQF7AwpjKeMRAusnFNo', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 2, 2, 'tt', 'tt0703', 'tt0703', '07hdcn', '1772854612_69ab9d544c698.jpg', 'nioda', '10', 'g 308', '08800658501', '08800658501', 'rcmodular97@gmail.com', NULL, 1, 'Uttar Pradesh', '12', NULL, 1, NULL, '2026-03-07 10:36:52', '2026-03-07 10:36:52', '$2y$12$JrtnK7KuDeeStrrHRFSZbeXYX.G9m/YuctUI5PNtyV7FEVYRHISge', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90.0000000, 90.0000000, NULL, NULL),
(199, 2, 1, 'Oxyn', 'John', NULL, 'Manager', 'https://fivoflow.com/wclm/public/uploads/supplier/1773395954_69b3dff2b148a.jpg', 'Abidjan', '[\"10\"]', 'jsjsj', '63738384', 'e7373883', 'henry@gmail.com', 100, 1, '334', '78393', '[\"6\"]', 2, NULL, '2026-03-13 16:59:14', '2026-05-20 21:20:16', '$2y$12$SSoJB4AfolvS8hK3GcIIl.b2q1QSvY6476W0flhUln2tB3r9KDaaO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8.9848359, 38.6776900, 2365.65, 13.20);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_translates`
--

CREATE TABLE `supplier_translates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `seed_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`seed_id`)),
  `company_name` varchar(255) NOT NULL,
  `manager_name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `synthetic_pesticides`
--

CREATE TABLE `synthetic_pesticides` (
  `id` int(11) NOT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) NOT NULL,
  `trade_name` varchar(255) NOT NULL,
  `active_ingredient` varchar(255) DEFAULT NULL,
  `other_active_ingredient` varchar(255) DEFAULT NULL,
  `formulation` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) NOT NULL,
  `function` varchar(255) DEFAULT NULL,
  `other_function` varchar(255) DEFAULT NULL,
  `toxicological_class_number` varchar(255) DEFAULT NULL,
  `approval_number` varchar(255) NOT NULL,
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `semiwholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `synthetic_pesticides`
--

INSERT INTO `synthetic_pesticides` (`id`, `localProductName`, `parent_id`, `live_id`, `form_type`, `trade_name`, `active_ingredient`, `other_active_ingredient`, `formulation`, `registration_number`, `function`, `other_function`, `toxicological_class_number`, `approval_number`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `qr_code_path`, `product_id`, `product_master_id`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `language_id`, `created_by`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(41, NULL, NULL, 0, 'synthetic_pesticide', 'HerbiClean 360', 'Glyphosate 360 g/L', 'SL (Soluble liquid)', 'SL (Soluble liquid)', 'REG-GN-PST-2024-054', '1', 'Non-selective systemic herbicideNon-selective systemic herbicide', 'Class III', 'AP-2024-091', 6500.00, 6500.00, 6500.00, NULL, 3, NULL, 191, NULL, 2, NULL, 1, 1, '2025-12-15 17:14:55', '2025-12-23 10:27:49', NULL),
(100052, NULL, NULL, 0, 'synthetic_pesticide', 'Super Pesticide', 'Ingredient A', 'Ingredient B', 'Liquid', 'REG12345', 'Insecticide', 'Fungicide', 'Class 2', 'APP6789', 1500.00, 2000.00, 15200.00, 'qrcodes/pesticide_100052.png', 3, NULL, 191, 1, 1, NULL, 1, 1, '2025-12-24 17:25:21', '2025-12-24 17:25:21', 'uploads/synthetic_pesticide/pesticide_1766571921_694bbf9117f41.png'),
(100053, NULL, 100052, 1, 'synthetic_pesticide', 'Super Pesticide', 'Ingredient A', 'Ingredient B', 'Liquid', 'REG12345', 'Insecticide', 'Fungicide', 'Class 2', 'APP6789', 1500.00, 2000.00, 15200.00, 'qrcodes/pesticide_100053.png', 3, NULL, 191, 1, 1, NULL, 1, 1, '2025-12-24 17:25:44', '2025-12-24 17:43:20', 'uploads/synthetic_pesticide/pesticide_1766571944_694bbfa869f62.png'),
(100054, NULL, 100053, 0, 'synthetic_pesticide', 'Super Pesticide', 'Ingredient A1', 'Ingredient B', 'Liquid', 'REG12345', 'Insecticide', 'Fungicide', 'Class 2', 'APP6789', 1500.00, 2000.00, 15200.00, 'qrcodes/pesticide_100054.png', 3, NULL, 191, 1, 1, NULL, 1, 1, '2025-12-24 17:43:20', '2025-12-24 17:43:20', 'uploads/synthetic_pesticide/pesticide_1766573000_694bc3c87d984.png'),
(100055, 'local test 1', NULL, 0, 'synthetic_pesticide', 'new', 'Acetamiprid 32 g/day', NULL, 'S: Solution', '243', 'Post-emergence corn herbicide', NULL, '5', '22', 5.00, 33.00, 22.00, 'qrcodes/pesticide_100055.png', 3, NULL, 191, 1, 1, NULL, 1, 1, '2026-04-03 18:30:31', '2026-04-03 18:30:31', 'uploads/synthetic_pesticide/pesticide_1775215831_69cfa4d786260.jpg'),
(100056, 'local test 2', 100055, 0, 'synthetic_pesticide', 'new', 'Acetamiprid 32 g/day', NULL, 'S: Solution', '243', 'Post-emergence corn herbicide', NULL, '5', '22', 5.00, 33.00, 22.00, 'qrcodes/pesticide_100056.png', 3, NULL, 191, 1, 1, NULL, 1, 1, '2026-04-03 18:32:00', '2026-04-03 18:32:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `synthetic_pesticides_fields`
--

CREATE TABLE `synthetic_pesticides_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `synthetic_pesticides_fields`
--

INSERT INTO `synthetic_pesticides_fields` (`id`, `label`, `name`, `type`, `options`, `required`) VALUES
(1, 'Trade Name', 'trade_name', 'text', NULL, 1),
(2, 'Active Ingredient(s)', 'active_ingredient', 'text', NULL, 0),
(3, 'Other Active Ingredients', 'other_active_ingredient', 'text', NULL, 0),
(4, 'Formulation', 'formulation', 'text', NULL, 0),
(5, 'Registration Number', 'registration_number', 'text', NULL, 1),
(6, 'Function', 'function', 'text', NULL, 0),
(7, 'Other Function', 'other_function', 'text', NULL, 0),
(8, 'Toxicological Class and Number', 'toxicological_class_number', 'text', NULL, 0),
(9, 'Approval Number', 'approval_number', 'text', NULL, 1),
(10, 'Average Wholesale Price', 'wholesale_price', 'number', NULL, 1),
(11, 'Average Semi-wholesale Price', 'semiwholesale_price', 'number', NULL, 1),
(12, 'Average Retail Price', 'retail_price', 'number', NULL, 1),
(13, 'Local produt name', 'localProductName', 'text', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `synthetic_pesticide_translations`
--

CREATE TABLE `synthetic_pesticide_translations` (
  `id` int(11) NOT NULL,
  `synthetic_pesticide_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `active_ingredient` varchar(255) DEFAULT NULL,
  `other_active_ingredient` varchar(255) DEFAULT NULL,
  `formulation` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `function` varchar(255) DEFAULT NULL,
  `other_function` varchar(255) DEFAULT NULL,
  `toxicological_class_number` varchar(255) DEFAULT NULL,
  `approval_number` varchar(255) DEFAULT NULL,
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `semiwholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `synthetic_pesticide_translations`
--

INSERT INTO `synthetic_pesticide_translations` (`id`, `synthetic_pesticide_id`, `language_id`, `trade_name`, `active_ingredient`, `other_active_ingredient`, `formulation`, `registration_number`, `function`, `other_function`, `toxicological_class_number`, `approval_number`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `supplier_id`, `agent_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '15', '15', '15', '15', NULL, '15', '15', NULL, NULL, 15.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-15 09:41:58', '2025-10-15 09:41:58'),
(2, 4, 2, '15', '15', '15', '15', NULL, '15', '15', NULL, NULL, 15.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-15 09:41:59', '2025-10-15 09:41:59'),
(3, 4, 12, '15', '15', '15', '15', NULL, '15', '15', NULL, NULL, 15.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-15 09:42:00', '2025-10-15 09:42:00'),
(4, 4, 13, '15', '15', '15', '15', NULL, '15', '15', NULL, NULL, 15.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-15 09:42:00', '2025-10-15 09:42:00'),
(5, 5, 1, 'ritika', 'ritak', 'ritika', 'ritika', '123', '123', '12', '3', '1', 1.00, 1.00, 1.00, NULL, NULL, 80, '2025-10-15 10:00:40', '2025-10-15 10:00:40'),
(6, 5, 2, 'ritika', 'ritak', 'ritika', 'ritika', '123', '123', '12', '3', '1', 1.00, 1.00, 1.00, NULL, NULL, 80, '2025-10-15 10:00:43', '2025-10-15 10:00:43'),
(7, 5, 12, 'रितिका', 'ऋतक', 'रितिका', 'रितिका', '123', '123', '12', '3', '1', 1.00, 1.00, 1.00, NULL, NULL, 80, '2025-10-15 10:00:45', '2025-10-15 10:00:45'),
(8, 5, 13, 'ریتیکا', 'ریتک', 'ریتیکا', 'ریتیکا', '123', '123', '12', '3', '1', 1.00, 1.00, 1.00, NULL, NULL, 80, '2025-10-15 10:00:48', '2025-10-15 10:00:48'),
(9, 6, 1, 'renu', 'up85', 'teat', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:47', '2025-10-15 10:10:47'),
(10, 6, 2, 'renu', 'jusqu\'à85', 'trayon', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:50', '2025-10-15 10:10:50'),
(11, 6, 12, 'रेनू', 'up85', 'चूची', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:52', '2025-10-15 10:10:52'),
(12, 6, 13, 'رینو', 'UP85', 'چائے', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:56', '2025-10-15 10:10:56'),
(13, 7, 1, 'renu', 'up85', 'teat', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:58', '2025-10-15 10:10:58'),
(14, 7, 2, 'renu', 'jusqu\'à85', 'trayon', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:10:59', '2025-10-15 10:10:59'),
(15, 7, 12, 'रेनू', 'up85', 'चूची', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:11:00', '2025-10-15 10:11:00'),
(16, 7, 13, 'رینو', 'UP85', 'چائے', '1215', '1212', '2121', '21121', '121212', '121212', 21121.00, 21212.00, 2112.00, NULL, NULL, 80, '2025-10-15 10:11:01', '2025-10-15 10:11:01'),
(17, 13, 1, 'lokesg', 'jk', 'jk', 'j', 'kj', 'j', 'j', 'jk', '15', 151.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-23 16:39:35', '2025-10-23 16:39:35'),
(18, 13, 2, 'j\'aime', 'jk', 'jk', 'j', 'kj', 'j', 'j', 'jk', '15', 151.00, 15.00, 15.00, NULL, NULL, 80, '2025-10-23 16:39:37', '2025-10-23 16:39:37'),
(19, 19, 1, 'red', 'fe', 'fdf', 'fd', '85', '8', '5', '5', '5', 5.00, 5.00, 5.00, 42, 7, 1, '2025-10-25 11:28:26', '2025-10-25 11:28:26'),
(20, 19, 2, 'rouge', 'fe', 'fdf', 'fd', '85', '8', '5', '5', '5', 5.00, 5.00, 5.00, 42, 7, 1, '2025-10-25 11:28:27', '2025-10-25 11:28:27'),
(21, 23, 1, 'and', 'and', 'and', 'and', '1', '1', '1', '1', '1', 1.00, 1.00, 1.00, 57, 6, 1, '2025-11-04 20:59:25', '2025-11-04 20:59:25'),
(22, 23, 2, 'et', 'et', 'et', 'et', '1', '1', '1', '1', '1', 1.00, 1.00, 1.00, 57, 6, 1, '2025-11-04 20:59:26', '2025-11-04 20:59:26'),
(23, 24, 1, 'to', 'to', 'tpo', '1', '1', '1', '1', '1', '1', 1.00, 1.00, 1.00, 73, NULL, 1, '2025-11-05 20:06:03', '2025-11-05 20:06:03'),
(24, 24, 2, 'à', 'à', 'tpo', '1', '1', '1', '1', '1', '1', 1.00, 1.00, 1.00, 73, NULL, 1, '2025-11-05 20:06:05', '2025-11-05 20:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `language_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_conditions`
--

INSERT INTO `terms_conditions` (`id`, `title`, `description`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'Terms and Conditions', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2025-11-04 15:03:59', '2025-11-04 15:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name_type`, `created_at`, `updated_at`) VALUES
(1, 'Agent', NULL, NULL),
(2, 'Supplier', NULL, NULL),
(3, 'Farmer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usertype_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_entity_registration` varchar(255) DEFAULT NULL,
  `employer_identification_number` varchar(255) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `verify` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reject_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usertype_id`, `country_id`, `language_id`, `username`, `name`, `email`, `company_name`, `manager_name`, `position`, `image`, `city`, `region`, `address`, `phone`, `mobile`, `status_id`, `state_entity_registration`, `employer_identification_number`, `latitude`, `longitude`, `email_verified_at`, `password`, `remember_token`, `device_id`, `otp`, `otp_expires_at`, `verify`, `created_at`, `updated_at`, `reject_message`) VALUES
(194, 3, 2, NULL, NULL, 'farmer1', 'farmer@gmail.com', NULL, NULL, NULL, '1765792815_10045.jpg', NULL, NULL, NULL, '89595988659898', NULL, 2, NULL, NULL, NULL, NULL, NULL, '$2y$12$fF.JBphQaRmtwVJ4KGYJfO4sBmFw.v/Ihjm1DZn8OexXQMmgSENHu', NULL, 'fa_jM8H-SoiSnzBFsuNmED:APA91bEgTYYpH3i8O-HGyxgjd61caRmtwfB4zuewbtZoxQYmI7lfmA7tQ0Ps99cSjXDDaFi5w4LzMALZB0UMtG-GOAQhX_MF6aUtD6ChX9MJs-f_6-5tyKM', '765557', '2025-12-15 17:10:15', 'yes', '2025-12-15 15:20:35', '2026-05-20 21:09:25', NULL),
(195, 3, 1, 1, NULL, 'farmer2', 'farmer2@gmail.com', NULL, NULL, NULL, '1765787847_image_picker_F2D708D6-62FA-49DA-8ED0-0C10A1F17212-29036-0000003ECB8BDD1F.png', NULL, NULL, NULL, '2343434', NULL, 2, NULL, NULL, NULL, NULL, NULL, '$2y$12$n.qB1RYaXdlxmAGGmTSr7eShul4104NIhzMgP0AYEmNTJTwoUVlTe', NULL, 'dwbyk4EjSPqJZDS877HvfA:APA91bFgEeOn-GwHWkIEmMUm0wHhlSuyetgxmaWGLqgGP0Lv1-8A56m8KlO5IVejZ8awZjmDH3ejIeDSEvuYNMy1qp8BWx8FvAn1FQF7AwpjKeMRAusnFNo', NULL, NULL, 'yes', '2025-12-15 15:37:28', '2025-12-20 14:52:20', NULL),
(196, 3, 2, NULL, NULL, 'Sanou saidou', 'saidousanou@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0022678222277', NULL, 2, NULL, NULL, NULL, NULL, NULL, '$2y$12$ECTyLcc9cVwC.XKcJEWEVu3IDlirM7hVZywH6jS.x4Q66mn/hK6p.', NULL, 'e7wsN5WQRiOZJxY2NJtW40:APA91bFkK5nAR3G3nt1yWy7ZfhqjvtmVmlfgYwcDLtFDljFZ4Ha3kSdZhHknG1fHTjcJ1VTgI63D1wrAqWBrCYDjwNU9ZAHViHo7CUnPL7Zkn0TEtLbRgZk', '688941', '2026-01-20 22:11:13', NULL, '2026-01-20 22:01:13', '2026-05-20 20:48:46', NULL),
(197, 3, 12, 2, NULL, 'Ado', 'adinbloukounon@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00221773887212', NULL, 2, NULL, NULL, NULL, NULL, NULL, '$2y$12$TTUDoMwKJcLmVpH/Q.l5muHrSezniNrabyz3MJMxC0irZA/J/pbC.', NULL, 'd8K5pNzESEK4znyQ4pAKVq:APA91bECEo_lJUhNxoCImlolKZLUoQfoSP76I-_k5fKUt36hM1AkOIQrdFxRZcFPBiXjCvbyqfbnpIwMOR9_4FjJLRLdIaIw7t9b8hiCVRtMs3o75BwMI3M', NULL, NULL, 'yes', '2026-02-11 01:00:58', '2026-05-20 20:48:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `type_name`, `language_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Agent', NULL, NULL, '2025-10-01 01:32:17', '2025-10-01 01:32:17'),
(2, ' Supplier                ', NULL, NULL, '2025-10-01 01:32:17', '2025-10-01 01:32:17'),
(3, 'Farmer', NULL, NULL, '2025-10-01 20:52:33', '2025-10-01 20:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_creation_log`
--

CREATE TABLE `user_creation_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_creation_log`
--

INSERT INTO `user_creation_log` (`id`, `user_id`, `usertype_id`, `country_id`, `language_id`, `created_by`, `created_at`) VALUES
(11, 67, 3, 5, 2, NULL, '2025-10-06 14:12:53'),
(12, 68, 1, 2, 1, NULL, '2025-10-06 18:37:05'),
(13, 69, 1, 1, 1, NULL, '2025-10-06 18:44:09'),
(14, 70, 2, 2, 2, NULL, '2025-10-06 18:46:01'),
(15, 71, 1, 2, 1, NULL, '2025-10-06 18:51:38'),
(16, 72, 1, 1, 1, NULL, '2025-10-07 00:40:52'),
(19, 79, 1, 1, 12, 0, '2025-10-07 09:15:04'),
(20, 80, 2, 1, 1, 0, '2025-10-07 09:18:25'),
(21, 81, 1, 2, 1, 0, '2025-10-08 05:25:11'),
(22, 82, 1, 2, 1, 0, '2025-10-10 09:45:42'),
(23, 83, 1, 1, 1, 0, '2025-10-15 06:14:25'),
(24, 84, 1, 6, 12, 0, '2025-10-15 12:24:39'),
(25, 85, 2, 6, 12, 0, '2025-10-15 12:55:31'),
(26, 86, 1, 1, 1, NULL, '2025-10-24 04:07:40'),
(27, 87, 1, 2, 1, 0, '2025-10-25 07:21:10'),
(28, 88, 1, 5, 1, 0, '2025-10-25 14:42:29'),
(29, 89, 1, 7, 1, 0, '2025-10-25 14:44:29'),
(30, 90, 1, 2, 1, NULL, '2025-10-27 14:38:05'),
(31, 91, 2, 1, 1, NULL, '2025-10-27 15:35:44'),
(32, 92, 2, 1, 1, NULL, '2025-10-27 15:40:25'),
(33, 93, 2, 1, 1, NULL, '2025-10-27 15:43:01'),
(34, 94, 2, 1, 1, NULL, '2025-10-27 15:51:12'),
(35, 95, 1, 1, 1, NULL, '2025-10-27 16:02:08'),
(36, 96, 1, 1, 1, NULL, '2025-10-27 16:07:48'),
(37, 97, 1, 1, 1, NULL, '2025-10-27 16:12:27'),
(38, 98, 1, 1, 1, NULL, '2025-10-27 16:13:44'),
(39, 99, 1, 1, 1, NULL, '2025-10-27 16:19:00'),
(40, 100, 1, 1, 1, NULL, '2025-10-28 01:51:13'),
(41, 101, 1, 1, 1, NULL, '2025-10-28 02:11:15'),
(42, 102, 1, 1, 1, NULL, '2025-10-28 02:14:25'),
(43, 103, 1, 1, 1, NULL, '2025-10-28 14:00:10'),
(44, 104, 1, 1, 1, NULL, '2025-10-28 14:13:31'),
(45, 105, 1, 1, 1, NULL, '2025-10-28 14:14:49'),
(46, 106, 1, 1, 1, NULL, '2025-10-29 16:54:10'),
(47, 107, 1, 1, 1, NULL, '2025-10-29 21:07:08'),
(48, 108, 1, 1, 1, NULL, '2025-10-31 12:54:35'),
(49, 109, 1, 1, 1, NULL, '2025-10-31 20:47:22'),
(50, 110, 1, 1, 1, NULL, '2025-10-31 20:57:44'),
(51, 111, 1, 1, 1, NULL, '2025-10-31 20:58:27'),
(52, 112, 1, 1, 1, NULL, '2025-10-31 21:11:31'),
(53, 113, 1, 1, 1, NULL, '2025-10-31 21:13:51'),
(54, 119, 1, 1, 1, NULL, '2025-11-01 13:37:56'),
(55, 125, 1, 1, 1, 0, '2025-11-01 07:11:33'),
(56, 126, 1, 1, 1, 0, '2025-11-01 07:12:28'),
(57, 139, 1, 1, 1, 0, '2025-11-04 07:27:08'),
(58, 141, 1, 1, 1, NULL, '2025-11-04 14:40:19'),
(59, 142, 2, 1, 2, NULL, '2025-11-04 20:28:42'),
(60, 143, 3, 2, 1, 0, '2025-11-05 04:05:23'),
(61, 144, 1, 1, 1, 0, '2025-11-05 06:04:09'),
(62, 155, 1, 1, 1, 0, '2025-11-05 12:01:07'),
(63, 156, 2, 1, 2, NULL, '2025-11-05 22:47:38'),
(64, 159, 2, 1, 2, NULL, '2025-11-06 13:39:36'),
(65, 160, 2, 1, 2, NULL, '2025-11-06 14:12:44'),
(66, 161, 3, 1, 1, NULL, '2025-11-06 18:52:38'),
(67, 162, 3, 1, 1, NULL, '2025-11-06 20:11:47'),
(68, 163, 3, 1, 1, NULL, '2025-11-10 18:13:35'),
(69, 164, 3, 1, 1, NULL, '2025-11-18 17:17:15'),
(70, 165, 1, 1, 1, 0, '2025-11-22 07:10:00'),
(71, 166, 1, 2, 1, 0, '2025-11-26 13:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_translations`
--

CREATE TABLE `user_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `veterinary_products`
--

CREATE TABLE `veterinary_products` (
  `id` int(11) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `live_id` tinyint(1) DEFAULT 0,
  `form_type` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `localProductName` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `manufacturing_lab` varchar(255) DEFAULT NULL,
  `active_substance` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) NOT NULL,
  `therapeutic_class` varchar(255) DEFAULT NULL,
  `other_therapeutic_class` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `pharmaceutical_form` varchar(255) DEFAULT NULL,
  `route_of_administration` varchar(255) DEFAULT NULL,
  `targeted_animals` varchar(255) DEFAULT NULL,
  `waiting_period` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `transport_storage_requirements` varchar(255) DEFAULT NULL,
  `wholesale_price` decimal(10,2) NOT NULL,
  `semiwholesale_price` decimal(10,2) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_master_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otherRecommendationsPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `veterinary_products`
--

INSERT INTO `veterinary_products` (`id`, `parent_id`, `live_id`, `form_type`, `title`, `localProductName`, `product_name`, `manufacturing_lab`, `active_substance`, `registration_number`, `therapeutic_class`, `other_therapeutic_class`, `dosage`, `pharmaceutical_form`, `route_of_administration`, `targeted_animals`, `waiting_period`, `expiry_date`, `transport_storage_requirements`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `qr_code_path`, `product_id`, `product_master_id`, `created_by`, `supplier_id`, `agent_id`, `status_id`, `reject_reason`, `language_id`, `created_at`, `updated_at`, `otherRecommendationsPhoto`) VALUES
(69, NULL, 0, 'veterinary_product', NULL, NULL, 'VetoGuard Oxytetracycline 20%', 'Ceva Sante Animale', 'Oxytetracycline', 'REG-BF-VET-2024-022', 'Antibiotics', NULL, '1mL per 10 kg live weight', 'Injections', 'Intramuscular', 'Cattle, Goats, Sheeps', '5 months', '2025-12-19', 'Keep below 25°', 2000.00, 3000.00, 3000.00, 'qrcodes/veterinary_69.png', 1, NULL, 1, 191, 100, 3, 'fail', 1, '2025-12-15 16:34:06', '2026-01-12 11:39:32', NULL),
(100054, NULL, 1, 'veterinary_product', 'Vet Product Example', NULL, 'SuperVet', 'VetLab Pvt Ltd', 'Substance X', 'REG123456', 'Antibiotic', 'NA', '5 ml / kg', 'Liquid', 'Oral', 'Cattle', '3 days', '2026-12-31', 'Keep in cool place', 120.00, 1230.00, 1250.00, 'qrcodes/veterinary_100054.png', 1, NULL, 1, 191, 1, 1, NULL, 1, '2025-12-24 17:34:57', '2025-12-24 17:51:29', 'uploads/veterinary_product/veterinary_1766573489_694bc5b14004c.png'),
(100055, 100054, 0, 'veterinary_product', 'Vet Product Example', NULL, 'SuperVet', 'VetLab Pvt Ltd', 'Substance X', 'REG123456', 'Antibiotic', 'NA', '5 ml / kg', 'Liquid', 'Oral', 'Cattle', '3 days', '2026-12-31', 'Keep in cool place', 120.00, 1230.00, 1250.00, 'qrcodes/veterinary_100055.png', 1, NULL, 1, 191, 1, 2, NULL, 1, '2025-12-24 17:35:52', '2026-02-02 20:29:19', 'uploads/veterinary_product/veterinary_1766572552_694bc20811383.png');

-- --------------------------------------------------------

--
-- Table structure for table `veterinary_products_fields`
--

CREATE TABLE `veterinary_products_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `veterinary_product_translations`
--

CREATE TABLE `veterinary_product_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `veterinary_product_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `manufacturing_lab` varchar(255) DEFAULT NULL,
  `active_substance` varchar(255) DEFAULT NULL,
  `therapeutic_class` varchar(255) DEFAULT NULL,
  `other_therapeutic_class` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `pharmaceutical_form` varchar(255) DEFAULT NULL,
  `route_of_administration` varchar(255) DEFAULT NULL,
  `targeted_animals` varchar(255) DEFAULT NULL,
  `waiting_period` varchar(255) DEFAULT NULL,
  `transport_storage_requirements` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `semiwholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veterinary_product_translations`
--

INSERT INTO `veterinary_product_translations` (`id`, `veterinary_product_id`, `language_id`, `title`, `product_name`, `manufacturing_lab`, `active_substance`, `therapeutic_class`, `other_therapeutic_class`, `dosage`, `pharmaceutical_form`, `route_of_administration`, `targeted_animals`, `waiting_period`, `transport_storage_requirements`, `registration_number`, `expiry_date`, `wholesale_price`, `semiwholesale_price`, `retail_price`, `supplier_id`, `agent_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 11, 1, NULL, 'dknfkvj', 'jnkjkc', 'knjnjk', '4554', '5445', '54454', '4554', '55454', '5454', '5445', 'h', 'k8', '2025-10-22', 2.00, 2.00, 2.00, NULL, NULL, 1, '2025-10-15 11:01:17', '2025-10-15 11:01:17'),
(2, 11, 2, NULL, 'dknfkvj', 'jnkjkc', 'knjnjk', '4554', '5445', '54454', '4554', '55454', '5454', '5445', 'h', 'k8', '2025-10-22', 2.00, 2.00, 2.00, NULL, NULL, 1, '2025-10-15 11:01:25', '2025-10-15 11:01:25'),
(3, 11, 12, NULL, 'dknfkvj', 'jnkjkc', 'knjnjk', '4554', '5445', '54454', '4554', '55454', '5454', '5445', 'एच', 'k8', '2025-10-22', 2.00, 2.00, 2.00, NULL, NULL, 1, '2025-10-15 11:01:31', '2025-10-15 11:01:31'),
(4, 11, 13, NULL, 'dknfkvj', 'jnkjkc', 'knjnjk', '4554', '5445', '54454', '4554', '55454', '5454', '5445', 'h', 'k8', '2025-10-22', 2.00, 2.00, 2.00, NULL, NULL, 1, '2025-10-15 11:01:39', '2025-10-15 11:01:39'),
(5, 12, 1, NULL, 'ritika', 'ritika', '11', '433', '434', '12', '12121', '1221', '2121', '11', '1212', '3223', '2025-10-15', 21.00, 1221.00, 21.00, NULL, NULL, 1, '2025-10-15 11:05:32', '2025-10-15 11:05:32'),
(6, 12, 2, NULL, 'ritika', 'ritika', '11', '433', '434', '12', '12121', '1221', '2121', '11', '1212', '3223', '2025-10-15', 21.00, 1221.00, 21.00, NULL, NULL, 1, '2025-10-15 11:05:34', '2025-10-15 11:05:34'),
(7, 12, 12, NULL, 'रितिका', 'रितिका', '11', '433', '434', '12', '12121', '1221', '2121', '11', '1212', '3223', '2025-10-15', 21.00, 1221.00, 21.00, NULL, NULL, 1, '2025-10-15 11:05:36', '2025-10-15 11:05:36'),
(8, 12, 13, NULL, 'ریتیکا', 'ریتیکا', '11', '433', '434', '12', '12121', '1221', '2121', '11', '1212', '3223', '2025-10-15', 21.00, 1221.00, 21.00, NULL, NULL, 1, '2025-10-15 11:05:38', '2025-10-15 11:05:38'),
(9, 13, 1, NULL, 'test', 'test', 'test', 'Antibiotics', 'test', 'tat', 'ttw', 'tat', 'ttt', 'ttt', 'jhsb', 'test85', '2025-10-16', 12.00, 12.00, 12.00, NULL, NULL, 1, '2025-10-16 20:13:22', '2025-10-16 20:13:22'),
(10, 13, 2, NULL, 'test', 'test', 'test', 'Antibiotiques', 'test', 'tatou', 'ttw', 'tatou', 'ttt', 'ttt', 'jhsb', 'test85', '2025-10-16', 12.00, 12.00, 12.00, NULL, NULL, 1, '2025-10-16 20:13:24', '2025-10-16 20:13:24'),
(11, 13, 12, NULL, 'परीक्षा', 'परीक्षा', 'परीक्षा', 'एंटीबायोटिक दवाओं', 'परीक्षा', 'गूंथना', 'ttw', 'गूंथना', 'टीटीटी', 'टीटीटी', 'जेएचएसबी', 'test85', '2025-10-16', 12.00, 12.00, 12.00, NULL, NULL, 1, '2025-10-16 20:13:28', '2025-10-16 20:13:28'),
(12, 13, 13, NULL, 'ٹیسٹ', 'ٹیسٹ', 'ٹیسٹ', 'اینٹی بائیوٹکس', 'ٹیسٹ', 'tat', 'ٹی ٹی ڈبلیو', 'tat', 'ttt', 'ttt', 'جے ایچ ایس بی', 'test85', '2025-10-16', 12.00, 12.00, 12.00, NULL, NULL, 1, '2025-10-16 20:13:35', '2025-10-16 20:13:35'),
(13, 14, 1, NULL, 'dfn', 'knkn', 'kjnkjnqjkn', 'Pest Control', 'lmlme', 'mlml', 'lmlkm', 'lml', NULL, '4', '4', '74', '2025-10-23', 4.00, 4.00, 44.00, NULL, NULL, 1, '2025-10-16 20:20:25', '2025-10-16 20:20:25'),
(14, 14, 2, NULL, 'dfn', 'je sais', 'kjnkjnqjkn', 'Lutte antiparasitaire', 'lmlme', 'mlml', 'lmlkm', 'lml', NULL, '4', '4', '74', '2025-10-23', 4.00, 4.00, 44.00, NULL, NULL, 1, '2025-10-16 20:20:35', '2025-10-16 20:20:35'),
(15, 14, 12, NULL, 'डीएफएन', 'knkn', 'kjnkjnqjkn', 'कीट नियंत्रण', 'एलएमएलएमई', 'एमएलएमएल', 'एलएमएलकेएम', 'एलएमएल', NULL, '4', '4', '74', '2025-10-23', 4.00, 4.00, 44.00, NULL, NULL, 1, '2025-10-16 20:20:38', '2025-10-16 20:20:38'),
(16, 14, 13, NULL, 'ڈی ایف این', 'knkn', 'kjnkjnqjkn', 'کیڑوں پر قابو پالیں', 'lmlme', 'ایم ایل ایم ایل', 'lmlkm', 'lml', NULL, '4', '4', '74', '2025-10-23', 4.00, 4.00, 44.00, NULL, NULL, 1, '2025-10-16 20:20:48', '2025-10-16 20:20:48'),
(17, 15, 1, NULL, 'jhvfbh', 'jhbhj', 'bhjbhj', 'Vaccines', '12', '12', '2', '1', '1', '1', '1', 'jhjb', '2025-10-16', 1.00, 1.00, 1.00, NULL, NULL, 1, '2025-10-16 20:24:05', '2025-10-16 20:24:05'),
(18, 15, 2, NULL, 'jhvfbh', 'jhbhj', 'bhjbhj', 'Vaccins', '12', '12', '2', '1', '1', '1', '1', 'jhjb', '2025-10-16', 1.00, 1.00, 1.00, NULL, NULL, 1, '2025-10-16 20:24:09', '2025-10-16 20:24:09'),
(19, 15, 12, NULL, 'jhvfbh', 'jhbhj', 'भजभज', 'टीके', '12', '12', '2', '1', '1', '1', '1', 'jhjb', '2025-10-16', 1.00, 1.00, 1.00, NULL, NULL, 1, '2025-10-16 20:24:12', '2025-10-16 20:24:12'),
(20, 15, 13, NULL, 'jhvfbh', 'جے ایچ بی ایچ جے', 'BHJBHJ', 'ویکسینز', '12', '12', '2', '1', '1', '1', '1', 'jhjb', '2025-10-16', 1.00, 1.00, 1.00, NULL, NULL, 1, '2025-10-16 20:24:19', '2025-10-16 20:24:19'),
(21, 16, 1, NULL, 'Animal Health Booster', 'VetCare Labs Pvt Ltd', 'Vitamin B Complex', 'Nutritional Supplement', 'Energy Booster', '5ml per 10kg body weight', 'Liquid', 'Oral', 'Cattle, Sheep, Goats', '3 days before slaughter', 'Store in a cool dry place', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:15:31', '2025-10-17 09:15:31'),
(22, 16, 2, NULL, 'Booster de santé animale', 'Laboratoires VetCare Pvt Ltd', 'Complexe de vitamines B', 'Supplément nutritionnel', 'Booster d\'énergie', '5 ml pour 10 kg de poids corporel', 'Liquide', 'Oral', 'Bovins, ovins, caprins', '3 jours avant l\'abattage', 'Conserver dans un endroit frais et sec', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:15:37', '2025-10-17 09:15:37'),
(23, 16, 12, NULL, 'पशु स्वास्थ्य वर्धक', 'वेटकेयर लैब्स प्राइवेट लिमिटेड', 'विटामिन बी कॉम्प्लेक्स', 'पोषण अनुपूरक', 'एनर्जी बूस्टर', 'प्रति 10 किलो वजन पर 5 मि.ली', 'तरल', 'मौखिक', 'मवेशी, भेड़, बकरियाँ', 'वध से 3 दिन पहले', 'ठंडे और सूखे स्थान में रखें', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:15:45', '2025-10-17 09:15:45'),
(24, 16, 13, NULL, 'جانوروں کی صحت کو بڑھانے والا', 'ویٹ کیئر لیبز پرائیوٹ لمیٹڈ', 'وٹامن بی کمپلیکس', 'غذائیت کا ضمیمہ', 'انرجی بوسٹر', '5 ملی لیٹر فی 10 کلو گرام جسمانی وزن', 'مائع', 'زبانی', 'مویشی ، بھیڑ ، بکرے', 'ذبح سے 3 دن پہلے', 'ٹھنڈی خشک جگہ پر اسٹور کریں', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:15:57', '2025-10-17 09:15:57'),
(25, 17, 1, 'Cattle Immunity Booster', 'Animal Health Booster', 'VetCare Labs Pvt Ltd', 'Vitamin B Complex', 'Nutritional Supplement', 'Energy Booster', '5ml per 10kg body weight', 'Liquid', 'Oral', 'Cattle, Sheep, Goats', '3 days before slaughter', 'Store in a cool dry place', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:32:19', '2025-10-17 09:32:19'),
(26, 17, 2, 'Booster d\'immunité des bovins', 'Booster de santé animale', 'Laboratoires VetCare Pvt Ltd', 'Complexe de vitamines B', 'Supplément nutritionnel', 'Booster d\'énergie', '5 ml pour 10 kg de poids corporel', 'Liquide', 'Oral', 'Bovins, ovins, caprins', '3 jours avant l\'abattage', 'Conserver dans un endroit frais et sec', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:32:21', '2025-10-17 09:32:21'),
(27, 17, 12, 'मवेशी प्रतिरक्षा बूस्टर', 'पशु स्वास्थ्य वर्धक', 'वेटकेयर लैब्स प्राइवेट लिमिटेड', 'विटामिन बी कॉम्प्लेक्स', 'पोषण अनुपूरक', 'एनर्जी बूस्टर', 'प्रति 10 किलो वजन पर 5 मि.ली', 'तरल', 'मौखिक', 'मवेशी, भेड़, बकरियाँ', 'वध से 3 दिन पहले', 'ठंडे और सूखे स्थान में रखें', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:32:23', '2025-10-17 09:32:23'),
(28, 17, 13, 'مویشیوں سے استثنیٰ بوسٹر', 'جانوروں کی صحت کو بڑھانے والا', 'ویٹ کیئر لیبز پرائیوٹ لمیٹڈ', 'وٹامن بی کمپلیکس', 'غذائیت کا ضمیمہ', 'انرجی بوسٹر', '5 ملی لیٹر فی 10 کلو گرام جسمانی وزن', 'مائع', 'زبانی', 'مویشی ، بھیڑ ، بکرے', 'ذبح سے 3 دن پہلے', 'ٹھنڈی خشک جگہ پر اسٹور کریں', 'REG-2025-001', '2026-12-31', 150.00, 175.00, 200.00, 37, 3, 1, '2025-10-17 09:32:26', '2025-10-17 09:32:26'),
(29, 26, 1, NULL, 'test', 'test', 'tetst', 'Pest Control', 'test', 'red', '12', '2', '2', '2', '223', 'tdtdt', '2025-10-23', 33.00, 33.00, 33.00, NULL, NULL, 1, '2025-10-23 16:36:11', '2025-10-23 16:36:11'),
(30, 26, 2, NULL, 'test', 'test', 'test', 'Lutte antiparasitaire', 'test', 'rouge', '12', '2', '2', '2', '223', 'tdtdt', '2025-10-23', 33.00, 33.00, 33.00, NULL, NULL, 1, '2025-10-23 16:36:13', '2025-10-23 16:36:13'),
(31, 27, 1, NULL, 'web', 'web', 'web', 'Antibiotics', '55', '55', '5', '5', '5', '5', '15', '85', '2025-10-31', 1.00, 1.00, 1.00, 41, 6, 1, '2025-10-23 18:24:37', '2025-10-23 18:24:37'),
(32, 27, 2, NULL, 'la toile', 'la toile', 'la toile', 'Antibiotiques', '55', '55', '5', '5', '5', '5', '15', '85', '2025-10-31', 1.00, 1.00, 1.00, 41, 6, 1, '2025-10-23 18:24:37', '2025-10-23 18:24:37'),
(33, 32, 1, NULL, 'rich', 'rich', 'rightq', 'Pest Control', '1', '1', '1', '1', '1', '1', '2', '85', '2025-10-25', 2.00, 2.00, 2.00, 42, 8, 1, '2025-10-25 11:33:49', '2025-10-25 11:33:49'),
(34, 32, 2, NULL, 'riche', 'riche', 'c\'est vrai', 'Lutte antiparasitaire', '1', '1', '1', '1', '1', '1', '2', '85', '2025-10-25', 2.00, 2.00, 2.00, 42, 8, 1, '2025-10-25 11:33:52', '2025-10-25 11:33:52'),
(35, 33, 1, NULL, 'red', '12', '2', 'Pest Control', '2', '2', '2', '2', '2', '1', '1', '2', '2025-10-25', 1.00, 1.00, 1.00, 39, 3, 1, '2025-10-25 12:25:37', '2025-10-25 12:25:37'),
(36, 33, 2, NULL, 'rouge', '12', '2', 'Lutte antiparasitaire', '2', '2', '2', '2', '2', '1', '1', '2', '2025-10-25', 1.00, 1.00, 1.00, 39, 3, 1, '2025-10-25 12:25:38', '2025-10-25 12:25:38'),
(37, 44, 1, NULL, 'ter', 'jknsjc', 'nca', 'Antibiotics', 'j', '1', '1', '1', '1', '1', '2', 'j', '2025-11-05', 2.00, 2.00, 2.00, 73, NULL, 1, '2025-11-05 19:04:20', '2025-11-05 19:04:20'),
(38, 44, 2, NULL, 'ter', 'jknsjc', 'nca', 'Antibiotiques', 'j', '1', '1', '1', '1', '1', '2', 'j', '2025-11-05', 2.00, 2.00, 2.00, 73, NULL, 1, '2025-11-05 19:04:23', '2025-11-05 19:04:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_email_unique` (`email`),
  ADD UNIQUE KEY `agents_username_unique` (`username`);

--
-- Indexes for table `agent_translations`
--
ALTER TABLE `agent_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_translations_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `agriculture_forms`
--
ALTER TABLE `agriculture_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allcomplementary`
--
ALTER TABLE `allcomplementary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allproduct`
--
ALTER TABLE `allproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animalfeed_testing`
--
ALTER TABLE `animalfeed_testing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `animal_feeds`
--
ALTER TABLE `animal_feeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animalfeed_language` (`language_id`);

--
-- Indexes for table `animal_feed_fields`
--
ALTER TABLE `animal_feed_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animal_feed_translations`
--
ALTER TABLE `animal_feed_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_feed_id` (`animal_feed_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_type_id_foreign` (`user_type_id`(768));

--
-- Indexes for table `announcement_translations`
--
ALTER TABLE `announcement_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `bio_stimulants`
--
ALTER TABLE `bio_stimulants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bio_stimulants_fields`
--
ALTER TABLE `bio_stimulants_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bio_stimulant_translations`
--
ALTER TABLE `bio_stimulant_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bst_bio_stimulant` (`bio_stimulant_id`),
  ADD KEY `fk_bst_language` (`language_id`),
  ADD KEY `fk_bst_supplier` (`supplier_id`),
  ADD KEY `fk_bst_agent` (`agent_id`);

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
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enqerytype`
--
ALTER TABLE `enqerytype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry_messages`
--
ALTER TABLE `enquiry_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_id` (`enquiry_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `farmer_enquiries`
--
ALTER TABLE `farmer_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_structures`
--
ALTER TABLE `form_structures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inorganic_soil_conditioners`
--
ALTER TABLE `inorganic_soil_conditioners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inorganic_soil_conditioner_fields`
--
ALTER TABLE `inorganic_soil_conditioner_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inorganic_soil_conditioner_translations`
--
ALTER TABLE `inorganic_soil_conditioner_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inorganic_id` (`inorganic_soil_conditioner_id`),
  ADD KEY `idx_language_id` (`language_id`);

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
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lang_code` (`lang_code`);

--
-- Indexes for table `master_admin`
--
ALTER TABLE `master_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mineral_fertilizers`
--
ALTER TABLE `mineral_fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mineral_fertilizer_fields`
--
ALTER TABLE `mineral_fertilizer_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mineral_fertilizer_translations`
--
ALTER TABLE `mineral_fertilizer_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onboarding_contents`
--
ALTER TABLE `onboarding_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organic_amendments`
--
ALTER TABLE `organic_amendments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organic_amendment_fields`
--
ALTER TABLE `organic_amendment_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organic_amendment_translations`
--
ALTER TABLE `organic_amendment_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_order_supplier_responses`
--
ALTER TABLE `pre_order_supplier_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pre_order_id` (`pre_order_id`);

--
-- Indexes for table `price_histories`
--
ALTER TABLE `price_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privacy_policies_language_id_foreign` (`language_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `product_likes`
--
ALTER TABLE `product_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `seed`
--
ALTER TABLE `seed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_fields`
--
ALTER TABLE `seed_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_fields_english_french`
--
ALTER TABLE `seed_fields_english_french`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seed_lang_name` (`product_id`,`language_id`,`name`);

--
-- Indexes for table `seed_forms`
--
ALTER TABLE `seed_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_form_translations`
--
ALTER TABLE `seed_form_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_translates`
--
ALTER TABLE `seed_translates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_status_id_foreign` (`status_id`);

--
-- Indexes for table `supplier_translates`
--
ALTER TABLE `supplier_translates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `synthetic_pesticides`
--
ALTER TABLE `synthetic_pesticides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `synthetic_pesticides_fields`
--
ALTER TABLE `synthetic_pesticides_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `synthetic_pesticide_translations`
--
ALTER TABLE `synthetic_pesticide_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terms_conditions_language_id_index` (`language_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_usertype_id_foreign` (`usertype_id`),
  ADD KEY `users_country_id_foreign` (`country_id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usertype_type_name_unique` (`type_name`);

--
-- Indexes for table `user_creation_log`
--
ALTER TABLE `user_creation_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_translations`
--
ALTER TABLE `user_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_translations_user_id_foreign` (`user_id`);

--
-- Indexes for table `veterinary_products`
--
ALTER TABLE `veterinary_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veterinary_products_fields`
--
ALTER TABLE `veterinary_products_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veterinary_product_translations`
--
ALTER TABLE `veterinary_product_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vp_translation_product` (`veterinary_product_id`),
  ADD KEY `fk_vp_translation_language` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `agent_translations`
--
ALTER TABLE `agent_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `agriculture_forms`
--
ALTER TABLE `agriculture_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `allcomplementary`
--
ALTER TABLE `allcomplementary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `allproduct`
--
ALTER TABLE `allproduct`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;

--
-- AUTO_INCREMENT for table `animalfeed_testing`
--
ALTER TABLE `animalfeed_testing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100006;

--
-- AUTO_INCREMENT for table `animal_feeds`
--
ALTER TABLE `animal_feeds`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100018;

--
-- AUTO_INCREMENT for table `animal_feed_fields`
--
ALTER TABLE `animal_feed_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `animal_feed_translations`
--
ALTER TABLE `animal_feed_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `announcement_translations`
--
ALTER TABLE `announcement_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bio_stimulants`
--
ALTER TABLE `bio_stimulants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100028;

--
-- AUTO_INCREMENT for table `bio_stimulants_fields`
--
ALTER TABLE `bio_stimulants_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bio_stimulant_translations`
--
ALTER TABLE `bio_stimulant_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enqerytype`
--
ALTER TABLE `enqerytype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `enquiry_messages`
--
ALTER TABLE `enquiry_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmer_enquiries`
--
ALTER TABLE `farmer_enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `form_structures`
--
ALTER TABLE `form_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inorganic_soil_conditioners`
--
ALTER TABLE `inorganic_soil_conditioners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100034;

--
-- AUTO_INCREMENT for table `inorganic_soil_conditioner_fields`
--
ALTER TABLE `inorganic_soil_conditioner_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inorganic_soil_conditioner_translations`
--
ALTER TABLE `inorganic_soil_conditioner_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `master_admin`
--
ALTER TABLE `master_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mineral_fertilizers`
--
ALTER TABLE `mineral_fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100059;

--
-- AUTO_INCREMENT for table `mineral_fertilizer_fields`
--
ALTER TABLE `mineral_fertilizer_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mineral_fertilizer_translations`
--
ALTER TABLE `mineral_fertilizer_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `onboarding_contents`
--
ALTER TABLE `onboarding_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `organic_amendments`
--
ALTER TABLE `organic_amendments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100053;

--
-- AUTO_INCREMENT for table `organic_amendment_fields`
--
ALTER TABLE `organic_amendment_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `organic_amendment_translations`
--
ALTER TABLE `organic_amendment_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pre_orders`
--
ALTER TABLE `pre_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pre_order_supplier_responses`
--
ALTER TABLE `pre_order_supplier_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `price_histories`
--
ALTER TABLE `price_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_likes`
--
ALTER TABLE `product_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `seed`
--
ALTER TABLE `seed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `seed_fields`
--
ALTER TABLE `seed_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `seed_fields_english_french`
--
ALTER TABLE `seed_fields_english_french`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `seed_forms`
--
ALTER TABLE `seed_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100078;

--
-- AUTO_INCREMENT for table `seed_form_translations`
--
ALTER TABLE `seed_form_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `seed_translates`
--
ALTER TABLE `seed_translates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `supplier_translates`
--
ALTER TABLE `supplier_translates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `synthetic_pesticides`
--
ALTER TABLE `synthetic_pesticides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100057;

--
-- AUTO_INCREMENT for table `synthetic_pesticides_fields`
--
ALTER TABLE `synthetic_pesticides_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `synthetic_pesticide_translations`
--
ALTER TABLE `synthetic_pesticide_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_creation_log`
--
ALTER TABLE `user_creation_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user_translations`
--
ALTER TABLE `user_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `veterinary_products`
--
ALTER TABLE `veterinary_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100068;

--
-- AUTO_INCREMENT for table `veterinary_products_fields`
--
ALTER TABLE `veterinary_products_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `veterinary_product_translations`
--
ALTER TABLE `veterinary_product_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_translations`
--
ALTER TABLE `agent_translations`
  ADD CONSTRAINT `agent_translations_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `animal_feeds`
--
ALTER TABLE `animal_feeds`
  ADD CONSTRAINT `fk_animalfeed_language` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `animal_feed_translations`
--
ALTER TABLE `animal_feed_translations`
  ADD CONSTRAINT `animal_feed_translations_ibfk_1` FOREIGN KEY (`animal_feed_id`) REFERENCES `animal_feeds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `animal_feed_translations_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_translations`
--
ALTER TABLE `announcement_translations`
  ADD CONSTRAINT `announcement_translations_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bio_stimulant_translations`
--
ALTER TABLE `bio_stimulant_translations`
  ADD CONSTRAINT `fk_bst_agent` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_bst_bio_stimulant` FOREIGN KEY (`bio_stimulant_id`) REFERENCES `bio_stimulants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bst_language` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bst_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enquiry_messages`
--
ALTER TABLE `enquiry_messages`
  ADD CONSTRAINT `enquiry_messages_ibfk_1` FOREIGN KEY (`enquiry_id`) REFERENCES `farmer_enquiries` (`id`);

--
-- Constraints for table `inorganic_soil_conditioner_translations`
--
ALTER TABLE `inorganic_soil_conditioner_translations`
  ADD CONSTRAINT `fk_inorganic_conditioner` FOREIGN KEY (`inorganic_soil_conditioner_id`) REFERENCES `inorganic_soil_conditioners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_language` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pre_order_supplier_responses`
--
ALTER TABLE `pre_order_supplier_responses`
  ADD CONSTRAINT `pre_order_supplier_responses_ibfk_1` FOREIGN KEY (`pre_order_id`) REFERENCES `pre_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD CONSTRAINT `privacy_policies_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `supplier_translates`
--
ALTER TABLE `supplier_translates`
  ADD CONSTRAINT `supplier_translates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_translates_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD CONSTRAINT `terms_conditions_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_usertype_id_foreign` FOREIGN KEY (`usertype_id`) REFERENCES `usertype` (`id`);

--
-- Constraints for table `user_translations`
--
ALTER TABLE `user_translations`
  ADD CONSTRAINT `user_translations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
