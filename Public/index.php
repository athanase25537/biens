<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Adapter\Persistence\PDOAdapter;
use App\Adapter\Persistence\Doctrine\UserRepository;

// Charger la configuration
$config = require __DIR__ . '/../config/database.php';

// Initialiser la connexion PDO
$dsn = sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']);
$pdo = new PDO($dsn, $config['user'], $config['password']);
$pdoAdapter = new PDOAdapter($pdo);

// Initialiser le UserRepository
$userRepository = new UserRepository($pdoAdapter);

// Exemple d'utilisation
$newUser = new \App\Core\Domain\Entity\User(0, 'test@example.com', 'password123', 'John Doe');
$userRepository->save($newUser);

echo "User saved!";
