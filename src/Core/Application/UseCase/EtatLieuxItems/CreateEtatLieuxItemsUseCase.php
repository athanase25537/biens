<?php

namespace App\Core\Application\UseCaseEtatLieuxItems;

use App\Port\Out\EtatLieuxItemsRepositoryInterface;
use App\Port\In\CreateEtatLieuxItemsInputPort;
use App\Core\Domain\Entity\EtatLieuxItems;

class CreateEtatLieuxItemsUseCase implements CreateEtatLieuxItemsInputPort
{

    private $etatLieuxRepository;

    public function __construct(EtatLieuxItemsRepositoryInterface $etatLieuxRepository)
    {
        $this->etatLieuxRepository = $etatLieuxRepository;
    }

    public function execute(array $data): EtatLieuxItems
    {
        $etatLieuxItems = new EtatLieuxItems(
            (int) $data['etat_lieux_id'],
            $data['titre'],
            (int) $data['etat'],
            (int) $data['plinthes'],
            (int) $data['murs'],
            (int) $data['sol'],
            (int) $data['plafond'],
            (int) $data['portes'],
            (int) $data['huisseries'],
            (int) $data['radiateurs'],
            (int) $data['placards'],
            (int) $data['aerations'],
            (int) $data['interrupteurs'],
            (int) $data['prises_electriques'],
            (int) $data['tableau_electrique'],
            isset($data['description']) ? $data['description'] : null
        );     
        
        $etatLieuxItems = $this->etatLieuxRepository->save($etatLieuxItems);

        return $etatLieuxItems;

    }
}