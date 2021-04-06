<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManagerInterfaces\MachineInterface;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class MachineTest extends TestCase
{
    private const MACHINE_ID = 'machine id';
    private const MACHINE_PROVIDER = ProviderInterface::NAME_DIGITALOCEAN;

    private Machine $machine;

    protected function setUp(): void
    {
        parent::setUp();

        $this->machine = new Machine(self::MACHINE_ID, self::MACHINE_PROVIDER);
    }

    public function testCreate(): void
    {
        self::assertSame(self::MACHINE_ID, $this->machine->getId());
        self::assertNull($this->machine->getRemoteId());
        self::assertSame(MachineInterface::STATE_CREATE_RECEIVED, $this->machine->getState());
        self::assertSame(self::MACHINE_PROVIDER, $this->machine->getProvider());
        self::assertSame([], $this->machine->getIpAddresses());
        self::assertSame('worker-' . self::MACHINE_ID, $this->machine->getName());
    }

    public function testGetSetRemoteId(): void
    {
        self::assertNull($this->machine->getRemoteId());

        $remoteId = 123;
        $this->machine->setRemoteId($remoteId);
        self::assertSame($remoteId, $this->machine->getRemoteId());
    }

    public function testGetSetState(): void
    {
        self::assertSame(MachineInterface::STATE_CREATE_RECEIVED, $this->machine->getState());

        $newState = MachineInterface::STATE_CREATE_REQUESTED;
        $this->machine->setState($newState);
        self::assertSame($newState, $this->machine->getState());
    }

    public function testGetSetIpAddresses(): void
    {
        self::assertSame([], $this->machine->getIpAddresses());

        $ipAddresses = ['10.0.0.1', '127.0.0.1'];
        $this->machine->setIpAddresses($ipAddresses);
        self::assertSame($ipAddresses, $this->machine->getIpAddresses());
    }

    public function testJsonSerialize(): void
    {
        self::assertSame(
            [
                'id' => self::MACHINE_ID,
                'state' => MachineInterface::STATE_CREATE_RECEIVED,
                'ip_addresses' => [],
            ],
            $this->machine->jsonSerialize()
        );
    }
}