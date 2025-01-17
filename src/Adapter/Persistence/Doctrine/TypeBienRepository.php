<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\TypeBien;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\TypeBienRepositoryInterface;

class TypeBienRepository implements TypeBienRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(TypeBien $typeBien): TypeBien
    {
        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];

        $query = "INSERT INTO types_bien (type, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";

        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($config);
        $stmt = $db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
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

}