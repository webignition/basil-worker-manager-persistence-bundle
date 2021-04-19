<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\ExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\MachineActionInterface;

class AbstractMachineProviderException extends \Exception implements ExceptionInterface
{
    /**
     * @param MachineActionInterface::ACTION_* $action
     */
    public function __construct(
        private \Throwable $remoteException,
        private string $action,
    ) {
        parent::__construct('', 0, $remoteException);
    }

    public function getRemoteException(): \Throwable
    {
        return $this->remoteException;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
