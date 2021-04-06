<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Services\Store;

use Doctrine\ORM\EntityManagerInterface;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\EntityInterface;

class EntityStore
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function store(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
