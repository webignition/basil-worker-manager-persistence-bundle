<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\HttpExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\MachineActionInterface;

class HttpException extends AbstractMachineProviderException implements HttpExceptionInterface
{
    /**
     * @param MachineActionInterface::ACTION_* $action
     */
    public function __construct(
        private int $statusCode,
        \Throwable $remoteException,
        string $action,
    ) {
        parent::__construct($remoteException, $action);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
