<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineProviderStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineProviderStoreTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private MachineProviderStore $store;

    protected function setUp(): void
    {
        parent::setUp();

        $store = $this->container->get(MachineProviderStore::class);
        \assert($store instanceof MachineProviderStore);
        $this->store = $store;
    }

    public function testStore(): void
    {
        $entity = new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
    }

    public function testFind(): void
    {
        $entity = new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
        $this->entityManager->clear();

        $retrievedEntity = $this->store->find(self::MACHINE_ID);

        self::assertEquals($entity, $retrievedEntity);
    }
}
