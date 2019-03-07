<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\DevicesTrait;
use BRMControl\Device\Traits\HashableTrait;
use BRMControl\Device\Traits\ScenariosTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

class DeviceStorage
{
    use HashableTrait;
    use DevicesTrait;
    use ScenariosTrait;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\Type\AbstractDevice>")
     */
    private $devices;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\Scenario>")
     */
    private $scenarios;

    /**
     * @var \DateTime
     *
     * @Type("DateTime")
     */
    private $createdAt;

    /**
     * @var string|null
     *
     * @Exclude
     */
    private $filename = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->id = $this->generateHash('device_storage');
        $this->devices = new ArrayCollection();
        $this->scenarios = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isPersisted()
    {
        return $this->filename === null;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }
}
