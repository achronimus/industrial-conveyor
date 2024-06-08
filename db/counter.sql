-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 01:33 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `counter`
--

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `no` int(20) NOT NULL,
  `id_telegram` int(20) NOT NULL,
  `uniqid` varchar(50) NOT NULL,
  `expdate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`no`, `id_telegram`, `uniqid`, `expdate`) VALUES
(1, 1234567890, '60d3f1c83ed69', '2021-06-24'),
(2, 1234567890, '60d3f45ae4441', '2021-06-24'),
(3, 1234567890, '60d433638e980', '2021-06-24'),
(4, 1234567890, '6212fb5f31535', '2022-02-21'),
(5, 1234567890, '6212fdc28b95d', '2022-02-21'),
(6, 1234567890, '6212fe260f3ac', '2022-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_config`
--

CREATE TABLE `tabel_config` (
  `id_telegram` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `key_api` varchar(50) NOT NULL,
  `token_bot` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_config`
--

INSERT INTO `tabel_config` (`id_telegram`, `username`, `password`, `key_api`, `token_bot`) VALUES
(1234567890, 'admin', '$2y$10$SrRmjwkfFHu99EFtUD0r3u5r8M0MrvxU2ZMW7U28RQJllhn/CEXvm', 'abc123', '1234567890:abcdefghijklmnopqrstu');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_device`
--

CREATE TABLE `tabel_device` (
  `id` int(20) NOT NULL,
  `device` varchar(20) NOT NULL,
  `count` int(20) NOT NULL,
  `max` int(20) NOT NULL,
  `start_time` int(20) NOT NULL,
  `end_time` int(20) NOT NULL,
  `mode` enum('Auto','Manual') NOT NULL,
  `count_state` enum('true','false') NOT NULL,
  `btn_state` int(20) NOT NULL,
  `msg_state` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_device`
--

INSERT INTO `tabel_device` (`id`, `device`, `count`, `max`, `start_time`, `end_time`, `mode`, `count_state`, `btn_state`, `msg_state`) VALUES
(1, 'Counter A', 0, 0, 0, 0, 'Manual', 'true', 1, 0),
(2, 'Counter B', 0, 0, 0, 0, 'Manual', 'true', 1, 0),
(3, 'Counter C', 0, 0, 0, 0, 'Manual', 'true', 1, 0),
(4, 'Counter D', 0, 0, 0, 0, 'Manual', 'true', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_record`
--

CREATE TABLE `tabel_record` (
  `no` int(20) NOT NULL,
  `waktu` varchar(20) NOT NULL DEFAULT current_timestamp(),
  `device` varchar(20) NOT NULL,
  `label` varchar(20) NOT NULL,
  `result` int(20) NOT NULL,
  `start_time` int(20) NOT NULL,
  `end_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `tabel_config`
--
ALTER TABLE `tabel_config`
  ADD PRIMARY KEY (`id_telegram`);

--
-- Indexes for table `tabel_device`
--
ALTER TABLE `tabel_device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_record`
--
ALTER TABLE `tabel_record`
  ADD PRIMARY KEY (`no`),
  ADD KEY `id` (`device`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tabel_device`
--
ALTER TABLE `tabel_device`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tabel_record`
--
ALTER TABLE `tabel_record`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
