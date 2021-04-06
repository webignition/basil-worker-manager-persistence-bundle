<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use Doctrine\ORM\EntityManagerInterface;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineEntityInterface;

class MachineEntityStore
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param class-string $className
     */
    public function find(string $className, string $machineId): ?MachineEntityInterface
    {
        $entity = $this->entityManager->find($className, $machineId);

        return $entity instanceof MachineEntityInterface ? $entity : null;
    }

    public function store(MachineEntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
