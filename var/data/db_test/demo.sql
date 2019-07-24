-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 22 juil. 2019 à 15:14
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

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
  `date_of_creation` datetime NOT NULL,
  `last_update` datetime NOT NULL,
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
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_failed_login` datetime DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649D17F50A6` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `uuid`, `username`, `password`, `email`, `last_login`, `last_failed_login`, `register_date`, `active`, `roles`) VALUES
(1, '00010000-0000-5000-a000-000000000000', 'userAdmin', '$2y$13$uMExCbu6O14WMsy9J9AkEOWObuBwIF7pMbkjRJD60HBvvyuejJlNe', 'userAdmin@gmail.com', NULL, NULL, '2019-07-22 17:14:22', 1, '[\"ROLE_ADMIN\"]'),
(2, '00020000-0000-5000-a000-000000000000', 'userInactive', '$2y$13$xZpJqt1JnqRd1CNZ.kbHd.bsBX/qYAnZIkqIKQe9BYOxr731p/SWK', 'userInactive@gmail.com', NULL, NULL, '2019-07-22 17:14:23', 0, '[]'),
(3, '00030000-0000-5000-a000-000000000000', 'userForbidden', '$2y$13$qL378jBjiBzM8ttnxwg/c.R.9E5Fi82nv/phehq623XDNQgNiyFHC', 'userForbidden@gmail.com', NULL, NULL, '2019-07-22 17:14:23', 1, '[]'),
(4, '00040000-0000-5000-a000-000000000000', 'userActive', '$2y$13$39G8ruJ148DyarTYvue12urn8phBD8cjHtTI.cEOYJztE8aXZBR0W', 'userActive@gmail.com', NULL, NULL, '2019-07-22 17:14:24', 1, '[]');

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
