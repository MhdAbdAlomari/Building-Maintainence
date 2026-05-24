-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24 مايو 2026 الساعة 08:47
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `building_maintenance`
--

-- --------------------------------------------------------

--
-- Truncate table before insert `addresses`
--

TRUNCATE TABLE `addresses`;
--
-- إرجاع أو استيراد بيانات الجدول `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `region_id`, `label`, `address_text`, `latitude`, `longitude`, `is_default`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 27, 6, NULL, '380 Hammes Street Suite 667', 33.2335050, 35.6826860, 0, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33'),
(2, 12, 17, NULL, '67773 Pouros Junctions Apt. 353', 32.9468080, 37.1949330, 0, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33'),
(3, 7, 13, 'Work', '92021 Klein Plains Apt. 734', 32.6158190, 36.8423680, 0, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33'),
(4, 6, 2, 'Other', '27568 Friesen Groves', 33.1179200, 38.1105030, 0, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33'),
(5, 10, 27, 'Home', '88432 Cordie Garden', 33.4221040, 38.0660210, 0, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33'),
(6, 13, 22, NULL, '37099 Percival Rapids', 33.8692330, 38.2778860, 0, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34'),
(7, 11, 11, NULL, '811 Alford Bridge', 34.4964000, 35.9249700, 0, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34'),
(8, 9, 11, 'Home', '77760 Cyril Street', 33.6161340, 38.2020450, 0, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34'),
(9, 8, 9, 'Home', '8633 Zulauf Mountains Suite 946', 33.4294240, 35.7939980, 0, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34'),
(10, 16, 6, 'Work', '5847 Friesen Mill', 34.4141840, 36.7917960, 0, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34'),
(11, 5, 12, 'Home', '95962 Savanah Underpass', 32.5871320, 37.6004160, 0, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(12, 15, 11, 'Other', '6685 Price Well', 32.6619050, 35.6680800, 0, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(13, 14, 16, NULL, '218 Littel Union', 33.1650740, 37.7768980, 0, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(14, 3, 6, NULL, '369 Metz Rue', 33.0113370, 36.2869760, 0, NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(15, 4, 4, 'Home', '823 Beier Harbors Suite 339', 33.1544780, 38.1244450, 0, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(16, 1, 2, 'Other', '2935 Kaleigh Forks', 33.4130700, 38.2180000, 1, NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:49'),
(17, 2, 20, 'Home', '704 Gutmann Prairie Suite 359', 34.4135320, 37.6526690, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(18, 2, 20, 'Work', '668 Bertrand Stravenue', 33.8333440, 36.4301500, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(19, 3, 27, 'Work', '9728 Antoinette Glens', 32.8752310, 38.3612640, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(20, 3, 27, 'Home', '161 Hal Trail', 33.2684510, 37.6813330, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(21, 3, 27, 'Home', '59998 Sally Overpass', 32.5316490, 38.2954430, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(22, 4, 3, 'Home', '807 Anabel Drive Apt. 558', 33.4461330, 35.5909760, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(23, 4, 3, 'Work', '628 Block Place Apt. 277', 34.1748240, 37.5252190, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(24, 5, 22, 'Other', '30719 Labadie Harbors', 33.1944770, 37.5832440, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(25, 6, 28, 'Home', '55774 Damian Dam', 32.6952990, 38.1698720, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(26, 6, 28, 'Work', '144 Rutherford Glens Suite 746', 33.1701430, 36.1308190, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(27, 7, 28, 'Home', '1050 Geraldine Road', 33.3159270, 36.9801880, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(28, 8, 22, 'Home', '42083 Heathcote Burgs Suite 561', 32.5585150, 37.6628060, 1, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:50'),
(29, 8, 22, 'Work', '91969 Crist Terrace', 34.0984430, 37.2496310, 0, NULL, '2026-05-07 07:54:49', '2026-05-07 07:54:49'),
(30, 8, 22, 'Home', '2992 Rau Field Apt. 293', 33.0283050, 35.6504400, 0, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(31, 9, 17, 'Home', '37871 Chaz Isle Suite 365', 32.7956490, 38.4334610, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(32, 10, 11, 'Home', '2578 Elias Mountain Apt. 780', 32.9853270, 35.6830860, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(33, 10, 11, 'Work', '8126 Hansen Rapid Suite 076', 33.4200100, 36.6184410, 0, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(34, 11, 7, 'Home', '78031 Kozey Port', 32.9398240, 37.9012070, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(35, 11, 7, 'Home', '903 Oral Lodge', 32.5137990, 35.9101670, 0, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(36, 11, 7, NULL, '248 Ada Overpass Suite 527', 33.8837380, 37.7618330, 0, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(37, 12, 7, 'Other', '31322 Funk Manor Apt. 647', 34.4696590, 37.5480140, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(38, 12, 7, NULL, '279 Norwood Glens', 34.4958240, 36.4573080, 0, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(39, 13, 20, 'Home', '34507 Leilani Terrace', 34.2339430, 37.8157650, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(40, 14, 29, 'Home', '5388 Tania Knoll', 32.9464910, 37.3351150, 1, NULL, '2026-05-07 07:54:50', '2026-05-07 07:54:50'),
(41, 15, 6, 'Other', '6455 Predovic Drives Suite 253', 32.9758430, 35.9164330, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(42, 16, 10, 'Home', '3939 Quitzon Manor Apt. 339', 33.8849250, 37.2434410, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(43, 16, 10, 'Other', '449 Providenci Burgs Apt. 774', 34.1039910, 38.1683060, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(44, 16, 10, 'Other', '292 Nils Estates', 32.5361440, 38.0729160, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(45, 17, 28, 'Home', '3383 Nya Via', 32.5202700, 35.8552020, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(46, 17, 28, 'Home', '600 Reinger Loaf Suite 710', 33.5119620, 38.2895860, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(47, 17, 28, 'Home', '118 Farrell Cliffs Apt. 596', 32.8043360, 38.2947070, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(48, 18, 7, 'Other', '16552 Junius Cape Suite 771', 33.0548430, 38.1469660, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(49, 19, 14, 'Other', '3626 Arturo Plaza', 33.6456100, 36.8810160, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(50, 20, 9, 'Home', '913 Rita Parks Suite 238', 34.1327350, 36.3730410, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(51, 20, 9, 'Home', '20608 Lenora Corner Apt. 948', 34.4013690, 35.9270350, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(52, 21, 14, 'Home', '915 Brook Trail', 32.5322050, 37.1208980, 1, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:52'),
(53, 21, 14, 'Home', '908 Mante Gateway Suite 181', 32.6319460, 37.5315060, 0, NULL, '2026-05-07 07:54:51', '2026-05-07 07:54:51'),
(54, 21, 14, NULL, '571 Brown Coves', 33.8068830, 35.6320870, 0, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(55, 22, 22, 'Work', '25846 Jaskolski Forks', 33.8631650, 35.9265460, 1, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(56, 23, 28, 'Home', '708 Jaqueline Mill', 34.2456010, 37.7260320, 1, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(57, 24, 19, 'Other', '7995 Ryan Islands', 34.4273720, 36.6141580, 1, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(58, 25, 4, 'Work', '9229 Farrell Club Apt. 796', 33.8103840, 36.2418350, 1, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(59, 26, 14, 'Other', '9489 Josiah Unions', 33.3407150, 36.1545910, 1, NULL, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(60, 27, NULL, 'جامعة دمشق - مجمع الطب والآداب – محافظة دمشق', 'جامعة دمشق - مجمع الطب والآداب, شارع 17 نيسان, حي الإخلاص, بلدية كفر سوسة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5071663, 36.2696765, 1, NULL, '2026-05-07 08:26:40', '2026-05-07 08:26:40'),
(61, 27, NULL, 'حي دمر الشرقية – محافظة دمشق', 'حي دمر الشرقية, بلدية دمر, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5252485, 36.2573007, 0, NULL, '2026-05-07 08:30:51', '2026-05-07 08:30:51'),
(62, 27, NULL, 'حي دمر الشرقية – محافظة دمشق', 'حي دمر الشرقية, بلدية دمر, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5355380, 36.2730400, 0, NULL, '2026-05-09 06:20:10', '2026-05-09 06:20:10'),
(63, 30, NULL, 'بلدية المزة – محافظة دمشق', 'بلدية المزة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5021550, 36.2456866, 0, NULL, '2026-05-23 01:18:14', '2026-05-23 02:32:54'),
(64, 30, NULL, 'بلدية المزة – محافظة دمشق', 'بلدية المزة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5021550, 36.2456866, 0, NULL, '2026-05-23 01:18:21', '2026-05-23 02:32:54'),
(65, 30, NULL, 'بلدية المزة – محافظة دمشق', 'بلدية المزة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5021550, 36.2456866, 0, NULL, '2026-05-23 01:19:41', '2026-05-23 02:32:54'),
(66, 30, NULL, 'ابن العباس – محافظة دمشق', 'ابن العباس, حي الواحة, بلدية كفر سوسة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.4965827, 36.2906943, 0, NULL, '2026-05-23 01:40:58', '2026-05-23 02:32:54'),
(67, 30, NULL, 'حي دمر الشرقية – محافظة دمشق', 'حي دمر الشرقية, بلدية دمر, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5313466, 36.2752490, 0, NULL, '2026-05-23 01:49:48', '2026-05-23 02:32:54'),
(68, 30, NULL, 'شارع الصغير – محافظة دمشق', 'شارع الصغير, حي الأمين, دمشق, بلدية دمشق القديمة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5051020, 36.3105372, 0, NULL, '2026-05-23 01:49:59', '2026-05-23 02:32:54'),
(69, 30, NULL, 'حي مزة ٨٦ – محافظة دمشق', 'حي مزة ٨٦, بلدية المزة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5088320, 36.2450939, 0, NULL, '2026-05-23 01:50:41', '2026-05-23 02:32:54'),
(70, 27, NULL, 'حلب – محافظة حلب', 'حلب, ناحية مركز جبل سمعان, منطقة جبل سمعان, محافظة حلب, سوريا', 36.1992400, 37.1637253, 0, NULL, '2026-05-23 01:51:54', '2026-05-23 01:51:54'),
(71, 30, NULL, 'محافظة حلب – محافظة حلب', 'محافظة حلب, سوريا', 36.2988434, 37.7593857, 0, NULL, '2026-05-23 02:15:27', '2026-05-23 02:32:54'),
(72, 30, NULL, 'أتستراد بيروت – محافظة دمشق', 'أتستراد بيروت, حي الإخلاص, بلدية كفر سوسة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.4918138, 36.2654117, 0, NULL, '2026-05-23 02:16:53', '2026-05-23 02:32:54'),
(73, 30, NULL, 'أتستراد بيروت – محافظة دمشق', 'أتستراد بيروت, حي الإخلاص, بلدية كفر سوسة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.4918138, 36.2654117, 0, NULL, '2026-05-23 02:17:11', '2026-05-23 02:32:54'),
(74, 30, NULL, 'كورجيه حداد – محافظة دمشق', 'كورجيه حداد, حي ساروجة, بلدية ساروجة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5183591, 36.2982098, 1, NULL, '2026-05-23 02:32:54', '2026-05-23 02:32:54'),
(75, 27, NULL, 'سوق الطويل - مدحت باشا – محافظة دمشق', 'سوق الطويل - مدحت باشا, حارة اليهود, باب توما, حي باب توما, دمشق, بلدية دمشق القديمة, ناحية دمشق, منطقة دمشق, محافظة دمشق, سوريا', 33.5092212, 36.3124666, 0, NULL, '2026-05-24 00:17:00', '2026-05-24 00:17:00');

-- --------------------------------------------------------

--
-- Truncate table before insert `app_settings`
--

TRUNCATE TABLE `app_settings`;
--
-- إرجاع أو استيراد بيانات الجدول `app_settings`
--

INSERT INTO `app_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'commission_rate', '10', '2026-05-23 18:39:19', '2026-05-23 18:39:19'),
(2, 'debt_ceiling', '2500', '2026-05-23 18:39:19', '2026-05-24 00:59:52'),
(3, 'owner_name', 'محمد عبد الرحمن محمد خير العمري', '2026-05-23 18:53:51', '2026-05-23 18:53:51'),
(4, 'owner_phone', '0964360686', '2026-05-23 18:53:51', '2026-05-23 18:53:51'),
(5, 'owner_governorate', 'damascus', '2026-05-23 18:53:51', '2026-05-23 18:53:51');

