<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManagerInterfaces\MachineProviderInterface;

class MachineProviderStore extends AbstractMachineEntityStore
{
    public function find(string $machineId): ?MachineProvider
    {
        $entity = $this->entityManager->find(MachineProvider::class, $machineId);

        return $entity instanceof MachineProvider ? $entity : null;
    }

    public function store(MachineProviderInterface $entity): void
    {
        if ($entity instanceof MachineProvider) {
            $this->doStore($entity);
        }
    }
}
