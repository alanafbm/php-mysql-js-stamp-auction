-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 16 sep. 2022 à 18:15
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stampee`
--

-- --------------------------------------------------------

--
-- Structure de la table `condition`
--

CREATE TABLE `conservation` (
  `con_id` int(11) NOT NULL,
  `con_etat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `condition`
--

INSERT INTO `conservation` (`con_id`, `con_etat`) VALUES
(1, 'avec gomme'),
(2, 'sans gomme'),
(3, 'bonne'),
(4, 'endommagée');

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

CREATE TABLE `enchere` (
  `enc_id` int(11) NOT NULL,
  `enc_nom` varchar(45) NOT NULL,
  `enc_date_debut` date NOT NULL,
  `enc_date_fin` date NOT NULL,
  `enc_pieces` tinyint(4) DEFAULT NULL,
  `utilisateur_uti_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `enchere`
--

INSERT INTO `enchere` (`enc_id`, `enc_nom`, `enc_date_debut`, `enc_date_fin`, `enc_pieces`, `utilisateur_uti_id`) VALUES
(1, 'Enchère1', '2022-09-08', '2022-10-28', 1,  1),
(2, 'Enchère2',  '2022-08-08', '2022-09-28', 2,  2),
(3, 'Enchère3', '2022-07-08', '2022-08-10',  3,  1),
(4, 'Enchère4',  '2022-06-08', '2022-07-05',  4,  3),
(5, 'Enchère5',  '2022-09-10', '2022-10-13',  5,  1),
(6, 'Enchère6',  '2022-10-12', '2022-11-22',  4,  2),
(7, 'Enchère7',  '2022-07-10', '2022-09-28',  3,  3),
(8, 'Enchère8',  '2022-09-08', '2022-09-27',  2,  1);


-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `img_id` int(11) NOT NULL,
  `img_titre` varchar(45) DEFAULT NULL,
  `img_path` varchar(45) NOT NULL,
  `img_timbre_tim_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `image`
--
INSERT INTO `image` (`img_id`, `img_titre`, `img_path`, `img_timbre_tim_id`) VALUES
(1, 'stamp1', 'ressources/images/timbres/stamp1.jpg', 1),
(2, 'stamp2', 'ressources/images/timbres/stamp2.jpg', 2),
(3, 'stamp3', 'ressources/images/timbres/stamp3.jpg', 3),
(4, 'stamp4', 'ressources/images/timbres/stamp4.jpg', 4),
(5, 'stamp5', 'ressources/images/timbres/stamp5.jpg', 5),
(6, 'stamp6', 'ressources/images/timbres/stamp6.jpg', 6),
(7, 'stamp7', 'ressources/images/timbres/stamp7.jpg', 7),
(8, 'stamp8', 'ressources/images/timbres/stamp8.jpg', 8),
(9, 'stamp5', 'ressources/images/timbres/stamp5.jpg', 1),
(10, 'stamp6', 'ressources/images/timbres/stamp6.jpg', 1),
(11, 'stamp7', 'ressources/images/timbres/stamp7.jpg', 3),
(12, 'stamp8', 'ressources/images/timbres/stamp8.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `mise`
--

CREATE TABLE `mise` (
  `mis_id` int(11) NOT NULL,
  `mis_prix` double DEFAULT NULL,
  `utilisateur_uti_id` int(11) NOT NULL,
  `mis_timbre_tim_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `fav_id` int(11) NOT NULL,
  `fav_utilisateur_uti_id` int(11) NOT NULL,
  `fav_timbre_tim_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `timbre`
--

CREATE TABLE `timbre` (
  `tim_id` int(11) NOT NULL,
  `tim_nom` varchar(45) DEFAULT NULL,
  `tim_date_creation` varchar(45) DEFAULT NULL,
  `tim_couleur` varchar(45) DEFAULT NULL,
  `tim_pays_origine` varchar(45) DEFAULT NULL,
  `tim_prix` double DEFAULT NULL,
  `tim_dimensions` varchar(45) DEFAULT NULL,
  `tim_certifie` varchar(45) DEFAULT NULL,
  `enchere_enc_id` int(11) NOT NULL,
  `conservation_con_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `timbre`
--

INSERT INTO `timbre` (`tim_id`, `tim_nom`, `tim_date_creation`, `tim_couleur`, `tim_pays_origine`, `tim_prix`, `tim_dimensions`, `tim_certifie`, `enchere_enc_id`, `conservation_con_id`) VALUES
(1, 'timbre1', '2022-09-10', 'gris', 'Brésil', 295,  '58cm x 55cm', 'oui', 1,  3),
(2, 'timbre2', '2022-08-11', 'bleu', 'Canada', 395,  '58cm x 55cm', 'oui', 2,  2),
(3, 'timbre3', '2022-07-12', 'rouge', 'EUA', 495,'58cm x 55cm', 'oui', 3,  3),
(4, 'timbre4', '2022-06-13', 'gris', 'Argentine', 595,  '58cm x 55cm', 'oui', 4,  3),
(5, 'timbre5', '2022-10-14', 'bleu', 'Brésil', 695,  '58cm x 55cm', 'oui', 5,  1),
(6, 'timbre6', '2022-11-15', 'rouge', 'Canada', 795,  '58cm x 55cm', 'oui', 6,  3),
(7, 'timbre7', '2022-12-16', 'gris', 'EUA', 895,  '58cm x 55cm', 'oui', 7,  3),
(8, 'timbre8', '2022-05-17', 'rouge', 'Canada', 595,  '58cm x 55cm', 'oui', 8,  1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `uti_id` int(11) NOT NULL,
  `uti_courriel` varchar(45) NOT NULL,
  `uti_mdp` varchar(45) NOT NULL,
  `uti_nom` varchar(45) NOT NULL,
  `uti_prenom` varchar(45) NOT NULL,
  `uti_privilege` tinyint(4) DEFAULT NULL,
  `uti_pays_residence` varchar(45) DEFAULT NULL,
  `uti_date_register` date DEFAULT NULL,
  `uti_confirmation` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`uti_id`, `uti_courriel`, `uti_mdp`, `uti_nom`, `uti_prenom`, `uti_privilege`, `uti_pays_residence`, `uti_date_register`, `uti_confirmation`) VALUES
(1, 'alana', '12345', 'Moraes', 'Alana', 1, 'Canada', '0000-00-00', 'true'),
(2, 'test@test.com', '12345', 'test', 'test', 2, 'Canada', '0000-00-00', 'true'),
(3, 'LordStampee@stampee.com', '12345', 'Stampee', 'Lord', 1, 'Canada', '0000-00-00', 'true');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `condition`
--
ALTER TABLE `conservation`
  ADD PRIMARY KEY (`con_id`);

--
-- Index pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD PRIMARY KEY (`enc_id`),
  ADD KEY `fk_enchere_utilisateur1` (`utilisateur_uti_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `fk_image_timbre1` (`img_timbre_tim_id`);


--
-- Index pour la table `mise`
--
ALTER TABLE `mise`
  ADD PRIMARY KEY (`mis_id`),
  ADD KEY `fk_mise_timbre1` (`mis_timbre_tim_id`),
  ADD KEY `fk_mise_utilisateur1` (`utilisateur_uti_id`);


--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`fav_id`),
  ADD KEY `fk_favoris_timbre1` (`fav_timbre_tim_id`),
  ADD KEY `fk_favoris_utilisateur1` (`fav_utilisateur_uti_id`);

--
-- Index pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD PRIMARY KEY (`tim_id`),
  ADD KEY `fk_timbre_enchere1` (`enchere_enc_id`),
  ADD KEY `fk_timbre_conservation1` (`conservation_con_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`uti_id`);

--
-- Contraintes pour les tables déchargées
--
ALTER TABLE `conservation`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `enchere`
  MODIFY `enc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `mise`
  MODIFY `mis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `favoris`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `timbre`
  MODIFY `tim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD CONSTRAINT `fk_enchere_utilisateur1` FOREIGN KEY (`utilisateur_uti_id`) REFERENCES `utilisateur` (`uti_id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_timbre1` FOREIGN KEY (`img_timbre_tim_id`) REFERENCES `timbre` (`tim_id`) ON DELETE CASCADE;


--
-- Contraintes pour la table `mise`
--
ALTER TABLE `mise`
  ADD CONSTRAINT `fk_mise_timbre1` FOREIGN KEY (`mis_timbre_tim_id`) REFERENCES `timbre` (`tim_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mise_utilisateur1` FOREIGN KEY (`utilisateur_uti_id`) REFERENCES `utilisateur` (`uti_id`) ;


--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `fk_favoris_timbre1` FOREIGN KEY (`fav_timbre_tim_id`) REFERENCES `timbre` (`tim_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favoris_utilisateur1` FOREIGN KEY (`fav_utilisateur_uti_id`) REFERENCES `utilisateur` (`uti_id`) ;

--
-- Contraintes pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD CONSTRAINT `fk_timbre_conservation1` FOREIGN KEY (`conservation_con_id`) REFERENCES `conservation` (`con_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_timbre_enchere1` FOREIGN KEY (`enchere_enc_id`) REFERENCES `enchere` (`enc_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
