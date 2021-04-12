<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Factory\MachineFactory;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;

class MachineFactoryTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private MachineFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $factory = $this->container->get(MachineFactory::class);
        \assert($factory instanceof MachineFactory);
        $this->factory = $factory;
    }

    public function testCreate(): void
    {
        $repository = $this->entityManager->getRepository(Machine::class);
        self::assertCount(0, $repository->findAll());

        $entity = $this->factory->create(self::MACHINE_ID);

        self::assertCount(1, $repository->findAll());
        self::assertEquals(
            new Machine(self::MACHINE_ID),
            $entity
        );
    }
}
