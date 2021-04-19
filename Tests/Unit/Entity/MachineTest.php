<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\Machine;
use webignition\BasilWorkerManagerInterfaces\MachineInterface;

class MachineTest extends TestCase
{
    private const MACHINE_ID = 'machine id';

    private Machine $machine;

    protected function setUp(): void
    {
        parent::setUp();

        $this->machine = new Machine(self::MACHINE_ID);
    }

    public function testCreate(): void
    {
        self::assertSame(self::MACHINE_ID, $this->machine->getId());
        self::assertSame(MachineInterface::STATE_CREATE_RECEIVED, $this->machine->getState());
        self::assertSame([], $this->machine->getIpAddresses());
        self::assertSame('worker-' . self::MACHINE_ID, $this->machine->getName());
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

    public function testReset(): void
    {
        self::assertSame(MachineInterface::STATE_CREATE_RECEIVED, $this->machine->getState());
        self::assertSame([], $this->machine->getIpAddresses());

        $this->machine->setState(MachineInterface::STATE_CREATE_FAILED);
        self::assertSame(MachineInterface::STATE_CREATE_FAILED, $this->machine->getState());

        $ipAddresses = ['10.0.0.1'];
        $this->machine->setIpAddresses($ipAddresses);
        self::assertSame($ipAddresses, $this->machine->getIpAddresses());

        $this->machine->reset();

        self::assertSame(MachineInterface::STATE_CREATE_RECEIVED, $this->machine->getState());
        self::assertSame([], $this->machine->getIpAddresses());
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

    /**
     * @dataProvider mergeDataProvider
     */
    public function testMerge(Machine $current, Machine $new, Machine $expected): void
    {
        self::assertEquals($expected, $current->merge($new));
    }

    /**
     * @return array[]
     */
    public function mergeDataProvider(): array
    {
        return [
            'current and new are equal' => [
                'current' => new Machine(self::MACHINE_ID),
                'new' => new Machine(self::MACHINE_ID),
                'expected' => new Machine(self::MACHINE_ID),
            ],
            'current and new have different states' => [
                'current' => new Machine(self::MACHINE_ID, MachineInterface::STATE_UP_STARTED),
                'new' => new Machine(self::MACHINE_ID, MachineInterface::STATE_UP_ACTIVE),
                'expected' => new Machine(self::MACHINE_ID, MachineInterface::STATE_UP_ACTIVE),
            ],
            'current and new have non-empty ip addresses' => [
                'current' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    ['a', 'b']
                ),
                'new' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    ['c', 'd']
                ),
                'expected' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    ['c', 'd']
                ),
            ],
            'current ip addresses are not overwritten by empty new ip addresses' => [
                'current' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    ['a', 'b']
                ),
                'new' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    []
                ),
                'expected' => new Machine(
                    self::MACHINE_ID,
                    MachineInterface::STATE_UP_STARTED,
                    ['a', 'b']
                ),
            ],
        ];
    }
}
