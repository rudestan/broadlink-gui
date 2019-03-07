<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\CommandsTrait;
use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Remote
{
    use HashableTrait;
    use CommandsTrait;

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
    private $name;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\Command>")
     */
    private $commands;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = $this->generateHash($name);
        $this->commands = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
