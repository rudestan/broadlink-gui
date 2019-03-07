<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use BRMControl\Device\Type\AbstractDevice;
use JMS\Serializer\Annotation\Type;

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
     * @var string
     *
     * @Type("string")
     */
    private $deviceId;

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
        $this->deviceId = $device->getId();
        $this->name = $name;
        $this->code = $code;
        $this->id = $this->generateHash($name. $code);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
