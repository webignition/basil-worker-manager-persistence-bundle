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
        if ($entity instanceof Machine) {
            $this->doStore($entity);
        }
    }
}
