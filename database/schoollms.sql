-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 07:43 AM
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
-- Database: `schoollms`
--

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `description`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 'Nursery', 'This is Nursery class', '2023-09-04 05:21:10', '2023-09-04 05:24:43', 1),
(2, 'First standard', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', '2023-09-04 05:21:11', '2023-09-26 06:40:24', 1),
(3, 'Second standard', 'This is Third standard', '2023-09-04 05:21:11', '2023-09-26 06:41:51', 1),
(4, 'Third standard', 'this is Fourth standard', '2023-09-04 05:21:11', '2023-09-26 06:43:15', 1),
(5, 'Fourth standard', 'this is 5 class', '2023-09-04 05:21:11', '2023-09-26 07:07:47', 1),
(6, ' Five standard', 'this class  fifth classroom', '2023-10-04 05:38:02', '2023-10-04 05:38:02', 1),
(7, 'six standard', 'dsdsdf', '2023-10-09 04:44:10', '2023-10-09 04:44:10', 1),
(8, '7 th', 'this is seven classroom', '2023-10-09 04:45:34', '2023-10-09 04:45:34', 1),
(9, '8 th', 'this is Eight classroom', '2023-10-09 04:46:22', '2023-10-09 04:46:22', 1),
(10, '9th', 'this is Ninth classroom', '2023-10-09 04:46:53', '2023-10-09 04:46:53', 35),
(11, '10 th', 'this is tenth classroom', '2023-10-09 04:47:38', '2023-10-09 04:47:38', 35),
(12, '11 th', 'this is seven classroom', '2023-10-09 04:49:05', '2023-10-09 04:49:05', 35),
(13, 'Eleven', 'this is Ninth standard', '2023-10-09 04:54:31', '2023-10-09 04:54:31', 35),
(14, 'Twelve', 'this is  Eleven classroom', '2023-10-09 05:41:16', '2023-10-09 05:41:16', 35),
(19, '13 th', 'sdfdgfg', '2023-10-11 04:43:08', '2023-10-11 04:43:08', 35),
(20, 'Class 4 DEMO', 'SST', '2023-10-12 05:54:55', '2023-10-12 05:57:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `classroom_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` text NOT NULL,
  `courses_type` text DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_title`, `subject_code`, `description`, `teacher_id`, `classroom_id`, `created_at`, `updated_at`, `url`, `courses_type`, `school_id`) VALUES
(1, 'Title1', 'SC-000001', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 5, '2023-09-27 00:43:09', '2023-10-07 07:48:14', 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 'PDF', 1),
(2, 'Title2', 'SC-000008', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 2, '2023-09-27 00:55:31', '2023-10-07 07:40:43', 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 'PDF', 1),
(4, 'Title4', 'SC-000007', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', NULL, 3, '2023-09-27 01:01:12', '2023-09-27 01:01:12', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'Video', 1),
(5, 'title5', 'SC-000009', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', NULL, 2, '2023-09-27 01:02:57', '2023-09-27 01:02:57', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'Video', 1),
(8, 'Title 8', 'SC-000012', 'wtrytyutyy', NULL, 5, '2023-09-28 23:09:59', '2023-09-28 23:09:59', 'google.com', 'PDF', 1),
(10, 'title 18', 'SC-000016', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', NULL, 3, '2023-10-04 23:34:15', '2023-10-04 23:34:15', 'google.com', 'PDF', 1),
(11, 'course 1', 'SC-000011', 'this requeted course by teacher', NULL, 3, '2023-10-05 02:50:46', '2023-10-05 02:50:46', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(13, 'Coures 3', 'SC-000010', 'this is requested courses', NULL, 4, '2023-10-05 03:02:25', '2023-10-05 03:02:25', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(15, 'Coures 4', 'SC-000011', 'sdfdsghgh', NULL, 3, '2023-10-05 03:07:16', '2023-10-05 03:07:16', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(16, 'Coures 5', 'SC-000011', 'sdgfsdgfg', NULL, 3, '2023-10-05 03:08:49', '2023-10-05 03:08:49', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(18, 'Coures 23', 'SC-000018', 'wesdfd', NULL, 4, '2023-10-05 03:13:28', '2023-10-05 03:13:28', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'PDF', 35),
(21, 'Title 19', 'SC-000008', 'Subject Chem', NULL, 2, '2023-10-06 04:40:52', '2023-10-06 04:40:52', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'Video', 1),
(22, 'Title 20', 'SC-000021', 'Subject Geo', NULL, 4, '2023-10-06 04:40:52', '2023-10-06 04:40:52', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'pdf', 35),
(25, 'admin course 1', 'SC-000027', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 13, '2023-10-09 23:49:22', '2023-10-09 23:49:22', 'google.com', 'PDF', 1),
(26, 'admin course2', 'SC-000025', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 14, '2023-10-09 23:50:36', '2023-10-09 23:50:36', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(27, 'admin course2', 'SC-000025', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 14, '2023-10-09 23:53:09', '2023-10-09 23:53:09', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 1),
(28, 'courses admin 3', 'SC-000027', 'abcd', NULL, 13, '2023-10-09 23:56:50', '2023-10-09 23:56:50', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'PDF', 35),
(29, 'course409', 'SC-000025', 'qsdfsfd', NULL, 14, '2023-10-10 00:02:33', '2023-10-10 00:02:33', 'google.com', 'PDF', 1),
(30, 'course 789', 'SC-000025', 'abcds', NULL, 14, '2023-10-10 00:03:55', '2023-10-10 00:03:55', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 35),
(32, 'co 11', 'SC-000025', 'w3eder', NULL, 14, NULL, NULL, 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'PDF', 35),
(34, 'course999', 'SC-000031', 'xccvdfgfg', NULL, 13, NULL, NULL, 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'PDF', 35),
(35, 'course777', 'SC-000031', 'zsdfsdfdf', NULL, 13, NULL, NULL, 'google.com', 'PDF', 35),
(36, 'course 123', 'SC-000031', 'errtryt', NULL, 13, NULL, NULL, 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 'Video', 35),
(37, 'course233', 'SC-000019', 'asdasd', NULL, 2, NULL, NULL, 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 'PDF', 1),
(38, 'test courses1', 'SC-000033', 'ddfgghh', NULL, 19, NULL, NULL, 'google.com', 'PDF', 35),
(39, 'course', 'SC-000004', 'sdsdsdsd', NULL, 5, NULL, NULL, 'google.com', 'PDF', 1),
(40, 'course 80', 'SC-000008', 'fdgfrfffh', NULL, 2, '2023-10-11 05:29:04', '2023-10-11 05:29:04', 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 'PDF', 1),
(42, 'Title 200', 'SC-000001', 'Subject Chem', NULL, 5, '2023-10-11 06:25:20', '2023-10-11 06:25:20', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'Video', 1),
(43, 'Title 201', 'SC-000002', 'Subject Geo', NULL, 1, '2023-10-11 06:25:20', '2023-10-11 06:25:20', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'PDF', 1),
(44, 'Title 400', 'SC-000001', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', NULL, 5, '2023-10-11 06:31:19', '2023-10-12 01:05:45', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'Video', 1),
(45, 'Title 201', 'SC-000002', 'Subject Geo22', NULL, 1, '2023-10-11 06:31:19', '2023-10-11 06:31:19', 'https://www.youtube.com/embed/EhLCcMoaUE0', 'PDF', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_05_13_182949_create_class_rooms_table', 1),
(6, '2022_05_13_193552_create_teachers_table', 1),
(7, '2022_05_13_201132_create_students_table', 1),
(8, '2022_05_14_180740_create_subjects_table', 1),
(9, '2023_09_26_055553_create_courses_table', 2),
(10, '2023_10_05_073238_create_requests_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `courses_type` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `classroom_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `course_title`, `subject_code`, `description`, `status`, `courses_type`, `url`, `teacher_id`, `classroom_id`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 'course 1', 'SC-000014', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quae nisi architecto quos nam veritatis provident debitis iure aspernatur, voluptates quas atque vero dolorem inventore, at ipsa amet, quasi voluptate.', 'Approved', 'PDF', 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 16, 2, '2023-10-05 03:25:35', '2023-10-11 04:40:00', 1),
(7, 'Requested course 1', 'SC-000016', 'dfgdgf', 'Pending', 'Video', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 16, 3, '2023-10-11 02:08:57', '2023-10-11 02:08:57', 1),
(8, 'requested 2', 'SC-000012', 'ghfsdfsadf', 'Pending', 'Video', 'https://www.youtube.com/embed/PfiVnI3dNTk?list=PLr5IOV1YXoFX59bqMfij8I2jJa85_iVKW', 16, 5, '2023-10-11 02:35:30', '2023-10-12 04:36:25', 1),
(9, 'Course 22', 'SC-000013', 'this is teacher 2 courses', 'Approved', 'PDF', 'https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf', 28, 1, '2023-10-11 04:38:34', '2023-10-11 06:34:32', 1),
(10, 'Test Requested  course', 'SC-000033', 'cvbgfh', 'Pending', 'PDF', 'google.com', 29, 19, '2023-10-11 05:16:10', '2023-10-11 05:16:10', 35);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `student_num` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `parent_phone_number` varchar(255) NOT NULL,
  `second_phone_number` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `classroom_id` int(10) UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `surname`, `student_num`, `birth_date`, `address`, `parent_phone_number`, `second_phone_number`, `gender`, `classroom_id`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(1, 'Diego', 'Smith', 'STDN-000001', '2008-09-04', '8445 Jast Passage Suite 349\nEstevanfurt, MS 12107-2595', '463-438-6632', NULL, 1, 3, '2022-09-04', '2023-09-04 05:21:11', '2023-09-04 05:21:11'),
(2, 'Paolo', 'Kunze', 'STDN-000002', '2008-09-04', '1451 Carley Crest\nWinstonborough, IL 14910-8284', '424-645-3687', NULL, 0, 3, '2022-09-04', '2023-09-04 05:21:11', '2023-09-04 05:21:11'),
(3, 'Emilio', 'Dickinson', 'STDN-000003', '2008-09-04', '282 Chesley Skyway Apt. 271\nWest Geraldineview, PA 66040-1099', '484-416-3913', NULL, 1, 2, '2022-09-04', '2023-09-04 05:21:11', '2023-09-04 05:21:11'),
(4, 'Marlene', 'Lubowitz', 'STDN-000004', '2008-09-04', '783 Thiel Locks\nMarquardtchester, WY 54997-7847', '1-925-836-7163', NULL, 1, 1, '2022-09-04', '2023-09-04 05:21:12', '2023-09-04 05:21:12'),
(5, 'Norma', 'Brakus', 'STDN-000005', '2008-09-04', '32192 Emiliano Walks\nNorth Westonbury, DE 60854-3758', '+19855715229', NULL, 0, 5, '2022-09-04', '2023-09-04 05:21:12', '2023-09-04 05:21:12'),
(6, 'Crystal', 'Schmeler', 'STDN-000006', '2008-09-04', '19580 Wintheiser Cove\nSouth Willard, GA 82229', '+1.858.646.4232', NULL, 1, 1, '2022-09-04', '2023-09-04 05:21:12', '2023-09-04 05:21:12'),
(7, 'Josefa', 'Nader', 'STDN-000007', '2008-09-04', '98920 Hoppe Underpass\nWest Roelberg, MS 50650', '956.218.9041', NULL, 0, 3, '2022-09-04', '2023-09-04 05:21:12', '2023-09-04 05:21:12'),
(8, 'Pedro', 'Blanda', 'STDN-000008', '2008-09-04', '194 Sylvester Cliff\nGerryhaven, VT 75221', '934.464.3274', NULL, 1, 3, '2022-09-04', '2023-09-04 05:21:12', '2023-09-04 05:21:12'),
(9, 'Duncan', 'Rosenbaum', 'STDN-000009', '2008-09-04', '8642 Towne Path\nAxelbury, RI 90556', '(276) 428-9223', NULL, 1, 2, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(10, 'Glenda', 'Jacobson', 'STDN-000010', '2008-09-04', '60704 Schmidt Mission Apt. 088\nCasimertown, MD 88807-4809', '(346) 423-8285', NULL, 0, 3, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(11, 'Carson', 'Frami', 'STDN-000011', '2008-09-04', '327 Monique Stream\nBraunmouth, AK 85924-2873', '1-530-848-8433', NULL, 1, 5, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(12, 'Aileen', 'Effertz', 'STDN-000012', '2008-09-04', '6491 Fisher Lodge Suite 704\nEast Danefort, SC 76189', '507.983.9350', NULL, 0, 4, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(13, 'Elias', 'Murazik', 'STDN-000013', '2008-09-04', '6440 Fahey Walks Suite 681\nWest Jamisonmouth, CO 22799', '(909) 498-7096', NULL, 1, 4, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(14, 'Everardo', 'Senger', 'STDN-000014', '2008-09-04', '899 Farrell Tunnel Suite 107\nPort Conniebury, NJ 35354', '+19785911797', NULL, 0, 5, '2022-09-04', '2023-09-04 05:21:13', '2023-09-04 05:21:13'),
(15, 'Holden', 'Mertz', 'STDN-000015', '2008-09-04', '70431 Baumbach Flat\nBereniceborough, NJ 74290', '1-786-851-1530', NULL, 1, 4, '2022-09-04', '2023-09-04 05:21:14', '2023-09-04 05:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `semester` int(1) DEFAULT NULL,
  `teacher_id` int(10) UNSIGNED DEFAULT NULL,
  `classroom_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subject_code`, `description`, `semester`, `teacher_id`, `classroom_id`, `created_at`, `updated_at`, `school_id`) VALUES
(1, 'Mathmatics', 'SC-000001', 'Optio ut animi dignissimos quia.', 1, 1, 5, '2023-09-04 05:21:11', '2023-09-26 07:09:43', 1),
(2, 'Hindi', 'SC-000002', 'hindi is a good subject', 0, 1, 1, '2023-09-04 05:21:11', '2023-09-26 06:58:57', 1),
(3, 'EVS', 'SC-000003', 'Sed ipsam minima quibusdam repellat possimus omnis.', 1, 3, 4, '2023-09-04 05:21:11', '2023-09-26 07:11:35', 1),
(4, 'Computer', 'SC-000004', 'Voluptatem quasi omnis repudiandae.', 0, 3, 5, '2023-09-04 05:21:12', '2023-09-26 07:13:47', 1),
(5, 'Hindi', 'SC-000005', 'Hindi for first standard', 1, 4, 2, '2023-09-04 05:21:12', '2023-09-28 02:26:08', 1),
(6, 'Warehouse', 'SC-000006', 'Qui modi veniam aut cupiditate rerum ut.', 1, 1, 4, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 1),
(7, 'Dentist', 'SC-000007', 'Minus sunt saepe at asperiores consequatur corrupti.', 1, 2, 3, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 1),
(8, 'Food Preparation', 'SC-000008', 'Vel et ut iste ad error corrupti.', 0, 4, 2, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 1),
(10, 'Education Teacher', 'SC-000010', 'Voluptatibus enim unde fugit commodi tempora.', 1, 2, 4, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 1),
(11, 'Dragline Operator', 'SC-000011', 'Ratione veritatis doloribus alias quibusdam harum aut.', 0, 1, 3, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 1),
(12, 'English', 'SC-000012', 'Ut maxime pariatur qui dicta ipsa.', 1, 9, 5, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 1),
(13, 'Engineering Technician', 'SC-000013', 'Rem reprehenderit aperiam et non eos deserunt sapiente.', 1, 4, 1, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 1),
(14, 'Brickmason', 'SC-000014', 'Provident repellendus sed deleniti nobis.', 0, 12, 2, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 1),
(15, 'Prepress Technician', 'SC-000015', 'Vel vitae nam iusto distinctio dolor sit suscipit.', 1, 1, 5, '2023-09-04 05:21:14', '2023-09-04 05:21:14', 1),
(16, 'English', 'SC-000016', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 1, 16, 3, NULL, NULL, 1),
(18, 'geometry', 'SC-000018', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 0, 16, 4, NULL, NULL, 1),
(19, 'trigonometry', 'SC-000019', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 0, 16, 2, NULL, NULL, 1),
(20, 'Gk', 'SC-000020', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 1, 16, 2, NULL, NULL, 1),
(25, 'physics', 'SC-000025', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 0, 24, 14, NULL, NULL, 1),
(27, 'chemistry', 'SC-000027', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', NULL, 24, 13, NULL, NULL, 35),
(30, 'SST', 'SC-000030', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 0, 25, 14, NULL, NULL, 35),
(31, 'SST', 'SC-000031', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 1, 24, 13, NULL, NULL, 35),
(32, 'Computer2', 'SC-000032', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\n', 0, 16, 14, NULL, NULL, 35),
(33, 'political science', 'SC-000033', 'thhjdfgdf', 0, 29, 19, NULL, NULL, 35),
(34, 'Math2', 'SC-000034', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 26, 7, '2023-10-11 05:31:07', '2023-10-12 01:04:24', 1),
(35, 'sst', 'SC-000035', 'THIS SUBJECT IS SST', 0, 27, 20, '2023-10-12 05:58:44', '2023-10-12 05:58:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `teacher_num` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `surname`, `teacher_num`, `birth_date`, `email`, `phone_number`, `photo_path`, `address`, `gender`, `created_at`, `updated_at`, `school_id`, `user_id`) VALUES
(1, 'Janick', 'Harvey', 'TN-000001', '1988-09-04', 'ukihn@gmail.com', '07887099057', 'Teachers/Harvey/teacher.jfif', 'kanpur', 0, '2023-09-04 05:21:11', '2023-10-07 10:27:00', 1, NULL),
(2, 'Derick', 'Keeling', 'TN-000002', '2001-09-04', 'astrid86@hotmail.com', '574-474-1838', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:11', '2023-09-04 05:21:11', 1, NULL),
(3, 'Elizabeth', 'Hansen', 'TN-000003', '2008-09-04', 'wiley92@hotmail.com', '(202) 778-7873', 'Teachers/blank.png', NULL, 0, '2023-09-04 05:21:11', '2023-09-04 05:21:11', 1, NULL),
(4, 'Laurel', 'Renner', 'TN-000004', '1983-09-04', 'owilderman@hotmail.com', '1-940-371-4553', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:11', '2023-09-04 05:21:11', 1, NULL),
(5, 'Linnea', 'Ledner', 'TN-000005', '1999-09-04', 'catherine.kohler@wyman.net', '606.960.8857', 'Teachers/blank.png', NULL, 0, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 1, NULL),
(6, 'Aileen', 'Turner', 'TN-000006', '2001-09-04', 'violet90@yahoo.com', '615.456.4882', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 35, NULL),
(7, 'Meggie', 'Strosin', 'TN-000007', '2007-09-04', 'lucas.reinger@toy.net', '1-984-410-1746', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 35, NULL),
(8, 'Cora', 'Schumm', 'TN-000008', '2000-09-04', 'murray.brigitte@hotmail.com', '+1.629.900.6353', 'Teachers/blank.png', NULL, 0, '2023-09-04 05:21:12', '2023-09-04 05:21:12', 35, NULL),
(9, 'Vern', 'Krajcik', 'TN-000009', '2000-09-04', 'wabernathy@harvey.biz', '508-535-6432', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 35, NULL),
(10, 'Edyth', 'Adams', 'TN-000010', '1989-09-04', 'rturner@hotmail.com', '+1 (985) 307-4904', 'Teachers/blank.png', NULL, 1, '2023-09-04 05:21:13', '2023-09-04 05:21:13', 35, NULL),
(12, 'Rosina', 'Adamsaaaaaaaaa', 'TN-000012', '1999-09-04', 'hoconnell@kuvalis.net', '2345678753', 'Teachers/Adamsaaaaaaaaa/teacher.jfif', 'noida', 1, '2023-09-04 05:21:13', '2023-10-13 04:40:06', 1, NULL),
(16, 'teacher1', 'varma', 'TN-000016', '1991-12-03', 'teacher1@gmail.com', '9532471951', 'Teachers/varma/teacher.jfif', 'kanpur', 1, '2023-10-03 01:27:56', '2023-10-03 01:27:56', 1, 6),
(18, 'amrita', 'singh', 'TN-000018', '2000-03-02', 'amrita@gmail.com', '', 'Teachers/singh/teacher.jfif', 'kanpur', 1, '2023-10-03 01:33:49', '2023-10-03 01:33:49', 35, 18),
(21, 'teacher309', 'singh', 'TN-000020', '1999-03-04', 'teacher309@gmail.com', '1234567899', 'Teachers/singh/teacher.jfif', 'kanpur', 1, '2023-10-04 04:49:09', '2023-10-04 04:49:09', 35, 23),
(23, 'Teacher 333', 'Singh', 'TN-000022', '2000-12-03', 'taecher333@gmail.com', '09450718607', 'Teachers/Singh/teacher22.jfif', 'delhi', 1, '2023-10-09 06:11:35', '2023-10-09 06:11:35', 35, 28),
(24, 'teacher700', 'Singh', 'TN-000023', '1919-02-03', 'teacher700@gamil.com', '07887099089', 'Teachers/Singh/teacher22.jfif', 'gurugram', 1, '2023-10-09 06:23:12', '2023-10-09 06:23:12', 1, 32),
(25, 'teacher777', 'Singh', 'TN-000024', '2000-06-07', 'taecher@777gamil.com', '1234567867', 'Teachers/Singh/teacher22.jfif', 'Noida', 1, '2023-10-09 06:29:27', '2023-10-09 06:29:27', 1, 33),
(26, 'teacher 899', 'varma', 'TN-000025', '1998-05-04', 'teacher899@gmail.com', '7887099077', 'Teachers/varma/teacher22.jfif', 'Noida', 0, '2023-10-09 06:35:02', '2023-10-09 06:35:02', 1, NULL),
(27, 'teacher1000', 'Singh', 'TN-000026', '1919-02-04', 'teacher1000@gmail.com', '7887099066', 'Teachers/Singh/teacher22.jfif', 'gurugram', 1, '2023-10-10 01:13:19', '2023-10-10 01:13:19', 1, 36),
(28, 'teacher 2  school 1', 'varma', 'TN-000027', '1987-03-04', 'teacher2@gmail.com', '9571048844', 'Teachers/varma/teacher.jfif', 'delhi', 1, '2023-10-11 04:35:12', '2023-10-11 04:35:12', 1, 42),
(29, 'teacher999 school 2', 'Singh', 'TN-000028', '1988-03-05', 'teacher999@gmail.com', '1234567800', 'Teachers/Singh/test.webp', 'kanpur', 0, '2023-10-11 04:45:13', '2023-10-11 04:45:13', 35, 43),
(31, 'teacher7009', 'singh', 'TN-000030', '2001-02-03', 'teacher7009@gmail.com', '3455667789', 'Teachers/singh/test.webp', 'Knapur', 1, '2023-10-12 02:09:10', '2023-10-12 02:09:10', 1, 54),
(33, 'taecher13001', 'varma', 'TN-000031', '2000-03-04', 'teacher13001@gmail.com', '8965346754', 'Teachers/varma/test.webp', 'kanpur', 1, '2023-10-13 02:06:25', '2023-10-13 02:06:25', 1, 58),
(34, 'teacher9999', 'varma', 'TN-000032', '1998-02-03', 'teacher9999@gmail.com', '5467839834', 'Teachers/varma/teacher.jfif', 'noida', 1, '2023-10-13 02:08:32', '2023-10-13 02:08:32', 1, 60),
(35, 'techer8001', 'varma', 'TN-000033', '1998-03-04', 'teacher8001@gmail.com', '2345567456', 'Teachers/varma/teacher.jfif', 'noida', 1, '2023-10-13 02:15:06', '2023-10-13 02:15:06', 1, 62),
(36, 'teacher178', 'varma', 'TN-000034', '2001-04-06', 'teacher178@gmail.com', '6754342389', 'Teachers/varma/teacher.jfif', 'noida', 0, '2023-10-13 02:16:43', '2023-10-13 02:16:43', 1, 63),
(37, 'teacher4000', 'varma', 'TN-000035', '2001-09-08', 'teacher4000@gmail.com', '9876542345', 'Teachers/varma/teacher.jfif', 'gurugram', 1, '2023-10-13 02:20:01', '2023-10-13 02:20:01', 1, 64),
(38, 'teacher19189', 'varmaaaaaaaaaaa', 'TN-000036', '2000-12-31', 'teacher191@gmail.com', '2345678976', 'Teachers/varmaaaaaaaaaaa/teacher.jfif', 'Noida', 1, '2023-10-13 02:45:13', '2023-10-14 02:15:18', 1, 65),
(39, 'taecher50000', 'Singh', 'TN-000037', '2000-03-04', 'teacher50000@gmail.com', '9876542345', 'Teachers/Singh/demo.png', 'kanpur', 1, '2023-10-14 02:18:14', '2023-10-14 02:18:14', 1, 66);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo_path` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_name` varchar(200) DEFAULT NULL,
  `role_id` int(4) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `soft_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo_path`, `remember_token`, `created_at`, `updated_at`, `role_name`, `role_id`, `phone_number`, `soft_login`) VALUES
(1, 'School1', 'school1@gmail.com', '2023-09-04 05:21:10', '$2y$10$GXUwEwJVAIEx9oShgBxCgu0b0sZyJqm7Os3qHBN8.W2PTrnmJjkDi', 'users/blank-profile.png', 'QAPpvMZjp7Pft6Ct2RPu0zQickPS33QNhvW9aZFt2rN4EliBSCXp28eX82Na', '2023-09-04 05:21:10', '2023-10-15 23:56:07', 'Admin', 1, '7887099057', '1'),
(2, 'manger', 'manager@gmail.com', NULL, '$2y$10$YB2AUKUjyPaRWC7V8TK.d.7VDVAJpjsOFs4/bPX3jCmGNOg2Py0nS', 'users/blank-profile.png', NULL, '2023-09-04 05:27:26', '2023-09-04 05:27:26', NULL, 4, NULL, '0'),
(6, 'Teacher 1 singh', 'teacher1@gmail.com', '2023-09-04 05:21:10', '$2y$10$CZbhJ1/uTaJy7dxG0oofSeTsSNOWPbkp9bbRlUgmdSZFD43oWF3Mq', 'Teachers/Singh/teacher.jfif', NULL, '2023-10-03 01:19:09', '2023-10-15 23:56:07', 'Teacher', 2, '9532471951', '1'),
(18, 'amrita singh', 'amrita@gmail.com', NULL, '$2y$10$i57SapghAbTuV3L3gRMBEuqKioLN517keqpCUdIL8jAdFwk/CnZ0K', NULL, NULL, '2023-10-03 01:33:49', '2023-10-13 07:06:00', NULL, NULL, NULL, '1'),
(23, 'teacher309 singh', 'teacher309@gmail.com', NULL, '$2y$10$YB2AUKUjyPaRWC7V8TK.d.7VDVAJpjsOFs4/bPX3jCmGNOg2Py0nS', 'Teachers/singh/teacher.jfif', NULL, '2023-10-04 04:49:09', '2023-10-13 07:06:00', NULL, NULL, '1234567899', '1'),
(28, 'Teacher 333 Singh', 'taecher333@gmail.com', NULL, '$2y$10$mOxHCMCGBMpXFgfvNC1kwO4/gK.uiJLrfQhpH.kVjjCGiJ6TOzgWK', 'Teachers/Singh/teacher22.jfif', NULL, '2023-10-09 06:11:35', '2023-10-13 07:06:00', NULL, NULL, '09450718607', '1'),
(32, 'teacher700 Singh', 'teacher700@gamil.com', NULL, '$2y$10$.5y/js9Z5/iK9EtyI61WE.r5JxROIaYm2nEj45.i.XPjt74YA/uOe', 'Teachers/Singh/teacher22.jfif', NULL, '2023-10-09 06:23:12', '2023-10-15 23:56:07', NULL, NULL, '07887099089', '1'),
(33, 'teacher777 Singh', 'taecher@777gamil.com', NULL, '$2y$10$l/km4uvm6wrd4bQmUtQvm.CWwgM5H3.0OqgZcXAvB1v0fi7P18wLO', 'Teachers/Singh/teacher22.jfif', NULL, '2023-10-09 06:29:27', '2023-10-15 23:56:07', NULL, NULL, '1234567867', '1'),
(35, 'School2', 'school2@gmail.com', NULL, '$2y$10$GXUwEwJVAIEx9oShgBxCgu0b0sZyJqm7Os3qHBN8.W2PTrnmJjkDi', 'users/blank-profile.png', NULL, '2023-10-09 23:38:07', '2023-10-13 07:06:00', 'Admin', 1, '7887099099', '1'),
(36, 'teacher1000 Singh', 'teacher1000@gmail.com', '2023-09-04 05:21:10', '$2y$10$ncOkz/lgC1J.ve7F3/t0c.i639AJC11Wd4.tvg/qTIg7/bL2TWh8a', 'Teachers/Singh/teacher22.jfif', NULL, '2023-10-10 01:13:19', '2023-10-15 23:56:07', 'teacher', 2, '7887099066', '1'),
(39, 'Superadmin', 'superadmin@gmail.com', NULL, '$2y$10$2Pc.haRPcR.za2qx7AQlJ.pvFjG0Ts8gTl73cjl790l6oKkZr0llG', 'users/blank-profile.png', NULL, '2023-10-10 07:17:30', '2023-10-10 07:17:30', 'Superadmin', 0, '7887099049', '1'),
(42, 'teacher 2  school 1 varma', 'teacher2@gmail.com', NULL, '$2y$10$eBfmxIDI7qeKsEMp92545OhHPtRG4o/qO9n9G39XwiE3A5rNQcgva', 'Teachers/varma/teacher.jfif', NULL, '2023-10-11 04:35:12', '2023-10-15 23:56:07', 'Teacher', 2, '9571048844', '1'),
(43, 'teacher999 school 2 Singh', 'teacher999@gmail.com', NULL, '$2y$10$CZbhJ1/uTaJy7dxG0oofSeTsSNOWPbkp9bbRlUgmdSZFD43oWF3Mq', 'Teachers/Singh/test.webp', NULL, '2023-10-11 04:45:13', '2023-10-13 07:06:00', 'teacher', 2, '1234567800', '1'),
(45, 'School3', 'school3@gmail.com', NULL, '$2y$10$NUIuMKkoFS951.TUysPed.GXHmBhZ/pPJDG2gEDCygImCdU/P9uLG', 'users/blank-profile.png', NULL, '2023-10-12 01:12:48', '2023-10-12 01:12:48', NULL, NULL, '9450718600', '1'),
(51, 'school123', 'school123@gmail.com', NULL, '$2y$10$o7L1oY2/gWeGCiqLD6lQ7.jtz89jwG8u.QRvyDxIcbB3klKUd0MyG', 'users/blank-profile.png', NULL, '2023-10-12 01:51:34', '2023-10-15 23:56:13', NULL, 1, '98234567892', '0'),
(54, 'teacher7009 singh', 'teacher7009@gmail.com', NULL, '$2y$10$mZaEX8vnwjn7UIZQTs./pu8HgPOcm4qEKPu0XK4jUkOURFqhqG5Jq', 'Teachers/singh/test.webp', NULL, '2023-10-12 02:09:10', '2023-10-15 23:56:07', NULL, 2, '3455667789', '1'),
(56, 'school995', 'school995@gmail.com', NULL, '$2y$10$kBJdGJ9WtpV2FS3x58Co1O4/Kk34nTm7UR7j0Hoy94gXZLqZVf7H.', 'users/blank-profile.png', NULL, '2023-10-13 00:56:08', '2023-10-15 23:56:11', NULL, 1, '7878778909', '0'),
(58, 'taecher13001 varma', 'teacher13001@gmail.com', NULL, '$2y$10$3tjTQfW2EPQHcc9Y8WEc5e9tK6JSpQFD.ySeWy.XARWOjYQtp.5tK', 'Teachers/varma/test.webp', NULL, '2023-10-13 02:06:25', '2023-10-15 23:56:07', NULL, 2, '8965346754', '1'),
(60, 'teacher9999 varma', 'teacher9999@gmail.com', NULL, '$2y$10$TD6ZwdjEd84eOMY8lxA7muSH/7DpdRCvad3z6w3QwK.arKHdrA006', 'Teachers/varma/teacher.jfif', NULL, '2023-10-13 02:08:32', '2023-10-15 23:56:07', NULL, 2, '5467839834', '1'),
(62, 'techer8001 varma', 'teacher8001@gmail.com', NULL, '$2y$10$m1pJE6gzksCREMLvM45vRO1R/wy65ngnZ1IuryEabIKk4k3DdH6Ue', 'Teachers/varma/teacher.jfif', NULL, '2023-10-13 02:15:06', '2023-10-15 23:56:07', NULL, 2, '2345567456', '1'),
(63, 'teacher178 varma', 'teacher178@gmail.com', NULL, '$2y$10$uATjOx9kkiAQ.HZ4HuY5/e0L.82w5vc3jRGcJ2deBG.z1pfmUst4O', 'Teachers/varma/teacher.jfif', NULL, '2023-10-13 02:16:43', '2023-10-15 23:56:07', NULL, 2, '6754342389', '1'),
(64, 'teacher4000 varma', 'teacher4000@gmail.com', NULL, '$2y$10$z6dVTJzdWVgeVVLnGXVoBecrfUc1qTfuPbP94Fy2IZKTX1qA9k7ea', 'Teachers/varma/teacher.jfif', NULL, '2023-10-13 02:20:01', '2023-10-15 23:56:07', NULL, 2, '9876542345', '1'),
(65, 'teacher19189 varmaaaaaaaaaaa', 'teacher191@gmail.com', NULL, '$2y$10$OIxU2yQYTGmBs/gDFVdTTOOu7T3Brot22//kP1drxAjv8dm0HiZ46', 'Teachers/varmaaaaaaaaaaa/teacher.jfif', NULL, '2023-10-13 02:45:13', '2023-10-15 23:56:07', NULL, 2, '2345678976', '1'),
(66, 'taecher50000 Singh', 'teacher50000@gmail.com', NULL, '$2y$10$gie8D9ybiR2dVQKVALPnTeSrM778db3dbPfT4xyZPPpSqDc8ozGdm', 'Teachers/Singh/demo.png', NULL, '2023-10-14 02:18:14', '2023-10-15 23:56:07', NULL, 2, '9876542345', '1'),
(67, 'school75', 'school75@gmail.com', NULL, '$2y$10$Fo7pKo.GpzDqgcQywQDLyeubf6.KlBa3VR3fAzJMzupl40Tm9sF96', 'users/blank-profile.png', NULL, '2023-10-15 23:28:22', '2023-10-15 23:56:08', NULL, 1, '3456786543', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classrooms_school_id_foreign` (`school_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_teacher_id_foreign` (`teacher_id`),
  ADD KEY `courses_classroom_id_foreign` (`classroom_id`),
  ADD KEY `courses_school_id_foreign` (`school_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requests_teacher_id_foreign` (`teacher_id`),
  ADD KEY `requests_classroom_id_foreign` (`classroom_id`),
  ADD KEY `requests_school_id_foreign` (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_classroom_id_foreign` (`classroom_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_teacher_id_foreign` (`teacher_id`),
  ADD KEY `subjects_classroom_id_foreign` (`classroom_id`),
  ADD KEY `subjects_school_id_foreign` (`school_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD KEY `teachers_school_id_foreign` (`school_id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requests_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requests_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
