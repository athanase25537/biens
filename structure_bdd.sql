-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 13 jan. 2025 à 06:20
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bail_online`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

DROP TABLE IF EXISTS `abonnement`;
CREATE TABLE IF NOT EXISTS `abonnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin,
  `prix_mensuel` decimal(10,2) NOT NULL,
  `prix_annuel` decimal(10,2) NOT NULL,
  `tva_rate` decimal(5,2) NOT NULL DEFAULT '20.00',
  `actif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `assurances`
--

DROP TABLE IF EXISTS `assurances`;
CREATE TABLE IF NOT EXISTS `assurances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  `type_assurance` enum('habitation','propriétaire','garantie_loyer_impayé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fournisseur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` enum('brouillon','actif','expiré','résilié') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bien_id` (`bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `baux`
--

DROP TABLE IF EXISTS `baux`;
CREATE TABLE IF NOT EXISTS `baux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `garant_id` int DEFAULT NULL,
  `bien_immobilier_id` int DEFAULT NULL,
  `modele_bail_id` int DEFAULT NULL,
  `contenu_personnalise` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `montant_loyer` decimal(10,2) DEFAULT NULL,
  `montant_charge` decimal(10,2) DEFAULT NULL,
  `montant_caution` decimal(10,2) DEFAULT NULL,
  `echeance_paiement` int DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `duree_preavis` int DEFAULT NULL,
  `statut` enum('brouillon','actif','expiré','terminé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `engagement_attestation_assurance` tinyint(1) DEFAULT NULL,
  `mode_paiement` enum('virement','chèque','espèces','carte') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conditions_speciales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `references_legales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `indexation_annuelle` decimal(5,2) DEFAULT NULL,
  `indice_reference` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caution_remboursee` tinyint(1) DEFAULT '0',
  `date_remboursement_caution` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `garant_id` (`garant_id`),
  KEY `bien_immobilier_id` (`bien_immobilier_id`),
  KEY `modele_bail_id` (`modele_bail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `baux_locataires`
--

DROP TABLE IF EXISTS `baux_locataires`;
CREATE TABLE IF NOT EXISTS `baux_locataires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bail_id` int NOT NULL,
  `users_id` int NOT NULL,
  `pourcentage_part` decimal(5,2) DEFAULT '100.00',
  `date_entree` date NOT NULL,
  `date_sortie` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bail_id` (`bail_id`),
  KEY `users_id` (`users_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers`
--

DROP TABLE IF EXISTS `biens_immobiliers`;
CREATE TABLE IF NOT EXISTS `biens_immobiliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proprietaire_id` int DEFAULT NULL,
  `type_bien_id` int DEFAULT NULL,
  `etat_general` enum('neuf','bon','à rénover','mauvais','ruine') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classe_energetique` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consommation_energetique` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emissions_ges` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxe_fonciere` decimal(10,2) DEFAULT NULL,
  `taxe_habitation` decimal(10,2) DEFAULT NULL,
  `orientation` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vue` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_chauffage` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_propriete` enum('loué','vacant','en vente','occupé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_ajout` datetime DEFAULT NULL,
  `date_mise_a_jour` datetime DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `immeuble` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quartier` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `proprietaire_id` (`proprietaire_id`),
  KEY `type_bien_id` (`type_bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers_configuration`
--

DROP TABLE IF EXISTS `biens_immobiliers_configuration`;
CREATE TABLE IF NOT EXISTS `biens_immobiliers_configuration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bien` int DEFAULT NULL,
  `surface_habitable` decimal(10,2) DEFAULT NULL,
  `surface_jardin` decimal(10,2) DEFAULT NULL,
  `surface_dependances` decimal(10,2) DEFAULT NULL,
  `nombre_pieces` int DEFAULT NULL,
  `nombre_chambres` int DEFAULT NULL,
  `nombre_salles_de_bain` int DEFAULT NULL,
  `nombre_toilettes` int DEFAULT NULL,
  `nombre_etages` int DEFAULT NULL,
  `nombre_balcon` int DEFAULT NULL,
  `nombre_terrasse` int DEFAULT NULL,
  `annee_construction` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee_renovation` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_bien` (`id_bien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers_option`
--

DROP TABLE IF EXISTS `biens_immobiliers_option`;
CREATE TABLE IF NOT EXISTS `biens_immobiliers_option` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bien` int DEFAULT NULL,
  `cuisine_equipee` tinyint(1) DEFAULT NULL,
  `jardin` tinyint(1) DEFAULT NULL,
  `piscine` tinyint(1) DEFAULT NULL,
  `parking` tinyint(1) DEFAULT NULL,
  `garage` tinyint(1) DEFAULT NULL,
  `cave` tinyint(1) DEFAULT NULL,
  `ascenseur` tinyint(1) DEFAULT NULL,
  `climatisation` tinyint(1) DEFAULT NULL,
  `acces_pmr` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_bien` (`id_bien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

DROP TABLE IF EXISTS `compteur`;
CREATE TABLE IF NOT EXISTS `compteur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `baux_id` int NOT NULL,
  `type` enum('elec','eau','gaz','autre') COLLATE utf8mb4_bin NOT NULL,
  `value` float NOT NULL DEFAULT '0',
  `value_type` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_baux` (`baux_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `bien_id` int DEFAULT NULL,
  `bail_id` int DEFAULT NULL,
  `type_document` enum('attestation','contrat','facture','autre') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bien_id` (`bien_id`),
  KEY `bail_id` (`bail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat_lieux`
--

DROP TABLE IF EXISTS `etat_lieux`;
CREATE TABLE IF NOT EXISTS `etat_lieux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `baux_id` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `etat_entree` tinyint(1) DEFAULT NULL,
  `etat_sortie` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `baux_id` (`baux_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `garant_user`
--

DROP TABLE IF EXISTS `garant_user`;
CREATE TABLE IF NOT EXISTS `garant_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_id_garant` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_garant` (`user_id_garant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_modifications`
--

DROP TABLE IF EXISTS `historique_modifications`;
CREATE TABLE IF NOT EXISTS `historique_modifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_cible` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cible_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `type_modification` enum('création','mise à jour','suppression') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `incidents`
--

DROP TABLE IF EXISTS `incidents`;
CREATE TABLE IF NOT EXISTS `incidents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bien_id` int DEFAULT NULL,
  `bail_id` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `statut` enum('brouillon','signalé','en_cours','résolu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_signalement` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_resolution` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bien_id` (`bien_id`),
  KEY `bail_id` (`bail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bien_id` int NOT NULL,
  `etat_lieux_items_id` int NOT NULL,
  `incidents_id` int DEFAULT NULL,
  `type` enum('image','video','document','audio') COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin,
  `position` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bien_id` (`bien_id`),
  KEY `etat_lieux_items_id` (`etat_lieux_items_id`),
  KEY `incidents_id` (`incidents_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `modeles_bail`
--

DROP TABLE IF EXISTS `modeles_bail`;
CREATE TABLE IF NOT EXISTS `modeles_bail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contenu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `type_notification` enum('rappel_paiement','renouvellement_bail','autre') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `statut` enum('non_lu','lu','archivé') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'non_lu',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_envoi` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stripe_payment_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('brouillon','succès','échec','en_attente') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `quittances_loyer`
--

DROP TABLE IF EXISTS `quittances_loyer`;
CREATE TABLE IF NOT EXISTS `quittances_loyer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bail_id` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_emission` datetime DEFAULT NULL,
  `statut` enum('brouillon','en_attente','payée','annulée') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `moyen_paiement` enum('virement','chèque','espèces','carte') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bail_id` (`bail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `signature`
--

DROP TABLE IF EXISTS `signature`;
CREATE TABLE IF NOT EXISTS `signature` (
  `id` int NOT NULL AUTO_INCREMENT,
  `baux_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `signature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `baux_id` (`baux_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivis_paiements`
--

DROP TABLE IF EXISTS `suivis_paiements`;
CREATE TABLE IF NOT EXISTS `suivis_paiements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quittance_id` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `statut` enum('validé','en_attente','échoué') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `quittance_id` (`quittance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_bien`
--

DROP TABLE IF EXISTS `types_bien`;
CREATE TABLE IF NOT EXISTS `types_bien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_parrain` int DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portable` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users_abonnements`
--

DROP TABLE IF EXISTS `users_abonnements`;
CREATE TABLE IF NOT EXISTS `users_abonnements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `abonnement_id` int NOT NULL,
  `payments_id` int DEFAULT NULL,
  `type_formule` enum('mensuel','annuel') COLLATE utf8mb4_bin NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `tva_rate` decimal(5,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_ttc` decimal(10,2) NOT NULL,
  `date_acquisition` date NOT NULL,
  `date_expiration` date NOT NULL,
  `statut` enum('actif','expiré','annulé') COLLATE utf8mb4_bin DEFAULT 'actif',
  `suivi` text COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `abonnement_id` (`abonnement_id`),
  KEY `fk_payments_id` (`payments_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user_facturation_info`
--

DROP TABLE IF EXISTS `user_facturation_info`;
CREATE TABLE IF NOT EXISTS `user_facturation_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `is_pro` tinyint(1) DEFAULT '0' COMMENT '0 = particulier / 1 pro',
  `entreprise` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `siret` varchar(14) COLLATE utf8mb4_bin DEFAULT NULL,
  `adresse` text COLLATE utf8mb4_bin,
  `code_postal` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `pays` varchar(100) COLLATE utf8mb4_bin DEFAULT 'France',
  `tva_intra` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assurances`
--
ALTER TABLE `assurances`
  ADD CONSTRAINT `assurances_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assurances_ibfk_2` FOREIGN KEY (`bien_id`) REFERENCES `biens_immobiliers` (`id`);

--
-- Contraintes pour la table `baux`
--
ALTER TABLE `baux`
  ADD CONSTRAINT `baux_ibfk_2` FOREIGN KEY (`garant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `baux_ibfk_3` FOREIGN KEY (`bien_immobilier_id`) REFERENCES `biens_immobiliers` (`id`),
  ADD CONSTRAINT `baux_ibfk_4` FOREIGN KEY (`modele_bail_id`) REFERENCES `modeles_bail` (`id`);

--
-- Contraintes pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  ADD CONSTRAINT `biens_immobiliers_ibfk_1` FOREIGN KEY (`proprietaire_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `biens_immobiliers_ibfk_2` FOREIGN KEY (`type_bien_id`) REFERENCES `types_bien` (`id`);

--
-- Contraintes pour la table `biens_immobiliers_configuration`
--
ALTER TABLE `biens_immobiliers_configuration`
  ADD CONSTRAINT `biens_immobiliers_configuration_ibfk_1` FOREIGN KEY (`id_bien`) REFERENCES `biens_immobiliers` (`id`);

--
-- Contraintes pour la table `biens_immobiliers_option`
--
ALTER TABLE `biens_immobiliers_option`
  ADD CONSTRAINT `biens_immobiliers_option_ibfk_1` FOREIGN KEY (`id_bien`) REFERENCES `biens_immobiliers` (`id`);

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`bien_id`) REFERENCES `biens_immobiliers` (`id`),
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`bail_id`) REFERENCES `baux` (`id`);

--
-- Contraintes pour la table `etat_lieux`
--
ALTER TABLE `etat_lieux`
  ADD CONSTRAINT `etat_lieux_ibfk_1` FOREIGN KEY (`baux_id`) REFERENCES `baux` (`id`);

--
-- Contraintes pour la table `garant_user`
--
ALTER TABLE `garant_user`
  ADD CONSTRAINT `garant_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `garant_user_ibfk_2` FOREIGN KEY (`user_id_garant`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `historique_modifications`
--
ALTER TABLE `historique_modifications`
  ADD CONSTRAINT `historique_modifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`bien_id`) REFERENCES `biens_immobiliers` (`id`),
  ADD CONSTRAINT `incidents_ibfk_2` FOREIGN KEY (`bail_id`) REFERENCES `baux` (`id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `quittances_loyer`
--
ALTER TABLE `quittances_loyer`
  ADD CONSTRAINT `quittances_loyer_ibfk_1` FOREIGN KEY (`bail_id`) REFERENCES `baux` (`id`);

--
-- Contraintes pour la table `signature`
--
ALTER TABLE `signature`
  ADD CONSTRAINT `signature_ibfk_1` FOREIGN KEY (`baux_id`) REFERENCES `baux` (`id`),
  ADD CONSTRAINT `signature_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `suivis_paiements`
--
ALTER TABLE `suivis_paiements`
  ADD CONSTRAINT `suivis_paiements_ibfk_1` FOREIGN KEY (`quittance_id`) REFERENCES `quittances_loyer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
