<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use JMS\Serializer\Annotation\Type;

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
     * @var int
     *
     * @Type("string")
     */
    private $commandId;

    /**
     * @var float
     *
     * @Type("float")
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
