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
        self::assertSame(self::PROVIDER_NAME, $this->machineProvider->getName());
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
        ];
    }
}
