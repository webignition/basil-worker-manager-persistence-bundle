<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineStore;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineFactory
{
    public function __construct(
        private MachineStore $store,
    ) {
    }

    /**
     * @param ProviderInterface::NAME_* $provider
     */
    public function create(string $machineId, string $provider): Machine
    {
        $entity = new Machine($machineId, $provider);
        $this->store->store($entity);

        return $entity;
    }
}
