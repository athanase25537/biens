<?php

namespace App\Core\Domain\Entity;

class QuittanceLoyer
{
    private int $bailId;
    private float $montant;	
    private \DateTime $dateEmission;
    private int $statut;
    private string $description;
    private int $moyenPaiement;
    private float $montantCharge;
    private float $montantImpayer;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(
        int $bailId,
        float $montant,
        \DateTime $dateEmission,
        int $statut,
        string $description,
        int $moyenPaiement,
        float $montantCharge,
        float $montantImpayer,
        \DateTime $createdAt,
        \DateTime $updatedAt,
    ) 
    {
        $this->bailId = $bailId;
        $this->montant = $montant;
        $this->dateEmission = $dateEmission;
        $this->statut = $statut;
        $this->description = $description;
        $this->moyenPaiement = $moyenPaiement;
        $this->montantCharge = $montantCharge;
        $this->montantImpayer = $montantImpayer;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters
    public function getBailId(): int 
    {
        return $this->bailId;
    }

    public function getMontant(): float 
    {
        return $this->montant;
    }

    public function getDateEmission(): \DateTime 
    {
        return $this->dateEmission;
    }

    public function getStatut(): int 
    {
        return $this->statut;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getMoyenPaiement(): int
    {
        return $this->moyenPaiement;
    }

    public function getMontantCharge(): float 
    {
        return $this->montantCharge;
    }

    public function getMontantImpayer(): float 
    {
        return $this->montantImpayer;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    // Setters
    public function setBailId(int $bailId): void 
    {
         $this->bailId = $bailId;
    }

    public function setMontant(float $montant): void
    {
        $this->montant = $montant;
    }

    public function setDateEmission(\DateTime $dateEmission): void 
    {
        $this->dateEmission = $dateEmission;
    }
    
    public function setStatut(int $statut): void 
    {
        $this->statut = $statut;
    }

    public function setDescription(string $description): void 
    {
        $this->description = $description;
    }

    public function setMoyenPaiement(int $moyenPaiement): void
    {
        $this->moyenPaiement = $moyenPaiement;
    }

    public function setMontantCharge(float $montantCharge): void 
    {
        $this->montantCharge = $montantCharge;
    }

    public function setMontantImpayer(float $montantImpayer): void 
    {
        $this->montantImpayer = $montantImpayer;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}