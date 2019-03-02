<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;

class ScenarioItem
{
    use HashableTrait;

    /**
     * Maximum delay after command execution in seconds
     */
    public const MAX_DELAY = 10;

    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $remoteId;

    /**
     * @var int
     */
    private $commandId;


    /**
     * @var float
     */
    private $delay = 0;

    public function __construct(string $remoteId, string $commandId, ?string $id = null)
    {
        $this->remoteId = $remoteId;
        $this->commandId = $commandId;
        $this->id = $id ?? $this->generateHash($this->remoteId.$this->commandId);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRemoteId(): string
    {
        return $this->remoteId;
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
