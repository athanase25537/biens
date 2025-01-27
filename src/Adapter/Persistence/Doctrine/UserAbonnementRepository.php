<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\UserAbonnementRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;
use App\Core\Domain\Entity\UserAbonnement;

class UserAbonnementRepository implements UserAbonnementRepositoryInterface
{
    private $db;
    private $config = [
        'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
        'host' => 'localhost',
        'dbname' => 'bailonline',
        'user' => 'root',
        'password' => '',
    ];

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(UserAbonnement $userAbonnement): UserAbonnement
    {
        $query = "INSERT INTO users_abonnements (
            user_id,
            abonnement_id,
            payments_id,
            type_formule,
            prix_ht,
            tva_rate,
            montant_tva,
            montant_ttc,
            date_acquisition,
            date_expiration,
            statut,
            suivi,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($this->config);
        $stmt = $db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        // Extraction des données de l'objet UserAbonnement
        $userId = $userAbonnement->getUserId();
        $abonnementId = $userAbonnement->getAbonnementId();
        $paymentsId = $userAbonnement->getPaymentsId();
        $typeFormule = $userAbonnement->getTypeFormule();
        $prixHt = $userAbonnement->getPrixHt();
        $tvaRate = $userAbonnement->getTvaRate();
        $montantTva = $userAbonnement->getMontantTva();
        $montantTtc = $userAbonnement->getMontantTtc();
        $dateAcquisition = $userAbonnement->getDateAcquisition()->format('Y-m-d');
        $dateExpiration = $userAbonnement->getDateExpiration()->format('Y-m-d');
        $statut = $userAbonnement->getStatut();
        $suivi = $userAbonnement->getSuivi();
        $createdAt = $userAbonnement->getCreatedAt()->format('Y-m-d H:i:s');
        $updatedAt = $userAbonnement->getUpdatedAt()->format('Y-m-d H:i:s');

        // Liaison des paramètres
        $stmt->bind_param(
            "iiissddddsssss",
            $userId,
            $abonnementId,
            $paymentsId,
            $typeFormule,
            $prixHt,
            $tvaRate,
            $montantTva,
            $montantTtc,
            $dateAcquisition,
            $dateExpiration,
            $statut,
            $suivi,
            $createdAt,
            $updatedAt
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        
        // Retour de l'objet UserAbonnement
        return $userAbonnement;
    }
} 