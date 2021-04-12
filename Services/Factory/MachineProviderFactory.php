<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineProviderStore;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineProviderFactory
{
    public function __construct(
        private MachineProviderStore $store,
    ) {
    }

    /**
     * @param ProviderInterface::NAME_* $name
     */
    public function create(string $machineId, string $name): MachineProvider
    {
        $entity = new MachineProvider($machineId, $name);
        $this->store->store($entity);

        return $entity;
    }
}
