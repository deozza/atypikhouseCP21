-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 20 juin 2019 à 12:12
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `atypikhouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `api_token`
--

DROP TABLE IF EXISTS `api_token`;
CREATE TABLE IF NOT EXISTS `api_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7BA2F5EBD17F50A6` (`uuid`),
  KEY `IDX_7BA2F5EBA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `api_token`
--

INSERT INTO `api_token` (`id`, `user_id`, `uuid`, `token`) VALUES
(1, 1, '00100000-0000-5000-a000-000000000000', 'token_userAdmin'),
(2, 2, '00200000-0000-5000-a000-000000000000', 'token_userInactive'),
(3, 3, '00300000-0000-5000-a000-000000000000', 'token_userForbidden'),
(4, 4, '00400000-0000-5000-a000-000000000000', 'token_userActive');

-- --------------------------------------------------------

--
-- Structure de la table `entity`
--

DROP TABLE IF EXISTS `entity`;
CREATE TABLE IF NOT EXISTS `entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `kind` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation_state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:object)',
  `date_of_creation` date NOT NULL,
  `last_update` date NOT NULL,
  `properties` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E284468D17F50A6` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_failed_login` datetime DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `last_login`, `last_failed_login`, `register_date`, `active`, `roles`) VALUES
(1, 'userAdmin', '$2y$13$7sio9Kx5bhMmGRaUmmxoh.NCwzzRLebuNFNAoWYNm82IEgkGyIuVS', 'userAdmin@gmail.com', NULL, NULL, '2019-06-20 12:11:29', 1, '[\"ROLE_ADMIN\"]'),
(2, 'userInactive', '$2y$13$SteH5OhEnzF.qWnQjbu6GeKCIG4HfKzx78YtwcZyPpAQ/WYgx9Y9a', 'userInactive@gmail.com', NULL, NULL, '2019-06-20 12:11:30', 0, '[]'),
(3, 'userForbidden', '$2y$13$PgLDPVASrcYNA8/CntldoOlT.xFIeoKs79gZz6kEBYH47Nzzlnk1G', 'userForbidden@gmail.com', NULL, NULL, '2019-06-20 12:11:30', 1, '[]'),
(4, 'userActive', '$2y$13$uNrS7XxjjiUUtrc.UyO/zuEVt53RswVua6U/FZX6oYJFuf3HhuJLS', 'userActive@gmail.com', NULL, NULL, '2019-06-20 12:11:31', 1, '[]');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `api_token`
--
ALTER TABLE `api_token`
  ADD CONSTRAINT `FK_7BA2F5EBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
