<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\BienImmobilierRepositoryInterface;

class BienImmobilierRepository implements BienImmobilierRepositoryInterface
{

    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(BienImmobilier $bienImmobilier): BienImmobilier
    {

        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];
        
        // Préparation de la requête
        $query = "INSERT INTO biens_immobiliers 
            (etat_general, classe_energetique, consommation_energetique, 
            emissions_ges, taxe_fonciere, taxe_habitation, orientation, vue, type_chauffage, 
            statut_propriete, description, date_ajout, date_mise_a_jour, adresse, immeuble, etage, 
            quartier, ville, code_postal, pays, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($config);
        $stmt = $db->prepare($query);
        
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }
        
        // Liaison des paramètres
        $stmt->bind_param(
            "sssssddsssssssssssss", // Types des paramètres (i = integer, s = string, d = double)
            $etatGeneral,
            $classeEnergetique,
            $consommationEnergetique,
            $emissionsGes,
            $taxeFonciere,
            $taxeHabitation,
            $orientation,
            $vue,
            $typeChauffage,
            $statutPropriete,
            $description,
            $dateAjout,
            $dateMiseAJour,
            $adresse,
            $immeuble,
            $etage,
            $quartier,
            $ville,
            $codePostal,
            $pays
        );
        
        // Assignation des valeurs à partir de l'objet BienImmobilier
        $proprietaireId = $bienImmobilier->getProprietaireId();
        $typeBienId = $bienImmobilier->getTypeBienId();
        $etatGeneral = $bienImmobilier->getEtatGeneral();
        $classeEnergetique = $bienImmobilier->getClasseEnergetique();
        $consommationEnergetique = $bienImmobilier->getConsommationEnergetique();
        $emissionsGes = $bienImmobilier->getEmissionsGes();
        $taxeFonciere = $bienImmobilier->getTaxeFonciere();
        $taxeHabitation = $bienImmobilier->getTaxeHabitation();
        $orientation = $bienImmobilier->getOrientation();
        $vue = $bienImmobilier->getVue();
        $typeChauffage = $bienImmobilier->getTypeChauffage();
        $statutPropriete = $bienImmobilier->getStatutPropriete();
        $description = $bienImmobilier->getDescription();
        $dateAjout = $bienImmobilier->getDateAjout()->format('Y-m-d H:i:s'); // Format DateTime en string
        $dateMiseAJour = $bienImmobilier->getDateMiseAJour()->format('Y-m-d H:i:s');
        $adresse = $bienImmobilier->getAdresse();
        $immeuble = $bienImmobilier->getImmeuble();
        $etage = $bienImmobilier->getEtage();
        $quartier = $bienImmobilier->getQuartier();
        $ville = $bienImmobilier->getVille();
        $codePostal = $bienImmobilier->getCodePostal();
        $pays = $bienImmobilier->getPays();
        
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
                
        // Fermeture du statement
        $stmt->close();
        
        return $bienImmobilier;
        
    }

}