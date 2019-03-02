<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;

class Command
{
    use HashableTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $irCode;

    /**
     * @var string|null
     */
    private $iconClass;

    /**
     * @var string|null
     */
    private $colorClass;

    public function __construct(
        string $name,
        string $irCode,
        ?string $id = null,
        ?string $iconClass = null,
        ?string $colorClass = null
    ) {
        $this->name = $name;
        $this->irCode = $irCode;
        $this->id = $id ?? $this->generateHash($name);
        $this->iconClass = $iconClass;
        $this->colorClass = $colorClass;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIrCode(): string
    {
        return $this->irCode;
    }

    public function getIconClass(): ?string
    {
        return $this->iconClass;
    }

    public function getColorClass(): ?string
    {
        return $this->colorClass;
    }
}
