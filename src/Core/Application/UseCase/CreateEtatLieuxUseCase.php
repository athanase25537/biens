<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\In\CreateEtatLieuxInputPort;
use App\Port\Out\EtatLieuxRepositoryInterface;

class CreateEtatLieuxUseCase implements CreateEtatLieuxInputPort
{

    private $etatLieuxRepository;

    public function __construct(EtatLieuxRepositoryInterface $etatLieuxRepository)
    {
        $this->etatLieuxRepository = $etatLieuxRepository;
    }

    public function execute(array $data): EtatLieux
    {
        $etatLieux = new EtatLieux(
            (int)$data['baux_id'],
            new \DateTime($data['date']),
            $data['etat_entree'],
            $data['etat_sortie'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at']),
        );

        $etatLieux = $this->etatLieuxRepository->save($etatLieux);

        return $etatLieux;

    }
}