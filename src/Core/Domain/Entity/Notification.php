<?php

namespace App\Core\Domain\Entity;

class Notification
{
    private int $id;
    private int $userId;
    private string $typeNotification;
    private string $contenu;
    private string $statut;
    private string $tokenPortable;
    private \DateTime $dateCreation;
    private ?\DateTime $dateEnvoi;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTypeNotification(): string
    {
        return $this->typeNotification;
    }

    public function setTypeNotification(string $typeNotification): void
    {
        $this->typeNotification = $typeNotification;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function getTokenPortable(): string
    {
        return $this->tokenPortable;
    }

    public function setTokenPortable(string $tokenPortable): void
    {
        $this->tokenPortable = $tokenPortable;
    }

    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function getDateEnvoi(): ?\DateTime
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(?\DateTime $dateEnvoi): void
    {
        $this->dateEnvoi = $dateEnvoi;
    }
}
