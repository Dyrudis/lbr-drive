-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 mai 2022 à 13:55
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lbr_drive`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `IDCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `NomCategorie` text NOT NULL,
  `Couleur` varchar(6) NOT NULL COMMENT 'HEX',
  PRIMARY KEY (`IDCategorie`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`IDCategorie`, `NomCategorie`, `Couleur`) VALUES
(0, 'Autres', '3b3d3f'),
(1, 'Edition', '2c8cb5'),
(2, 'Lieu', '109e54');

-- --------------------------------------------------------

--
-- Structure de la table `classifier`
--

DROP TABLE IF EXISTS `classifier`;
CREATE TABLE IF NOT EXISTS `classifier` (
  `IDFichier` varchar(10) NOT NULL,
  `IDTag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fichier`
--

DROP TABLE IF EXISTS `fichier`;
CREATE TABLE IF NOT EXISTS `fichier` (
  `IDFichier` varchar(10) NOT NULL,
  `Nom` text NOT NULL,
  `IDUtilisateur` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Taille` int(11) NOT NULL COMMENT 'En octets',
  `Type` varchar(16) NOT NULL,
  `Extension` varchar(4) NOT NULL,
  `Duree` int(11) NOT NULL COMMENT 'En secondes',
  `Corbeille` date,
  PRIMARY KEY (`IDFichier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `IDTag` int(11) NOT NULL AUTO_INCREMENT,
  `NomTag` text NOT NULL,
  `IDCategorie` int(11) NOT NULL,
  PRIMARY KEY (`IDTag`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`IDTag`, `NomTag`, `IDCategorie`) VALUES
(0, 'Sans tag', 0),
(1, 'Jour', 0),
(2, 'Nuit', 0),
(3, '2021', 1),
(4, '2022', 1),
(5, '2023', 1),
(6, '2024', 1),
(7, 'Scene 1', 2),
(8, 'Scene 2', 2),
(9, 'Backstage', 2),
(10, 'Camping', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `IDUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` text NOT NULL,
  `Prenom` text NOT NULL,
  `Email` text NOT NULL,
  `MotDePasse` text NOT NULL,
  `Description` text NOT NULL,
  `Role` varchar(16) NOT NULL,
  `Actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`IDUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDUtilisateur`, `Nom`, `Prenom`, `Email`, `MotDePasse`, `Description`, `Role`, `Actif`) VALUES
(1, 'NomAdmin', 'PrenomAdmin', 'a@a', '$2y$10$n8MAwj9VAZFfkfhULkr.hOysFkzXPUYLc8UA16xSw3QjgFSK.P9IK', 'DescriptionAdmin', 'admin', 1),
(2, 'NomEcriture', 'PrenomEcriture', 'e@e', '$2y$10$n8MAwj9VAZFfkfhULkr.hOysFkzXPUYLc8UA16xSw3QjgFSK.P9IK', 'DescriptionEcriture', 'ecriture', 1),
(3, 'NomInvite', 'PrenomInvite', 'i@i', '$2y$10$n8MAwj9VAZFfkfhULkr.hOysFkzXPUYLc8UA16xSw3QjgFSK.P9IK', 'DescriptionInvite', 'invite', 1),
(4, 'NomLecture', 'PrenomLecture', 'l@l', '$2y$10$n8MAwj9VAZFfkfhULkr.hOysFkzXPUYLc8UA16xSw3QjgFSK.P9IK', 'DescriptionLecture', 'lecture', 1);

-- --------------------------------------------------------

--
-- Structure de la table `restreindre`
--

DROP TABLE IF EXISTS `restreindre`;
CREATE TABLE IF NOT EXISTS `restreindre` (
  `IDUtilisateur` int(11) NOT NULL,
  `IDTag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `restreindre`
--

INSERT INTO `restreindre` (`IDUtilisateur`, `IDTag`) VALUES
(3, 0),
(3, 2),
(3, 3),
(3, 4);

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `IDLog` int(11) NOT NULL AUTO_INCREMENT,
  `IDSource` int(11) NOT NULL COMMENT 'ID de l''utilisateur à l''origine de l''émission du log',
  `Date` timestamp NOT NULL COMMENT 'Date de l''événement',
  `Description` text NOT NULL COMMENT 'Description de l''événement',
  PRIMARY KEY (`IDLog`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
