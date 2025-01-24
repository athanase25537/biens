<?php

namespace App\Core\Domain\Entity;

class Garant
{
    private $id;
    private $userId;
    private $userIdGarant;

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getUserIdGarant() { return $this->userIdGarant; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setUserId($userId) { $this->userId = $userId; }
    public function setUserIdGarant($userIdGarant) { $this->userIdGarant = $userIdGarant; }

}