-- --------------------------------------------------------

--
-- Truncate table before insert `banners`
--

TRUNCATE TABLE `banners`;
--
-- إرجاع أو استيراد بيانات الجدول `banners`
--

INSERT INTO `banners` (`id`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'banners/AC_Banner.png', 1, 0, NULL, NULL),
(3, 'banners/Painting_Banner.png', 1, 0, NULL, NULL),
(4, 'banners/elec_Banner.png', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Truncate table before insert `cache`
--

-- --------------------------------------------------------

--
-- Truncate table before insert `commissions`
--

TRUNCATE TABLE `commissions`;
--
-- إرجاع أو استيراد بيانات الجدول `commissions`
--

INSERT INTO `commissions` (`id`, `request_id`, `technician_id`, `payment_id`, `request_amount`, `commission_rate`, `commission_amount`, `payment_method`, `status`, `collected_at`, `created_at`, `updated_at`) VALUES
(3, 105, 30, 16, 2500, 10, 250, 'cash', 'pending_debt', NULL, '2026-05-24 00:51:33', '2026-05-24 00:51:33');

-- --------------------------------------------------------

--
-- Truncate table before insert `debt_settlements`
--

TRUNCATE TABLE `debt_settlements`;
--
-- إرجاع أو استيراد بيانات الجدول `debt_settlements`
--

INSERT INTO `debt_settlements` (`id`, `technician_id`, `amount`, `branch`, `receipt_image`, `note`, `status`, `rejection_reason`, `reviewed_at`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(2, 30, 250, 'alharam', 'settlements/NSV8QlaPVvoHfCg3B8pCgK0ccPuvTmGOgTFnt1pr.jpg', 'تم تحويل المبلغ كامل', 'pending', NULL, NULL, NULL, '2026-05-24 00:57:25', '2026-05-24 00:57:25');

-- --------------------------------------------------------

--
-- Truncate table before insert `failed_jobs`
--

TRUNCATE TABLE `failed_jobs`;
-- --------------------------------------------------------

--
-- Truncate table before insert `jobs`
--

TRUNCATE TABLE `jobs`;
-- --------------------------------------------------------

--
-- Truncate table before insert `job_batches`
--

TRUNCATE TABLE `job_batches`;
-- --------------------------------------------------------

--
-- Truncate table before insert `media`
--

TRUNCATE TABLE `media`;
--
-- إرجاع أو استيراد بيانات الجدول `media`
--

INSERT INTO `media` (`id`, `request_id`, `type`, `url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 31, 'after', 'https://via.placeholder.com/640x480.png/006699?text=business+aliquam', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(2, 32, 'before', 'https://via.placeholder.com/640x480.png/0055bb?text=business+ut', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(3, 33, 'after', 'https://via.placeholder.com/640x480.png/00dd00?text=business+id', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(4, 34, 'after', 'https://via.placeholder.com/640x480.png/0088cc?text=business+quidem', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(5, 35, 'after', 'https://via.placeholder.com/640x480.png/0066aa?text=business+esse', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(6, 36, 'after', 'https://via.placeholder.com/640x480.png/003399?text=business+cum', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(7, 37, 'before', 'https://via.placeholder.com/640x480.png/0088dd?text=business+magni', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(8, 38, 'after', 'https://via.placeholder.com/640x480.png/00ff88?text=business+rerum', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(9, 39, 'before', 'https://via.placeholder.com/640x480.png/007755?text=business+quae', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(10, 40, 'after', 'https://via.placeholder.com/640x480.png/006644?text=business+est', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(11, 41, 'before', 'https://via.placeholder.com/640x480.png/00ff22?text=business+vel', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(12, 42, 'before', 'https://via.placeholder.com/640x480.png/0088bb?text=business+molestiae', NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46'),
(13, 43, 'after', 'https://via.placeholder.com/640x480.png/007711?text=business+voluptate', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(14, 44, 'after', 'https://via.placeholder.com/640x480.png/00ffdd?text=business+itaque', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(15, 45, 'after', 'https://via.placeholder.com/640x480.png/001100?text=business+aut', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(16, 46, 'after', 'https://via.placeholder.com/640x480.png/003388?text=business+minus', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(17, 47, 'after', 'https://via.placeholder.com/640x480.png/009933?text=business+aut', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(18, 48, 'after', 'https://via.placeholder.com/640x480.png/004455?text=business+incidunt', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(19, 49, 'before', 'https://via.placeholder.com/640x480.png/006622?text=business+ad', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(20, 50, 'before', 'https://via.placeholder.com/640x480.png/0055bb?text=business+dolorem', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(21, 51, 'before', 'https://via.placeholder.com/640x480.png/0077bb?text=business+voluptatibus', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(22, 52, 'after', 'https://via.placeholder.com/640x480.png/00bb44?text=business+amet', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(23, 53, 'after', 'https://via.placeholder.com/640x480.png/00dd11?text=business+odit', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(24, 54, 'after', 'https://via.placeholder.com/640x480.png/000099?text=business+sed', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(25, 55, 'after', 'https://via.placeholder.com/640x480.png/00cc99?text=business+dolores', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(26, 56, 'after', 'https://via.placeholder.com/640x480.png/00cc11?text=business+et', NULL, '2026-05-07 07:54:47', '2026-05-07 07:54:47'),
(27, 57, 'before', 'https://via.placeholder.com/640x480.png/002233?text=business+quo', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(28, 58, 'after', 'https://via.placeholder.com/640x480.png/0000cc?text=business+ducimus', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(29, 59, 'after', 'https://via.placeholder.com/640x480.png/007799?text=business+fugiat', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(30, 60, 'before', 'https://via.placeholder.com/640x480.png/007733?text=business+omnis', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(31, 61, 'after', 'https://via.placeholder.com/640x480.png/00aa33?text=business+provident', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(32, 62, 'before', 'https://via.placeholder.com/640x480.png/00dd11?text=business+numquam', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(33, 63, 'after', 'https://via.placeholder.com/640x480.png/0033aa?text=business+laboriosam', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(34, 64, 'before', 'https://via.placeholder.com/640x480.png/00dd55?text=business+et', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(35, 65, 'after', 'https://via.placeholder.com/640x480.png/001166?text=business+earum', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(36, 66, 'before', 'https://via.placeholder.com/640x480.png/005544?text=business+laboriosam', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(37, 67, 'after', 'https://via.placeholder.com/640x480.png/0022cc?text=business+cupiditate', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(38, 68, 'after', 'https://via.placeholder.com/640x480.png/00ccff?text=business+similique', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(39, 69, 'before', 'https://via.placeholder.com/640x480.png/0044ee?text=business+neque', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(40, 70, 'before', 'https://via.placeholder.com/640x480.png/000055?text=business+iure', NULL, '2026-05-07 07:54:48', '2026-05-07 07:54:48'),
(42, 85, 'before', 'http://192.168.1.103:8000/storage/requests/85/before/BEfC3ew6uv1k1RZlGe7ErpOufUCaEXYIXKTqPbqj.jpg', NULL, '2026-05-07 08:27:11', '2026-05-07 08:27:11'),
(43, 87, 'before', 'http://192.168.1.103:8000/storage/requests/87/before/xoyAOEqwZJzQ73feEcNjdxlQwGAFSkzhz66sttDF.jpg', NULL, '2026-05-07 08:39:11', '2026-05-07 08:39:11'),
(44, 88, 'before', 'http://192.168.1.103:8000/storage/requests/88/before/3VoCQyXndqJZ7NHFyhl6tYFGC3IkXmsfJ5RMcv4w.jpg', NULL, '2026-05-07 08:48:04', '2026-05-07 08:48:04'),
(45, 89, 'before', 'http://192.168.1.103:8000/storage/requests/89/before/4jhTgt9ZjD0cUBsoF79PrtIcajFWEcM7burAt4bO.jpg', NULL, '2026-05-07 12:07:33', '2026-05-07 12:07:33'),
(49, 91, 'before', 'http://192.168.1.103:8000/storage/requests/91/before/6dN3LGAazRsN1rb5Csv1ztudA0soOiZVt5kN3uKj.jpg', NULL, '2026-05-07 12:30:37', '2026-05-07 12:30:37'),
(50, 91, 'before', 'http://192.168.1.103:8000/storage/requests/91/before/JB2WCPwrKgiXfGqUGrMkPhQjjOURpKBiDe1F9WkV.jpg', NULL, '2026-05-07 12:30:37', '2026-05-07 12:30:37'),
(51, 91, 'before', 'http://192.168.1.103:8000/storage/requests/91/before/57akSPvAGZ0vA6gPVXlW0J41c76DN4NEtogneZ7O.jpg', NULL, '2026-05-07 12:30:37', '2026-05-07 12:30:37'),
(54, 94, 'before', 'http://192.168.1.103:8000/storage/requests/94/before/zkAW7uMjRoGEozUoZsil0vDdA3pZwQf4rmJcjroB.jpg', NULL, '2026-05-18 13:05:52', '2026-05-18 13:05:52'),
(62, 105, 'before', 'http://192.168.1.103:8000/storage/requests/105/before/64f7sgE5gCC4NsFyFOB0YwDRqW2yDDdkjcVueo7q.jpg', NULL, '2026-05-24 00:10:48', '2026-05-24 00:10:48'),
(63, 105, 'before', 'http://192.168.1.103:8000/storage/requests/105/before/KE4l1qcqPsGGyJCAdy99R2SG9o7fmvYvHRSKumrC.jpg', NULL, '2026-05-24 00:10:48', '2026-05-24 00:10:48'),
(64, 106, 'before', 'http://192.168.1.103:8000/storage/requests/106/before/o9ex4fhZTq18r4gRCjXZ91A6NhUmlG52BQwC9RBF.jpg', NULL, '2026-05-24 00:38:16', '2026-05-24 00:38:16');

-- --------------------------------------------------------

--
-- Truncate table before insert `migrations`
--

-- --------------------------------------------------------

--
-- Truncate table before insert `password_reset_tokens`
--

TRUNCATE TABLE `password_reset_tokens`;
-- --------------------------------------------------------

--
-- Truncate table before insert `payments`
--

TRUNCATE TABLE `payments`;
--
-- إرجاع أو استيراد بيانات الجدول `payments`
--

INSERT INTO `payments` (`id`, `request_id`, `tenant_id`, `amount_usd_cents`, `currency`, `payment_method`, `status`, `stripe_session_id`, `stripe_payment_intent_id`, `created_at`, `updated_at`) VALUES
(16, 105, 27, 0, 'SYP', 'cash', 'paid', NULL, NULL, '2026-05-24 00:51:33', '2026-05-24 00:51:33'),
(17, 105, 27, 50, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 01:08:42', '2026-05-24 01:08:42'),
(18, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a1iM9F9CNpL8B0I8HeAgGKa52K0zzIiLumR4zQTM0rJA12LFGNgUjxkEE7', NULL, '2026-05-24 01:09:18', '2026-05-24 01:09:26'),
(19, 105, 27, 3500, 'SYR', 'cash', 'paid', 'cs_test_a16a1LCWFR16ylpal8eATSupmpqHusNwYpI5EqU5N8IT91KRgtwDHfYvDS', NULL, '2026-05-24 01:09:50', '2026-05-24 01:31:29'),
(20, 105, 27, 2500, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 01:47:25', '2026-05-24 01:47:25'),
(21, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a1INhvHeSlLTkmxzu2EOPf1VoOT1nUCJbaafnIuUIoHCuWMioyjnOAfEgR', NULL, '2026-05-24 01:47:57', '2026-05-24 01:48:21'),
(22, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a1FwLDQHSG3HNMwaAizBmQTAtGpLhgctxkgc0vIwUOEBVTUgs4lokLESy0', NULL, '2026-05-24 01:48:23', '2026-05-24 01:48:40'),
(23, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a1bkjNu8Gbx5PFSwB1G3zT9Fr7dwKGrWngslmmKBjJCbrUWCuB6ABmtMlY', NULL, '2026-05-24 01:52:08', '2026-05-24 01:52:31'),
(24, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a1cxkjyEP3FET6Nw1ZpKtEB4DRJf3RCNWsmd9gjcKu2G4sdT7163CeLuZU', NULL, '2026-05-24 01:53:56', '2026-05-24 01:54:04'),
(25, 105, 27, 2500, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 01:57:38', '2026-05-24 01:57:38'),
(26, 105, 27, 2500, 'usd', 'stripe', 'pending', 'cs_test_a191rOyuhEPBxqZ1yKRxwEWytzPWSAxCEN6tmRUbNaM8Nyo4QJ7IVP7whZ', NULL, '2026-05-24 02:01:02', '2026-05-24 02:01:03'),
(27, 105, 27, 2500, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 02:03:17', '2026-05-24 02:03:17'),
(28, 105, 27, 2500, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 02:04:08', '2026-05-24 02:04:08'),
(29, 105, 27, 2500, 'usd', 'stripe', 'pending', NULL, NULL, '2026-05-24 02:04:33', '2026-05-24 02:04:33');

-- --------------------------------------------------------

--
-- Truncate table before insert `personal_access_tokens`
--

TRUNCATE TABLE `personal_access_tokens`;
--
-- إرجاع أو استيراد بيانات الجدول `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6, 'App\\Models\\User', 27, 'auth_token', '67e44b3945889399720b496d1c92b988c30fe2e3d63b8723ca18eb4af48d790f', '[\"*\"]', NULL, NULL, '2026-05-07 10:01:00', '2026-05-07 10:01:00'),
(13, 'App\\Models\\User', 28, 'auth_token', 'e0b0b5363cd674cd4351c50482b7ddc82064b948ecd6a3a497212d8e34ff9481', '[\"*\"]', '2026-05-07 16:42:16', NULL, '2026-05-07 16:41:04', '2026-05-07 16:42:16'),
(22, 'App\\Models\\User', 27, 'auth_token', 'b1024f9b7541c4b58bddd086bc0490b2531a825fee1eb66448f4378641327219', '[\"*\"]', '2026-05-07 17:41:38', NULL, '2026-05-07 17:36:30', '2026-05-07 17:41:38'),
(25, 'App\\Models\\User', 27, 'auth_token', '6faaeb2cb6cf5a40b853d4f9dcdbcd9c14b62b18b0b06ad161e41a37b35afb98', '[\"*\"]', '2026-05-07 07:48:33', NULL, '2026-05-07 18:11:26', '2026-05-07 07:48:33'),
(31, 'App\\Models\\User', 27, 'auth_token', '5074f532daa517d2c1e050bc1e2ddb9db1420c7b581c1c5be6e44de0a5e8c539', '[\"*\"]', '2026-05-07 07:56:31', NULL, '2026-05-07 07:55:12', '2026-05-07 07:56:31'),
(32, 'App\\Models\\User', 28, 'auth_token', 'be32b3a01f6da5735d49213737420387b2515788646db7e20f06061de9687814', '[\"*\"]', '2026-05-07 07:57:20', NULL, '2026-05-07 07:57:11', '2026-05-07 07:57:20'),
(33, 'App\\Models\\User', 27, 'auth_token', '43ddf9b8d5a81d9b66ae3cca95d517e08766b8917e0a4958d57c27af7f400470', '[\"*\"]', '2026-05-07 08:50:56', NULL, '2026-05-07 07:57:54', '2026-05-07 08:50:56'),
(35, 'App\\Models\\User', 28, 'auth_token', '883bb9fe63c7a2a8ccb171dfc15d87bb340f5c5a80c034647ba7f823aac5dd04', '[\"*\"]', '2026-05-07 10:38:43', NULL, '2026-05-07 09:05:13', '2026-05-07 10:38:43'),
(41, 'App\\Models\\User', 28, 'auth_token', 'c9df10ff57482e5d9a34b35985546506ed353f0b36cc19918e94e48f6f82b788', '[\"*\"]', '2026-05-07 11:34:32', NULL, '2026-05-07 10:39:06', '2026-05-07 11:34:32'),
(43, 'App\\Models\\User', 27, 'auth_token', 'dc9c4f49a621eae855fac0f5452b6bb5187f153005ccb50796263821dda1d641', '[\"*\"]', '2026-05-07 12:09:03', NULL, '2026-05-07 11:45:57', '2026-05-07 12:09:03'),
(48, 'App\\Models\\User', 30, 'auth_token', 'eee5f52251435c256c2f9fcc461c6737de2399b14b3a86bc481f33b1d723f22e', '[\"*\"]', '2026-05-07 13:02:30', NULL, '2026-05-07 12:59:06', '2026-05-07 13:02:30'),
(60, 'App\\Models\\User', 30, 'auth_token', 'f9ac3fe42e056106d71f09482b12df02767e9d8c78437146eaa974fd4a36545c', '[\"*\"]', '2026-05-08 19:21:48', NULL, '2026-05-07 15:42:29', '2026-05-08 19:21:48'),
(74, 'App\\Models\\User', 27, 'auth_token', 'e868fbc66e50d36db51968f541a0add186aa8611475176f273dfdc9ec58555bb', '[\"*\"]', '2026-05-14 12:45:55', NULL, '2026-05-09 06:26:53', '2026-05-14 12:45:55'),
(75, 'App\\Models\\User', 27, 'auth_token', '10d7afa527e55f6b5c72741352e270a487af736dc9f3c2ba9b3606143b83de85', '[\"*\"]', NULL, NULL, '2026-05-14 14:38:40', '2026-05-14 14:38:40'),
(77, 'App\\Models\\User', 30, 'auth_token', 'eca2d22ab4a7ba0e40fc0b518ab3287084999eba27cffd470e71fab9ea829d90', '[\"*\"]', NULL, NULL, '2026-05-14 14:42:19', '2026-05-14 14:42:19'),
(78, 'App\\Models\\User', 27, 'auth_token', '5f99fb0d94d7f8c5d506c215abfab727330d239ffcd4367b644503347de38156', '[\"*\"]', '2026-05-14 14:44:52', NULL, '2026-05-14 14:42:31', '2026-05-14 14:44:52'),
(79, 'App\\Models\\User', 30, 'auth_token', '76d3e7b2e346bd2ce5755b08c0b350fec6d659a7bece9706075bd241174d6749', '[\"*\"]', '2026-05-14 14:45:22', NULL, '2026-05-14 14:43:53', '2026-05-14 14:45:22'),
(83, 'App\\Models\\User', 30, 'auth_token', '5e4a82a0f0384ce4e16c11349a161aba829c5db8fa46cc301e5e9d3579eb03c9', '[\"*\"]', '2026-05-23 19:08:18', NULL, '2026-05-14 15:07:41', '2026-05-23 19:08:18'),
(85, 'App\\Models\\User', 30, 'auth_token', '6bb3cb2807a0b3e51a6a5fafa233a4ab196e057d48293c5d969115a10d597514', '[\"*\"]', '2026-05-18 11:53:30', NULL, '2026-05-18 10:47:33', '2026-05-18 11:53:30'),
(103, 'App\\Models\\User', 30, 'auth_token', 'a5458857e92edf2d8496f687b20c8495b1b5c24f2b7e07160e3d2a792cbf1562', '[\"*\"]', '2026-05-23 00:13:39', NULL, '2026-05-23 00:12:55', '2026-05-23 00:13:39'),
(104, 'App\\Models\\User', 30, 'auth_token', '1ff953cee0d7e9ec94a8e7760fde3649fbc5bf5274c32907143a6ec7591ab1ae', '[\"*\"]', '2026-05-23 01:43:37', NULL, '2026-05-23 00:15:45', '2026-05-23 01:43:37'),
(119, 'App\\Models\\User', 30, 'auth_token', 'e8a8860c0ddf38e16c2869fdfb3f2bcd0040ded8cb9667a0a69156b6c65eac4f', '[\"*\"]', '2026-05-23 18:47:20', NULL, '2026-05-23 18:47:02', '2026-05-23 18:47:20'),
(120, 'App\\Models\\User', 27, 'auth_token', '6db8fa0b8b3d3833766fc464d32ee9cc8843ba1616079025caf7305024efab99', '[\"*\"]', '2026-05-24 01:06:35', NULL, '2026-05-23 19:08:47', '2026-05-24 01:06:35'),
(121, 'App\\Models\\User', 27, 'auth_token', '1bc731ccbdb38c1b201a06a61b5ec81efdd9fd653aabc9aeb44e00a23ae98292', '[\"*\"]', NULL, NULL, '2026-05-23 19:16:46', '2026-05-23 19:16:46'),
(141, 'App\\Models\\User', 27, 'auth_token', '66b6d9b0cee5af269ed413aa3b162546f9c253d81aa07229f80589943f9f787b', '[\"*\"]', '2026-05-24 02:04:33', NULL, '2026-05-24 01:07:08', '2026-05-24 02:04:33'),
(144, 'App\\Models\\User', 27, 'auth_token', 'a964cb3b135a5f498edc3ee2b2cc957b3f5ca58c6139da2f28b2962ccd765691', '[\"*\"]', '2026-05-24 02:04:08', NULL, '2026-05-24 01:44:14', '2026-05-24 02:04:08'),
(145, 'App\\Models\\User', 27, 'auth_token', 'c41f69c837b733846080671c8780d33b31bb5cfe218e5c89080c3f0f95c4dc1c', '[\"*\"]', NULL, NULL, '2026-05-24 03:14:37', '2026-05-24 03:14:37');

-- --------------------------------------------------------

--
-- Truncate table before insert `regions`
--

TRUNCATE TABLE `regions`;
--
-- إرجاع أو استيراد بيانات الجدول `regions`
--

INSERT INTO `regions` (`id`, `name`, `latitude`, `longitude`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Al-Mazzeh', 33.48915609, 36.39701882, '2026-05-07 07:54:27', '2026-05-07 07:54:27', NULL),
(2, 'Barzeh', 33.45469167, 36.29442968, '2026-05-07 07:54:27', '2026-05-07 07:54:27', NULL),
(3, 'Al-Maliki', 33.56204442, 36.39064434, '2026-05-07 07:54:27', '2026-05-07 07:54:27', NULL),
(4, 'Kafr Sousa', 33.58794297, 36.26239698, '2026-05-07 07:54:27', '2026-05-07 07:54:27', NULL),
(5, 'Al-Marjeh', 33.43800213, 36.19717196, '2026-05-07 07:54:27', '2026-05-07 07:54:27', NULL),
(6, 'Reggiestad', 33.44924319, 36.26343600, '2026-05-07 07:54:29', '2026-05-07 07:54:29', NULL),
(7, 'South Coreneport', 33.52371519, 36.37645544, '2026-05-07 07:54:29', '2026-05-07 07:54:29', NULL),
(8, 'O\'Reillyburgh', 33.50637847, 36.16728825, '2026-05-07 07:54:29', '2026-05-07 07:54:29', NULL),
(9, 'Marvinchester', 33.43641748, 36.20713535, '2026-05-07 07:54:29', '2026-05-07 07:54:29', NULL),
(10, 'New Blake', 33.50243730, 36.33585569, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(11, 'North Christelleland', 33.46385628, 36.18640436, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(12, 'West Anais', 33.59384289, 36.27667268, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(13, 'Port Lilian', 33.52570069, 36.21160551, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(14, 'Lake Jo', 33.44987719, 36.30368474, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(15, 'Lake Bartholome', 33.54397099, 36.20976066, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(16, 'Germainefort', 33.51600563, 36.27760446, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(17, 'Cummingsborough', 33.41068199, 36.20792454, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(18, 'East Candaceborough', 33.56994342, 36.37196476, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(19, 'Kaneview', 33.57632027, 36.20244689, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(20, 'Lake Justicefurt', 33.56431492, 36.26561533, '2026-05-07 07:54:30', '2026-05-07 07:54:30', NULL),
(21, 'Douglasview', 33.54426303, 36.35354051, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(22, 'East Ashleigh', 33.57663252, 36.31349494, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(23, 'Adamsberg', 33.43912897, 36.18524274, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(24, 'South Donna', 33.51189643, 36.16343091, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(25, 'Pfefferhaven', 33.44221596, 36.22310885, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(26, 'North Kali', 33.40782525, 36.24473753, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(27, 'Reillymouth', 33.52956244, 36.18075459, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(28, 'Dayneshire', 33.49006575, 36.29931008, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(29, 'East Marquisefurt', 33.49412657, 36.26142217, '2026-05-07 07:54:31', '2026-05-07 07:54:31', NULL),
(30, 'Fernefurt', 33.58160032, 36.30539639, '2026-05-07 07:54:32', '2026-05-07 07:54:32', NULL);

-- --------------------------------------------------------

--
-- Truncate table before insert `requests`
--

TRUNCATE TABLE `requests`;
--
-- إرجاع أو استيراد بيانات الجدول `requests`
--

INSERT INTO `requests` (`id`, `tenant_id`, `technician_id`, `service_id`, `address_id`, `status`, `title`, `description`, `scheduled_date`, `scheduled_time`, `estimated_price`, `estimate_note`, `final_price_syp`, `is_paid`, `paid_at`, `cancellation_reason`, `cancelled_at`, `estimated_at`, `confirmed_at`, `processing_at`, `final_approval_requested_at`, `additions_approved`, `completed_at`, `rejected_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 24, 1, 1, 'estimate_price', 'qui aspernatur illo', 'In voluptatum molestias in omnis ut sint accusamus eos reiciendis nemo excepturi.', '2026-05-10', '01:06:29', 186467, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:33', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(2, 12, 18, 3, 2, 'confirmed', 'voluptate praesentium est', 'Fugit alias consequuntur adipisci hic nihil animi error et.', '2026-05-09', '00:37:14', 156390, 'Porro omnis modi quia provident ad aspernatur ea quidem.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(3, 7, 18, 5, 3, 'completed', 'ratione ea aut', 'Quod quam perferendis ut id iure numquam neque perspiciatis esse minus est dolore voluptate nihil.', '2026-05-08', '01:48:48', 188464, NULL, 151779, 0, NULL, NULL, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33', '2026-05-07 07:54:33', NULL, 0, '2026-05-07 07:54:33', NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35'),
(4, 6, 24, 4, 4, 'processing', 'autem laboriosam consequuntur', 'Ut quae perspiciatis earum ducimus voluptas exercitationem et dolore laborum aut.', '2026-05-08', '20:58:33', 125785, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:33', '2026-05-07 07:54:33', '2026-05-07 07:54:33', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(5, 10, 24, 3, 5, 'confirmed', 'aliquam assumenda molestiae', 'Voluptate nulla distinctio ea debitis quo et eum ea est ullam consequatur iusto voluptas omnis.', '2026-05-10', '18:49:30', 237182, 'Mollitia maiores ipsam ut.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(6, 6, 22, 3, 4, 'confirmed', 'qui placeat et', 'Animi eius ut dolore minus voluptatem ex non sunt sit voluptatem omnis et.', '2026-05-09', '02:20:17', 231314, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(7, 13, 18, 3, 6, 'estimate_price', 'enim eveniet voluptas', 'Iure non et in harum et aut fugit necessitatibus ut tempore autem corporis facilis ut nobis et.', '2026-05-08', '08:26:53', 105232, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(8, 11, 20, 1, 7, 'estimate_price', 'adipisci quos aut', 'Occaecati velit velit veniam quis et possimus tenetur maiores corrupti.', '2026-05-09', '05:37:01', 254104, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(9, 9, 22, 2, 8, 'processing', 'officia odit natus', 'Dolorem nobis odit ex voluptas unde amet qui.', '2026-05-13', '12:12:34', 113698, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34', '2026-05-07 07:54:34', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(10, 8, 18, 3, 9, 'confirmed', 'quia veniam dolor', 'Excepturi porro officiis deleniti saepe non nulla eligendi et nobis minima.', '2026-05-11', '00:33:07', 150829, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:34', '2026-05-07 07:54:34', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(11, 16, 17, 5, 10, 'estimate_price', 'et id blanditiis', 'Et ipsa dolor aliquid explicabo excepturi ipsam esse voluptas et.', '2026-05-09', '13:08:54', 271879, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(12, 5, NULL, 5, 11, 'rejected', 'aut quidem veritatis', 'Sapiente iure ullam quae veniam eligendi molestias maxime qui tenetur dolor aut ipsam.', '2026-05-09', '12:34:26', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:35', NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(13, 5, 18, 4, 11, 'confirmed', 'modi itaque illo', 'Iure reiciendis corporis assumenda adipisci velit occaecati aut ipsa.', '2026-05-11', '08:50:06', 101446, 'Reprehenderit sed atque at.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(14, 15, 24, 1, 12, 'completed', 'id exercitationem cum', 'Ea rerum asperiores molestias mollitia ea enim et omnis atque modi.', '2026-05-09', '13:16:30', 129975, NULL, 115770, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, 0, '2026-05-07 07:54:35', NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(15, 8, NULL, 5, 9, 'cancelled', 'quo atque accusantium', 'Praesentium praesentium delectus est repudiandae expedita laboriosam est sit et qui.', '2026-05-10', '06:28:33', NULL, NULL, NULL, 0, NULL, 'Sit consequatur in quia reprehenderit non praesentium iste.', '2026-05-07 07:54:35', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(16, 8, NULL, 1, 9, 'rejected', 'inventore et praesentium', 'Minus expedita velit libero perferendis aut rerum magnam blanditiis a ex in veritatis rem saepe.', '2026-05-10', '03:33:39', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:35', NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(17, 2, 17, 2, 1, 'estimate_price', 'in quis voluptatem', 'Aspernatur cupiditate perferendis est ad nesciunt voluptate ut vel vero rerum.', '2026-05-12', '11:16:00', 139529, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(18, 12, NULL, 1, 2, 'cancelled', 'recusandae dolorem quis', 'Reiciendis quis et impedit consequatur culpa magnam corrupti veritatis ipsam omnis eos in ut ut.', '2026-05-10', '10:21:00', NULL, NULL, NULL, 0, NULL, 'Minima minima quisquam qui qui et esse amet eius.', '2026-05-07 07:54:35', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(19, 11, 21, 4, 7, 'estimate_price', 'voluptatem neque aut', 'Libero modi libero inventore eius et expedita modi voluptatem consequuntur beatae culpa dolorem aut est.', '2026-05-10', '06:17:37', 143455, 'Recusandae vero commodi voluptatum.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(20, 14, 24, 2, 13, 'processing', 'sunt voluptas ratione', 'Excepturi fugit ut et eveniet alias ullam veritatis in et corrupti excepturi vel.', '2026-05-13', '19:42:00', 179968, 'Quos perspiciatis perferendis nemo tempore aut cum officiis ut.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:36'),
(21, 10, 18, 5, 5, 'awaiting_final_approval', 'assumenda libero maxime', 'Qui ut harum aut nemo ut fugiat at optio perferendis assumenda maiores voluptates sed maxime est aliquam.', '2026-05-07', '07:04:46', 164443, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:52', 0, NULL, NULL, NULL, '2026-05-07 07:54:36', '2026-05-07 07:54:52'),
(22, 16, 25, 4, 10, 'awaiting_final_approval', 'voluptatem vel ut', 'Adipisci aut suscipit molestias beatae eaque et possimus sint qui et.', '2026-05-11', '23:52:10', 240752, 'Autem error non magni ut qui.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:53'),
(23, 5, NULL, 2, 11, 'pending', 'consequuntur nobis suscipit', 'Aut soluta ut quibusdam natus corporis eos amet molestiae explicabo voluptatem libero omnis exercitationem atque labore.', '2026-05-08', '00:59:52', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(24, 11, 23, 4, 7, 'awaiting_final_approval', 'dolorem dolorem sint', 'Et consequuntur suscipit neque ex rerum et quas.', '2026-05-11', '12:43:18', 107298, 'Consequatur vel suscipit non reprehenderit magni consectetur.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:53'),
(25, 5, 21, 2, 11, 'completed', 'exercitationem eligendi facilis', 'Omnis debitis quod aperiam dignissimos sunt magni odio dolorum nemo aliquid.', '2026-05-08', '17:51:42', 294789, NULL, 267150, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, 0, '2026-05-07 07:54:35', NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(26, 2, 22, 5, 1, 'awaiting_final_approval', 'nulla temporibus et', 'Eum est praesentium ea quo et consequatur voluptatem nisi facere sunt eligendi non iure hic ut.', '2026-05-07', '11:20:16', 62074, 'Iure nesciunt blanditiis numquam cupiditate tenetur.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:53'),
(27, 10, NULL, 5, 5, 'cancelled', 'ipsam sit eos', 'Rerum autem temporibus et sint cum id quis autem.', '2026-05-10', '06:01:56', NULL, NULL, NULL, 0, NULL, 'Cumque voluptatem qui ad ut.', '2026-05-07 07:54:35', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(28, 9, 19, 3, 8, 'completed', 'eaque eius dolorum', 'Praesentium eos debitis eveniet labore dolor aut et in.', '2026-05-12', '07:49:28', 191140, NULL, 165440, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, 0, '2026-05-07 07:54:35', NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(29, 14, NULL, 3, 13, 'rejected', 'repudiandae minus dolore', 'Sint dicta illum nostrum quibusdam similique rem ratione corporis officia molestiae fugit sequi quia est.', '2026-05-09', '12:16:30', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:35', NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(30, 15, 20, 5, 12, 'confirmed', 'ex voluptatibus ut', 'Omnis vitae excepturi quo officiis voluptate sit expedita ratione temporibus quae necessitatibus voluptas enim ullam.', '2026-05-12', '10:01:20', 184274, 'Impedit aliquid magni deleniti omnis ipsam maxime.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:35', '2026-05-07 07:54:35', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:37', '2026-05-07 07:54:37'),
(31, 11, NULL, 2, 7, 'rejected', 'totam est laboriosam', 'Et quas sed praesentium quo sit consequatur sunt rerum aspernatur maxime et impedit neque omnis nam.', '2026-05-08', '10:13:45', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:38', NULL, '2026-05-07 07:54:38', '2026-05-07 07:54:38'),
(32, 5, 22, 5, 11, 'awaiting_final_approval', 'voluptas corrupti aspernatur', 'Minima at delectus vel rem officia delectus nihil.', '2026-05-07', '04:58:24', 169568, 'Est eos totam vel et occaecati.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:38', '2026-05-07 07:54:38', '2026-05-07 07:54:38', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:38', '2026-05-07 07:54:53'),
(33, 11, 23, 3, 7, 'estimate_price', 'dolor sed corporis', 'Repellat et a est suscipit aliquid accusantium incidunt est blanditiis omnis sunt rerum expedita qui.', '2026-05-07', '02:12:42', 90969, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:38', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:38', '2026-05-07 07:54:38'),
(34, 6, NULL, 2, 4, 'cancelled', 'consequatur voluptates nulla', 'Maiores sint ea iure accusamus nesciunt voluptas odit voluptatum.', '2026-05-08', '21:17:38', NULL, NULL, NULL, 0, NULL, 'Omnis neque culpa in dolorem.', '2026-05-07 07:54:39', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(35, 16, NULL, 2, 10, 'rejected', 'modi voluptatem tempore', 'Neque eaque sunt eveniet qui sit et molestiae dolorem.', '2026-05-10', '00:21:01', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:39', NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(36, 3, NULL, 3, 14, 'pending', 'aut cum aliquam', 'Sed sint omnis nulla aperiam porro rerum vel ipsam libero eum.', '2026-05-10', '20:36:26', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(37, 13, NULL, 1, 6, 'rejected', 'facilis nemo ratione', 'Eveniet qui quasi delectus suscipit autem minima natus id similique totam et adipisci neque ut.', '2026-05-12', '12:31:02', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:39', NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(38, 14, NULL, 1, 13, 'pending', 'rem animi exercitationem', 'Minus ea magni voluptatem eaque voluptatem et occaecati et perferendis eius dolorem minus dolorem asperiores.', '2026-05-11', '15:02:42', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:39', '2026-05-07 07:54:39'),
(39, 2, 18, 5, 1, 'completed', 'et totam voluptate', 'Doloremque quod eligendi recusandae at ipsum recusandae vel est itaque blanditiis ullam eos et iste cupiditate at.', '2026-05-12', '00:39:59', 215853, 'Eius ea sit rerum sit autem porro ullam.', 180629, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:40', NULL, 0, '2026-05-07 07:54:40', NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40'),
(40, 10, 21, 4, 5, 'awaiting_final_approval', 'quo laudantium consequuntur', 'Sed et sunt voluptas natus cumque non autem consectetur voluptate sed voluptatem.', '2026-05-11', '06:17:42', 274783, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:53'),
(41, 16, NULL, 3, 10, 'rejected', 'molestiae dolorem delectus', 'Et repellat repudiandae ipsa minima culpa dolor in consectetur ipsam ea nobis voluptas velit.', '2026-05-07', '12:12:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:40', NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40'),
(42, 13, 24, 4, 6, 'processing', 'alias adipisci et', 'Molestiae sit consequuntur non eum non sit laboriosam dolores a.', '2026-05-12', '04:52:01', 215218, 'Nihil atque officia autem voluptate officiis reprehenderit officia.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:40', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40'),
(43, 7, 18, 5, 3, 'completed', 'fugit quidem dolor', 'Praesentium facere adipisci distinctio nihil facilis ut eum.', '2026-05-08', '11:56:16', 228871, NULL, 224771, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:40', NULL, 0, '2026-05-07 07:54:40', NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40'),
(44, 5, 19, 4, 11, 'processing', 'impedit autem non', 'Molestiae aut quidem consequatur earum esse et quo sunt qui omnis nostrum sequi officiis iure.', '2026-05-11', '20:45:47', 111378, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40', '2026-05-07 07:54:40', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:40', '2026-05-07 07:54:40'),
(45, 12, NULL, 3, 2, 'rejected', 'voluptas ipsam soluta', 'Molestiae in officia quis doloremque sint modi rerum ipsam et voluptatem est.', '2026-05-13', '20:02:51', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:41', NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41'),
(46, 6, 19, 5, 4, 'awaiting_final_approval', 'nobis quia error', 'Minus minima sequi voluptatem eaque quis ad ab perferendis accusantium explicabo et odio ut ut praesentium.', '2026-05-08', '15:51:11', 271647, 'Quae error nulla hic et culpa.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41', '2026-05-07 07:54:41', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:53'),
(47, 12, 25, 1, 2, 'completed', 'dignissimos sint aliquam', 'Nesciunt id quas ratione odio nihil ut repudiandae ad ex molestias hic magnam reiciendis consequatur.', '2026-05-12', '06:55:53', 137436, 'Omnis minus aut aut perferendis soluta.', 123171, 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41', '2026-05-07 07:54:41', NULL, 0, '2026-05-07 07:54:41', NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41'),
(48, 3, NULL, 3, 14, 'pending', 'consequatur ut omnis', 'Odio et qui quia et id sit et voluptatem perspiciatis maiores inventore.', '2026-05-10', '19:13:27', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41'),
(49, 16, 25, 5, 10, 'awaiting_final_approval', 'dolores voluptatem vero', 'Quia voluptas minus est laborum ut autem velit voluptatem.', '2026-05-10', '13:51:45', 153922, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:41', '2026-05-07 07:54:41', '2026-05-07 07:54:53', 0, NULL, NULL, NULL, '2026-05-07 07:54:41', '2026-05-07 07:54:53'),
(50, 2, NULL, 4, 1, 'cancelled', 'quis esse qui', 'Consectetur iusto voluptatem harum laborum eum alias illo delectus voluptatem.', '2026-05-11', '22:33:03', NULL, NULL, NULL, 0, NULL, 'Ipsa omnis dolorem ea rerum.', '2026-05-07 07:54:42', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42'),
(51, 10, 23, 5, 5, 'completed', 'totam est quia', 'Unde autem doloribus aspernatur autem qui ipsa ipsam reprehenderit soluta ipsam qui.', '2026-05-13', '08:58:03', 97161, NULL, 85208, 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42', '2026-05-07 07:54:42', NULL, 0, '2026-05-07 07:54:42', NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42'),
(52, 5, 23, 2, 11, 'awaiting_final_approval', 'rem quia consequatur', 'Quae maxime eaque alias rerum velit nihil corrupti hic.', '2026-05-11', '17:46:00', 178065, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42', '2026-05-07 07:54:42', '2026-05-07 07:54:54', 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:54'),
(53, 6, NULL, 3, 4, 'cancelled', 'aut molestias velit', 'Quia sunt et ullam earum beatae non eveniet dolorem consequatur.', '2026-05-12', '01:26:55', NULL, NULL, NULL, 0, NULL, 'Nihil aut error quis distinctio voluptatem sed.', '2026-05-07 07:54:42', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42'),
(54, 7, NULL, 1, 3, 'cancelled', 'repellat corporis numquam', 'Optio veritatis autem eius qui quisquam velit sint ad qui et qui rerum occaecati sed voluptas quidem.', '2026-05-09', '05:01:44', NULL, NULL, NULL, 0, NULL, 'Omnis consequatur perferendis facere veniam quia est.', '2026-05-07 07:54:42', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:42', '2026-05-07 07:54:42'),
(55, 16, NULL, 1, 10, 'pending', 'adipisci quia voluptatem', 'Qui asperiores voluptas illo reiciendis aut voluptatem debitis.', '2026-05-12', '00:54:22', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43'),
(56, 3, 21, 3, 14, 'completed', 'quis tenetur et', 'Tempora qui error enim consectetur recusandae animi exercitationem.', '2026-05-07', '21:07:29', 286707, 'Placeat vitae molestias laudantium aut quo.', 250209, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43', '2026-05-07 07:54:43', NULL, 0, '2026-05-07 07:54:43', NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43'),
(57, 5, 18, 4, 11, 'completed', 'saepe sed enim', 'Quibusdam molestiae qui iure vel nihil quaerat et dolorum odit ex.', '2026-05-13', '11:02:53', 271266, 'Velit adipisci architecto est molestiae deserunt voluptas mollitia.', 255938, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43', '2026-05-07 07:54:43', NULL, 0, '2026-05-07 07:54:43', NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43'),
(58, 5, NULL, 1, 11, 'pending', 'molestiae alias ut', 'Molestias corrupti commodi doloribus voluptatum aliquam aut laudantium.', '2026-05-07', '15:55:15', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43'),
(59, 6, 24, 1, 4, 'processing', 'iure dolorum inventore', 'In omnis voluptatem praesentium laboriosam eius et et corrupti ipsa repellendus animi et rem molestiae similique.', '2026-05-13', '20:05:22', 120016, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43', '2026-05-07 07:54:43', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:43', '2026-05-07 07:54:43'),
(60, 7, NULL, 5, 3, 'rejected', 'vero non vero', 'Quia dolores voluptas saepe sed quam ut nihil asperiores voluptatem minus aut dolor dolor nemo.', '2026-05-08', '19:21:40', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:44', NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44'),
(61, 2, NULL, 3, 1, 'rejected', 'est mollitia voluptate', 'Magnam nihil doloremque non odit numquam dignissimos assumenda animi sed.', '2026-05-08', '14:10:59', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-07 07:54:44', NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44'),
(62, 11, 17, 3, 7, 'completed', 'molestias enim consequatur', 'Nihil perferendis dolorum quia est voluptatem explicabo delectus nostrum rem magnam maiores et possimus rem.', '2026-05-09', '14:37:32', 238988, 'Tempora impedit qui est voluptatem expedita dignissimos sequi dolore.', 216529, 0, NULL, NULL, NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44', '2026-05-07 07:54:44', NULL, 0, '2026-05-07 07:54:44', NULL, NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44'),
(63, 12, 26, 3, 2, 'processing', 'reiciendis error dolor', 'Vero enim itaque sed sed ullam eum eum nobis molestiae et rerum.', '2026-05-10', '23:59:24', 55801, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44', '2026-05-07 07:54:44', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:44', '2026-05-07 07:54:44'),
(64, 15, 21, 5, 12, 'completed', 'voluptatem pariatur illo', 'Quo id explicabo est voluptatem autem totam velit est vel non eum quod.', '2026-05-13', '08:57:17', 89527, NULL, 88998, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45', '2026-05-07 07:54:45', NULL, 0, '2026-05-07 07:54:45', NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(65, 15, 26, 4, 12, 'completed', 'sit sed accusamus', 'Doloribus omnis numquam praesentium est non quam non beatae error magnam numquam quasi pariatur aut et corrupti.', '2026-05-10', '23:43:43', 189452, NULL, 154601, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45', '2026-05-07 07:54:45', NULL, 0, '2026-05-07 07:54:45', NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(66, 6, 19, 3, 4, 'confirmed', 'corporis qui dolor', 'Maxime accusantium error consequatur occaecati recusandae rem magnam voluptate a asperiores alias quos facere magnam qui.', '2026-05-13', '06:51:14', 134693, 'Repellendus quo voluptatem aut est vitae tempora est veniam.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(67, 14, 28, 3, 13, 'estimate_price', 'asperiores neque ut', 'Aperiam laboriosam qui et esse architecto vel et nostrum excepturi illum totam pariatur quasi voluptas eligendi.', '2026-05-09', '18:38:59', 666, 'غغغ', NULL, 0, NULL, NULL, NULL, '2026-05-07 11:13:05', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 11:13:05'),
(68, 4, NULL, 1, 15, 'pending', 'hic itaque incidunt', 'Sunt doloremque possimus at odio et et quis sequi est eaque eaque quod sunt.', '2026-05-12', '21:42:08', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(69, 11, 17, 4, 7, 'estimate_price', 'quis quidem quia', 'Aut ut est blanditiis nisi aliquam minus sit iste suscipit perspiciatis ea animi reprehenderit sapiente.', '2026-05-08', '17:47:32', 198681, 'Quia eum cumque ut aliquid eum libero aut quia.', NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:45', '2026-05-07 07:54:45'),
(70, 12, 23, 2, 2, 'awaiting_final_approval', 'dicta nesciunt et', 'Quas saepe quis dolores ex blanditiis voluptatibus pariatur impedit.', '2026-05-09', '02:13:15', 247687, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:46', '2026-05-07 07:54:46', '2026-05-07 07:54:54', 0, NULL, NULL, NULL, '2026-05-07 07:54:46', '2026-05-07 07:54:54'),
(71, 27, 28, 1, 60, 'confirmed', 'تيست حالات', 'بلل', '2026-05-18', '19:30:00', 5555, 'ااا', NULL, 0, NULL, NULL, NULL, '2026-05-07 11:07:53', '2026-05-07 11:13:59', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 08:50:38', '2026-05-07 11:13:59'),
(72, 27, 28, 1, 60, 'confirmed', 'تيست اشعار', 'تتتا', '2026-05-21', '16:30:00', 50000, 'شغال؟', NULL, 0, NULL, NULL, NULL, '2026-05-07 11:15:30', '2026-05-07 11:16:12', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 11:13:50', '2026-05-07 11:16:12'),
(78, 27, NULL, 1, 61, 'pending', 'ااا', 'اغ', '2026-05-21', '16:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-07 12:13:36', '2026-05-07 17:55:23', '2026-05-07 12:13:36'),
(82, 27, NULL, 1, 1, 'pending', 'تيست صورة', 'تيت', '2026-05-25', '17:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-14 15:15:28', '2026-05-07 08:06:07', '2026-05-14 15:15:28'),
(83, 27, NULL, 1, 61, 'pending', 'مشكلة في نظام التدفئة المركزية للمنزل', 'لا يعمل نظام التدفئة المركزية بالمنزل بشكل صحيح ', '2026-05-15', '17:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-07 08:08:23', '2026-05-07 08:08:23'),
(84, 27, NULL, 1, 61, 'pending', 'تيست صورةةةة', 'تهه', '2026-05-29', '15:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-18 13:13:48', '2026-05-07 08:19:42', '2026-05-18 13:13:48'),
(85, 27, NULL, 1, 61, 'pending', 'صورة مع مع', 'تات', '2026-05-15', '15:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-18 13:13:53', '2026-05-07 08:27:10', '2026-05-18 13:13:53'),
(86, 27, NULL, 1, 61, 'pending', 'صور كلاود', 'تع', '2026-05-21', '15:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-14 15:15:26', '2026-05-07 08:35:05', '2026-05-14 15:15:26'),
(87, 27, 30, 1, 61, 'rejected', 'ككمكم', 'عع', '2026-05-07', '16:30:00', 25000, '567', NULL, 0, NULL, NULL, NULL, '2026-05-07 14:23:12', NULL, NULL, NULL, 0, NULL, '2026-05-14 15:12:57', NULL, '2026-05-07 08:39:10', '2026-05-14 15:12:57'),
(88, 27, 28, 1, 61, 'cancelled', 'صورة صورة صورة 📷', 'تيتي', '2026-05-17', '16:30:00', 50000, 'غا', NULL, 0, NULL, 'Final approval rejected by tenant', '2026-05-14 15:12:44', '2026-05-07 09:08:44', '2026-05-07 09:09:15', '2026-05-07 09:09:35', '2026-05-07 09:09:51', 0, NULL, NULL, NULL, '2026-05-07 08:48:04', '2026-05-14 15:12:44'),
(89, 27, NULL, 1, 60, 'pending', 'عطل في براد القهوة — الماء الساخن لا يعمل', 'يوجد مشكلة في براد القهوة، حيث أن الماء الساخن لا ينزل نهائيًا عند الاستخدام. تم التأكد من تشغيل الجهاز لكن وظيفة تسخين/ضخ الماء الساخن لا تعمل. يرجى الفحص والصيانة بأقرب وقت ممكن.', '2026-05-08', '16:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-18 13:13:35', '2026-05-07 12:07:33', '2026-05-18 13:13:35'),
(91, 27, 30, 1, 61, 'pending', 'عطل في براد القهوة — الماء الساخن لا يعمل', 'يوجد مشكلة في براد القهوة، حيث أن الماء الساخن لا ينزل نهائيًا عند الاستخدام. تم التأكد من تشغيل الجهاز لكن وظيفة تسخين/ضخ الماء الساخن لا تعمل. يرجى الفحص والصيانة بأقرب وقت ممكن.', '2026-05-30', '14:30:00', NULL, 'المشكلة من مواسير الماء الساخن', NULL, 0, NULL, NULL, NULL, '2026-05-07 13:36:29', '2026-05-07 14:38:09', '2026-05-07 14:38:38', '2026-05-14 15:05:35', 1, '2026-05-23 23:38:43', NULL, NULL, '2026-05-07 12:30:37', '2026-05-24 00:32:00'),
(94, 27, 30, 1, 62, 'awaiting_final_approval', 'تيست رفض طلب واضافات', '...', '2026-05-28', '16:30:00', 1000, 'تمام', NULL, 0, NULL, NULL, NULL, '2026-05-18 13:06:46', '2026-05-18 13:08:19', '2026-05-18 13:08:47', '2026-05-18 13:09:18', 0, NULL, NULL, '2026-05-18 13:09:52', '2026-05-18 13:05:51', '2026-05-18 13:09:52'),
(105, 27, 30, 1, 60, 'completed', 'عطل في جهاز منظم الكهرباء / مثبت الجهد', 'الجهاز لا يعمل بشكل طبيعي ويوجد خلل داخلي ظاهر في التوصيلات والمكونات. تم إرفاق صور توضح حالة الجهاز من الداخل. نحتاج إلى فحص وصيانة عاجلة للتأكد من سلامة التشغيل وإصلاح العطل.', '2026-07-11', '13:00:00', 2500, 'عطل في الكرت الإلكتروني (البورد) داخل المنظم.', 3500, 0, '2026-05-24 00:51:33', NULL, NULL, '2026-05-24 00:42:16', '2026-05-24 00:43:21', '2026-05-24 00:44:27', '2026-05-24 01:03:48', 1, '2026-05-24 01:05:38', NULL, NULL, '2026-05-24 00:10:48', '2026-05-24 01:05:38'),
(106, 27, NULL, 1, 62, 'pending', 'مشكلة في نظام التدفئة المركزية للمنزل', 'يوجد عطل في نظام التدفئة المركزية بالمنزل، حيث لا يعمل بشكل صحيح وتظهر مشكلة في الجهاز أو التوصيلات الداخلية. تم إرفاق صور توضح حالة النظام نحتاج إلى فحص وصيانة لحل المشكلة وإعادة التدفئة للعمل بشكل طبيعي.', '2026-09-16', '16:30:00', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2026-05-24 00:38:16', '2026-05-24 00:38:16');

-- --------------------------------------------------------

--
-- Truncate table before insert `request_additions`
--

TRUNCATE TABLE `request_additions`;
--
-- إرجاع أو استيراد بيانات الجدول `request_additions`
--

INSERT INTO `request_additions` (`id`, `request_id`, `name`, `price_syp`, `created_at`, `updated_at`) VALUES
(1, 21, 'Sealant material', 21268, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(2, 22, 'Wiring accessory', 39628, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(3, 22, 'Extra labor', 20417, '2026-05-07 07:54:52', '2026-05-07 07:54:52'),
(4, 24, 'Extra labor', 40649, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(5, 24, 'Extra labor', 26277, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(6, 26, 'Extra labor', 39120, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(7, 26, 'Valve replacement', 23444, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(8, 26, 'Extra labor', 29039, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(9, 32, 'Pipe replacement', 18019, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(10, 32, 'Wiring accessory', 44135, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(11, 32, 'Wiring accessory', 18639, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(12, 40, 'Extra labor', 19475, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(13, 40, 'Pipe replacement', 47804, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(14, 46, 'Extra labor', 28004, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(15, 49, 'Pipe replacement', 43365, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(16, 49, 'Sealant material', 38247, '2026-05-07 07:54:53', '2026-05-07 07:54:53'),
(17, 52, 'Sealant material', 23746, '2026-05-07 07:54:54', '2026-05-07 07:54:54'),
(18, 70, 'Sealant material', 44398, '2026-05-07 07:54:54', '2026-05-07 07:54:54'),
(19, 70, 'Pipe replacement', 21948, '2026-05-07 07:54:54', '2026-05-07 07:54:54'),
(20, 70, 'Valve replacement', 26510, '2026-05-07 07:54:54', '2026-05-07 07:54:54'),
(22, 88, 'بربيش', 2500, '2026-05-07 09:09:51', '2026-05-07 09:09:51'),
(23, 88, 'جلدة', 5000, '2026-05-07 09:09:51', '2026-05-07 09:09:51'),
(27, 94, 'رقم جديد', 1000, '2026-05-18 13:09:18', '2026-05-18 13:09:18'),
(28, 94, 'علبة محارم', 1000, '2026-05-18 13:09:18', '2026-05-18 13:09:18'),
(29, 105, 'استبدال المكثفات التالفة (Capacitors) داخل البورد الإلكترونيلتحسين استقرار عمل المنظم.', 500, '2026-05-24 01:03:48', '2026-05-24 01:03:48'),
(30, 105, 'تغيير الريليه أو الفيوز المحترق في الكرت الإلكتروني لضمان عودة الجهاز للعمل بشكل طبيعي', 500, '2026-05-24 01:03:48', '2026-05-24 01:03:48');

-- --------------------------------------------------------

--
-- Truncate table before insert `services`
--

TRUNCATE TABLE `services`;
--
-- إرجاع أو استيراد بيانات الجدول `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `min_price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'السباكة', '', 50.00, NULL, '2026-05-07 07:54:27', '2026-05-07 07:54:27'),
(2, 'الكهرباء', '', 50.00, NULL, '2026-05-07 07:54:27', '2026-05-07 07:54:27'),
(3, 'النجارة', '', 50.00, NULL, '2026-05-07 07:54:28', '2026-05-07 07:54:28'),
(4, 'الدهان', '', 50.00, NULL, '2026-05-07 07:54:28', '2026-05-07 07:54:28'),
(5, 'التكييف والتهوية', '', 50.00, NULL, '2026-05-07 07:54:28', '2026-05-07 07:54:28');

-- --------------------------------------------------------

--
-- Truncate table before insert `sessions`
--

--
-- إرجاع أو استيراد بيانات الجدول `technician_details`
--

INSERT INTO `technician_details` (`id`, `user_id`, `service_id`, `years_of_experience`, `skills_description`, `max_distance_km`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 17, 2, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(2, 18, 4, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(3, 19, 5, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(4, 20, 3, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(5, 21, 3, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(6, 22, 1, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(7, 23, 5, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(8, 24, 3, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(9, 25, 1, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(10, 26, 5, 3, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(11, 30, 1, 5, 'IT Manager', 100, NULL, '2026-05-07 11:46:49', '2026-05-24 00:32:42');

-- --------------------------------------------------------

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `address`, `region_id`, `is_active`, `remember_token`, `fcm_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '0999999999', NULL, '$2y$12$SLVe6R4QYbYQHpPkywQBIegbWOedtMXa80y59w2jxhRgjDLQlAbI2', 'admin', NULL, 1, 1, NULL, NULL, NULL, '2026-05-07 07:54:29', '2026-05-07 07:54:29'),
(2, 'Dr. Ewald Hansen DDS', 'gemmerich@example.com', '0996589077', '2026-05-07 07:54:29', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '48600 Steuber Motorway', 6, 1, NULL, NULL, NULL, '2026-05-07 07:54:30', '2026-05-07 07:54:30'),
(3, 'Buster O\'Conner', 'sschoen@example.org', '0997820793', '2026-05-07 07:54:29', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '953 Eunice Centers', 7, 1, NULL, NULL, NULL, '2026-05-07 07:54:30', '2026-05-07 07:54:30'),
(4, 'Clarabelle Raynor PhD', 'rutherford.samanta@example.org', '0990718001', '2026-05-07 07:54:29', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', NULL, 8, 1, NULL, NULL, NULL, '2026-05-07 07:54:30', '2026-05-07 07:54:30'),
(5, 'Raquel Conroy', 'eloy55@example.org', '0950880648', '2026-05-07 07:54:29', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '74933 Skyla Islands', 9, 1, NULL, NULL, NULL, '2026-05-07 07:54:30', '2026-05-07 07:54:30'),
(6, 'Dr. Hershel Mann I', 'amara24@example.org', '0916622889', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', NULL, 10, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(7, 'Mrs. Joelle Glover DVM', 'murray.opal@example.com', '0979690126', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '76442 Hegmann Rapids Suite 990', 11, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(8, 'Prof. Cecil Jenkins MD', 'jack94@example.com', '0999020741', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', NULL, 12, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(9, 'John Schamberger III', 'vmetz@example.org', '0911341718', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', NULL, 13, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(10, 'Guido Gislason', 'lebsack.hudson@example.com', '0995409021', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '78893 Laverna Plaza', 14, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(11, 'Alycia Jenkins Jr.', 'billie.morar@example.com', '0995884182', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '29313 Kyla Mountain Suite 866', 15, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(12, 'Veronica Veum', 'walker.ariane@example.net', '0921128315', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '4898 Orval Passage', 16, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(13, 'Edwin Stroman', 'vickie61@example.com', '0945930606', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', NULL, 17, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(14, 'Dr. Mariane Reichert Sr.', 'carmela98@example.org', '0999150407', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '49993 Darrick Spur', 18, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(15, 'Dario Strosin V', 'amelie.leuschke@example.org', '0911410874', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '30593 Hammes Roads Apt. 152', 19, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(16, 'Mr. Austen Gulgowski I', 'wcrist@example.net', '0941828104', '2026-05-07 07:54:30', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'tenant', '68943 Gislason Union Suite 460', 20, 1, NULL, NULL, NULL, '2026-05-07 07:54:31', '2026-05-07 07:54:31'),
(17, 'Yolanda Macejkovic', 'rosalinda54@example.com', '0984664544', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', NULL, 21, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(18, 'Brice Crona', 'ressie.beatty@example.org', '0932227185', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', NULL, 22, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(19, 'Kevin O\'Connell', 'qcummings@example.net', '0993450863', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', NULL, 23, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(20, 'Katelynn Gottlieb DDS', 'felicita.runte@example.net', '0951801981', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', '425 Casper Cape Suite 058', 24, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(21, 'Katrine Zemlak', 'ezekiel.batz@example.org', '0992697942', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', NULL, 25, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(22, 'Luther Abbott', 'britney38@example.org', '0993458217', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', '65790 Cortney Meadow Suite 360', 26, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(23, 'Al Jaskolski Jr.', 'lia.schmeler@example.org', '0921182672', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', NULL, 27, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(24, 'Adrain Lynch', 'bernhard.margot@example.com', '0991676922', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', '34751 Emerson Square Suite 836', 28, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(25, 'Braxton Thompson', 'hcremin@example.net', '0953847713', '2026-05-07 07:54:31', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', '69095 Smitham Junctions', 29, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(26, 'Reagan Parker', 'streich.adrian@example.org', '0921500886', '2026-05-07 07:54:32', '$2y$12$rIRArSdxXx2w4Md/0UCSWO0WoRyJDdqNtV3Kw/awcBfAC7YVaMwNK', 'technician', '595 Neoma Islands Apt. 966', 30, 1, NULL, NULL, NULL, '2026-05-07 07:54:32', '2026-05-07 07:54:32'),
(27, 'abd tenant', 'aaaa@gmail.com', '0964360686', NULL, '$2y$12$FffbZkmzp4wmsusfEnK1qeiehv9dMfjepfL1T29kMuewD14cnasx.', 'tenant', NULL, NULL, 1, NULL, 'csOgeRt8RdEdpcCLRjigEj:APA91bH_CNugOZlxYuEPPfLSvrTUfr9v6RDu0k6Z7HC3h5-gpkc-6TbxEWM5sdAgpRusJyh-MwHq8SxxHbpBTGU-m90xVpiRaZkoUfLxzLSnclSszY1g0ME', NULL, '2026-05-07 08:18:05', '2026-05-23 01:51:11'),
(28, 'shsh provider', 'aa45aa@gmail.com', '0999606627', NULL, '$2y$12$Mylv7gWTKrsAbqVAiCsOO.ldcsu9t9e3gmXJnSAx67FpXdRLoNaLG', 'technician', NULL, NULL, 1, NULL, 'dp80gQgER-ebIMWvPjLGu4:APA91bH7cS9kYUVxexXyHgcjCdS8pHkCRFOfU1FoRhmxLLwLmYVsdaDyjzrIexdaD7RU8BW_qAIQFgRDjWUY934x1v3NvinHUWMKxL16CONih0DQ39VLLpk', NULL, '2026-05-07 08:19:51', '2026-05-07 17:29:01'),
(30, 'عبد الرحمن العمري', 'abdulrahmanit@gmail.com', '09999606627', NULL, '$2y$12$Cq3CRI/wu8/sLoiEpLjP1elQiyTjDVhwENBwZ1xWoGHhMYGe4iIae', 'technician', 'Damascus', 1, 1, NULL, 'csOgeRt8RdEdpcCLRjigEj:APA91bH_CNugOZlxYuEPPfLSvrTUfr9v6RDu0k6Z7HC3h5-gpkc-6TbxEWM5sdAgpRusJyh-MwHq8SxxHbpBTGU-m90xVpiRaZkoUfLxzLSnclSszY1g0ME', NULL, '2026-05-07 11:46:49', '2026-05-23 01:49:00'),
(31, 'Admin', 'admin@admin.com', '0000000000', NULL, '$2y$12$5wSPlfpjQ4DJ5u7lE/O1yef/geWyBgdicmsKKsBYdEEoxaRlDWQnS', 'admin', NULL, NULL, 1, 'Rq5ETZ7Gh1DKG0PYDOvagsjkK4bdvbHhy0FvwbB9hKoDUniyGkn815tAXMnl', NULL, NULL, '2026-05-23 03:00:11', '2026-05-23 03:11:42'),
(32, 'abdh tenandt', 'aaada@gmail.com', '09643606486', NULL, '$2y$12$LAvuV00VoKsW4vR0mo3OvuvsnOzrqvryNaKhVq5bHCcapxxnmpPtG', 'tenant', NULL, NULL, 1, NULL, NULL, NULL, '2026-05-24 00:22:29', '2026-05-24 00:22:29');

-- --------------------------------------------------------

--
-- Truncate table before insert `wallets`
--

TRUNCATE TABLE `wallets`;
--
-- إرجاع أو استيراد بيانات الجدول `wallets`
--

INSERT INTO `wallets` (`id`, `technician_id`, `balance`, `currency`, `created_at`, `updated_at`) VALUES
(1, 30, 125000, 'SYP', '2026-05-23 00:12:30', '2026-05-23 17:41:09'),
(2, 28, 225000, 'SYP', '2026-05-23 15:56:02', '2026-05-23 15:56:02');

-- --------------------------------------------------------

--
-- Truncate table before insert `wallet_transactions`
--

TRUNCATE TABLE `wallet_transactions`;
--
-- إرجاع أو استيراد بيانات الجدول `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `wallet_id`, `amount`, `type`, `status`, `request_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1000, 'credit', 'completed', NULL, 'Payment for request #95', '2026-05-23 00:12:30', '2026-05-23 00:12:30'),
(2, 1, 75000, 'credit', 'completed', NULL, 'Payment for request #100', '2026-05-23 02:37:08', '2026-05-23 02:37:08'),
(3, 1, 5000, 'debit', 'completed', NULL, 'سحب رصيد شخصي', '2026-05-23 15:48:47', '2026-05-23 15:48:47'),
(4, 1, 5000, 'credit', 'completed', NULL, 'حوافز', '2026-05-23 15:50:30', '2026-05-23 15:50:30'),
(5, 1, 10000, 'debit', 'completed', NULL, 'مصروف شخصي', '2026-05-23 15:53:50', '2026-05-23 15:53:50'),
(6, 1, 15000, 'debit', 'completed', NULL, 'Withdrawal request #1 approved', '2026-05-23 16:58:29', '2026-05-23 16:58:29'),
(7, 1, 31000, 'debit', 'completed', NULL, 'Withdrawal request #2 approved', '2026-05-23 17:01:54', '2026-05-23 17:01:54'),
(8, 1, 5000, 'credit', 'completed', NULL, 'سرعة بالعمل والاداء', '2026-05-23 17:03:39', '2026-05-23 17:03:39'),
(9, 1, 100000, 'credit', 'completed', NULL, 'مكافئة مالية', '2026-05-23 17:41:09', '2026-05-23 17:41:09');

-- --------------------------------------------------------

--
-- Truncate table before insert `withdrawal_requests`
--

TRUNCATE TABLE `withdrawal_requests`;
--
-- إرجاع أو استيراد بيانات الجدول `withdrawal_requests`
--

INSERT INTO `withdrawal_requests` (`id`, `technician_id`, `wallet_id`, `amount`, `branch`, `governorate`, `receiver_full_name`, `receiver_phone`, `note`, `status`, `rejection_reason`, `reviewed_at`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(3, 30, 1, 25000, 'alharam', 'damascus', 'عبد الرحمن العمري', '09999606627', NULL, 'pending', NULL, NULL, NULL, '2026-05-24 01:35:24', '2026-05-24 01:35:24');

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `debt_settlements`
--
ALTER TABLE `debt_settlements`
  ADD CONSTRAINT `debt_settlements_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `debt_settlements_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- قيود الجداول `request_additions`
--
ALTER TABLE `request_additions`
  ADD CONSTRAINT `request_additions_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `technician_details`
--
ALTER TABLE `technician_details`
  ADD CONSTRAINT `technician_details_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `technician_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- قيود الجداول `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD CONSTRAINT `withdrawal_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_requests_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrawal_requests_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
