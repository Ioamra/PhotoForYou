-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 22 mars 2022 à 19:04
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
('graffiti'),
('paysage'),
('peinture acrylique'),
('portrait');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `nom_image` varchar(20) NOT NULL,
  `prix_image` int(11) NOT NULL,
  `chemin_image` varchar(60) NOT NULL,
  `nom_categorie` varchar(60) NOT NULL,
  `id_vendeur` int(11) NOT NULL,
  `id_acheteur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `nom_image`, `prix_image`, `chemin_image`, `nom_categorie`, `id_vendeur`, `id_acheteur`) VALUES
(1, 'Dune', 200, 'upload/graffiti/Dune21-03-22_13-40-45.jpg', 'graffiti', 11, NULL),
(2, 'Glacier', 150, 'upload/paysage/Glacier21-03-22_13-41-04.jpg', 'paysage', 11, NULL),
(3, 'Graffeur du futur', 200, 'upload/graffiti/Graffeur-du-futur21-03-22_13-41-20.jpg', 'graffiti', 11, NULL),
(4, 'Graffiti personnage', 200, 'upload/graffiti/Graffiti-personnage21-03-22_13-41-36.jpg', 'graffiti', 11, NULL),
(5, 'Change Your Agenda', 200, 'upload/graffiti/Change-Your-Agenda21-03-22_13-42-00.jpg', 'graffiti', 11, NULL),
(6, 'La sainte victoire', 250, 'upload/paysage/La-sainte-victoire21-03-22_13-42-15.jpg', 'paysage', 11, NULL),
(7, 'Libellule', 400, 'upload/peinture-acrylique/Libellule21-03-22_13-42-30.jpg', 'peinture acrylique', 11, NULL),
(8, 'Montagne', 200, 'upload/paysage/Montagne21-03-22_13-42-47.jpg', 'paysage', 11, NULL),
(9, 'Portrait Street Art', 350, 'upload/portrait/Portrait-Street-Art21-03-22_13-43-16.jpg', 'portrait', 11, NULL),
(10, 'Portrait Street Art', 320, 'upload/portrait/Portrait-Street-Art21-03-22_13-44-43.jpg', 'portrait', 11, NULL),
(11, 'Turfu', 450, 'upload/peinture-acrylique/Turfu21-03-22_13-45-23.jpg', 'peinture acrylique', 11, NULL);

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
(3, 'Déposer des images', 'deposer-des-images.php', 2),
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
  `pseudo` varchar(20) NOT NULL,
  `img_profil` varchar(50) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `mdp` varchar(40) NOT NULL,
  `grade` varchar(40) NOT NULL,
  `SIRET` varchar(14) DEFAULT NULL,
  `credits` int(11) NOT NULL DEFAULT '0',
  `etat` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `pseudo`, `img_profil`, `mail`, `mdp`, `grade`, `SIRET`, `credits`, `etat`) VALUES
(1, 'admin', 'admin', 'admin', 'upload/user/defaut.png', 'admin@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'admin', '0', 10019, 'valid'),
(2, 'Maroud', 'Kevin', 'Lareyku', 'upload/user/defaut.png', 'photographe@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567890123', 0, 'valid'),
(3, 'Duval', 'Jordan', 'Belorik', 'upload/user/defaut.png', 'client@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'client', '0', 0, 'valid'),
(5, 'Majou', 'Marie', 'Deyrha', 'upload/user/defaut.png', 'test@test.te', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567891234', 0, 'banni'),
(11, 'Kazey', 'Jean', 'Kahrean', 'upload/user/defaut.png', 'test@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '12365478963222', 0, 'valid');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
