<?php

namespace App\Core\Application\Service;

use App\Core\Domain\Entity\HistoriqueModification;
use App\Adapter\Persistence\Doctrine\HistoriqueModificationRepository;

class HistoriqueService
{
    private HistoriqueModificationRepository $repository;

    public function __construct(HistoriqueModificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function enregistrerModification(
        string $tableCible,
        int $cibleId,
        int $userId,
        string $typeModification,
        ?string $details = null
    ): void {
        $historique = new HistoriqueModification(
            $tableCible,
            $cibleId,
            $userId,
            $typeModification,
            $details
        );

        $this->repository->save($historique);
    }
}
