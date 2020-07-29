-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 18 juil. 2020 à 17:53
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetpro`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(7, 'CAT 1'),
(5, 'CAT 2'),
(13, 'categ'),
(9, 'CAT 3');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` int(11) NOT NULL,
  `avis` varchar(255) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_plats` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `goututilisateurs`
--

DROP TABLE IF EXISTS `goututilisateurs`;
CREATE TABLE IF NOT EXISTS `goututilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `boeuf` int(11) NOT NULL,
  `poulet` int(11) NOT NULL,
  `dinde` int(11) NOT NULL,
  `saumon` int(11) NOT NULL,
  `thon` int(11) NOT NULL,
  `calamar` int(11) NOT NULL,
  `haricots` int(11) NOT NULL,
  `pommeDeTerre` int(11) NOT NULL,
  `brocolis` int(11) NOT NULL,
  `avocat` int(11) NOT NULL,
  `choux` int(11) NOT NULL,
  `salade` int(11) NOT NULL,
  `poivrons` int(11) NOT NULL,
  `champignons` int(11) NOT NULL,
  `lentilles` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `goututilisateurs`
--

INSERT INTO `goututilisateurs` (`id`, `id_utilisateur`, `boeuf`, `poulet`, `dinde`, `saumon`, `thon`, `calamar`, `haricots`, `pommeDeTerre`, `brocolis`, `avocat`, `choux`, `salade`, `poivrons`, `champignons`, `lentilles`) VALUES
(1, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom`) VALUES
(1, 'Boeuf'),
(2, 'Saumon'),
(3, 'Poulet');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `id_utilisateur`, `id_produit`, `quantite`, `prix`) VALUES
(1, 4, 8, 1, 25),
(2, 4, 9, 1, 25),
(7, 4, 10, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `img1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `img2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `nom`, `description`, `prix`, `id_categorie`, `img1`, `img2`) VALUES
(30, 'nom', 'salade', 10, 7, '330515.jpgjpg', '748855.jpgjpg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(3, 'lop change', '$2y$12$NvmuwOGLLHpESrrtX6oJ2eJXK8MMqD7QSiOcWyShUJPiped4gB9AO'),
(2, 'Katakuri', '$2y$12$.6j3M8nb4tjhP6I6us5M3u9F05u02XuU3GXTXLY.jqNPeaY5r0vXi'),
(4, 'admin', '$2y$12$ye935Pc9V7CHMlYoJAd65uX8MCL2upmVRYb2koPNLf9JEZo6U3NFW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
