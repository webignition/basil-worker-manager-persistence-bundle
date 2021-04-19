<?php

declare(strict_types=1);

namespace webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\Services\Factory;

use webignition\BasilWorkerManager\PersistenceBundle\Entity\CreateFailure;
use webignition\BasilWorkerManager\PersistenceBundle\Services\Factory\CreateFailureFactory;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\ApiLimitException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\AuthenticationException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\CurlException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\HttpException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\UnknownException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\UnprocessableRequestException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Exception\MachineProvider\UnsupportedProviderException;
use webignition\BasilWorkerManager\PersistenceBundle\Tests\Functional\AbstractFunctionalTest;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\ApiLimitExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\AuthenticationExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\CurlExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\ExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\HttpExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\UnknownExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\MachineProvider\UnprocessableRequestExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\Exception\UnsupportedProviderExceptionInterface;
use webignition\BasilWorkerManagerInterfaces\MachineActionInterface;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

class CreateFailureFactoryTest extends AbstractFunctionalTest
{
    private const MACHINE_ID = 'machine id';

    private CreateFailureFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $factory = $this->container->get(CreateFailureFactory::class);
        \assert($factory instanceof CreateFailureFactory);
        $this->factory = $factory;
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(
        ExceptionInterface | UnsupportedProviderExceptionInterface $exception,
        CreateFailure $expectedCreateFailure
    ): void {
        $createFailure = $this->factory->create(self::MACHINE_ID, $exception);

        self::assertEquals($expectedCreateFailure, $createFailure);

        $retrievedCreateFailure = $this->entityManager->find(CreateFailure::class, self::MACHINE_ID);
        self::assertInstanceOf(CreateFailure::class, $retrievedCreateFailure);
        self::assertEquals($createFailure, $retrievedCreateFailure);
    }

    /**
     * @return array[]
     */
    public function createDataProvider(): array
    {
//        $unprocessableRequestException = \Mockery::mock(UnprocessableRequestExceptionInterface::class);
//        $unknownException = \Mockery::mock(UnknownExceptionInterface::class);

        return [
            UnsupportedProviderExceptionInterface::class => [
                'exception' => new UnsupportedProviderException(ProviderInterface::NAME_DIGITALOCEAN),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_UNSUPPORTED_PROVIDER,
                    CreateFailure::REASON_UNSUPPORTED_PROVIDER,
                ),
            ],
            ApiLimitExceptionInterface::class => [
                'exception' => new ApiLimitException(
                    123,
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_API_LIMIT_EXCEEDED,
                    CreateFailure::REASON_API_LIMIT_EXCEEDED,
                    [
                        'reset-timestamp' => 123,
                    ]
                ),
            ],
            AuthenticationExceptionInterface::class => [
                'exception' => new AuthenticationException(
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_API_AUTHENTICATION_FAILURE,
                    CreateFailure::REASON_API_AUTHENTICATION_FAILURE,
                ),
            ],
            CurlExceptionInterface::class => [
                'exception' => new CurlException(
                    7,
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_CURL_ERROR,
                    CreateFailure::REASON_CURL_ERROR,
                    [
                        'curl-code' => 7,
                    ]
                ),
            ],
            HttpExceptionInterface::class => [
                'exception' => new HttpException(
                    500,
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_HTTP_ERROR,
                    CreateFailure::REASON_HTTP_ERROR,
                    [
                        'status-code' => 500,
                    ]
                ),
            ],
            UnprocessableRequestExceptionInterface::class => [
                'exception' => new UnprocessableRequestException(
                    UnprocessableRequestExceptionInterface::REASON_REMOTE_PROVIDER_RESOURCE_LIMIT_REACHED,
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_UNPROCESSABLE_REQUEST,
                    CreateFailure::REASON_UNPROCESSABLE_REQUEST,
                    [
                        'provider-reason' =>
                            UnprocessableRequestExceptionInterface::REASON_REMOTE_PROVIDER_RESOURCE_LIMIT_REACHED,
                    ]
                ),
            ],
            UnknownExceptionInterface::class => [
                'exception' => new UnknownException(
                    new \Exception(),
                    MachineActionInterface::ACTION_CREATE
                ),
                'expectedCreateFailure' => new CreateFailure(
                    self::MACHINE_ID,
                    CreateFailure::CODE_UNKNOWN,
                    CreateFailure::REASON_UNKNOWN,
                ),
            ],
        ];
    }
}
