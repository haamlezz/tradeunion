-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2022 at 03:40 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tradeunion`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດການເຄື່ອນໄຫວ',
  `act_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ຫົວຂໍ້',
  `act_date` date NOT NULL COMMENT 'ວັນທີ',
  `act_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ສະຖານທີ່',
  `act_detail` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'ລາຍລະອຽດ',
  `total_member_join` int(11) NOT NULL COMMENT 'ຈຳນວນຜູ້ເຂົ້າຮ່ວມ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `act_title`, `act_date`, `act_location`, `act_detail`, `total_member_join`, `col_id`) VALUES
(7, 'ອອກແຮງງານ', '2022-05-07', 'ບ້ານ ໂພນປ່າເປົ້າ', '<p>ັດ່ັາກດວັກ່ດວັກ່ດັຫດັກຫດ</p>', 100, 2),
(8, 'ວຽກງານໂຄສະນາອົບຮົມ', '2022-05-10', 'ວິທະຍາໄລ ລາວ-ທ໊ອບ', '<ol>\r\n<li>ເຜີຍແຜ່ມະຕິກອງປະຊຸມ</li>\r\n<li>ເຜີຍແຜ່ກົດລະບຽບໃຫ້ແກ່ສະມາຊິກໃໝ່</li>\r\n<li>ຈັດເຝິກອົບຮົມວຽກງານຄຸ້ມຄອງພະນັກງານ</li>\r\n<li>ຈັດເຝິກອົບຮົມວຽກງານແນວຄິດການເມືອງ</li>\r\n</ol>', 32, 1),
(9, 'ວຽກງານແຮງງານສຶກສາ', '2022-05-07', 'ບ້ານ ໂພນປ່າເປົ້າ', '<p>ວັນທີ 7 ພຶດສະພາ 2022 ໜ່ວຍງານກຳມະບານຮາກຖານ ວິທະຍາໄລ ລາວ-ທ໊ອບ ແລະ ອົງການຈັດຕັ້ງທີ່ປິ່ນອ້ອມ ໄດ້ຮ່ວມກັນອອກແຮງງານວັນເສົາແດງ ເພື່ອສະເຫຼີມສະຫຼອງ ວັນສ້າງຕັ້ງສະຫະພັນກຳມະບານ ພາຍໃຕ້ການນຳພາຂອງທ່ານ ພັນທະວິໄລ ນວນຮຸ່ນ ອຳນວຍການວິທະຍາໄລ ລາວ-ທ໊ອບ ໂດຍໄດ້ເຄື່ອນໄຫວດັ່ງນີ້:</p>\r\n<ul>\r\n<li>ອະນາໄມອ້ອມແອ້ມວິທະຍາໄລ</li>\r\n<li>ທຳຄວາມສະອາດເສັ້ນທາງໂພນປ່າເປົ້າ</li>\r\n</ul>', 32, 1),
(10, 'ອອກແຮງງານວັນເສົາແດງ', '2022-07-02', 'ບ້ານໂພນທັນ', '<p>ວັນທີ 2 ກໍລະກົດ ທີ່ຜ່ານມາ ໄດ້ມີການເຄື່ອນໄຫວອອກແຮງງານວັນເສົາແດງ ອ້ອມແອ້ມບ້ານໂພນທັນ</p>\r\n<p>ມີຄະນະນຳກຳມະບານຮາກຖານ ແລະ ສະມາຊິກເຂົ້າຮ່ວມກັນຢ່າງຄຶກຄື້ນ</p>', 120, 7);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `col_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ຊື່ຮາກຖານ',
  `col_village` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ບ້ານ',
  `col_district` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ເມືອງ',
  `col_province` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ແຂວງ',
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ເບີໂທ',
  `email` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ອີເມວ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`col_id`, `col_name`, `col_village`, `col_district`, `col_province`, `tel`, `email`) VALUES
