<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\MySQLUserRepository;
use App\Controllers\UserController;
use App\UseCases\CreateUserUseCase;

$pdo = new PDO('mysql:host=localhost;dbname=bailonline', 'root', '');
$userRepository = new MySQLUserRepository($pdo);
$createUserUseCase = new CreateUserUseCase($userRepository);
$userController = new UserController($createUserUseCase);

// Data exemple
$data = [
    'parrain_id' => 1,
    'username' => 'athanos21',
    'photo' => 'path/to/photo.jpg',
    'email' => 'athanos@test.com',
    'phone' => '123456789',
    'password' => 'mon_mot_de_passe',
    'rules' => '',
    'name' => 'Atha',
    'firstname' => 'Nos',
    'is_active' => true,
];

echo $userController->createUser($data);
