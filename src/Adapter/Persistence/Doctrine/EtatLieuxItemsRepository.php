<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Port\Out\EtatLieuxItemsRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;
use App\Core\Domain\Entity\EtatLieuxItems;

class EtatLieuxItemsRepository implements EtatLieuxItemsRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(EtatLieuxItems $etatLieuxItems): EtatLieuxItems
    {
        $config = [
            'db_type' => 'mysql', // Peut être 'mysql', 'postgresql', etc.
            'host' => 'localhost',
            'dbname' => 'bailonline',
            'user' => 'root',
            'password' => '',
        ];
        $query = "INSERT INTO etat_lieux_items (etat_lieux_id, titre, etat, plinthes, murs, sol, plafond, portes, huisseries, radiateurs, placards, aerations, interrupteurs, prises_electriques, tableau_electrique, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Initialisation de la connexion MySQLi
        $db = $this->db->connect($config);
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
} 