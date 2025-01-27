<?php

namespace App\Adapter\Api\Rest;

use App\Adapter\Persistence\Doctrine\SignatureRepository;
use PDO;

class SignatureController
{
    private $repository;

    public function __construct(SignatureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function uploadSignature()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bauxId = $_POST['baux_id'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            $signatureFile = $_FILES['signature'] ?? null;
        
            if (!$bauxId || !$userId || !$signatureFile) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Champs manquants.']);
                exit;
            }
        
            if ($signatureFile['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload du fichier.']);
                exit;
            }
        
            $allowedMimeTypes = ['image/png', 'image/jpeg'];
            if (!in_array(mime_content_type($signatureFile['tmp_name']), $allowedMimeTypes)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Type de fichier non supporté.']);
                exit;
            }
        
            $uploadDir = __DIR__ . '/uploads/signatures/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            $fileName = uniqid() . '.' . pathinfo($signatureFile['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;
        
            if (!move_uploaded_file($signatureFile['tmp_name'], $filePath)) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde du fichier.']);
                exit;
            }
        
            $signaturePath = '/uploads/signatures/' . $fileName;
            $dateSignature = date('Y-m-d');
        
            $sql = "INSERT INTO signature (baux_id, user_id, date_signature, signature, created_at, updated_at) 
                    VALUES (:baux_id, :user_id, :date_signature, :signature, NOW(), NOW())";
        
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':baux_id', $bauxId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':date_signature', $dateSignature, PDO::PARAM_STR);
            $stmt->bindParam(':signature', $signaturePath, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Signature ajoutée avec succès.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion en base de données.']);
            }
        }
    }
}