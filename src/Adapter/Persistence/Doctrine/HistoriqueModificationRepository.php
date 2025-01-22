<?php
namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\HistoriqueModification;
use App\Port\Out\DatabaseAdapterInterface;

class HistoriqueModificationRepository
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(HistoriqueModification $historique): void
    {
        $data = [
            'table_cible' => $historique->getTableCible(),
            'cible_id' => $historique->getCibleId(),
            'user_id' => $historique->getUserId(),
            'type_modification' => $historique->getTypeModification(),
            'details' => $historique->getDetails(),
        ];

        $this->db->persist('historique_modifications', $data);
    }
}