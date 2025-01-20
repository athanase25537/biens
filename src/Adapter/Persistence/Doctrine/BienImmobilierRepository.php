<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\Out\BienImmobilierRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class BienImmobilierRepository implements BienImmobilierRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(BienImmobilier $bienImmobilier): BienImmobilier
    {
        $this->db->execute(
            "INSERT INTO biens_immobiliers 
            (etat_general, classe_energetique, consommation_energetique, 
            emissions_ges, taxe_fonciere, taxe_habitation, orientation, vue, type_chauffage, 
            statut_propriete, description, date_ajout, date_mise_a_jour, adresse, immeuble, etage, 
            quartier, ville, code_postal, pays, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $bienImmobilier->getEtatGeneral(),
                $bienImmobilier->getClasseEnergetique(),
                $bienImmobilier->getConsommationEnergetique(),
                $bienImmobilier->getEmissionsGes(),
                $bienImmobilier->getTaxeFonciere(),
                $bienImmobilier->getTaxeHabitation(),
                $bienImmobilier->getOrientation(),
                $bienImmobilier->getVue(),
                $bienImmobilier->getTypeChauffage(),
                $bienImmobilier->getStatutPropriete(),
                $bienImmobilier->getDescription(),
                $bienImmobilier->getDateAjout()->format('Y-m-d H:i:s'),
                $bienImmobilier->getDateMiseAJour()->format('Y-m-d H:i:s'),
                $bienImmobilier->getAdresse(),
                $bienImmobilier->getImmeuble(),
                $bienImmobilier->getEtage(),
                $bienImmobilier->getQuartier(),
                $bienImmobilier->getVille(),
                $bienImmobilier->getCodePostal(),
                $bienImmobilier->getPays(),
            ]
        );

        return $bienImmobilier;
    }

    public function update(int $idBienImmobilier, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));

        $query = "UPDATE biens_immobiliers SET $setClause, updated_at = NOW() WHERE id = ?";
        $params = array_values($data);
        $params[] = $idBienImmobilier;

        return $this->db->execute($query, $params);
    }

    public function getBienImmobilier($idBienImmobilier): ?BienImmobilier
    {
        $row = $this->db->findOne(
            "SELECT * FROM biens_immobiliers WHERE id = ?",
            [$idBienImmobilier]
        );

        return $row ? $this->mapToEntity($row) : null;
    }

    public function destroy(int $idBienImmobilier): bool
    {
        return $this->db->execute(
            "DELETE FROM biens_immobiliers WHERE id = ?",
            [$idBienImmobilier]
        );
    }

    private function mapToEntity(array $row): BienImmobilier
    {
        $bien = new BienImmobilier();
        $bien->setEtatGeneral($row['etat_general']);
        $bien->setClasseEnergetique($row['classe_energetique']);
        $bien->setConsommationEnergetique($row['consommation_energetique']);
        $bien->setEmissionsGes($row['emissions_ges']);
        $bien->setTaxeFonciere($row['taxe_fonciere']);
        $bien->setTaxeHabitation($row['taxe_habitation']);
        $bien->setOrientation($row['orientation']);
        $bien->setVue($row['vue']);
        $bien->setTypeChauffage($row['type_chauffage']);
        $bien->setStatutPropriete($row['statut_propriete']);
        $bien->setDescription($row['description']);
        $bien->setDateAjout(new \DateTime($row['date_ajout']));
        $bien->setDateMiseAJour(new \DateTime($row['date_mise_a_jour']));
        $bien->setAdresse($row['adresse']);
        $bien->setImmeuble($row['immeuble']);
        $bien->setEtage($row['etage']);
        $bien->setQuartier($row['quartier']);
        $bien->setVille($row['ville']);
        $bien->setCodePostal($row['code_postal']);
        $bien->setPays($row['pays']);

        return $bien;
    }
}
