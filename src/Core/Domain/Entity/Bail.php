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


}
