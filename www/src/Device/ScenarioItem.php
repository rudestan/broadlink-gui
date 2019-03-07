<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;

class ScenarioItem
{
    use HashableTrait;

    /**
     * Maximum delay after command execution in seconds
     */
    public const MAX_DELAY = 10;

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
    private $commandId;

    /**
     * @var Command
     *
     * @Exclude
     */
    private $command;

    /**
     * @var float
     *
     * @Type("float")
     */
    private $delay = 0;

    public function __construct(Command $command)
    {
        $this->commandId = $command->getId();
        $this->command = $command;
        $this->id = $this->generateHash($this->command->getId());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCommandId(): string
    {
        return $this->commandId;
    }

    public function getCommand(): Command
    {
        return $this->command;
    }

    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }

    public function getDelay(): float
    {
        return $this->delay;
    }

    public function setDelay(float $delay): void
    {
        $this->delay = $delay;
    }
}
