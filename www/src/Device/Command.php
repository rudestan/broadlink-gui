<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use BRMControl\Device\Type\AbstractDevice;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

class Command
{
    use HashableTrait;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $id;

    /**
     * @var AbstractDevice
     *
     * @Exclude
     */
    private $device;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $code;

    public function __construct(AbstractDevice $device, string $name, string $code)
    {
        $this->device = $device;
        $this->name = $name;
        $this->code = $code;
        $this->id = $this->generateHash($this->device->getId() . $code);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDevice(): AbstractDevice
    {
        return $this->device;
    }

    public function setDevice(AbstractDevice $device): void
    {
        if (!$this->device) {
            $this->device = $device;
        }
    }
}
