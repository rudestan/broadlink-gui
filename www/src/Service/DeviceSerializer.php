<?php

namespace BRMControl\Service;

use BRMControl\Device\RMPPlus;
use JMS\Serializer\SerializerInterface;

class DeviceSerializer
{
    private const FORMAT_JSON = 'json';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize(RMPPlus $rmpPlus): string
    {
        return $this->serializer->serialize($rmpPlus, self::FORMAT_JSON);
    }

    public function deserialize(string $data): RMPPlus
    {
        return $this->serializer->deserialize($data, RMPPlus::class, self::FORMAT_JSON);
    }
}
