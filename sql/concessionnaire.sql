-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2025 at 12:51 PM
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
  `nom` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `message`) VALUES
(1, 'sefora', 'sefora@iuo.fr', 'testde msg'),
(2, 'ji', 'ji@outlook.fr', 'ceci est un test effectué le 14 / 12 / 2025');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'sor@65.ouf');

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
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_vehicule` (`id_vehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `id_utilisateur`, `id_vehicule`, `date_debut`, `date_fin`, `total`, `message`) VALUES
(1, 2, 2, '2025-12-19', '2025-12-28', 648.00, ''),
(2, 2, 10, '2025-12-14', '2025-12-21', 2100.00, ''),
(3, 2, 22, '2025-12-21', '2025-12-28', 1050.00, ''),
(4, 2, 1, '2025-12-21', '2025-12-23', 100.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_rapide`
--

DROP TABLE IF EXISTS `reservation_rapide`;
CREATE TABLE IF NOT EXISTS `reservation_rapide` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prenom` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `adresse` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ville` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `code_postal` int NOT NULL,
  `id_vehicule` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_id_vehicule_3` (`id_vehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `reservation_rapide`
--

INSERT INTO `reservation_rapide` (`id`, `nom`, `prenom`, `email`, `adresse`, `ville`, `code_postal`, `id_vehicule`, `date_debut`, `date_fin`, `total`, `message`) VALUES
(6, 'ff', 'fdd', 'ff.fdd@hj.fr', 'd,dovd', 'dggsgf', 98754, 2, '2025-12-17', '2025-12-27', 720, 'gsdgxc'),
(7, 's', 'sy', 'test@testr.fr', '4 reu fer', 'ormo', 45000, 24, '2025-12-20', '2025-12-26', 300, 'dvsgdfhhndgn'),
(8, 's', 's', 's@uy.gt', '12 rue des lui', 'ormoy', 91540, 7, '2025-12-22', '2025-12-29', 3150, 'ce\'est un test');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `motdepasse` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prenom` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `adresse` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ville` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `code_postal` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` enum('client','admin') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant` (`identifiant`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`, `nom`, `prenom`, `email`, `adresse`, `ville`, `code_postal`, `role`) VALUES
(1, 'Concessionnaire', '$2y$12$1sSure6YtTHXuZNoSTwwn.lUPHJkQK/C724L.iK2JrKzYLXUXDf/e', '', '', '', '', '', '', 'admin'),
(2, 's', '$2y$12$yYukZvZ2GzSN8zmbQikCtumbOE05.MbleHA7GHjKUcutIkmPx3hQu', 's', 's', 's@s.fr', '', '', '', 'client');

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
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prix_jour` decimal(10,0) NOT NULL,
  `nb_places` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vehicules`
--

INSERT INTO `vehicules` (`id`, `nom_vehicule`, `marque`, `annee_vehicule`, `description`, `image`, `prix_jour`, `nb_places`) VALUES
(1, 'Peugeot 206', 'Peugeot', '1998', '', '206.jpg', 50, 5),
(2, 'Nissan Qashqai', 'Nissan', '2007', '', 'qashqai.jpg', 72, 5),
(3, 'Smart fortwo coupe', 'Smart', '2018', '', '693ee8db458e6.png', 25, 2),
(4, 'Audi A3', 'Audi', '2020', '', '693eeeeaa2a8e.jpg', 250, 5),
(5, 'BMW X5', 'BMW', '2019', '', '693eef1ec4fc3.jpg', 200, 5),
(6, 'Clio 4', 'Renault', '2013', '', '693ef0a049764.jpg', 85, 3),
(7, 'Audi SQ7', 'Audi', '2018', '', '693ef185be430.jpeg', 450, 5),
(8, 'Audi RS6 Avant', 'Audi', '2020', '', '693ef1c746a43.jpg', 600, 5),
(9, 'Dodge RAM', 'Dodge', '2022', '', '693ef22d94e27.jpeg', 400, 4),
(10, 'Dodge charger SRT', 'Dodge', '1978', '', '693ef2ea9cdcf.jpg', 300, 4),
(11, 'Lamborghini Aventador', 'Lamborghini', '2018', '', '693ef3792146f.jpg', 600, 2),
(12, 'VW T-ROC', 'VW ', '2021', '', '693f0e695e438.jpg', 150, 5),
(13, 'Toyota yaris', 'Toyota', '2023', '', '693f23cde7da4.jpg', 37, 5),
(14, 'BMW M3 CS', 'BMW', '2023', '', '693f2698225f3.jpg', 250, 5),
(15, 'AUDI RS3', 'AUDI', '2022', '', '693f26d911a8c.jpg', 250, 4),
(16, 'Peugeot 208', 'Peugeot', '2024', '', '693f276cefd50.jpeg', 150, 5),
(17, 'Porsche Cayenne', 'Porsche', '2024', '', '693f284d35e2f.jpg', 300, 5),
(18, 'Lamborghini Urus', 'Lamborghini', '2022', '', '693f28a0d2a63.jpg', 600, 5),
(19, 'Peugeot 3008', 'Peugeot', '2022', '', '693f291d7c623.jpg', 150, 5),
(20, 'Tesla Model S', 'Tesla', '2018', '', '693f29a12f736.jpg', 200, 4),
(21, 'Range Rover sport', 'Range Rover', '2023', '', '693f2a14f1fa2.jpg', 420, 5),
(22, 'Dodge challenger', 'Dodge', '1971', '', '693f2afa1a8f6.jpg', 150, 4),
(23, 'VW Golf 7', 'VW', '2020', '', '693f2b608fb4e.jpg', 75, 5),
(24, 'Citroen ami', 'Citroen', '2025', '', '693f2bab29107.jpg', 50, 2),
(25, 'Fiat 500', 'Fiat', '2024', '', '693f2be59c88b.jpg', 100, 2),
(26, 'Suzuki swift', 'Suzuki', '2024', '', '693f2c409b7e1.jpg', 75, 4),
(27, 'Mini Cooper', 'Mini', '2024', '', '693f2c82abe85.jpg', 130, 4),
(28, 'Toyota aygo', 'Toyota', '2025', '', '693f2cd833714.jpg', 100, 4),
(29, 'Citroen c3', 'Citroen', '2025', '', '693f2d25d969f.jpg', 90, 5),
(30, 'Suzuki ignis', 'Suzuki', '2024', '', '693f2daa697ae.jpg', 50, 4),
(31, 'Audi a5', 'audi', '2020', '', '694146b72bf57.jpg', 250, 5);

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
