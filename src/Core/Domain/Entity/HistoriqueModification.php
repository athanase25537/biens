<?php

namespace App\Core\Domain\Entity;

class HistoriqueModification
{
    private ?int $id;
    private string $tableCible;
    private int $cibleId;
    private int $userId;
    private string $typeModification;
    private ?string $details;
    private \DateTime $dateModification;

    public function __construct(
        string $tableCible,
        int $cibleId,
        int $userId,
        string $typeModification,
        ?string $details
    ) {
        $this->tableCible = $tableCible;
        $this->cibleId = $cibleId;
        $this->userId = $userId;
        $this->typeModification = $typeModification;
        $this->details = $details;
        $this->dateModification = new \DateTime();
    }

	public function getTableCible(): string
    {
        return $this->tableCible;
    }

    public function getCibleId(): int
    {
        return $this->cibleId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTypeModification(): string
    {
        return $this->typeModification;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }
}
