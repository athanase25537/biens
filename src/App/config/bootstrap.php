<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Repositories\MySQLUserRepository;
use App\Controllers\UserController;
use App\UseCases\CreateUserUseCase;

$pdo = new PDO('mysql:host=170.187.150.177;dbname=bailonline', 'bailonline', '3NEeZuRailVisKB7V2Gr');
$userRepository = new MySQLUserRepository($pdo);
$createUserUseCase = new CreateUserUseCase($userRepository);
$userController = new UserController($createUserUseCase);

// Data exemple
$data = [
    'parrain_id' => 1,
    'username' => 'Bajoh',
    'photo' => 'path/to/photo.jpg',
    'email' => 'bajoh@test.com',
    'phone' => '123456789',
    'password' => 'mon_mot_de_passe',
    'rules' => 'user',
    'name' => 'Baina',
    'firstname' => 'Josh',
    'is_active' => 0,
];

echo $userController->createUser($data);
