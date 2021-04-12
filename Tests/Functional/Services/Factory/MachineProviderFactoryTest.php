<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Factory\MachineProviderFactory;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineProviderFactoryTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private MachineProviderFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $factory = $this->container->get(MachineProviderFactory::class);
        \assert($factory instanceof MachineProviderFactory);
        $this->factory = $factory;
    }

    public function testCreate(): void
    {
        $repository = $this->entityManager->getRepository(MachineProvider::class);
        self::assertCount(0, $repository->findAll());

        $entity = $this->factory->create(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);

        self::assertCount(1, $repository->findAll());
        self::assertEquals(
            new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
            $entity
        );
    }
}
