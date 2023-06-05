-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 05 juin 2023 à 08:37
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetmvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `double_id` (`product_id`,`user_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id`, `product_id`, `user_id`) VALUES
(41, 1, 1),
(2, 2, 4),
(25, 5, 1),
(3, 5, 2),
(52, 7, 1),
(26, 9, 1),
(28, 12, 1),
(53, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colonne` varchar(50) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(50) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_d` (`produit_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`id`, `colonne`, `date`, `content`, `produit_id`, `user_id`) VALUES
(83, 'prenom', '2023-05-15 14:26:42', '\"Cmoliere\"', NULL, 3),
(84, 'prix_achat', '2023-05-15 14:26:47', '\"1\"', 9, NULL),
(85, 'prix_achat', '2023-05-15 14:27:28', '\"0\"', 9, NULL),
(86, 'prix_achat', '2023-05-15 14:27:32', '\"2\"', 9, NULL),
(87, 'prix_achat', '2023-05-15 14:31:45', '\"1\"', 9, NULL),
(88, 'admin', '2023-05-15 14:49:01', '\"yes\"', NULL, 1),
(89, 'admin', '2023-05-15 14:49:04', '\"0\"', NULL, 1),
(90, 'admin', '2023-05-15 14:49:17', '\"yes\"', NULL, 2),
(91, 'admin', '2023-05-15 14:49:20', '\"0\"', NULL, 3),
(92, 'admin', '2023-05-15 14:49:25', '\"yes\"', NULL, 5),
(93, 'admin', '2023-05-15 14:49:30', '\"no\"', NULL, 6),
(94, 'admin', '2023-05-15 14:49:37', '\"no\"', NULL, 6),
(95, 'admin', '2023-05-15 14:49:42', '\"no\"', NULL, 6),
(96, 'admin', '2023-05-15 14:49:44', '\"yes\"', NULL, 2),
(97, 'admin', '2023-05-15 14:49:48', '\"0\"', NULL, 2),
(98, 'admin', '2023-05-15 14:49:51', '\"0\"', NULL, 5),
(99, 'admin', '2023-05-15 14:49:54', '\"1\"', NULL, 4),
(100, 'admin', '2023-05-15 14:49:57', '\"1\"', NULL, 4),
(101, 'admin', '2023-05-15 14:50:00', '\"1\"', NULL, 4),
(102, 'budget', '2023-05-15 14:50:07', '\"9999\"', NULL, 1),
(103, 'budget', '2023-05-15 14:50:12', '\"-8\"', NULL, 1),
(104, 'budget', '2023-05-15 14:50:13', '\"22\"', NULL, 1),
(105, 'budget', '2023-05-15 14:50:44', '\"22\"', NULL, 1),
(106, 'budget', '2023-05-15 14:50:50', '\"22\"', NULL, 1),
(107, 'budget', '2023-05-15 14:50:53', '\"86\"', NULL, 1),
(108, 'prix_salarie', '2023-05-15 14:53:26', '\"2\"', 14, NULL),
(109, 'prix_achat', '2023-05-15 14:53:31', '\"0.02\"', 14, NULL),
(110, 'prix_achat', '2023-05-15 14:53:35', '\"0.2\"', 14, NULL),
(111, 'prix_achat', '2023-05-15 14:53:39', '\"0.9\"', 14, NULL),
(112, 'prix_achat', '2023-05-15 14:53:40', '\"1\"', 14, NULL),
(113, 'prix_achat', '2023-05-15 14:53:43', '\"1.5\"', 14, NULL),
(114, 'prix_salarie', '2023-05-15 14:53:53', '\"vhij\"', 14, NULL),
(115, 'nom', '2023-05-15 14:54:47', '\"Bob\"', NULL, 4),
(116, 'nom', '2023-05-15 14:54:56', '\"Robert\"', NULL, 4),
(117, 'prix_achat', '2023-05-15 14:56:25', '\"-1\"', 15, NULL),
(118, 'prix_salarie', '2023-05-15 14:56:36', '\"2\"', 15, NULL),
(119, 'prix_achat', '2023-05-15 14:56:40', '\"9\"', 15, NULL),
(120, 'admin', '2023-05-15 14:56:56', '\"0\"', NULL, 1),
(121, 'admin', '2023-05-15 14:56:57', '\"0\"', NULL, 2),
(122, 'prix_salarie', '2023-05-15 14:57:05', '\"5\"', 3, NULL),
(123, 'prix_achat', '2023-05-15 14:57:08', '\"5\"', 3, NULL),
(124, 'budget', '2023-05-15 14:58:04', '\"20\"', NULL, 1),
(125, 'budget', '2023-05-15 14:59:10', '\"30\"', NULL, 2),
(126, 'admin', '2023-05-15 14:59:52', '\"1\"', NULL, 4),
(127, 'admin', '2023-05-17 09:31:54', '\"1\"', NULL, 2),
(128, 'admin', '2023-05-17 09:32:04', '\"1\"', NULL, 2),
(129, 'budget', '2023-05-17 09:32:10', '\"40\"', NULL, 2),
(130, 'prenom', '2023-05-17 09:32:17', '\"Nicoww\"', NULL, 2),
(131, 'admin', '2023-05-17 09:32:25', '\"1\"', NULL, 3),
(132, 'admin', '2023-05-17 09:33:57', '\"1\"', NULL, 4),
(133, 'admin', '2023-05-17 09:33:59', '\"0\"', NULL, 1),
(134, 'admin', '2023-05-17 09:34:03', '\"1\"', NULL, 1),
(135, 'admin', '2023-05-17 09:34:06', '\"1\"', NULL, 1),
(136, 'admin', '2023-05-17 09:34:43', '\"1\"', NULL, 3),
(137, 'admin', '2023-05-17 09:34:54', '\"1\"', NULL, 3),
(138, 'admin', '2023-05-17 09:35:15', '\"0\"', NULL, 2),
(139, 'admin', '2023-05-17 09:35:21', '\"1\"', NULL, 2),
(140, 'admin', '2023-05-17 09:36:00', '\"1\"', NULL, 3),
(141, 'admin', '2023-05-17 09:36:03', '\"1\"', NULL, 3),
(142, 'admin', '2023-05-17 09:36:03', '\"1\"', NULL, 3),
(143, 'admin', '2023-05-17 09:36:04', '\"1\"', NULL, 3),
(144, 'admin', '2023-05-17 09:37:16', '\"1\"', NULL, 3),
(145, 'admin', '2023-05-17 09:38:26', '\"1\"', NULL, 3),
(146, 'admin', '2023-05-17 09:39:09', '\"1\"', NULL, 2),
(147, 'admin', '2023-05-17 09:39:16', '\"0\"', NULL, 2),
(148, 'admin', '2023-05-17 09:39:50', '\"1\"', NULL, 2),
(149, 'admin', '2023-05-17 09:41:23', '\"1\"', NULL, 3),
(150, 'admin', '2023-05-17 09:41:36', '\"0\"', NULL, 3),
(151, 'admin', '2023-05-17 09:41:59', '\"1\"', NULL, 3),
(152, 'admin', '2023-05-17 09:42:01', '\"0\"', NULL, 3),
(153, 'admin', '2023-05-17 09:42:50', '\"1\"', NULL, 3),
(154, 'admin', '2023-05-17 09:43:55', '\"0\"', NULL, 2),
(155, 'admin', '2023-05-17 09:43:59', '\"1\"', NULL, 3),
(156, 'admin', '2023-05-17 09:44:02', '\"1\"', NULL, 2),
(157, 'admin', '2023-05-17 09:44:13', '\"1\"', NULL, 1),
(158, 'admin', '2023-05-17 09:44:16', '\"0\"', NULL, 3),
(159, 'admin', '2023-05-17 09:44:45', '\"0\"', NULL, 1),
(160, 'admin', '2023-05-17 09:44:48', '\"1\"', NULL, 1),
(161, 'admin', '2023-05-17 09:45:11', '\"0\"', NULL, 1),
(162, 'admin', '2023-05-17 09:45:13', '\"1\"', NULL, 3),
(163, 'admin', '2023-05-17 09:47:29', '\"1\"', NULL, 1),
(164, 'admin', '2023-05-17 09:47:34', '\"0\"', NULL, 3),
(165, 'admin', '2023-05-17 09:48:11', '\"1\"', NULL, 3),
(166, 'admin', '2023-05-17 09:48:16', '\"0\"', NULL, 3),
(167, 'admin', '2023-05-17 09:48:25', '\"1\"', NULL, 3),
(168, 'admin', '2023-05-17 09:48:28', '\"0\"', NULL, 2),
(169, 'budget', '2023-05-17 09:48:59', '\".5\"', NULL, 1),
(170, 'budget', '2023-05-17 09:49:02', '\"0\"', NULL, 1),
(171, 'budget', '2023-05-17 09:49:06', '\"999\"', NULL, 1),
(172, 'budget', '2023-05-17 09:49:42', '\"50.2\"', NULL, 1),
(173, 'budget', '2023-05-17 09:49:47', '\"50.5\"', NULL, 1),
(174, 'budget', '2023-05-17 09:50:21', '\"05.2\"', NULL, 3),
(175, 'admin', '2023-05-17 13:05:32', '\"1\"', NULL, 2),
(176, 'budget', '2023-05-17 13:05:39', '\"9999\"', NULL, 1),
(177, 'budget', '2023-05-17 13:25:22', '\"10.55\"', NULL, 1),
(178, 'budget', '2023-05-17 13:25:47', '\"2\"', NULL, 1),
(179, 'budget', '2023-05-17 13:25:52', '\"20\"', NULL, 1),
(180, 'budget', '2023-05-17 13:26:28', '\"20.50\"', NULL, 1),
(181, 'budget', '2023-05-17 13:26:35', '\"10.1\"', NULL, 1),
(182, 'budget', '2023-05-17 13:26:41', '\"22.22\"', NULL, 1),
(183, 'budget', '2023-05-17 13:26:51', '\"55.55\"', NULL, 1),
(184, 'prix_achat', '2023-05-17 13:36:29', '\"00.25\"', 14, NULL),
(185, 'prix_achat', '2023-05-17 13:36:39', '\"01.25\"', 14, NULL),
(186, 'prix_achat', '2023-05-17 13:37:23', '\"00.25\"', 11, NULL),
(187, 'prenom', '2023-05-17 13:38:59', '\"12\"', NULL, 4),
(188, 'budget', '2023-05-17 13:58:02', '\"90\"', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  `prix_salarie` float NOT NULL,
  `prix_achat` float NOT NULL,
  `stock` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `nom`, `prix_salarie`, `prix_achat`, `stock`, `type`, `image`) VALUES
(1, 'kainder bueno', 8, 0.5, 0, 'snack', 'noPic'),
(2, 'marsMallow', 3, 1, 38, 'snack', 'marchmallow'),
(3, 'croixsans', 5, 5, 90, 'snack', 'croissant'),
(4, 'parpaing du chocolat', 2, 1, 96, 'snack', 'painCho'),
(5, 'sneakers', 1, 1, 24, 'snack', 'sniker'),
(7, 'coffee', 0.5, 2, 3, 'boisson', 'coffee'),
(8, 'baboit', 1, 1, 38, 'boisson', 'baboit'),
(9, 'salade', 15, 1, 91, 'grass', 'salade'),
(10, 'nthChild2', 20, 2, 142, 'grass', 'noPic'),
(11, 'nthChild15', 121, 0.25, 21, 'grass', 'noPic'),
(12, 'bounneti', 2, 0.5, 85, 'snack', 'bounty'),
(13, 'vaco', 2, 1, 49, 'boisson', 'cola'),
(14, 'choukolatine', 2, 1, 48, 'snack', 'noPic'),
(15, 'poim', 2, 9, 50, 'snack', 'noPic'),
(16, 'burger', 3, 1, 20, 'snack', 'burger');

-- --------------------------------------------------------

--
-- Structure de la table `restock`
--

DROP TABLE IF EXISTS `restock`;
CREATE TABLE IF NOT EXISTS `restock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cout` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `restock`
--

INSERT INTO `restock` (`id`, `produit_id`, `user_id`, `quantite`, `date`, `cout`) VALUES
(2, 1, 1, 40, '2023-05-10 14:09:31', 17),
(3, 1, 1, 10, '2023-05-10 14:11:20', 4.75),
(4, 2, 1, 20, '2023-05-11 06:56:23', 18),
(5, 2, 1, 10, '2023-05-11 06:57:02', 9.5),
(6, 1, 1, 20, '2023-05-11 06:57:40', 9),
(7, 9, 1, 20, '2023-05-11 06:58:22', 18),
(8, 1, 1, 10, '2023-05-11 07:08:30', 4.75),
(9, 1, 1, 10, '2023-05-11 07:10:55', 4.75),
(10, 1, 1, 5, '2023-05-11 07:11:27', 2.5),
(11, 1, 1, 10, '2023-05-11 07:11:49', 4.75),
(12, 1, 1, 10, '2023-05-11 07:12:03', 4.75),
(13, 1, 1, 10, '2023-05-11 07:12:17', 4.75),
(14, 12, 1, 100, '2023-05-11 08:29:38', 35),
(15, 10, 1, 100, '2023-05-11 13:28:56', 140),
(16, 4, 1, 100, '2023-05-15 14:51:29', 70),
(17, 10, 1, 10, '2023-05-15 14:51:39', 19),
(18, 9, 1, 100, '2023-05-15 14:54:01', 70);

-- --------------------------------------------------------

--
-- Structure de la table `sold`
--

DROP TABLE IF EXISTS `sold`;
CREATE TABLE IF NOT EXISTS `sold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateAchat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_achat_produits` (`produit_id`),
  KEY `FK_achat_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sold`
--

INSERT INTO `sold` (`id`, `produit_id`, `user_id`, `dateAchat`) VALUES
(1, 2, 1, '2023-05-11 13:02:44'),
(2, 2, 1, '2023-05-11 13:23:22'),
(3, 2, 1, '2023-05-11 13:23:20'),
(4, 3, 1, '2023-05-11 13:23:28'),
(5, 3, 1, '2023-05-11 13:23:26'),
(6, 1, 2, '2023-05-11 13:23:33'),
(7, 1, 2, '2023-05-11 13:23:31'),
(8, 2, 3, '2023-05-11 13:23:40'),
(9, 3, 3, '2023-05-11 13:23:38'),
(10, 6, 1, '2023-05-12 09:25:01'),
(11, 7, 2, '2023-05-12 09:25:01'),
(12, 10, 5, '2023-05-12 11:57:05'),
(13, 8, 4, '2023-05-12 11:57:05'),
(14, 1, 5, '2023-05-15 08:13:51'),
(15, 7, 6, '2023-05-15 08:14:19'),
(16, 1, 1, '2023-05-30 11:47:16'),
(17, 1, 1, '2023-05-30 12:01:42'),
(18, 1, 1, '2023-05-30 12:02:56'),
(19, 1, 1, '2023-05-30 12:02:56'),
(20, 1, 1, '2023-05-30 12:02:58'),
(21, 1, 1, '2023-05-30 12:02:58'),
(22, 1, 1, '2023-05-30 12:02:58'),
(23, 1, 1, '2023-05-30 12:02:58'),
(24, 1, 1, '2023-05-30 12:02:58'),
(25, 1, 1, '2023-05-30 13:50:21'),
(26, 1, 1, '2023-05-30 13:52:39'),
(27, 1, 1, '2023-05-30 13:55:24'),
(28, 1, 1, '2023-05-30 13:55:26'),
(29, 1, 1, '2023-05-30 13:55:27'),
(30, 1, 1, '2023-05-30 13:55:28'),
(31, 1, 1, '2023-05-30 13:56:04'),
(32, 1, 1, '2023-05-30 13:56:07'),
(33, 1, 1, '2023-05-30 13:56:08'),
(34, 1, 1, '2023-05-30 13:56:09'),
(35, 1, 1, '2023-05-30 14:03:20'),
(36, 1, 1, '2023-05-30 14:03:21'),
(37, 2, 1, '2023-05-30 14:03:56'),
(38, 1, 1, '2023-05-30 14:04:05'),
(39, 1, 1, '2023-05-30 14:04:05'),
(40, 1, 1, '2023-05-30 14:04:08'),
(41, 1, 1, '2023-05-30 14:04:09'),
(42, 4, 1, '2023-05-30 14:04:19'),
(43, 4, 1, '2023-05-30 14:04:20'),
(44, 4, 1, '2023-05-30 14:04:20'),
(45, 4, 1, '2023-05-30 14:04:20'),
(46, 2, 1, '2023-05-31 08:29:01'),
(47, 14, 1, '2023-05-31 08:49:32'),
(48, 14, 1, '2023-05-31 08:49:33'),
(49, 13, 1, '2023-05-31 08:49:33'),
(50, 13, 1, '2023-05-31 08:49:33'),
(51, 13, 1, '2023-05-31 08:49:34'),
(52, 12, 1, '2023-05-31 08:49:35'),
(53, 11, 1, '2023-05-31 08:49:35'),
(54, 11, 1, '2023-05-31 08:49:35'),
(55, 12, 1, '2023-05-31 08:49:40'),
(56, 12, 1, '2023-05-31 08:49:40'),
(57, 12, 1, '2023-05-31 08:49:40'),
(58, 12, 1, '2023-05-31 08:49:40'),
(59, 12, 1, '2023-05-31 08:49:40'),
(60, 10, 1, '2023-05-31 08:49:41'),
(61, 10, 1, '2023-05-31 08:49:41'),
(62, 10, 1, '2023-05-31 08:49:41'),
(63, 10, 1, '2023-05-31 08:49:41'),
(64, 10, 1, '2023-05-31 08:49:41'),
(65, 12, 1, '2023-05-31 08:50:17'),
(66, 1, 1, '2023-05-31 11:52:00'),
(67, 1, 1, '2023-05-31 11:52:01'),
(68, 1, 1, '2023-05-31 11:53:33'),
(69, 1, 1, '2023-05-31 11:55:00'),
(70, 1, 1, '2023-05-31 11:55:00'),
(71, 1, 1, '2023-05-31 11:55:01'),
(72, 1, 1, '2023-05-31 11:55:01'),
(73, 1, 1, '2023-05-31 11:55:01'),
(74, 1, 1, '2023-05-31 11:55:01'),
(75, 1, 1, '2023-05-31 11:55:01'),
(76, 1, 1, '2023-05-31 11:55:01'),
(77, 1, 1, '2023-05-31 11:55:01'),
(78, 1, 1, '2023-05-31 11:55:02'),
(79, 1, 1, '2023-05-31 11:55:02'),
(80, 1, 1, '2023-05-31 11:55:02'),
(81, 1, 1, '2023-05-31 11:55:14'),
(82, 1, 1, '2023-05-31 11:55:14'),
(83, 1, 1, '2023-05-31 11:55:15'),
(84, 1, 1, '2023-05-31 11:55:15'),
(85, 2, 1, '2023-05-31 11:59:18'),
(86, 13, 1, '2023-05-31 12:00:40'),
(87, 13, 1, '2023-05-31 12:00:40'),
(88, 13, 1, '2023-05-31 12:00:41'),
(89, 13, 1, '2023-05-31 12:00:41'),
(90, 13, 1, '2023-05-31 12:00:41'),
(91, 13, 1, '2023-05-31 12:00:41'),
(92, 13, 1, '2023-05-31 12:00:41'),
(93, 13, 1, '2023-05-31 12:00:42'),
(94, 13, 1, '2023-05-31 12:00:42'),
(95, 13, 1, '2023-05-31 12:00:42'),
(96, 13, 1, '2023-05-31 12:00:42'),
(97, 13, 1, '2023-05-31 12:00:42'),
(98, 13, 1, '2023-05-31 12:00:42'),
(99, 13, 1, '2023-05-31 12:00:43'),
(100, 13, 1, '2023-05-31 12:00:43'),
(101, 13, 1, '2023-05-31 12:00:45'),
(102, 14, 1, '2023-05-31 12:00:55'),
(103, 14, 1, '2023-05-31 12:00:55'),
(104, 14, 1, '2023-05-31 12:00:55'),
(105, 14, 1, '2023-05-31 12:00:55'),
(106, 14, 1, '2023-05-31 12:00:56'),
(107, 14, 1, '2023-05-31 12:00:56'),
(108, 14, 1, '2023-05-31 12:00:56'),
(109, 14, 1, '2023-05-31 12:00:56'),
(110, 14, 1, '2023-05-31 12:00:58'),
(111, 7, 1, '2023-05-31 12:01:34'),
(112, 7, 1, '2023-05-31 12:01:36'),
(113, 1, 1, '2023-06-01 07:47:43'),
(114, 1, 1, '2023-06-01 07:47:45'),
(115, 1, 1, '2023-06-01 07:47:47'),
(116, 9, 1, '2023-06-01 09:13:36'),
(117, 10, 1, '2023-06-01 09:13:40'),
(118, 13, 1, '2023-06-01 09:13:48'),
(119, 14, 1, '2023-06-01 12:51:19'),
(120, 14, 1, '2023-06-01 12:51:21'),
(121, 12, 1, '2023-06-01 12:53:03'),
(122, 12, 1, '2023-06-01 12:53:03'),
(123, 12, 1, '2023-06-01 12:53:03'),
(124, 12, 1, '2023-06-01 12:53:03'),
(125, 12, 1, '2023-06-01 12:53:04'),
(126, 2, 1, '2023-06-01 12:53:05'),
(127, 2, 1, '2023-06-01 12:53:05'),
(128, 2, 1, '2023-06-01 12:53:05'),
(129, 2, 1, '2023-06-01 12:53:05'),
(130, 2, 1, '2023-06-01 12:53:06'),
(131, 2, 1, '2023-06-01 12:53:06'),
(132, 2, 1, '2023-06-01 12:53:06'),
(133, 2, 1, '2023-06-01 12:53:06'),
(134, 2, 1, '2023-06-01 12:53:06'),
(135, 2, 1, '2023-06-01 12:53:06');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `test`
--

INSERT INTO `test` (`id`, `prod_id`, `user_id`, `message`) VALUES
(1, 1, NULL, 'Je susi perdu'),
(2, NULL, 1, 'salut');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  `prenom` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `budget` float DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `pass`, `admin`, `budget`) VALUES
(1, 'ArauKo', 'Nicos', 'ed@mail.com', '$2y$10$E.nZWetplAvNXDloqj2prO011sfrtNCUJXPkxWjyLnMd9kms94tyq', 1, 9),
(2, 'Nicow', 'Nicoww', 'nicow@gaming.fr', '$2y$10$E.nZWetplAvNXDloqj2prO011sfrtNCUJXPkxWjyLnMd9kms94tyq', 1, 40),
(3, 'filsperdu', 'Cmoliere', 'perdu@mail.fr', '$2y$10$VPU.2JJIFicYDqvhN2AJjekEPWaI0t1V7qcgKVlFD.ome5Fdjrbve', 1, 50),
(4, 'Robert', 'Gzu', 'Cestpartilesamis@mails.com', '$2y$10$2KOxp.YWxF6thBDkMmeg4.END0snkMqjjwTeIU7bRjhSKZYaunJRu', 0, 50),
(5, 'azerty', 'azertyu', 'azerty@qsdfgh.com', '$2y$10$gtKEg8R8602gh0J7BmTBBuFef4WAm1JZIn1UY/VygJhBbTrOWQPnu', 0, 50),
(6, 'Michel', 'Mickael', 'michel@mail.com', '$2y$10$QRr0KTUJUJdlN4asnAslsOroTiyIVn5HvYKlXU7BZ3fkkehxfdDf2', 0, 50);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `restock`
--
ALTER TABLE `restock`
  ADD CONSTRAINT `restock_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `restock_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
