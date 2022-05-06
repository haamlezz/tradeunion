-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2022 at 07:49 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດໜ່ວຍ',
  `group_number` int(11) NOT NULL COMMENT 'ເລກໜ່ວຍ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ບັນຊີຜູ້ໃຊ້',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ສິດທິ',
  `book_no` int(5) DEFAULT NULL COMMENT 'ເລກປຶ້ມຕິດຕາມ',
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ຊື່',
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ນາມສະກຸນ',
  `gender` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ເພດ',
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
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ສະຖານະສະມາຊິກ',
  `group_id` int(10) NOT NULL COMMENT 'ລະຫັດຈຸ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mem_id`, `username`, `password`, `role`, `book_no`, `firstname`, `lastname`, `gender`, `ethnic`, `dob`, `h_village`, `h_district`, `h_province`, `addr_village`, `addr_district`, `addr_province`, `join_trade_union_date`, `join_party_date`, `join_women_union_date`, `status`, `group_id`) VALUES
(1, 'sompasong', '$2y$10$o96c0.I.3Me2u.emAya9AODyPiy4bv/KIp7oqOwi.dRPHHcVglc4q', 'admin', 1, 'admin', 'admin', 'ຊາຍ', 'ພຸດ', '2022-04-21', 'ກ', 'ກ', 'ກ', 'ກ', 'ກ', 'ກ', '2022-04-14', '2022-04-21', '2022-04-20', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member_in`
--

CREATE TABLE `member_in` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `doc_no` int(11) NOT NULL COMMENT 'ເລກທີເອກະສານ',
  `issus_date` date NOT NULL COMMENT 'ວັນທີເອກະສານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_out`
--

CREATE TABLE `member_out` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດ',
  `col_id` int(11) NOT NULL COMMENT 'ລະຫັດຮາກຖານ',
  `mem_id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `doc_no` int(11) NOT NULL COMMENT 'ເລກທີເອກະສານ',
  `issue_date` date NOT NULL COMMENT 'ວັນທີເອກະສານ',
  `lastest_paid_year` int(11) NOT NULL COMMENT 'ປີສຸດທ້າຍທີ່ຊຳລະຄ່າສະຕິ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດການເຄື່ອນໄຫວ';

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `col_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຮາກຖານ';

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດໜ່ວຍ';

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດສະມາຊິກ', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member_in`
--
ALTER TABLE `member_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ';

--
-- AUTO_INCREMENT for table `member_out`
--
ALTER TABLE `member_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດ';

--
-- AUTO_INCREMENT for table `yearly_fee`
--
ALTER TABLE `yearly_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຄ່າສະຕິ';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
