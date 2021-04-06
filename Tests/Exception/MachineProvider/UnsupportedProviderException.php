<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\UnsupportedProviderExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class UnsupportedProviderException extends \Exception implements UnsupportedProviderExceptionInterface
{
    /**
     * @param ProviderInterface::NAME_* $provider
     */
    public function __construct(
        private string $provider,
    ) {
        parent::__construct('', 0);
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}
