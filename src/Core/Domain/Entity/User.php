<?php
namespace App\Core\Domain\Entity;

class User
{
    private $id;
    private $email;
    private $password;
    private $name;

    public function __construct(int $id, string $email, string $password, string $name)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
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
