<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use webignition\BasilWorkerManager\PersistenceBundle\PersistenceBundle;

class PersistenceBundleTestingKernel extends Kernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new PersistenceBundle(),
            new DoctrineBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
    }
}
