<?php

namespace App\Core\Application\UseCase\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;
use App\Port\In\QuittanceLoyer\CreateQuittanceLoyerInputPort;
use App\Port\Out\QuittanceLoyerRepositoryInterface;

class CreateQuittanceLoyerUseCase implements CreateQuittanceLoyerInputPort
{
    private $quittanceLoyerRepository;

    public function __construct(QuittanceLoyerRepositoryInterface $quittanceLoyerRepository)
    {
        $this->quittanceLoyerRepository = $quittanceLoyerRepository;
    }

    public function execute(array $data): QuittanceLoyer
    {
        $quittanceLoyer = new QuittanceLoyer(
            $data['bail_id'],
            $data['montant'],
            new \DateTime($data['date_emission']),	
            $data['statut'],
            $data['description']	,
            $data['moyen_paiement'],
            $data['montant_charge'],
            $data['montant_impayer'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at']),
        );

        $quittanceLoyer = $this->quittanceLoyerRepository->save($quittanceLoyer);
        
        return $quittanceLoyer;
    }
}