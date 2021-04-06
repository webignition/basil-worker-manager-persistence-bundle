<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\EntityInterface;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\EntityStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class EntityStoreTest extends AbstractFunctionalTest
{
    private EntityStore $entityStore;

    protected function setUp(): void
    {
        parent::setUp();

        $entityStore = $this->container->get(EntityStore::class);
        \assert($entityStore instanceof EntityStore);
        $this->entityStore = $entityStore;
    }

    /**
     * @dataProvider storeDataProvider
     *
     * @param class-string $entityClassName
     */
    public function testStore(string $entityClassName, EntityInterface $entity): void
    {
        $repository = $this->entityManager->getRepository($entityClassName);
        self::assertCount(0, $repository->findAll());

        $this->entityStore->store($entity);

        self::assertCount(1, $repository->findAll());
    }

    /**
     * @return array[]
     */
    public function storeDataProvider(): array
    {
        return [
            CreateFailure::class => [
                'entityClassName' => CreateFailure::class,
                'entity' => new CreateFailure('machine id', CreateFailure::CODE_UNKNOWN, CreateFailure::REASON_UNKNOWN),
            ],
            Machine::class => [
                'entityClassName' => Machine::class,
                'entity' => new Machine('machine id', ProviderInterface::NAME_DIGITALOCEAN),
            ],
        ];
    }
}
