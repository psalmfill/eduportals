-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2022 at 08:24 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_sessions`
--

CREATE TABLE `academic_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` year(4) NOT NULL,
  `end_year` year(4) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_sessions`
--

INSERT INTO `academic_sessions` (`id`, `name`, `start_year`, `end_year`, `active`, `created_at`, `updated_at`) VALUES
(1, '2020/2021', 2020, 2021, 1, '2021-12-13 07:52:30', '2021-12-13 07:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `present` tinyint(1) NOT NULL DEFAULT 0,
  `holiday` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_results`
--

CREATE TABLE `comment_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_result_grade_id` bigint(20) UNSIGNED NOT NULL,
  `comment_result_group_id` bigint(20) UNSIGNED NOT NULL,
  `comment_result_item_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_result_grades`
--

CREATE TABLE `comment_result_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_result_groups`
--

CREATE TABLE `comment_result_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_result_items`
--

CREATE TABLE `comment_result_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `comment_result_group_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_result_remarks`
--

CREATE TABLE `comment_result_remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headmaster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_term_begins` date DEFAULT NULL,
  `next_term_fee` double DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `name`, `total_mark`, `term_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 'First Term', '100', 1, 1, '2021-12-13 07:56:31', '2021-12-13 07:56:31'),
(2, 'Second Term', '100', 2, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(3, 'Third Term', '100', 3, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date` date NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `exam_type_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark` int(11) NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `name`, `mark`, `exam_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 'CA', 20, 1, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(2, 'Assignment', 10, 1, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(3, 'Exam', 70, 1, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(4, 'CA', 30, 2, 1, '2021-12-13 07:56:32', '2022-04-03 17:29:49'),
(5, 'Assignment', 10, 2, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(6, 'Exam', 60, 2, 1, '2021-12-13 07:56:32', '2022-04-03 17:29:49'),
(7, 'CA', 20, 3, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(8, 'Assignment', 10, 3, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32'),
(9, 'Exam', 70, 3, 1, '2021-12-13 07:56:32', '2021-12-13 07:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'd-m-Y',
  `school_stamp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coat_of_arm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `current_session_id` bigint(20) UNSIGNED DEFAULT NULL,
  `current_term_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `slogan`, `favicon`, `date_format`, `school_stamp`, `coat_of_arm`, `tagline`, `currency_symbol`, `current_session_id`, `current_term_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'd-m-Y', NULL, NULL, NULL, 'N', NULL, NULL, 1, '2021-12-13 07:54:06', '2021-12-13 07:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_score` int(11) NOT NULL,
  `maximum_score` int(11) NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mark_stores`
--

CREATE TABLE `mark_stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) DEFAULT NULL,
  `absent` tinyint(1) NOT NULL DEFAULT 0,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `exam_type_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `not_offered` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mark_stores`
--

