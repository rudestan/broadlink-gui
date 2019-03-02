<?php

namespace BroadlinkApi\Command;

use BroadlinkApi\Device\NetDeviceInterface;
use BroadlinkApi\Packet\Packet;

interface CommandInterface
{
    public const COMMAND_DISCOVER = 0x06;

    public const COMMAND_AUTHENTICATE = 0x65;

    public const COMMAND_GET_INFO = 0x6a;

    public function getCommandId(): int;

    public function handleResponse(Packet $packet);

    public function getDevice(): NetDeviceInterface;
}
