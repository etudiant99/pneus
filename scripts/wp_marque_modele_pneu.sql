-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 24 Mars 2018 à 20:37
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
-- Structure de la table `wp_marque_modele_pneu`
--

CREATE TABLE IF NOT EXISTS `wp_marque_modele_pneu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque_id` int(11) DEFAULT NULL,
  `modele_id` int(11) DEFAULT NULL,
  `pneu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Contenu de la table `wp_marque_modele_pneu`
--

INSERT INTO `wp_marque_modele_pneu` (`id`, `marque_id`, `modele_id`, `pneu_id`) VALUES
(1, 1, 2, 5),
(2, 1, 57, 31),
(3, 1, 14, 31),
(4, 16, 6, 17),
(5, 16, 15, 15),
(6, 1, 56, 9),
(7, 9, 7, 30),
(8, 9, 25, NULL),
(9, 9, 23, 1),
(10, 9, 48, 36),
(11, 9, 19, 39),
(12, 9, 70, 31),
(13, 9, 16, 8),
(14, 9, 24, 8),
(15, 9, 31, 27),
(16, 9, 32, 40),
(17, 9, 34, 31),
(18, 9, 49, 37),
(19, 9, 62, 37),
(20, 9, 65, 6),
(21, 9, 72, 33),
(22, 9, 46, 37),
(23, 9, 58, 27),
(24, 9, 26, 26),
(25, 2, 3, 3),
(26, 2, 28, 24),
(27, 2, 30, 4),
(28, 2, 53, 4),
(29, 2, 54, 4),
(30, 2, 55, 25),
(31, 3, 8, 36),
(32, 3, 10, 37),
(33, 3, 12, 37),
(34, 3, 21, 36),
(35, 3, 39, 37),
(36, 3, 77, 6),
(37, 3, 51, 6),
(38, 3, 67, 1),
(39, 7, 40, 25),
(40, 7, 44, 4),
(41, 7, 45, 37),
(42, 7, 66, 25),
(43, 8, 25, 6),
(44, 8, 27, 31),
(45, 6, 33, 2),
(46, 6, 35, 2),
(47, 6, 36, 2),
(48, 6, 67, NULL),
(49, 6, 69, 2),
(50, 6, 71, NULL),
(51, 19, 75, 41),
(52, 4, 1, 2),
(53, 18, 74, 18),
(54, 15, 4, 8),
(55, 12, 17, 7),
(56, 12, 18, 6),
(57, 12, 47, 7),
(58, 12, 42, 7),
(59, 12, 43, 31),
(60, 13, 5, 8),
(61, 13, 29, 7),
(62, 13, 37, 8),
(63, 13, 63, 8),
(64, 10, 9, 8),
(65, 10, 25, 37),
(66, 10, 38, 37),
(67, 10, 50, 36),
(68, 10, 61, 8),
(69, 11, 11, 6),
(70, 11, 13, 31),
(71, 11, 59, 31),
(72, 5, 2, 1),
(73, 5, 64, 5),
(74, 14, 41, 7),
(75, 20, 76, 17),
(76, 17, 20, 20),
(77, 17, 73, 73),
(78, 9, 65, 32),
(79, 16, 15, 22),
(80, 16, 6, 10),
(81, 16, 6, 11),
(82, 2, 3, 25),
(83, 3, 8, 37),
(84, 3, 21, 43),
(85, 4, 1, 38),
(86, 5, 2, 5),
(87, 5, 2, 31),
(88, 5, 2, 8),
(89, 7, 44, 38),
(90, 7, 40, 4),
(91, 7, 45, 4),
(92, 7, 66, 7),
(93, 9, 7, 27),
(94, 9, 23, 8),
(95, 9, 48, 6),
(96, 9, 70, 34),
(97, 9, 19, 42),
(98, 9, 34, 37),
(99, 9, 31, 28),
(100, 9, 31, 29),
(101, 10, 61, 6),
(102, 10, 9, 36),
(103, 10, 9, 37),
(104, 10, 50, 37),
(105, 11, 13, 6),
(106, 11, 59, 6),
(107, 12, 43, 6),
(108, 12, 42, 6),
(109, 13, 5, 7),
(110, 13, 63, 38),
(111, 13, 37, 7),
(112, 21, 78, 44),
(113, 22, 79, 45),
(114, 23, 80, 19),
(115, 14, 81, 46),
(116, 14, 41, 23),
(117, 14, 82, 46),
(118, 14, 83, 47),
(119, 14, 84, 46),
(120, 14, 85, 17),
(121, 14, 86, 17),
(122, 14, 87, 48),
(123, 14, 88, 49),
(124, 14, 89, 48),
(125, 14, 90, 50),
(126, 16, 91, 48),
(127, 17, 92, 51),
(128, 17, 73, 26),
(129, 17, 93, 51),
(130, 17, 94, 52),
(131, 17, 95, 53),
(132, 17, 96, 54),
(133, 17, 97, 17),
(134, 6, 71, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
