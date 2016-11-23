-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09.11.2016 klo 11:01
-- Palvelimen versio: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kartta`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `cities`
--

INSERT INTO `cities` (`id`, `name`, `place_id`) VALUES
(1, 'Regensburg', 'ChIJ9y4icpjBn0cREMs3CaQlHQQ'),
(2, 'Kuopio', 'ChIJ88T-r4qwhEYRwPbfnn33tuc');

-- --------------------------------------------------------

--
-- Rakenne taululle `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `countries`
--

INSERT INTO `countries` (`id`, `name`, `place_id`) VALUES
(1, 'Suomi', 'ChIJ3fYyS9_KgUYREKh1PNZGAQA'),
(2, 'Ruotsi', 'ChIJ8fA1bTmyXEYRYm-tjaLruCI'),
(3, 'Saksa', 'ChIJa76xwh5ymkcRW-WRjmtd6HU');

-- --------------------------------------------------------

--
-- Rakenne taululle `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`) VALUES
(1, 'Energiatekniikka', '0713'),
(2, 'Ympäristötekniikka', '0712'),
(3, 'Ind Management', '071'),
(4, 'Konetekniikka', '0715'),
(5, 'Rakennusarkkitehti', '0731'),
(6, 'Rakennustekniikka', '0732'),
(7, 'Sähkötekniikka', '0713'),
(8, 'Tietotekniikka', '0612'),
(9, 'Muut savonia alat', '');

-- --------------------------------------------------------


--
-- Rakenne taululle `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `city` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `schools`
--

INSERT INTO `schools` (`id`, `name`, `place_id`, `country`, `city`) VALUES
(1, 'Hochschule Ostwestfalen-Lippe', 'ChIJn7IKU5pCukcROdGCKQD3FX4', 3, 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `school_has_department`
--

CREATE TABLE `school_has_department` (
  `school_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Rakenne taululle `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `writer` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`) VALUES
(1, 'lulBOi', 'xDLuL', 'Testi'),
(3, 'SakeTheBous', 'ez', 'Santeri Remes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);



--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country`),
  ADD KEY `city_id` (`city`);
  
--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);
  
--
-- Indexes for table `school_has_department`
--
ALTER TABLE `school_has_department`
  ADD KEY `school_id` (`school_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Rajoitteet vedostauluille
--
--
-- Rajoitteet taululle `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `fk_schools_id` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);
--
-- Rajoitteet taululle `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `fk_school_city` FOREIGN KEY (`city`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_school_country` FOREIGN KEY (`country`) REFERENCES `countries` (`id`);

--
-- Rajoitteet taululle `school_has_department`
--
ALTER TABLE `school_has_department`
  ADD CONSTRAINT `school_has_department_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `school_has_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;