<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;
use PDO;

class BailRepository implements BailRepositoryInterface
{
    private PDO $dbAdapter;

    public function __construct(PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function save(Bail $bail): void
    {
        $query = "INSERT INTO baux (garant_id, bien_immobilier_id, montant_loyer, montant_charge, montant_caution, echeance_paiement, date_debut, date_fin, duree_preavis, statut, engagement_attestation_assurance, mode_paiement, conditions_speciales, references_legales, indexation_annuelle, indice_reference, caution_remboursee, date_remboursement_caution, created_at, updated_at)
                  VALUES (:garant_id, :bien_immobilier_id, :montant_loyer, :montant_charge, :montant_caution, :echeance_paiement, :date_debut, :date_fin, :duree_preavis, :statut, :engagement_attestation_assurance, :mode_paiement, :conditions_speciales, :references_legales, :indexation_annuelle, :indice_reference, :caution_remboursee, :date_remboursement_caution, :created_at, :updated_at)";
        $stmt = $this->dbAdapter->prepare($query);

        $stmt->execute([
            'garant_id' => $bail->getGarantId(),
            'bien_immobilier_id' => $bail->getBienImmobilierId(),
            'montant_loyer' => $bail->getMontantLoyer(),
            'montant_charge' => $bail->getMontantCharge(),
            'montant_caution' => $bail->getMontantCaution(),
            'echeance_paiement' => $bail->getEcheancePaiement(),
            'date_debut' => $bail->getDateDebut()->format('Y-m-d'),
            'date_fin' => $bail->getDateFin()->format('Y-m-d'),
            'duree_preavis' => $bail->getDureePreavis(),
            'statut' => $bail->getStatut(),
            'engagement_attestation_assurance' => $bail->getEngagementAttestationAssurance(),
            'mode_paiement' => $bail->getModePaiement(),
            'conditions_speciales' => $bail->getConditionsSpeciales(),
            'references_legales' => $bail->getReferencesLegales(),
            'indexation_annuelle' => $bail->getIndexationAnnuelle(),
            'indice_reference' => $bail->getIndiceReference(),
            'caution_remboursee' => $bail->getCautionRemboursee(),
            'date_remboursement_caution' => $bail->getDateRemboursementCaution()?->format('Y-m-d'),
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);

        return (int)$this->dbAdapter->lastInsertId();
    }

    public function findById(int $id): ?Bail
    {
        $query = "SELECT * FROM baux WHERE id = :id";
        $stmt = $this->dbAdapter->prepare($query);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->mapToBailEntity($data);
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM baux";
        $stmt = $this->dbAdapter->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToBailEntity'], $data);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM baux WHERE id = :id";
        $stmt = $this->dbAdapter->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    private function mapToBailEntity(array $data): Bail
    {
        $bail = new Bail();
        $bail->setId($data['id']);
        $bail->setGarantId($data['garant_id']);
        $bail->setBienImmobilierId($data['bien_immobilier_id']);
        $bail->setMontantLoyer($data['montant_loyer']);
        $bail->setMontantCharge($data['montant_charge']);
        $bail->setMontantCaution($data['montant_caution']);
        $bail->setEcheancePaiement($data['echeance_paiement']);
        $bail->setDateDebut(new \DateTime($data['date_debut']));
        $bail->setDateFin(new \DateTime($data['date_fin']));
        $bail->setDureePreavis($data['duree_preavis']);
        $bail->setStatut($data['statut']);
        $bail->setEngagementAttestationAssurance($data['engagement_attestation_assurance']);
        $bail->setModePaiement($data['mode_paiement']);
        $bail->setConditionsSpeciales($data['conditions_speciales']);
        $bail->setReferencesLegales($data['references_legales']);
        $bail->setIndexationAnnuelle($data['indexation_annuelle']);
        $bail->setIndiceReference($data['indice_reference']);
        $bail->setCautionRemboursee($data['caution_remboursee']);
        $bail->setDateRemboursementCaution($data['date_remboursement_caution'] ? new \DateTime($data['date_remboursement_caution']) : null);
        $bail->setCreatedAt(new \DateTime($data['created_at']));
        $bail->setUpdatedAt(new \DateTime($data['updated_at']));

        return $bail;
    }
}