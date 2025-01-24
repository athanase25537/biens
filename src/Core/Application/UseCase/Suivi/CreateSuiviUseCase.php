<?php

namespace App\Core\Application\UseCase\Suivi;

use App\Core\Domain\Entity\Suivi;
use App\Port\In\Suivi\CreateSuiviInputPort;
use App\Port\Out\SuiviRepositoryInterface;

class CreateSuiviUseCase implements CreateSuiviInputPort
{
    private $suiviRepository;

    public function __construct(SuiviRepositoryInterface $suiviRepository)
    {
        $this->suiviRepository = $suiviRepository;
    }

    public function execute(array $data): Suivi
    {
        $suivi = new Suivi(
            $data['quittance_id'],
            $data['montant'],
            new \DateTime($data['date_paiement']),	
            $data['statut'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at']),
        );

        $suivi = $this->suiviRepository->save($suivi);
        
        return $suivi;
    }
}