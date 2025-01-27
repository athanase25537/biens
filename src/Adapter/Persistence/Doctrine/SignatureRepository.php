<?php

namespace App\Adapter\Persistence\Doctrine;

use PDO;

class SignatureRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveSignature($bauxId, $userId, $dateSignature, $filePath)
    {
        $sql = "INSERT INTO signature (baux_id, user_id, date_signature, signature, created_at, updated_at)
                VALUES (:baux_id, :user_id, :date_signature, :signature, NOW(), NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':baux_id', $bauxId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':date_signature', $dateSignature, PDO::PARAM_STR);
        $stmt->bindParam(':signature', $filePath, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
