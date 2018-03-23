-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 20 Mars 2018 à 17:32
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `medicaments`
--

-- --------------------------------------------------------

--
-- Structure de la table `medicament_substance`
--

CREATE TABLE IF NOT EXISTS `medicament_substance` (
  `medicament_id` int(11) NOT NULL,
  `substance_id` int(11) NOT NULL,
  PRIMARY KEY (`medicament_id`,`substance_id`),
  KEY `IDX_3B0E1B6AAB0D61F7` (`medicament_id`),
  KEY `IDX_3B0E1B6AC707E018` (`substance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `medicament_substance`
--

INSERT INTO `medicament_substance` (`medicament_id`, `substance_id`) VALUES
(1, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `medicament_substance`
--
ALTER TABLE `medicament_substance`
  ADD CONSTRAINT `FK_3B0E1B6AAB0D61F7` FOREIGN KEY (`medicament_id`) REFERENCES `medicament` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3B0E1B6AC707E018` FOREIGN KEY (`substance_id`) REFERENCES `substance` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
