<?php

namespace App\Core\Domain\Entity;

class Media
{
    private int $id;
    private int $bienId;
    private ?int $etatLieuxItemsId;
    private ?int $incidentsId;
    private string $type;
    private string $url; // Le chemin ou l'URL du fichier
    private ?string $description;
    private ?string $position;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

}
