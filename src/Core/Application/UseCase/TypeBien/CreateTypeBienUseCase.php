<?php

namespace App\Core\Application\UseCase\TypeBien;

use App\Core\Domain\Entity\TypeBien;
use App\Port\In\CreateTypeBienInputPort;
use App\Port\Out\TypeBienRepositoryInterface;

class CreateTypeBienUseCase implements CreateTypeBienInputPort
{

    private $typeBienRepository;

    public function __construct(TypeBienRepositoryInterface $typeBienRepository)
    {
        $this->typeBienRepository = $typeBienRepository;
    }

    public function execute(array $data): TypeBien
    {
        $typeBien = new TypeBien(
            $data['type'],
            $data['description'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );

        $typeBien = $this->typeBienRepository->save($typeBien);

        return $typeBien;
    }
    
}