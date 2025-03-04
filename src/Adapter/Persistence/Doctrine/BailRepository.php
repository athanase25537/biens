<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class BailRepository implements BailRepositoryInterface
{
    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

	public function save(Bail $bail): Bail
    {
        $this->db->execute(
            "INSERT INTO baux 
            (garant_id, bien_immobilier_id, montant_loyer, montant_charge, montant_caution, 
            echeance_paiement, date_debut, date_fin, duree_preavis, statut, engagement_attestation_assurance, 
            mode_paiement, conditions_speciales, references_legales, indexation_annuelle, indice_reference, 
            caution_remboursee, date_remboursement_caution, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $bail->getGarantId(),
                $bail->getBienImmobilierId(),
                $bail->getMontantLoyer(),
                $bail->getMontantCharge(),
                $bail->getMontantCaution(),
                $bail->getEcheancePaiement(),
                $bail->getDateDebut()->format('Y-m-d'),
                $bail->getDateFin()->format('Y-m-d'),
                $bail->getDureePreavis(),
                $bail->getStatut(),
                $bail->getEngagementAttestationAssurance(),
                $bail->getModePaiement(),
                $bail->getConditionsSpeciales(),
                $bail->getReferencesLegales(),
                $bail->getIndexationAnnuelle(),
                $bail->getIndiceReference(),
                $bail->getCautionRemboursee(),
                $bail->getDateRemboursementCaution() ? $bail->getDateRemboursementCaution()->format('Y-m-d') : null
            ]
        );

        $bail->setId((int)$this->db->lastInsertId());
        
        return $bail;
    }

    public function update(int $idBail, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));

        $query = "UPDATE baux SET $setClause, updated_at = NOW() WHERE id = ?";
        $params = array_values($data);
        $params[] = $idBail;

        return $this->db->execute($query, $params);
    }

    public function findById(int $id): ?Bail
    {
        $row = $this->db->findOne(
            "SELECT * FROM baux WHERE id = ?",
            [$id]
        );

        return $row ? $this->mapToEntity($row) : null;
    }

    public function findAll(): array
    {
        $rows = $this->db->findAll(
            "SELECT * FROM baux"
        );

        return array_map([$this, 'mapToEntity'], $rows);
    }

    public function delete(int $id): bool
    {
    try {
        $this->db->execute("DELETE FROM baux WHERE id = ?", [$id]);
        return true;
    } catch (\Exception $e) {
        error_log("Erreur SQL lors de la suppression du bail : " . $e->getMessage());
        throw new \Exception("Erreur lors de la suppression du bail.");
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

        $bail->setProprietaireId($row['garant_id']);

        return $bail;
    }

    public function getAllBail(int $offset)
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM baux LIMIT 10 OFFSET ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $offset);

        // Assignation de la valeur du paramètre
        $id = $offset;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun bail trouvé.");
        }

        // Traitement du résultat
        $baux = $result->fetch_all(MYSQLI_ASSOC);

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $baux;
    }

    public function getBail(int $bailId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM baux WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $bailId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun bail trouvé, l'ID: $bailId n'existe pas");
        }

        // Traitement du résultat
        $bail = $result->fetch_assoc();

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $bail;
    }
}
