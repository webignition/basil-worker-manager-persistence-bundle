<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\UnknownExceptionInterface;

class UnknownException extends AbstractMachineProviderException implements UnknownExceptionInterface
{
}
