<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\IncidentRepositoryInterface;
use App\Core\Domain\Entity\Incident;

class IncidentRepository implements IncidentRepositoryInterface
{

    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function save(Incident $incident): Incident
    {
        $query = "INSERT INTO incidents (bien_id, bail_id, description, statut, date_signalement, date_resolution) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        

        // Assignation des valeurs à partir de l'objet Incident
        $bien_id = $incident->getBienId();
        $bail_id = $incident->getBailId();
        $description = $incident->getDescription();
        $statut = $incident->getStatut();
        $date_signalement = $incident->getDateSignalement()->format('Y-m-d H:i:s');
        $date_resolution = $incident->getDateResolution()->format('Y-m-d H:i:s');;
        
        // Liaison des paramètres
        $stmt->bind_param(
            "iissss", // Types des paramètres (i = integer, s = string)
            $bien_id,
            $bail_id,
            $description,
            $statut,
            $date_signalement,
            $date_resolution
        );
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
        
        // Fermeture du statement
        $stmt->close();
        
        return $incident;     
    }

    public function update(int $incidentId, array $data): bool 
    {
        $query = "UPDATE incidents AS inc
            INNER JOIN biens_immobiliers AS bi ON bi.id = inc.bien_id
            INNER JOIN baux AS b ON b.id = inc.bail_id
            SET 
                inc.bien_id = ?,
                inc.bail_id = ?,
                inc.description = ?,
                inc.statut = ?,
                inc.date_signalement = ?,
                inc.date_resolution = ?
            WHERE inc.id = ? AND bi.id = ? AND b.id = ?";

        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs à partir des données
        $bien_id = $data['bien_id'];
        $bail_id = $data['bail_id'];
        $description = $data['description'];
        $statut = $data['statut'];
        $date_signalement = $data['date_signalement'];
        $date_resolution = $data['date_resolution'];
        $inc_id = $incidentId;

        // Liaison des paramètres
        $stmt->bind_param(
            "iissssiii", // Types des paramètres (i = integer, s = string, d = double)
            $bien_id,
            $bail_id,
            $description,
            $statut,
            $date_signalement,
            $date_resolution,
            $inc_id,
            $bien_id,
            $bail_id
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            throw new \Exception("Aucun mis à jour n'a été effectuer.\nIncident id: {$incidentId} ne possede pas un bail id: {$data['bail_id']} et/ou un bien id: {$data['bien_id']}.\nVeuillez vérifier vos informations.");
        }

        $stmt->close();

        return true;
    }

    public function destroy(int $incidentId, int $bienId, int $bailId): bool 
    {
        $query = "DELETE inc
            FROM incidents AS inc
            INNER JOIN biens_immobiliers AS bi ON bi.id = inc.bien_id
            INNER JOIN baux AS b ON b.id = inc.bail_id
            WHERE inc.id = ? AND bi.id = ? AND b.id = ?";

        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison des paramètres
        $stmt->bind_param(
            "iii", // Types des paramètres (i = integer, s = string, d = double)
            $incidentId,
            $bienId,
            $bailId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            throw new \Exception("Aucun incident n'a été supprimer.\nIncident id: {$incidentId} ne possede pas un bail id: {$bailId} et/ou un bien id: {$bienId}.\nVeuillez vérifier vos informations.");
        }

        $stmt->close();

        return true;
    }
    
    public function getIncident(int $incidentId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM incidents WHERE id = ?";

        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $incidentId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun incident trouvé, l'ID: $incidentId n'existe pas");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $incident = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $incident;
    }

    public function getAllIncident(int $offset): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM incidents LIMIT 10 OFFSET ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $offset);

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun incident trouvé.");
        }

        // Traitement du résultat
        $incident = $result->fetch_all(MYSQLI_ASSOC);

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $incident;
    }
}