-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2022 at 05:37 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` enum('Inactive','Active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `status`, `remember_token`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 'a@b.co', '$2y$10$Sz54IxnJCXGb92Y5EtolqOQkJR6UCLOs2po06H9.uIqV/aDwC3E2W', 'Active', 'tajwlqnpkmR1ZEjrTpxnA6YyzmmTr5shSsa8LsJU7IKkKEYRa4JoApWpNiil', '2021-10-12 06:15:26', 0, '2022-09-04 09:56:37', 1, '0000-00-00 00:00:00', 0),
(3, 'Admin1', 'admin1@gmail.com', '$2y$10$1d42OyK9XOu6ENwciQIcKOTxLjzvxJXqmpTkhTr8qZFJTj8a2FGia', 'Active', '', '2022-01-24 20:23:38', 1, '2022-09-03 10:10:19', 1, '0000-00-00 00:00:00', 0),
(10, 'Sumit', 'sumit@test.com', '$2y$10$ErRbMEf3tms/ItSva.Hf1ehacl.LhBC1bSjau3BRLXo.BjbXeQLuC', 'Active', '', '2022-04-30 09:01:42', 0, '2022-04-30 14:30:56', 0, '2022-04-30 14:30:56', 0),
(12, 'demo', 'demo@demo.com', '$2y$10$4JF0P7KG3unJXAhUo5Znf.v1enzL0boyS5PReviKxVOl4uVKPY0Oq', 'Active', '', '2022-09-03 09:40:00', 1, '2022-09-03 10:08:58', 1, '0000-00-00 00:00:00', 0),
(13, 'test12', 'admin@gmail.com', '$2y$10$iYBWTLV84SRs0LO6nCDlce9pJC.gvlp4FdldlPyxT4HixZakohFji', 'Active', '', '2022-09-04 04:12:18', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(15, 'Adminmm', 'tfmt@gmail.com', '$2y$10$fltZ1w4MejyOFTsW4F0vcOlIdl9CnIXaTbkZmsXY2aXSWNjo51.De', 'Active', '', '2022-09-04 04:13:56', 1, '2022-09-04 04:14:27', 1, '2022-09-04 04:16:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON array, for example: ["Torch","Raincoat",...]',
  `status` enum('Inactive','Active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `name`, `short_description`, `long_description`, `tag`, `status`, `created_at`, `created_by`, `created_by_user_type`, `updated_at`, `updated_by`, `updated_by_user_type`, `deleted_at`, `deleted_by`, `deleted_by_user_type`) VALUES
(10, 'dfa ffff', 'fdfdfff', 'fdfdf fff', '[\"ffff\",\"fff\",\"fd\",\"d\",\"ss\",\"s\"]', 'Active', '2022-09-04 12:35:42', 1, 'Admin', '2022-09-04 23:03:26', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(12, 'cxc  kk', 'xcxc kk', 'cxcxc&nbsp; gghhh', '[\"gfhgfh\"]', 'Active', '2022-09-04 12:41:14', 1, 'Admin', '2022-09-04 20:46:30', 1, 'Admin', '2022-09-04 21:59:30', 1, 'Admin'),
(13, 'xzxz', 'xzx', '<p>zxzx</p>', '[\"zxzxzx\"]', 'Active', '2022-09-04 13:06:16', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '2022-09-04 22:02:25', 1, 'Admin'),
(14, 'sasa11', '11', '<p>11</p>', '[\"jkj11\"]', 'Active', '2022-09-04 19:57:31', 1, 'Admin', '2022-09-05 01:11:14', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(15, 'dsds', 'sds', '<p>sdsd</p>', '[\"dss dsd\",\"d\",\"sdsd\",\"dsd\"]', 'Active', '2022-09-05 00:15:36', 26, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(16, 'xzxzx11', 'Sasa11', '<p>asas11</p>', '[\"sas\",\"ass\",\"as\",\"sasas\",\"jj\"]', 'Active', '2022-09-05 01:09:53', 1, 'Admin', '2022-09-05 01:10:40', 1, 'Admin', '2022-09-05 01:12:35', 1, 'Admin'),
(17, 'fff', 'fff', '<p>fff<br></p>', '[\"wrt\",\"wrt1\",\"2\",\"DD\",\"ff\"]', 'Active', '2022-09-05 04:02:30', 29, 'Tour Operator', '2022-09-05 04:40:38', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `desc`, `blog_id`, `created_at`, `updated_at`) VALUES
(6, 'dsd', 10, '2022-09-04 16:23:32', '2022-09-04 16:23:32'),
(9, 'xmzbxmz', 10, '2022-09-04 17:34:49', '2022-09-04 17:34:49'),
(10, 'zvxvz', 10, '2022-09-04 17:34:58', '2022-09-04 17:34:58'),
(12, 'dd', 14, '2022-09-04 22:07:37', '2022-09-04 22:07:37'),
(13, 'new', 10, '2022-09-04 22:14:39', '2022-09-04 22:14:39'),
(14, 'wrt', 17, '2022-09-04 22:33:00', '2022-09-04 22:33:00'),
(15, 'sdsds', 17, '2022-09-04 23:11:07', '2022-09-04 23:11:07'),
(16, 'zzz', 17, '2022-09-04 23:11:20', '2022-09-04 23:11:20'),
(17, 'mm', 10, '2022-09-04 23:12:44', '2022-09-04 23:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(47, '2022_09_03_072334_create_roles_table', 40),
(48, '2022_09_03_072334_create_comments_table', 41);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets_t_o_staff`
--

