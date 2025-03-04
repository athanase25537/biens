<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\QuittanceLoyerRepositoryInterface;
use App\Core\Domain\Entity\QuittanceLoyer;

class QuittanceLoyerRepository implements QuittanceLoyerRepositoryInterface
{

    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function save(QuittanceLoyer $quittanceLoyer): QuittanceLoyer
    {
        $query = "INSERT INTO quittances_loyer (
                    bail_id,
                    montant,
                    date_emission,	
                    statut,
                    description,	
                    moyen_paiement,
                    montant_charge,
                    montant_impayer,
                    created_at,
                    updated_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        

        // Assignation des valeurs à partir de l'objet Incident
        $bail_id = $quittanceLoyer->getBailId();
        $montant = $quittanceLoyer->getMontant();
        $date_emission = $quittanceLoyer->getDateEmission()->format('Y-m-d H:i:s');
        $statut = $quittanceLoyer->getStatut();
        $description = $quittanceLoyer->getDescription();
        $moyen_paiement = $quittanceLoyer->getMoyenPaiement();
        $montant_charge = $quittanceLoyer->getMontantCharge();
        $montant_impayer = $quittanceLoyer->getMontantImpayer();
        $created_at = $quittanceLoyer->getCreatedAt()->format('Y-m-d H:i:s');
        $updated_at = $quittanceLoyer->getUpdatedAt()->format('Y-m-d H:i:s');
        
        // Liaison des paramètres
        $stmt->bind_param(
            "idsisiddss", // Types des paramètres (i = integer, s = string)
            $bail_id,
            $montant,
            $date_emission,
            $statut,
            $description,
            $moyen_paiement,
            $montant_charge,
            $montant_impayer,
            $created_at,
            $updated_at,
        );
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
        
        // Fermeture du statement
        $stmt->close();
        
        return $quittanceLoyer;     
    }

    public function update(int $quittanceLoyerId, array $data): bool 
    {
        $query = "UPDATE quittances_loyer AS ql
            INNER JOIN baux AS b ON b.id = ql.bail_id
            SET 
                ql.bail_id = ?,
                ql.montant = ?,
                ql.date_emission = ?,
                ql.statut = ?,
                ql.description = ?,
                ql.moyen_paiement = ?,
                ql.montant_charge = ?,
                ql.montant_impayer = ?,
                ql.updated_at = ?
            WHERE ql.id = ? AND ql.bail_id = ? AND b.id = ?";
        
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        // Assignation des valeurs à partir des données
        $bailId = $data['bail_id'];
        $montant = $data['montant'];
        $dateEmission = $data['date_emission'];
        $statut = $data['statut'];
        $description = $data['description'];
        $moyenPaiement = $data['moyen_paiement'];
        $montantCharge = $data['montant_charge'];
        $montantImpayer = $data['montant_impayer'];
        $updatedAt = $data['updated_at'];
        $id = $quittanceLoyerId;

        // Liaison des paramètres
        $stmt->bind_param(
            "idsssiddsiii", // Types des paramètres
            $bailId,
            $montant,
            $dateEmission,
            $statut,
            $description,
            $moyenPaiement,
            $montantCharge,
            $montantImpayer,
            $updatedAt,
            $quittanceLoyerId,
            $bailId,
            $quittanceLoyerId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    public function destroy(int $quittanceLoyerId, int $bailId): bool 
    {
        $query = "DELETE ql
            FROM quittances_loyer AS ql
            INNER JOIN baux AS b ON b.id = ql.bail_id
            WHERE bl.id = ? AND b.id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison des paramètres
        $stmt->bind_param(
            "ii", // Types des paramètres (i = integer, s = string, d = double)
            $quittanceLoyerId,
            $bailId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }
    
    public function getQuittanceLoyer(int $quittanceLoyerId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM quittances_loyer WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $quittanceLoyerId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun quittance loyer trouvé, l'ID: $quittanceLoyerId n'existe pas");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $quittanceLoyer = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $quittanceLoyer;
    }

    public function selectLastQuittanceByBailId(int $bailId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM quittances_loyer
                    WHERE bail_id = ?
                    ORDER BY id DESC LIMIT 1";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $bailId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun Type Bien trouvé");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $quittanceLoyer = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $quittanceLoyer;
    }
}