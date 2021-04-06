<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider;

use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\AuthenticationExceptionInterface;

class AuthenticationException extends AbstractMachineProviderException implements AuthenticationExceptionInterface
{
}
