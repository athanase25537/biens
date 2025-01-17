<?php
namespace Core\Domain\Entity;

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
}
