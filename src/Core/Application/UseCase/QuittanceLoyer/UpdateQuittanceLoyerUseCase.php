<?php

namespace App\Core\Application\UseCase\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;
use App\Port\In\QuittanceLoyer\UpdateQuittanceLoyerInputPort;
use App\Port\Out\QuittanceLoyerRepositoryInterface;

class UpdateQuittanceLoyerUseCase implements UpdateQuittanceLoyerInputPort
{

    private $quittanceLoyerRepository;

    public function __construct(QuittanceLoyerRepositoryInterface $quittanceLoyerRepository)
    {
        $this->quittanceLoyerRepository = $quittanceLoyerRepository;
    }

    public function execute(int $quittanceLoyerId, array $data): ?array
    {
        $update = $this->quittanceLoyerRepository->update($quittanceLoyerId, $data);
        return ($update) ? $this->quittanceLoyerRepository->getQuittanceLoyer($quittanceLoyerId) : null;
    }
}
