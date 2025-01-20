<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\EtatLieuxRepositoryInterface;

class EtatLieuxRepository implements EtatLieuxRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(EtatLieux $etatLieux): EtatLieux
    {
        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];

        $query = "INSERT INTO etat_lieux (baux_id, date, etat_entree, etat_sortie, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";

        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($config);
        $stmt = $db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
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

}