INSERT INTO `mark_stores` (`id`, `score`, `absent`, `exam_id`, `exam_type_id`, `subject_id`, `academic_session_id`, `student_id`, `section_id`, `school_class_id`, `created_at`, `updated_at`, `not_offered`) VALUES
(1, 2, 0, 1, 1, 1, 1, 2, 1, 3, '2022-04-04 19:39:45', '2022-04-04 19:39:45', 0),
(2, 3, 0, 1, 2, 1, 1, 2, 1, 3, '2022-04-04 19:39:45', '2022-04-04 19:39:45', 0),
(3, 33, 0, 1, 3, 1, 1, 2, 1, 3, '2022-04-04 19:39:45', '2022-04-04 19:39:45', 0),
(4, 5, 0, 1, 1, 1, 1, 3, 1, 3, '2022-04-04 19:39:45', '2022-04-04 19:39:45', 0),
(5, 5, 0, 1, 2, 1, 1, 3, 1, 3, '2022-04-04 19:39:46', '2022-04-04 19:39:46', 0),
(6, 6, 0, 1, 3, 1, 1, 3, 1, 3, '2022-04-04 19:39:46', '2022-04-04 19:39:46', 0),
(7, 11, 0, 1, 1, 2, 1, 2, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(8, 1, 0, 1, 2, 2, 1, 2, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(9, 45, 0, 1, 3, 2, 1, 2, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(10, 5, 0, 1, 1, 2, 1, 3, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(11, 4, 0, 1, 2, 2, 1, 3, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(12, 45, 0, 1, 3, 2, 1, 3, 1, 3, '2022-04-04 19:40:11', '2022-04-04 19:40:11', 0),
(13, 12, 0, 1, 1, 3, 1, 2, 1, 3, '2022-04-04 19:40:33', '2022-04-04 19:40:33', 0),
(14, 1, 0, 1, 2, 3, 1, 2, 1, 3, '2022-04-04 19:40:34', '2022-04-04 19:40:34', 0),
(15, 65, 0, 1, 3, 3, 1, 2, 1, 3, '2022-04-04 19:40:34', '2022-04-04 19:40:34', 0),
(16, 12, 0, 1, 1, 3, 1, 3, 1, 3, '2022-04-04 19:40:35', '2022-04-04 19:40:35', 0),
(17, 6, 0, 1, 2, 3, 1, 3, 1, 3, '2022-04-04 19:40:35', '2022-04-04 19:40:35', 0),
(18, 65, 0, 1, 3, 3, 1, 3, 1, 3, '2022-04-04 19:40:35', '2022-04-04 19:40:35', 0),
(19, 5, 0, 1, 1, 4, 1, 2, 1, 3, '2022-04-04 19:41:06', '2022-04-04 19:41:06', 0),
(20, 7, 0, 1, 2, 4, 1, 2, 1, 3, '2022-04-04 19:41:07', '2022-04-04 19:41:07', 0),
(21, 60, 0, 1, 3, 4, 1, 2, 1, 3, '2022-04-04 19:41:07', '2022-04-04 19:41:07', 0),
(22, 6, 0, 1, 1, 4, 1, 3, 1, 3, '2022-04-04 19:41:07', '2022-04-04 19:41:07', 0),
(23, 7, 0, 1, 2, 4, 1, 3, 1, 3, '2022-04-04 19:41:07', '2022-04-04 19:41:07', 0),
(24, 60, 0, 1, 3, 4, 1, 3, 1, 3, '2022-04-04 19:41:07', '2022-04-04 19:41:07', 0),
(25, 3, 0, 1, 1, 5, 1, 2, 1, 3, '2022-04-04 19:41:31', '2022-04-04 19:41:31', 0),
(26, 4, 0, 1, 2, 5, 1, 2, 1, 3, '2022-04-04 19:41:32', '2022-04-04 19:41:32', 0),
(27, 44, 0, 1, 3, 5, 1, 2, 1, 3, '2022-04-04 19:41:32', '2022-04-04 19:41:32', 0),
(28, 6, 0, 1, 1, 5, 1, 3, 1, 3, '2022-04-04 19:41:32', '2022-04-04 19:41:32', 0),
(29, 6, 0, 1, 2, 5, 1, 3, 1, 3, '2022-04-04 19:41:33', '2022-04-04 19:41:33', 0),
(30, 33, 0, 1, 3, 5, 1, 3, 1, 3, '2022-04-04 19:41:33', '2022-04-04 19:41:33', 0),
(31, 4, 0, 1, 1, 6, 1, 2, 1, 3, '2022-04-04 19:42:02', '2022-04-04 19:42:02', 0),
(32, 2, 0, 1, 2, 6, 1, 2, 1, 3, '2022-04-04 19:42:03', '2022-04-04 19:42:03', 0),
(33, 34, 0, 1, 3, 6, 1, 2, 1, 3, '2022-04-04 19:42:03', '2022-04-04 19:42:03', 0),
(34, 5, 0, 1, 1, 6, 1, 3, 1, 3, '2022-04-04 19:42:03', '2022-04-04 19:42:03', 0),
(35, 3, 0, 1, 2, 6, 1, 3, 1, 3, '2022-04-04 19:42:03', '2022-04-04 19:42:03', 0),
(36, 65, 0, 1, 3, 6, 1, 3, 1, 3, '2022-04-04 19:42:03', '2022-04-04 19:42:03', 0),
(37, 5, 0, 1, 1, 7, 1, 2, 1, 3, '2022-04-04 19:42:25', '2022-04-04 19:42:25', 0),
(38, 3, 0, 1, 2, 7, 1, 2, 1, 3, '2022-04-04 19:42:25', '2022-04-04 19:42:25', 0),
(39, 34, 0, 1, 3, 7, 1, 2, 1, 3, '2022-04-04 19:42:25', '2022-04-04 19:42:25', 0),
(40, 6, 0, 1, 1, 7, 1, 3, 1, 3, '2022-04-04 19:42:25', '2022-04-04 19:42:25', 0),
(41, 9, 0, 1, 2, 7, 1, 3, 1, 3, '2022-04-04 19:42:25', '2022-04-04 19:42:25', 0),
(42, 55, 0, 1, 3, 7, 1, 3, 1, 3, '2022-04-04 19:42:26', '2022-04-04 19:42:26', 0),
(43, 20, 0, 1, 1, 8, 1, 2, 1, 3, '2022-04-04 19:42:48', '2022-04-04 19:42:48', 0),
(44, 1, 0, 1, 2, 8, 1, 2, 1, 3, '2022-04-04 19:42:48', '2022-04-04 19:42:48', 0),
(45, 70, 0, 1, 3, 8, 1, 2, 1, 3, '2022-04-04 19:42:48', '2022-04-04 19:42:48', 0),
(46, 17, 0, 1, 1, 8, 1, 3, 1, 3, '2022-04-04 19:42:48', '2022-04-04 19:42:48', 0),
(47, 5, 0, 1, 2, 8, 1, 3, 1, 3, '2022-04-04 19:42:48', '2022-04-04 19:42:48', 0),
(48, 54, 0, 1, 3, 8, 1, 3, 1, 3, '2022-04-04 19:42:49', '2022-04-04 19:42:49', 0),
(49, 20, 0, 1, 1, 9, 1, 2, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0),
(50, 6, 0, 1, 2, 9, 1, 2, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0),
(51, 54, 0, 1, 3, 9, 1, 2, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0),
(52, 2, 0, 1, 1, 9, 1, 3, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0),
(53, 5, 0, 1, 2, 9, 1, 3, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0),
(54, 44, 0, 1, 3, 9, 1, 3, 1, 3, '2022-04-04 19:43:50', '2022-04-04 19:43:50', 0);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_25_140624_create_schools_table', 1),
(5, '2020_05_25_140638_create_vendors_table', 1),
(6, '2020_05_25_140659_create_academic_sessions_table', 1),
(7, '2020_05_25_140729_create_terms_table', 1),
(8, '2020_05_25_140800_create_subjects_table', 1),
(9, '2020_05_25_140813_create_roles_table', 1),
(10, '2020_05_25_140823_create_permissions_table', 1),
(11, '2020_05_25_140920_create_results_table', 1),
(12, '2020_05_25_140948_create_grades_table', 1),
(13, '2020_05_25_141024_create_students_table', 1),
(14, '2020_05_25_141037_create_staff_table', 1),
(15, '2020_05_25_150324_create_vendor_categories_table', 1),
(16, '2020_05_25_150336_create_school_categories_table', 1),
(17, '2020_05_25_151207_create_sections_table', 1),
(18, '2020_05_25_151232_create_school_classes_table', 1),
(19, '2020_05_25_215318_create_qualifications_table', 1),
(20, '2020_05_25_220206_create_mark_stores_table', 1),
(21, '2020_05_26_005648_create_school_class_section_table', 1),
(22, '2020_05_26_020035_create_exam_types_table', 1),
(23, '2020_05_26_020351_create_exams_table', 1),
(24, '2020_05_27_132103_create_school_staff_table', 1),
(25, '2020_05_27_141803_create_school_class_staff_table', 1),
(26, '2020_05_27_141852_create_subject_staff_table', 1),
(27, '2020_05_28_122715_create_school_class_section_subject_table', 1),
(28, '2020_05_30_212349_create_psychomotors_table', 1),
(29, '2020_05_30_212506_create_psychomotor_subjects_table', 1),
(30, '2020_05_31_065324_create_psychomotor_grades_table', 1),
(31, '2020_05_31_134254_create_psychomotor_results_table', 1),
(32, '2020_06_02_064246_create_result_remarks_table', 1),
(33, '2020_06_03_130315_create_general_settings_table', 1),
(34, '2020_06_04_173524_create_pins_table', 1),
(35, '2020_06_06_193956_create_comment_result_groups_table', 1),
(36, '2020_06_06_194004_create_comment_result_items_table', 1),
(37, '2020_06_06_194609_create_comment_result_grades_table', 1),
(38, '2020_06_07_140854_create_comment_results_table', 1),
(39, '2020_06_10_203328_create_exam_schedules_table', 1),
(40, '2020_06_11_054256_create_attendances_table', 1),
(41, '2020_06_15_060231_add_foriegn_keys_to_tables', 1),
(42, '2021_03_23_230106_create_comment_result_remarks_table', 1),
(43, '2021_04_17_104858_add_academic_session_id_column_to_students_table', 1),
(44, '2021_07_15_075011_add_not_offered_to_mark_stores_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('login') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'login',
  `ref_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_date` date DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `downloaded` tinyint(1) NOT NULL DEFAULT 0,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pins`
--

INSERT INTO `pins` (`id`, `code`, `type`, `ref_code`, `serial_number`, `activation_date`, `duration`, `expiry_date`, `downloaded`, `student_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, '2565-7280-4980-1552', 'login', 'SAMFIELDACADEMY-1107-Yv0EU', '00000000000000000000', '2022-06-15', 30, '2022-07-15', 0, 2, 1, '2022-06-15 03:50:55', '2022-06-15 03:57:42'),
(2, '3302-8691-1917-3091', 'login', 'SAMFIELDACADEMY-8935-qiCcB', '00000000000000000001', '2022-06-15', 30, '2022-07-15', 0, 1, 1, '2022-06-15 03:51:04', '2022-06-15 03:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `psychomotors`
--

CREATE TABLE `psychomotors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `psychomotor_grades`
--

CREATE TABLE `psychomotor_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `psychomotor_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `psychomotor_results`
--

CREATE TABLE `psychomotor_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `psychomotor_subjects`
--

CREATE TABLE `psychomotor_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `psychomotor_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `type`, `subject`, `school`, `start_date`, `end_date`, `staff_id`, `created_at`, `updated_at`) VALUES
(1, 'university', 'hand', 'school', NULL, NULL, 1, '2021-12-13 11:57:07', '2021-12-13 11:57:07'),
(2, 'secondary', 'wmew ds', 'jdfr hello', NULL, NULL, 1, '2021-12-13 11:57:07', '2021-12-13 11:57:07'),
(3, 'primary', 'nil', 'we xs', NULL, NULL, 1, '2021-12-13 11:57:07', '2021-12-13 11:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result_remarks`
--

CREATE TABLE `result_remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `headmaster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_average` int(11) NOT NULL,
  `min_average` int(11) NOT NULL,
  `next_term_fee` int(11) DEFAULT NULL,
  `next_term_begins` date DEFAULT NULL,
  `decision` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `academic_session_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, 1, '2021-12-13 07:29:48', NULL),
(2, 'Vendor', NULL, 1, '2021-12-13 07:29:48', NULL),
(3, 'School Admin', NULL, 1, '2021-12-13 07:29:48', NULL),
(4, 'Parent', NULL, 1, '2021-12-13 07:29:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `school_category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `code`, `address`, `email`, `phone_number`, `country`, `state`, `city`, `logo`, `active`, `vendor_id`, `school_category_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Samfield Academy', 'samfieldacademy', 'Iron road', 'samfield4sure@gmail.com', '08188631121', 'Nigeria', 'Always Ibom', 'Uyo', NULL, 1, 1, 2, 3, '2021-12-13 07:37:56', '2021-12-13 07:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `school_categories`
--

CREATE TABLE `school_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_categories`
--

INSERT INTO `school_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Primary', '2021-12-13 07:36:48', '2021-12-13 07:36:48'),
(3, 'Secondary', '2021-12-13 07:36:54', '2021-12-13 07:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `name`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Alumni', 1, 1, '2021-12-13 07:37:56', '2021-12-13 07:37:56'),
(2, 'Trash', 1, 1, '2021-12-13 07:37:56', '2021-12-13 07:37:56'),
(3, 'Jss 1', 1, 1, '2021-12-13 07:53:34', '2021-12-13 07:53:34'),
(4, 'JSS 2', 1, 1, '2021-12-13 07:53:59', '2021-12-13 07:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `school_class_section`
--

CREATE TABLE `school_class_section` (
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_class_section`
--

INSERT INTO `school_class_section` (`school_class_id`, `section_id`) VALUES
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `school_class_section_subject`
--

CREATE TABLE `school_class_section_subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_class_section_subject`
--

INSERT INTO `school_class_section_subject` (`id`, `school_id`, `school_class_id`, `section_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 1, NULL, NULL),
(2, 1, 3, 1, 2, NULL, NULL),
(3, 1, 3, 1, 3, NULL, NULL),
(4, 1, 3, 1, 4, NULL, NULL),
(5, 1, 3, 1, 5, NULL, NULL),
(6, 1, 3, 1, 6, NULL, NULL),
(7, 1, 3, 1, 7, NULL, NULL),
(8, 1, 3, 1, 8, NULL, NULL),
(9, 1, 3, 1, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_class_staff`
--

CREATE TABLE `school_class_staff` (
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_staff`
--

CREATE TABLE `school_staff` (
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_staff`
--

INSERT INTO `school_staff` (`staff_id`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, 1, '2021-12-13 07:53:00', '2021-12-13 07:53:00'),
(2, 'B', 1, 1, '2021-12-13 07:53:06', '2021-12-13 07:53:06'),
(3, 'C', 1, 1, '2021-12-13 07:53:13', '2021-12-13 07:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `date_of_birth` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nigeria',
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `other_name`, `username`, `password`, `gender`, `date_of_birth`, `email`, `image`, `address_1`, `address_2`, `phone_number`, `religion`, `country`, `state`, `city`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Staff', 'Bassey', NULL, 'staff', '$2y$10$DKea1BZgZCSBTUe57QGQBeKCQ4hUxa6CIEeAYGjOnu9oHQj3IL2ey', 'male', '2000-04-04', 'staff@gmail.com', NULL, '#31 Emco Lane, Uyo', NULL, '08188631120', NULL, 'Nigeria', 'Akwa Ibom', 'Uyo', 1, '2021-12-13 11:57:07', '2021-12-13 11:57:07'),
(2, 'destiny', 'udo', 'okon', 'coolman', '$2y$10$yzy4.PrNQQK./eP42ylmJO/gLdqoPgCvWMsqfffnedQV3LIh/IxZm', 'male', '2011-11-11', 'fggh', NULL, 'gfdddd', NULL, '6555', NULL, 'Nigeria', 'Akwa Ibom', 'Uyo', 1, '2022-04-04 19:35:27', '2022-04-04 19:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `date_of_birth` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genotype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `academic_session_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `other_name`, `gender`, `date_of_birth`, `email`, `reg_no`, `image`, `religion`, `country`, `state`, `city`, `address_1`, `address_2`, `blood_group`, `genotype`, `school_class_id`, `section_id`, `school_id`, `parent_id`, `active`, `created_at`, `updated_at`, `academic_session_id`) VALUES
(1, 'Samfield', 'Bassey', 'Hawb', 'male', '2021-05-10', NULL, 'DSS/2022/0001', NULL, NULL, 'Nigeria', 'Akwa Ibom', 'Uyo', '#31 Emco Lane, Uyo', NULL, 'A+', 'AA', 3, 1, 1, 4, 1, '2022-04-04 19:31:07', '2022-06-15 03:47:01', NULL),
(2, 'mfon', 'weni', 'otu', 'female', '2021-05-10', NULL, 'DSS/2022/0002', NULL, NULL, 'Nigeria', 'Akwa Ibom', 'Uyo', '#31 Emco Lane, Uyo', NULL, 'A+', 'AA', 3, 1, 1, 2, 1, '2022-04-04 19:31:52', '2022-04-04 19:31:52', NULL),
(3, 'honesty', 'hosa', 'edu', 'male', '2021-05-10', NULL, 'DSS/2022/0003', NULL, NULL, 'Nigeria', 'Akwa Ibom', 'Uyo', '#31 Emco Lane, Uyo', NULL, 'A+', 'AA', 3, 1, 1, 2, 1, '2022-04-04 19:33:16', '2022-04-04 19:33:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'maths', 'qqw', 1, 1, '2022-04-04 19:36:23', '2022-04-04 19:36:23'),
(2, 'english', 'gg', 1, 1, '2022-04-04 19:36:33', '2022-04-04 19:36:33'),
(3, 'biology', 'reerf', 1, 1, '2022-04-04 19:36:45', '2022-04-04 19:36:45'),
(4, 'physic', 'yghh', 1, 1, '2022-04-04 19:36:54', '2022-04-04 19:36:54'),
(5, 'chemistrry', 'rfd', 1, 1, '2022-04-04 19:37:05', '2022-04-04 19:37:05'),
(6, 'economics', 'qwe', 1, 1, '2022-04-04 19:37:17', '2022-04-04 19:37:17'),
(7, 'civic education', 'fddd', 1, 1, '2022-04-04 19:37:30', '2022-04-04 19:37:30'),
(8, 'roldman', 'dfgvv', 1, 1, '2022-04-04 19:37:43', '2022-04-04 19:37:43'),
(9, 'french', '34', 1, 1, '2022-04-04 19:37:53', '2022-04-04 19:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `subject_staff`
--

CREATE TABLE `subject_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `school_class_id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `school_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'First Term', 1, 1, '2021-12-13 07:54:52', '2021-12-13 07:54:52'),
(2, 'Second Term', 1, 1, '2021-12-13 07:54:59', '2021-12-13 07:54:59'),
(3, 'Third Term', 1, 1, '2021-12-13 07:55:06', '2021-12-13 07:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `other_name`, `address`, `phone_number`, `email`, `email_verified_at`, `password`, `role_id`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Super', NULL, 'nil', 'nil', 'admin@dss.com', NULL, '$2y$10$m9JQ63tOufd5DJJuiLNPOOv1fW7x8AHx5JCXiIsss.JWvAWR06TFG', 1, 1, NULL, '2021-12-13 07:29:44', '2021-12-13 07:29:44'),
(2, 'Samfield', 'Bassey', 'Hawb', '#31 Emco Lane, Uyo', '08188631121', 'samfield4sure@gmail.com', NULL, '$2y$10$m9JQ63tOufd5DJJuiLNPOOv1fW7x8AHx5JCXiIsss.JWvAWR06TFG', 2, 1, NULL, '2021-12-13 07:36:02', '2021-12-13 07:36:02'),
(3, 'Samfield', 'Bassey', 'Hawb', '#31 Emco Lane, Uyo', '08188631121', 'samfieldacademy@gmail.com', NULL, '$2y$10$m9JQ63tOufd5DJJuiLNPOOv1fW7x8AHx5JCXiIsss.JWvAWR06TFG', 3, 1, NULL, '2021-12-13 07:37:56', '2021-12-13 12:47:00'),
(4, 'ffffff', 'dddd', 'hhh', 'tttt', '08888', 'ffghhh', NULL, '$2y$10$FiInkyLZt./wRw5mSXiNq.e9BgMaY3DtL.WxMDnqBGMMZnuS4GWLm', 4, 1, NULL, '2022-04-04 19:31:07', '2022-04-04 19:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nigeria',
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `code`, `email`, `phone_number`, `address`, `country`, `state`, `city`, `vendor_category_id`, `user_id`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Samfield Group', 'samfieldgroup', 'samfield4sure@gmail.com', '08188631121', '#31 Emco Lane, Uyo', 'Nigeria', 'Akwa Ibom', 'Uyo', 1, 2, 1, '2021-12-13 07:36:02', '2021-12-13 07:36:02');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_categories`
--

CREATE TABLE `vendor_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_categories`
--

INSERT INTO `vendor_categories` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Private', 1, '2021-12-13 07:35:02', '2021-12-13 07:35:02'),
(3, 'Government', 1, '2021-12-13 07:35:20', '2021-12-13 07:35:20'),
(4, 'Missionary', 1, '2021-12-13 07:35:27', '2021-12-13 07:35:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_sessions`
--
ALTER TABLE `academic_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_school_class_id_foreign` (`school_class_id`),
  ADD KEY `attendances_section_id_foreign` (`section_id`),
  ADD KEY `attendances_term_id_foreign` (`term_id`),
  ADD KEY `attendances_school_id_foreign` (`school_id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `comment_results`
--
ALTER TABLE `comment_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_results_comment_result_grade_id_foreign` (`comment_result_grade_id`),
  ADD KEY `comment_results_comment_result_group_id_foreign` (`comment_result_group_id`),
  ADD KEY `comment_results_comment_result_item_id_foreign` (`comment_result_item_id`),
  ADD KEY `comment_results_school_class_id_foreign` (`school_class_id`),
  ADD KEY `comment_results_section_id_foreign` (`section_id`),
  ADD KEY `comment_results_exam_id_foreign` (`exam_id`),
  ADD KEY `comment_results_school_id_foreign` (`school_id`),
  ADD KEY `comment_results_student_id_foreign` (`student_id`),
  ADD KEY `comment_results_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `comment_result_grades`
--
ALTER TABLE `comment_result_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_result_grades_school_id_foreign` (`school_id`);

--
-- Indexes for table `comment_result_groups`
--
ALTER TABLE `comment_result_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_result_groups_school_id_foreign` (`school_id`);

--
-- Indexes for table `comment_result_items`
--
ALTER TABLE `comment_result_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_result_items_comment_result_group_id_foreign` (`comment_result_group_id`),
  ADD KEY `comment_result_items_school_id_foreign` (`school_id`);

--
-- Indexes for table `comment_result_remarks`
--
ALTER TABLE `comment_result_remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_result_remarks_school_class_id_foreign` (`school_class_id`),
  ADD KEY `comment_result_remarks_section_id_foreign` (`section_id`),
  ADD KEY `comment_result_remarks_exam_id_foreign` (`exam_id`),
  ADD KEY `comment_result_remarks_school_id_foreign` (`school_id`),
  ADD KEY `comment_result_remarks_student_id_foreign` (`student_id`),
  ADD KEY `comment_result_remarks_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_school_id_foreign` (`school_id`),
  ADD KEY `exams_term_id_foreign` (`term_id`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_schedules_school_class_id_foreign` (`school_class_id`),
  ADD KEY `exam_schedules_section_id_foreign` (`section_id`),
  ADD KEY `exam_schedules_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_schedules_exam_type_id_foreign` (`exam_type_id`),
  ADD KEY `exam_schedules_school_id_foreign` (`school_id`),
  ADD KEY `exam_schedules_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_types_school_id_foreign` (`school_id`),
  ADD KEY `exam_types_exam_id_foreign` (`exam_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `general_settings_school_id_foreign` (`school_id`),
  ADD KEY `general_settings_current_term_id_foreign` (`current_term_id`),
  ADD KEY `general_settings_current_session_id_foreign` (`current_session_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_school_id_foreign` (`school_id`);

--
-- Indexes for table `mark_stores`
--
ALTER TABLE `mark_stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mark_stores_school_class_id_foreign` (`school_class_id`),
  ADD KEY `mark_stores_section_id_foreign` (`section_id`),
  ADD KEY `mark_stores_exam_id_foreign` (`exam_id`),
  ADD KEY `mark_stores_exam_type_id_foreign` (`exam_type_id`),
  ADD KEY `mark_stores_subject_id_foreign` (`subject_id`),
  ADD KEY `mark_stores_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pins_code_unique` (`code`),
  ADD UNIQUE KEY `pins_ref_code_unique` (`ref_code`),
  ADD UNIQUE KEY `pins_serial_number_unique` (`serial_number`);

--
-- Indexes for table `psychomotors`
--
ALTER TABLE `psychomotors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychomotors_school_id_foreign` (`school_id`);

--
-- Indexes for table `psychomotor_grades`
--
ALTER TABLE `psychomotor_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychomotor_grades_school_id_foreign` (`school_id`),
  ADD KEY `psychomotor_grades_psychomotor_id_foreign` (`psychomotor_id`);

--
-- Indexes for table `psychomotor_results`
--
ALTER TABLE `psychomotor_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychomotor_results_school_class_id_foreign` (`school_class_id`),
  ADD KEY `psychomotor_results_section_id_foreign` (`section_id`),
  ADD KEY `psychomotor_results_exam_id_foreign` (`exam_id`),
  ADD KEY `psychomotor_results_school_id_foreign` (`school_id`),
  ADD KEY `psychomotor_results_student_id_foreign` (`student_id`),
  ADD KEY `psychomotor_results_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `psychomotor_subjects`
--
ALTER TABLE `psychomotor_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychomotor_subjects_school_id_foreign` (`school_id`),
  ADD KEY `psychomotor_subjects_psychomotor_id_foreign` (`psychomotor_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result_remarks`
--
ALTER TABLE `result_remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_remarks_school_class_id_foreign` (`school_class_id`),
  ADD KEY `result_remarks_exam_id_foreign` (`exam_id`),
  ADD KEY `result_remarks_school_id_foreign` (`school_id`),
  ADD KEY `result_remarks_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_school_id_foreign` (`school_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_name_unique` (`name`),
  ADD KEY `schools_vendor_id_foreign` (`vendor_id`),
  ADD KEY `schools_school_category_id_foreign` (`school_category_id`),
  ADD KEY `schools_user_id_foreign` (`user_id`);

--
-- Indexes for table `school_categories`
--
ALTER TABLE `school_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_classes_school_id_foreign` (`school_id`);

--
-- Indexes for table `school_class_section`
--
ALTER TABLE `school_class_section`
  ADD KEY `school_class_section_school_class_id_foreign` (`school_class_id`),
  ADD KEY `school_class_section_section_id_foreign` (`section_id`);

--
-- Indexes for table `school_class_section_subject`
--
ALTER TABLE `school_class_section_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_class_section_subject_subject_id_foreign` (`subject_id`),
  ADD KEY `school_class_section_subject_school_id_foreign` (`school_id`),
  ADD KEY `school_class_section_subject_section_id_foreign` (`section_id`),
  ADD KEY `school_class_section_subject_school_class_id_foreign` (`school_class_id`);

--
-- Indexes for table `school_class_staff`
--
ALTER TABLE `school_class_staff`
  ADD KEY `school_class_staff_school_id_foreign` (`school_id`),
  ADD KEY `school_class_staff_staff_id_foreign` (`staff_id`),
  ADD KEY `school_class_staff_section_id_foreign` (`section_id`),
  ADD KEY `school_class_staff_school_class_id_foreign` (`school_class_id`);

--
-- Indexes for table `school_staff`
--
ALTER TABLE `school_staff`
  ADD KEY `school_staff_school_id_foreign` (`school_id`),
  ADD KEY `school_staff_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_school_id_foreign` (`school_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_username_unique` (`username`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_school_class_id_foreign` (`school_class_id`),
  ADD KEY `students_section_id_foreign` (`section_id`),
  ADD KEY `students_school_id_foreign` (`school_id`),
  ADD KEY `students_parent_id_foreign` (`parent_id`),
  ADD KEY `students_academic_session_id_foreign` (`academic_session_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_school_id_foreign` (`school_id`);

--
-- Indexes for table `subject_staff`
--
ALTER TABLE `subject_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_staff_subject_id_foreign` (`subject_id`),
  ADD KEY `subject_staff_school_id_foreign` (`school_id`),
  ADD KEY `subject_staff_staff_id_foreign` (`staff_id`),
  ADD KEY `subject_staff_section_id_foreign` (`section_id`),
  ADD KEY `subject_staff_school_class_id_foreign` (`school_class_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terms_school_id_foreign` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_name_unique` (`name`),
  ADD UNIQUE KEY `vendors_code_unique` (`code`),
  ADD KEY `vendors_vendor_category_id_foreign` (`vendor_category_id`),
  ADD KEY `vendors_user_id_foreign` (`user_id`);

--
-- Indexes for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_sessions`
--
ALTER TABLE `academic_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_results`
--
ALTER TABLE `comment_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_result_grades`
--
ALTER TABLE `comment_result_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_result_groups`
--
ALTER TABLE `comment_result_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_result_items`
--
ALTER TABLE `comment_result_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_result_remarks`
--
ALTER TABLE `comment_result_remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mark_stores`
--
ALTER TABLE `mark_stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `psychomotors`
--
ALTER TABLE `psychomotors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `psychomotor_grades`
--
ALTER TABLE `psychomotor_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `psychomotor_results`
--
ALTER TABLE `psychomotor_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `psychomotor_subjects`
--
ALTER TABLE `psychomotor_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result_remarks`
--
ALTER TABLE `result_remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_categories`
--
ALTER TABLE `school_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `school_class_section_subject`
--
ALTER TABLE `school_class_section_subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject_staff`
--
ALTER TABLE `subject_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `attendances_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `attendances_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `attendances_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`);

--
-- Constraints for table `comment_results`
--
ALTER TABLE `comment_results`
  ADD CONSTRAINT `comment_results_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `comment_results_comment_result_grade_id_foreign` FOREIGN KEY (`comment_result_grade_id`) REFERENCES `comment_result_grades` (`id`),
  ADD CONSTRAINT `comment_results_comment_result_group_id_foreign` FOREIGN KEY (`comment_result_group_id`) REFERENCES `comment_result_groups` (`id`),
  ADD CONSTRAINT `comment_results_comment_result_item_id_foreign` FOREIGN KEY (`comment_result_item_id`) REFERENCES `comment_result_items` (`id`),
  ADD CONSTRAINT `comment_results_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `comment_results_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `comment_results_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `comment_results_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `comment_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `comment_result_grades`
--
ALTER TABLE `comment_result_grades`
  ADD CONSTRAINT `comment_result_grades_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `comment_result_groups`
--
ALTER TABLE `comment_result_groups`
  ADD CONSTRAINT `comment_result_groups_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `comment_result_items`
--
ALTER TABLE `comment_result_items`
  ADD CONSTRAINT `comment_result_items_comment_result_group_id_foreign` FOREIGN KEY (`comment_result_group_id`) REFERENCES `comment_result_groups` (`id`),
  ADD CONSTRAINT `comment_result_items_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `comment_result_remarks`
--
ALTER TABLE `comment_result_remarks`
  ADD CONSTRAINT `comment_result_remarks_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `comment_result_remarks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `comment_result_remarks_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `comment_result_remarks_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `comment_result_remarks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `comment_result_remarks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`);

--
-- Constraints for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD CONSTRAINT `exam_schedules_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `exam_schedules_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_schedules_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`),
  ADD CONSTRAINT `exam_schedules_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `exam_schedules_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `exam_schedules_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Constraints for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD CONSTRAINT `exam_types_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_types_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD CONSTRAINT `general_settings_current_session_id_foreign` FOREIGN KEY (`current_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `general_settings_current_term_id_foreign` FOREIGN KEY (`current_term_id`) REFERENCES `terms` (`id`),
  ADD CONSTRAINT `general_settings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `mark_stores`
--
ALTER TABLE `mark_stores`
  ADD CONSTRAINT `mark_stores_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `mark_stores_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `mark_stores_exam_type_id_foreign` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`id`),
  ADD CONSTRAINT `mark_stores_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `mark_stores_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `mark_stores_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `psychomotors`
--
ALTER TABLE `psychomotors`
  ADD CONSTRAINT `psychomotors_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `psychomotor_grades`
--
ALTER TABLE `psychomotor_grades`
  ADD CONSTRAINT `psychomotor_grades_psychomotor_id_foreign` FOREIGN KEY (`psychomotor_id`) REFERENCES `psychomotors` (`id`),
  ADD CONSTRAINT `psychomotor_grades_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `psychomotor_results`
--
ALTER TABLE `psychomotor_results`
  ADD CONSTRAINT `psychomotor_results_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `psychomotor_results_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `psychomotor_results_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `psychomotor_results_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `psychomotor_results_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `psychomotor_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `psychomotor_subjects`
--
ALTER TABLE `psychomotor_subjects`
  ADD CONSTRAINT `psychomotor_subjects_psychomotor_id_foreign` FOREIGN KEY (`psychomotor_id`) REFERENCES `psychomotors` (`id`),
  ADD CONSTRAINT `psychomotor_subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `result_remarks`
--
ALTER TABLE `result_remarks`
  ADD CONSTRAINT `result_remarks_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `academic_sessions` (`id`),
  ADD CONSTRAINT `result_remarks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `result_remarks_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `result_remarks_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_school_category_id_foreign` FOREIGN KEY (`school_category_id`) REFERENCES `school_categories` (`id`),
  ADD CONSTRAINT `schools_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `schools_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD CONSTRAINT `school_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `school_class_section`
--
ALTER TABLE `school_class_section`
  ADD CONSTRAINT `school_class_section_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `school_class_section_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Constraints for table `school_class_section_subject`
--
ALTER TABLE `school_class_section_subject`
  ADD CONSTRAINT `school_class_section_subject_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `school_class_section_subject_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `school_class_section_subject_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `school_class_section_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `school_class_staff`
--
ALTER TABLE `school_class_staff`
  ADD CONSTRAINT `school_class_staff_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `school_class_staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `school_class_staff_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `school_class_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `school_staff`
--
ALTER TABLE `school_staff`
  ADD CONSTRAINT `school_staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `school_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_academic_session_id_foreign` FOREIGN KEY (`academic_session_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `students_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `subject_staff`
--
ALTER TABLE `subject_staff`
  ADD CONSTRAINT `subject_staff_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`),
  ADD CONSTRAINT `subject_staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `subject_staff_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `subject_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `subject_staff_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vendors_vendor_category_id_foreign` FOREIGN KEY (`vendor_category_id`) REFERENCES `vendor_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
