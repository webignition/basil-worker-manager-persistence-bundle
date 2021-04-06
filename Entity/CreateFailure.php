<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CreateFailure implements \JsonSerializable
{
    public const CODE_UNKNOWN = 0;
    public const REASON_UNKNOWN = 'unknown';

    public const CODE_UNSUPPORTED_PROVIDER = 1;
    public const REASON_UNSUPPORTED_PROVIDER = 'unsupported provider';

    public const CODE_API_LIMIT_EXCEEDED = 2;
    public const REASON_API_LIMIT_EXCEEDED = 'api limit exceeded';

    public const CODE_API_AUTHENTICATION_FAILURE = 3;
    public const REASON_API_AUTHENTICATION_FAILURE = 'api authentication failure';

    public const CODE_CURL_ERROR = 4;
    public const REASON_CURL_ERROR = 'http transport error';

    public const CODE_HTTP_ERROR = 5;
    public const REASON_HTTP_ERROR = 'http application error';

    public const CODE_UNPROCESSABLE_REQUEST = 6;
    public const REASON_UNPROCESSABLE_REQUEST = 'unprocessable request';

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=128)
     */
    private string $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var self::CODE_*
     */
    private int $code;

    /**
     * @ORM\Column(type="text")
     *
     * @var self::REASON_*
     */
    private string $reason;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     *
     * @var array<string, int|string>
     */
    private array $context = [];

    /**
     * @param self::CODE_* $code
     * @param self::REASON_* $reason
     * @param array<string, int|string> $context
     */
    public function __construct(string $machineId, int $code, string $reason, array $context = [])
    {
        $this->id = $machineId;
        $this->code = $code;
        $this->reason = $reason;
        $this->context = $context;
    }


    /**
     * @return array<string, string|int|array<string, string|int>>
     */
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'reason' => $this->reason,
            'context' => $this->context,
        ];
    }
}
