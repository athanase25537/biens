<?php

namespace App\Entities;

use DateTime;

class User
{
    private int $id;
    private int $parrain_id;
    private string $username;
    private string $photo;
    private string $email;
    private string $phone;
    private string $password;
    private string $rules;
    private string $name;
    private string $firstname;
    private bool $is_active;
    private DateTime $last_login;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(
        int $parrain_id,
        string $username,
        string $photo,
        string $email,
        string $phone,
        string $password,
        string $rules,
        string $name,
        string $firstname
    ) {
        $this->parrain_id = $parrain_id;
        $this->username = $username;
        $this->photo = $photo;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->rules = $rules;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->is_active = false;
        $this->last_login = new DateTime();
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    // Getters and setters

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getParrainId(): int
    {
        return $this->parrain_id;
    }

    public function setParrainId(int $parrain_id): void
    {
        $this->parrain_id = $parrain_id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getRules(): string
    {
        return $this->rules;
    }

    public function setRules(string $rules): void
    {
        $this->rules = $rules;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    public function getLastLogin(): DateTime
    {
        return $this->last_login;
    }

    public function setLastLogin(DateTime $last_login): void
    {
        $this->last_login = $last_login;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}