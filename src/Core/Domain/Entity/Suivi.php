<?php

namespace App\Core\Domain\Entity;

class Suivi
{
    private int $quittance_id;
    private float $montant;
    private \DateTime $date_paiement;
    private int $statut;
    private \DateTime $created_at;
    private \DateTime $updated_at;

    // Constructeur
    public function __construct(
        int $quittance_id = null,
        float $montant = null,
        \DateTime $date_paiement = null,
        int $statut = null,
        \DateTime $created_at,
        \DateTime $updated_at
        )
    {
        $this->quittance_id = $quittance_id;
        $this->montant = $montant;
        $this->date_paiement = $date_paiement;
        $this->statut = $statut;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters et Setters
    public function getQuittanceId(): int
    {
        return $this->quittance_id;
    }

    public function setQuittanceId($quittance_id)
    {
        $this->quittance_id = $quittance_id;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    public function getDatePaiement(): \DateTime
    {
        return $this->date_paiement;
    }

    public function setDatePaiement($date_paiement)
    {
        $this->date_paiement = $date_paiement;
    }

    public function getStatut(): int
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}