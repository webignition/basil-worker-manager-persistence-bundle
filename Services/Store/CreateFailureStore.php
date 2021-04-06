<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;

class CreateFailureStore extends AbstractMachineEntityStore
{
    public function find(string $machineId): ?CreateFailure
    {
        $entity = $this->doFind(CreateFailure::class, $machineId);

        return $entity instanceof CreateFailure ? $entity : null;
    }

    public function store(CreateFailure $entity): void
    {
        $this->doStore($entity);
    }
}
