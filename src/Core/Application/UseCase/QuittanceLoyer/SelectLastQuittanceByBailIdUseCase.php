<?php

namespace App\Core\Application\UseCase\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;
use App\Port\In\QuittanceLoyer\SelectLastQuittanceByBailIdInputPort;
use App\Port\Out\QuittanceLoyerRepositoryInterface;

class SelectLastQuittanceByBailIdUseCase implements SelectLastQuittanceByBailIdInputPort
{

    private $quittanceLoyerRepository;

    public function __construct(QuittanceLoyerRepositoryInterface $quittanceLoyerRepository)
    {
        $this->quittanceLoyerRepository = $quittanceLoyerRepository;
    }

    public function execute(int $bailId): ?array
    {
        $quittanceLoyer = $this->quittanceLoyerRepository->selectLastQuittanceByBailId($bailId);

        return $quittanceLoyer;
    }
}