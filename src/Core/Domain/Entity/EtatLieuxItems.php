<?php

namespace App\Core\Domain\Entity;

use DateTime;

class EtatLieuxItems
{
    private int $id;
    private int $etat_lieux_id;
    private string $titre;
    private int $etat;
    private int $plinthes;
    private int $murs;
    private int $sol;
    private int $plafond;
    private int $portes;
    private int $huisseries;
    private int $radiateurs;
    private int $placards;
    private int $aerations;
    private int $interrupteurs;
    private int $prises_electriques;
    private int $tableau_electrique;
    private ?string $description;

    public function __construct(
        int $etat_lieux_id,
        string $titre,
        int $etat,
        int $plinthes,
        int $murs,
        int $sol,
        int $plafond,
        int $portes,
        int $huisseries,
        int $radiateurs,
        int $placards,
        int $aerations,
        int $interrupteurs,
        int $prises_electriques,
        int $tableau_electrique,
        ?string $description
    ) {
        $this->etat_lieux_id = $etat_lieux_id;
        $this->titre = $titre;
        $this->etat = $etat;
        $this->plinthes = $plinthes;
        $this->murs = $murs;
        $this->sol = $sol;
        $this->plafond = $plafond;
        $this->portes = $portes;
        $this->huisseries = $huisseries;
        $this->radiateurs = $radiateurs;
        $this->placards = $placards;
        $this->aerations = $aerations;
        $this->interrupteurs = $interrupteurs;
        $this->prises_electriques = $prises_electriques;
        $this->tableau_electrique = $tableau_electrique;
        $this->description = $description;
    }

    // Getters et Setters
    public function getId(): int { return $this->id; }
    public function getEtatLieuxId(): int { return $this->etat_lieux_id; }
    public function getTitre(): string { return $this->titre; }
    public function getEtat(): int { return $this->etat; }
    public function getPlinthes(): int { return $this->plinthes; }
    public function getMurs(): int { return $this->murs; }
    public function getSol(): int { return $this->sol; }
    public function getPlafond(): int { return $this->plafond; }
    public function getPortes(): int { return $this->portes; }
    public function getHuisseries(): int { return $this->huisseries; }
    public function getRadiateurs(): int { return $this->radiateurs; }
    public function getPlacards(): int { return $this->placards; }
    public function getAerations(): int { return $this->aerations; }
    public function getInterrupteurs(): int { return $this->interrupteurs; }
    public function getPrisesElectriques(): int { return $this->prises_electriques; }
    public function getTableauElectrique(): int { return $this->tableau_electrique; }
    public function getDescription(): ?string { return $this->description; }
    

    public function setId(int $id): void { $this->id = $id; }
    public function setEtatLieuxId(int $etat_lieux_id): void { $this->etat_lieux_id = $etat_lieux_id; }
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function setEtat(int $etat): void { $this->etat = $etat; }
    public function setPlinthes(int $plinthes): void { $this->plinthes = $plinthes; }
    public function setMurs(int $murs): void { $this->murs = $murs; }
    public function setSol(int $sol): void { $this->sol = $sol; }
    public function setPlafond(int $plafond): void { $this->plafond = $plafond; }
    public function setPortes(int $portes): void { $this->portes = $portes; }
    public function setHuisseries(int $huisseries): void { $this->huisseries = $huisseries; }
    public function setRadiateurs(int $radiateurs): void { $this->radiateurs = $radiateurs; }
    public function setPlacards(int $placards): void { $this->placards = $placards; }
    public function setAerations(int $aerations): void { $this->aerations = $aerations; }
    public function setInterrupteurs(int $interrupteurs): void { $this->interrupteurs = $interrupteurs; }
    public function setPrisesElectriques(int $prises_electriques): void { $this->prises_electriques = $prises_electriques; }
    public function setTableauElectrique(int $tableau_electrique): void { $this->tableau_electrique = $tableau_electrique; }
    public function setDescription(?string $description): void { $this->description = $description; }
}
