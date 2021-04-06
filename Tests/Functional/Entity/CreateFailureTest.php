<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Entity;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\ObjectReflector\ObjectReflector;

class CreateFailureTest extends AbstractFunctionalTest
{
    public function testEntityMapping(): void
    {
        $repository = $this->entityManager->getRepository(CreateFailure::class);
        self::assertCount(0, $repository->findAll());

        $entity = new CreateFailure('machine id', CreateFailure::CODE_UNKNOWN, CreateFailure::REASON_UNKNOWN);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        self::assertCount(1, $repository->findAll());
    }

    public function testRetrieveWithNullContext(): void
    {
        $entity = new CreateFailure('machine id', CreateFailure::CODE_UNKNOWN, CreateFailure::REASON_UNKNOWN);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->entityManager->clear();

        $retrievedEntity = $this->entityManager->find(CreateFailure::class, 'machine id');
        self::assertInstanceOf(CreateFailure::class, $retrievedEntity);
        self::assertSame([], ObjectReflector::getProperty($retrievedEntity, 'context'));
    }
}
