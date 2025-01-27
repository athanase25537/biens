<<<<<<< HEAD
<?php

namespace App\Core\Domain\Entity;

class TypeBien
{

    private int $id;
    private string $type;
    private string $description;
    private \DateTime $created_at; 
    private \DateTime $updated_at; 


    public function __construct(
        string $type,
        string $description,
        \DateTime $created_at,
        \DateTime $updated_at
    ) {
        $this->type = $type;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
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

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

=======
<?php

namespace App\Core\Domain\Entity;

class TypeBien
{

    private int $id;
    private string $type;
    private string $description;
    private \DateTime $created_at; 
    private \DateTime $updated_at; 


    public function __construct(
        string $type,
        string $description,
        \DateTime $created_at,
        \DateTime $updated_at
    ) {
        $this->type = $type;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
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

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

>>>>>>> bajoh
}