<?php

use PDO;
use App\Repositories\MySQLUserRepository;
use App\UseCases\CreateUserUseCase;
use App\Controllers\UserController;

$pdo = new PDO('mysql:host=localhost;dbname=my_database', 'username', 'password');
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
];

echo $userController->createUser($data);
