<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\ObjectReflector\ObjectReflector;

class CreateFailureTest extends TestCase
{
    public function testCreate(): void
    {
        $machineId = 'machine id';
        $code = CreateFailure::CODE_UNKNOWN;
        $reason = CreateFailure::REASON_UNKNOWN;

        $createFailure = new CreateFailure($machineId, $code, $reason);
        self::assertSame($machineId, ObjectReflector::getProperty($createFailure, 'id'));
        self::assertSame($code, ObjectReflector::getProperty($createFailure, 'code'));
        self::assertSame($reason, ObjectReflector::getProperty($createFailure, 'reason'));
        self::assertSame([], ObjectReflector::getProperty($createFailure, 'context'));
    }

    /**
     * @dataProvider jsonSerializeDataProvider
     *
     * @param array<mixed> $expectedSerializedObject
     */
    public function testJsonSerialize(CreateFailure $createFailure, array $expectedSerializedObject): void
    {
        self::assertSame($expectedSerializedObject, $createFailure->jsonSerialize());
    }

    /**
     * @return array[]
     */
    public function jsonSerializeDataProvider(): array
    {
        $machineId = 'machine id';
        $code = CreateFailure::CODE_UNKNOWN;
        $reason = CreateFailure::REASON_UNKNOWN;
        $context = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        return [
            'without context' => [
                'createFailure' => new CreateFailure($machineId, $code, $reason),
                'expectedSerializedObject' => [
                    'code' => $code,
                    'reason' => $reason,
                    'context' => [],
                ],
            ],
            'with context' => [
                'createFailure' => new CreateFailure($machineId, $code, $reason, $context),
                'expectedSerializedObject' => [
                    'code' => $code,
                    'reason' => $reason,
                    'context' => $context,
                ],
            ],
        ];
    }
}
