<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;
use App\Core\Application\Service\HistoriqueService;

class AddBailUseCase
{
    private BailRepositoryInterface $bailRepository;
  	private HistoriqueService $historiqueService;

    public function __construct(BailRepositoryInterface $bailRepository, HistoriqueService $historiqueService)
    {
        $this->bailRepository = $bailRepository;
      	$this->historiqueService = $historiqueService;
    }

    /*public function execute(Bail $bail): Bail
    {
        return $this->bailRepository->save($bail);
    }*/
      public function execute(Bail $bail, int $userId): Bail
    {
        $savedBail = $this->bailRepository->save($bail);

        $this->historiqueService->enregistrerModification(
            'bail',
            $savedBail->getId(),
            $userId,     
            'création',
            json_encode([
                'garant_id' => $savedBail->getGarantId(),
                'bien_immobilier_id' => $savedBail->getBienImmobilierId(),                
              	'montant_loyer' => $savedBail->getMontantLoyer(),
              	'montant_charge' => $savedBail->getMontantCharge(),
              	'montant_caution' => $savedBail->getMontantCaution(),
              	'echeance_paiement' => $savedBail->getEcheancePaiement(),
              	'date_debut' => $savedBail->getDateDebut()->format('Y-m-d'),
              	'date_fin' => $savedBail->getDateFin()->format('Y-m-d'),
              	'duree_preavis' => $savedBail->getDureePreavis(),
              	'statut' => $savedBail->getStatut(),
              	'engagement_attestation_assurance' => $savedBail->getEngagementAttestationAssurance(),
              	'mode_paiement' => $savedBail->getModePaiement(),
              	'conditions_speciales' => $savedBail->getConditionsSpeciales(),	
              	'references_legales' => $savedBail->getReferencesLegales(),
              	'indexation_annuelle' => $savedBail->getIndexationAnnuelle(),	
              	'indice_reference' => $savedBail->getIndiceReference(),
              	'caution_remboursee' => $savedBail->getCautionRemboursee(),
              	'date_remboursement_caution' => $savedBail->getDateRemboursementCaution() ? $bail->getDateRemboursementCaution()->format('Y-m-d') : null
            ])
        );

        return $savedBail;
    }
}
