-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 24 Mars 2018 à 20:35
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `denis`
--

-- --------------------------------------------------------

--
-- Structure de la table `wp_inv_marque`
--

CREATE TABLE IF NOT EXISTS `wp_inv_marque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `wp_inv_marque`
--

INSERT INTO `wp_inv_marque` (`id`, `marque`) VALUES
(1, 'Buick'),
(2, 'Cadillac'),
(3, 'Chevrolet'),
(4, 'Lincoln'),
(5, 'Studebaker'),
(6, 'Jeep'),
(7, 'Chrysler'),
(8, 'Dodge'),
(9, 'Ford'),
(10, 'Plymouth'),
(11, 'Pontiac'),
(12, 'Mercury'),
(13, 'Oldsmobile'),
(14, 'Volkswagen'),
(15, 'Mercedes-Benz'),
(16, 'Honda'),
(17, 'Toyota'),
(18, 'Mazda'),
(19, 'Jaguard'),
(20, 'Subaru'),
(21, 'Alpha Roméo'),
(22, 'American Motors'),
(23, 'BMW'),
(24, '1971');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
