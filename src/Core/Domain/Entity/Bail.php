<?php
namespace App\Core\Domain\Entity;

class Bail
{
    private int $id;
    private int $garantId;
    private int $bienImmobilierId;
    private float $montantLoyer;
    private float $montantCharge;
    private float $montantCaution;
    private int $echeancePaiement;
    private \DateTime $dateDebut;
    private \DateTime $dateFin;
    private int $dureePreavis;
    private string $statut;
    private bool $engagementAttestationAssurance;
    private string $modePaiement;
    private ?string $conditionsSpeciales;
    private ?string $referencesLegales;
    private ?float $indexationAnnuelle;
    private ?string $indiceReference;
    private bool $cautionRemboursee;
    private ?\DateTime $dateRemboursementCaution;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(array $data)
    {
        $this->garantId = $data['garant_id'];
        $this->bienImmobilierId = $data['bien_immobilier_id'];
        $this->montantLoyer = $data['montant_loyer'];
        $this->montantCharge = $data['montant_charge'];
        $this->montantCaution = $data['montant_caution'];
        $this->echeancePaiement = $data['echeance_paiement'];
        $this->dateDebut = new \DateTime($data['date_debut']);
        $this->dateFin = new \DateTime($data['date_fin']);
        $this->dureePreavis = $data['duree_preavis'];
        $this->statut = $data['statut'];
        $this->engagementAttestationAssurance = $data['engagement_attestation_assurance'];
        $this->modePaiement = $data['mode_paiement'];
        $this->conditionsSpeciales = $data['conditions_speciales'] ?? null;
        $this->referencesLegales = $data['references_legales'] ?? null;
        $this->indexationAnnuelle = $data['indexation_annuelle'] ?? null;
        $this->indiceReference = $data['indice_reference'] ?? null;
        $this->cautionRemboursee = $data['caution_remboursee'];
        $this->dateRemboursementCaution = isset($data['date_remboursement_caution']) 
            ? new \DateTime($data['date_remboursement_caution']) 
            : null;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'garant_id' => $this->garantId,
            'bien_immobilier_id' => $this->bienImmobilierId,
            'montant_loyer' => $this->montantLoyer,
            'montant_charge' => $this->montantCharge,
            'montant_caution' => $this->montantCaution,
            'echeance_paiement' => $this->echeancePaiement,
            'date_debut' => $this->dateDebut->format('Y-m-d'),
            'date_fin' => $this->dateFin->format('Y-m-d'),
            'duree_preavis' => $this->dureePreavis,
            'statut' => $this->statut,
            'engagement_attestation_assurance' => $this->engagementAttestationAssurance,
            'mode_paiement' => $this->modePaiement,
            'conditions_speciales' => $this->conditionsSpeciales,
            'references_legales' => $this->referencesLegales,
            'indexation_annuelle' => $this->indexationAnnuelle,
            'indice_reference' => $this->indiceReference,
            'caution_remboursee' => $this->cautionRemboursee,
            'date_remboursement_caution' => $this->dateRemboursementCaution ? $this->dateRemboursementCaution->format('Y-m-d') : null,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
    public function setGarantId(int $garantId): void
    {
        $this->garantId = $garantId;
    }

    public function setBienImmobilierId(int $bienImmobilierId): void
    {
        $this->bienImmobilierId = $bienImmobilierId;
    }

    public function setMontantLoyer(float $montantLoyer): void
    {
        $this->montantLoyer = $montantLoyer;
    }

    public function setMontantCharge(float $montantCharge): void
    {
        $this->montantCharge = $montantCharge;
    }

    public function setMontantCaution(float $montantCaution): void
    {
        $this->montantCaution = $montantCaution;
    }

    public function setEcheancePaiement(int $echeancePaiement): void
    {
        $this->echeancePaiement = $echeancePaiement;
    }

    public function setDateDebut(\DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin(\DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function setDureePreavis(int $dureePreavis): void
    {
        $this->dureePreavis = $dureePreavis;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setEngagementAttestationAssurance(bool $engagement): void
    {
        $this->engagementAttestationAssurance = $engagement;
    }

    public function setModePaiement(string $modePaiement): void
    {
        $this->modePaiement = $modePaiement;
    }

    public function setConditionsSpeciales(?string $conditions): void
    {
        $this->conditionsSpeciales = $conditions;
    }

    public function setReferencesLegales(?string $references): void
    {
        $this->referencesLegales = $references;
    }

    public function setIndexationAnnuelle(?float $indexation): void
    {
        $this->indexationAnnuelle = $indexation;
    }

    public function setIndiceReference(?string $indice): void
    {
        $this->indiceReference = $indice;
    }

    public function setCautionRemboursee(bool $cautionRemboursee): void
    {
        $this->cautionRemboursee = $cautionRemboursee;
    }

    public function setDateRemboursementCaution(?\DateTime $date): void
    {
        $this->dateRemboursementCaution = $date;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGarantId(): int
    {
        return $this->garantId;
    }

    public function getBienImmobilierId(): int
    {
        return $this->bienImmobilierId;
    }

    public function getMontantLoyer(): float
    {
        return $this->montantLoyer;
    }

    public function getMontantCharge(): float
    {
        return $this->montantCharge;
    }

    public function getMontantCaution(): float
    {
        return $this->montantCaution;
    }

    public function getEcheancePaiement(): int
    {
        return $this->echeancePaiement;
    }

    public function getDateDebut(): \DateTime
    {
        return $this->dateDebut;
    }

    public function getDateFin(): \DateTime
    {
        return $this->dateFin;
    }

    public function getDureePreavis(): int
    {
        return $this->dureePreavis;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getEngagementAttestationAssurance(): bool
    {
        return $this->engagementAttestationAssurance;
    }

    public function getModePaiement(): string
    {
        return $this->modePaiement;
    }

    public function getConditionsSpeciales(): ?string
    {
        return $this->conditionsSpeciales;
    }

    public function getReferencesLegales(): ?string
    {
        return $this->referencesLegales;
    }

    public function getIndexationAnnuelle(): ?float
    {
        return $this->indexationAnnuelle;
    }

    public function getIndiceReference(): ?string
    {
        return $this->indiceReference;
    }

    public function getCautionRemboursee(): bool
    {
        return $this->cautionRemboursee;
    }

    public function getDateRemboursementCaution(): ?\DateTime
    {
        return $this->dateRemboursementCaution;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
