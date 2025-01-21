<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\EtatLieuxItemsRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;
use App\Core\Domain\Entity\EtatLieuxItems;

class EtatLieuxItemsRepository implements EtatLieuxItemsRepositoryInterface
{
    private $db;
    private $config = [
        'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
        'host' => 'localhost',
        'dbname' => 'bailonline',
        'user' => 'root',
        'password' => '',
    ];

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(EtatLieuxItems $etatLieuxItems): EtatLieuxItems
    {
        $query = "INSERT INTO etat_lieux_items (etat_lieux_id, titre, etat, plinthes, murs, sol, plafond, portes, huisseries, radiateurs, placards, aerations, interrupteurs, prises_electriques, tableau_electrique, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($this->config);
        $stmt = $db->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        $etatLieuxId = $etatLieuxItems->getEtatLieuxId();
        $titre = $etatLieuxItems->getTitre();
        $etat = $etatLieuxItems->getEtat();
        $plinthes = $etatLieuxItems->getPlinthes();
        $murs = $etatLieuxItems->getMurs();
        $sol = $etatLieuxItems->getSol();
        $plafond = $etatLieuxItems->getPlafond();
        $portes = $etatLieuxItems->getPortes();
        $huisseries = $etatLieuxItems->getHuisseries();
        $radiateurs = $etatLieuxItems->getRadiateurs();
        $placards = $etatLieuxItems->getPlacards();
        $aerations = $etatLieuxItems->getAerations();
        $interrupteurs = $etatLieuxItems->getInterrupteurs();
        $prisesElectriques = $etatLieuxItems->getPrisesElectriques();
        $tableauElectrique = $etatLieuxItems->getTableauElectrique();
        $description = $etatLieuxItems->getDescription();

        $stmt->bind_param(
            "isiiiiiiiiiiiiis",
            $etatLieuxId,
            $titre,
            $etat,
            $plinthes,
            $murs,
            $sol,
            $plafond,
            $portes,
            $huisseries,
            $radiateurs,
            $placards,
            $aerations,
            $interrupteurs,
            $prisesElectriques,
            $tableauElectrique,
            $description,            
        );

        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }
        
        $stmt->close();
        return $etatLieuxItems;
    }

    public function getEtatLieuxItems(int $etatLieuxItemsId): ?array
    {
        // Préparation de la connexion et de la requête
        $query = "SELECT * FROM etat_lieux_items WHERE id = ?";

        $db = $this->db->connect($this->config);
        $stmt = $db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        // Liaison du paramètre
        $stmt->bind_param("i", $id);

        // Assignation de la valeur du paramètre
        $id = $etatLieuxItemsId;

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

        // Remplissage de l'objet EtatLieuxItems avec les données récupérées
        $etatLieuxItems = $row;

        // Fermeture du statement et retour de l'objet
        $stmt->close();

        return $etatLieuxItems;
    }

    public function update(int $etatLieuxItemsId, array $data): bool
    {
        $query = "UPDATE etat_lieux_items 
          SET 
          etat_lieux_id = ?,
          titre = ?, 
          etat = ?, 
          plinthes = ?, 
          murs = ?, 
          sol = ?, 
          plafond = ?, 
          portes = ?, 
          huisseries = ?, 
          radiateurs = ?, 
          placards = ?, 
          aerations = ?, 
          interrupteurs = ?, 
          prises_electriques = ?, 
          tableau_electrique = ?, 
          description = ?
          WHERE id = ?";

        $db = $this->db->connect($this->config);
        $stmt = $db->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $db->error);
        }

        // Assignation des valeurs
        $etatLieuxId = $data['etat_lieux_id'];
        $titre = $data['titre'];
        $etat = $data['etat'];
        $plinthes = $data['plinthes'];
        $murs = $data['murs'];
        $sol = $data['sol'];
        $plafond = $data['plafond'];
        $portes = $data['portes'];
        $huisseries = $data['huisseries'];
        $radiateurs = $data['radiateurs'];
        $placards = $data['placards'];
        $aerations = $data['aerations'];
        $interrupteurs = $data['interrupteurs'];
        $prisesElectriques = $data['prises_electriques'];
        $tableauElectrique = $data['tableau_electrique'];
        $description = $data['description'];
        $id = $etatLieuxItemsId;

        // Liaison des paramètres
        $stmt->bind_param(
            "isssssssssssssssi",
            $etatLieuxId,
            $titre,
            $etat,
            $plinthes,
            $murs,
            $sol,
            $plafond,
            $portes,
            $huisseries,
            $radiateurs,
            $placards,
            $aerations,
            $interrupteurs,
            $prisesElectriques,
            $tableauElectrique,
            $description,
            $id
        );

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        return true;
    }
} 