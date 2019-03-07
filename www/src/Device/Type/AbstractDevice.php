<?php

namespace BRMControl\Device\Type;

use BRMControl\Device\Traits\HashableTrait;
use JMS\Serializer\Annotation\Type;

abstract class AbstractDevice
{
    use HashableTrait;

    public const TYPE_RM = 'RM';

    public const TYPE_SP = 'SP';

    public const SUPPORTED = [
        self::TYPE_RM,
        self::TYPE_SP,
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

    public function __construct(string $ip, string $mac, ?string $name = null)
    {
        $this->ip = $ip;
        $this->mac = $mac;
        $this->id = $this->generateHash($this->type. $mac);
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
}
