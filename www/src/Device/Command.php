<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use JMS\Serializer\Annotation\Type;

class Command
{
    use HashableTrait;

    /**
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @Type("string")
     * @var string
     */
    private $name;

    /**
     * @Type("string")
     * @var string
     */
    private $code;

    public function __construct(string $name, string $code) {
        $this->name = $name;
        $this->code = $code;
        $this->id = $this->generateHash($name .microtime());
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
}
