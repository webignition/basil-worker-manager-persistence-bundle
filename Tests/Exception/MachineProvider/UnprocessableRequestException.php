<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\UnprocessableRequestExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\RemoteRequestActionInterface;

class UnprocessableRequestException extends AbstractMachineProviderException implements
    UnprocessableRequestExceptionInterface
{
    /**
     * @param RemoteRequestActionInterface::ACTION_* $action
     */
    public function __construct(
        private string $reason,
        \Throwable $remoteException,
        string $action,
    ) {
        parent::__construct($remoteException, $action);
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
