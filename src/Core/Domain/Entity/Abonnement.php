<?php

namespace App\Core\Domain\Entity;

class Abonnement
{
    private string $nom;	
	private string $description;
	private float $prix_mensuel;	
	private float $prix_annuel;	
	private float $tva_rate;
	private int $actif;
	private \DateTime $created_at;

      // Constructeur
      public function __construct(
        string $nom,
        string $description,
        float $prix_mensuel,
        float $prix_annuel,
        float $tva_rate,
        int $actif,
        \DateTime $created_at
    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix_mensuel = $prix_mensuel;
        $this->prix_annuel = $prix_annuel;
        $this->tva_rate = $tva_rate;
        $this->actif = $actif;
        $this->created_at = $created_at;
    }

    // Getters
    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrixMensuel(): float
    {
        return $this->prix_mensuel;
    }

    public function getPrixAnnuel(): float
    {
        return $this->prix_annuel;
    }

    public function getTvaRate(): float
    {
        return $this->tva_rate;
    }

    public function getActif(): int
    {
        return $this->actif;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    // Setters
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrixMensuel(float $prix_mensuel): void
    {
        $this->prix_mensuel = $prix_mensuel;
    }

    public function setPrixAnnuel(float $prix_annuel): void
    {
        $this->prix_annuel = $prix_annuel;
    }

    public function setTvaRate(float $tva_rate): void
    {
        $this->tva_rate = $tva_rate;
    }

    public function setActif(int $actif): void
    {
        $this->actif = $actif;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}