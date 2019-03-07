<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\DevicesTrait;
use BRMControl\Device\Traits\HashableTrait;
use BRMControl\Device\Traits\ScenariosTrait;
use BRMControl\Device\Type\AbstractDevice;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PostDeserialize;

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

    /**
     * @PostDeserialize
     */
    private function PostDeserialize(): void
    {
        /** @var Scenario $scenario */
        foreach ($this->getScenarios() as $scenario) {
            $this->bindCommandToScenarioItems($scenario->getItems());
        }
    }

    private function bindCommandToScenarioItems(ArrayCollection $scenarioItems): void
    {
        /** @var ScenarioItem $scenarioItem */
        foreach ($scenarioItems as $scenarioItem)
        {
            $command = $this->getCommandById($scenarioItem->getCommandId());

            if ($command !== null) {
                $scenarioItem->setCommand($command);
            }
        }
    }

    private function getCommandById(string $commandId): ?Command
    {
        /** @var AbstractDevice $device */
        foreach ($this->getDevices() as $device) {
            $command = $device->getCommandById($commandId);

            if ($command !== null) {
                return $command;
            }
        }

        return null;
    }
}
