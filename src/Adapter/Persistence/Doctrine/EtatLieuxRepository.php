<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\EtatLieuxRepositoryInterface;
use App\Adapter\Persistence\Doctrine\BailRepository;

class EtatLieuxRepository implements EtatLieuxRepositoryInterface
{
    private $db;
    private $bailRepository;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
        $this->bailRepository = new BailRepository($db);
    }

    public function save(EtatLieux $etatLieux): EtatLieux
    {
        $query = "INSERT INTO etat_lieux (baux_id, date, etat_entree, etat_sortie, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";

        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        
        // Assignation des valeurs à partir des données
        $bauxId = $etatLieux->getBauxId(); // Exemple: une méthode pour récupérer l'ID du bail
        $date = $etatLieux->getDate()->format('Y-m-d H:i:s'); // Conversion en chaîne au format SQL
        $etatEntree = $etatLieux->getEtatEntree(); // Exemple: une méthode pour récupérer l'état d'entrée
        $etatSortie = $etatLieux->getEtatSortie(); // Exemple: une méthode pour récupérer l'état de sortie 

        // Liaison des paramètres
        $stmt->bind_param(
            "isii", // Types des paramètres (i = integer, s = string, d = double)
            $bauxId,
            $date,
            $etatEntree,
            $etatSortie
        );
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
        
        // Fermeture du statement
        $stmt->close();
        
        return $etatLieux;
            
    }

    public function update(int $etatLieuxId, array $data): bool
    {
        $bailId = $data['baux_id'];

        $this->getEtatLieux($etatLieuxId);
        $bail = $this->bailRepository->getBail($bailId);

        $query = "UPDATE etat_lieux AS el
            INNER JOIN baux AS b ON b.id = el.baux_id
            SET 
                el.date = ?,
                el.etat_entree = ?,
                el.etat_sortie = ?,
                el.updated_at = NOW()
            WHERE el.id = ? AND b.id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs à partir des données
        $bauxId = $data['baux_id']; // Exemple: une méthode pour récupérer l'ID du bail
        $date = $data['date'];
        $etatEntree = $data['etat_entree']; // Exemple: une méthode pour récupérer l'état d'entrée
        $etatSortie = $data['etat_sortie']; // Exemple: une méthode pour récupérer l'état de sortie 
        $id = $etatLieuxId;

        // Liaison des paramètres
        $stmt->bind_param(
            "siiii", // Types des paramètres (i = integer, s = string, d = double)
            $date,
            $etatEntree,
            $etatSortie,
            $id,
            $bauxId
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            throw new \Exception("Aucun mis à jour n'a été effectuer. etat des lieux id: " . $etatLieuxId . " n'as pas un bail id: " . $bailId . " , veuillez vérifier vos informations.");
        }

        $stmt->close();
        return true;
    }

    public function getEtatLieux(int $etatLieuxId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM etat_lieux WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $etatLieuxId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun etat lieux trouvé, l'ID: $etatLieuxId n'existe pas");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $etatLieux = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $etatLieux;
    }

    public function getAllEtatLieux(int $offset): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM etat_lieux LIMIT 10 OFFSET ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $offset);

        // Assignation de la valeur du paramètre
        $id = $offset;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun etat lieux trouvé.");
        }

        // Traitement du résultat
        $etatLieux = $result->fetch_all(MYSQLI_ASSOC);

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $etatLieux;
    }

    public function destroy(int $etatLieuxId, int $bailId): bool
    {

        $this->getEtatLieux($etatLieuxId);
        $bail = $this->bailRepository->getBail($bailId);

        // Préparation de la connexion et de la requête
        $query = 'DELETE el
        FROM etat_lieux AS el 
        INNER JOIN baux AS b 
        ON b.id = el.baux_id 
        WHERE el.id = ? AND b.id = ?';

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        
        // Assignation de la valeur du paramètre
        $el_id = $etatLieuxId;
        $b_id = $bailId;

        // Liaison du paramètre
        $stmt->bind_param("ii", $el_id, $b_id);

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            throw new \Exception("Aucun etat des lieux n'a été supprimer. etat des lieux id: " . $etatLieuxId . " n'as pas un bail id: " . $bailId . " , veuillez vérifier vos informations.");
        }

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return true;       
    }
}

