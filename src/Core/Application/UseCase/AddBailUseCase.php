<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Bail;
use App\Core\Domain\Port\Out\BailRepositoryInterface;

class AddBailUseCase
{
    private BailRepositoryInterface $bailRepository;

    public function __construct(BailRepositoryInterface $bailRepository)
    {
        $this->bailRepository = $bailRepository;
    }

    public function execute(array $bailData): int
    {
        $bail = new Bail($bailData);
        return $this->bailRepository->save($bail);
    }
}
