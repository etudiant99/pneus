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
-- Structure de la table `wp_inv_pneus`
--

CREATE TABLE IF NOT EXISTS `wp_inv_pneus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pneu` varchar(255) DEFAULT NULL,
  `largeur` varchar(255) DEFAULT NULL,
  `rapport_aspect` varchar(255) DEFAULT NULL,
  `diametre` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Contenu de la table `wp_inv_pneus`
--

INSERT INTO `wp_inv_pneus` (`id`, `pneu`, `largeur`, `rapport_aspect`, `diametre`) VALUES
(1, '6.00-16', NULL, NULL, NULL),
(2, '7.00-16', NULL, NULL, NULL),
(3, '8.90-15', NULL, NULL, NULL),
(4, '8.00-15', NULL, NULL, NULL),
(5, '6.50-15', NULL, NULL, NULL),
(6, '8.00-14', NULL, NULL, NULL),
(7, '8.50-14', NULL, NULL, NULL),
(8, '7.60-15', NULL, NULL, NULL),
(9, '195/70R14', '195', '70R\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n70R\r\n', 14),
(10, '195/65R15', NULL, NULL, NULL),
(11, '205/65R15', NULL, NULL, NULL),
(12, '195/65R15', NULL, NULL, NULL),
(14, '205/60R16', NULL, NULL, NULL),
(15, '155R12', NULL, NULL, NULL),
(16, '6.00-12', NULL, NULL, NULL),
(17, '155R13', NULL, NULL, NULL),
(18, '165R13', NULL, NULL, NULL),
(19, '185/70R13', NULL, NULL, NULL),
(20, '195/60R14', NULL, NULL, NULL),
(21, '185/65R14', NULL, NULL, NULL),
(22, '175/65R14', NULL, NULL, NULL),
(23, '155R15', NULL, NULL, NULL),
(24, 'L78-15', NULL, NULL, NULL),
(25, '8.20-15', NULL, NULL, NULL),
(26, '6.00-13', NULL, NULL, NULL),
(27, '5.20-13', NULL, NULL, NULL),
(28, '165/70R365', NULL, NULL, NULL),
(29, '195/60R15', NULL, NULL, NULL),
(30, '5.00-16', NULL, NULL, NULL),
(31, '7.10-15', NULL, NULL, NULL),
(32, '225/60R16', NULL, NULL, NULL),
(33, '6.40-13', NULL, NULL, NULL),
(34, '7.00-14', NULL, NULL, NULL),
(35, '205/70R14', NULL, NULL, NULL),
(36, '6.70-15', NULL, NULL, NULL),
(37, '7.50-14', NULL, NULL, NULL),
(38, '9.00-14', NULL, NULL, NULL),
(39, '5.60-13', NULL, NULL, NULL),
(40, '235/75R15', NULL, NULL, NULL),
(41, '185R15', NULL, NULL, NULL),
(42, '5.90-13', NULL, NULL, NULL),
(43, '205/75R15', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
