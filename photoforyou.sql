-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 08 mai 2022 à 22:13
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
('Animaux'),
('Océan'),
('Paysage');

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
  `date_achat` varchar(10) DEFAULT NULL,
  `heure_achat` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `nom_image`, `prix_image`, `chemin_image`, `nom_categorie`, `id_vendeur`, `id_acheteur`, `date_achat`, `heure_achat`) VALUES
(30, 'Corail', 300, 'upload/Océan/Corail02-05-22_15-56-54.jpg', 'Océan', 2, NULL, NULL, NULL),
(29, 'Corail étrange', 500, 'upload/Océan/Corail-étrange02-05-22_15-56-41.jpg', 'Océan', 2, NULL, NULL, NULL),
(28, 'Fond marin', 250, 'upload/Océan/Fond-marin02-05-22_15-56-04.jpg', 'Océan', 2, NULL, NULL, NULL),
(27, 'Paysage Canadien', 1100, 'upload/Paysage/Paysage-Canadien02-05-22_15-44-52.jpg', 'Paysage', 2, NULL, NULL, NULL),
(26, 'Arbre d\'australie', 7000, 'upload/Paysage/Arbre-d\'australie02-05-22_15-44-26.jpg', 'Paysage', 2, NULL, NULL, NULL),
(25, 'Lac d\'hiver', 600, 'upload/Paysage/Lac-d\'hiver02-05-22_15-41-37.jpg', 'Paysage', 2, NULL, NULL, NULL),
(24, 'Massif de Belledonne', 2200, 'upload/Paysage/Massif-de-Belledonne02-05-22_15-40-25.jpg', 'Paysage', 2, NULL, NULL, NULL),
(22, 'Aigle', 1700, 'upload/Animaux/Aigle02-05-22_15-03-24.jpg', 'Animaux', 2, NULL, NULL, NULL),
(21, 'Lion', 300, 'upload/Animaux/Lion02-05-22_15-02-26.jpg', 'Animaux', 2, 3, '2022-05-02', '18:07'),
(19, 'Renard', 500, 'upload/Animaux/Renard02-05-22_14-59-03.jpg', 'Animaux', 2, NULL, NULL, NULL),
(20, 'Tigre', 400, 'upload/Animaux/Tigre02-05-22_15-02-09.jpg', 'Animaux', 2, NULL, NULL, NULL),
(23, 'Forêt d\'automne', 600, 'upload/Paysage/Forêt-d\'automne02-05-22_15-23-07.jpg', 'Paysage', 2, NULL, NULL, NULL),
(32, 'Corail habité', 650, 'upload/Océan/Corail-habité02-05-22_15-57-36.jpg', 'Océan', 2, NULL, NULL, NULL),
(31, 'Vague d\'australie', 1400, 'upload/Océan/Vague-d\'australie02-05-22_15-57-13.jpg', 'Océan', 2, NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `pseudo`, `img_profil`, `mail`, `mdp`, `grade`, `SIRET`, `credits`, `etat`) VALUES
(1, 'admin', 'admin', 'admin', 'upload/user/defaut.png', 'admin@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'admin', '0', 9999, 'valid'),
(2, 'Maroud', 'Kevin', 'Lareyku', 'upload/user/defaut.png', 'photographe@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567890123', 300, 'valid'),
(3, 'Duval', 'Jordan', 'Belorik', 'upload/user/defaut.png', 'client@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'client', '0', 3000, 'valid'),
(17, 'Dupres', 'Simon', 'Zekles', 'upload/user/Zekles.jpg', 'zekles@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'photographe', '01234567890124', 0, 'attValid'),
(16, 'Filon', 'Jean', 'Jouloulou', 'upload/user/defaut.png', 'jean@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'client', '', 0, 'banni');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
