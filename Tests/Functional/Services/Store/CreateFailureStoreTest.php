<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Store;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Store\CreateFailureStore;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;

class CreateFailureStoreTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private CreateFailureStore $store;

    protected function setUp(): void
    {
        parent::setUp();

        $store = $this->container->get(CreateFailureStore::class);
        \assert($store instanceof CreateFailureStore);
        $this->store = $store;
    }

    public function testStore(): void
    {
        $entity = new CreateFailure(
            self::MACHINE_ID,
            CreateFailure::CODE_UNKNOWN,
            CreateFailure::REASON_UNKNOWN
        );

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
    }


    public function testFind(): void
    {
        $entity = new CreateFailure(
            self::MACHINE_ID,
            CreateFailure::CODE_UNKNOWN,
            CreateFailure::REASON_UNKNOWN
        );

        $repository = $this->entityManager->getRepository($entity::class);
        self::assertCount(0, $repository->findAll());

        $this->store->store($entity);

        self::assertCount(1, $repository->findAll());
        $this->entityManager->clear();

        $retrievedEntity = $this->store->find(self::MACHINE_ID);

        self::assertEquals($entity, $retrievedEntity);
    }
}
