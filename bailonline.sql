-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 23 jan. 2025 à 08:41
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bailonline`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `prix_mensuel` decimal(10,2) NOT NULL,
  `prix_annuel` decimal(10,2) NOT NULL,
  `tva_rate` decimal(5,2) NOT NULL DEFAULT 20.00,
  `actif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `assurances`
--

CREATE TABLE `assurances` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bien_id` int(11) DEFAULT NULL,
  `type_assurance` enum('habitation','propriétaire','garantie_loyer_impayé') DEFAULT NULL,
  `fournisseur` varchar(255) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` enum('brouillon','actif','expiré','résilié') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `baux`
--

CREATE TABLE `baux` (
  `id` int(11) NOT NULL,
  `garant_id` int(11) DEFAULT NULL,
  `bien_immobilier_id` int(11) DEFAULT NULL,
  `modele_bail_id` int(11) DEFAULT NULL,
  `contenu_personnalise` longtext DEFAULT NULL,
  `montant_loyer` decimal(10,2) DEFAULT NULL,
  `montant_charge` decimal(10,2) DEFAULT NULL,
  `montant_caution` decimal(10,2) DEFAULT NULL,
  `echeance_paiement` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `duree_preavis` int(11) DEFAULT NULL,
  `statut` enum('brouillon','actif','expiré','terminé') DEFAULT NULL,
  `engagement_attestation_assurance` tinyint(1) DEFAULT NULL,
  `mode_paiement` enum('virement','chèque','espèces','carte') DEFAULT NULL,
  `conditions_speciales` text DEFAULT NULL,
  `references_legales` text DEFAULT NULL,
  `indexation_annuelle` decimal(5,2) DEFAULT NULL,
  `indice_reference` varchar(100) DEFAULT NULL,
  `caution_remboursee` tinyint(1) DEFAULT 0,
  `date_remboursement_caution` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `baux`
--

INSERT INTO `baux` (`id`, `garant_id`, `bien_immobilier_id`, `modele_bail_id`, `contenu_personnalise`, `montant_loyer`, `montant_charge`, `montant_caution`, `echeance_paiement`, `date_debut`, `date_fin`, `duree_preavis`, `statut`, `engagement_attestation_assurance`, `mode_paiement`, `conditions_speciales`, `references_legales`, `indexation_annuelle`, `indice_reference`, `caution_remboursee`, `date_remboursement_caution`, `created_at`, `updated_at`) VALUES
(4, 13, 3, 1, 'Contenu personnalisé 1', 700.00, 50.00, 1400.00, 12, '2023-01-01', '2024-01-01', 2, 'actif', 1, 'virement', 'Aucune condition', 'Article L123', 1.50, 'IRL-2023', 0, NULL, '2025-01-20 08:50:30', '2025-01-20 08:50:30'),
(6, 13, 3, 1, 'Contenu personnalisé 1', 700.00, 50.00, 1400.00, 12, '2023-01-01', '2024-01-01', 2, 'actif', 1, 'virement', 'Aucune condition', 'Article L123', 1.50, 'IRL-2023', 0, NULL, '2025-01-20 08:50:50', '2025-01-20 08:50:50'),
(7, 14, 3, 2, 'Contenu personnalisé 2', 800.00, 60.00, 1600.00, 11, '2023-02-01', '2024-02-01', 3, 'brouillon', 0, 'chèque', 'Aucune condition', 'Article L456', 2.00, 'IRL-2024', 1, '2024-02-15', '2025-01-20 08:50:50', '2025-01-20 08:50:50'),
(8, 14, 5, 3, 'Contenu personnalisé 3', 750.00, 55.00, 1500.00, 10, '2023-03-01', '2024-03-01', 1, 'actif', 1, 'espèces', 'Conditions spéciales', 'Article L789', 1.75, 'IRL-2025', 0, NULL, '2025-01-20 08:50:50', '2025-01-20 08:50:50'),
(9, 14, 6, 4, 'Contenu personnalisé 4', 850.00, 70.00, 1700.00, 12, '2023-04-01', '2024-04-01', 3, 'expiré', 1, 'virement', 'Pas de conditions', 'Article L012', 1.25, 'IRL-2026', 1, '2024-04-10', '2025-01-20 08:50:50', '2025-01-20 08:50:50'),
(10, 15, 6, 5, 'Contenu personnalisé 5', 950.00, 80.00, 1900.00, 12, '2023-05-01', '2024-05-01', 2, 'terminé', 0, 'carte', 'Conditions particulières', 'Article L345', 1.00, 'IRL-2027', 0, NULL, '2025-01-20 08:50:51', '2025-01-20 08:50:51'),
(11, 16, 3, 1, 'Contenu personnalisé 6', 1000.00, 90.00, 2000.00, 10, '2023-06-01', '2024-06-01', 1, 'actif', 1, 'virement', 'Aucune', 'Article L678', 1.50, 'IRL-2028', 1, '2024-06-20', '2025-01-20 08:50:51', '2025-01-20 08:50:51'),
(12, 17, 5, 2, 'Contenu personnalisé 7', 720.00, 40.00, 1400.00, 11, '2023-07-01', '2024-07-01', 2, 'brouillon', 0, 'chèque', 'Rien à signaler', 'Article L901', 2.25, 'IRL-2029', 0, NULL, '2025-01-20 08:50:51', '2025-01-20 08:50:51'),
(13, 18, 6, 3, 'Contenu personnalisé 8', 1100.00, 100.00, 2200.00, 12, '2023-08-01', '2024-08-01', 3, 'actif', 1, 'virement', 'Conditions diverses', 'Article L234', 1.75, 'IRL-2030', 1, '2024-08-15', '2025-01-20 08:50:51', '2025-01-20 08:50:51'),
(14, 13, 3, 4, 'Contenu personnalisé 9', 900.00, 85.00, 1800.00, 10, '2023-09-01', '2024-09-01', 1, 'expiré', 1, 'chèque', 'Rien', 'Article L567', 2.50, 'IRL-2031', 0, NULL, '2025-01-20 08:50:51', '2025-01-20 08:50:51'),
(16, 13, 3, 1, 'Contenu personnalisé 1', 700.00, 50.00, 1400.00, 12, '2023-01-01', '2024-01-01', 2, 'actif', 1, 'virement', 'Aucune condition', 'Article L123', 1.50, 'IRL-2023', 0, NULL, '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(17, 14, 3, 2, 'Contenu personnalisé 2', 800.00, 60.00, 1600.00, 11, '2023-02-01', '2024-02-01', 3, 'brouillon', 0, 'chèque', 'Aucune condition', 'Article L456', 2.00, 'IRL-2024', 1, '2024-02-15', '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(18, 14, 5, 3, 'Contenu personnalisé 3', 750.00, 55.00, 1500.00, 10, '2023-03-01', '2024-03-01', 1, 'actif', 1, 'espèces', 'Conditions spéciales', 'Article L789', 1.75, 'IRL-2025', 0, NULL, '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(19, 14, 6, 4, 'Contenu personnalisé 4', 850.00, 70.00, 1700.00, 12, '2023-04-01', '2024-04-01', 3, 'expiré', 1, 'virement', 'Pas de conditions', 'Article L012', 1.25, 'IRL-2026', 1, '2024-04-10', '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(20, 15, 6, 5, 'Contenu personnalisé 5', 950.00, 80.00, 1900.00, 12, '2023-05-01', '2024-05-01', 2, 'terminé', 0, 'carte', 'Conditions particulières', 'Article L345', 1.00, 'IRL-2027', 0, NULL, '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(21, 16, 3, 1, 'Contenu personnalisé 6', 1000.00, 90.00, 2000.00, 10, '2023-06-01', '2024-06-01', 1, 'actif', 1, 'virement', 'Aucune', 'Article L678', 1.50, 'IRL-2028', 1, '2024-06-20', '2025-01-20 08:51:32', '2025-01-20 08:51:32'),
(22, 17, 5, 2, 'Contenu personnalisé 7', 720.00, 40.00, 1400.00, 11, '2023-07-01', '2024-07-01', 2, 'brouillon', 0, 'chèque', 'Rien à signaler', 'Article L901', 2.25, 'IRL-2029', 0, NULL, '2025-01-20 08:51:33', '2025-01-20 08:51:33'),
(23, 18, 6, 3, 'Contenu personnalisé 8', 1100.00, 100.00, 2200.00, 12, '2023-08-01', '2024-08-01', 3, 'actif', 1, 'virement', 'Conditions diverses', 'Article L234', 1.75, 'IRL-2030', 1, '2024-08-15', '2025-01-20 08:51:33', '2025-01-20 08:51:33'),
(24, 13, 3, 4, 'Contenu personnalisé 9', 900.00, 85.00, 1800.00, 10, '2023-09-01', '2024-09-01', 1, 'expiré', 1, 'chèque', 'Rien', 'Article L567', 2.50, 'IRL-2031', 0, NULL, '2025-01-20 08:51:33', '2025-01-20 08:51:33'),
(25, 14, 6, 5, 'Contenu personnalisé 10', 820.00, 65.00, 1600.00, 11, '2023-10-01', '2024-10-01', 2, 'terminé', 0, 'espèces', 'Aucune condition', 'Article L890', 2.00, 'IRL-2032', 1, '2024-10-25', '2025-01-20 08:51:33', '2025-01-20 08:51:33');

-- --------------------------------------------------------

--
-- Structure de la table `baux_locataires`
--

CREATE TABLE `baux_locataires` (
  `id` int(11) NOT NULL,
  `bail_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `pourcentage_part` decimal(5,2) DEFAULT 100.00,
  `date_entree` date NOT NULL,
  `date_sortie` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers`
--

CREATE TABLE `biens_immobiliers` (
  `id` int(11) NOT NULL,
  `proprietaire_id` int(11) DEFAULT NULL,
  `type_bien_id` int(11) DEFAULT NULL,
  `etat_general` enum('neuf','bon','à rénover','mauvais','ruine') DEFAULT NULL,
  `classe_energetique` char(1) DEFAULT NULL,
  `consommation_energetique` char(1) DEFAULT NULL,
  `emissions_ges` char(1) DEFAULT NULL,
  `taxe_fonciere` decimal(10,2) DEFAULT NULL,
  `taxe_habitation` decimal(10,2) DEFAULT NULL,
  `orientation` varchar(10) DEFAULT NULL,
  `vue` varchar(100) DEFAULT NULL,
  `type_chauffage` varchar(50) DEFAULT NULL,
  `statut_propriete` enum('loué','vacant','en vente','occupé') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_ajout` datetime DEFAULT NULL,
  `date_mise_a_jour` datetime DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `immeuble` varchar(255) DEFAULT NULL,
  `etage` varchar(255) DEFAULT NULL,
  `quartier` varchar(100) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `biens_immobiliers`
--

INSERT INTO `biens_immobiliers` (`id`, `proprietaire_id`, `type_bien_id`, `etat_general`, `classe_energetique`, `consommation_energetique`, `emissions_ges`, `taxe_fonciere`, `taxe_habitation`, `orientation`, `vue`, `type_chauffage`, `statut_propriete`, `description`, `date_ajout`, `date_mise_a_jour`, `adresse`, `immeuble`, `etage`, `quartier`, `ville`, `code_postal`, `pays`, `created_at`, `updated_at`) VALUES
(3, NULL, NULL, '', 'D', '5', '1', 1200.50, 800.75, '0', 'Dégagée', 'Gaz', '', 'Appartement lumineux avec balcon', '2025-01-15 14:30:00', '2025-01-17 10:00:00', '123 Rue des Lilas', 'Résidence Les Jardins', '2', 'Centre-ville', 'Paris', '75001', 'France', '2025-01-16 09:20:02', '2025-01-17 13:15:30'),
(5, NULL, NULL, '', 'B', 'C', 'D', 1500.50, 1200.75, '0', 'Vue sur mer', 'Chauffage central', '', 'Maison spacieuse avec jardin et piscine.', '2025-01-15 14:30:00', '2025-01-16 10:00:00', '123 Rue de l\'Exemple', 'Résidence les Palmiers', '3', 'Centre-ville', 'Nice', '06000', 'France', '2025-01-16 09:22:41', '2025-01-16 09:22:41'),
(6, NULL, NULL, '', 'B', 'C', 'D', 1500.50, 1200.75, '0', 'Vue sur mer', 'Chauffage central', '', 'Maison spacieuse avec jardin et piscine.', '2025-01-15 14:30:00', '2025-01-16 10:00:00', '123 Rue de l\'Exemple', 'Résidence les Palmiers', '3', 'Centre-ville', 'Nice', '06000', 'France', '2025-01-16 09:25:49', '2025-01-16 09:25:49');

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers_configuration`
--

CREATE TABLE `biens_immobiliers_configuration` (
  `id` int(11) NOT NULL,
  `id_bien` int(11) DEFAULT NULL,
  `surface_habitable` decimal(10,2) DEFAULT NULL,
  `surface_jardin` decimal(10,2) DEFAULT NULL,
  `surface_dependances` decimal(10,2) DEFAULT NULL,
  `nombre_pieces` int(11) DEFAULT NULL,
  `nombre_chambres` int(11) DEFAULT NULL,
  `nombre_salles_de_bain` int(11) DEFAULT NULL,
  `nombre_toilettes` int(11) DEFAULT NULL,
  `nombre_etages` int(11) DEFAULT NULL,
  `nombre_balcon` int(11) DEFAULT NULL,
  `nombre_terrasse` int(11) DEFAULT NULL,
  `annee_construction` varchar(4) DEFAULT NULL,
  `annee_renovation` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers_option`
--

CREATE TABLE `biens_immobiliers_option` (
  `id` int(11) NOT NULL,
  `id_bien` int(11) DEFAULT NULL,
  `cuisine_equipee` tinyint(1) DEFAULT NULL,
  `jardin` tinyint(1) DEFAULT NULL,
  `piscine` tinyint(1) DEFAULT NULL,
  `parking` tinyint(1) DEFAULT NULL,
  `garage` tinyint(1) DEFAULT NULL,
  `cave` tinyint(1) DEFAULT NULL,
  `ascenseur` tinyint(1) DEFAULT NULL,
  `climatisation` tinyint(1) DEFAULT NULL,
  `acces_pmr` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE `compteur` (
  `id` int(11) NOT NULL,
  `baux_id` int(11) NOT NULL,
  `type` enum('elec','eau','gaz','autre') NOT NULL,
  `value` float NOT NULL DEFAULT 0,
  `value_type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bien_id` int(11) DEFAULT NULL,
  `bail_id` int(11) DEFAULT NULL,
  `type_document` enum('attestation','contrat','facture','autre') DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat_lieux`
--

CREATE TABLE `etat_lieux` (
  `id` int(11) NOT NULL,
  `baux_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `etat_entree` tinyint(1) DEFAULT NULL,
  `etat_sortie` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat_lieux`
--

INSERT INTO `etat_lieux` (`id`, `baux_id`, `date`, `etat_entree`, `etat_sortie`, `created_at`, `updated_at`) VALUES
(5, 6, '2025-01-20 12:00:00', 1, 0, '2025-01-20 08:54:45', '2025-01-20 08:54:45');

-- --------------------------------------------------------

--
-- Structure de la table `etat_lieux_items`
--

CREATE TABLE `etat_lieux_items` (
  `id` int(11) NOT NULL,
  `etat_lieux_id` int(11) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `etat` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') NOT NULL,
  `plinthes` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `murs` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `sol` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `plafond` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `portes` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `huisseries` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `radiateurs` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `placards` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `aerations` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `interrupteurs` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `prises_electriques` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `tableau_electrique` enum('Neuf','Très bon état','Bon état','Correct','Usé','Dégradé','Hors service','Absent') DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etat_lieux_items`
--

INSERT INTO `etat_lieux_items` (`id`, `etat_lieux_id`, `titre`, `etat`, `plinthes`, `murs`, `sol`, `plafond`, `portes`, `huisseries`, `radiateurs`, `placards`, `aerations`, `interrupteurs`, `prises_electriques`, `tableau_electrique`, `description`) VALUES
(5, 5, 'Meuble', 'Correct', 'Neuf', 'Très bon état', 'Neuf', 'Très bon état', 'Neuf', 'Neuf', 'Très bon état', 'Neuf', 'Neuf', 'Neuf', 'Très bon état', 'Neuf', 'Quelques traces sur les murs, bon état général.');

-- --------------------------------------------------------

--
-- Structure de la table `garant_user`
--

CREATE TABLE `garant_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_id_garant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_modifications`
--

CREATE TABLE `historique_modifications` (
  `id` int(11) NOT NULL,
  `table_cible` varchar(50) DEFAULT NULL,
  `cible_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_modification` enum('création','mise à jour','suppression') DEFAULT NULL,
  `details` text DEFAULT NULL,
  `date_modification` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `bien_id` int(11) DEFAULT NULL,
  `bail_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `statut` enum('brouillon','signalé','en_cours','résolu') DEFAULT NULL,
  `date_signalement` datetime DEFAULT current_timestamp(),
  `date_resolution` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `incidents`
--

INSERT INTO `incidents` (`id`, `bien_id`, `bail_id`, `description`, `statut`, `date_signalement`, `date_resolution`) VALUES
(2, 3, 4, 'Fuite d\'eau dans la salle de bain', '', '2025-01-20 00:00:00', '2025-01-25 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `bien_id` int(11) NOT NULL,
  `etat_lieux_items_id` int(11) NOT NULL,
  `incidents_id` int(11) DEFAULT NULL,
  `type` enum('image','video','document','audio') NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `modeles_bail`
--

CREATE TABLE `modeles_bail` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `contenu` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modeles_bail`
--

INSERT INTO `modeles_bail` (`id`, `nom`, `description`, `contenu`, `created_at`, `updated_at`) VALUES
(1, 'Modèle Standard', 'Modèle de bail standard pour logements', 'Contenu du modèle standard', '2025-01-20 08:49:34', '2025-01-20 08:49:34'),
(2, 'Modèle Commercial', 'Modèle pour les locaux commerciaux', 'Contenu du modèle commercial', '2025-01-20 08:49:34', '2025-01-20 08:49:34'),
(3, 'Modèle Meublé', 'Modèle pour les logements meublés', 'Contenu du modèle meublé', '2025-01-20 08:49:35', '2025-01-20 08:49:35'),
(4, 'Modèle Vacant', 'Modèle pour les biens immobiliers vacants', 'Contenu du modèle vacant', '2025-01-20 08:49:35', '2025-01-20 08:49:35'),
(5, 'Modèle Colocation', 'Modèle pour les contrats de colocation', 'Contenu du modèle colocation', '2025-01-20 08:49:35', '2025-01-20 08:49:35'),
(6, 'Modèle Temporaire', 'Modèle pour les locations temporaires', 'Contenu du modèle temporaire', '2025-01-20 08:49:35', '2025-01-20 08:49:35'),
(7, 'Modèle Étudiant', 'Modèle destiné aux étudiants', 'Contenu du modèle étudiant', '2025-01-20 08:49:35', '2025-01-20 08:49:35'),
(8, 'Modèle Professionnel', 'Modèle pour les professions libérales', 'Contenu du modèle professionnel', '2025-01-20 08:49:36', '2025-01-20 08:49:36'),
(9, 'Modèle Saisonnière', 'Modèle pour les locations saisonnières', 'Contenu du modèle saisonnière', '2025-01-20 08:49:36', '2025-01-20 08:49:36'),
(10, 'Modèle Long Terme', 'Modèle pour les locations longues durées', 'Contenu du modèle long terme', '2025-01-20 08:49:36', '2025-01-20 08:49:36');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_notification` enum('rappel_paiement','renouvellement_bail','autre') DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `statut` enum('non_lu','lu','archivé') DEFAULT 'non_lu',
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_envoi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `stripe_payment_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('brouillon','succès','échec','en_attente') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `quittances_loyer`
--

CREATE TABLE `quittances_loyer` (
  `id` int(11) NOT NULL,
  `bail_id` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_emission` datetime DEFAULT NULL,
  `statut` enum('brouillon','en_attente','payée','annulée') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `moyen_paiement` enum('virement','chèque','espèces','carte') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `signature`
--

CREATE TABLE `signature` (
  `id` int(11) NOT NULL,
  `baux_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `etat_lieux_id` int(11) NOT NULL,
  `date_signature` date DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivis_paiements`
--

CREATE TABLE `suivis_paiements` (
  `id` int(11) NOT NULL,
  `quittance_id` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `statut` enum('validé','en_attente','échoué') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_bien`
--

CREATE TABLE `types_bien` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `types_bien`
--

INSERT INTO `types_bien` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'lease', 'Méthode pour récupérer l\'ID du bail', '2025-01-17 09:08:30', '2025-01-23 09:34:56'),
(2, 'Appartement', 'Un appartement spacieux avec vue sur la mer.', '2025-01-17 09:09:51', '2025-01-17 09:09:51'),
(3, 'Appartement', 'Un appartement spacieux avec vue sur la mer.', '2025-01-17 09:12:05', '2025-01-17 09:12:05'),
(4, 'Appartement', 'Un appartement spacieux avec vue sur la mer.', '2025-01-17 09:16:35', '2025-01-17 09:16:35'),
(5, 'Appartement', 'Un appartement spacieux avec vue sur la mer.', '2025-01-17 14:28:30', '2025-01-17 14:28:30'),
(6, 'lease', 'Nouveau méthode pour récupérer l\'ID du bail', '2025-01-23 07:26:34', '2025-01-23 07:26:34'),
(7, 'lease', 'Nouveau méthode pour récupérer l\'ID du bail', '2025-01-23 07:27:32', '2025-01-23 07:27:32');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_parrain` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `portable` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `id_parrain`, `username`, `photo`, `email`, `portable`, `password`, `role`, `nom`, `prenom`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(13, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$FxHJNcz1NGZARGcTQdUW8.gJdhVg3z6o25qXOer0TphCRT2RLR7Wi', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-15 11:25:53', '2025-01-15 11:25:53'),
(14, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$6L4X7isymBFUMyF/ujRgD.EHQAEd/GOrqjZ2hr/7CWdmAAT.Smslq', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-15 11:29:52', '2025-01-15 11:29:52'),
(15, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$6L4X7isymBFUMyF/ujRgD.EHQAEd/GOrqjZ2hr/7CWdmAAT.Smslq', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-15 11:29:52', '2025-01-15 11:29:52'),
(16, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$.TCFGqWYq5HnJz2SX0YrBumOJCsVLzWla2hfPSdR5EeGzZOhBT1oy', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-15 11:46:04', '2025-01-15 11:46:04'),
(17, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$UOPtO1Rue36B4yt4cgl2wOdnMzFnSs3WqlhmyjvKDWUlVVcBmLYsO', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-15 11:48:17', '2025-01-15 11:48:17'),
(18, 3, 'athanosss', 'ath.png', 'andriamasy@gmail.com', '44522221', '$2y$10$jjJXRdgOIsG6LlnI//Q2lO5u3Tr7QHdZBJ8DZskxeuoZgybk271R6', 'admin', 'marcus', 'marcus', 0, NULL, '2025-01-16 09:01:11', '2025-01-16 09:01:11');

-- --------------------------------------------------------

--
-- Structure de la table `users_abonnements`
--

CREATE TABLE `users_abonnements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `abonnement_id` int(11) NOT NULL,
  `payments_id` int(11) DEFAULT NULL,
  `type_formule` enum('mensuel','annuel') NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `tva_rate` decimal(5,2) NOT NULL,
  `montant_tva` decimal(10,2) NOT NULL,
  `montant_ttc` decimal(10,2) NOT NULL,
  `date_acquisition` date NOT NULL,
  `date_expiration` date NOT NULL,
  `statut` enum('actif','expiré','annulé') DEFAULT 'actif',
  `suivi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `user_facturation_info`
--

CREATE TABLE `user_facturation_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_pro` tinyint(1) DEFAULT 0 COMMENT '0 = particulier / 1 pro',
  `entreprise` varchar(255) DEFAULT NULL,
  `siret` varchar(14) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT 'France',
  `tva_intra` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `assurances`
--
ALTER TABLE `assurances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bien_id` (`bien_id`);

--
-- Index pour la table `baux`
--
ALTER TABLE `baux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `garant_id` (`garant_id`),
  ADD KEY `bien_immobilier_id` (`bien_immobilier_id`),
  ADD KEY `modele_bail_id` (`modele_bail_id`);

--
-- Index pour la table `baux_locataires`
--
ALTER TABLE `baux_locataires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bail_id` (`bail_id`),
  ADD KEY `users_id` (`users_id`) USING BTREE;

--
-- Index pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietaire_id` (`proprietaire_id`),
  ADD KEY `type_bien_id` (`type_bien_id`);

--
-- Index pour la table `biens_immobiliers_configuration`
--
ALTER TABLE `biens_immobiliers_configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bien` (`id_bien`);

--
-- Index pour la table `biens_immobiliers_option`
--
ALTER TABLE `biens_immobiliers_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bien` (`id_bien`);

--
-- Index pour la table `compteur`
--
ALTER TABLE `compteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_baux` (`baux_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bien_id` (`bien_id`),
  ADD KEY `bail_id` (`bail_id`);

--
-- Index pour la table `etat_lieux`
--
ALTER TABLE `etat_lieux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baux_id` (`baux_id`);

--
-- Index pour la table `etat_lieux_items`
--
ALTER TABLE `etat_lieux_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etat_lieux_id` (`etat_lieux_id`);

--
-- Index pour la table `garant_user`
--
ALTER TABLE `garant_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_garant` (`user_id_garant`);

--
-- Index pour la table `historique_modifications`
--
ALTER TABLE `historique_modifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bien_id` (`bien_id`),
  ADD KEY `bail_id` (`bail_id`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bien_id` (`bien_id`),
  ADD KEY `etat_lieux_items_id` (`etat_lieux_items_id`),
  ADD KEY `incidents_id` (`incidents_id`);

--
-- Index pour la table `modeles_bail`
--
ALTER TABLE `modeles_bail`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `quittances_loyer`
--
ALTER TABLE `quittances_loyer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bail_id` (`bail_id`);

--
-- Index pour la table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `baux_id` (`baux_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_signature_etat_lieux` (`etat_lieux_id`);

--
-- Index pour la table `suivis_paiements`
--
ALTER TABLE `suivis_paiements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quittance_id` (`quittance_id`);

--
-- Index pour la table `types_bien`
--
ALTER TABLE `types_bien`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_abonnements`
--
ALTER TABLE `users_abonnements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `abonnement_id` (`abonnement_id`),
  ADD KEY `fk_payments_id` (`payments_id`);

--
-- Index pour la table `user_facturation_info`
--
ALTER TABLE `user_facturation_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `assurances`
--
ALTER TABLE `assurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `baux`
--
ALTER TABLE `baux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `baux_locataires`
--
ALTER TABLE `baux_locataires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `biens_immobiliers_configuration`
--
ALTER TABLE `biens_immobiliers_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `biens_immobiliers_option`
--
ALTER TABLE `biens_immobiliers_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `compteur`
--
ALTER TABLE `compteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etat_lieux`
--
ALTER TABLE `etat_lieux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `etat_lieux_items`
--
ALTER TABLE `etat_lieux_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `garant_user`
--
ALTER TABLE `garant_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique_modifications`
--
ALTER TABLE `historique_modifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `modeles_bail`
--
ALTER TABLE `modeles_bail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quittances_loyer`
--
ALTER TABLE `quittances_loyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivis_paiements`
--
ALTER TABLE `suivis_paiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types_bien`
--
ALTER TABLE `types_bien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `users_abonnements`
--
ALTER TABLE `users_abonnements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_facturation_info`
--
ALTER TABLE `user_facturation_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Contraintes pour la table `etat_lieux_items`
--
ALTER TABLE `etat_lieux_items`
  ADD CONSTRAINT `fk_etat_lieux_id` FOREIGN KEY (`etat_lieux_id`) REFERENCES `etat_lieux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_signature_etat_lieux` FOREIGN KEY (`etat_lieux_id`) REFERENCES `etat_lieux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
