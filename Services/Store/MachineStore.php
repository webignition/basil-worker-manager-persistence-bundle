<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManagerInterfaces\MachineInterface;

class MachineStore extends AbstractMachineEntityStore
{
    public function find(string $machineId): ?Machine
    {
        $entity = $this->entityManager->find(Machine::class, $machineId);

        return $entity instanceof Machine ? $entity : null;
    }

    public function store(MachineInterface $entity): void
    {
        $existingEntity = $this->find($entity->getId());
        if ($existingEntity instanceof Machine) {
            $entity = $existingEntity->merge($entity);
        }

        if ($entity instanceof Machine) {
            $this->doStore($entity);
        }
    }
}
