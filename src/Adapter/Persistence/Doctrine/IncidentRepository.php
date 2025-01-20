<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\IncidentRepositoryInterface;
use App\Core\Domain\Entity\Incident;

class IncidentRepository implements IncidentRepositoryInterface
{

    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(Incident $incident): Incident
    {
        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];
        
        $query = "INSERT INTO incidents (bien_id, bail_id, description, statut, date_signalement, date_resolution) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($config);
        $stmt = $db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
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
}