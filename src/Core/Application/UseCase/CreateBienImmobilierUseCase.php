<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\In\CreateBienImmobilierInputPort;
use App\Port\Out\BienImmobilierRepositoryInterface;

class CreateBienImmobilierUseCase implements CreateBienImmobilierInputPort
{

    private $bienImmobilierRepository;

    public function __construct(BienImmobilierRepositoryInterface $bienImmobilierRepository)
    {
        $this->bienImmobilierRepository = $bienImmobilierRepository;
    }

    public function execute(array $data): BienImmobilier
    {
        $bienImmobilier = new BienImmobilier(
            (int)$data['proprietaire_id'],
            (int)$data['type_bien_id'],
            $data['etat_general'],
            $data['classe_energetique'],
            $data['consommation_energetique'],
            $data['emissions_ges'],
            (float)$data['taxe_fonciere'],
            (float)$data['taxe_habitation'],
            $data['orientation'],
            $data['vue'],
            $data['type_chauffage'],
            $data['statut_propriete'],
            $data['description'],
            new \DateTime($data['date_ajout']),
            new \DateTime($data['date_mise_a_jour']),
            $data['adresse'],
            $data['immeuble'],
            $data['etage'],
            $data['quartier'],
            $data['ville'],
            $data['code_postal'],
            $data['pays'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );

        $bienImmobilier = $this->bienImmobilierRepository->save($bienImmobilier);
        return $bienImmobilier;
    }
}