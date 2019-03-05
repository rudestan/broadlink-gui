<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

class ScenarioItem
{
    use HashableTrait;

    /**
     * Maximum delay after command execution in seconds
     */
    public const MAX_DELAY = 10;

    /**
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @Type("string")
     * @var int
     */
    private $commandId;

    /**
     * @Type("float")
     * @var float
     */
    private $delay = 0;

    public function __construct(Command $command)
    {
        $this->commandId = $command->getId();
        $this->id = $this->generateHash($this->commandId);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCommandId(): string
    {
        return $this->commandId;
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
