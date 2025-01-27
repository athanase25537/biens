<?php

namespace App\Core\Domain\Entity;

class UserFacturationInfo
{
    private int $id;
    private int $user_id;
    private bool $is_pro;
    private ?string $entreprise;
    private ?string $siret;
    private ?string $adresse;
    private ?string $code_postal;
    private ?string $ville;
    private ?string $pays;
    private ?string $tva_intra;
    private \DateTime $created_at;
    private \DateTime $updated_at;

    // Constructeur
    public function __construct(
        int $id,
        int $user_id,
        bool $is_pro,
        ?string $entreprise,
        ?string $siret,
        ?string $adresse,
        ?string $code_postal,
        ?string $ville,
        ?string $pays,
        ?string $tva_intra,
        \DateTime $created_at,
        \DateTime $updated_at
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->is_pro = $is_pro;
        $this->entreprise = $entreprise;
        $this->siret = $siret;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->tva_intra = $tva_intra;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function isPro(): bool
    {
        return $this->is_pro;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function getTvaIntra(): ?string
    {
        return $this->tva_intra;
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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setIsPro(bool $is_pro): void
    {
        $this->is_pro = $is_pro;
    }

    public function setEntreprise(?string $entreprise): void
    {
        $this->entreprise = $entreprise;
    }

    public function setSiret(?string $siret): void
    {
        $this->siret = $siret;
    }

    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setCodePostal(?string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function setPays(?string $pays): void
    {
        $this->pays = $pays;
    }

    public function setTvaIntra(?string $tva_intra): void
    {
        $this->tva_intra = $tva_intra;
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
