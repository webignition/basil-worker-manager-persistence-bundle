<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\ApiLimitExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\MachineActionInterface;

class ApiLimitException extends AbstractMachineProviderException implements ApiLimitExceptionInterface
{
    /**
     * @param MachineActionInterface::ACTION_* $action
     */
    public function __construct(
        private int $resetTimestamp,
        \Throwable $remoteException,
        string $action,
    ) {
        parent::__construct($remoteException, $action);
    }

    public function getResetTimestamp(): int
    {
        return $this->resetTimestamp;
    }
}
