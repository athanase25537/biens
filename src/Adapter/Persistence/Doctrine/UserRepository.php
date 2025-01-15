<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\User;
use App\Port\Out\UserRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class UserRepository implements UserRepositoryInterface {
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter) {
        $this->db = $dbAdapter;
    }

    public function findByEmail(string $email): ?array {
        return $this->db->findOne(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
    }

    public function save(User $user): void
    {
        
        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];
        
       // Préparation de la requête
        $query = "INSERT INTO users (id_parrain, username, photo, email, portable, password, role, nom, prenom, is_active, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        // Initialisation de la connexion MySQLi (Assurez-vous que $mysqli est une instance valide de MySQLi)
        $stmt = $this->db->connect($config)->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->mysqli->error);
        }

        // Liaison des paramètres (type "s" pour string, "i" pour integer, "d" pour double, "b" pour blob)
        $stmt->bind_param(
            "issssssssi", // Types des paramètres (i = integer, s = string)
            $idParrain,
            $username,
            $photo,
            $email,
            $portable,
            $password,
            $role,
            $nom,
            $prenom,
            $isActive
        );

        // Assignation des valeurs
        $idParrain = $user->getParrainId();
        $username = $user->getUsername();
        $photo = $user->getPhoto();
        $email = $user->getEmail();
        $portable = $user->getPhone();
        $password = $user->getPassword();
        $role = $user->getRules();
        $nom = $user->getName();
        $prenom = $user->getFirstname();
        $isActive = $user->isActive() ? 1 : 0; // Convertir booléen en entier

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération de l'ID inséré
        $user->setId((int)$this->db->connect($config)->insert_id);

        // Fermeture du statement
        $stmt->close();

    }
}