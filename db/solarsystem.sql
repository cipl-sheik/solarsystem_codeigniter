-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2017 at 09:00 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `solarsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `solar_planets`
--

CREATE TABLE IF NOT EXISTS `solar_planets` (
`planet_id` int(11) NOT NULL,
  `planet_solar_id` int(11) NOT NULL,
  `planet_name` varchar(255) NOT NULL,
  `planet_size` float NOT NULL,
  `planet_coordinate_x` float NOT NULL,
  `planet_coordinate_y` float NOT NULL,
  `planet_coordinate_z` float NOT NULL,
  `planet_is_sun` tinyint(1) NOT NULL,
  `planet_is_orbit_sun` tinyint(1) NOT NULL,
  `planet_created_at` datetime NOT NULL,
  `planet_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solar_planets`
--

INSERT INTO `solar_planets` (`planet_id`, `planet_solar_id`, `planet_name`, `planet_size`, `planet_coordinate_x`, `planet_coordinate_y`, `planet_coordinate_z`, `planet_is_sun`, `planet_is_orbit_sun`, `planet_created_at`, `planet_updated_at`) VALUES
(1, 3, 'Earth', 49, 55, 47, 78, 0, 1, '2017-02-21 20:55:44', '2017-02-21 19:55:44'),
(4, 3, 'Sun', 45, 34, 34, 34, 1, 0, '2017-02-21 15:25:06', '2017-02-21 14:57:23'),
(6, 3, 'Sandy', 450, 340, 340, 340, 0, 1, '2017-02-21 20:08:42', '2017-02-21 19:08:42'),
(7, 5, 'Earth', 45, 34, 34, 34, 0, 1, '2017-02-21 18:35:09', '2017-02-21 17:35:09'),
(9, 3, 'Moon', 45, 34, 23, 34, 0, 0, '2017-02-21 20:49:04', '2017-02-21 19:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `solar_system`
--

CREATE TABLE IF NOT EXISTS `solar_system` (
`solar_id` int(11) NOT NULL,
  `solar_name` varchar(255) NOT NULL,
  `solar_size` float NOT NULL,
  `solar_coordinate_x` float NOT NULL,
  `solar_coordinate_y` float NOT NULL,
  `solar_coordinate_z` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solar_system`
--

INSERT INTO `solar_system` (`solar_id`, `solar_name`, `solar_size`, `solar_coordinate_x`, `solar_coordinate_y`, `solar_coordinate_z`, `created_at`, `updated_at`) VALUES
(3, 'Solar232', 45, 34, 34, 34, '2017-02-21 14:32:55', '2017-02-21 13:32:55'),
(5, 'Solar555', 45, 34, 34, 34, '2017-02-21 18:31:39', '2017-02-21 17:31:39'),
(6, 'Georgia edit', 45, 34, 34, 34, '2017-02-21 19:54:01', '2017-02-21 18:54:01'),
(7, 'Solar677', 45, 45, 55, 23, '2017-02-21 20:32:32', '2017-02-21 19:32:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `solar_planets`
--
ALTER TABLE `solar_planets`
 ADD PRIMARY KEY (`planet_id`), ADD KEY `planet_name` (`planet_name`);

--
-- Indexes for table `solar_system`
--
ALTER TABLE `solar_system`
 ADD PRIMARY KEY (`solar_id`), ADD KEY `solar_name` (`solar_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `solar_planets`
--
ALTER TABLE `solar_planets`
MODIFY `planet_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `solar_system`
--
ALTER TABLE `solar_system`
MODIFY `solar_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
