-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mar 02 Mai 2017 à 15:58
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `pizzeria`
--
CREATE DATABASE IF NOT EXISTS `pizzeria` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pizzeria`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `ville`, `age`) VALUES
(1, 'ARMANI', 'Sophie', 'Nantes', 25),
(2, 'BERURIER', 'Laurent', 'Saint-Herblain', 30),
(3, 'DENIS', 'Sylvain', 'Vannes', 23),
(4, 'FERNIOT', 'Michelle', 'Lorient', 45),
(5, 'LOPERT', 'Nikos', 'Paris', 42),
(6, 'MILLOT', 'Perrine', 'Brest', 29),
(8, 'RESTRI', 'Mélanie', 'Strasbourg', 36),
(11, 'AMISSE', 'François', 'Prinquiau', 43),
(12, 'MERBEAU', 'Nicolas', 'Toulouse', 23),
(13, 'CHEVALIER', 'Lionel', 'Paris', 34),
(14, 'TOTO', 'Titi', 'Nantes', 50);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_commande` int(10) NOT NULL,
  `date_commande` date NOT NULL,
  `livreur_id` int(10) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`id`, `numero_commande`, `date_commande`, `livreur_id`, `client_id`) VALUES
(1, 1, '2016-05-08', 1, 1),
(2, 2, '2016-05-09', 1, 2),
(3, 3, '2016-05-10', 1, 3),
(4, 4, '2016-05-11', 2, 1),
(5, 5, '2016-05-12', 2, 4),
(6, 4, '2016-05-13', 2, 5),
(7, 6, '2016-05-14', 1, 1),
(8, 7, '2016-05-10', 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `commande_pizza`
--

CREATE TABLE IF NOT EXISTS `commande_pizza` (
  `commande_id` int(10) NOT NULL,
  `pizza_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commande_pizza`
--

INSERT INTO `commande_pizza` (`commande_id`, `pizza_id`) VALUES
(1, 1),
(1, 1),
(1, 4),
(2, 3),
(2, 1),
(2, 6),
(3, 2),
(3, 6);

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

CREATE TABLE IF NOT EXISTS `livreur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `livreur`
--

INSERT INTO `livreur` (`id`, `nom`, `prenom`) VALUES
(1, 'ARMAND', 'Lionel'),
(2, 'JOURNEE', 'Marguerite'),
(3, 'SPIDE', 'Arthur');

-- --------------------------------------------------------

--
-- Structure de la table `pizza`
--

CREATE TABLE IF NOT EXISTS `pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `reference` varchar(10) NOT NULL,
  `prix` int(3) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pizza`
--

INSERT INTO `pizza` (`id`, `libelle`, `reference`, `prix`, `url_image`) VALUES
(1, 'Reine', 'PREI', 10, 'reine.jpg'),
(2, 'Regina', 'PREG', 9, 'regina.jpg'),
(3, 'Napolitaine', 'PNAP', 10, 'napolitaine.jpg'),
(4, '4 fromages', 'P4FR', 10, '4fromages.jpg'),
(5, 'Chorizo', 'PCHO', 10, 'chorizo.jpg'),
(6, '4 saisons', 'P4SA', 9, '4saisons.jpg'),
(8, 'Bolognese', 'PBOL', 12, 'bolognese.jpg');