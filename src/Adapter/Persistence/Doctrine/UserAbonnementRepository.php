<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\UserAbonnementRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;
use App\Core\Domain\Entity\UserAbonnement;

class UserAbonnementRepository implements UserAbonnementRepositoryInterface
{

    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
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
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
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

    public function update(int $userAbonnementId, array $data): bool
    {
        $query = "UPDATE users_abonnements AS ua
        SET 
            ua.user_id = ?,
            ua.payments_id = ?,
            ua.type_formule = ?,
            ua.prix_ht = ?,
            ua.tva_rate = ?,
            ua.montant_tva = ?,
            ua.montant_ttc = ?,
            ua.date_acquisition = ?,
            ua.date_expiration = ?,
            ua.statut = ?,
            ua.suivi = ?,
            ua.updated_at = NOW()
        WHERE ua.id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs à partir des données
        $abonnementId = $userAbonnementId;
        $paymentsId = $data['payments_id'];
        $typeFormule = $data['type_formule'];
        $prixHt = $data['prix_ht'];
        $tvaRate = $data['tva_rate'];
        $montantTva = $data['montant_tva'];
        $montantTtc = $data['montant_ttc'];
        $dateAcquisition = $data['date_acquisition'];
        $dateExpiration = $data['date_expiration'];
        $statut = $data['statut'];
        $suivi = $data['suivi'];
        $userId = $data['user_id']; // Identifiant de l'utilisateur
        echo($userAbonnementId);

        // Liaison des paramètres
        $stmt->bind_param(
            "iisdddsdsisi", // Types des paramètres : (i = integer, s = string, d = double)
            $userId,
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
            $abonnementId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    public function getUserAbonnement($userAbonnementId): ?array 
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM users_abonnements WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $userAbonnementId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun user abonnement trouvé, l'ID: $userAbonnementId n'existe pas");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $userAbonnement = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $userAbonnement;
    }

    public function destroy(int $userAbonnementId): bool
    {
        $query = "DELETE FROM users_abonnements
            WHERE id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison des paramètres
        $stmt->bind_param(
            "i", // Types des paramètres (i = integer, s = string, d = double)
            $userAbonnementId,
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }
} 