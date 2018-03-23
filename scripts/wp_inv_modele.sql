-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 22 Mars 2018 à 23:01
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
-- Structure de la table `wp_inv_modele`
--

CREATE TABLE IF NOT EXISTS `wp_inv_modele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modele` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Contenu de la table `wp_inv_modele`
--

INSERT INTO `wp_inv_modele` (`id`, `modele`) VALUES
(1, 'Continental'),
(2, 'Commander'),
(3, 'Commercial Chass'),
(4, '300D'),
(5, '98'),
(6, 'Accord'),
(7, 'Anglia'),
(8, 'Bel Air'),
(9, 'Belvedere'),
(10, 'Biscayne'),
(11, 'Bonneville'),
(12, 'Brookwood'),
(13, 'Catalina'),
(14, 'Century'),
(15, 'Civic'),
(16, 'Club'),
(17, 'Colony Park'),
(18, 'Commuter'),
(19, 'Consul'),
(20, 'Corolla'),
(21, 'Corvette'),
(23, 'Country Sedan'),
(24, 'Country Squire'),
(25, 'Custom'),
(26, 'Custom 300'),
(27, 'D100 Pickup'),
(28, 'DeVille'),
(29, 'Dynamic'),
(30, 'Eldorado'),
(31, 'Escort'),
(32, 'F Series'),
(33, 'F-134'),
(34, 'Fairlane'),
(35, 'FC150'),
(36, 'FC170'),
(37, 'Fiesta'),
(38, 'Fury'),
(39, 'Impala'),
(40, 'Imperial'),
(41, 'Karmann Ghia'),
(42, 'Montclair'),
(43, 'Monterey'),
(44, 'New Yorker'),
(45, 'Newport'),
(46, 'P-100'),
(47, 'Park Lane'),
(48, 'Ranch Wagon'),
(49, 'Ranchero'),
(50, 'Savoy'),
(51, 'Sedan Delivery'),
(53, 'Series 60 Fleetwood'),
(54, 'Series 62'),
(55, 'Series 75 Fleetwood'),
(56, 'Skyrlak'),
(57, 'Special'),
(58, 'Squire'),
(59, 'Star Chief'),
(60, 'Starfire'),
(61, 'Suburban'),
(62, 'Sunliner'),
(63, 'Super 88'),
(64, 'Taxi'),
(65, 'Thunderbird'),
(66, 'Town & Country'),
(67, 'Truck'),
(69, 'Utility Wagon'),
(70, 'Victoria'),
(71, 'Willys'),
(72, 'Zodiac'),
(73, 'Corona'),
(74, 'RX-2'),
(75, 'XKE'),
(76, 'GL'),
(77, 'Nomad');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
