<?php

namespace BRMControl\Device\Type;

class SCDevice extends SPDevice
{
    public function getType(): string
    {
        return self::TYPE_SC;
    }
}