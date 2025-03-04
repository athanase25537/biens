<?php

namespace App\Core\Application\UseCase\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;
use App\Port\In\QuittanceLoyer\DeleteQuittanceLoyerInputPort;
use App\Port\Out\QuittanceLoyerRepositoryInterface;

class DeleteQuittanceLoyerUseCase implements DeleteQuittanceLoyerInputPort
{

    private $quittanceLoyerRepository;

    public function __construct(QuittanceLoyerRepositoryInterface $quittanceLoyerRepository)
    {
        $this->quittanceLoyerRepository = $quittanceLoyerRepository;
    }

    public function execute(int $quittanceLoyerId, int $bailId): void
    {
        $this->quittanceLoyerRepository->destroy($quittanceLoyerId, $bailId);
    }
}