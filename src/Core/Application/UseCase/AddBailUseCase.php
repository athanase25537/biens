<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;

class AddBailUseCase
{
    private BailRepositoryInterface $bailRepository;

    public function __construct(BailRepositoryInterface $bailRepository)
    {
        $this->bailRepository = $bailRepository;
    }

    public function execute(Bail $bail): Bail
    {
        // Code pour ajouter un bail
        return $this->bailRepository->save($bail);
    }
}
