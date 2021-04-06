<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;

class MachineStore extends AbstractMachineEntityStore
{
    public function find(string $machineId): ?Machine
    {
        $entity = $this->entityManager->find(Machine::class, $machineId);

        return $entity instanceof Machine ? $entity : null;
    }

    public function store(Machine $entity): void
    {
        $this->doStore($entity);
    }
}
