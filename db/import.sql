CREATE DATABASE IF NOT EXISTS kartta;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kartta`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Vedos taulusta `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`) VALUES
(1, 'Tietotekniikka', '0612'),
(2, 'Sähkötekniikka', '0713'),
(3, 'Rakennustekniikka', '0732');

-- --------------------------------------------------------

--
-- Rakenne taululle `experiences`
--

CREATE TABLE IF NOT EXISTS `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `writer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country`),
  KEY `city_id` (`city`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Vedos taulusta `schools`
--

INSERT INTO `schools` (`id`, `name`, `place_id`, `country`, `city`) VALUES
(1, 'Hochschule Ostwestfalen-Lippe', 'ChIJn7IKU5pCukcROdGCKQD3FX4', 3, 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `school_has_department`
--

CREATE TABLE IF NOT EXISTS `school_has_department` (
  `school_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  KEY `school_id` (`school_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `school_has_department`
--

INSERT INTO `school_has_department` (`school_id`, `department_id`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`) VALUES
(1, 'lulBOi', 'xDLuL', 'Testi'),
(3, 'SakeTheBous', 'ez', 'Santeri Remes');

--
-- Rajoitteet vedostauluille
--

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
  ADD CONSTRAINT `school_has_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `school_has_department_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
