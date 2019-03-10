<?php

namespace BRMControl\Device\Type;

use Doctrine\Common\Collections\ArrayCollection;

class UnknownDevice extends AbstractDevice
{
    public function getType(): string
    {
        return self::TYPE_UNKNOWN;
    }

    public function getCommands(): ArrayCollection
    {
        return new ArrayCollection();
    }
}
