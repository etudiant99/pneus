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
-- Structure de la table `wp_inv_options`
--

CREATE TABLE IF NOT EXISTS `wp_inv_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `options` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Contenu de la table `wp_inv_options`
--

INSERT INTO `wp_inv_options` (`id`, `options`) VALUES
(1, 'Base'),
(2, 'Deluxe'),
(3, 'Regal Deluxe'),
(4, 'Land Cruiser'),
(5, 'Base (8.00-14)'),
(6, 'Base (8.50-14)'),
(7, 'BASE (155R12)'),
(8, 'BASE (6.00-12)'),
(9, 'BASE (8.00-15)'),
(10, 'BASE (8.00-15DS)'),
(11, 'DX 4 cyl.'),
(12, 'DX'),
(13, 'LX 4 cyl. (195/65R15 89 H 6x15 4x114.3)'),
(14, 'LX V6 (205/65R15 92V 6.5X15 5X114.3)'),
(15, 'LX 4 cyl.'),
(16, 'LX V6'),
(17, 'LX'),
(18, 'S'),
(19, 'SE 4 cyl.'),
(20, 'EX 4 cyl.'),
(21, 'EX V6'),
(22, 'LXi'),
(23, 'EX V6 16po option'),
(24, 'CE(175/65R14 81 S)'),
(25, 'Base (155R15)'),
(26, 'Mark II (6.00-13)'),
(27, 'Base (7.10-15)'),
(28, 'Super Coupe'),
(29, 'Base (7.00-14)'),
(30, 'Base (7.10-15 6x15)'),
(31, 'Base (7.50-14)'),
(32, 'Base (6.70-15)'),
(33, 'Base (7.60-15)'),
(34, 'Base (7.60-15 5x15)'),
(35, 'Base (185R15)'),
(36, 'Base (155R13)'),
(37, 'Base (8.20-15)'),
(38, 'MKI'),
(39, 'MKII'),
(40, 'Base (205/75R15)'),
(41, 'Base (155R15 78S)'),
(42, 'Base (175R13 73 S)'),
(43, 'Base (155R13 73 S)'),
(44, 'GT'),
(45, 'Luxury'),
(46, 'BJ60'),
(47, 'STD(155R13 79S)');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
