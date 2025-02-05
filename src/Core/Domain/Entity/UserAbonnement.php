<?php

namespace App\Core\Domain\Entity;

class UserAbonnement
{
    private int $id;
    private int $user_id;
    private int $abonnement_id;
    private ?int $payments_id;
    private int $type_formule;
    private float $prix_ht;
    private float $tva_rate;
    private float $montant_tva;
    private float $montant_ttc;
    private \DateTime $date_acquisition;
    private \DateTime $date_expiration;
    private string $statut;
    private ?string $suivi;
    private \DateTime $created_at;
    private \DateTime $updated_at;

    // Constructeur
    public function __construct(
        int $user_id,
        int $abonnement_id,
        ?int $payments_id,
        int $type_formule,
        float $prix_ht,
        float $tva_rate,
        float $montant_tva,
        float $montant_ttc,
        \DateTime $date_acquisition,
        \DateTime $date_expiration,
        string $statut,
        ?string $suivi,
        \DateTime $created_at,
        \DateTime $updated_at
    ) {
        $this->user_id = $user_id;
        $this->abonnement_id = $abonnement_id;
        $this->payments_id = $payments_id;
        $this->type_formule = $type_formule;
        $this->prix_ht = $prix_ht;
        $this->tva_rate = $tva_rate;
        $this->montant_tva = $montant_tva;
        $this->montant_ttc = $montant_ttc;
        $this->date_acquisition = $date_acquisition;
        $this->date_expiration = $date_expiration;
        $this->statut = $statut;
        $this->suivi = $suivi;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAbonnementId(): int
    {
        return $this->abonnement_id;
    }

    public function getPaymentsId(): ?int
    {
        return $this->payments_id;
    }

    public function getTypeFormule(): int
    {
        return $this->type_formule;
    }

    public function getPrixHt(): float
    {
        return $this->prix_ht;
    }

    public function getTvaRate(): float
    {
        return $this->tva_rate;
    }

    public function getMontantTva(): float
    {
        return $this->montant_tva;
    }

    public function getMontantTtc(): float
    {
        return $this->montant_ttc;
    }

    public function getDateAcquisition(): \DateTime
    {
        return $this->date_acquisition;
    }

    public function getDateExpiration(): \DateTime
    {
        return $this->date_expiration;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getSuivi(): ?string
    {
        return $this->suivi;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    // Setters

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setAbonnementId(int $abonnement_id): void
    {
        $this->abonnement_id = $abonnement_id;
    }

    public function setPaymentsId(?int $payments_id): void
    {
        $this->payments_id = $payments_id;
    }

    public function setTypeFormule(int  $type_formule): void
    {
        $this->type_formule = $type_formule;
    }
 
    public function setPrixHt(float $prix_ht): void
    {
        $this->prix_ht = $prix_ht;
    }

    public function setTvaRate(float $tva_rate): void
    {
        $this->tva_rate = $tva_rate;
    }

    public function setMontantTva(float $montant_tva): void
    {
        $this->montant_tva = $montant_tva;
    }

    public function setMontantTtc(float $montant_ttc): void
    {
        $this->montant_ttc = $montant_ttc;
    }

    public function setDateAcquisition(\DateTime $date_acquisition): void
    {
        $this->date_acquisition = $date_acquisition;
    }

    public function setDateExpiration(\DateTime $date_expiration): void
    {
        $this->date_expiration = $date_expiration;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setSuivi(?string $suivi): void
    {
        $this->suivi = $suivi;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
