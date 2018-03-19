-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 18 Mars 2018 à 20:51
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
(9, '195/70R14', '195', '70R\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n70R\r\n', 14),
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
(22, '175/65R14', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
