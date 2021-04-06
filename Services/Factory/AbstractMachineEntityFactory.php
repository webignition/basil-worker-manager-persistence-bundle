<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineEntityStore;

abstract class AbstractMachineEntityFactory
{
    public function __construct(
        protected MachineEntityStore $store,
    ) {
    }
}
