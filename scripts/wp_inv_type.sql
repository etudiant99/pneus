-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 24 Mars 2018 à 20:36
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
-- Structure de la table `wp_inv_type`
--

CREATE TABLE IF NOT EXISTS `wp_inv_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `wp_inv_type`
--

INSERT INTO `wp_inv_type` (`id`, `type`) VALUES
(1, '2 Dr Convertible'),
(2, '2 Dr Coupe'),
(3, '2 Dr Hearse'),
(4, '4 Dr Limousine'),
(5, '4 Dr Sedan'),
(7, '2 Dr Hardtop'),
(8, '2 Dr Sedan'),
(9, '3 Dr. Hatchback'),
(10, 'Base (155-R15)'),
(11, '4 Dr Hardtop'),
(12, '4 Dr Wagon'),
(13, '2 Dr Wagon'),
(14, '5 Dr Wagon'),
(15, '2 Dr Standard Cab Pickup'),
(16, '2 Dr Hatchback'),
(17, '3 Dr Standard Passenger'),
(18, '4 Dr Sport Utility'),
(19, '2 Dr Cab & Chassis');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
