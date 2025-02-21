<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\User;
use App\Port\Out\UserRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class UserRepository implements UserRepositoryInterface 
{
    
    private $db;
    public function __construct(\mysqli $db) 
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?array 
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        $stmt->close();
    
        return $user ?: null;
    }

    public function save(User $user): User
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

        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
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
        $lastInsertedId = $this->db->insert_id;
        $user->setId((int)$lastInsertedId);

        // Fermeture du statement
        $stmt->close();

        return $user;
    }

}