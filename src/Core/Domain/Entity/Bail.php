<?php

namespace App\Core\Domain\Entity;

class Bail
{
    private $id;
    private $garantId;
    private $bienImmobilierId;
    private int $proprietaireId;
    private $montantLoyer;
    private $montantCharge;
    private $montantCaution;
    private $echeancePaiement;
    private $dateDebut;
    private $dateFin;
    private $dureePreavis;
    private $statut;
    private $engagementAttestationAssurance;
    private $modePaiement;
    private $conditionsSpeciales;
    private $referencesLegales;
    private $indexationAnnuelle;
    private $indiceReference;
    private $cautionRemboursee;
    private $dateRemboursementCaution;
    private $createdAt;
    private $updatedAt;

    // Getters
    public function getId() { return $this->id; }
    public function getGarantId() { return $this->garantId; }
    public function getBienImmobilierId() { return $this->bienImmobilierId; }
    public function getMontantLoyer() { return $this->montantLoyer; }
    public function getMontantCharge() { return $this->montantCharge; }
    public function getMontantCaution() { return $this->montantCaution; }
    public function getEcheancePaiement() { return $this->echeancePaiement; }
    public function getDateDebut() { return $this->dateDebut; }
    public function getDateFin() { return $this->dateFin; }
    public function getDureePreavis() { return $this->dureePreavis; }
    public function getStatut() { return $this->statut; }
    public function getEngagementAttestationAssurance() { return $this->engagementAttestationAssurance; }
    public function getModePaiement() { return $this->modePaiement; }
    public function getConditionsSpeciales() { return $this->conditionsSpeciales; }
    public function getReferencesLegales() { return $this->referencesLegales; }
    public function getIndexationAnnuelle() { return $this->indexationAnnuelle; }
    public function getIndiceReference() { return $this->indiceReference; }
    public function getCautionRemboursee() { return $this->cautionRemboursee; }
    public function getDateRemboursementCaution() { return $this->dateRemboursementCaution; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    /*Notification*/
    public function getProprietaireId() { return $this->proprietaireId; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setGarantId($garantId) { $this->garantId = $garantId; }
    public function setBienImmobilierId($bienImmobilierId) { $this->bienImmobilierId = $bienImmobilierId; }
    public function setMontantLoyer($montantLoyer) { $this->montantLoyer = $montantLoyer; }
    public function setMontantCharge($montantCharge) { $this->montantCharge = $montantCharge; }
    public function setMontantCaution($montantCaution) { $this->montantCaution = $montantCaution; }
    public function setEcheancePaiement($echeancePaiement) { $this->echeancePaiement = $echeancePaiement; }
    public function setDateDebut($dateDebut) { $this->dateDebut = $dateDebut; }
    public function setDateFin($dateFin) { $this->dateFin = $dateFin; }
    public function setDureePreavis($dureePreavis) { $this->dureePreavis = $dureePreavis; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setEngagementAttestationAssurance($engagementAttestationAssurance) { $this->engagementAttestationAssurance = $engagementAttestationAssurance; }
    public function setModePaiement($modePaiement) { $this->modePaiement = $modePaiement; }
    public function setConditionsSpeciales($conditionsSpeciales) { $this->conditionsSpeciales = $conditionsSpeciales; }
    public function setReferencesLegales($referencesLegales) { $this->referencesLegales = $referencesLegales; }
    public function setIndexationAnnuelle($indexationAnnuelle) { $this->indexationAnnuelle = $indexationAnnuelle; }
    public function setIndiceReference($indiceReference) { $this->indiceReference = $indiceReference; }
    public function setCautionRemboursee($cautionRemboursee) { $this->cautionRemboursee = $cautionRemboursee; }
    public function setDateRemboursementCaution($dateRemboursementCaution) { $this->dateRemboursementCaution = $dateRemboursementCaution; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }
    
    /*Notification*/
    public function setProprietaireId($proprietaireId) { $this->proprietaireId = $proprietaireId; }
}