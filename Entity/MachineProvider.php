<?php

namespace webignition\BasilWorkerManager\PersistenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use webignition\BasilWorkerManagerInterfaces\MachineProviderInterface;
use webignition\BasilWorkerManagerInterfaces\ProviderInterface;

/**
 * @ORM\Entity
 */
class MachineProvider implements MachineProviderInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=MachineIdInterface::LENGTH)
     */
    private string $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $remote_id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var ProviderInterface::NAME_*
     */
    private string $provider;

    /**
     * @param ProviderInterface::NAME_* $provider
     */
    public function __construct(string $id, string $provider, ?int $remoteId = null)
    {
        $this->id = $id;
        $this->provider = $provider;
        $this->remote_id = $remoteId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRemoteId(): ?int
    {
        return $this->remote_id;
    }

    public function setRemoteId(int $remoteId): void
    {
        $this->remote_id = $remoteId;
    }

    /**
     * @return ProviderInterface::NAME_*
     */
    public function getName(): string
    {
        return $this->provider;
    }
}