CREATE TABLE `password_resets_t_o_staff` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `display_order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('Inactive','Active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_order`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Admin', 1, 'Active', '2022-01-20 17:07:00', 1, '2022-09-03 12:09:32', 1, '0000-00-00 00:00:00', 0),
(2, 'Writer', 2, 'Active', '2022-04-10 22:23:26', 1, '2022-09-03 12:10:04', 1, '0000-00-00 00:00:00', 0),
(3, 'Reader', 3, 'Active', '2022-09-03 12:10:32', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(6, 'ffs', 6, 'Inactive', '2022-09-04 03:43:35', 1, '2022-09-04 03:44:07', 1, '2022-09-04 03:44:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `updated_by_user_type`, `deleted_at`, `deleted_by`, `deleted_by_user_type`) VALUES
(1, 'dsdsd', 'asasas friends.', '2022-01-20 16:47:28', 1, '2022-05-11 00:12:04', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(2, 'Creative', 'Holiday', '2022-03-31 02:21:57', 1, '2022-04-05 04:45:07', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(3, 'John Rambo dd', 'Live life like John J. Rambo. Helicopter rides Camp-outs with only a knife and a bandana  and river swimming. ddd', '2022-03-31 02:21:57', 1, '2022-04-05 04:45:07', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(4, 'zxzxqqddkknn n', '', '2022-09-04 02:42:25', 1, '2022-09-04 03:00:14', 1, 'Admin', '2022-09-04 03:00:41', 1, 'Admin'),
(5, 'ikjycg', '', '2022-09-04 03:18:47', 1, '2022-09-04 03:19:31', 1, 'Admin', '2022-09-04 03:19:54', 1, 'Admin'),
(6, 'zZcxcxcx cx dd', '', '2022-09-04 03:41:22', 1, '2022-09-04 03:41:46', 1, 'Admin', '2022-09-04 03:42:06', 1, 'Admin'),
(7, 'zxzxsss  ss', 'zxzxzsss ss', '2022-09-04 10:59:35', 1, '2022-09-04 10:59:57', 1, 'Admin', '2022-09-04 11:07:28', 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purpose` enum('Listening Broadcast') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Listening Broadcast',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `csrf_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `purpose`, `user_id`, `user_type`, `csrf_token`, `created_at`, `updated_at`) VALUES
(1, 'Listening Broadcast', 15, 'Tour Operator', 'aS1T3BnINpbZL4ZNWrrppsP8p96AoUeSxHnkf9zm', '2022-05-11 04:53:36', '2022-05-11 04:58:40'),
(2, 'Listening Broadcast', 15, 'Tour Operator', '8HUiRmwdVWNiZQ0NjZF0996chHsi9VbmC1hQsfLh', '2022-05-11 05:39:06', '2022-05-11 05:39:06'),
(3, 'Listening Broadcast', 4, '', 'NrNrviNWEjpGV30bIjkhylnU9xbMA5eJHye1CnlE', '2022-05-11 05:39:55', '2022-05-11 05:39:55'),
(4, 'Listening Broadcast', 4, '', 'NrNrviNWEjpGV30bIjkhylnU9xbMA5eJHye1CnlE', '2022-05-11 05:52:29', '2022-05-11 05:52:29'),
(5, 'Listening Broadcast', 4, '', 'NrNrviNWEjpGV30bIjkhylnU9xbMA5eJHye1CnlE', '2022-05-11 05:53:34', '2022-05-11 05:53:34'),
(6, 'Listening Broadcast', 4, '', 'NrNrviNWEjpGV30bIjkhylnU9xbMA5eJHye1CnlE', '2022-05-11 05:57:03', '2022-05-11 05:57:03'),
(7, 'Listening Broadcast', 19, 'Tour Operator', 'NrNrviNWEjpGV30bIjkhylnU9xbMA5eJHye1CnlE', '2022-05-11 05:58:11', '2022-05-11 05:58:11'),
(8, 'Listening Broadcast', 1, 'Admin', '7tLZEAQPq7x1iGa3rcCk3Z0hSi828tWcRtKdIS5e', '2022-05-11 09:35:18', '2022-05-11 09:35:18'),
(9, 'Listening Broadcast', 5, 'Admin', 'bLQD1k8Bkz5Ti8ieSkNy4Md4NEPoln5IVm8TZVQf', '2022-05-11 09:53:32', '2022-05-11 11:01:50'),
(10, 'Listening Broadcast', 1, 'Admin', 'OsBaUHGZNSPkRtFJe8BfTsdUNLJ7ubDExPSh4jNQ', '2022-05-11 09:57:38', '2022-05-11 09:57:38'),
(11, 'Listening Broadcast', 1, 'Admin', 'dDkh38chiGJevzAz3VuaGciwMrYyClDdhKq0YlHQ', '2022-05-11 10:11:45', '2022-05-11 10:11:45'),
(12, 'Listening Broadcast', 1, 'Admin', 'AjLccoMLP1caBapoLIf9bHcUDcsbShX8lnwO6IiZ', '2022-05-11 10:35:31', '2022-05-11 10:35:31'),
(13, 'Listening Broadcast', 1, 'Admin', 'qXYjmTLZT1cOdsoGGg1nwbMClxSGvFfJWQj9U2mf', '2022-05-11 10:53:31', '2022-05-11 10:53:31'),
(14, 'Listening Broadcast', 5, 'Admin', 'gCrQYrM1KXJdkwyZZyFQHKQqLZDc9OaxWVXmPSMX', '2022-05-11 12:51:04', '2022-05-11 12:51:04'),
(15, 'Listening Broadcast', 8, 'Tour Operator', 'S8bAL2QHZZYk7ZAlmp0sXXpVZ8YQQrxeK7EhqnPY', '2022-05-11 13:57:22', '2022-05-11 13:57:22'),
(16, 'Listening Broadcast', 5, 'Admin', '1la7mvrccHCjnRmz0j3Yx2mzlzfPw77GVnHn372s', '2022-05-11 14:42:52', '2022-05-11 14:42:52'),
(17, 'Listening Broadcast', 22, 'Tour Operator', '49XiPZi5jeabR8z8ujJrq6HRmyLejUM4hDr5X3lz', '2022-05-11 14:46:49', '2022-05-11 14:46:49'),
(18, 'Listening Broadcast', 5, 'Admin', '1FddEt5AuZ5wTC2CXOp71zEus7PB0BXf56C8vmX3', '2022-05-11 18:36:28', '2022-05-11 18:36:28'),
(19, 'Listening Broadcast', 1, 'Admin', 'wFBxXYFf4b4PkNd5TJWTJySDjnr6JBRCu7MG0HDB', '2022-05-11 20:43:30', '2022-05-11 22:43:32'),
(20, 'Listening Broadcast', 1, 'Admin', 'BgErlY6KunAPyUY1LXHAFCr5E6Zu1mb1RSTrF62X', '2022-05-11 21:21:09', '2022-05-11 21:21:09'),
(21, 'Listening Broadcast', 19, 'Tour Operator', 'VohC9xsphkzBkbUrgketyekVAb5hjDby7pxqN5qR', '2022-05-11 21:24:16', '2022-05-11 21:24:16'),
(22, 'Listening Broadcast', 24, '', 'yDaVM3YH158YDDTtelO3COz3qg6tYODavcEDcOhO', '2022-05-11 21:31:37', '2022-05-11 21:31:37'),
(23, 'Listening Broadcast', 24, '', 'gAMgKpdyseDOcx8iFe0fRAp8ZwdW5LW3NxoxnGY8', '2022-05-11 21:32:32', '2022-05-11 21:32:32'),
(24, 'Listening Broadcast', 24, '', 'hwc5Lpyf40cjwF7ooEwhxuMS9dp3OwLRjmEyl346', '2022-05-11 21:32:42', '2022-05-11 21:32:42'),
(25, 'Listening Broadcast', 24, '', 'qTaPTXTzsC7PsfAn8MzaNrh3GjQ6Z2NDU5GEAU1r', '2022-05-11 21:33:18', '2022-05-11 21:33:18'),
(26, 'Listening Broadcast', 24, '', 'NvGyH6DPj5o3JcgGQeejziKoMcecQSDs8SnOHIg7', '2022-05-11 21:33:27', '2022-05-11 21:33:27'),
(27, 'Listening Broadcast', 1, 'Admin', 'XMApYSzGmZqAhLhvSvdIsvGVndlrMNYSbgzqyvYi', '2022-05-11 21:51:06', '2022-05-11 21:51:06'),
(28, 'Listening Broadcast', 15, 'Tour Operator', 'Qqxqf7YEWfeu8WmA7fxS7hTq7AueqWX8DF4cGAhc', '2022-05-11 22:13:15', '2022-05-11 22:13:15'),
(29, 'Listening Broadcast', 1, 'Admin', 'FYFYdgJnedFbDEtU4PothlYcNQjXXPYcA7JKkNt9', '2022-05-11 22:45:40', '2022-05-11 22:47:32'),
(30, 'Listening Broadcast', 1, 'Admin', 'yGEbvuZznDOfKedeNVPamiYBKtPcH10wB1hBxOWn', '2022-05-11 23:09:38', '2022-05-11 23:09:38'),
(31, 'Listening Broadcast', 5, 'Admin', 'rbJMgJyRNgWUwnc3BAuRLUOw9W4G7YYwpGBIW4WF', '2022-05-11 23:09:45', '2022-05-11 23:09:45'),
(32, 'Listening Broadcast', 1, 'Admin', 'u5vfrgPsoUpQDkefiTHnFFSIXuSDdOJ8e7DUrFUr', '2022-05-12 00:22:26', '2022-05-12 00:22:26'),
(33, 'Listening Broadcast', 1, 'Admin', 'ACl1pJSLmBo7qQIdwdrFAhfro8heENypUcdd4lDA', '2022-05-12 01:39:51', '2022-05-12 01:39:51'),
(34, 'Listening Broadcast', 1, 'Admin', 'pWfPyxTTmwWZ1hEBnIOovIAcUl2bv3Nb5M0iENRk', '2022-05-12 02:18:03', '2022-05-12 02:18:03'),
(35, 'Listening Broadcast', 1, 'Admin', 'vrtXZiBApqTvPMCdMW5qIPiPpv8WcuJ7W1OYAWw0', '2022-05-12 02:54:05', '2022-05-12 02:54:05'),
(36, 'Listening Broadcast', 1, 'Admin', '3Ur7OrGE7roltDRRogkstjQvITYshpALmWHp3c31', '2022-05-12 02:54:12', '2022-05-12 02:54:12'),
(37, 'Listening Broadcast', 24, '', 'wUDjXA9LZHh1Y1Q1qXdLis43b6uIbZadC2QSN242', '2022-05-12 02:58:41', '2022-05-12 02:58:41'),
(38, 'Listening Broadcast', 1, 'Admin', 'A8oAf2L7IW7MupmTSIGDQ5cU3lOHnWaDnIxY0ux0', '2022-05-12 03:45:24', '2022-05-12 03:45:24'),
(39, 'Listening Broadcast', 1, 'Admin', 'brAISN9pp17iHDR8QDXAgWCW6uBpQEKH3uDXhmD4', '2022-05-18 02:33:01', '2022-05-18 02:33:01'),
(40, 'Listening Broadcast', 1, 'Admin', 'fE2jTaItJ2TFLnxp8JKHreLPtR8VZlgisEGxPd0u', '2022-09-02 16:05:15', '2022-09-02 16:05:15'),
(41, 'Listening Broadcast', 1, 'Admin', 'Zi1DL66mvxTN9T8DR3Zq49IZnMpQHH2hmeUr6slC', '2022-09-02 19:06:47', '2022-09-02 19:06:47'),
(42, 'Listening Broadcast', 1, 'Admin', 'KpF5m3i65ns3RTkPPpgnVjWvX2LAaKEKrpmkNB9F', '2022-09-02 19:40:45', '2022-09-02 19:40:45'),
(43, 'Listening Broadcast', 1, 'Admin', 'VYXDht2DtXXDNwesccrNVc3huwk0InWC3W79BIzu', '2022-09-03 02:42:59', '2022-09-03 02:42:59'),
(44, 'Listening Broadcast', 1, 'Admin', 'raSIFYLPmcDTxYHHKkehDDL49g03vuBnS4YdzvTK', '2022-09-03 03:33:50', '2022-09-03 03:33:50'),
(45, 'Listening Broadcast', 1, 'Admin', 'Hc5j5VhS7qrlBoU72QVupbYbPyCqtOa81CMFnsq2', '2022-09-03 03:36:57', '2022-09-03 03:36:57'),
(46, 'Listening Broadcast', 1, 'Admin', 'SlbTg3aTQR4weOyR4iqudt1v3qrvOXxpnyZelzje', '2022-09-03 03:46:27', '2022-09-03 03:46:27'),
(47, 'Listening Broadcast', 12, 'Admin', 'zQrJkhwgzbbk0d9q6qZm0iic2RD1661Yd4XKIbTU', '2022-09-03 04:37:23', '2022-09-03 04:37:23'),
(48, 'Listening Broadcast', 12, 'Admin', 'uijyVIADB2iqfv385rjHZPPqlJ7PxU8vmgNtMIjr', '2022-09-03 04:38:49', '2022-09-03 04:38:49'),
(49, 'Listening Broadcast', 18, 'Tour Operator', 'VmcqCO0ViMILLDkYxP1x04N3aCVPuQjQl9aOSs7W', '2022-09-03 05:45:16', '2022-09-03 05:45:16'),
(50, 'Listening Broadcast', 26, 'Tour Operator', 'VmcqCO0ViMILLDkYxP1x04N3aCVPuQjQl9aOSs7W', '2022-09-03 06:14:21', '2022-09-03 06:14:21'),
(51, 'Listening Broadcast', 27, 'Tour Operator', 'IwyEVA1gNCV9HwCcHCm9c5wtVN69v8Xo28cH2lyA', '2022-09-03 06:24:43', '2022-09-03 06:24:43'),
(52, 'Listening Broadcast', 1, 'Admin', 'XHdUdFVx5yW6EwAbyqTnp7QsjAwQPwnrDfpZ4pX9', '2022-09-03 07:15:29', '2022-09-03 07:15:29'),
(53, 'Listening Broadcast', 1, 'Admin', 'UCBet6B8FA3TYveO6sp5zPUcKjRkQsi0SuM4U8Nw', '2022-09-03 16:09:19', '2022-09-03 16:09:19'),
(54, 'Listening Broadcast', 26, 'Tour Operator', 'Yymr273pghSxLwIMk9UHpRLMl0aB408Wtfn48Y4C', '2022-09-03 16:33:12', '2022-09-03 16:33:12'),
(55, 'Listening Broadcast', 27, 'Tour Operator', '8SYTNRuDOEobQc1hHBejSIONFwbNfS0QtLHs71ax', '2022-09-03 16:34:11', '2022-09-03 16:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `tour_operator_staff`
--

CREATE TABLE `tour_operator_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` enum('Inactive','Active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_operator_staff`
--

INSERT INTO `tour_operator_staff` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `status`, `remember_token`, `created_at`, `created_by`, `created_by_user_type`, `updated_at`, `updated_by`, `updated_by_user_type`, `deleted_at`, `deleted_by`, `deleted_by_user_type`) VALUES
(26, 'demo', 'demo', 'ss@gmail.com', '$2y$10$1/FeVRqHgYYVAmYPkEusy.Hmc1OW/XntyCRFyFasUR5oTetGmPGRy', '123456789', 'Active', '', '2022-09-03 11:42:52', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(27, 'wew', 'wdww', 'a@bwsw.co', '$2y$10$1/FeVRqHgYYVAmYPkEusy.Hmc1OW/XntyCRFyFasUR5oTetGmPGRy', '123456789', 'Active', '', '2022-09-03 11:43:44', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '2022-09-05 03:14:30', 1, 'Admin'),
(28, 'sdayu', 'wqyu', 'wqwyu@gmail.com', '$2y$10$lQIYzW0DXslwMUjrQHDxwOuamHG9vifXnzGxtPSiLcZxjv3/gBhym', '1234567689', 'Active', '', '2022-09-05 02:49:56', 1, 'Admin', '2022-09-05 03:01:59', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(29, 'wwew', 'wew', 'ewew@mail.com', '$2y$10$HXxaJWk85G6tfQ2ZhYENn.pWbbGyjYDlybrNtp7scuM0oT41oxmue', '123456789', 'Active', '', '2022-09-05 03:48:48', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator');

-- --------------------------------------------------------

--
-- Table structure for table `tour_operator_staff_roles`
--

CREATE TABLE `tour_operator_staff_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tour_operator_staff_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator',
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_by_user_type` enum('Admin','Tour Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tour Operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_operator_staff_roles`
--

INSERT INTO `tour_operator_staff_roles` (`id`, `role_id`, `tour_operator_staff_id`, `created_at`, `created_by`, `created_by_user_type`, `updated_at`, `updated_by`, `updated_by_user_type`, `deleted_at`, `deleted_by`, `deleted_by_user_type`) VALUES
(51, 1, 26, '2022-09-04 00:12:52', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(52, 2, 27, '2022-09-04 00:13:44', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(53, 3, 28, '2022-09-05 15:19:56', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator'),
(54, 2, 29, '2022-09-05 16:18:48', 1, 'Admin', '0000-00-00 00:00:00', 0, 'Tour Operator', '0000-00-00 00:00:00', 0, 'Tour Operator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets_t_o_staff`
--
ALTER TABLE `password_resets_t_o_staff`
  ADD KEY `password_resets_t_o_staff_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_operator_staff`
--
ALTER TABLE `tour_operator_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `tour_operator_staff_roles`
--
ALTER TABLE `tour_operator_staff_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_operator_staff_roles_role_id` (`role_id`),
  ADD KEY `tour_operator_staff_roles_tour_operator_staff_id` (`tour_operator_staff_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tour_operator_staff`
--
ALTER TABLE `tour_operator_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tour_operator_staff_roles`
--
ALTER TABLE `tour_operator_staff_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