(1, 'ວິທະຍາໄລ ລາວ-ທ໊ອບ', 'ບ້ານ ໂພນປ່າເປົ້າ', 'ເມືອງ ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021353800', 'info@laotop.net'),
(2, 'ວິທະຍາໄລ ລາວນາໆຊາດ', 'ບ້ານ ສະພານທອງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021412558', 'lic.college@hotmail.com'),
(7, 'ສະຖານບັນຣັດຕະນະບໍລິຫານທຸລະກິດ', 'ບ້ານ ໂພນທັນ', 'ເມືອງ ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021555555', 'rbac@gmail.com'),
(10, 'ວິທະຍາໄລ ລາວວຽງ', 'ຊ້າງຄູ້', 'ໄຊທານີ', 'ນະຄອນຫຼວງວຽງຈັນ', '021 333112', 'laovieng@gmail.com'),
(11, 'ວິທະຍາໄລ ເສດຖາບໍລິຫານທຸລະກິດ', 'ຈອມມະນີໃຕ້', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', '021 415551', ''),
(12, 'ສະຖາບັນແສງສະຫວັນບໍລິຫານທຸລະກິດ', 'ສີສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', '021 223 822', 'info@sengsavanh.edu.la'),
(13, 'ສະຖະບັນເຕັກໂນໂລຊີສຸດສະກະ', 'ໂພນພະເນົາ', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', '021 900 337', 'info@sit.edu.la');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດຈຸ',
  `group_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ຊື່ຈຸ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `col_id`) VALUES
(1, 'ຈຸ 1', 1),
(3, 'ຈຸ 2', 1),
(4, 'ຈຸ 3', 1),
(5, 'ຈຸ 4', 2),
(6, 'ຈຸ 5', 1),
(12, 'ຈຸ 1', 6),
(13, 'ຈຸ 1', 7),
(14, 'ຈຸ 4', 1),
(15, 'ຈຸ 1', 11),
(16, 'ຈຸ 2', 11);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ບັນຊີຜູ້ໃຊ້',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `role` int(5) NOT NULL DEFAULT 3 COMMENT 'ສິດທິ',
  `book_no` int(5) DEFAULT 0 COMMENT 'ເລກປຶ້ມຕິດຕາມ',
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ຊື່',
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ນາມສະກຸນ',
  `gender` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ເພດ',
  `ethnic` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ຊົນເຜົ່າ',
  `dob` date DEFAULT NULL COMMENT 'ວດປ ເກີດ',
  `h_village` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ບ້ານເກີດ',
  `h_district` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ເມືອງເກີດ',
  `h_province` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ແຂວງເກີດ',
  `addr_village` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ບ້ານຢູ່',
  `addr_district` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ເມືອງຢູ່',
  `addr_province` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ແຂວງຢູ່',
  `join_trade_union_date` date DEFAULT NULL COMMENT 'ວດປ ເຂົ້າຮ່ວມ ກມບ',
  `join_party_date` date DEFAULT NULL COMMENT 'ວດປ ເຂົ້າພັກ',
  `join_women_union_date` date DEFAULT NULL COMMENT 'ວດປ ເຂົ້າສະຫະພັນແມ່ຍິງ',
  `status` int(10) NOT NULL DEFAULT 0 COMMENT 'ສະຖານະສະມາຊິກ',
  `group_id` int(10) DEFAULT 0 COMMENT 'ລະຫັດຈຸ',
  `col_id` int(10) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `join_local` date DEFAULT NULL COMMENT 'ວັນທີຮັບເຂົ້າຮາກຖານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mem_id`, `username`, `password`, `role`, `book_no`, `firstname`, `lastname`, `gender`, `ethnic`, `dob`, `h_village`, `h_district`, `h_province`, `addr_village`, `addr_district`, `addr_province`, `join_trade_union_date`, `join_party_date`, `join_women_union_date`, `status`, `group_id`, `col_id`, `join_local`) VALUES
(4, 'sam', '$2y$10$aSt6oF5jo7xfolImJufzwO5W3zmoMY/sRzYfrlcnXOYwSzC5k1sLO', 1, 111, 'ພັນທະວິໄລ', 'ນວນຮຸ່ນ', 'ຊາຍ', 'ລາວລຸ່ມ', '1984-04-09', 'ດົງປາແຫຼບ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງ', 'ໜອງດ້ວງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-05-08', '2022-05-07', '2022-05-06', 1, 1, 1, '2022-05-08'),
(11, 'song', '$2y$10$Gc.eo0c5f3mQ6EiR770ZL.jvGpxApv10xVNTfZTx785gKRUyx0Y9C', 2, 75, 'ສົມປະສົງ', 'ວົງຖາວອນ', 'ຊາຍ', 'ລາວລຸ່ມ', '1989-06-19', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ສົມໂຮງ', 'ຫາດຊາຍຟອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2017-02-01', '2021-06-01', NULL, 1, 13, 7, '2017-02-01'),
(12, 'art', '$2y$10$EQaoygHXv1P9AwjohdBaP.K9ZnafRsTk6Z2b5wEV55g18GHhJaZVW', 2, 101, 'ອາດ', 'ພົມວິໄຊ', 'ຊາຍ', 'ລາວລຸ່ມ', '1992-06-01', 'ໂພນຕ້ອງຈອມມະນີ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂພນຕ້ອງຈອມມະນີ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', '2019-02-01', NULL, NULL, 1, 5, 2, NULL),
(14, 'bounkong', '$2y$10$jq892GeMh93waYX8jYOshOyclPbGckBKHVeg5BqvDQQPW4PvKRDNi', 3, 101, 'ບຸນກອງ', 'ຈອມມະນີວົງ', 'ຊາຍ', 'ລາວລຸ່ມ', '1985-01-04', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2020-02-03', NULL, NULL, 1, 1, 1, '2022-01-10'),
(24, 'art2', '$2y$10$qvC4MfiUPl64EDae/wiIXuB7iaUSpkXVITiCQ.laHWJVDqNlMK9G2', 3, 101, 'ອາດ', 'ພູມີວົງ', 'ຊາຍ', 'ລາວລຸ່ມ', '1990-04-08', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂພນຕ້ອງສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', '2021-02-01', NULL, NULL, 2, 13, 7, '2022-02-01'),
(25, 'big', '$2y$10$GFDlgYF2KJjHMhG1pBqXDug7AnVvADyr0SrBnmOjGGsClpiLxORK6', 1, 101, 'ພອນສະຫວັນ', 'ພົມມະລີ', 'ຍິງ', 'ລາວລຸ່ມ', '1990-04-03', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '2021-02-01', NULL, '2022-03-08', 1, 5, 2, '2021-02-01'),
(30, 'nang', '$2y$10$pk2CJVQr4sN9pMdk6JFOF.hSrf7LNVis2DNvqRgacLiiV2eT8Gpcm', 2, 101, 'ສັງວຽນ', 'ວັນນະວົງ', 'ຍິງ', 'ລາວສູງ', '1996-07-03', 'ທາດຫຼວງເໜືອ', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ທາດຫຼວງເໝືອ', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', '2021-02-02', '2022-01-11', '2020-07-07', 1, 15, 11, '2022-07-07'),
(31, 'houndai', '$2y$10$xd6nNWU5lkZOfzMisJ8qkO0qxzfX4ASfcd2VggMWDCo1OL/vxhjFW', 3, 100, 'ຮຸນໄດ', 'ກິດຕິອາສ', 'ຍິງ', 'ລາວລຸ່ມ', '1991-03-03', 'ປາກທ້າງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ປາກທ້າງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-06-15', NULL, '2019-04-03', 1, 16, 11, '2022-06-15'),
(32, 'khamwiang', '$2y$10$gkc3aRRY.5zhM1S3ow6okuK0IWCuiBhpu.adP7zwJdKME1T6kvUiO', 3, 22, 'ຄຳຫວຽງ', 'ຈັນທະກູນ', 'ຊາຍ', 'ລາວເທີງ', '1984-06-07', 'ດອນຮີ', 'ໂຂງ', 'ຈຳປາສັກ', 'ທາດຫຼວງໃຕ້', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', '2020-02-03', '2021-03-09', NULL, 1, 13, 7, '2022-02-01'),
(33, 'salita', '$2y$10$4WRM4gFfZq6kU.06H2RjjOaDZ45WFZf.AtqqO2VToNp7ZpA0s8iYm', 3, 21, 'ສາລິຕາ', 'ຈິດຕະວົງ', 'ຍິງ', 'ລາວລຸ່ມ', '1999-04-03', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-07', NULL, '2022-02-02', 1, 13, 7, '2022-07-07'),
(34, 'phonexay', '$2y$10$AXVk.7m7AoEEsWbHjlAavOj8HvGCpd.8Tb0BqqasSa0FOSMi58Lo.', 3, 34, 'ພອນໄຊ', 'ເມືອງໝັ້ນ', 'ຍິງ', 'ລາວລຸ່ມ', '2000-09-23', 'ໂພນຕ້ອງສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂພນຕ້ອງສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-07', NULL, '2022-01-18', 1, 13, 7, '2022-07-07'),
(35, 'teow', '$2y$10$zfEro0mqldAZe18z857UMOXcIFV/gKudbc0IxLM9PyQiaz3SY2CUm', 2, 54, 'ໄຊສຸລິສັກ', 'ແດນຈຳປາ', 'ຊາຍ', 'ລາວລຸ່ມ', '1989-06-08', 'ດອນນົກຂຸ້ມ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ທາດຫຼວງເໝືອ', 'ໄຊເສດຖາ', 'ນະຄອນຫຼວງວຽງຈັນ', '2020-03-17', '2021-04-07', NULL, 1, 14, 1, '2020-03-17'),
(36, 'vilaxay', '$2y$10$olzlp2nkm.dhmEc4xxghqe6fJjrYVRL/4ncm9RzklFkDjjonZiIuK', 3, 57, 'ວິລະໄຊ', 'ບຸດຕະໂຄດ', 'ຊາຍ', 'ລາວລຸ່ມ', '2007-09-14', 'ໂພນຕ້ອງສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂພນຕ້ອງສະຫວາດ', 'ຈັນທະບູລີ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-08', NULL, NULL, 1, 14, 1, '2022-07-08'),
(37, 'vilasouk', '$2y$10$uOIU7IVj/cSYmmlvuH9Q9.mJ8Tp3AAoQxOnhl6bSb.Reus45R0q26', 3, 77, 'ວິລະສຸກ', 'ວິລະສັກ', 'ຊາຍ', 'ລາວລຸ່ມ', '1995-06-11', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-08', NULL, NULL, 1, 3, 1, '2022-07-08'),
(38, 'soudalat', '$2y$10$AssbB6/l4VnRSXhdBai6pu/brJE1L3xEQpzzOSal6CZDF1U6TLwSu', 3, 78, 'ສຸດາລັດ', 'ວັນນະລາດ', 'ຍິງ', 'ລາວສູງ', '2002-06-19', 'ດອນນົກຂຸ້ມ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ດອນນົກຂຸ້ມ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-08', NULL, '2022-07-08', 1, 14, 1, '2022-07-08'),
(39, 'vieng', '$2y$10$gBU2Qn6Ul1lxzzebvfTceeB08PVs76Ta0P1PwwjHUk835wNhmQ8vq', 3, 76, 'ວຽງນະຄອນ', 'ແສງອາລຸນ', 'ຊາຍ', 'ລາວລຸ່ມ', '2001-08-06', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ໂສກປ່າຫຼວງ', 'ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-07-08', NULL, NULL, 2, 6, 1, '2022-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `membership_fee`
--

CREATE TABLE `membership_fee` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດເສຍຄ່າສະຕິ',
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `fee_id` int(11) NOT NULL COMMENT 'ລະຫັດຄ່າສະຕິປະຈຳປີ',
  `pay_date` date NOT NULL COMMENT 'ວັນທີຊຳລະ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `membership_fee`
--

INSERT INTO `membership_fee` (`id`, `mem_id`, `fee_id`, `pay_date`) VALUES
(30, 4, 1, '2022-06-20'),
(35, 14, 1, '2022-05-03'),
(38, 11, 1, '2022-07-06'),
(42, 24, 1, '2022-07-06'),
(43, 30, 1, '2022-07-07'),
(44, 31, 1, '2022-07-07'),
(45, 32, 1, '2022-07-07'),
(46, 39, 1, '2022-07-07'),
(47, 37, 1, '2022-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `member_in`
--

CREATE TABLE `member_in` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `doc_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ເລກທີເອກະສານ',
  `issue_date` date NOT NULL COMMENT 'ວັນທີເອກະສານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_in`
--

INSERT INTO `member_in` (`id`, `col_id`, `mem_id`, `doc_no`, `issue_date`) VALUES
(7, 1, 14, '11/ກມບ', '2022-01-04'),
(9, 7, 11, '11/ກມບ', '2022-07-06'),
(12, 7, 24, '11/ກມບ', '2022-02-01'),
(13, 1, 35, '32', '2021-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `member_out`
--

CREATE TABLE `member_out` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `doc_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ເລກທີເອກະສານ',
  `issue_date` date NOT NULL COMMENT 'ວັນທີເອກະສານ',
  `latest_paid_year` int(11) NOT NULL COMMENT 'ປີສຸດທ້າຍທີ່ຊຳລະຄ່າສະຕິ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_out`
--

INSERT INTO `member_out` (`id`, `col_id`, `mem_id`, `doc_no`, `issue_date`, `latest_paid_year`) VALUES
(13, 7, 24, '11/ກມບ', '2022-07-06', 2022),
(14, 1, 39, '33', '2022-07-08', 2022);

-- --------------------------------------------------------

--
-- Table structure for table `yearly_fee`
--

CREATE TABLE `yearly_fee` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດຄ່າສະຕິ',
  `fee` int(11) NOT NULL COMMENT 'ຄ່າສະຕິ',
  `year` int(11) NOT NULL COMMENT 'ປີ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `yearly_fee`
--

INSERT INTO `yearly_fee` (`id`, `fee`, `year`) VALUES
(1, 32000, 2022);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`col_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`);

--
-- Indexes for table `membership_fee`
--
ALTER TABLE `membership_fee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mem_id` (`mem_id`),
  ADD KEY `fee_id` (`fee_id`);

--
-- Indexes for table `member_in`
--
ALTER TABLE `member_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `col_id` (`col_id`),
  ADD KEY `mem_id` (`mem_id`);

--
-- Indexes for table `member_out`
--
ALTER TABLE `member_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `col_id` (`col_id`),
  ADD KEY `mem_id` (`mem_id`);

--
-- Indexes for table `yearly_fee`
--
ALTER TABLE `yearly_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດການເຄື່ອນໄຫວ', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `col_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຮາກຖານ', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຈຸ', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດສະມາຊິກ', AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `membership_fee`
--
ALTER TABLE `membership_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດເສຍຄ່າສະຕິ', AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `member_in`
--
ALTER TABLE `member_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `member_out`
--
ALTER TABLE `member_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `yearly_fee`
--
ALTER TABLE `yearly_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຄ່າສະຕິ', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membership_fee`
--
ALTER TABLE `membership_fee`
  ADD CONSTRAINT `membership_fee_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `member` (`mem_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_in`
--
ALTER TABLE `member_in`
  ADD CONSTRAINT `member_in_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `member` (`mem_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_out`
--
ALTER TABLE `member_out`
  ADD CONSTRAINT `member_out_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `member` (`mem_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
