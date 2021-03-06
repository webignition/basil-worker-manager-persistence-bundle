<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Entity;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineProviderTest extends AbstractFunctionalTest
{
    public function testEntityMapping(): void
    {
        $repository = $this->entityManager->getRepository(MachineProvider::class);
        self::assertCount(0, $repository->findAll());

        $entity = new MachineProvider('machine id', ProviderInterface::NAME_DIGITALOCEAN);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        self::assertCount(1, $repository->findAll());
    }
}
