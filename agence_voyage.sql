-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 06 juin 2025 à 18:43
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
-- Base de données : `agence_voyage`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `telephone`) VALUES
(1, 'Meli', 'Tiwa', 'donfackcaline@gmail.com', '693663748'),
(2, 'Donfack', 'Caline', 'mbogningcaline@gmail.com', '650195549'),
(3, 'Dombou', 'Dirane', 'capris488@gmail.com', '650195540');

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  `statut` enum('en attente','validée','annulée') DEFAULT NULL,
  `date_depart` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `destinations`
--

INSERT INTO `destinations` (`id`, `pays`, `ville`, `prix`, `date_retour`, `statut`, `date_depart`) VALUES
(1, 'Cameroun', 'Dschang', '4500.00', '2025-06-27', 'en attente', '2025-06-06');

-- --------------------------------------------------------

--
-- Structure de la table `logs_emails`
--

CREATE TABLE `logs_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  `utilisateur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `destination_id`, `date_reservation`, `utilisateur_id`) VALUES
(12, 2, 1, '2025-06-06', 1),
(18, 3, 1, '2025-06-06', 3),
(19, 1, 1, '2025-06-06', 3),
(20, 2, 1, '2025-06-21', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('admin','caissier') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'Tiwa Meli', 'donfackcaline@gmail.com', '$2y$10$Y3RTs9IEdLRBzPkuQ/FGiecgJLA8a.usAFnZUeJDC4AW3UwEH4MAy', 'admin'),
(3, 'prisca', 'dreydonfack@gmail.com', '$2y$10$uYp3zENrkKyRmVJ6HMr1/eLXBA1iD3fMCTrk.sU9yZT4bz86HFh1C', 'caissier');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs_emails`
--
ALTER TABLE `logs_emails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `logs_emails`
--
ALTER TABLE `logs_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
