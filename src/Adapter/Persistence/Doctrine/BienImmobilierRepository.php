<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\Out\DatabaseAdapterInterface;
use App\Port\Out\BienImmobilierRepositoryInterface;

class BienImmobilierRepository implements BienImmobilierRepositoryInterface
{

    private $db;
    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function save(BienImmobilier $bienImmobilier): BienImmobilier
    {   
        // Préparation de la requête
        $query = "INSERT INTO biens_immobiliers 
            (etat_general, classe_energetique, consommation_energetique, 
            emissions_ges, taxe_fonciere, taxe_habitation, orientation, vue, type_chauffage, 
            statut_propriete, description, date_ajout, date_mise_a_jour, adresse, immeuble, etage, 
            quartier, ville, code_postal, pays, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        // Initialisation de la connexion MySQLi
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
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


    public function update(int $bienImmobilierId, array $data): bool
    {   
        $query = "UPDATE biens_immobiliers 
                    SET 
                    etat_general = ?, 
                    classe_energetique = ?, 
                    consommation_energetique = ?, 
                    emissions_ges = ?, 
                    taxe_fonciere = ?, 
                    taxe_habitation = ?, 
                    orientation = ?, 
                    vue = ?, 
                    type_chauffage = ?, 
                    statut_propriete = ?, 
                    description = ?, 
                    date_mise_a_jour = ?, 
                    adresse = ?, 
                    immeuble = ?, 
                    etage = ?, 
                    quartier = ?, 
                    ville = ?, 
                    code_postal = ?, 
                    pays = ?, 
                    updated_at = NOW() 
                    WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Assignation des valeurs
        $bienImmobilier = $data;
        $etatGeneral = $bienImmobilier['etat_general'];
        $classeEnergetique = $bienImmobilier['classe_energetique'];
        $consommationEnergetique = $bienImmobilier['consommation_energetique'];
        $emissionsGes = $bienImmobilier['emissions_ges'];
        $taxeFonciere = $bienImmobilier['taxe_fonciere'];
        $taxeHabitation = $bienImmobilier['taxe_habitation'];
        $orientation = $bienImmobilier['orientation'];
        $vue = $bienImmobilier['vue'];
        $typeChauffage = $bienImmobilier['type_chauffage'];
        $statutPropriete = $bienImmobilier['statut_propriete'];
        $description = $bienImmobilier['description'];
        $dateMiseAJour = $bienImmobilier['date_mise_a_jour'];
        $adresse = $bienImmobilier['adresse'];
        $immeuble = $bienImmobilier['immeuble'];
        $etage = $bienImmobilier['etage'];
        $quartier = $bienImmobilier['quartier'];
        $ville = $bienImmobilier['ville'];
        $codePostal = $bienImmobilier['code_postal'];
        $pays = $bienImmobilier['pays'];
        $id = $bienImmobilierId;

        // Liaison des paramètres
        $stmt->bind_param(
            "sssssddssssssssssssi",
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
            $dateMiseAJour,
            $adresse,
            $immeuble,
            $etage,
            $quartier,
            $ville,
            $codePostal,
            $pays,
            $id
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
                
        $stmt->close();
        return true;
    }

    public function getBienImmobilier($bienImmobilierId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM biens_immobiliers WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $bienImmobilierId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun bien immobilier trouvé");
        }

        // Traitement du résultat
        $row = $result->fetch_assoc();

        // Remplissage de l'objet BienImmobilier avec les données récupérées
        $bienImmobilier = $row;
        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $bienImmobilier;
    }

    public function destroy(int $bienImmobilierId): bool
    {
        // Check if bien immobilier exist: if exist we continue else we have an exception
        $this->getBienImmobilier($bienImmobilierId);

        // Préparation de la connexion et de la requête
        $query = "DELETE FROM biens_immobiliers WHERE id = ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $bienImmobilierId;

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return true;       
    }

    public function getAllBienImmobilier(int $offset): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM biens_immobiliers LIMIT 10 OFFSET ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $offset);

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        // Récupération des résultats
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception("Aucun bien immobilier trouvé.");
        }

        // Traitement du résultat
        $bienImmobilier = $result->fetch_all(MYSQLI_ASSOC);

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $bienImmobilier;
    }
}