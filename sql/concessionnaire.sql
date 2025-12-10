-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2025 at 01:16 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concessionnaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_vehicule` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `message` text COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_vehicule` (`id_vehicule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_rapide`
--

DROP TABLE IF EXISTS `reservation_rapide`;
CREATE TABLE IF NOT EXISTS `reservation_rapide` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `code_postal` int NOT NULL,
  `id_vehicule` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `message` text COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_id_vehicule_3` (`id_vehicule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `motdepasse` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `code_postal` varchar(5) COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant` (`identifiant`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`, `nom`, `prenom`, `email`, `adresse`, `ville`, `code_postal`, `role`) VALUES
(1, 'Concessionnaire', 'Bv9x9h9U', '', '', '', '', '', '', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `vehicules`
--

DROP TABLE IF EXISTS `vehicules`;
CREATE TABLE IF NOT EXISTS `vehicules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_vehicule` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `marque` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `annee_vehicule` year NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `prix_jour` decimal(10,0) NOT NULL,
  `nb_places` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vehicules`
--

INSERT INTO `vehicules` (`id`, `nom_vehicule`, `marque`, `annee_vehicule`, `description`, `image`, `prix_jour`, `nb_places`) VALUES
(1, 'Peugeot 206', 'Peugeot', '1998', 'Petite citadine économique, parfaite pour les trajets quotidiens.', 'peugeot206.jpg', 30, 5),
(2, 'Nissan Qashqai', 'Nissan', '2007', 'SUV confortable, idéal pour les familles et les longs trajets.', 'qashqai.jpg', 55, 5),
(3, 'Renault Clio 4', 'Renault', '2015', 'Voiture moderne, faible consommation et conduite agréable.','clio4.jpg',40, 5),
(4, 'Audi A3', 'Audi', '2018', 'Berline premium, idéale pour ceux cherchant confort et performance.','audi_a3.jpg',75, 5),
(5, 'BMW X5', 'BMW', '2020', 'SUV haut de gamme, puissant et parfait pour longs trajets.','bmw_x5.jpg',120, 7);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_rapide`
--
ALTER TABLE `reservation_rapide`
  ADD CONSTRAINT `fk_id_vehicule_3` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
