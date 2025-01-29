<?php

namespace App\Core\Domain\Entity;

use DateTime;

class BienImmobilier
{
    private int $proprietaire_id;
    private int $type_bien_id;
    private string $etat_general;
    private string $classe_energetique;
    private string $consommation_energetique;
    private string $emissions_ges;
    private float $taxe_fonciere;
    private float $taxe_habitation;
    private string $orientation;
    private string $vue;
    private string $type_chauffage;
    private string $statut_propriete;
    private string $description;
    private DateTime $date_ajout;
    private DateTime $date_mise_a_jour;
    private string $adresse;
    private string $immeuble;
    private string $etage;
    private string $quartier;
    private string $ville;
    private string $code_postal;
    private string $pays;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(
        int $proprietaire_id,
        int $type_bien_id,
        string $etat_general,
        string $classe_energetique,
        string $consommation_energetique,
        string $emissions_ges,
        float $taxe_fonciere,
        float $taxe_habitation,
        string $orientation,
        string $vue,
        string $type_chauffage,
        string $statut_propriete,
        string $description,
        DateTime $date_ajout,
        DateTime $date_mise_a_jour,
        string $adresse,
        string $immeuble,
        string $etage,
        string $quartier,
        string $ville,
        string $code_postal,
        string $pays,
        DateTime $created_at,
        DateTime $updated_at
    ) {
        $this->proprietaire_id = $proprietaire_id;
        $this->type_bien_id = $type_bien_id;
        $this->etat_general = $etat_general;
        $this->classe_energetique = $classe_energetique;
        $this->consommation_energetique = $consommation_energetique;
        $this->emissions_ges = $emissions_ges;
        $this->taxe_fonciere = $taxe_fonciere;
        $this->taxe_habitation = $taxe_habitation;
        $this->orientation = $orientation;
        $this->vue = $vue;
        $this->type_chauffage = $type_chauffage;
        $this->statut_propriete = $statut_propriete;
        $this->description = $description;
        $this->date_ajout = $date_ajout;
        $this->date_mise_a_jour = $date_mise_a_jour;
        $this->adresse = $adresse;
        $this->immeuble = $immeuble;
        $this->etage = $etage;
        $this->quartier = $quartier;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->pays = $pays;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters et Setters
    public function getProprietaireId(): int
    {
        return $this->proprietaire_id;
    }

    public function setProprietaireId(int $proprietaire_id): void
    {
        $this->proprietaire_id = $proprietaire_id;
    }

    public function getTypeBienId(): int
    {
        return $this->type_bien_id;
    }

    public function setTypeBienId(int $type_bien_id): void
    {
        $this->type_bien_id = $type_bien_id;
    }

    public function getEtatGeneral(): string
    {
        return $this->etat_general;
    }

    public function setEtatGeneral(string $etat_general): void
    {
        $this->etat_general = $etat_general;
    }

    public function getClasseEnergetique(): string
    {
        return $this->classe_energetique;
    }

    public function setClasseEnergetique(string $classe_energetique): void
    {
        $this->classe_energetique = $classe_energetique;
    }

    public function getConsommationEnergetique(): string
    {
        return $this->consommation_energetique;
    }

    public function setConsommationEnergetique(string $consommation_energetique): void
    {
        $this->consommation_energetique = $consommation_energetique;
    }

    public function getEmissionsGes(): string
    {
        return $this->emissions_ges;
    }

    public function setEmissionsGes(string $emissions_ges): void
    {
        $this->emissions_ges = $emissions_ges;
    }

    public function getTaxeFonciere(): float
    {
        return $this->taxe_fonciere;
    }

    public function setTaxeFonciere(float $taxe_fonciere): void
    {
        $this->taxe_fonciere = $taxe_fonciere;
    }

    public function getTaxeHabitation(): float
    {
        return $this->taxe_habitation;
    }

    public function setTaxeHabitation(float $taxe_habitation): void
    {
        $this->taxe_habitation = $taxe_habitation;
    }

    public function getOrientation(): string
    {
        return $this->orientation;
    }

    public function setOrientation(string $orientation): void
    {
        $this->orientation = $orientation;
    }

    public function getVue(): string
    {
        return $this->vue;
    }

    public function setVue(string $vue): void
    {
        $this->vue = $vue;
    }

    public function getTypeChauffage(): string
    {
        return $this->type_chauffage;
    }

    public function setTypeChauffage(string $type_chauffage): void
    {
        $this->type_chauffage = $type_chauffage;
    }

    public function getStatutPropriete(): string
    {
        return $this->statut_propriete;
    }

    public function setStatutPropriete(string $statut_propriete): void
    {
        $this->statut_propriete = $statut_propriete;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDateAjout(): DateTime
    {
        return $this->date_ajout;
    }

    public function setDateAjout(DateTime $date_ajout): void
    {
        $this->date_ajout = $date_ajout;
    }

    public function getDateMiseAJour(): DateTime
    {
        return $this->date_mise_a_jour;
    }

    public function setDateMiseAJour(DateTime $date_mise_a_jour): void
    {
        $this->date_mise_a_jour = $date_mise_a_jour;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getImmeuble(): string
    {
        return $this->immeuble;
    }

    public function setImmeuble(string $immeuble): void
    {
        $this->immeuble = $immeuble;
    }

    public function getEtage(): string
    {
        return $this->etage;
    }

    public function setEtage(string $etage): void
    {
        $this->etage = $etage;
    }

    public function getQuartier(): string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): void
    {
        $this->quartier = $quartier;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function getCodePostal(): string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
