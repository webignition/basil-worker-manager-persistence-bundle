<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\MachineProvider;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;
use webignition\ObjectReflector\ObjectReflector;

class MachineProviderTest extends TestCase
{
    private const MACHINE_ID = 'machine id';
    private const PROVIDER_NAME = ProviderInterface::NAME_DIGITALOCEAN;

    private MachineProvider $machineProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->machineProvider = new MachineProvider(self::MACHINE_ID, self::PROVIDER_NAME);
    }

    public function testCreate(): void
    {
        self::assertSame(self::MACHINE_ID, $this->machineProvider->getId());
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

    /**
     * @dataProvider mergeDataProvider
     */
    public function testMerge(MachineProvider $current, MachineProvider $new, MachineProvider $expected): void
    {
        self::assertEquals($expected, $current->merge($new));
    }

    /**
     * @return array[]
     */
    public function mergeDataProvider(): array
    {
        $machineProviderWithDifferentName = new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);
        ObjectReflector::setProperty(
            $machineProviderWithDifferentName,
            MachineProvider::class,
            'provider',
            'different provider'
        );

        $machineProviderWithRemoteId1 = new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);
        $machineProviderWithRemoteId1->setRemoteId(1);

        $machineProviderWithRemoteId2 = new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN);
        $machineProviderWithRemoteId2->setRemoteId(2);

        return [
            'current and new are equal' => [
                'current' => new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
                'new' => new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
                'expected' => new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
            ],
            'current and new have different names' => [
                'current' => new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
                'new' => $machineProviderWithDifferentName,
                'expected' => $machineProviderWithDifferentName,
            ],
            'current and new have non-empty remote ids' => [
                'current' => $machineProviderWithRemoteId1,
                'new' => $machineProviderWithRemoteId2,
                'expected' => $machineProviderWithRemoteId2,
            ],
            'current remote id is not overwritten by empty new remote id' => [
                'current' => $machineProviderWithRemoteId1,
                'new' => new MachineProvider(self::MACHINE_ID, ProviderInterface::NAME_DIGITALOCEAN),
                'expected' => $machineProviderWithRemoteId1,
            ],
        ];
    }
}
