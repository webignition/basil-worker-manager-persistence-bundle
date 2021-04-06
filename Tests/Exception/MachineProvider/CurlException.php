<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\CurlExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\RemoteRequestActionInterface;

class CurlException extends AbstractMachineProviderException implements CurlExceptionInterface
{
    /**
     * @param RemoteRequestActionInterface::ACTION_* $action
     */
    public function __construct(
        private int $curlCode,
        \Throwable $remoteException,
        string $action,
    ) {
        parent::__construct($remoteException, $action);
    }

    public function getCurlCode(): int
    {
        return $this->curlCode;
    }
}
