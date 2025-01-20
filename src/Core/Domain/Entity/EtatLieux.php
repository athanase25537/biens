<?php

namespace App\Core\Domain\Entity;

use DateTime;

class EtatLieux
{
    private int $baux_id;
    private DateTime $date;
    private int $etat_entree;
    private int $etat_sortie;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(
        int $baux_id,
        DateTime $date,
        int $etat_entree,
        int $etat_sortie,
        DateTime $created_at,
        DateTime $updated_at
    ) {
        $this->baux_id = $baux_id;
        $this->date = $date;
        $this->etat_entree = $etat_entree;
        $this->etat_sortie = $etat_sortie;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters et Setters
    public function getBauxId(): int
    {
        return $this->baux_id;
    }

    public function setBauxId(int $baux_id): void
    {
        $this->baux_id = $baux_id;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getEtatEntree(): int
    {
        return $this->etat_entree;
    }

    public function setEtatEntree(int $etat_entree): void
    {
        $this->etat_entree = $etat_entree;
    }

    public function getEtatSortie(): int
    {
        return $this->etat_sortie;
    }

    public function setEtatSortie(int $etat_sortie): void
    {
        $this->etat_sortie = $etat_sortie;
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
