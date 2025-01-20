<?php

namespace App\Core\Domain\Entity;

class Incident
{
    private int $bien_id;
    private int $bail_id;
    private string $description;
    private string $statut;
    private ?\DateTime $date_signalement;
    private ?\DateTime $date_resolution;

    // Constructeur
    public function __construct(
        int $bien_id,
        int $bail_id,
        string $description,
        string $statut,
        ?\DateTime $date_signalement = null,
        ?\DateTime $date_resolution = null
    ) {
        $this->bien_id = $bien_id;
        $this->bail_id = $bail_id;
        $this->description = $description;
        $this->statut = $statut;
        $this->date_signalement = $date_signalement;
        $this->date_resolution = $date_resolution;
    }

    // Méthodes getter
    public function getBienId(): int {
        return $this->bien_id;
    }

    public function getBailId(): int {
        return $this->bail_id;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function getDateSignalement(): ?\DateTime {
        return $this->date_signalement;
    }

    public function getDateResolution(): ?\DateTime {
        return $this->date_resolution;
    }

    // Méthodes setter
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

    public function setDateSignalement(?\Datetime $date_signalement): void {
        $this->date_signalement = $date_signalement;
    }

    public function setDateResolution(?\DateTime $date_resolution): void {
        $this->date_resolution = $date_resolution;
    }
}