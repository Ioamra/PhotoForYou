-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 11 nov. 2021 à 22:33
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `photoforyou`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `nom_categorie` varchar(20) NOT NULL,
  PRIMARY KEY (`nom_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`nom_categorie`) VALUES
('Paysage'),
('Portrait');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `nom_image` varchar(20) NOT NULL,
  `prix_image` int(11) NOT NULL,
  `chemin_image` varchar(40) NOT NULL,
  `nom_categorie` varchar(60) NOT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `nom_image`, `prix_image`, `chemin_image`, `nom_categorie`) VALUES
(32, 'portrait-graffiti-2', 250, 'upload/Portrait/portrait-graffiti-2.jpg', 'Portrait'),
(31, 'portrait-graffiti-1', 150, 'upload/Portrait/portrait-graffiti-1.jpg', 'Portrait'),
(30, 'glacier', 300, 'upload/Paysage/glacier.jpg', 'Paysage'),
(29, 'montagne', 200, 'upload/Paysage/montagne.jpg', 'Paysage'),
(28, 'sainte-victoire', 400, 'upload/Paysage/sainte-victoire.jpg', 'Paysage');

-- --------------------------------------------------------

--
-- Structure de la table `navbar`
--

DROP TABLE IF EXISTS `navbar`;
CREATE TABLE IF NOT EXISTS `navbar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acte` varchar(40) NOT NULL,
  `lien` varchar(40) NOT NULL,
  `droit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `navbar`
--

INSERT INTO `navbar` (`id`, `acte`, `lien`, `droit`) VALUES
(1, 'Acheter des crédits', 'acheter-des-credits.php', 1),
(2, 'Historique des achats', 'historique-des-achats.php', 1),
(3, 'Déposer des images', 'deposer-des-images.php', 2),
(4, 'Historique des ventes', 'historique-des-ventes.php', 2),
(5, 'Gestion Utilisateur', 'Gestion-Utilisateur.php', 3),
(6, 'Gestion Catégorie', 'gestion-categorie.php', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `mdp` varchar(40) NOT NULL,
  `grade` varchar(40) NOT NULL,
  `SIRET` varchar(14) DEFAULT NULL,
  `credits` int(11) NOT NULL DEFAULT '0',
  `etat` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `mail`, `mdp`, `grade`, `SIRET`, `credits`, `etat`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'admin', '0', 0, 'valid'),
(2, 'photographe', 'photographe', 'photographe@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567890123', 0, 'valid'),
(3, 'client', 'client', 'client@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'client', '0', 0, 'valid'),
(5, 'afjehja', 'kfzkenf', 'test@test.te', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567891234', 0, 'banni');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
