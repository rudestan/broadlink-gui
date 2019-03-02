<?php

namespace BRMControl\Service;

use BroadlinkApi\Packet\Packet;

class CommandCodeEncoder
{
    private const DELIMITER = ',';

    public function encode(Packet $packet): ?string
    {
        $encoded = [];
        $data = $packet->toArray();

        foreach ($data as $address => $value) {
            $encoded[] = $address . 'x' . $value;
        }

        return implode(self::DELIMITER, $encoded);
    }

    public function decode(string $code): Packet
    {
        $data = explode(self::DELIMITER, $code);
        $decoded = [];

        foreach ($data as $bytes) {
            $bytesData = explode('x', $bytes);

            $decoded[$bytesData[0]] = (int) $bytesData[1];
        }

        return Packet::fromArray($decoded);
    }
}
