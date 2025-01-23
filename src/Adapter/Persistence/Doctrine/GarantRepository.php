<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Garant;
use App\Port\Out\GarantRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class GarantRepository implements GarantRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

	public function save(Garant $Garant): Garant
    {
        $this->db->execute(
            "INSERT INTO garant_user 
            (user_id, user_id_garant) 
            VALUES (?, ?)",
            [
                $Garant->getUserId(),
                $Garant->getUserIdGarant(),
            ]
        );

        $Garant->setId((int)$this->db->lastInsertId());
        
        return $Garant;
    }

    public function update(int $idGarant, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));

        $query = "UPDATE garant_user SET $setClause, updated_at = NOW() WHERE id = ?";
        $params = array_values($data);
        $params[] = $idGarant;

        return $this->db->execute($query, $params);
    }

    public function findById(int $id): ?Garant
    {
        $row = $this->db->findOne(
            "SELECT * FROM garant_user WHERE id = ?",
            [$id]
        );

        return $row ? $this->mapToEntity($row) : null;
    }

    public function findAll(): array
    {
        $rows = $this->db->findAll(
            "SELECT * FROM garant_user"
        );

        return array_map([$this, 'mapToEntity'], $rows);
    }

    public function delete(int $id): bool
    {
    try {
        $this->db->execute("DELETE FROM garant_user WHERE id = ?", [$id]);
        return true;
    } catch (\Exception $e) {
        error_log("Erreur SQL lors de la suppression du garant : " . $e->getMessage());
        throw new \Exception("Erreur lors de la suppression du garant.");
    }
    }



    private function mapToEntity(array $row): Bail
    {
        $bail = new Bail();
        $bail->setId($row['id']);
        $bail->setGarantId($row['garant_id']);
        $bail->setBienImmobilierId($row['bien_immobilier_id']);
        $bail->setMontantLoyer($row['montant_loyer']);
        $bail->setMontantCharge($row['montant_charge']);
        $bail->setMontantCaution($row['montant_caution']);
        $bail->setEcheancePaiement($row['echeance_paiement']);
        $bail->setDateDebut(new \DateTime($row['date_debut']));
        $bail->setDateFin(new \DateTime($row['date_fin']));
        $bail->setDureePreavis($row['duree_preavis']);
        $bail->setStatut($row['statut']);
        $bail->setEngagementAttestationAssurance($row['engagement_attestation_assurance']);
        $bail->setModePaiement($row['mode_paiement']);
        $bail->setConditionsSpeciales($row['conditions_speciales']);
        $bail->setReferencesLegales($row['references_legales']);
        $bail->setIndexationAnnuelle($row['indexation_annuelle']);
        $bail->setIndiceReference($row['indice_reference']);
        $bail->setCautionRemboursee($row['caution_remboursee']);
        $bail->setDateRemboursementCaution($row['date_remboursement_caution'] ? new \DateTime($row['date_remboursement_caution']) : null);
        $bail->setCreatedAt(new \DateTime($row['created_at']));
        $bail->setUpdatedAt(new \DateTime($row['updated_at']));

        return $bail;
    }
}
