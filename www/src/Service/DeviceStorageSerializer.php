<?php

namespace BRMControl\Service;

use BRMControl\Device\DeviceStorage;
use JMS\Serializer\SerializerInterface;

class DeviceStorageSerializer
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

    public function serialize(DeviceStorage $deviceStorage): string
    {
        return $this->serializer->serialize($deviceStorage, self::FORMAT_JSON);
    }

    public function deserialize(string $data): DeviceStorage
    {
        return $this->serializer->deserialize($data, DeviceStorage::class, self::FORMAT_JSON);
    }
}
