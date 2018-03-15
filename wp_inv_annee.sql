-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 15 Mars 2018 à 19:10
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `tutoriel`
--

-- --------------------------------------------------------

--
-- Structure de la table `wp_inv_annee`
--

CREATE TABLE IF NOT EXISTS `wp_inv_annee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `wp_inv_annee`
--

INSERT INTO `wp_inv_annee` (`id`, `annee`) VALUES
(1, 1942),
(2, 1943),
(3, 1944),
(4, 1945),
(5, 1946),
(6, 1947),
(7, 1948),
(8, 1949),
(9, 1950),
(10, 1951),
(11, 1952),
(12, 1953),
(13, 1954),
(14, 1955),
(15, 1956),
(16, 1957),
(17, 1958),
(18, 1959),
(19, 1960),
(20, 2000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
