<?php

namespace BRMControl\Device\Type;

use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Discriminator;
use JMS\Serializer\Annotation\PostDeserialize;
use BRMControl\Device\Command;

/**
 * @Discriminator(field = "type", disabled = false, map = {
 *     "RM": "BRMControl\Device\Type\RMDevice",
 *     "SP": "BRMControl\Device\Type\SPDevice",
 *     "SC": "BRMControl\Device\Type\SCDevice"
 * })
 */
abstract class AbstractDevice
{
    use HashableTrait;

    public const TYPE_RM = 'RM';
    public const TYPE_SP = 'SP';
    public const TYPE_SC = 'SC';
    public const TYPE_UNKNOWN = 'Unknown';

    public const SUPPORTED = [
        self::TYPE_RM,
        self::TYPE_SP,
        self::TYPE_SC,
    ];

    /**
     * @var string
     *
     * @Type("string")
     */
    private $id;

    /**
     * @var string
     *
     * @Type("int")
     */
    private $internalId;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $mac;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $ip;

    /**
     * @var string|null
     *
     * @Type("string")
     */
    private $name;

    public function __construct(string $ip, string $mac, int $internalId, ?string $name = null)
    {
        $this->ip = $ip;
        $this->mac = $mac;
        $this->internalId = $internalId;
        $this->id = $this->generateHash($this->getType(). $mac);
        $this->name = $name ?? $this->getType() . ' #'. $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getInternalId(): int
    {
        return $this->internalId;
    }

    public function getMac(): string
    {
        return $this->mac;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    abstract public function getType(): string;

    abstract public function getCommands(): ArrayCollection;

    public function getCommandById(string $commandId): ?Command
    {
        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            if ($command->getId() === $commandId) {
                return $command;
            }
        }

        return null;
    }

    /**
     * @PostDeserialize
     */
    protected function postDeserialize(): void
    {
        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            $command->setDevice($this);
        }
    }
}
