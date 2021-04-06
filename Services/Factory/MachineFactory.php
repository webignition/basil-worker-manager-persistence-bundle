<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineFactory extends AbstractMachineEntityFactory
{
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
