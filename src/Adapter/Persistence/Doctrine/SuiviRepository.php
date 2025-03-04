<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\SuiviRepositoryInterface;
use App\Core\Domain\Entity\Suivi;

class SuiviRepository implements SuiviRepositoryInterface
{

    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function save(Suivi $suivi): Suivi
    {
        $query = "INSERT INTO suivis_paiements (
                    quittance_id,
                    montant,
                    date_paiement,
                    statut,
                    created_at,
                    updated_at
                    ) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        

        // Assignation des valeurs à partir de l'objet Incident
        $quittance_id = $suivi->getQuittanceId();
        $montant = $suivi->getMontant();
        $date_paiement = $suivi->getDatePaiement()->format('Y-m-d H:i:s');
        $statut = $suivi->getStatut();
        $created_at = $suivi->getCreatedAt()->format('Y-m-d H:i:s');
        $updated_at = $suivi->getUpdatedAt()->format('Y-m-d H:i:s');
        
        // Liaison des paramètres
        $stmt->bind_param(
            "idsiss", // Types des paramètres (i = integer, s = string)
            $quittance_id,
            $montant,
            $date_paiement,
            $statut,
            $created_at,
            $updated_at
        );
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
        
        // Fermeture du statement
        $stmt->close();
        
        return $suivi;     
    }

    public function update(int $suiviId, array $data): bool 
    {
        $query = "UPDATE suivis_paiements
            SET 
                quittance_id = ?,
                montant = ?,
                date_paiement = ?,
                statut = ?,
                updated_at = ? 
            WHERE id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs à partir des données
        $quittanceId = $data['quittance_id'];
        $montant = $data['montant'];
        $datePaiement = $data['date_paiement'];
        $statut = $data['statut'];
        $updatedAt = $data['updated_at'];

        // Liaison des paramètres
        $stmt->bind_param(
            "idsis",
            $quittanceId,
            $montant,
            $datePaiement,
            $statut,
            $updatedAt,
            $suiviId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }

    public function destroy(int $suiviId, int $bailId): bool 
    {
        $query = "DELETE s
            FROM suivis_paiements AS s
            INNER JOIN baux AS b ON b.id = s.bail_id
            WHERE s.id = ? AND b.id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison des paramètres
        $stmt->bind_param(
            "ii", // Types des paramètres (i = integer, s = string, d = double)
            $suiviId,
            $bailId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }
    
    public function getSuivi(int $suiviId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM suivis_paiements WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $suiviId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun suivi paiement trouvé");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $suivi = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $suivi;
    }
}