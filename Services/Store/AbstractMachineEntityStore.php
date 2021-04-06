<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use Doctrine\ORM\EntityManagerInterface;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;

abstract class AbstractMachineEntityStore
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param class-string $className
     */
    protected function doFind(string $className, string $machineId): ?object
    {
        $entity = $this->entityManager->find($className, $machineId);

        return $entity instanceof $className ? $entity : null;
    }

    public function doStore(CreateFailure | Machine $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
