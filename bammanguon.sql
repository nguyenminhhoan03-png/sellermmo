-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2025 at 08:57 PM
-- Server version: 5.7.44-log
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bammanguon`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_configs`
--

CREATE TABLE `api_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_configs`
--

INSERT INTO `api_configs` (`id`, `name`, `value`, `domain`, `username`, `created_at`, `updated_at`) VALUES
(1, 'charging_card', '{\"fees\":{\"VIETTEL\":\"20\",\"VINAPHONE\":\"20\",\"MOBIFONE\":\"20\",\"ZING\":\"20\"},\"api_url\":\"https:\\/\\/doithecao5s.vn\",\"partner_id\":null,\"partner_key\":null}', NULL, NULL, '2024-10-15 16:09:30', '2025-01-19 15:35:29'),
(3, 'dvr_mbbank', '{\"api_token\":\"000138665e25381765b1e2bf2832c950\"}', NULL, NULL, '2024-10-16 10:45:26', '2024-10-16 10:46:59'),
(4, 'telegram', '{\"status\":\"0\",\"chat_id\":\"ccccc\",\"bot_token\":\"cc\"}', NULL, NULL, '2024-10-28 11:41:49', '2025-08-08 18:57:33'),
(5, 'dvr_vietcombank', '{\"api_token\":\"cccc\"}', NULL, NULL, '2025-01-20 04:36:11', '2025-01-20 04:43:37'),
(6, 'dvr_tsr', '{\"api_token\":\"11\"}', NULL, NULL, '2025-01-20 04:48:57', '2025-01-20 04:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `api_logo`
--

CREATE TABLE `api_logo` (
  `id` int(11) NOT NULL,
  `shortName` text CHARACTER SET utf8mb4 NOT NULL,
  `logo` text CHARACTER SET utf8mb4 NOT NULL,
  `name` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_logo`
--

INSERT INTO `api_logo` (`id`, `shortName`, `logo`, `name`) VALUES
(1, 'VietinBank', 'https://api.vietqr.io/img/ICB.png', 'Ngân hàng TMCP Công thương Việt Nam'),
(2, 'Vietcombank', 'https://api.vietqr.io/img/VCB.png', 'Ngân hàng TMCP Ngoại Thương Việt Nam'),
(3, 'BIDV', 'https://api.vietqr.io/img/BIDV.png', 'Ngân hàng TMCP Đầu tư và Phát triển Việt Nam'),
(4, 'Agribank', 'https://api.vietqr.io/img/VBA.png', 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam'),
(5, 'OCB', 'https://api.vietqr.io/img/OCB.png', 'Ngân hàng TMCP Phương Đông'),
(6, 'MBBank', 'https://api.vietqr.io/img/MB.png', 'Ngân hàng TMCP Quân đội'),
(7, 'Techcombank', 'https://api.vietqr.io/img/TCB.png', 'Ngân hàng TMCP Kỹ thương Việt Nam'),
(8, 'ACB', 'https://api.vietqr.io/img/ACB.png', 'Ngân hàng TMCP Á Châu'),
(9, 'VPBank', 'https://api.vietqr.io/img/VPB.png', 'Ngân hàng TMCP Việt Nam Thịnh Vượng'),
(10, 'TPBank', 'https://api.vietqr.io/img/TPB.png', 'Ngân hàng TMCP Tiên Phong'),
(11, 'Sacombank', 'https://api.vietqr.io/img/STB.png', 'Ngân hàng TMCP Sài Gòn Thương Tín'),
(12, 'HDBank', 'https://api.vietqr.io/img/HDB.png', 'Ngân hàng TMCP Phát triển Thành phố Hồ Chí Minh'),
(13, 'VietCapitalBank', 'https://api.vietqr.io/img/VCCB.png', 'Ngân hàng TMCP Bản Việt'),
(14, 'SCB', 'https://api.vietqr.io/img/SCB.png', 'Ngân hàng TMCP Sài Gòn'),
(15, 'VIB', 'https://api.vietqr.io/img/VIB.png', 'Ngân hàng TMCP Quốc tế Việt Nam'),
(16, 'SHB', 'https://api.vietqr.io/img/SHB.png', 'Ngân hàng TMCP Sài Gòn - Hà Nội'),
(17, 'Eximbank', 'https://api.vietqr.io/img/EIB.png', 'Ngân hàng TMCP Xuất Nhập khẩu Việt Nam'),
(18, 'MSB', 'https://api.vietqr.io/img/MSB.png', 'Ngân hàng TMCP Hàng Hải'),
(19, 'CAKE', 'https://api.vietqr.io/img/CAKE.png', 'TMCP Việt Nam Thịnh Vượng - Ngân hàng số CAKE by VPBank'),
(20, 'Ubank', 'https://api.vietqr.io/img/UBANK.png', 'TMCP Việt Nam Thịnh Vượng - Ngân hàng số Ubank by VPBank'),
(21, 'Timo', 'https://vietqr.net/portal-service/resources/icons/TIMO.png', 'Ngân hàng số Timo by Ban Viet Bank (Timo by Ban Viet Bank)'),
(22, 'ViettelMoney', 'https://api.vietqr.io/img/VIETTELMONEY.png', 'Tổng Công ty Dịch vụ số Viettel - Chi nhánh tập đoàn công nghiệp viễn thông Quân Đội'),
(23, 'VNPTMoney', 'https://api.vietqr.io/img/VNPTMONEY.png', 'VNPT Money'),
(24, 'SaigonBank', 'https://api.vietqr.io/img/SGICB.png', 'Ngân hàng TMCP Sài Gòn Công Thương'),
(25, 'BacABank', 'https://api.vietqr.io/img/BAB.png', 'Ngân hàng TMCP Bắc Á'),
(26, 'PVcomBank', 'https://api.vietqr.io/img/PVCB.png', 'Ngân hàng TMCP Đại Chúng Việt Nam'),
(27, 'Oceanbank', 'https://api.vietqr.io/img/OCEANBANK.png', 'Ngân hàng Thương mại TNHH MTV Đại Dương'),
(28, 'NCB', 'https://api.vietqr.io/img/NCB.png', 'Ngân hàng TMCP Quốc Dân'),
(29, 'ShinhanBank', 'https://api.vietqr.io/img/SHBVN.png', 'Ngân hàng TNHH MTV Shinhan Việt Nam'),
(30, 'ABBANK', 'https://api.vietqr.io/img/ABB.png', 'Ngân hàng TMCP An Bình'),
(31, 'VietABank', 'https://api.vietqr.io/img/VAB.png', 'Ngân hàng TMCP Việt Á'),
(32, 'NamABank', 'https://api.vietqr.io/img/NAB.png', 'Ngân hàng TMCP Nam Á'),
(33, 'PGBank', 'https://api.vietqr.io/img/PGB.png', 'Ngân hàng TMCP Xăng dầu Petrolimex'),
(34, 'VietBank', 'https://api.vietqr.io/img/VIETBANK.png', 'Ngân hàng TMCP Việt Nam Thương Tín'),
(35, 'BaoVietBank', 'https://api.vietqr.io/img/BVB.png', 'Ngân hàng TMCP Bảo Việt'),
(36, 'SeABank', 'https://api.vietqr.io/img/SEAB.png', 'Ngân hàng TMCP Đông Nam Á'),
(37, 'COOPBANK', 'https://api.vietqr.io/img/COOPBANK.png', 'Ngân hàng Hợp tác xã Việt Nam'),
(38, 'LienVietPostBank', 'https://api.vietqr.io/img/LPB.png', 'Ngân hàng TMCP Bưu Điện Liên Việt'),
(39, 'KienLongBank', 'https://api.vietqr.io/img/KLB.png', 'Ngân hàng TMCP Kiên Long'),
(40, 'KBank', 'https://api.vietqr.io/img/KBANK.png', 'Ngân hàng Đại chúng TNHH Kasikornbank'),
(41, 'KookminHN', 'https://api.vietqr.io/img/KBHN.png', 'Ngân hàng Kookmin - Chi nhánh Hà Nội'),
(42, 'KEBHanaHCM', 'https://api.vietqr.io/img/KEBHANAHCM.png', 'Ngân hàng KEB Hana – Chi nhánh Thành phố Hồ Chí Minh'),
(43, 'KEBHANAHN', 'https://api.vietqr.io/img/KEBHANAHN.png', 'Ngân hàng KEB Hana – Chi nhánh Hà Nội'),
(44, 'MAFC', 'https://api.vietqr.io/img/MAFC.png', 'Công ty Tài chính TNHH MTV Mirae Asset (Việt Nam)'),
(45, 'Citibank', 'https://api.vietqr.io/img/CITIBANK.png', 'Ngân hàng Citibank, N.A. - Chi nhánh Hà Nội'),
(46, 'KookminHCM', 'https://api.vietqr.io/img/KBHCM.png', 'Ngân hàng Kookmin - Chi nhánh Thành phố Hồ Chí Minh'),
(47, 'VBSP', 'https://api.vietqr.io/img/VBSP.png', 'Ngân hàng Chính sách Xã hội'),
(48, 'Woori', 'https://api.vietqr.io/img/WVN.png', 'Ngân hàng TNHH MTV Woori Việt Nam'),
(49, 'VRB', 'https://api.vietqr.io/img/VRB.png', 'Ngân hàng Liên doanh Việt - Nga'),
(50, 'UnitedOverseas', 'https://api.vietqr.io/img/UOB.png', 'Ngân hàng United Overseas - Chi nhánh TP. Hồ Chí Minh'),
(51, 'StandardChartered', 'https://api.vietqr.io/img/SCVN.png', 'Ngân hàng TNHH MTV Standard Chartered Bank Việt Nam'),
(52, 'PublicBank', 'https://api.vietqr.io/img/PBVN.png', 'Ngân hàng TNHH MTV Public Việt Nam'),
(53, 'Nonghyup', 'https://api.vietqr.io/img/NHB.png', 'Ngân hàng Nonghyup - Chi nhánh Hà Nội'),
(54, 'IndovinaBank', 'https://api.vietqr.io/img/IVB.png', 'Ngân hàng TNHH Indovina'),
(55, 'IBKHCM', 'https://api.vietqr.io/img/IBK.png', 'Ngân hàng Công nghiệp Hàn Quốc - Chi nhánh TP. Hồ Chí Minh'),
(56, 'IBKHN', 'https://api.vietqr.io/img/IBK.png', 'Ngân hàng Công nghiệp Hàn Quốc - Chi nhánh Hà Nội'),
(57, 'HSBC', 'https://api.vietqr.io/img/HSBC.png', 'Ngân hàng TNHH MTV HSBC (Việt Nam)'),
(58, 'HongLeong', 'https://api.vietqr.io/img/HLBVN.png', 'Ngân hàng TNHH MTV Hong Leong Việt Nam'),
(59, 'GPBank', 'https://api.vietqr.io/img/GPB.png', 'Ngân hàng Thương mại TNHH MTV Dầu Khí Toàn Cầu'),
(60, 'DongABank', 'https://api.vietqr.io/img/DOB.png', 'Ngân hàng TMCP Đông Á'),
(61, 'DBSBank', 'https://api.vietqr.io/img/DBS.png', 'DBS Bank Ltd - Chi nhánh Thành phố Hồ Chí Minh'),
(62, 'CIMB', 'https://api.vietqr.io/img/CIMB.png', 'Ngân hàng TNHH MTV CIMB Việt Nam'),
(63, 'CBBank', 'https://api.vietqr.io/img/CBB.png', 'Ngân hàng Thương mại TNHH MTV Xây dựng Việt Nam'),
(64, 'MOMO', 'https://imgur.com/ESXApvP.png', 'Ví Điện Tử MOMO'),
(65, 'ZaloPay', 'https://i.imgur.com/6iUZXSZ.png', 'Ví Điện Tử Zalo Pay'),
(66, 'Thesieure', 'https://imgur.com/GEHuS50.png', 'Ví Điện Tử TSR');

-- --------------------------------------------------------

--
-- Table structure for table `author_forms`
--

CREATE TABLE `author_forms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_members` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_account` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `market_account` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_category` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `name`, `owner`, `number`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Vietcombank', 'NGUYEN DUY KHANH', '1049850384', 0, '2024-10-16 10:47:46', '2025-02-04 04:59:09'),
(3, 'Thesieure', 'NGUYEN DUY KHANH', 'cskh.dichvuright@gmail.com', 1, '2024-10-16 10:47:46', '2024-10-16 10:47:46'),
(4, 'MOMO', 'NGUYEN DUY KHANH', '0978009289', 1, '2024-10-16 10:47:46', '2024-10-16 10:47:46'),
(5, 'Mbbank', 'NGUYEN DUY KHANH', '6320079999', 1, '2024-10-16 10:47:46', '2024-10-16 10:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('app_version', 'i:1000;', 1754996960),
('cur_setting', 'a:7:{s:13:\"currency_code\";s:3:\"VND\";s:15:\"currency_symbol\";s:3:\"₫\";s:16:\"currency_decimal\";i:2;s:27:\"currency_thousand_separator\";s:5:\"comma\";s:26:\"currency_decimal_separator\";s:3:\"dot\";s:17:\"currency_position\";s:4:\"left\";s:17:\"new_currecry_rate\";i:1;}', 1754932395),
('cur_user_setting', 'a:7:{s:13:\"currency_code\";s:3:\"VND\";s:15:\"currency_symbol\";s:3:\"₫\";s:16:\"currency_decimal\";i:2;s:27:\"currency_thousand_separator\";s:5:\"comma\";s:26:\"currency_decimal_separator\";s:3:\"dot\";s:17:\"currency_position\";s:4:\"left\";s:17:\"new_currecry_rate\";i:1;}', 1754932395),
('general_contact_info_localhost', 'a:4:{s:5:\"email\";s:19:\"localhost@gmail.com\";s:8:\"facebook\";s:25:\"https://www.facebook.com/\";s:8:\"telegram\";s:13:\"https://t.me/\";s:3:\"sdt\";s:4:\"2323\";}', 1738592944),
('general_contact_info_mmo.viecodes.com', 'a:4:{s:5:\"email\";s:19:\"localhost@gmail.com\";s:8:\"facebook\";s:25:\"https://www.facebook.com/\";s:8:\"telegram\";s:13:\"https://t.me/\";s:3:\"sdt\";s:4:\"2323\";}', 1754996960),
('general_contact_info_trumcode.vn', 'a:4:{s:5:\"email\";s:19:\"localhost@gmail.com\";s:8:\"facebook\";s:25:\"https://www.facebook.com/\";s:8:\"telegram\";s:13:\"https://t.me/\";s:3:\"sdt\";s:4:\"2323\";}', 1738665773),
('general_settings_localhost', 'a:12:{s:5:\"title\";s:14:\"DichVuRight.VN\";s:8:\"keywords\";s:47:\"dichvuright, Shop bán source website giá rẻ\";s:11:\"description\";s:63:\"Hệ Thống bán mã nguồn,cronjobs,domain uy tín số 1 vn\";s:11:\"footer_text\";s:15:\"DichVuRight Inc\";s:11:\"footer_link\";s:23:\"https://dichvuright.com\";s:6:\"rutctv\";s:1:\"1\";s:6:\"minctv\";s:5:\"10000\";s:7:\"hosting\";s:1:\"1\";s:9:\"logo_dark\";s:60:\"/uploads/23-01-2025/13b4ead8-3aed-48e4-aeac-93a61112234b.png\";s:10:\"logo_light\";s:31:\"https://i.imgur.com/nMxPgiz.png\";s:7:\"favicon\";s:60:\"/uploads/23-01-2025/f814dbb6-73ca-4d54-8532-84252e4e1b1f.png\";s:9:\"thumbnail\";N;}', 1738592944),
('general_settings_mmo.viecodes.com', 'a:17:{s:5:\"title\";s:14:\"DichVuRight.VN\";s:8:\"keywords\";s:47:\"dichvuright, Shop bán source website giá rẻ\";s:11:\"description\";s:63:\"Hệ Thống bán mã nguồn,cronjobs,domain uy tín số 1 vn\";s:11:\"footer_text\";s:15:\"DichVuRight Inc\";s:11:\"footer_link\";s:23:\"https://dichvuright.com\";s:6:\"rutctv\";s:1:\"1\";s:6:\"minctv\";s:5:\"10000\";s:7:\"hosting\";s:1:\"1\";s:14:\"captcha_status\";s:1:\"0\";s:15:\"captcha_siteKey\";N;s:17:\"captcha_secretKey\";N;s:3:\"ns1\";s:24:\"kimora.ns.cloudflare.com\";s:3:\"ns2\";s:24:\"morgan.ns.cloudflare.com\";s:9:\"logo_dark\";s:60:\"/uploads/23-01-2025/13b4ead8-3aed-48e4-aeac-93a61112234b.png\";s:10:\"logo_light\";s:31:\"https://i.imgur.com/nMxPgiz.png\";s:7:\"favicon\";s:60:\"/uploads/23-01-2025/f814dbb6-73ca-4d54-8532-84252e4e1b1f.png\";s:9:\"thumbnail\";N;}', 1754996960),
('general_settings_trumcode.vn', 'a:12:{s:5:\"title\";s:14:\"DichVuRight.VN\";s:8:\"keywords\";s:47:\"dichvuright, Shop bán source website giá rẻ\";s:11:\"description\";s:63:\"Hệ Thống bán mã nguồn,cronjobs,domain uy tín số 1 vn\";s:11:\"footer_text\";s:15:\"DichVuRight Inc\";s:11:\"footer_link\";s:23:\"https://dichvuright.com\";s:6:\"rutctv\";s:1:\"1\";s:6:\"minctv\";s:5:\"10000\";s:7:\"hosting\";s:1:\"1\";s:9:\"logo_dark\";s:60:\"/uploads/23-01-2025/13b4ead8-3aed-48e4-aeac-93a61112234b.png\";s:10:\"logo_light\";s:31:\"https://i.imgur.com/nMxPgiz.png\";s:7:\"favicon\";s:60:\"/uploads/23-01-2025/f814dbb6-73ca-4d54-8532-84252e4e1b1f.png\";s:9:\"thumbnail\";N;}', 1738666025),
('general_settings_www.trumcode.vn', 'a:12:{s:5:\"title\";s:14:\"DichVuRight.VN\";s:8:\"keywords\";s:47:\"dichvuright, Shop bán source website giá rẻ\";s:11:\"description\";s:63:\"Hệ Thống bán mã nguồn,cronjobs,domain uy tín số 1 vn\";s:11:\"footer_text\";s:15:\"DichVuRight Inc\";s:11:\"footer_link\";s:23:\"https://dichvuright.com\";s:6:\"rutctv\";s:1:\"1\";s:6:\"minctv\";s:5:\"10000\";s:7:\"hosting\";s:1:\"1\";s:9:\"logo_dark\";s:60:\"/uploads/23-01-2025/13b4ead8-3aed-48e4-aeac-93a61112234b.png\";s:10:\"logo_light\";s:31:\"https://i.imgur.com/nMxPgiz.png\";s:7:\"favicon\";s:60:\"/uploads/23-01-2025/f814dbb6-73ca-4d54-8532-84252e4e1b1f.png\";s:9:\"thumbnail\";N;}', 1738650211),
('general_theme_settings_localhost', 'a:2:{s:9:\"ladi_name\";N;s:7:\"auth_bg\";s:60:\"/uploads/23-01-2025/908e51e0-154a-4a6b-b205-b7b9d4230784.jpg\";}', 1738585470),
('general_theme_settings_mmo.viecodes.com', 'a:2:{s:9:\"ladi_name\";s:7:\"default\";s:7:\"auth_bg\";s:60:\"/uploads/23-01-2025/908e51e0-154a-4a6b-b205-b7b9d4230784.jpg\";}', 1754981364),
('general_theme_settings_trumcode.vn', 'a:2:{s:9:\"ladi_name\";s:7:\"default\";s:7:\"auth_bg\";s:60:\"/uploads/23-01-2025/908e51e0-154a-4a6b-b205-b7b9d4230784.jpg\";}', 1738666025),
('general_theme_settings_www.trumcode.vn', 'a:2:{s:9:\"ladi_name\";s:7:\"default\";s:7:\"auth_bg\";s:60:\"/uploads/23-01-2025/908e51e0-154a-4a6b-b205-b7b9d4230784.jpg\";}', 1738650211);

-- --------------------------------------------------------

--
-- Table structure for table `card_lists`
--

CREATE TABLE `card_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '30',
  `sys_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`, `domain`, `created_at`, `updated_at`) VALUES
(1, 'theme_settings', '{\"ladi_name\":\"default\",\"auth_bg\":\"\\/uploads\\/23-01-2025\\/908e51e0-154a-4a6b-b205-b7b9d4230784.jpg\"}', NULL, '2024-10-15 05:56:23', '2025-02-03 14:41:45'),
(2, 'general', '{\"title\":\"DichVuRight.VN\",\"keywords\":\"dichvuright, Shop b\\u00e1n source website gi\\u00e1 r\\u1ebb\",\"description\":\"H\\u1ec7 Th\\u1ed1ng b\\u00e1n m\\u00e3 ngu\\u1ed3n,cronjobs,domain uy t\\u00edn s\\u1ed1 1 vn\",\"footer_text\":\"DichVuRight Inc\",\"footer_link\":\"https:\\/\\/dichvuright.com\",\"rutctv\":\"1\",\"minctv\":\"10000\",\"hosting\":\"1\",\"captcha_status\":\"0\",\"captcha_siteKey\":null,\"captcha_secretKey\":null,\"ns1\":\"kimora.ns.cloudflare.com\",\"ns2\":\"morgan.ns.cloudflare.com\",\"logo_dark\":\"\\/uploads\\/23-01-2025\\/13b4ead8-3aed-48e4-aeac-93a61112234b.png\",\"logo_light\":\"https:\\/\\/i.imgur.com\\/nMxPgiz.png\",\"favicon\":\"\\/uploads\\/23-01-2025\\/f814dbb6-73ca-4d54-8532-84252e4e1b1f.png\",\"thumbnail\":null}', NULL, '2024-10-15 05:56:23', '2025-08-10 10:35:07'),
(5, 'version_code', '1000', NULL, '2024-10-15 05:57:55', '2024-10-15 06:03:07'),
(6, 'contact_info', '{\"email\":\"localhost@gmail.com\",\"facebook\":\"https:\\/\\/www.facebook.com\\/\",\"telegram\":\"https:\\/\\/t.me\\/\",\"sdt\":\"2323\"}', NULL, '2024-10-15 05:57:55', '2025-01-23 13:18:50'),
(7, 'deposit_status', '{\"card\":\"1\",\"bank\":\"0\",\"crypto\":\"0\"}', NULL, '2024-10-15 05:57:55', '2024-10-16 10:46:19'),
(9, 'time_cron_order', '\"2024-11-04T11:00:33.306237Z\"', NULL, '2024-10-15 05:58:45', '2024-11-04 11:00:33'),
(11, 'deposit_info', '{\"prefix\":\"testcode \",\"transfer\":\"THANHTOAN\",\"discount\":0,\"min_amount\":0}', NULL, '2024-10-15 05:58:58', '2024-10-16 10:48:09'),
(14, 'affiliate_config', NULL, NULL, '2025-01-23 13:51:54', '2025-01-23 13:51:54'),
(15, 'currency_settings', NULL, NULL, '2025-01-23 14:12:09', '2025-01-23 14:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `createwebs`
--

CREATE TABLE `createwebs` (
  `id` int(11) NOT NULL,
  `trans_id` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `web_id` int(11) NOT NULL,
  `tk` varchar(255) NOT NULL COMMENT 'tài khoản admin',
  `mk` varchar(255) NOT NULL COMMENT 'mật khẩu admin',
  `domain` varchar(500) NOT NULL COMMENT 'tên miền',
  `pointer` int(11) NOT NULL DEFAULT '0' COMMENT '0: chưa trỏ, 1 đã trỏ',
  `time_exp` int(11) NOT NULL COMMENT 'thời gian hết hạn',
  `price` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: đang xử lý, 1: đã hủy đơn, 2 tạo web thành công',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `createwebs`
--

INSERT INTO `createwebs` (`id`, `trans_id`, `user_id`, `web_id`, `tk`, `mk`, `domain`, `pointer`, `time_exp`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DF1754805892', 1, 4, 'cccc', 'cccc', 'boladuykhanhvlxx.com', 1, 1759989892, 240000, 2, '2025-08-10 11:04:52', '2025-08-10 15:48:13'),
(2, 'AQ1754806150', 1, 4, 'ccc', 'cccc', 'boladuykhanhvlxx.com', 1, 1759990150, 190000, 2, '2025-08-10 11:09:10', '2025-08-10 16:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `currency_lists`
--

CREATE TABLE `currency_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_thousand_separator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dot',
  `currency_decimal_separator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dot',
  `currency_decimal` int(11) NOT NULL DEFAULT '2',
  `default_price_percentage_increase` int(11) NOT NULL DEFAULT '0',
  `auto_rounding_x_decimal_places` int(11) NOT NULL DEFAULT '2',
  `is_auto_currency_convert` tinyint(1) NOT NULL DEFAULT '0',
  `new_currecry_rate` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency_lists`
--

INSERT INTO `currency_lists` (`id`, `currency_code`, `currency_symbol`, `currency_thousand_separator`, `currency_decimal_separator`, `currency_decimal`, `default_price_percentage_increase`, `auto_rounding_x_decimal_places`, `is_auto_currency_convert`, `new_currecry_rate`, `created_at`, `updated_at`) VALUES
(1, 'VND', '₫', 'comma', 'dot', 2, 0, 2, 0, 1, '2024-10-15 05:57:55', '2024-10-15 05:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `extend_price` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domain`
--

INSERT INTO `domain` (`id`, `name`, `price`, `extend_price`, `sale`, `status`, `created_at`, `updated_at`) VALUES
(1, 'com', 50000, '250000', 0, 1, '2025-08-09 17:04:25', '2025-08-09 17:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `domain_order`
--

CREATE TABLE `domain_order` (
  `id` int(11) NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `domain_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ns` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_han` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` timestamp NULL DEFAULT NULL,
  `expired_timestamp` int(11) DEFAULT NULL,
  `giahan` int(11) NOT NULL DEFAULT '0' COMMENT '1:auto,0:ko auto',
  `status` int(11) NOT NULL COMMENT '1:chờ duyệt,2:đã được duyệt,3:bị khóa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domain_order`
--

INSERT INTO `domain_order` (`id`, `trans_id`, `user_id`, `domain_name`, `ns`, `price`, `time_han`, `expired_date`, `expired_timestamp`, `giahan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TX1754805892', 1, 'boladuykhanhvlxx.com', 'kimora.ns.cloudflare.com,morgan.ns.cloudflare.com', '50000', '1', '2026-08-10 11:04:52', 1786341892, 0, 2, '2025-08-10 11:04:52', '2025-08-10 11:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `his_logo`
--

CREATE TABLE `his_logo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logo_id` int(11) NOT NULL,
  `trans_id` varchar(500) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: chở xử lý,2 đã hoàn thành, 1 đã hủy',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `his_logo`
--

INSERT INTO `his_logo` (`id`, `user_id`, `logo_id`, `trans_id`, `price`, `name`, `link`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 'FC1754648972', 90000, 'khánh code', NULL, 0, '2025-08-08 15:29:32', '2025-08-08 15:29:32'),
(4, 1, 3, 'HI1754649041', 90000, 'cccc', NULL, 0, '2025-08-08 15:30:41', '2025-08-08 15:30:41'),
(5, 1, 3, 'YU1754649118', 90000, 'ccccc', 'ccc', 2, '2025-08-08 15:31:58', '2025-08-08 18:41:53'),
(6, 1, 1, 'UE1754878883', 1140000, 'Demo123.vn', NULL, 0, '2025-08-11 07:21:23', '2025-08-11 07:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `user_id`, `license_key`, `domain`, `status`, `cmt`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'e8e526d5a7e08fccc9b350a3be705847', '[]', 'active', 'noti', '2026-08-12', '2025-08-11 22:12:25', '2025-08-11 22:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `list_url_cron`
--

CREATE TABLE `list_url_cron` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_server` int(11) NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `second` int(11) NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `time_his` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` timestamp NULL DEFAULT NULL,
  `expired_timestamp` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `ck` int(11) NOT NULL DEFAULT '0',
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `name`, `image`, `price`, `ck`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Logo Shop Acc Game', '/uploads/08-08-2025/c7058d4e-9309-4255-bce0-024fbf44bd79.gif', 1200000, 5, 'ccccz', 1, '2025-08-08 12:44:41', '2025-08-08 17:52:00'),
(3, 'Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', '/uploads/08-08-2025/427d49a0-68fb-4d33-8a34-7c2a5b80041e.gif', 100000, 5, 'cccc', 1, '2025-08-08 13:14:34', '2025-08-09 07:19:45'),
(4, 'logo ok vip bank', '/uploads/08-08-2025/ad79b910-55b3-4906-9fca-784ad064923a.gif', 1000000, 60, 'ccc', 1, '2025-08-08 13:15:21', '2025-08-08 13:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` int(11) NOT NULL,
  `old_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `data`, `old_data`, `new_data`, `ip`, `description`, `data_json`, `created_at`, `updated_at`) VALUES
(1, 1, 'Đăng kí tài khoản', 0, '0', '0', '14.191.8.188', 'Thực hiện đăng kí tài khoản địa chỉ ip 14.191.8.188', '', '2025-02-04 17:41:51', '2025-02-04 17:41:51'),
(2, 1, 'Đăng kí tài khoản', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng kí tài khoản địa chỉ ip 14.191.9.192', '', '2025-08-08 09:38:49', '2025-08-08 09:38:49'),
(3, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.9.192', '', '2025-08-08 14:07:13', '2025-08-08 14:07:13'),
(4, 1, 'Đăng tải logoLogo Shop Acc Gamevới giá 1,200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng logo với địa chỉ ip14.191.9.192', '', '2025-08-08 14:44:41', '2025-08-08 14:44:41'),
(5, 1, 'Cập nhật logo Logo Shop Acc Game1với giá 1,200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-08 14:58:19', '2025-08-08 14:58:19'),
(6, 1, 'Cập nhật logo Logo Shop Acc Game1với giá 1,200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-08 14:58:46', '2025-08-08 14:58:46'),
(7, 1, 'Cập nhật logo Logo Shop Acc Gamevới giá 1,200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-08 14:59:08', '2025-08-08 14:59:08'),
(8, 1, 'Đăng tải logocccccvới giá 3,432,434đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng logo với địa chỉ ip14.191.9.192', '', '2025-08-08 15:09:14', '2025-08-08 15:09:14'),
(9, 1, 'Xóa sản phẩm #ccccc', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa sản phẩm #ccccc với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 15:12:29', '2025-08-08 15:12:29'),
(10, 1, 'Đăng tải logologo fi faivới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng logo với địa chỉ ip14.191.9.192', '', '2025-08-08 15:14:34', '2025-08-08 15:14:34'),
(11, 1, 'Đăng tải logologo ok vip bankvới giá 1,000,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng logo với địa chỉ ip14.191.9.192', '', '2025-08-08 15:15:21', '2025-08-08 15:15:21'),
(12, 1, 'Cộng tiền thành công cho dichvuright [cong-tien]', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Cộng tiền thành công cho dichvuright [cong-tien] với địa chỉ ip 14.191.9.192', '{\"amount\":\"20000000\",\"reason\":null}', '2025-08-08 17:17:40', '2025-08-08 17:17:40'),
(13, 1, 'Thành toán logo logo fi fai Mã số 3', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo fi fai Mã số 3 với địa chỉ ip14.191.9.192', '', '2025-08-08 17:23:13', '2025-08-08 17:23:13'),
(14, 1, 'Thành toán logo logo fi fai Mã số 3', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo fi fai Mã số 3 với địa chỉ ip14.191.9.192', '', '2025-08-08 17:29:32', '2025-08-08 17:29:32'),
(15, 1, 'Thành toán logo logo fi fai Mã số 3', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo fi fai Mã số 3 với địa chỉ ip14.191.9.192', '', '2025-08-08 17:30:41', '2025-08-08 17:30:41'),
(16, 1, 'Thành toán logo logo fi fai Mã số 3', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo fi fai Mã số 3 với địa chỉ ip14.191.9.192', '', '2025-08-08 17:31:58', '2025-08-08 17:31:58'),
(17, 1, 'Xóa đơn tạo logo #FE1754648593', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa đơn tạo logo #FE1754648593 với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 19:42:46', '2025-08-08 19:42:46'),
(18, 1, 'Cập nhật cài đặt API; Loại telegram', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Cập nhật cài đặt API; Loại telegram với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 20:57:23', '2025-08-08 20:57:23'),
(19, 1, 'Cập nhật cài đặt API; Loại telegram', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Cập nhật cài đặt API; Loại telegram với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 20:57:33', '2025-08-08 20:57:33'),
(20, 1, 'Thành toán logo logo fi fai Mã số 3', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo fi fai Mã số 3 với địa chỉ ip14.191.9.192', '', '2025-08-08 20:58:34', '2025-08-08 20:58:34'),
(21, 1, 'Xóa đơn tạo logo #SM1754661468', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa đơn tạo logo #SM1754661468 với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 20:58:52', '2025-08-08 20:58:52'),
(22, 1, 'Xóa đơn tạo logo #XR1754661514', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa đơn tạo logo #XR1754661514 với địa chỉ ip 14.191.9.192', '{}', '2025-08-08 20:58:55', '2025-08-08 20:58:55'),
(23, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.9.192', '', '2025-08-09 08:13:33', '2025-08-09 08:13:33'),
(24, 1, 'Đăng tải website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 1,000,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng website với địa chỉ ip14.191.9.192', '', '2025-08-09 08:39:03', '2025-08-09 08:39:03'),
(25, 1, 'Đăng tải website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 1,000,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng website với địa chỉ ip14.191.9.192', '', '2025-08-09 08:41:36', '2025-08-09 08:41:36'),
(26, 1, 'Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay với địa chỉ ip 14.191.9.192', '{}', '2025-08-09 08:51:48', '2025-08-09 08:51:48'),
(27, 1, 'Đăng tải website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng website với địa chỉ ip14.191.9.192', '', '2025-08-09 08:52:22', '2025-08-09 08:52:22'),
(28, 1, 'Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay với địa chỉ ip 14.191.9.192', '{}', '2025-08-09 08:56:34', '2025-08-09 08:56:34'),
(29, 1, 'Đăng tải website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng website với địa chỉ ip14.191.9.192', '', '2025-08-09 09:01:19', '2025-08-09 09:01:19'),
(30, 1, 'Cập nhật logo Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay1với giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-09 09:18:01', '2025-08-09 09:18:01'),
(31, 1, 'Cập nhật logo Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay1với giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-09 09:18:54', '2025-08-09 09:18:54'),
(32, 1, 'Cập nhật logo Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay1với giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-09 09:19:06', '2025-08-09 09:19:06'),
(33, 1, 'Cập nhật logo Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật logo với địa chỉ ip14.191.9.192', '', '2025-08-09 09:19:45', '2025-08-09 09:19:45'),
(34, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay1với giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 09:21:53', '2025-08-09 09:21:53'),
(35, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay1với giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 09:22:27', '2025-08-09 09:22:27'),
(36, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 09:22:32', '2025-08-09 09:22:32'),
(37, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 100,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 09:22:39', '2025-08-09 09:22:39'),
(38, 1, 'Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay với địa chỉ ip 14.191.9.192', '{}', '2025-08-09 09:22:55', '2025-08-09 09:22:55'),
(39, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.9.192', '', '2025-08-09 16:32:13', '2025-08-09 16:32:13'),
(40, 1, 'Đăng tải website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng website với địa chỉ ip14.191.9.192', '', '2025-08-09 16:44:36', '2025-08-09 16:44:36'),
(41, 1, 'Đăng tải tên miềncomvới giá 50,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động đăng sản phẩm với địa chỉ ip14.191.9.192', '', '2025-08-09 17:04:25', '2025-08-09 17:04:25'),
(42, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.9.192', '', '2025-08-09 19:33:44', '2025-08-09 19:33:44'),
(43, 1, 'Thành toán logo logo ok vip bank Mã số 4', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Thành toán logo logo ok vip bank Mã số 4 với địa chỉ ip14.191.9.192', '', '2025-08-09 20:55:30', '2025-08-09 20:55:30'),
(44, 1, 'Xóa đơn tạo logo #HQ1754747730', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Xóa đơn tạo logo #HQ1754747730 với địa chỉ ip 14.191.9.192', '{}', '2025-08-09 20:55:50', '2025-08-09 20:55:50'),
(45, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 21:55:26', '2025-08-09 21:55:26'),
(46, 1, 'Cập nhật websiteWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 200,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật website với địa chỉ ip14.191.9.192', '', '2025-08-09 21:55:31', '2025-08-09 21:55:31'),
(47, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.9.192', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.9.192', '', '2025-08-10 10:38:18', '2025-08-10 10:38:18'),
(48, 1, 'Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4 với địa chỉ ip 14.191.9.192', '', '2025-08-10 12:59:31', '2025-08-10 12:59:31'),
(49, 1, 'Cập nhật nameserver tên miền thành công', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Cập nhật nameserver tên miền thành công với địa chỉ ip 14.191.9.192', '{}', '2025-08-10 13:01:10', '2025-08-10 13:01:10'),
(50, 1, 'Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4 với địa chỉ ip 14.191.9.192', '', '2025-08-10 13:04:52', '2025-08-10 13:04:52'),
(51, 1, 'Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động Tạo web Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay - Mã số 4 với địa chỉ ip 14.191.9.192', '', '2025-08-10 13:09:10', '2025-08-10 13:09:10'),
(52, 1, 'Cập nhật tên miềnboladuykhanhvlxx.comvới giá 50,000đ', 0, '0', '0', '14.191.9.192', 'Thực hiện hành động cập nhật tên miền với địa chỉ ip14.191.9.192', '', '2025-08-10 13:12:27', '2025-08-10 13:12:27'),
(53, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.8.89', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.8.89', '', '2025-08-10 16:04:57', '2025-08-10 16:04:57'),
(54, 1, 'Thành toán gia hạn website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay Giá tiền 200,000đ', 0, '0', '0', '14.191.8.89', 'Thực hiện hành động thanh toán gia hạn website với địa chỉ ip14.191.8.89', '', '2025-08-10 17:37:24', '2025-08-10 17:37:24'),
(55, 1, 'Thành toán gia hạn website Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay Giá tiền 20,000đ', 0, '0', '0', '14.191.8.89', 'Thực hiện hành động thanh toán gia hạn website với địa chỉ ip14.191.8.89', '', '2025-08-10 17:39:06', '2025-08-10 17:39:06'),
(56, 1, 'Đăng tải mã nguồnWebsite Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quayvới giá 42,342,342đ', 0, '0', '0', '14.191.8.89', 'Thực hiện hành động đăng sản phẩm với địa chỉ ip14.191.8.89', '', '2025-08-10 19:58:48', '2025-08-10 19:58:48'),
(57, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '116.99.117.230', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip116.99.117.230', '', '2025-08-10 19:59:16', '2025-08-10 19:59:16'),
(58, 1, 'Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', 0, '0', '0', '14.191.8.89', 'Thực hiện hành động Xóa sản phẩm #Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay với địa chỉ ip 14.191.8.89', '{}', '2025-08-10 20:00:11', '2025-08-10 20:00:11'),
(59, 1, 'Đăng tải mã nguồnDemo 1với giá 10,000đ', 0, '0', '0', '171.255.140.63', 'Thực hiện hành động đăng sản phẩm với địa chỉ ip171.255.140.63', '', '2025-08-10 21:19:37', '2025-08-10 21:19:37'),
(60, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '171.255.140.63', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip171.255.140.63', '', '2025-08-11 08:07:43', '2025-08-11 08:07:43'),
(61, 1, 'Thành toán logo Logo Shop Acc Game Mã số 1', 0, '0', '0', '14.191.114.195', 'Thực hiện hành động Thành toán logo Logo Shop Acc Game Mã số 1 với địa chỉ ip14.191.114.195', '', '2025-08-11 09:21:23', '2025-08-11 09:21:23'),
(62, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '115.73.122.179', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip115.73.122.179', '', '2025-08-12 00:01:54', '2025-08-12 00:01:54'),
(63, 1, 'Đăng tải danh mục HostingVn Test', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động đăng danh mục Hosting với địa chỉ ip115.73.122.179', '', '2025-08-12 00:02:22', '2025-08-12 00:02:22'),
(64, 1, 'Tạo máy chủ hosting: 103-149-252-139.cprapid.com', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động Tạo máy chủ hosting: 103-149-252-139.cprapid.com với địa chỉ ip 115.73.122.179', '{}', '2025-08-12 00:03:01', '2025-08-12 00:03:01'),
(65, 1, 'Đăng tải gói Hostinglebaodz1', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động đăng gói Hosting với địa chỉ ip115.73.122.179', '', '2025-08-12 00:04:31', '2025-08-12 00:04:31'),
(66, 1, 'Mua Hosting Thuộc gói lebaodz1', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động mua hosting với địa chỉ ip115.73.122.179', '', '2025-08-12 00:04:56', '2025-08-12 00:04:56'),
(67, 1, 'Thục hiện cài đặt lại hosting mã số #1', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động cài đặt lại hosting với địa chỉ ip115.73.122.179', '', '2025-08-12 00:07:23', '2025-08-12 00:07:23'),
(68, 1, 'Câp nhật tên miền cho hosting, tên miền shopaccgame.click', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động cập nhật gói Hosting với địa chỉ ip115.73.122.179', '', '2025-08-12 00:07:34', '2025-08-12 00:07:34'),
(69, 1, 'Thành toán mã nguồn Demo 1 Mã số 2', 0, '0', '0', '115.73.122.179', 'Thực hiện hành động Thành toán mã nguồn Demo 1 Mã số 2 với địa chỉ ip115.73.122.179', '', '2025-08-12 00:12:25', '2025-08-12 00:12:25'),
(70, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.8.89', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.8.89', '', '2025-08-12 00:12:26', '2025-08-12 00:12:26'),
(71, 1, 'Đăng nhập thành công vào vào hệ thống', 0, '0', '0', '14.191.8.89', 'Thực hiện đăng nhập tài khoản qua website địa chỉ ip14.191.8.89', '', '2025-08-12 08:05:39', '2025-08-12 08:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `name`, `type`, `value`, `domain`, `created_at`, `updated_at`) VALUES
(1, 'notectv', NULL, 'PHA+xJDhu4MgxJHhuqNtIGLhuqNvIHF1eeG7gW4gbOG7o2kgdiZhZ3JhdmU7IHPhu7EgYW4gdG8mYWdyYXZlO24gY2hvIHF1JnlhY3V0ZTsga2gmYWFjdXRlO2NoLCB2dWkgbCZvZ3JhdmU7bmcgdHUmYWNpcmM7biB0aOG7pyBjJmFhY3V0ZTtjIG7hu5lpIHF1eSBzYXUga2hpIHRo4buxYyBoaeG7h24gciZ1YWN1dGU7dCB0aeG7gW46PC9wPg0KDQo8dWw+DQoJPGxpPlPhu5EgdGnhu4FuIHImdWFjdXRlO3QgcGjhuqNpIMSR4bqhdCBt4bupYyB04buRaSB0aGnhu4N1IMSRxrDhu6NjIHF1eSDEkeG7i25oIGLhu59pIGjhu4cgdGjhu5FuZy4gUiZ1YWN1dGU7dCB0aeG7gW4gZMaw4bubaSBo4bqhbiBt4bupYyBuJmFncmF2ZTt5IHPhur0ga2gmb2NpcmM7bmcgxJHGsOG7o2MgeOG7rSBsJnlhY3V0ZTsuPC9saT4NCgk8bGk+VGjhu51pIGdpYW4geOG7rSBsJnlhY3V0ZTsgciZ1YWN1dGU7dCB0aeG7gW4gYyZvYWN1dGU7IHRo4buDIGsmZWFjdXRlO28gZCZhZ3JhdmU7aSB04burIDEgxJHhur9uIDMgbmcmYWdyYXZlO3kgbCZhZ3JhdmU7bSB2aeG7h2MsIHQmdWdyYXZlO3kgdGh14buZYyB2JmFncmF2ZTtvIG5nJmFjaXJjO24gaCZhZ3JhdmU7bmcgaG/hurdjIHBoxrDGoW5nIHRo4bupYyB0aGFuaCB0byZhYWN1dGU7bi48L2xpPg0KCTxsaT5N4buNaSBnaWFvIGThu4tjaCByJnVhY3V0ZTt0IHRp4buBbiBj4bqnbiDEkcaw4bujYyB0aOG7sWMgaGnhu4duIHRoJm9jaXJjO25nIHF1YSB0JmFncmF2ZTtpIGtob+G6o24gY2gmaWFjdXRlO25oIGNo4bunIMSRJmF0aWxkZTsgxJHEg25nIGsmeWFjdXRlOyB0ciZlY2lyYztuIGjhu4cgdGjhu5FuZy48L2xpPg0KCTxsaT5Ucm9uZyB0csaw4budbmcgaOG7o3AgcGgmYWFjdXRlO3QgaGnhu4duIHRoJm9jaXJjO25nIHRpbiByJnVhY3V0ZTt0IHRp4buBbiBzYWkgbOG7h2NoIGhv4bq3YyBnaWFuIGzhuq1uLCBnaWFvIGThu4tjaCBz4bq9IGLhu4sgSOG7plkgQuG7jiB2JmFncmF2ZTsgaOG7hyB0aOG7kW5nIGMmb2FjdXRlOyBxdXnhu4FuIHThuqFtIGtoJm9hY3V0ZTthIHQmYWdyYXZlO2kga2hv4bqjbiDEkeG7gyDEkWnhu4F1IHRyYS48L2xpPg0KCTxsaT5RdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBjaOG7i3UgdHImYWFjdXRlO2NoIG5oaeG7h20ga2nhu4NtIHRyYSBz4buRIHRp4buBbiB2JmFncmF2ZTsgdGgmb2NpcmM7bmcgdGluIHQmYWdyYXZlO2kga2hv4bqjbiBuaOG6rW4gdHLGsOG7m2Mga2hpIHgmYWFjdXRlO2Mgbmjhuq1uIGdpYW8gZOG7i2NoLjwvbGk+DQoJPGxpPkjhu4cgdGjhu5FuZyBraCZvY2lyYztuZyBjaOG7i3UgdHImYWFjdXRlO2NoIG5oaeG7h20gxJHhu5FpIHbhu5tpIGMmYWFjdXRlO2MgbOG7l2kgcGgmYWFjdXRlO3Qgc2luaCBkbyBjdW5nIGPhuqVwIHRoJm9jaXJjO25nIHRpbiBraCZvY2lyYztuZyBjaCZpYWN1dGU7bmggeCZhYWN1dGU7Yy48L2xpPg0KPC91bD4NCg0KPHA+UXUmeWFjdXRlOyBraCZhYWN1dGU7Y2ggdnVpIGwmb2dyYXZlO25nIGxpJmVjaXJjO24gaOG7hyBi4buZIHBo4bqtbiBo4buXIHRy4bujIG7hur91IGMmb2FjdXRlOyBi4bqldCBr4buzIHRo4bqvYyBt4bqvYyBob+G6t2Mgc+G7sSBj4buRIG4mYWdyYXZlO28gdHJvbmcgcXUmYWFjdXRlOyB0ciZpZ3JhdmU7bmggciZ1YWN1dGU7dCB0aeG7gW4uIFhpbiBj4bqjbSDGoW4hPC9wPg==', NULL, '2024-10-15 05:57:55', '2025-01-23 12:10:21'),
(2, 'modal_dashboard', NULL, 'PHAgc3R5bGU9InRleHQtYWxpZ246Y2VudGVyIj48ZW0+PHN0cm9uZz5Db2RlIMSQxrDhu6NjIFZp4bq/dCBC4bufaSA8c3BhbiBzdHlsZT0iY29sb3I6I2U3NGMzYyI+RGljaFZ1UmlnaHQgVk48L3NwYW4+PC9zdHJvbmc+PC9lbT48L3A+DQoNCjxwIHN0eWxlPSJ0ZXh0LWFsaWduOmNlbnRlciI+PHNwYW4gc3R5bGU9ImNvbG9yOiNlNzRjM2MiPjxzdHJvbmc+PGVtPk11YSBDb2RlIFThuqFpIDxhIGhyZWY9Imh0dHBzOi8vZGljaHZ1cmlnaHQuY29tIj5EaWNoVnVSaWdodC5Db208L2E+PC9lbT48L3N0cm9uZz48L3NwYW4+PC9wPg==', NULL, '2024-10-15 05:57:55', '2025-01-23 12:21:39'),
(3, 'header_script', NULL, NULL, NULL, '2024-10-15 05:57:55', '2025-01-23 13:57:04'),
(4, 'footer_script', NULL, '', NULL, '2024-10-15 05:57:55', '2025-01-23 14:05:36'),
(5, 'page_deposit', NULL, 'PG9sPg0KICAgICAgICAgICAgICAgICAgICAgICAgPGxpIGRhdGEtbGlzdD0iYnVsbGV0Ij4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c3BhbiBjbGFzcz0icWwtdWkiIGNvbnRlbnRlZGl0YWJsZT0iZmFsc2UiPjwvc3Bhbj4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c3Ryb25nIGNsYXNzPSJxbC1zaXplLWxhcmdlIiBzdHlsZT0iY29sb3I6IHJnYigwLCAxMzgsIDApOyI+Q8OhYyDEkcahbiBu4bqhcCB0aeG7gW4gc+G6vSDEkcaw4bujYyBj4buZbmcgdGnhu4FuIGNo4buJIHNhdSAzMHMtMTVwLjwvc3Ryb25nPg0KICAgICAgICAgICAgICAgICAgICAgICAgPC9saT4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxsaSBkYXRhLWxpc3Q9ImJ1bGxldCI+DQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPHNwYW4gY2xhc3M9InFsLXVpIiBjb250ZW50ZWRpdGFibGU9ImZhbHNlIj48L3NwYW4+DQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPHN0cm9uZyBjbGFzcz0icWwtc2l6ZS1sYXJnZSIgc3R5bGU9ImNvbG9yOiByZ2IoMjM1LCA4OCwgODgpOyI+UXXDvSBraMOhY2ggdnVpIGzDsm5nIG5o4bqtcCDEkcO6bmcgbuG7mWkgZHVuZyB0aMOsIHPhur0gxJHGsOG7o2MgY+G7mW5nIHRp4buBbi48L3N0cm9uZz4NCiAgICAgICAgICAgICAgICAgICAgICAgIDwvbGk+DQogICAgICAgICAgICAgICAgICAgICAgICA8bGkgZGF0YS1saXN0PSJidWxsZXQiPg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzcGFuIGNsYXNzPSJxbC11aSIgY29udGVudGVkaXRhYmxlPSJmYWxzZSI+PC9zcGFuPg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzdHJvbmcgY2xhc3M9InFsLXNpemUtbGFyZ2UiIHN0eWxlPSJjb2xvcjogcmdiKDIzNSwgODgsIDg4KTsiPkjhu4cgdGjhu5FuZyBjaMO6bmcgdMO0aSBraMO0bmcgc+G7rSBk4bulbmcgdGnhu4FuIHThu6sgdmlzYSxjcmVkaXQgY2FyZCwgdGnhu4FuIGtow7RuZyByw7Ugbmd14buTbiBn4buRYyBu4bq/dSBwaMOhdCBoaeG7h24gc+G6vSBraMOzYSB2di48L3N0cm9uZz4NCiAgICAgICAgICAgICAgICAgICAgICAgIDwvbGk+DQogICAgICAgICAgICAgICAgICAgIDwvb2w+', NULL, '2024-10-15 08:10:26', '2025-01-23 12:24:56'),
(6, 'page_privacy_policy', NULL, 'PHA+Q2jDoG8gbeG7q25nIGLhuqFuIMSR4bq/biB24bubaSB3ZWJzaXRlIGPhu6dhIGNow7puZyB0w7RpLiBLaGkgYuG6oW4gdHJ1eSBj4bqtcCB2w6Agc+G7rSBk4bulbmcgd2Vic2l0ZSBuw6B5LCBi4bqhbiDEkeG7k25nIMO9IHR1w6JuIHRo4bunIGPDoWMgxJFp4buBdSBraG/huqNuIHbDoCDEkWnhu4F1IGtp4buHbiBkxrDhu5tpIMSRw6J5LiBO4bq/dSBi4bqhbiBraMO0bmcgxJHhu5NuZyDDvSB24bubaSBi4bqldCBr4buzIMSRaeG7gXUga2hv4bqjbiBuw6BvLCB2dWkgbMOybmcga2jDtG5nIHPhu60gZOG7pW5nIHdlYnNpdGUgbsOgeS48L3A+DQogICAgDQogICAgPGgyPjEuIFF1eeG7gW4gU+G7rSBE4bulbmc8L2gyPg0KICAgIDxwPk5nxrDhu51pIGTDuW5nIMSRxrDhu6NjIHBow6lwIHRydXkgY+G6rXAgdsOgIHPhu60gZOG7pW5nIG7hu5lpIGR1bmcgdHLDqm4gd2Vic2l0ZSBjaG8gbeG7pWMgxJHDrWNoIGPDoSBuaMOibiB2w6AgcGhpIHRoxrDGoW5nIG3huqFpLiBN4buNaSBow6BuaCB2aSBzYW8gY2jDqXAsIHBow6JuIHBo4buRaSwgc+G7rWEgxJHhu5VpIGhv4bq3YyBz4butIGThu6VuZyBu4buZaSBkdW5nIG3DoCBraMO0bmcgY8OzIHPhu7EgY2hvIHBow6lwIHLDtSByw6BuZyB04burIGNow7puZyB0w7RpIMSR4buBdSBi4buLIG5naGnDqm0gY+G6pW0uIENow7puZyB0w7RpIGLhuqNvIGzGsHUgcXV54buBbiBo4bqhbiBjaOG6vyBob+G6t2MgY2jhuqVtIGThu6l0IHF1eeG7gW4gdHJ1eSBj4bqtcCBj4bunYSBi4bqldCBr4buzIG5nxrDhu51pIGTDuW5nIG7DoG8gdmkgcGjhuqFtIGPDoWMgxJFp4buBdSBraG/huqNuIG7DoHkuPC9wPg0KICAgIA0KICAgIDxoMj4yLiDEkMSDbmcgS8O9IFTDoGkgS2hv4bqjbjwvaDI+DQogICAgPHA+xJDhu4Mgc+G7rSBk4bulbmcgbeG7mXQgc+G7kSBk4buLY2ggduG7pSB0csOqbiB3ZWJzaXRlLCBi4bqhbiBjw7MgdGjhu4MgY+G6p24gcGjhuqNpIMSRxINuZyBrw70gdMOgaSBraG/huqNuLiBC4bqhbiDEkeG7k25nIMO9IGN1bmcgY+G6pXAgdGjDtG5nIHRpbiBjaMOtbmggeMOhYywgxJHhuqd5IMSR4bunIHbDoCBj4bqtcCBuaOG6rXQgduG7gSBi4bqjbiB0aMOibi4gQuG6oW4gY8WpbmcgY8OzIHRyw6FjaCBuaGnhu4dtIGLhuqNvIG3huq10IHRow7RuZyB0aW4gdMOgaSBraG/huqNuIGPhu6dhIG3DrG5oIHbDoCB0aMO0bmcgYsOhbyBjaG8gY2jDum5nIHTDtGkgbmdheSBs4bqtcCB04bupYyBu4bq/dSBjw7MgYuG6pXQga+G7syBow6BuaCB2aSBz4butIGThu6VuZyB0csOhaSBwaMOpcCBuw6BvLjwvcD4NCiAgICANCiAgICA8aDI+My4gQuG6o28gTeG6rXQgVGjDtG5nIFRpbjwvaDI+DQogICAgPHA+Q2jDum5nIHTDtGkgY2FtIGvhur90IGLhuqNvIHbhu4cgdGjDtG5nIHRpbiBjw6EgbmjDom4gY+G7p2EgbmfGsOG7nWkgZMO5bmcuIE3hu41pIHRow7RuZyB0aW4gdGh1IHRo4bqtcCBz4bq9IMSRxrDhu6NjIHPhu60gZOG7pW5nIHRoZW8gY2jDrW5oIHPDoWNoIGLhuqNvIG3huq10IGPhu6dhIGNow7puZyB0w7RpLiBDaMO6bmcgdMO0aSBz4bq9IGtow7RuZyBjaGlhIHPhursgdGjDtG5nIHRpbiBjw6EgbmjDom4gY+G7p2EgYuG6oW4gduG7m2kgYsOqbiB0aOG7qSBiYSBtw6Aga2jDtG5nIGPDsyBz4buxIMSR4buTbmcgw70gY+G7p2EgYuG6oW4sIHRy4burIGtoaSDEkcaw4bujYyB5w6p1IGPhuqd1IGLhu59pIHBow6FwIGx14bqtdC48L3A+DQogICAgDQogICAgPGgyPjQuIE7hu5lpIER1bmcgTmfGsOG7nWkgRMO5bmc8L2gyPg0KICAgIDxwPkLhuqFuIGPDsyB0aOG7gyDEkcaw4bujYyBwaMOpcCBn4butaSBob+G6t2MgxJHEg25nIHThuqNpIG7hu5lpIGR1bmcgbMOqbiB3ZWJzaXRlLiBC4bqhbiDEkeG7k25nIMO9IHLhurFuZyBi4bqhbiBz4bq9IGtow7RuZyBn4butaSBu4buZaSBkdW5nIHZpIHBo4bqhbSBi4bqjbiBxdXnhu4FuLCBwaOG7iSBiw6FuZywga2hpw6p1IGTDom0sIGhv4bq3YyBi4bqldCBr4buzIG7hu5lpIGR1bmcgbsOgbyB0csOhaSBwaMOhcCBsdeG6rXQuIENow7puZyB0w7RpIGPDsyBxdXnhu4FuIHjDs2EgaG/hurdjIGNo4buJbmggc+G7rWEgYuG6pXQga+G7syBu4buZaSBkdW5nIG7DoG8gbcOgIGNow7puZyB0w7RpIGNobyBsw6Aga2jDtG5nIHBow7kgaOG7o3AgbcOgIGtow7RuZyBj4bqnbiB0aMO0bmcgYsOhbyB0csaw4bubYy48L3A+DQogICAgDQogICAgPGgyPjUuIFRyw6FjaCBOaGnhu4dtIFBow6FwIEzDvTwvaDI+DQogICAgPHA+Q2jDum5nIHTDtGkga2jDtG5nIGNo4buLdSB0csOhY2ggbmhp4buHbSB24buBIGLhuqV0IGvhu7MgdGhp4buHdCBo4bqhaSBuw6BvIHBow6F0IHNpbmggdOG7qyB2aeG7h2Mgc+G7rSBk4bulbmcgd2Vic2l0ZSwgYmFvIGfhu5NtIG5oxrBuZyBraMO0bmcgZ2nhu5tpIGjhuqFuIOG7nyB2aeG7h2Mgc+G7rSBk4bulbmcgbcOjIGNvZGUgduG7m2kgbeG7pWMgxJHDrWNoIGzhu6thIMSR4bqjbyBob+G6t2MgdmkgcGjhuqFtIHBow6FwIGx14bqtdC4gTmfGsOG7nWkgZMO5bmcgaG/DoG4gdG/DoG4gY2jhu4t1IHRyw6FjaCBuaGnhu4dtIHbhu4EgaMOgbmggdmkgY+G7p2EgbcOsbmggdsOgIGNhbSBr4bq/dCBi4buTaSB0aMaw4budbmcgY2hvIGNow7puZyB0w7RpIHRyb25nIHRyxrDhu51uZyBo4bujcCBjw7MgYuG6pXQga+G7syBraGnhur91IG7huqFpIG7DoG8gcGjDoXQgc2luaCB04burIGjDoG5oIHZpIGPhu6dhIGLhuqFuLjwvcD4NCiAgICANCiAgICA8aDI+Ni4gVGhheSDEkOG7lWkgxJBp4buBdSBLaG/huqNuPC9oMj4NCiAgICA8cD5DaMO6bmcgdMO0aSBjw7MgcXV54buBbiB0aGF5IMSR4buVaSBjw6FjIMSRaeG7gXUga2hv4bqjbiBuw6B5IG3DoCBraMO0bmcgY+G6p24gdGjDtG5nIGLDoW8gdHLGsOG7m2MuIE5nxrDhu51pIGTDuW5nIG7Dqm4gdGjGsOG7nW5nIHh1ecOqbiBraeG7g20gdHJhIMSR4buDIGPhuq1wIG5o4bqtdCBjw6FjIMSRaeG7gXUga2hv4bqjbiBt4bubaSBuaOG6pXQuIFZp4buHYyB0aeG6v3AgdOG7pWMgc+G7rSBk4bulbmcgd2Vic2l0ZSBzYXUga2hpIGPDsyB0aGF5IMSR4buVaSDEkeG7k25nIG5naMSpYSB24bubaSB2aeG7h2MgYuG6oW4gY2jhuqVwIG5o4bqtbiBjw6FjIMSRaeG7gXUga2hv4bqjbiDEkcOjIMSRxrDhu6NjIHPhu61hIMSR4buVaS48L3A+DQogICAgDQogICAgPGgyPjcuIExpw6puIEvhur90IMSQ4bq/biBDw6FjIFRyYW5nIFdlYiBLaMOhYzwvaDI+DQogICAgPHA+V2Vic2l0ZSBj4bunYSBjaMO6bmcgdMO0aSBjw7MgdGjhu4MgY2jhu6lhIGxpw6puIGvhur90IMSR4bq/biBjw6FjIHRyYW5nIHdlYiBraMOhYy4gQ2jDum5nIHTDtGkga2jDtG5nIGtp4buDbSBzb8OhdCB2w6Aga2jDtG5nIGNo4buLdSB0csOhY2ggbmhp4buHbSB24buBIG7hu5lpIGR1bmcsIGNow61uaCBzw6FjaCBi4bqjbyBt4bqtdCBob+G6t2MgY8OhYyBow6BuaCB2aSBj4bunYSBjw6FjIHRyYW5nIHdlYiBuw6B5LiBC4bqhbiBuw6puIHhlbSB4w6l0IGPDoWMgxJFp4buBdSBraG/huqNuIHbDoCDEkWnhu4F1IGtp4buHbiBj4bunYSBjw6FjIHRyYW5nIHdlYiBiw6puIHRo4bupIGJhIHRyxrDhu5tjIGtoaSBz4butIGThu6VuZy48L3A+DQogICAgDQogICAgPGgyPjguIEx14bqtdCDDgXAgROG7pW5nPC9oMj4NCiAgICA8cD5Dw6FjIMSRaeG7gXUga2hv4bqjbiBuw6B5IHPhur0gxJHGsOG7o2MgxJFp4buBdSBjaOG7iW5oIHbDoCBnaeG6o2kgdGjDrWNoIHRoZW8gbHXhuq10IHBow6FwIGPhu6dhIFtRdeG7kWMgZ2lhIGPhu6dhIGLhuqFuXS4gTeG7jWkgdHJhbmggY2jhuqVwIHBow6F0IHNpbmggdOG7qyB2aeG7h2Mgc+G7rSBk4bulbmcgd2Vic2l0ZSBz4bq9IMSRxrDhu6NjIGdp4bqjaSBxdXnhur90IHThuqFpIHQgw7JhIMOhbiBjw7MgdGjhuqltIHF1eeG7gW4gdOG6oWkgW8SQ4buLYSDEkWnhu4NtIGPhu6dhIGLhuqFuXS48L3A+DQogICAgDQogICAgPGgyPjkuIFF1eeG7gW4gTOG7o2kgQ+G7p2EgQ2jDum5nIFTDtGk8L2gyPg0KICAgIDxwPkNow7puZyB0w7RpIGLhuqNvIGzGsHUgcXV54buBbiB04bqhbSBuZ+G7q25nIGhv4bq3YyBjaOG6pW0gZOG7qXQgZOG7i2NoIHbhu6UgbcOgIGtow7RuZyBj4bqnbiB0aMO0bmcgYsOhbyB0csaw4bubYyBu4bq/dSBwaMOhdCBoaeG7h24gYuG6pXQga+G7syBow6BuaCB2aSB2aSBwaOG6oW0gbsOgbyB04burIHBow61hIG5nxrDhu51pIGTDuW5nLiBDaMO6bmcgdMO0aSBjxaluZyBjw7MgcXV54buBbiB04burIGNo4buRaSBjdW5nIGPhuqVwIGThu4tjaCB24bulIGNobyBi4bqldCBr4buzIGFpIG3DoCBjaMO6bmcgdMO0aSBjaG8gbMOgIGPDsyBow6BuaCB2aSBraMO0bmcgcGjDuSBo4bujcC48L3A+DQogICAgDQogICAgPGgyPjEwLiBUaMO0bmcgVGluIExpw6puIEjhu4c8L2gyPg0KICAgIDxwPk7hur91IGLhuqFuIGPDsyBi4bqldCBr4buzIGPDonUgaOG7j2kgbsOgbyB24buBIGPDoWMgxJFp4buBdSBraG/huqNuIG7DoHkgaG/hurdjIGPhuqduIGjhu5cgdHLhu6MsIHZ1aSBsw7JuZyBsacOqbiBo4buHIHbhu5tpIGNow7puZyB0w7RpIHF1YSB0aMO0bmcgdGluIGxpw6puIGzhuqFjIMSRxrDhu6NjIGN1bmcgY+G6pXAgdHLDqm4gd2Vic2l0ZS4gQ2jDum5nIHTDtGkgc+G6vSBj4buRIGfhuq9uZyBwaOG6o24gaOG7k2kgYuG6oW4gdHJvbmcgdGjhu51pIGdpYW4gc+G7m20gbmjhuqV0IGPDsyB0aOG7gy48L3A+', NULL, '2024-10-15 08:50:26', '2025-01-23 12:44:12'),
(7, 'page_deposit_card', NULL, 'PG9sPg0KCTxsaT48c3Ryb25nPkMmYWFjdXRlO2MgxJHGoW4gbuG6oXAgdGjhursgc+G6vSDEkcaw4bujYyBj4buZbmcgdGnhu4FuIGNo4buJIHNhdSAzMHMtMTVwLjwvc3Ryb25nPjwvbGk+DQoJPGxpPjxzdHJvbmc+S2gmb2NpcmM7bmcgbmjhuq1uIHRo4bq7IHThu6sgZ2FtZSBiJmFncmF2ZTtpLCB0aOG6uyDEg24gY+G6r3AsIGzhu6thIMSR4bqjbywga2gmb2NpcmM7bmcgciZvdGlsZGU7IG5ndeG7k24gZ+G7kWMsIHRo4bq7IHImdWFjdXRlO3QgdOG7qyB2aXNhLGNyZWRpdCBjYXJkLi4ucGgmYWFjdXRlO3QgaGnhu4duIGtoJm9hY3V0ZTthIHZ2Ljwvc3Ryb25nPjwvbGk+DQo8L29sPg==', NULL, '2025-01-23 12:26:35', '2025-02-04 05:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(13, 'App\\Models\\User', 1, 'access_token', 'e76c85837660eb61594302c436a032810ec767cee7e1964afd74572be6edeb0d', '[\"*\"]', '2025-02-04 06:21:05', NULL, '2024-11-13 04:44:02', '2025-02-04 06:21:05'),
(14, 'App\\Models\\User', 2, 'access_token', 'cf60760b9522e92a51afdb1cc7130df51ce54d2881bec973cb5f73ba0ab6504b', '[\"*\"]', NULL, NULL, '2024-11-13 05:39:48', '2024-11-13 05:39:48'),
(15, 'App\\Models\\User', 5, 'access_token', 'dffc3dc437fe2d3cc39e92769428c79bad5f9046b404c04109a16b61d3d18117', '[\"*\"]', '2025-02-03 15:52:45', NULL, '2025-02-03 15:38:05', '2025-02-03 15:52:45'),
(16, 'App\\Models\\User', 8, 'access_token', '5339ed729c4a250ea31b5fb2d0b42565bf1efba6441093c737ab032adeab9447', '[\"*\"]', NULL, NULL, '2025-02-04 05:21:05', '2025-02-04 05:21:05'),
(17, 'App\\Models\\User', 11, 'access_token', '704be2124dcfb1fe83bab7e90a672063e0e35536acebc87972b508bf06c1d91a', '[\"*\"]', NULL, NULL, '2025-02-04 10:19:14', '2025-02-04 10:19:14'),
(18, 'App\\Models\\User', 12, 'access_token', '1b6920f9d5a9c1e5982296e0b0665f0e1ccdcaaca015f2758659fe2b6df8c861', '[\"*\"]', NULL, NULL, '2025-02-04 10:20:35', '2025-02-04 10:20:35'),
(19, 'App\\Models\\User', 13, 'access_token', '3c378c075f7fab8a38572f0cedf9aa4c95b4d02efb51d4991a722f3fd8c77e59', '[\"*\"]', NULL, NULL, '2025-02-04 10:22:05', '2025-02-04 10:22:05'),
(20, 'App\\Models\\User', 14, 'access_token', '9203b78a7a25788e9f8b92766f47f1cfc1baa363c5fda1f333fe195cb3debdc7', '[\"*\"]', NULL, NULL, '2025-02-04 10:25:52', '2025-02-04 10:25:52'),
(21, 'App\\Models\\User', 15, 'access_token', 'eb5528444fd82969ed698d4ddac3469b12b84dfd97d26526a921411904b43ead', '[\"*\"]', NULL, NULL, '2025-02-04 10:27:14', '2025-02-04 10:27:14'),
(22, 'App\\Models\\User', 16, 'access_token', '9ba7e8d4d6a6993563fa946d1a11a4809fad79c140a241b6811348ac3249439c', '[\"*\"]', NULL, NULL, '2025-02-04 10:28:22', '2025-02-04 10:28:22'),
(23, 'App\\Models\\User', 1, 'access_token', 'a0f58634d9193c946bdfa508c649cdf3472c16ab33adb916056e80da0e4787ba', '[\"*\"]', '2025-02-04 10:42:45', NULL, '2025-02-04 10:41:51', '2025-02-04 10:42:45'),
(24, 'App\\Models\\User', 1, 'access_token', '49c50d47faca3cccca4586b719349e41fa55d824d05845a6c011e85d7e76c888', '[\"*\"]', '2025-08-10 19:18:14', NULL, '2025-08-08 07:38:49', '2025-08-10 19:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` text COLLATE utf8_unicode_ci,
  `mota` text COLLATE utf8_unicode_ci,
  `image` text COLLATE utf8_unicode_ci,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `view` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `mota`, `image`, `slug`, `content`, `status`, `view`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'Hướng dẫn cách cấu hình SMTP để gửi Email cho website', 'U01UUCBHbWFpbCAodmnhur90IHThuq90IGPhu6dhIFNpbXBsZSBNYWlsIFRyYW5zZmVyIFByb3RvY29sKSDEkcaw4bujYyBz4butIGThu6VuZyDEkeG7gyBn4butaSBlbWFpbCB24bubaSB04buRYyDEkeG7mSBuaGFuaCBjaMOzbmcgbcOgIGtow7RuZyBi4buLIGdp4bubaSBo4bqhbiBz4buRIGzGsOG7o25nIGdp4buRbmcgbmjGsCBjw6FjIGjDsm0gdGjGsCBtaeG7hW4gcGjDrSBj4bunYSBHbWFpbC4=', 'https://i.imgur.com/zOTUBBm.jpeg', 'huong-dan-cach-cau-hinh-smtp-de-gui-email-cho-website', 'PHA+TeG6rXQga2jhuql1IOG7qW5nIGThu6VuZyBHbWFpbCBsJmFncmF2ZTsgZyZpZ3JhdmU7PzwvcD4NCg0KPHA+TeG6rXQga2jhuql1IOG7qW5nIGThu6VuZyBHbWFpbCBsJmFncmF2ZTsgbeG6rXQga2jhuql1IG0mYWdyYXZlOyBi4bqhbiBz4butIGThu6VuZyDEkeG7gyB4JmFhY3V0ZTtjIHRo4buxYyBtJmFhY3V0ZTt5IGNo4bunIGtoaSBi4bqhbiBz4butIGThu6VuZyBt4buZdCDhu6luZyBk4bulbmcga2gmYWFjdXRlO2MgxJHhu4MgdHJ1eSBj4bqtcCB0JmFncmF2ZTtpIGtob+G6o24gPHN0cm9uZz5HbWFpbDwvc3Ryb25nPiBj4bunYSBi4bqhbi4gViZpYWN1dGU7IGThu6UsIG7hur91IGLhuqFuIHPhu60gZOG7pW5nIG3hu5l0IGNoxrDGoW5nIHRyJmlncmF2ZTtuaCB0aMawIMSRaeG7h24gdOG7rSBuaMawIDxzdHJvbmc+TWljcm9zb2Z0IE91dGxvb2s8L3N0cm9uZz4gaG/hurdjIDxzdHJvbmc+QXBwbGUgTWFpbDwvc3Ryb25nPiDEkeG7gyBn4butaSB2JmFncmF2ZTsgbmjhuq1uIGVtYWlsIHThu6sgdCZhZ3JhdmU7aSBraG/huqNuIDxzdHJvbmc+R21haWw8L3N0cm9uZz4gY+G7p2EgYuG6oW4sIGLhuqFuIHPhur0gY+G6p24gc+G7rSBk4bulbmcgbeG6rXQga2jhuql1IOG7qW5nIGThu6VuZyBHbWFpbCDEkeG7gyB4JmFhY3V0ZTtjIHRo4buxYyBtJmFhY3V0ZTt5IGNo4bunIDxzdHJvbmc+R21haWw8L3N0cm9uZz4uPC9wPg0KDQo8aDMgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+VOG6oWkgc2FvIGNoJnVhY3V0ZTtuZyB0YSBwaOG6o2kgdOG6oW8gbeG6rXQga2jhuql1IOG7qW5nIGThu6VuZyBHbWFpbCA/PC9oMz4NCg0KPGg0IHN0eWxlPSJ0ZXh0LWFsaWduOmxlZnQiPkMmb2FjdXRlOyBoYWkgbCZ5YWN1dGU7IGRvIGNoJmlhY3V0ZTtuaCDEkeG7kWkgduG7m2kgdmnhu4djIGLhuqFuIGPhuqduIHThuqFvIG3huq10IGto4bqpdSDhu6luZyBk4bulbmcgR21haWw6PC9oND4NCg0KPHA+QuG6o28gbeG6rXQgdCZhZ3JhdmU7aSBraG/huqNuOiBN4bqtdCBraOG6qXUg4bupbmcgZOG7pW5nIEdtYWlsIGwmYWdyYXZlOyBt4buZdCBjJmFhY3V0ZTtjaCDEkeG7gyBi4bqjbyB24buHIHQmYWdyYXZlO2kga2hv4bqjbiBj4bunYSBi4bqhbiBraOG7j2kgdHJ1eSBj4bqtcCBraCZvY2lyYztuZyDEkcaw4bujYyBwaCZlYWN1dGU7cC4gS2hpIGLhuqFuIHPhu60gZOG7pW5nIG3huq10IGto4bqpdSDhu6luZyBk4bulbmcgR21haWwgxJHhu4MgeCZhYWN1dGU7YyB0aOG7sWMgbSZhYWN1dGU7eSBjaOG7pywgYuG6oW4gYyZvYWN1dGU7IHRo4buDIGNo4bqvYyBjaOG6r24gcuG6sW5nIGNo4buJIGMmYWFjdXRlO2Mg4bupbmcgZOG7pW5nIG0mYWdyYXZlOyBi4bqhbiDEkSZhdGlsZGU7IGNobyBwaCZlYWN1dGU7cCBt4bubaSBjJm9hY3V0ZTsgdGjhu4MgdHJ1eSBj4bqtcCB0JmFncmF2ZTtpIGtob+G6o24gY+G7p2EgYuG6oW4uPC9wPg0KDQo8cD5N4bufIHLhu5luZyBjaOG7qWMgbsSDbmc6IE3huq10IGto4bqpdSDhu6luZyBk4bulbmcgR21haWwgY8WpbmcgY2hvIHBoJmVhY3V0ZTtwIGLhuqFuIHPhu60gZOG7pW5nIGMmYWFjdXRlO2Mg4bupbmcgZOG7pW5nIGtoJmFhY3V0ZTtjIMSR4buDIHRydXkgY+G6rXAgdiZhZ3JhdmU7IHF14bqjbiBsJnlhY3V0ZTsgdCZhZ3JhdmU7aSBraG/huqNuIEdtYWlsIGPhu6dhIGLhuqFuLiBWJmlhY3V0ZTsgZOG7pSwgYuG6oW4gYyZvYWN1dGU7IHRo4buDIHPhu60gZOG7pW5nIGNoxrDGoW5nIHRyJmlncmF2ZTtuaCB0aMawIMSRaeG7h24gdOG7rSBuaMawIE1pY3Jvc29mdCBPdXRsb29rIGhv4bq3YyBBcHBsZSBNYWlsIMSR4buDIGfhu61pIHYmYWdyYXZlOyBuaOG6rW4gZW1haWwgdOG7qyB0JmFncmF2ZTtpIGtob+G6o24gR21haWwgY+G7p2EgYuG6oW4sIGhv4bq3YyBz4butIGThu6VuZyBjJmFhY3V0ZTtjIOG7qW5nIGThu6VuZyBraCZhYWN1dGU7YyDEkeG7gyBxdeG6o24gbCZ5YWN1dGU7IGzhu4tjaCwgZGFuaCBi4bqhIHYmYWdyYXZlOyBjJmFhY3V0ZTtjIHQmYWFjdXRlO2MgduG7pSBraCZhYWN1dGU7YyBsaSZlY2lyYztuIHF1YW4gxJHhur9uIHQmYWdyYXZlO2kga2hv4bqjbiBHbWFpbCBj4bunYSBi4bqhbi48L3A+DQoNCjxwPiZuYnNwOzwvcD4NCg0KPGgzIHN0eWxlPSJ0ZXh0LWFsaWduOmxlZnQiPsSQ4buDIHThuqFvIG3huq10IGto4bqpdSDhu6luZyBk4bulbmcgY2hvIEdtYWlsLCBi4bqhbiBj4bqnbiBsJmFncmF2ZTttIHRoZW8gYyZhYWN1dGU7YyBixrDhu5tjIHNhdTo8L2gzPg0KDQo8aDQgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+Qsaw4bubYyAxOjwvaDQ+DQoNCjxwPi0gxJDEg25nIG5o4bqtcCB2JmFncmF2ZTtvIHQmYWdyYXZlO2kga2hv4bqjbiA8c3Ryb25nPkdtYWlsPC9zdHJvbmc+IGPhu6dhIGLhuqFuLjxiciAvPg0KLSBUcnV5IGPhuq1wIHYmYWdyYXZlO28gdHJhbmcgYyZhZ3JhdmU7aSDEkeG6t3QgYuG6o28gbeG6rXQgdOG6oWkgxJHhu4thIGNo4buJIDxhIGhyZWY9Imh0dHBzOi8vbXlhY2NvdW50Lmdvb2dsZS5jb20vc2VjdXJpdHkiIHRhcmdldD0iX2JsYW5rIj5odHRwczovL215YWNjb3VudC5nb29nbGUuY29tL3NlY3VyaXR5PC9hPiZuYnNwO8SR4buDIGLhuq10IHgmYWFjdXRlO2MgbWluaCAyIGLGsOG7m2MuPC9wPg0KDQo8aDQgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+Qsaw4bubYyAyOjwvaDQ+DQoNCjxkaXY+LSBU4bqhaSAmb2NpcmM7IHQmaWdyYXZlO20ga2nhur9tLCB2dWkgbCZvZ3JhdmU7bmcgbmjhuq1wICZxdW90OzxzdHJvbmc+beG6rXQga2jhuql1IOG7qW5nIGThu6VuZzwvc3Ryb25nPiZxdW90Oy48L2Rpdj4NCg0KPHA+LSBUciZlY2lyYztuIHRyYW5nIHRp4bq/cCBuaOG6pW4gbiZ1YWN1dGU7dCAmcXVvdDs8c3Ryb25nPkNo4buNbiDhu6luZyBk4bulbmc8L3N0cm9uZz4mcXVvdDssIGNo4buNbiAmcXVvdDs8c3Ryb25nPktoJmFhY3V0ZTtjKFQmZWNpcmM7biB0deG7syBjaOG7iW5oKTwvc3Ryb25nPi48L3A+DQoNCjxwPi0g4bueICZvY2lyYzsgdCZlY2lyYztuIOG7qW5nIGThu6VuZywgYyZhYWN1dGU7YyBi4bqhbiBuaOG6rXAgdCZlY2lyYztuIGfhu41pIG5o4bubIMSR4buDIHRp4buHbiBzYXUgbiZhZ3JhdmU7eSB0JmlncmF2ZTttIGzhuqFpIG5oJmVhY3V0ZTsuPC9wPg0KDQo8aDQgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+Qsaw4bubYyAzOjwvaDQ+DQoNCjxwPi0gU2F1IGtoaSB04bqhbyB4b25nIGjhu4cgdGjhu5FuZyBz4bq9IGPhuqVwIGNobyBi4bqhbiBt4buZdCBt4bqtdCBraOG6qXUg4bupbmcgZOG7pW5nLCB0aeG6v3AgdGhlbyBi4bqhbiBjaOG7iSBj4bqnbiBjb3B5IG3huq10IGto4bqpdSDhu6luZyBk4bulbmcgxJEmb2FjdXRlOyBuaOG6rXAgdiZhZ3JhdmU7byAmb2NpcmM7IFBhc3N3b3JkIEVtYWlsIFNNVFAgdHJvbmcgd2Vic2l0ZSBj4bunYSBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBsJmFncmF2ZTsgeG9uZywgbmjhu5sgxJFp4buBbiBlbWFpbCBj4bunYSBi4bqhbiB2JmFncmF2ZTtvICZvY2lyYzsgRW1haWwgU01UUCBu4buvYSBuaCZlYWN1dGU7LjwvcD4NCg0KPGRpdj5MxrB1ICZ5YWN1dGU7OiBN4bqtdCBraOG6qXUg4bupbmcgZOG7pW5nIGNo4buJIMSRxrDhu6NjIHPhu60gZOG7pW5nIGNobyBjJmFhY3V0ZTtjIOG7qW5nIGThu6VuZyBraCZhYWN1dGU7YyBn4butaSBlbWFpbCBxdWEgPHN0cm9uZz5TTVRQPC9zdHJvbmc+LCBraCZvY2lyYztuZyBwaOG6o2kgxJHhu4MgxJHEg25nIG5o4bqtcCB2JmFncmF2ZTtvIHQmYWdyYXZlO2kga2hv4bqjbiA8c3Ryb25nPkdtYWlsPC9zdHJvbmc+IGPhu6dhIGLhuqFuLiZuYnNwOzwvZGl2Pg0KDQo8cD4mbmJzcDs8L3A+', 1, 40, '2025-01-22 11:11:10', '2025-08-10 21:31:22'),
(3, 1, 2, 'Hướng dẫn cấu hình reCAPTCHA vào mã nguồn', 'cmVDQVBUQ0hBIGzDoCBt4buZdCBo4buHIHRo4buRbmcgYuG6o28gbeG6rXQgxJHGsOG7o2MgcGjDoXQgdHJp4buDbiBi4bufaSBHb29nbGUsIGdpw7pwIHjDoWMgbWluaCBuZ8aw4budaSBkw7luZyB0csOqbiBt4bqhbmcgbMOgIGNvbiBuZ8aw4budaSB0aOG7sWMgc+G7sSBoYXkgbMOgIG3hu5l0IGNoxrDGoW5nIHRyw6xuaCBtw6F5IHTDrW5oIHThu7EgxJHhu5luZyAoYm90KS4gTeG7pWMgxJHDrWNoIGPhu6dhIHJlQ0FQVENIQSBsw6AgbmfEg24gY2jhurduIGPDoWMgY3Xhu5ljIHThuqVuIGPDtG5nIHThu6sgY8OhYyBib3QsIGdpw7pwIGLhuqNvIHbhu4cgY8OhYyB0cmFuZyB3ZWIgdsOgIGThu4tjaCB24bulIHRy4buxYyB0dXnhur9uIGto4buPaSBzcGFtIHbDoCBs4bqhbSBk4bulbmcu', 'https://i.imgur.com/ZEUPSfs.jpeg', 'huong-dan-cau-hinh-recaptcha-vao-ma-nguon', 'PHA+xJDhuqd1IHRpJmVjaXJjO24gcXUmeWFjdXRlOyBraCZhYWN1dGU7Y2ggY+G6p24gaGnhu4N1IHImb3RpbGRlOyA8c3Ryb25nPnJlQ0FQVENIQTwvc3Ryb25nPiBsJmFncmF2ZTsgZyZpZ3JhdmU7OjwvcD4NCg0KPHA+PHN0cm9uZz5yZUNBUFRDSEE8L3N0cm9uZz4gbCZhZ3JhdmU7IG3hu5l0IGjhu4cgdGjhu5FuZyBi4bqjbyBt4bqtdCDEkcaw4bujYyBwaCZhYWN1dGU7dCB0cmnhu4NuIGLhu59pIEdvb2dsZSwgZ2kmdWFjdXRlO3AgeCZhYWN1dGU7YyBtaW5oIG5nxrDhu51pIGQmdWdyYXZlO25nIHRyJmVjaXJjO24gbeG6oW5nIGwmYWdyYXZlOyBjb24gbmfGsOG7nWkgdGjhu7FjIHPhu7EgaGF5IGwmYWdyYXZlOyBt4buZdCBjaMawxqFuZyB0ciZpZ3JhdmU7bmggbSZhYWN1dGU7eSB0JmlhY3V0ZTtuaCB04buxIMSR4buZbmcgKGJvdCkuIE3hu6VjIMSRJmlhY3V0ZTtjaCBj4bunYSA8c3Ryb25nPnJlQ0FQVENIQTwvc3Ryb25nPiBsJmFncmF2ZTsgbmfEg24gY2jhurduIGMmYWFjdXRlO2MgY3Xhu5ljIHThuqVuIGMmb2NpcmM7bmcgdOG7qyBjJmFhY3V0ZTtjIGJvdCwgZ2kmdWFjdXRlO3AgYuG6o28gduG7hyBjJmFhY3V0ZTtjIHRyYW5nIHdlYiB2JmFncmF2ZTsgZOG7i2NoIHbhu6UgdHLhu7FjIHR1eeG6v24ga2jhu49pIHNwYW0gdiZhZ3JhdmU7IGzhuqFtIGThu6VuZy48L3A+DQoNCjxwPiZuYnNwOzwvcD4NCg0KPGgyIHN0eWxlPSJ0ZXh0LWFsaWduOmxlZnQiPkMmYWFjdXRlO2NoIGPhuqV1IGgmaWdyYXZlO25oIDxzdHJvbmc+cmVDQVBUQ0hBPC9zdHJvbmc+IG5oxrAgc2F1OjwvaDI+DQoNCjxoMyBzdHlsZT0idGV4dC1hbGlnbjpsZWZ0Ij5CxrDhu5tjIDE6PC9oMz4NCg0KPHA+LSBRdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBj4bqnbiBjJm9hY3V0ZTsgdCZhZ3JhdmU7aSBraG/huqNuIDxzdHJvbmc+R29vZ2xlPC9zdHJvbmc+IHYmYWdyYXZlOyA8c3Ryb25nPkdvb2dsZSBQbGF0Zm9ybTwvc3Ryb25nPi48L3A+DQoNCjxwPi0gVHJ1eSBj4bqtcCB2JmFncmF2ZTtvIGxpJmVjaXJjO24ga+G6v3QmbmJzcDs8YSBocmVmPSJodHRwczovL3d3dy5nb29nbGUuY29tL3JlY2FwdGNoYS9hYm91dC8iIHRhcmdldD0iX2JsYW5rIj5odHRwczovL3d3dy5nb29nbGUuY29tL3JlY2FwdGNoYS9hYm91dC88L2E+Jm5ic3A7xJHhu4MgdiZhZ3JhdmU7byB0cmFuZyA8c3Ryb25nPnJlQ0FQVENIQTwvc3Ryb25nPi48L3A+DQoNCjxoMyBzdHlsZT0idGV4dC1hbGlnbjpsZWZ0Ij5CxrDhu5tjIDI6PC9oMz4NCg0KPHA+LSBOaOG6pW4gdiZhZ3JhdmU7byBtZW51IHYzIEFkbWluIENvbnNvbGUgxJHhu4MgdiZhZ3JhdmU7byB0cmFuZyBxdeG6o24gdHLhu4sgcmVDQVBUQ0hBLjwvcD4NCg0KPHA+LSBOaOG6pW4gdiZhZ3JhdmU7byBpY29uIGThuqV1ICsgKGNyZWF0ZSkgxJHhu4MgdOG6oW8gbeG7m2kgQVBJLjwvcD4NCg0KPHA+PHN0cm9uZz5CxrDhu5tjIDM6PC9zdHJvbmc+PC9wPg0KDQo8ZGl2Pg0KPHA+LSBU4bqhaSB0cmFuZyB0aCZlY2lyYzttIG3hu5tpLCBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBuaOG6rXAgdGgmb2NpcmM7bmcgdGluIG5oxrAgc2F1OjwvcD4NCg0KPHAgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+TGFiZWwgPSZndDsgVCZlY2lyYztuIMSR4buDIG5o4bqtbiBk4bqhbmcgQVBJLCBuJmVjaXJjO24gxJHhu4MgbCZhZ3JhdmU7IHQmZWNpcmM7biB3ZWJzaXRlIGPhu6dhIHF1JnlhY3V0ZTsga2gmYWFjdXRlO2NoLjxiciAvPg0KcmVDQVBUQ0hBIHR5cGUgPSZndDsgQ2jhu41uIG5oxrAg4bqjbmguPGJyIC8+DQpEb21haW5zID0mZ3Q7IE5o4bqtcCB0JmVjaXJjO24gd2Vic2l0ZSBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaC48L3A+DQoNCjxwPi0gVGnhur9wIHRoZW8gxJEmb2FjdXRlOyBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBuaOG6pW4gPHN0cm9uZz5TdWJtaXQ8L3N0cm9uZz4uPC9wPg0KDQo8aDMgc3R5bGU9InRleHQtYWxpZ246bGVmdCI+Qsaw4bubYyA0OjwvaDM+DQoNCjxwPi0gU2FvIGNoJmVhY3V0ZTtwIDxzdHJvbmc+U0lURSBLRVk8L3N0cm9uZz4gdiZhZ3JhdmU7IDxzdHJvbmc+U0VDUkVUIEtFWTwvc3Ryb25nPiBkJmFhY3V0ZTtuIHYmYWdyYXZlO28gdHJhbmcgcXXhuqNuIHRy4buLIGPhu6dhIHF1JnlhY3V0ZTsga2gmYWFjdXRlO2NoIGwmYWdyYXZlOyBYT05HITwvcD4NCg0KPHA+Q2gmdWFjdXRlO2MgcXUmeWFjdXRlOyBraCZhYWN1dGU7Y2ggdGgmYWdyYXZlO25oIGMmb2NpcmM7bmcuPC9wPg0KPC9kaXY+', 1, 9, '2025-01-22 11:25:51', '2025-08-10 21:31:23'),
(4, 1, 1, 'Người dùng trình duyệt Chrome dính mã độc qua tiện ích mở rộng', 'Q8OhYyBjaHV5w6puIGdpYSDEkcOjIHRodSB0aOG6rXAgZOG7ryBsaeG7h3UgYuG6sW5nIGPDoWNoIHBow6JuIHTDrWNoIGPDuiBwaMOhcCB04buHcCBraGFpICouanNvbiBj4bunYSB04burbmcgZXh0ZW5zaW9uLiBOaOG7r25nIHThu4dwIG7DoHkgc2F1IMSRw7MgxJHGsOG7o2MgY2hpYSB0aMOgbmggY8OhYyBxdXnhu4FuIHnDqnUgY+G6p3UgdHJ1eSBj4bqtcCB24buBIEdpYW8gZGnhu4duIGzhuq1wIHRyw6xuaCDhu6luZyBk4bulbmcgKEFQSSkgbmjGsCBi4buZIG5o4bubLCBjb29raWUgdsOgIG3DoXkgY2jhu6cgbmjGsCBVUkwgaG/hurdjIG3huqt1IFVSTC4=', 'https://i.imgur.com/T5Psmbg.jpeg', 'nguoi-dung-trinh-duyet-chrome-dinh-ma-doc-qua-tien-ich-mo-rong', 'PHA+SCZhZ3JhdmU7bmcgdHLEg20gdHJp4buHdSBuZ8aw4budaSBkJnVncmF2ZTtuZyB0ciZpZ3JhdmU7bmggZHV54buHdCBDaHJvbWUgY+G7p2EgR29vZ2xlIMSR4buRaSBt4bq3dCBuZ3V5IGPGoSB24buBIGLhuqNvIG3huq10IGRvIGMmYWdyYXZlO2kgxJHhurd0IHRp4buHbiAmaWFjdXRlO2NoIG3hu58gcuG7mW5nIChleHRlbnNpb24pLjwvcD4NCg0KPHA+TeG7m2kgxJEmYWNpcmM7eSwgxJDhuqFpIGjhu41jIFN0YW5mb3JkIHYmYWdyYXZlOyBUcnVuZyB0JmFjaXJjO20gQuG6o28gbeG6rXQgdGgmb2NpcmM7bmcgdGluIENJU1BBIEhlbG1ob2x0eiBjJm9jaXJjO25nIGLhu5EgbmdoaSZlY2lyYztuIGPhu6l1IGNobyB0aOG6pXksIGjGoW4gMzQ2IHRyaeG7h3UgbMaw4bujdCBuZ8aw4budaSBkJnVncmF2ZTtuZyDEkSZhdGlsZGU7IGMmYWdyYXZlO2kgYyZhYWN1dGU7YyBsb+G6oWkgZXh0ZW5zaW9uIGNo4bupYSBtJmF0aWxkZTsgxJHhu5ljIHRyb25nIGdpYWkgxJFv4bqhbiB04burIHRoJmFhY3V0ZTtuZyA3LzIwMjAgxJHhur9uIHRoJmFhY3V0ZTtuZyAyLzIwMjMuIFNhdSBraGkgdHLhu6sgxJFpIDY2IHRyaeG7h3UgbMaw4bujdCBjJmFncmF2ZTtpIGtoJm9jaXJjO25nIHRoJmFncmF2ZTtuaCBjJm9jaXJjO25nIGRvIHZpIHBo4bqhbSBjaCZpYWN1dGU7bmggcyZhYWN1dGU7Y2ggdiZhZ3JhdmU7IGfhurdwIGzhu5dpLCBuaCZvYWN1dGU7bSBuZ2hpJmVjaXJjO24gY+G7qXUgxrDhu5tjIHQmaWFjdXRlO25oIHbhuqtuIGMmb2dyYXZlO24gMjgwIHRyaeG7h3UgbMaw4bujdCBjJmFncmF2ZTtpIMSR4bq3dCBjaOG7qWEgcGjhuqduIG3hu4FtIMSR4buZYyBo4bqhaS48L3A+DQoNCjxwPkMmYWFjdXRlO2MgY2h1eSZlY2lyYztuIGdpYSDEkSZhdGlsZGU7IHRodSB0aOG6rXAgZOG7ryBsaeG7h3UgYuG6sW5nIGMmYWFjdXRlO2NoIHBoJmFjaXJjO24gdCZpYWN1dGU7Y2ggYyZ1YWN1dGU7IHBoJmFhY3V0ZTtwIHThu4dwIGtoYWkgKi5qc29uIGPhu6dhIHThu6tuZyBleHRlbnNpb24uIE5o4buvbmcgdOG7h3AgbiZhZ3JhdmU7eSBzYXUgxJEmb2FjdXRlOyDEkcaw4bujYyBjaGlhIHRoJmFncmF2ZTtuaCBjJmFhY3V0ZTtjIHF1eeG7gW4geSZlY2lyYzt1IGPhuqd1IHRydXkgY+G6rXAgduG7gSBHaWFvIGRp4buHbiBs4bqtcCB0ciZpZ3JhdmU7bmgg4bupbmcgZOG7pW5nIChBUEkpIG5oxrAgYuG7mSBuaOG7mywgY29va2llIHYmYWdyYXZlOyBtJmFhY3V0ZTt5IGNo4bunIG5oxrAgVVJMIGhv4bq3YyBt4bqrdSBVUkwuPC9wPg0KDQo8cD4mbGRxdW87S2gmb2NpcmM7bmcgYuG6pXQgbmfhu50ga2hpIGMmYWFjdXRlO2MgdGnhu4duICZpYWN1dGU7Y2ggbeG7nyBy4buZbmcgdGjGsOG7nW5nIGMmb2FjdXRlOyB4dSBoxrDhu5tuZyB5JmVjaXJjO3UgY+G6p3Ugbmhp4buBdSBxdXnhu4FuIGjGoW4gbmjhu69uZyBnJmlncmF2ZTsgY+G6p24gdGhp4bq/dC4gRXh0ZW5zaW9uIGMmYWdyYXZlO25nIGMmb2FjdXRlOyBuaGnhu4F1IHF1eeG7gW4sIGto4bqjIG7Eg25nIHThuqVuIGMmb2NpcmM7bmcgYyZhZ3JhdmU7bmcgbOG7m24mcXVvdDssIG5oJm9hY3V0ZTttIG5naGkmZWNpcmM7biBj4bupdSBjaG8gYmnhur90LjwvcD4NCg0KPHA+S2gmb2NpcmM7bmcgY2jhu4kgduG6rXksIGImYWFjdXRlO28gYyZhYWN1dGU7byBjxaluZyBjaOG7iSByYSDEkWnhu4F1IMSRJmFhY3V0ZTtuZyBsbyBuZ+G6oWkgYyZhYWN1dGU7YyBleHRlbnNpb24gY2jhu6lhIHBo4bqnbiBt4buBbSDEkeG7mWMgaOG6oWkgdGjGsOG7nW5nIGMmb2FjdXRlOyB0aOG7nWkgZ2lhbiB04buVbiB04bqhaSB0cnVuZyBiJmlncmF2ZTtuaCBsJmVjaXJjO24gdOG7m2kgMzgwIG5nJmFncmF2ZTt5IHRyxrDhu5tjIGtoaSBi4buLIHBoJmFhY3V0ZTt0IGhp4buHbiB2JmFncmF2ZTsgbG/huqFpIGLhu48uIFRoZW8gRm9yYmVzLCB2aeG7h2MgdOG7k24gdOG6oWkgcXUmYWFjdXRlOyBsJmFjaXJjO3UgdHImZWNpcmM7biB0ciZpZ3JhdmU7bmggZHV54buHdCBraGnhur9uIG5ndXkgY8ahIGThu68gbGnhu4d1IGLhu4sgxJEmYWFjdXRlO25oIGPhuq9wIGMmYWdyYXZlO25nIGzhu5tuLCBz4buRIGzGsOG7o25nIGMmYWdyYXZlO25nIG5oaeG7gXUuPC9wPg0KDQo8cD5OZ28mYWdyYXZlO2nigK9yYSwgbmgmb2FjdXRlO20gbmdoaSZlY2lyYztuIGPhu6l1IGNobyBiaeG6v3QgdCZpYWN1dGU7bmggxJHhur9uIHRoJmFhY3V0ZTtuZyA1LzIwMjQsIGMmb2FjdXRlOyBn4bqnbiAxJSB04buVbmcgbMaw4bujdCBjJmFncmF2ZTtpIGV4dGVuc2lvbiB0ciZlY2lyYztuIENocm9tZSBjaOG7qWEgcGjhuqduIG3hu4FtIMSR4buZYyBo4bqhaS4gVGhlbyB0aOG7kW5nIGsmZWNpcmM7IGPhu6dhIEdvb2dsZSwgaMahbiAyNTAuMDAwIGV4dGVuc2lvbiDEkWFuZyBjJm9hY3V0ZTsgbeG6t3QgdHImZWNpcmM7biBj4butYSBoJmFncmF2ZTtuZyBDaHJvbWUgdHLhu7FjIHR1eeG6v24sIG5oaeG7gXUgaMahbiBi4bqldCBj4bupIHRyJmlncmF2ZTtuaCBkdXnhu4d0IG4mYWdyYXZlO28ga2gmYWFjdXRlO2MuPC9wPg0KDQo8cD5Hb29nbGUgY8WpbmcgxJHhu4EgeHXhuqV0IG5nxrDhu51pIGQmdWdyYXZlO25nIG4mZWNpcmM7biB0aOG7sWMgaGnhu4duIGLhu5FuIGMmYWFjdXRlO2NoIMSR4buDIGdp4bqjbSBuZ3V5IGPGoSB04bqjaSB24buBIHBo4bqnbiBt4buBbSDEkeG7mWMgaOG6oWkuIFRyb25nIMSRJm9hY3V0ZTssIGjhu40gY+G6p24geGVtIGzhuqFpIHRoJm9jaXJjO25nIHRpbiBtJmFncmF2ZTsgZXh0ZW5zaW9uIMSRJm9hY3V0ZTsgdGh1IHRo4bqtcCB0csaw4bubYyBraGkgYyZhZ3JhdmU7aTsgZ+G7oSBjJmFncmF2ZTtpIMSR4bq3dCBuaOG7r25nIGV4dGVuc2lvbiBraCZvY2lyYztuZyBjJm9ncmF2ZTtuIHPhu60gZOG7pW5nOyBnaeG7m2kgaOG6oW4gYyZhYWN1dGU7YyB3ZWJzaXRlIG0mYWdyYXZlOyBleHRlbnNpb24gYyZvYWN1dGU7IHRo4buDIGhv4bqhdCDEkeG7mW5nOyB2JmFncmF2ZTsgYuG6rXQgY2jhur8gxJHhu5kgQuG6o28gduG7hyBuJmFjaXJjO25nIGNhbyBraGkgZHV54buHdCB3ZWIgbuG6v3UgY+G6p24uPC9wPg0KDQo8cD5UaGVvIFN0YXRjb3VudGVyLCB0JmlhY3V0ZTtuaCDEkeG6v24gaOG6v3QgdGgmYWFjdXRlO25nIDUvMjAyNCwgQ2hyb21lIHbhuqtuIGwmYWdyYXZlOyB0ciZpZ3JhdmU7bmggZHV54buHdCB0aOG7kW5nIHRy4buLIHbhu5tpIGjGoW4gMywyIHThu7cgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcuIFRyJmVjaXJjO24gbSZhYWN1dGU7eSB0JmlhY3V0ZTtuaCwgdHImaWdyYXZlO25oIGR1eeG7h3QgYyZvYWN1dGU7IHRo4buLIHBo4bqnbiA2NCw4NyUsIHbGsOG7o3QgeGEgaGFpIHbhu4sgdHImaWFjdXRlOyB0aeG6v3AgdGhlbyBsJmFncmF2ZTsgTWljcm9zb2Z0IEVkZ2UgduG7m2kgMTMsMTQlIHYmYWdyYXZlOyBTYWZhcmkgbCZhZ3JhdmU7IDgsNzklLiBUciZlY2lyYztuIHRoaeG6v3QgYuG7iyBkaSDEkeG7mW5nLCBDaHJvbWUgY2hp4bq/bSA2NSw5NCUsIFNhZmFyaSB0aOG7qSBoYWkgduG7m2kgMjMsNDclIHYmYWdyYXZlOyBTYW1zdW5nIEludGVybmV0IDQsNDMlLjwvcD4=', 1, 9, '2025-01-22 12:18:11', '2025-08-10 21:31:13'),
(5, 1, 1, 'Cảnh báo lừa đảo đánh cắp mã OTP bằng cuộc gọi AI', 'S2hpIG7huqFuIG5ow6JuIG5o4bqtcCB0w6puIMSRxINuZyBuaOG6rXAgdsOgIG3huq10IGto4bqpdSB2w6BvIHdlYnNpdGUgZ2nhuqMgbeG6oW8sIGvhursgbOG7q2EgxJHhuqNvIHPhur0gdOG7sSDEkeG7mW5nIHRodSB0aOG6rXAgdGjDtG5nIHRpbiBuZ2F5IGzhuq1wIHThu6ljLCB0aGVvIHRo4budaSBnaWFuIHRo4buxYy4gU2F1IMSRw7MsIGNow7puZyBz4bq9IMSRxINuZyBuaOG6rXAgdsOgIGvDrWNoIGhv4bqhdCB2aeG7h2MgZ+G7rWkgbcOjIE9UUCDEkeG6v24gxJFp4buHbiB0aG/huqFpIGPhu6dhIG7huqFuIG5ow6JuLg==', 'https://i.imgur.com/yBYUlKH.jpeg', 'canh-bao-lua-dao-danh-cap-ma-otp-bang-cuoc-goi-ai', 'PHA+Vmnhu4djIHgmYWFjdXRlO2MgdGjhu7FjIDIgeeG6v3UgdOG7kSBi4bqxbmcgbSZhdGlsZGU7IE9UUCDEkcaw4bujYyB4ZW0gbCZhZ3JhdmU7IGJp4buHbiBwaCZhYWN1dGU7cCBi4bqjbyBt4bqtdCBhbiB0byZhZ3JhdmU7bi4gVHV5IG5oaSZlY2lyYztuIGMmYWFjdXRlO2MgdGluIHThurdjIMSRJmF0aWxkZTsgdCZpZ3JhdmU7bSByYSBr4bq9IGjhu58gxJHhu4Mgc+G7rSBk4bulbmcgcGjGsMahbmcgcGgmYWFjdXRlO3AgbiZhZ3JhdmU7eSB04bqlbiBjJm9jaXJjO25nIGzhu6thIMSR4bqjby4gS2hpIG7huqFuIG5oJmFjaXJjO24gbmjhuq1wIHQmZWNpcmM7biDEkcSDbmcgbmjhuq1wIHYmYWdyYXZlOyBt4bqtdCBraOG6qXUgdiZhZ3JhdmU7byB3ZWJzaXRlIGdp4bqjIG3huqFvLCBr4bq7IGzhu6thIMSR4bqjbyBz4bq9IHThu7EgxJHhu5luZyB0aHUgdGjhuq1wIHRoJm9jaXJjO25nIHRpbiBuZ2F5IGzhuq1wIHThu6ljLCB0aGVvIHRo4budaSBnaWFuIHRo4buxYy4gU2F1IMSRJm9hY3V0ZTssIGNoJnVhY3V0ZTtuZyBz4bq9IMSRxINuZyBuaOG6rXAgdiZhZ3JhdmU7IGsmaWFjdXRlO2NoIGhv4bqhdCB2aeG7h2MgZ+G7rWkgbSZhdGlsZGU7IE9UUCDEkeG6v24gxJFp4buHbiB0aG/huqFpIGPhu6dhIG7huqFuIG5oJmFjaXJjO24uPC9wPg0KDQo8cD5YJmFhY3V0ZTtjIHRo4buxYyAyIHnhur91IHThu5EgKDJGQSkgbCZhZ3JhdmU7IHQmaWFjdXRlO25oIG7Eg25nIGLhuqNvIG3huq10IHRpJmVjaXJjO3UgY2h14bqpbiB0cm9uZyBhbiBuaW5oIG3huqFuZy4gVCZpYWN1dGU7bmggbsSDbmcgbiZhZ3JhdmU7eSB5JmVjaXJjO3UgY+G6p3UgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgeCZhYWN1dGU7YyBtaW5oIGRhbmggdCZpYWN1dGU7bmggYuG6sW5nIG3hu5l0IGLGsOG7m2MgeCZhYWN1dGU7YyB0aOG7sWMgdGjhu6kgaGFpLCB0aMaw4budbmcgbCZhZ3JhdmU7IG3huq10IGto4bqpdSBkJnVncmF2ZTtuZyBt4buZdCBs4bqnbiAoT1RQKSDEkcaw4bujYyBn4butaSBxdWEgdGluIG5o4bqvbiB2xINuIGLhuqNuLCBlbWFpbCBob+G6t2Mg4bupbmcgZOG7pW5nLiZuYnNwOzwvcD4NCg0KPHA+TOG7m3AgYuG6o28gbeG6rXQgYuG7lSBzdW5nIG4mYWdyYXZlO3kgxJHGsOG7o2MgdOG6oW8gcmEgbmjhurFtIG3hu6VjIMSRJmlhY3V0ZTtjaCBi4bqjbyB24buHIHQmYWdyYXZlO2kga2hv4bqjbiBj4bunYSBuZ8aw4budaSBkJnVncmF2ZTtuZyBuZ2F5IGPhuqMga2hpIG3huq10IGto4bqpdSBj4bunYSBo4buNIGLhu4sgxJEmYWFjdXRlO25oIGPhuq9wLiBUdXkgduG6rXksIGMmYWFjdXRlO2MgaGFja2VyIMSRYW5nIHQmaWdyYXZlO20gYyZhYWN1dGU7Y2ggcXVhIG3hurd0ICZsZHF1bzti4bupYyB0xrDhu51uZyBs4butYSZyZHF1bzsgbiZhZ3JhdmU7eSBi4bqxbmcgYyZhYWN1dGU7YyBiaeG7h24gcGgmYWFjdXRlO3AgdOG6pW4gYyZvY2lyYztuZyBwaGkga+G7uSB0aHXhuq10LiZuYnNwOzwvcD4NCg0KPHA+S2hpIG7huqFuIG5oJmFjaXJjO24gbmjhuq1wIHQmZWNpcmM7biDEkcSDbmcgbmjhuq1wIHYmYWdyYXZlOyBt4bqtdCBraOG6qXUgdiZhZ3JhdmU7byB3ZWJzaXRlIGdp4bqjIG3huqFvLCA8YSBocmVmPSJodHRwczovL2NoZWNrc2NhbS5jb20vc2NhbXMiPjxlbT5r4bq7IGzhu6thIMSR4bqjbzwvZW0+PC9hPiBz4bq9IHThu7EgxJHhu5luZyB0aHUgdGjhuq1wIHRoJm9jaXJjO25nIHRpbiBuZ2F5IGzhuq1wIHThu6ljLCB0aGVvIHRo4budaSBnaWFuIHRo4buxYy4gU2F1IMSRJm9hY3V0ZTssIGNoJnVhY3V0ZTtuZyBz4bq9IMSRxINuZyBuaOG6rXAgdiZhZ3JhdmU7IGsmaWFjdXRlO2NoIGhv4bqhdCB2aeG7h2MgZ+G7rWkgbSZhdGlsZGU7IE9UUCDEkeG6v24gxJFp4buHbiB0aG/huqFpIGPhu6dhIG7huqFuIG5oJmFjaXJjO24uJm5ic3A7PC9wPg0KDQo8cD5UaCZvY2lyYztuZyB0aMaw4budbmcsIG5nYXkgY+G6oyBraGkgbOG7mSBt4bqtdCBraOG6qXUsIHQmYWdyYXZlO2kga2hv4bqjbiBj4bunYSBuZ8aw4budaSBkJnVncmF2ZTtuZyBz4bq9IMSRxrDhu6NjIGLhuqNvIHbhu4cgYuG6sW5nIHZp4buHYyB4JmFhY3V0ZTtjIHRo4buxYyAyIHnhur91IHThu5EgaGF5IHgmYWFjdXRlO2MgdGjhu7FjIDIgYsaw4bubYy4gVHV5IG5oaSZlY2lyYztuLCB4deG6pXQgaGnhu4duIGNoaSZlY2lyYzt1IHRyJm9ncmF2ZTsgbeG7m2kga2hpIGvhursgbOG7q2EgxJHhuqNvIHPhu60gZOG7pW5nIGJvdCBPVFAgxJHhu4MgbOG7q2EgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgdGnhur90IGzhu5kgbSZhdGlsZGU7IE9UUC48L3A+DQoNCjxwPk5o4buvbmcgY29uIGJvdCBPVFAgc+G6vSB04buxIMSR4buZbmcgZ+G7jWkgxJFp4buHbiDEkeG6v24gbuG6oW4gbmgmYWNpcmM7biwgbeG6oW8gZGFuaCBuaCZhY2lyYztuIHZpJmVjaXJjO24gY+G7p2EgbeG7mXQgdOG7lSBjaOG7qWMgxJEmYWFjdXRlO25nIHRpbiBj4bqteS4gQm90IE9UUCBz4butIGThu6VuZyBr4buLY2ggYuG6o24gaOG7mWkgdGhv4bqhaSDEkcaw4bujYyBs4bqtcCB0ciZpZ3JhdmU7bmggc+G6tW4gxJHhu4MgdGh1eeG6v3QgcGjhu6VjIG7huqFuIG5oJmFjaXJjO24gdGnhur90IGzhu5kgbSZhdGlsZGU7IE9UUC4gVGgmb2NpcmM7bmcgcXVhIMSRJm9hY3V0ZTssIGhhY2tlciBjJm9hY3V0ZTsgxJHGsOG7o2MgbSZhdGlsZGU7IE9UUCB2JmFncmF2ZTsgc+G7rSBk4bulbmcgbiZvYWN1dGU7IMSR4buDIHRydXkgY+G6rXAgdHImYWFjdXRlO2kgcGgmZWFjdXRlO3AgdiZhZ3JhdmU7byB0JmFncmF2ZTtpIGtob+G6o24uPC9wPg0KDQo8cD5L4bq7IGzhu6thIMSR4bqjbyDGsHUgdGkmZWNpcmM7biBz4butIGThu6VuZyBjdeG7mWMgZ+G7jWkgdGhv4bqhaSB0aGF5IGNobyB0aW4gbmjhuq9uLCB2JmlncmF2ZTsgbuG6oW4gbmgmYWNpcmM7biBjJm9hY3V0ZTsgeHUgaMaw4bubbmcgcGjhuqNuIGjhu5NpIG5oYW5oIGjGoW4ga2hpICZhYWN1dGU7cCBk4bulbmcgaCZpZ3JhdmU7bmggdGjhu6ljIG4mYWdyYXZlO3kuIMSQ4buDIHTEg25nIGhp4buHdSBxdeG6oywgYm90IE9UUCBz4bq9IG0mb2NpcmM7IHBo4buPbmcgZ2nhu41uZyDEkWnhu4d1IHYmYWdyYXZlOyBz4buxIGto4bqpbiB0csawxqFuZyBj4bunYSBjb24gbmfGsOG7nWkgdHJvbmcgY3Xhu5ljIGfhu41pIG5o4bqxbSB04bqhbyBj4bqjbSBnaSZhYWN1dGU7YyB0aW4gY+G6rXkgdiZhZ3JhdmU7IHTEg25nIHQmaWFjdXRlO25oIHRodXnhur90IHBo4bulYy4mbmJzcDs8L3A+DQoNCjxwPk5o4buvbmcgY29uIGJvdCBPVFAgxJHGsOG7o2MgxJFp4buBdSBraGnhu4NuIHRy4buxYyB0dXnhur9uIGhv4bq3YyB0aCZvY2lyYztuZyBxdWEgbuG7gW4gdOG6o25nIG5o4bqvbiB0aW4gbmjGsCBUZWxlZ3JhbS4gQ2gmdWFjdXRlO25nIGMmb2dyYXZlO24gxJFpIGsmZWdyYXZlO20gduG7m2kgbmhp4buBdSB0JmlhY3V0ZTtuaCBuxINuZyB2JmFncmF2ZTsgZyZvYWN1dGU7aSDEkcSDbmcgayZ5YWN1dGU7IGtoJmFhY3V0ZTtjIG5oYXUsIGvhursgdOG6pW4gYyZvY2lyYztuZyBjJm9hY3V0ZTsgdGjhu4MgdCZ1Z3JhdmU7eSBjaOG7iW5oIHQmaWFjdXRlO25oIG7Eg25nIGPhu6dhIGJvdCDEkeG7gyBt4bqhbyBkYW5oIGMmYWFjdXRlO2MgdOG7lSBjaOG7qWMsIHPhu60gZOG7pW5nIMSRYSBuZyZvY2lyYztuIG5n4buvIHYmYWdyYXZlOyB0aOG6rW0gY2gmaWFjdXRlOyBjaOG7jW4gdCZvY2lyYztuZyBnaeG7jW5nIG5hbSBob+G6t2MgbuG7ry4mbmJzcDs8L3A+DQoNCjxwPkMmYWFjdXRlO2MgdCZ1Z3JhdmU7eSBjaOG7jW4gbiZhY2lyYztuZyBjYW8gYyZvZ3JhdmU7biBiYW8gZ+G7k20gZ2nhuqMgbeG6oW8gc+G7kSDEkWnhu4duIHRob+G6oWkgaGnhu4NuIHRo4buLIGdp4buRbmcgbmjGsCDEkeG6v24gdOG7qyBt4buZdCB04buVIGNo4bupYyBo4bujcCBwaCZhYWN1dGU7cCBuaOG6sW0gxJEmYWFjdXRlO25oIGzhu6thIG7huqFuIG5oJmFjaXJjO24gbeG7mXQgYyZhYWN1dGU7Y2ggdGluaCB2aS4gVuG7m2kgc+G7sSB4deG6pXQgaGnhu4duIGPhu6dhIGMmYWFjdXRlO2MgYm90IE9UUCwgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgxJFhbmcgcGjhuqNpIMSR4buRaSBt4bq3dCB24bubaSBuaOG7r25nIG5ndXkgY8ahIG3hu5tpIHbhu4EgYuG6o28gbeG6rXQuJm5ic3A7PC9wPg0KDQo8cD7EkOG7gyBraCZvY2lyYztuZyB0cuG7nyB0aCZhZ3JhdmU7bmggbuG6oW4gbmgmYWNpcmM7biwgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgY+G6p24gdHImYWFjdXRlO25oIG5o4bqlcCB2JmFncmF2ZTtvIGMmYWFjdXRlO2MgxJHGsOG7nW5nIGxpbmsgxJEmYWFjdXRlO25nIG5n4budIMSRxrDhu6NjIGfhu61pIMSR4bq/biBxdWEgZW1haWwsIHRpbiBuaOG6r24uIE7hur91IGzhuqduIMSR4bqndSB0cnV5IGPhuq1wIHYmYWdyYXZlO28gbeG7mXQgd2Vic2l0ZSBuJmFncmF2ZTtvIMSRJm9hY3V0ZTssIGgmYXRpbGRlO3kga2nhu4NtIHRyYSB0aCZvY2lyYztuZyB0aW4gduG7gSDEkcahbiB24buLIGNo4bunIHF14bqjbiB0cmFuZyB3ZWIgYuG6sW5nIGMmb2NpcmM7bmcgY+G7pSBXaG9pcy4mbmJzcDs8L3A+DQoNCjxwPktoaSBnJm90aWxkZTsgxJHhu4thIGNo4buJIGMmYWFjdXRlO2MgdHJhbmcgbeG6oW5nIHgmYXRpbGRlOyBo4buZaSBoYXkgbmcmYWNpcmM7biBoJmFncmF2ZTtuZywgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgY+G6p24gdHImYWFjdXRlO25oIGzhu5dpIMSRJmFhY3V0ZTtuaCBtJmFhY3V0ZTt5IGMmb2FjdXRlOyB0aOG7gyB2Jm9jaXJjOyB0JmlncmF2ZTtuaCBk4bqrbiDEkeG6v24gd2Vic2l0ZSBnaeG6oyBt4bqhby4gVGhheSB2JmlncmF2ZTsgdCZpZ3JhdmU7bSBraeG6v20gdHImZWNpcmM7biBHb29nbGUgxJHhu4MgcuG7k2kgYuG7iyBk4bqrbiBk4bulIHYmYWdyYXZlO28gYyZhYWN1dGU7YyB0cmFuZyB3ZWIgeOG6pXUsIG5nxrDhu51pIGQmdWdyYXZlO25nIG4mZWNpcmM7biBz4butIGThu6VuZyBk4bqldSB0cmFuZyDEkeG7gyBsxrB1IGzhuqFpIGMmYWFjdXRlO2Mgd2Vic2l0ZSB0cnV5IGPhuq1wIHRoxrDhu51uZyB4dXkmZWNpcmM7bi4gJm5ic3A7PC9wPg0KDQo8cD5DJmFhY3V0ZTtjIG5nJmFjaXJjO24gaCZhZ3JhdmU7bmcsIHYmaWFjdXRlOyDEkWnhu4duIHThu60gdXkgdCZpYWN1dGU7biBraCZvY2lyYztuZyBiYW8gZ2nhu50gaOG7j2kgbSZhdGlsZGU7IE9UUCBj4bunYSBuZ8aw4budaSBkJnVncmF2ZTtuZy4gVHJvbmcgbeG7jWkgdHLGsOG7nW5nIGjhu6NwLCBuZ8aw4budaSBkJnVncmF2ZTtuZyB0dXnhu4d0IMSR4buRaSBraCZvY2lyYztuZyBjdW5nIGPhuqVwIG0mYXRpbGRlOyBPVFAgY2hvIG5nxrDhu51pIGtoJmFhY3V0ZTtjLCDEkeG6t2MgYmnhu4d0IGwmYWdyYXZlOyBxdWEgYyZhYWN1dGU7YyBjdeG7mWMgZ+G7jWksIHRpbiBuaOG6r24sIGLhuqV0IGvhu4MgbuG7mWkgZHVuZyB0aCZvY2lyYztuZyB0aW4gYyZvYWN1dGU7IHbhursgdGh1eeG6v3QgcGjhu6VjIMSR4bq/biDEkSZhY2lyYzt1LiZuYnNwOzxiciAvPg0KJm5ic3A7PC9wPg==', 1, 3, '2025-01-22 13:13:15', '2025-08-10 21:31:15'),
(6, 1, 1, 'Nguy cơ bị đánh cắp tài khoản ngân hàng khi dùng WiFi lạ', 'TmfDoHkgbmF5LCBXaUZpIG1p4buFbiBwaMOtIGPDsyBz4bq1biB04bqhaSBuaGnhu4F1IG7GoWkga2jDoWMgbmhhdSBuaMawIGPDoWMga2h1IHbhu7FjIGPDtG5nIGPhu5luZywgY+G7rWEgaMOgbmcgaGF5IHF1w6FuIGPDoCBwaMOqLiBOZ8aw4budaSBkw7luZyBjw7MgdGjhu4MgZOG7hSBkw6BuZyB0cnV5IGPhuq1wIHbDoG8gY8OhYyBt4bqhbmcgV2lGaSBuw6B5IHbDoCBz4butIGThu6VuZyBtw6Aga2jDtG5nIGPhuqduIG3huq10IGto4bqpdS4=', 'https://i.imgur.com/qYi5Tx8.jpeg', 'nguy-co-bi-danh-cap-tai-khoan-ngan-hang-khi-dung-wifi-la', 'PHA+TmcmYWdyYXZlO3kgbmF5LCBXaUZpIG1p4buFbiBwaCZpYWN1dGU7IGMmb2FjdXRlOyBz4bq1biB04bqhaSBuaGnhu4F1IG7GoWkga2gmYWFjdXRlO2MgbmhhdSBuaMawIGMmYWFjdXRlO2Mga2h1IHbhu7FjIGMmb2NpcmM7bmcgY+G7mW5nLCBj4butYSBoJmFncmF2ZTtuZyBoYXkgcXUmYWFjdXRlO24gYyZhZ3JhdmU7IHBoJmVjaXJjOy4gTmfGsOG7nWkgZCZ1Z3JhdmU7bmcgYyZvYWN1dGU7IHRo4buDIGThu4UgZCZhZ3JhdmU7bmcgdHJ1eSBj4bqtcCB2JmFncmF2ZTtvIGMmYWFjdXRlO2MgbeG6oW5nIFdpRmkgbiZhZ3JhdmU7eSB2JmFncmF2ZTsgc+G7rSBk4bulbmcgbSZhZ3JhdmU7IGtoJm9jaXJjO25nIGPhuqduIG3huq10IGto4bqpdS48L3A+DQoNCjxwPkNoJmlhY3V0ZTtuaCB2JmlncmF2ZTsgdCZpYWN1dGU7bmggdGnhu4duIGzhu6NpIHRyJmVjaXJjO24sIG5oaeG7gXUgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcgdGjGsOG7nW5nIGNo4bunIHF1YW4ga2hpIHRydXkgY+G6rXAgSW50ZXJuZXQgdGgmb2NpcmM7bmcgcXVhIGMmYWFjdXRlO2MgbeG6oW5nIFdpRmkgYyZvY2lyYztuZyBj4buZbmcuIFR1eSB24bqteSwgxJEmYWNpcmM7eSBjJm9hY3V0ZTsgdGjhu4MgbCZhZ3JhdmU7IGMmb2NpcmM7bmcgY+G7pSDEkeG7gyB0aW4gdOG6t2MgdOG6pW4gYyZvY2lyYztuZyB0aGnhur90IGLhu4sgY+G7p2EgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcsIHThu6sgxJEmb2FjdXRlOyDEkSZhYWN1dGU7bmggY+G6r3AgdGgmb2NpcmM7bmcgdGluIGMmYWFjdXRlOyBuaCZhY2lyYztuIHYmYWdyYXZlOyB0aeG7gW4gdHJvbmcgdCZhZ3JhdmU7aSBraG/huqNuIG5nJmFjaXJjO24gaCZhZ3JhdmU7bmcuPC9wPg0KDQo8cD5IJmlncmF2ZTtuaCB0aOG7qWMgdOG6pW4gYyZvY2lyYztuZyBwaOG7lSBiaeG6v24gbCZhZ3JhdmU7IHRpbiB04bq3YyBz4bq9IGThu7FuZyBsJmVjaXJjO24gYyZhYWN1dGU7YyBt4bqhbmcgV2lGaSBnaeG6oyBt4bqhbyBjJm9hY3V0ZTsgdCZlY2lyYztuIGfhuqduIGdp4buRbmcgduG7m2kgYyZhYWN1dGU7YyDEkWnhu4NtIFdpRmkgYyZvY2lyYztuZyBj4buZbmcgxJHhu4MgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcga2gmb2FjdXRlOyBwaCZhY2lyYztuIGJp4buHdC4gTeG7pWMgxJEmaWFjdXRlO2NoIG5o4bqxbSDEkSZhYWN1dGU7bmggbOG7q2EgbmfGsOG7nWkgZCZ1Z3JhdmU7bmcga+G6v3QgbuG7kWkgdiZhZ3JhdmU7byBo4buHIHRo4buRbmcgV2lGaSBuJmFncmF2ZTt5LCB04burIMSRJm9hY3V0ZTsga2nhu4NtIHNvJmFhY3V0ZTt0IGThu68gbGnhu4d1PC9wPg0KDQo8cD5TYXUgxJEmb2FjdXRlOywgdGluIHThurdjIHPhur0ga2nhu4NtIHNvJmFhY3V0ZTt0IMSRxrDhu6NjIHRvJmFncmF2ZTtuIGLhu5kgYyZhYWN1dGU7YyBr4bq/dCBu4buRaSB04burIHRoaeG6v3QgYuG7iyByYSBJbnRlcm5ldC4gVGluIHThurdjIGMmb2FjdXRlOyB0aOG7gyDEkeG7qW5nIOG7nyBnaeG7r2EsIHRo4buxYyBoaeG7h24gxJEmYWFjdXRlO25oIGPhuq9wIHRoJm9jaXJjO25nIHRpbiBob+G6t2MgY2h1eeG7g24gaMaw4bubbmcgdHJ1eSBj4bqtcCDEkeG6v24gYyZhYWN1dGU7YyB0cmFuZyB3ZWIgZ2nhuqMgbeG6oW8uIENoJnVhY3V0ZTtuZyBz4bq9IGzhu6thIG5nxrDhu51pIGQmdWdyYXZlO25nIG5o4bqtcCB0aCZvY2lyYztuZyB0aW4gdCZhZ3JhdmU7aSBraG/huqNuLCBt4bqtdCBraOG6qXUsIHRo4bqtbSBjaCZpYWN1dGU7IGwmYWdyYXZlOyBtJmF0aWxkZTsgT1RQIMSR4buDIGNoaeG6v20gxJFv4bqhdCB0JmFncmF2ZTtpIHPhuqNuLjwvcD4NCg0KPHA+Q2jGsGEgZOG7q25nIGzhuqFpIOG7nyDEkSZvYWN1dGU7LCB0aW4gdOG6t2MgYyZvZ3JhdmU7biBjJm9hY3V0ZTsga2jhuqMgbsSDbmcgY2FuIHRoaeG7h3AgdiZhZ3JhdmU7byBxdSZhYWN1dGU7IHRyJmlncmF2ZTtuaCBkdXnhu4d0IHdlYiwgdOG7qyDEkSZvYWN1dGU7IGzhu6thIG5nxrDhu51pIGQmdWdyYXZlO25nIGMmYWdyYXZlO2kgxJHhurd0IHBo4bqnbiBt4buBbSBnaeG6oyBt4bqhbywgbSZhdGlsZGU7IMSR4buZYyBjaGnhur9tIHF1eeG7gW4gxJFp4buBdSBraGnhu4NuIMSRaeG7h24gdGhv4bqhaSwgbSZhYWN1dGU7eSB0JmlhY3V0ZTtuaDwvcD4NCg0KPHA+xJDhu4MgdHImYWFjdXRlO25oIGLhu4sgdOG6pW4gYyZvY2lyYztuZywga2hpIGvhur90IG7hu5FpIHYmYWdyYXZlO28gYyZhYWN1dGU7YyBt4bqhbmcgV2lGaSBraCZvY2lyYztuZyDEkeG6o20gYuG6o28sIG5nxrDhu51pIGQmdWdyYXZlO25nIGNo4buJIG4mZWNpcmM7biB0cnV5IGPhuq1wIGMmYWFjdXRlO2MgdHJhbmcgd2ViIGMmb2FjdXRlOyB0JmVjaXJjO24gbWnhu4FuIGLhuq90IMSR4bqndSBi4bqxbmcgJnF1b3Q7aHR0cHMmcXVvdDsuIMSQJmFjaXJjO3kgbCZhZ3JhdmU7IGMmYWFjdXRlO2MgdHJhbmcgd2ViIGMmb2FjdXRlOyBtJmF0aWxkZTsgaCZvYWN1dGU7YSwgeCZhYWN1dGU7YyB0aOG7sWMuPC9wPg0KDQo8cD5W4bubaSBjJmFhY3V0ZTtjIG3huqFuZyBXaUZpIG4mYWdyYXZlO3ksIG5nxrDhu51pIGQmdWdyYXZlO25nIGPFqW5nIGNo4buJIG4mZWNpcmM7biBz4butIGThu6VuZyDEkeG7gyDEkeG7jWMgdGgmb2NpcmM7bmcgdGluLCBo4bqhbiBjaOG6vyBjJmFhY3V0ZTtjIHRoYW8gdCZhYWN1dGU7YyDEkcSDbmcgbmjhuq1wLCBnaWFvIGThu4tjaCBoYXkgY2h1eeG7g24gdGnhu4FuLjwvcD4NCg0KPHA+VHJvbmcgdHLGsOG7nW5nIGjhu6NwIGPhuqduIGdpYW8gZOG7i2NoLCB04buRdCBuaOG6pXQgbiZlY2lyYztuIHPhu60gZOG7pW5nIHRyJmVjaXJjO24ga+G6v3QgbuG7kWkgM0csIDRHIGPhu6dhIMSRaeG7h24gdGhv4bqhaS4gQiZlY2lyYztuIGPhuqFuaCDEkSZvYWN1dGU7LCBuZ8aw4budaSBkJnVncmF2ZTtuZyBj4bqnbiBraeG7g20gdHJhIGzhuqFpIGMmYWFjdXRlO2MgdGgmb2NpcmM7bmcgdGluIGvhu7kgYyZhZ3JhdmU7bmcgdHLGsOG7m2Mga2hpIGNodXnhu4NuIGtob+G6o24uIMSQ4bq3YyBiaeG7h3QsIG5nxrDhu51pIGQmdWdyYXZlO25nIGPFqW5nIG4mZWNpcmM7biB0aMaw4budbmcgeHV5JmVjaXJjO24gY+G6rXAgbmjhuq10IHRoJm9jaXJjO25nIHRpbiDEkeG7gyBuaOG6rW4gZGnhu4duIGMmYWFjdXRlO2MgaCZpZ3JhdmU7bmggdGjhu6ljIGzhu6thIMSR4bqjbywgdOG7qyDEkSZvYWN1dGU7IGNo4bunIMSR4buZbmcgcGgmb2dyYXZlO25nIHRyJmFhY3V0ZTtuaDwvcD4NCg0KPHA+Q+G6rXAgbmjhuq10IGMmYWFjdXRlO2MgdGhp4bq/dCBi4buLIHRoxrDhu51uZyB4dXkmZWNpcmM7biDEkeG7gyB2JmFhY3V0ZTsgYyZhYWN1dGU7YyBs4buXIGjhu5VuZyBi4bqjbyBt4bqtdCBz4bq9IGdpJnVhY3V0ZTtwIHBoJm9ncmF2ZTtuZyB0ciZhYWN1dGU7bmggdmnhu4djIGQmb2dyYXZlOyBxdSZlYWN1dGU7dCB2JmFncmF2ZTsgdOG6pW4gYyZvY2lyYztuZyBj4bunYSBoYWNrZXIgdHJvbmcgYyZ1Z3JhdmU7bmcgbeG6oW5nIHdpZmkgYyZvY2lyYztuZyBj4buZbmcuIEtoJm9jaXJjO25nIGMmYWdyYXZlO2kgYuG6pXQga+G7syBwaOG6p24gbeG7gW0gZyZpZ3JhdmU7IG0mYWdyYXZlOyBuZ8aw4budaSBjdW5nIGPhuqVwIHdpZmkgbWnhu4VuIHBoJmlhY3V0ZTsgeSZlY2lyYzt1IGPhuqd1IMSR4buDIMSRxrDhu6NjIGvhur90IG7hu5FpIGludGVycm5ldCB2JmFncmF2ZTsgbHUmb2NpcmM7biBz4butIGThu6VuZyBjJmFhY3V0ZTtjIGvhur90IG7hu5FpIGMmb2FjdXRlOyAmbGRxdW87aHR0cHMmcmRxdW87IGwmYWdyYXZlOyBuaOG7r25nIMSRaeG7gXUgdOG7kWkgdGhp4buDdSBraGkgc+G7rSBk4bulbmcgaW50ZXJuZXQg4bufIGLhuqV0IGvhu7MgxJEmYWNpcmM7dS48L3A+', 1, 9, '2025-01-22 13:33:12', '2025-08-10 21:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

CREATE TABLE `post_category` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `slug` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tin Tức', 'tin-tuc', 1, '2025-01-21 12:32:11', '2025-01-21 12:59:28'),
(2, 'Hướng đẫn', 'huong-dan', 1, '2025-01-21 13:32:13', '2025-01-21 13:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `sever_crons`
--

CREATE TABLE `sever_crons` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 NOT NULL,
  `price` int(11) NOT NULL,
  `ck` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `limit_second` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1:hoạt động;0:không hoạt động',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_hosting`
--

CREATE TABLE `tbl_category_hosting` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_vietnamese_ci,
  `anh` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` text COLLATE utf8mb4_vietnamese_ci,
  `updated_at` text COLLATE utf8mb4_vietnamese_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_category_hosting`
--

INSERT INTO `tbl_category_hosting` (`id`, `name`, `anh`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vn Test', 'https://dichvulight.vn/upload/product/product6FBNDE.png', 1, '2025-08-12 00:02:22', '2025-08-12 00:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_his_code`
--

CREATE TABLE `tbl_his_code` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `trans_id` text COLLATE utf8mb4_vietnamese_ci,
  `price` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_his_code`
--

INSERT INTO `tbl_his_code` (`id`, `user_id`, `product_id`, `trans_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'ZA1754932345', 10000, '2025-08-12 00:12:25', '2025-08-11 22:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hosting_packages`
--

CREATE TABLE `tbl_hosting_packages` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `package_name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `disk_quota` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `bandwidth_limit` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `max_subdomains` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `max_parked_domains` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `max_addon_domains` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `language` varchar(50) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `cpanel_module` varchar(50) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_vietnamese_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_hosting_packages`
--

INSERT INTO `tbl_hosting_packages` (`id`, `category`, `package_name`, `disk_quota`, `bandwidth_limit`, `max_subdomains`, `max_parked_domains`, `max_addon_domains`, `language`, `cpanel_module`, `status`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'lebaodz1', '500', '9999999', 'unlimited', 'unlimited', 'unlimited', 'vi', 'jupiter', 1, 0, 'c8SR', '2025-08-11 22:04:31', '2025-08-11 22:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_code`
--

CREATE TABLE `tbl_list_code` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `name` text COLLATE utf8mb4_vietnamese_ci,
  `price` int(11) DEFAULT '0',
  `images` text COLLATE utf8mb4_vietnamese_ci,
  `list_images` text COLLATE utf8mb4_vietnamese_ci,
  `intro` longtext COLLATE utf8mb4_vietnamese_ci,
  `view` bigint(20) DEFAULT '0',
  `sold` bigint(20) DEFAULT '0',
  `link_down` text COLLATE utf8mb4_vietnamese_ci,
  `link_demo` text COLLATE utf8mb4_vietnamese_ci,
  `status` int(11) DEFAULT '0' COMMENT '1:hoạt động;2:chờ duyệt;0:không hoạt động',
  `ck` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_list_code`
--

INSERT INTO `tbl_list_code` (`id`, `user_id`, `name`, `price`, `images`, `list_images`, `intro`, `view`, `sold`, `link_down`, `link_demo`, `status`, `ck`, `created_at`, `updated_at`) VALUES
(2, 1, 'Demo 1', 10000, '/uploads/10-08-2025/8ec4550c-63d8-4411-a909-a223def94e36.jpg', '/uploads/10-08-2025/d2d10a66-7b55-4b11-bbe9-b422f291a5f1.jpg', '<p>Demo :))</p>', 4, 1, 'c1djbVhURXRCMTQzc1l0UzRlZ0syM2VtOVp1cDlXc2piMDY2TnZweFJRVT0=', 'https://vemoni.vn/', 1, 0, '2025-08-10 21:19:37', '2025-08-12 00:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchased_hosting`
--

CREATE TABLE `tbl_purchased_hosting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `ip` text COLLATE utf8mb4_vietnamese_ci,
  `block_ip` text COLLATE utf8mb4_vietnamese_ci,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `domain_name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `server_whm` text COLLATE utf8mb4_vietnamese_ci,
  `info_package` text COLLATE utf8mb4_vietnamese_ci,
  `price` int(11) NOT NULL DEFAULT '0',
  `month` int(11) NOT NULL DEFAULT '1',
  `total` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL COMMENT '1:đang tạo,2:đang hoạt động,3:đã hết hạn;0 là bị khóa',
  `giahan` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_purchased_hosting`
--

INSERT INTO `tbl_purchased_hosting` (`id`, `user_id`, `package_id`, `ip`, `block_ip`, `start_date`, `end_date`, `username`, `password`, `email`, `domain_name`, `server_whm`, `info_package`, `price`, `month`, `total`, `status`, `giahan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '103.149.252.139', NULL, 1754931893, 1757523893, 'jmvsubsieutoc', '04hW2r7u@y1o44H1754931889', 'khanhbts5@gmail.com', 'shopaccgame.click', '{\"id\":1,\"category\":1,\"whm_host\":\"103-149-252-139.cprapid.com\",\"ip\":\"103.149.252.139\",\"whm_user\":\"root\",\"whm_pass\":\"biVTeuglzW0YKCou\",\"accesshash\":\"AW4VBEK600IOYFY0BDIDJYZWM1KMELE9\",\"status\":1,\"created_at\":\"2025-08-11T17:03:01.000000Z\",\"updated_at\":\"2025-08-11T17:03:01.000000Z\"}', '{\"id\":1,\"category\":1,\"package_name\":\"lebaodz1\",\"disk_quota\":\"500\",\"bandwidth_limit\":\"9999999\",\"max_subdomains\":\"unlimited\",\"max_parked_domains\":\"unlimited\",\"max_addon_domains\":\"unlimited\",\"language\":\"vi\",\"cpanel_module\":\"jupiter\",\"status\":1,\"price\":0,\"description\":\"c8SR\",\"created_at\":\"2025-08-11T17:04:31.000000Z\",\"updated_at\":\"2025-08-11T17:04:31.000000Z\"}', 0, 1, 0, 2, 0, '2025-08-11 22:04:53', '2025-08-11 22:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_whm_info`
--

CREATE TABLE `tbl_whm_info` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '0',
  `whm_host` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `ip` text COLLATE utf8mb4_vietnamese_ci,
  `whm_user` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `whm_pass` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `accesshash` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `tbl_whm_info`
--

INSERT INTO `tbl_whm_info` (`id`, `category`, `whm_host`, `ip`, `whm_user`, `whm_pass`, `accesshash`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '103-149-252-139.cprapid.com', '103.149.252.139', 'root', 'biVTeuglzW0YKCou', 'AW4VBEK600IOYFY0BDIDJYZWM1KMELE9', 1, '2025-08-11 22:03:01', '2025-08-11 22:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `real_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance_after` decimal(12,2) NOT NULL,
  `balance_before` decimal(12,2) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lickey` text COLLATE utf8mb4_unicode_ci COMMENT 'key mã nguồn',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `code`, `amount`, `real_amount`, `balance_after`, `balance_before`, `type`, `extras`, `order_id`, `sys_note`, `status`, `content`, `user_id`, `username`, `lickey`, `created_at`, `updated_at`) VALUES
(1, 'BMC-1DZSXWT', 20000000.00, 0.00, 20000000.00, 0.00, 'user-deposit', '{\"reason\":\"\"}', NULL, NULL, 'completed', '#1: ', 1, 'dichvuright', NULL, '2025-08-08 15:17:39', '2025-08-08 15:17:39'),
(2, 'FE1754648593', 90000.00, 0.00, 19820000.00, 19910000.00, 'new-order', '{\"id\":3,\"order_code\":\"FE1754648593\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 15:23:13', '2025-08-08 15:23:13'),
(3, 'FC1754648972', 90000.00, 0.00, 19730000.00, 19820000.00, 'new-order', '{\"id\":3,\"order_code\":\"FC1754648972\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 15:29:32', '2025-08-08 15:29:32'),
(4, 'HI1754649041', 90000.00, 0.00, 19640000.00, 19730000.00, 'new-order', '{\"id\":3,\"order_code\":\"HI1754649041\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 15:30:41', '2025-08-08 15:30:41'),
(5, 'YU1754649118', 90000.00, 0.00, 19550000.00, 19640000.00, 'new-order', '{\"id\":3,\"order_code\":\"YU1754649118\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 15:31:58', '2025-08-08 15:31:58'),
(6, 'SM1754661468', 90000.00, 0.00, 19460000.00, 19550000.00, 'new-order', '{\"id\":3,\"order_code\":\"SM1754661468\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 18:57:48', '2025-08-08 18:57:48'),
(7, 'XR1754661514', 90000.00, 0.00, 19370000.00, 19460000.00, 'new-order', '{\"id\":3,\"order_code\":\"XR1754661514\"}', '3', NULL, 'paid', '[logo fi fai] ; mã số 3; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-08 18:58:34', '2025-08-08 18:58:34'),
(8, 'HQ1754747730', 400000.00, 0.00, 18970000.00, 19370000.00, 'new-order', '{\"id\":4,\"order_code\":\"HQ1754747730\"}', '4', NULL, 'paid', '[logo ok vip bank] ; mã số 4; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-09 18:55:30', '2025-08-09 18:55:30'),
(9, 'VV1754805571', 240000.00, 0.00, 18250000.00, 18490000.00, 'new-order', '{\"id\":4,\"order_code\":\"VV1754805571\"}', '4', NULL, 'paid', '[Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay] ; mã số 4; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-10 10:59:31', '2025-08-10 10:59:31'),
(10, 'DF1754805892', 240000.00, 0.00, 18010000.00, 18250000.00, 'new-order', '{\"id\":4,\"order_code\":\"DF1754805892\"}', '4', NULL, 'paid', '[Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay] ; mã số 4; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-10 11:04:52', '2025-08-10 11:04:52'),
(11, 'AQ1754806150', 190000.00, 0.00, 17820000.00, 18010000.00, 'new-order', '{\"id\":4,\"order_code\":\"AQ1754806150\"}', '4', NULL, 'paid', '[Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay] ; mã số 4; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-10 11:09:10', '2025-08-10 11:09:10'),
(12, 'AQ1754806150', 200000.00, 0.00, 17620000.00, 17820000.00, 'new-order', '{\"id\":2,\"order_code\":\"AQ1754806150\"}', '2', NULL, 'paid', '[Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay] ; mã số 2; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-10 15:37:24', '2025-08-10 15:37:24'),
(13, 'DF1754805892', 20000.00, 0.00, 17600000.00, 17620000.00, 'new-order', '{\"id\":1,\"order_code\":\"DF1754805892\"}', '1', NULL, 'paid', '[Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay] ; mã số 1; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-10 15:39:06', '2025-08-10 15:39:06'),
(14, 'UE1754878883', 1140000.00, 0.00, 16460000.00, 17600000.00, 'new-order', '{\"id\":1,\"order_code\":\"UE1754878883\"}', '1', NULL, 'paid', '[Logo Shop Acc Game] ; mã số 1; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-11 07:21:23', '2025-08-11 07:21:23'),
(15, 'VP1754931896', 0.00, 0.00, 16460000.00, 16460000.00, 'new-order', '{\"id\":1,\"order_code\":\"VP1754931896\"}', '1', NULL, 'paid', 'Mua Hosting Gói lebaodz1 ; Giá tiền 0đ; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', NULL, '2025-08-11 22:04:56', '2025-08-11 22:04:56'),
(16, 'ZA1754932345', 10000.00, 0.00, 16450000.00, 16460000.00, 'new-order', '{\"id\":2,\"order_code\":\"ZA1754932345\"}', '2', NULL, 'paid', '[Demo 1] ; mã số 2; Thanh toán thành công cho người dùng dichvuright', 1, 'dichvuright', 'e8e526d5a7e08fccc9b350a3be705847', '2025-08-11 22:12:25', '2025-08-11 22:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_order`
--

CREATE TABLE `transfer_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_id` text CHARACTER SET utf8mb4 NOT NULL,
  `bank` text CHARACTER SET utf8mb4 NOT NULL,
  `noidung` text CHARACTER SET utf8mb4,
  `price` int(11) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 NOT NULL,
  `status` int(11) NOT NULL COMMENT '1:chờ thành toán;2:đã thanh toán;3:đã hủy',
  `transactionID` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text,
  `chat_id` text,
  `name` text,
  `password` text,
  `email` text,
  `level` int(11) NOT NULL,
  `access_token` text,
  `ip` text,
  `device` text,
  `otp` text,
  `balance` int(11) NOT NULL,
  `balance_ctv` int(11) NOT NULL,
  `total_deposit` int(11) NOT NULL,
  `banned` int(11) NOT NULL,
  `loai` text,
  `gioi_thieu` text,
  `skill` text,
  `time_request` int(11) NOT NULL DEFAULT '0',
  `created_at` text,
  `updated_at` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `chat_id`, `name`, `password`, `email`, `level`, `access_token`, `ip`, `device`, `otp`, `balance`, `balance_ctv`, `total_deposit`, `banned`, `loai`, `gioi_thieu`, `skill`, `time_request`, `created_at`, `updated_at`) VALUES
(1, 'dichvuright', NULL, 'dichvuright', '$2y$12$fyYabN74KeLQAmx9hvmne.wYZR/ADebJW2FFpsu9537Z838cFbFM6', 'khanhbts5@gmail.com', 1, '8a0f4VutjC3QFkJ9hKSglpVCbxkKBPCVyc5nI26qf992df65', '14.191.8.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, 16450000, 0, 20000000, 0, 'tk', NULL, NULL, 1754960740, '2025-08-08 09:38:49', '2025-08-12 08:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  `qty` int(11) DEFAULT '0',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_logs`
--

CREATE TABLE `voucher_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_logs`
--

CREATE TABLE `wallet_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `amount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `channel_charge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_before` int(11) NOT NULL DEFAULT '0',
  `balance_after` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web`
--

CREATE TABLE `web` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `extend` int(11) NOT NULL,
  `ck` int(11) NOT NULL,
  `images` varchar(500) NOT NULL,
  `list_images` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web`
--

INSERT INTO `web` (`id`, `user_id`, `name`, `price`, `extend`, `ck`, `images`, `list_images`, `description`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'Website Shop Bán Acc Game Tùy Thích, Cày Thuê, Vòng Quay', 200000, 20000, 5, '/uploads/09-08-2025/946019c7-a566-4b1f-820c-996fe7f26639.png', '/uploads/09-08-2025/570b475f-b713-4b1e-8b46-75fecb0ea0bb.png\n/uploads/09-08-2025/0d6115fb-b049-4e4f-a838-c161484343e3.png\n/uploads/09-08-2025/7f2d7b61-fea3-47fb-b82c-f1c8ec503f25.png\n/uploads/09-08-2025/ad950a69-cce2-44d9-951d-c64e4687f373.png', '- Bán tài khoản tự động , thích bán game nào add thêm danh mục game đó\r\n\r\n- Flash sale acc đang có , tạo đợt flash sale, hạ giá acc nhanh chóng\r\n\r\n- Vòng quay may mắn , vật phẩm , rút vật phẩm\r\n\r\n- Cày thuê, dịch vụ game tự động theo tỉ số\r\n\r\n- Cộng tác viên bán acc, điều chỉnh được loại acc mà ctv được up\r\n\r\n- Cộng tác viên cày thuê , dịch vụ game \r\n\r\n- Top nạp các thứ , nói chung là đầy đủ và dễ dùng', 1, '2025-08-09 14:44:36', '2025-08-09 19:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_ctvs`
--

CREATE TABLE `withdraw_ctvs` (
  `id` int(11) NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) NOT NULL,
  `price` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stk` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctk` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '0:chờ;1:đang chuyển;2:thành công;3:thất bại',
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_configs`
--
ALTER TABLE `api_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_logo`
--
ALTER TABLE `api_logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author_forms`
--
ALTER TABLE `author_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `card_lists`
--
ALTER TABLE `card_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `createwebs`
--
ALTER TABLE `createwebs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_lists`
--
ALTER TABLE `currency_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain_order`
--
ALTER TABLE `domain_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_logo`
--
ALTER TABLE `his_logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_url_cron`
--
ALTER TABLE `list_url_cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sever_crons`
--
ALTER TABLE `sever_crons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category_hosting`
--
ALTER TABLE `tbl_category_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_his_code`
--
ALTER TABLE `tbl_his_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hosting_packages`
--
ALTER TABLE `tbl_hosting_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_list_code`
--
ALTER TABLE `tbl_list_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchased_hosting`
--
ALTER TABLE `tbl_purchased_hosting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_whm_info`
--
ALTER TABLE `tbl_whm_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_order`
--
ALTER TABLE `transfer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- Indexes for table `voucher_logs`
--
ALTER TABLE `voucher_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_logs`
--
ALTER TABLE `wallet_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web`
--
ALTER TABLE `web`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_ctvs`
--
ALTER TABLE `withdraw_ctvs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_configs`
--
ALTER TABLE `api_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `api_logo`
--
ALTER TABLE `api_logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `author_forms`
--
ALTER TABLE `author_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `card_lists`
--
ALTER TABLE `card_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `createwebs`
--
ALTER TABLE `createwebs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `currency_lists`
--
ALTER TABLE `currency_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `domain_order`
--
ALTER TABLE `domain_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `his_logo`
--
ALTER TABLE `his_logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `list_url_cron`
--
ALTER TABLE `list_url_cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sever_crons`
--
ALTER TABLE `sever_crons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category_hosting`
--
ALTER TABLE `tbl_category_hosting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_his_code`
--
ALTER TABLE `tbl_his_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_hosting_packages`
--
ALTER TABLE `tbl_hosting_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_list_code`
--
ALTER TABLE `tbl_list_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_purchased_hosting`
--
ALTER TABLE `tbl_purchased_hosting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_whm_info`
--
ALTER TABLE `tbl_whm_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transfer_order`
--
ALTER TABLE `transfer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_logs`
--
ALTER TABLE `voucher_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_logs`
--
ALTER TABLE `wallet_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web`
--
ALTER TABLE `web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `withdraw_ctvs`
--
ALTER TABLE `withdraw_ctvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
