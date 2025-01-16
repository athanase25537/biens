<?php
namespace Core\Domain\Entity;

class Signature
{
    private int $id;
    private int $bauxId;
    private int $userId;
    private \DateTime $dateSignature;
    private string $signature;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    // Ajoute ici les getters, setters et méthodes métier
}
