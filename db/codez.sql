-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2016 at 04:12 PM
-- Server version: 5.1.56-community-log
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projekti2_2016_syksy_halooproductions`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `place_id`) VALUES
(1, 'Finland', 'ChIJ3fYyS9_KgUYREKh1PNZGAQA'),
(2, 'Sweden', 'ChIJ8fA1bTmyXEYRYm-tjaLruCI'),
(3, 'Germany', 'ChIJa76xwh5ymkcRW-WRjmtd6HU'),
(7, 'Austria', 'ChIJfyqdJZsHbUcRr8Hk3XvUEhA'),
(8, 'France', 'ChIJMVd4MymgVA0R99lHx5Y__Ws'),
(9, 'Norway', 'ChIJv-VNj0VoEkYRK9BkuJ07sKE'),
(10, 'Russia', 'ChIJ-yRniZpWPEURE_YRZvj9CRQ'),
(11, 'China', 'ChIJwULG5WSOUDERbzafNHyqHZU'),
(12, 'The Netherlands', 'ChIJu-SH28MJxkcRnwq9_851obM'),
(13, 'Lithuania', 'ChIJE74zDxSU3UYRubpdpdNUCvM'),
(14, 'Hungary', 'ChIJw-Q333uDQUcREBAeDCnEAAA'),
(15, 'Belgium', 'ChIJl5fz7WR9wUcR8g_mObTy60c'),
(16, 'Ireland', 'ChIJ-ydAXOS6WUgRCPTbzjQSfM8'),
(17, 'Slovenia', 'ChIJYYOWXuckZUcRZdTiJR5FQOc'),
(18, 'Switzerland', 'ChIJYW1Zb-9kjEcRFXvLDxG1Vlw');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`) VALUES
(1, 'Energy Technology', '0713'),
(2, 'Environmental Engineering', '0712'),
(3, 'Ind Management', '071'),
(4, 'Mechanical Engineering', '0715'),
(5, 'Architect', '0731'),
(6, 'Construction Engineering', '0732'),
(7, 'Electrical Engineering', '0713'),
(8, 'Information Technology', '0612'),
(9, 'Others', '');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE IF NOT EXISTS `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `writer` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `url`, `writer`, `school_id`) VALUES
(1, 'a131af6f3ca897755a66b9579a7c641806fa3237.pdf', 'Tuukka Heiskanen', 2);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `place_id`, `country`, `city`) VALUES
(2, 'Fachhochschule Joanneum', 'ChIJLYk4QQ81bkcRKul1kk-dNV8', 7, 'Graz'),
(3, 'UniversitÃ© d''Artois, IUT BÃ©thune', 'ChIJVVRAO_4i3UcR5XnRCcLc84I', 8, 'Bethune'),
(4, 'Noordelijke Hogeschool Leeuwarden', 'ChIJWT7DrX7-yEcRzYoJuDwUs8o', 12, 'Leeuwarden'),
(5, 'Obuda University', 'ChIJE9VZDV3ZQUcRkL1Ca77HW7w', 14, 'Budapest'),
(6, 'Shanghai Second Polytechnic Univesity', 'ChIJTe9PyD-KrTURO_cT3m6pBL0', 11, 'Shanghai'),
(7, 'St. Petersburg Electrotechnical University "LETI"', 'ChIJOaJ07VgxlkYRQOWnCbZvWCg', 10, 'St. Petersburg');

-- --------------------------------------------------------

--
-- Table structure for table `school_has_department`
--

CREATE TABLE IF NOT EXISTS `school_has_department` (
  `school_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  KEY `school_id` (`school_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_has_department`
--

INSERT INTO `school_has_department` (`school_id`, `department_id`) VALUES
(2, 3),
(2, 8),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 8),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`) VALUES
(4, 'admin', 'admin', 'Admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `fk_schools_id` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `fk_school_country` FOREIGN KEY (`country`) REFERENCES `countries` (`id`);

--
-- Constraints for table `school_has_department`
--
ALTER TABLE `school_has_department`
  ADD CONSTRAINT `school_has_department_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `school_has_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
