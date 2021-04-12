<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineProviderTest extends TestCase
{
    private const ID = 'machine id';
    private const PROVIDER_NAME = ProviderInterface::NAME_DIGITALOCEAN;

    private MachineProvider $machineProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->machineProvider = new MachineProvider(self::ID, self::PROVIDER_NAME);
    }

    public function testCreate(): void
    {
        self::assertSame(self::ID, $this->machineProvider->getId());
        self::assertNull($this->machineProvider->getRemoteId());
        self::assertSame(self::PROVIDER_NAME, $this->machineProvider->getName());
    }

    public function testGetSetRemoteId(): void
    {
        self::assertNull($this->machineProvider->getRemoteId());

        $remoteId = 123;
        $this->machineProvider->setRemoteId($remoteId);
        self::assertSame($remoteId, $this->machineProvider->getRemoteId());
    }
}
