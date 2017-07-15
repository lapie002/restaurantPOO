-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Sam 15 Juillet 2017 à 13:14
-- Version du serveur :  5.7.18-0ubuntu0.16.04.1
-- Version de PHP :  7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tp_resto`
--

-- --------------------------------------------------------

--
-- Structure de la table `Admins`
--

CREATE TABLE `Admins` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `PRENOM` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Admins`
--

INSERT INTO `Admins` (`ID`, `NOM`, `PRENOM`, `EMAIL`, `PASSWORD`) VALUES
(1, 'lapierre', 'bruno', 'lapierre.bruno@gmail.com', '63a9f0ea7bb98050796b649e85481845');

-- --------------------------------------------------------

--
-- Structure de la table `Composer`
--

CREATE TABLE `Composer` (
  `IDPLAT` int(11) NOT NULL,
  `IDMENU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Composer`
--

INSERT INTO `Composer` (`IDPLAT`, `IDMENU`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(4, 3),
(4, 4),
(4, 6),
(5, 4),
(6, 5),
(7, 6),
(8, 3),
(8, 6),
(9, 1),
(9, 2),
(9, 4),
(9, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Menus`
--

CREATE TABLE `Menus` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `PRIX` decimal(10,2) NOT NULL,
  `IMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Menus`
--

INSERT INTO `Menus` (`ID`, `NOM`, `PRIX`, `IMAGE`) VALUES
(1, 'Menu Tacos', '6.99', 'tacos.png'),
(2, 'Menu Pizza', '4.99', 'pizza.png'),
(3, 'Menu Hotdog', '3.99', 'hotdog.png'),
(4, 'Menu Club Sandwich', '7.99', 'club.png'),
(5, 'Menu Chinese', '6.99', 'chinese.png'),
(6, 'Menu Burger', '7.99', 'burger.png');

-- --------------------------------------------------------

--
-- Structure de la table `Plats`
--

CREATE TABLE `Plats` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(255) NOT NULL,
  `PRIX` decimal(10,2) NOT NULL,
  `IMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Plats`
--

INSERT INTO `Plats` (`ID`, `NOM`, `PRIX`, `IMAGE`) VALUES
(1, 'Tacos', '2.99', 'tacosplat.png'),
(2, 'Pizza', '3.99', 'pizzaplat.png'),
(3, 'Hotdog', '1.99', 'hotdogplat.png'),
(4, 'Frites', '2.99', 'fritesplat.png'),
(5, 'Club Sandwich', '5.99', 'clubplat.png'),
(6, 'Ramen Noodles', '3.99', 'chineseplat.png'),
(7, 'Burger', '6.99', 'burgerplat.png'),
(8, 'Boisson Coca Cola', '1.99', 'boissonplat.png'),
(9, 'Boisson Gobelet', '4.99', 'bigboissonplat.png');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Composer`
--
ALTER TABLE `Composer`
  ADD PRIMARY KEY (`IDPLAT`,`IDMENU`),
  ADD KEY `I_FK_COMPOSER_PLATS` (`IDPLAT`),
  ADD KEY `I_FK_COMPOSER_MENUS` (`IDMENU`);

--
-- Index pour la table `Menus`
--
ALTER TABLE `Menus`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Plats`
--
ALTER TABLE `Plats`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Menus`
--
ALTER TABLE `Menus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `Plats`
--
ALTER TABLE `Plats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Composer`
--
ALTER TABLE `Composer`
  ADD CONSTRAINT `FK_COMPOSER_MENUS` FOREIGN KEY (`IDMENU`) REFERENCES `Menus` (`ID`),
  ADD CONSTRAINT `FK_COMPOSER_PLATS` FOREIGN KEY (`IDPLAT`) REFERENCES `Plats` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
