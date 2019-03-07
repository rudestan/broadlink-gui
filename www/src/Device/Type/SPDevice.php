<?php

namespace BRMControl\Device\Type;

use BRMControl\Device\Command;
use BRMControl\Device\Traits\CommandsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class SPDevice extends AbstractDevice
{
    use CommandsTrait;

    public const CMDCODE_POWER_ON = 'cmd_power_on';

    public const CMDCODE_POWER_OFF = 'cmd_power_off';

    public const CMDCODE_NIGHTLIGHT_ON = 'cmd_nightlight_on';

    public const CMDCODE_NIGHTLIGHT_OFF = 'cmd_nightlight_off';

    public const SUPPORTED_COMMANDS = [
        self::CMDCODE_POWER_ON => 'Power On',
        self::CMDCODE_POWER_OFF => 'Power Off',
        self::CMDCODE_NIGHTLIGHT_ON => 'Night light On',
        self::CMDCODE_NIGHTLIGHT_OFF => 'Night light Off',
    ];

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\Command>")
     */
    private $commands;

    public function __construct(string $ip, string $mac, ?string $name = null)
    {
        parent::__construct($ip, $mac, $name);

        $this->commands = $this->initCommands();
    }

    public function getType(): string
    {
        return self::TYPE_SP;
    }

    private function initCommands(): ArrayCollection
    {
        $commands = new ArrayCollection();

        foreach (self::SUPPORTED_COMMANDS as $name => $code) {
            $commands->add(new Command($this, $name, $code));
        }

        return $commands;
    }
}
