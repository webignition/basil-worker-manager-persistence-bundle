<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\MachineInterface;

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
        $entity = new Machine(self::MACHINE_ID);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
    }

    public function testStoreOverwritesExistingEntity(): void
    {
        $repository = $this->entityManager->getRepository(Machine::class);
        self::assertCount(0, $repository->findAll());

        $existingEntity = new Machine(self::MACHINE_ID);
        $this->store->store($existingEntity);
        self::assertCount(1, $repository->findAll());

        $newEntity = new Machine(self::MACHINE_ID, MachineInterface::STATE_UP_ACTIVE, ['127.0.0.1']);
        $this->store->store($newEntity);
        self::assertCount(1, $repository->findAll());
    }

    public function testFind(): void
    {
        $entity = new Machine(self::MACHINE_ID);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
        $this->entityManager->clear();

        $retrievedEntity = $this->store->find(self::MACHINE_ID);

        self::assertEquals($entity, $retrievedEntity);
    }
}
