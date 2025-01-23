<?php

namespace App\Core\Domain\Entity;

class Media
{
    private $id;
    private $bienId;
    private $etatLieuxItemsId;
    private $incidentsId;
    private $type;
    private $url;
    private $description;
    private $position;
    private $createdAt;
    private $updatedAt;
  	private $name;

    // Getters et setters pour chaque propriété
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getBienId(): ?int { return $this->bienId; }
    public function setBienId(?int $bienId): void { $this->bienId = $bienId; }

    public function getEtatLieuxItemsId(): ?int { return $this->etatLieuxItemsId; }
    public function setEtatLieuxItemsId(?int $etatLieuxItemsId): void { $this->etatLieuxItemsId = $etatLieuxItemsId; }

    public function getIncidentsId(): ?int { return $this->incidentsId; }
    public function setIncidentsId(?int $incidentsId): void { $this->incidentsId = $incidentsId; }

    public function getType(): string { return $this->type; }
    public function setType(string $type): void { $this->type = $type; }

    public function getUrl(): string { return $this->url; }
    public function setUrl(string $url): void { $this->url = $url; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getPosition(): ?int { return $this->position; }
    public function setPosition(?int $position): void { $this->position = $position; }

    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): void { $this->createdAt = $createdAt; }

    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }
    public function setUpdatedAt(\DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }
    
  	public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
}
