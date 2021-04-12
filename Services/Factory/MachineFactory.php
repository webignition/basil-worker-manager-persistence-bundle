<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineStore;

class MachineFactory
{
    public function __construct(
        private MachineStore $store,
    ) {
    }

    public function create(string $machineId): Machine
    {
        $entity = new Machine($machineId);
        $this->store->store($entity);

        return $entity;
    }
}
