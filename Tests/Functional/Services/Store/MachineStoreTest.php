<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineStoreTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private MachineStore $store;

    protected function setUp(): void
    {
        parent::setUp();

        $store = $this->container->get(MachineStore::class);
        \assert($store instanceof MachineStore);
        $this->store = $store;
    }

    public function testStore(): void
    {
        $entity = new Machine(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
    }

    public function testFind(): void
    {
        $entity = new Machine(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
        $this->entityManager->clear();

        $retrievedEntity = $this->store->find(self::MACHINE_ID);

        self::assertEquals($entity, $retrievedEntity);
    }
}
