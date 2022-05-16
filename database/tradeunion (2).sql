-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2022 at 09:24 AM
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
(1, 'ທົດສອບ', '2022-05-02', 'ວິທະຍາໄລ ລາວ-ທ໊ອບ', '<h1>ລາຍງານ</h1>\r\n<p>ທົດລອງ</p>', 100, 1),
(7, 'ອອກແຮງງານ', '2022-05-07', 'ບ້ານ ໂພນປ່າເປົ້າ', '<p>ັດ່ັາກດວັກ່ດວັກ່ດັຫດັກຫດ</p>', 100, 2);

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
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ອີເມວ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`col_id`, `col_name`, `col_village`, `col_district`, `col_province`, `tel`, `email`) VALUES
(1, 'ວິທະຍາໄລ ລາວ-ທ໊ອບ', 'ບ້ານ ໂພນປ່າເປົ້າ', 'ເມືອງ ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021353800', 'info@laotop.net'),
(2, 'ວິທະຍາໄລ ລາວນາໆຊາດ', 'ບ້ານ ສະພານທອງ', '021412558', 'ນະຄອນຫຼວງວຽງຈັນ', '021412558', 'lic.college@hotmail.com'),
(6, 'ວິທະຍາໄລ ສອນພິທັກ', 'ບ້ານ ໂສກປ່າຫຼວງ', 'ເມືອງ ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021 123456', 'sonephithak@gmail.com'),
(7, 'ສະຖານບັນຣັດຕະນະບໍລິຫານທຸລະກິດ', 'ບ້ານ ໂພນທັນ', 'ເມືອງ ສີສັດຕະນາກ', 'ນະຄອນຫຼວງວຽງຈັນ', '021555555', 'rbac@gmail.com'),
(8, 'ວິທະຍາໄລ ....', 'DDD', 'SSS', 'AAAA', '33333', 'eeee@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດໜ່ວຍ',
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
(6, 'ຈຸ 5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ບັນຊີຜູ້ໃຊ້',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `role` int(5) NOT NULL DEFAULT 3 COMMENT 'ສິດທິ',
  `book_no` int(5) DEFAULT NULL COMMENT 'ເລກປຶ້ມຕິດຕາມ',
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
  `group_id` int(10) NOT NULL COMMENT 'ລະຫັດຈຸ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mem_id`, `username`, `password`, `role`, `book_no`, `firstname`, `lastname`, `gender`, `ethnic`, `dob`, `h_village`, `h_district`, `h_province`, `addr_village`, `addr_district`, `addr_province`, `join_trade_union_date`, `join_party_date`, `join_women_union_date`, `status`, `group_id`) VALUES
(1, 'sompasong', '$2y$10$8yoLkykBvFdsPjeor.M5C.XUi8qrPMR33uScJD.VXVA88b5zb9ola', 2, 101, 'admin', 'admin', 'ຊາຍ', 'ພຸດ', '1987-09-19', 'ໜອງບົວທອງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', 'ສົມໂຮງ', 'ຫາດຊາຍຟອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2019-02-14', '2022-04-21', '2022-05-07', 1, 4),
(2, 'haamlezz', '$2y$10$OumdooZsG8JS9B9mp37pPeBBSPtVQHhlKOPp/PLVJPyufmBgYOiMm', 2, 333, 'll', 'll', '', 'lll', '1974-05-03', 'll', 'l', 'll', 'll', 'l', 'l', '2022-01-01', '2022-01-01', '2022-01-01', 1, 5),
(3, 'vilaisak', '$2y$10$aBcYonRlxPnfeNc9X336ruXemc2F8ZW8D2O5hNfQId0lPK4pJ49wO', 3, 333, 'ວິໄລສັກ', 'ຂັນຕິວົງ', 'ຊາຍ', 'ລາວລຸ່ມ', '1974-06-04', 'ກກກ', 'ຂຂຂ', 'ມມມ', 'ຊຊຊ', 'ບບບ', 'ລລລ', '2022-05-08', NULL, NULL, 0, 3),
(4, 'sam', '$2y$10$aSt6oF5jo7xfolImJufzwO5W3zmoMY/sRzYfrlcnXOYwSzC5k1sLO', 1, 111, 'ພັນທະວິໄລ', 'ນວນຮຸ່ນ', 'ຊາຍ', 'ລາວລຸ່ມ', '1984-04-09', 'ດົງປາແຫຼບ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງ', 'ໜອງດ້ວງ', 'ສີໂຄດຕະບອງ', 'ນະຄອນຫຼວງວຽງຈັນ', '2022-05-08', '2022-05-07', '2022-05-06', 1, 1),
(5, 'soumek', '$2y$10$VKbjUz.H17WkAkL4UQlvVO3Cu.agwZwQzPhASFa96DjXzGz.7atEq', 3, 11, 'ສຸເມກ', 'ສຸວັນນະໄລ', 'ຊາຍ', 'ລາວລຸ່ມ', '2001-10-07', 'ວຽງແກ້ວ', 'ທຸລະຄົມ', 'ວຽງຈັນ', 'ນາແຄ', 'ໄຊທານີ', 'ນະຄອນຫຼວງວຽງຈັນ', '2020-01-03', NULL, NULL, 2, 4);

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
(21, 5, 2, '2022-05-12'),
(22, 1, 1, '2022-05-12'),
(23, 1, 3, '2022-05-12'),
(24, 3, 3, '2022-05-12'),
(25, 4, 3, '2022-05-12'),
(26, 5, 3, '2022-05-12');

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
(3, 1, 5, '123/ວລທ/ກມບ', '2022-02-28'),
(4, 1, 3, '11/ກມບ', '2022-05-10');

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
(1, 1, 5, '12/ກມບ', '2022-04-07', 2022);

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
(1, 32000, 2022),
(2, 32000, 2023),
(3, 34000, 2024);

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
  ADD UNIQUE KEY `username` (`username`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_out`
--
ALTER TABLE `member_out`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດການເຄື່ອນໄຫວ', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `col_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຮາກຖານ', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດໜ່ວຍ', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດສະມາຊິກ', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership_fee`
--
ALTER TABLE `membership_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດເສຍຄ່າສະຕິ', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `member_in`
--
ALTER TABLE `member_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member_out`
--
ALTER TABLE `member_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `yearly_fee`
--
ALTER TABLE `yearly_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຄ່າສະຕິ', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
