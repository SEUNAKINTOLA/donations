-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 08, 2021 at 03:58 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donations`
--

-- --------------------------------------------------------

--
-- Table structure for table `prospective_donors`
--

DROP TABLE IF EXISTS `prospective_donors`;
CREATE TABLE IF NOT EXISTS `prospective_donors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donor_id` varchar(36) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `postal` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `phoneno` varchar(30) NOT NULL,
  `form_of_contact` varchar(30) DEFAULT NULL,
  `form_of_payment` varchar(30) DEFAULT NULL,
  `amount` int(30) DEFAULT NULL,
  `frequency` varchar(36) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(225) DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `id` (`donor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prospective_donors`
--

INSERT INTO `prospective_donors` (`id`, `donor_id`, `firstname`, `lastname`, `postal`, `country`, `address`, `city`, `state`, `phoneno`, `form_of_contact`, `form_of_payment`, `amount`, `frequency`, `email`, `comment`, `added`) VALUES
(7, 'e0276713-afa6-11eb-ba28-80e82c11f9e3', 'OLUWASEUN', 'AKINTOLA', '2932020', 'Nigeria', '6, Sab Ojewale Street, Gbagada', 'Lagos', 'Lagos', '+2348135719238', 'phone', '', 22, 'Yearly', 'akinsehunw@gmail.com', 'sdsdd', '2021-05-08 01:30:37'),
(8, '42f35d8d-afb0-11eb-ba28-80e82c11f9e3', 'OLUWASEUN', 'AKINTOLA', '2932020', 'Nigeria', '6, Sab Ojewale Street, Gbagada', 'Lagos', 'Lagos', '+2348135719238', 'phone', '', 222, 'Yearly', 'akinsehun2@gmail.com', '4434344', '2021-05-08 02:42:25'),
(9, 'bf863cdd-afb0-11eb-ba28-80e82c11f9e3', 'OLUWASEUN', 'AKINTOLA', '2932020', 'Nigeria', '6, Sab Ojewale Street, Gbagada', 'Lagos', 'Lagos', '+2348135719238', 'email', 'Bitcoin', 11, 'One-time', 'akinsehun@gmail.com4', 'tes', '2021-05-08 02:45:54'),
(13, '832cf6df-afb1-11eb-ba28-80e82c11f9e3', 'OLUWASEUN', 'AKINTOLA', '2932020', 'Nigeria', '6, Sab Ojewale Street, Gbagada', 'Lagos', 'Lagos', '+2348135719238', 'phone', 'USD', 22, 'Monthly', 'akinsehun@gmail.com22', '22', '2021-05-08 02:51:22');

--
-- Triggers `prospective_donors`
--
DROP TRIGGER IF EXISTS `before_insert_mytable`;
DELIMITER $$
CREATE TRIGGER `before_insert_mytable` BEFORE INSERT ON `prospective_donors` FOR EACH ROW SET new.`donor_id` = uuid()
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
