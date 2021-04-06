<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineEntityInterface;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\MachineEntityStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineEntityStoreTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private MachineEntityStore $store;

    protected function setUp(): void
    {
        parent::setUp();

        $store = $this->container->get(MachineEntityStore::class);
        \assert($store instanceof MachineEntityStore);
        $this->store = $store;
    }

    /**
     * @dataProvider machineEntityDataProvider
     */
    public function testStore(MachineEntityInterface $entity): void
    {
        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
    }

    /**
     * @dataProvider machineEntityDataProvider
     */
    public function testFind(MachineEntityInterface $entity): void
    {
        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
        $this->entityManager->clear();

        $retrievedEntity = $this->store->find($entity::class, self::MACHINE_ID);

        self::assertEquals($entity, $retrievedEntity);
    }

    /**
     * @return array[]
     */
    public function machineEntityDataProvider(): array
    {
        return [
            CreateFailure::class => [
                'entity' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_UNKNOWN,
                    CreateFailure::REASON_UNKNOWN
                ),
            ],
            Machine::class => [
                'entity' => new Machine(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
            ],
        ];
    }
}
