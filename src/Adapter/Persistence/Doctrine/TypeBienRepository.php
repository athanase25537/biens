<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\TypeBien;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\TypeBienRepositoryInterface;

class TypeBienRepository implements TypeBienRepositoryInterface
{
    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function save(TypeBien $typeBien): TypeBien
    {
        $query = "INSERT INTO types_bien (type, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";

        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        
        // Liaison des paramètres
        $stmt->bind_param(
            "ss", // Types des paramètres (i = integer, s = string, d = double)
            $type,
            $description,
        );
        
        // Assignation des valeurs à partir de l'objet BienImmobilier
        $type = $typeBien->getType();
        $description = $typeBien->getDescription();
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
                
        // Fermeture du statement
        $stmt->close(); 
        
        return $typeBien;
    }

    public function update(int $typeBienId, array $data): bool
    {
        $query = "UPDATE types_bien
            SET 
                type = ?,
                description = ?,
                updated_at = ?
            WHERE id = ?";
    
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs à partir des données
        $type = $data['type']; // Exemple: une méthode pour récupérer l'ID du bail
        $description = $data['description'];
        $updated_at = $data['updated_at']; // Exemple: une méthode pour récupérer l'état d'entrée
        $id = $typeBienId;

        // Liaison des paramètres
        $stmt->bind_param(
            "sssi", // Types des paramètres (i = integer, s = string, d = double)
            $type,
            $description,
            $updated_at,
            $id
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }

    public function destroy(int $typeBienId): bool
    {
        $t = $this->getTypeBien($typeBienId);
        if($t == null) {
            throw new \Exception("Ce type bien n'existe pas: ");
            return false;
        }
        // Préparation de la connexion et de la requête
        $query = 'DELETE 
        FROM types_bien
        WHERE id = ?';

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        
        // Assignation de la valeur du paramètre
        $id = $typeBienId;

        // Liaison du paramètre
        $stmt->bind_param("i",$id);

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return true;       
    }

    public function getTypeBien(int $typeBienId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM types_bien WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $typeBienId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun Type Bien trouvé, l'ID: $typeBienId n'existe pas");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $typeBien = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $typeBien;
    }

}