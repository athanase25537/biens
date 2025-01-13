<?php

namespace App\Core\Domain\Entity;

class User
{
    private ?int $id;
    private ?int $idParrain;
    private ?string $username;
    private ?string $photo;
    private string $email;
    private string $portable;
    private string $password;
    private ?string $role;
    private ?string $nom;
    private ?string $prenom;
    private bool $isActive;
    private ?\DateTime $lastLogin;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(
        ?int $id,
        string $email,
        string $password,
        string $portable,
        ?string $nom = null,
        ?string $prenom = null,
        ?string $role = 'user',
        bool $isActive = false,
        ?\DateTime $lastLogin = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->portable = $portable;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->lastLogin = $lastLogin;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->updatedAt = $updatedAt ?? new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
