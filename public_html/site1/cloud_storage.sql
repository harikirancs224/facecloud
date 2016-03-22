-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 05, 2015 at 09:52 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cloud_storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers_auth`
--

CREATE TABLE IF NOT EXISTS `customers_auth` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

--
-- Dumping data for table `customers_auth`
--

INSERT INTO `customers_auth` (`uid`, `name`, `email`, `phone`, `password`, `address`, `city`, `created`) VALUES
(187, 'santosh', 'santosh.avudari@gmail.com', '9014390120', '$2a$10$0b7d2e9857f1768514867uuPH.c2LTXyNMqyAjfMzyzla.WXXdX3a', 'dfamn dsfsf', '', '2015-09-05 05:50:16'),
(188, 'vasanth s', 'vasanth.s2011@gmail.com', '7396715296', '$2a$10$2705dcabb0f8e23ba19b0uiW3g2oU0JoPmq7NStgHUOikpd8OiB9S', 'Bhagath nagar,Hyd', '', '2015-09-05 07:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2000) NOT NULL,
  `path` varchar(2000) NOT NULL,
  `enccode` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `path`, `enccode`, `date`) VALUES
(1, 'Santosh', '\\dfsf\\sdf\\', '12453', '2015-09-03 10:09:30'),
(2, '1', 'Santosh', '1', '2015-09-03 11:45:10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
