<?php

namespace BroadlinkApi\Command;

use BroadlinkApi\Device\AuthenticatableDeviceInterface;
use BroadlinkApi\Device\NetDeviceInterface;
use BroadlinkApi\Dto\AuthDataDto;
use BroadlinkApi\Packet\Packet;
use BroadlinkApi\Packet\PacketBuilder;

class AuthenticateCommand implements EncryptedCommandInterface
{
    /**
     * @var AuthenticatableDeviceInterface
     */
    private $device;

    public function __construct(AuthenticatableDeviceInterface $device)
    {
        $this->device = $device;
    }

    public function getCommandId(): int
    {
        return CommandInterface::COMMAND_AUTHENTICATE;
    }

    public function getPayload(): Packet
    {
        return Packet::createZeroPacket(0x50);
    }

    public function handleResponse(Packet $packet): AuthDataDto
    {
        $packetBuilder = new PacketBuilder($packet);
        $sessionId = $packetBuilder->readInt32(0x00);
        $key = array_reverse($packetBuilder->readBytes(0x04, 16));

        return new AuthDataDto($key, $sessionId);
    }

    public function getDevice(): NetDeviceInterface
    {
        return $this->device;
    }
}
