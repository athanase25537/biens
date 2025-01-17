<?php
namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;

class BailRepository implements BailRepositoryInterface
{
    private $dbAdapter;

    public function __construct($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function save(Bail $bail): int
    {
        $query = "INSERT INTO baux (garant_id, bien_immobilier_id, montant_loyer, montant_charge, montant_caution, echeance_paiement, date_debut, date_fin, duree_preavis, statut, engagement_attestation_assurance, mode_paiement, conditions_speciales, references_legales, indexation_annuelle, indice_reference, caution_remboursee, date_remboursement_caution, created_at, updated_at)
                  VALUES (:garant_id, :bien_immobilier_id, :montant_loyer, :montant_charge, :montant_caution, :echeance_paiement, :date_debut, :date_fin, :duree_preavis, :statut, :engagement_attestation_assurance, :mode_paiement, :conditions_speciales, :references_legales, :indexation_annuelle, :indice_reference, :caution_remboursee, :date_remboursement_caution, NOW(), NOW())";

        $stmt = $this->dbAdapter->prepare($query);
        $stmt->execute($bail->toArray());

        return $this->dbAdapter->lastInsertId();
    }
}
