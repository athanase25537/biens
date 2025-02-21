<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Garant;
use App\Port\Out\GarantRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class GarantRepository implements GarantRepositoryInterface
{
    private $db;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

	public function save(Garant $Garant): Garant
    {
        $this->db->execute(
            "INSERT INTO garant_user 
            (user_id, user_id_garant) 
            VALUES (?, ?)",
            [
                $Garant->getUserId(),
                $Garant->getUserIdGarant(),
            ]
        );

        $Garant->setId((int)$this->db->lastInsertId());
        
        return $Garant;
    }

    public function update(int $idGarant, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));

        $query = "UPDATE garant_user SET $setClause WHERE id = ?";
        $params = array_values($data);
        $params[] = $idGarant;

        return $this->db->execute($query, $params);
    }

    public function findById(int $id): ?Garant
    {
        $row = $this->db->findOne(
            "SELECT * FROM garant_user WHERE id = ?",
            [$id]
        );

        return $row ? $this->mapToEntity($row) : null;
    }

    public function findAll(): array
    {
        $rows = $this->db->findAll(
            "SELECT * FROM garant_user"
        );

        return array_map([$this, 'mapToEntity'], $rows);
    }

    public function delete(int $id): bool
    {
    try {
        $this->db->execute("DELETE FROM garant_user WHERE id = ?", [$id]);
        return true;
    } catch (\Exception $e) {
        error_log("Erreur SQL lors de la suppression du garant : " . $e->getMessage());
        throw new \Exception("Erreur lors de la suppression du garant.");
    }
    }



    private function mapToEntity(array $row): Garant
    {
        $garant = new Garant();
        $garant->setId($row['id']);
        $garant->setUserId($row['user_id']);
        $garant->setUserIdGarant($row['user_id_garant']);

        return $garant;
    }
}
