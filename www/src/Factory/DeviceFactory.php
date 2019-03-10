<?php

namespace BRMControl\Factory;

use BRMControl\Device\Type\AbstractDevice;
use BRMControl\Device\Type\RMDevice;
use BRMControl\Device\Type\SCDevice;
use BRMControl\Device\Type\SPDevice;
use BRMControl\Device\Type\UnknownDevice;
use BroadlinkApi\Device\AuthenticatableDeviceInterface;
use BroadlinkApi\Device\IdentifiedDeviceInterface;

class DeviceFactory
{
    private const DEVICE_ID_CLASS_MAP = [
        SPDevice::class => [
            0x2733,
            0x2711,
            0x2719,
            0x7919,
            0x271a,
            0x791a,
            0x2720,
            0x753e,
            0x7D00,
            0x947a,
            0x9479,
            0x2728,
            0x273e,
            0x7530,
            0x7918,
            0x2736,
        ],
        RMDevice::class => [0x279d],
        SCDevice::class => [0x7547],
    ];

    public function create(AuthenticatableDeviceInterface $authDevice): AbstractDevice
    {
        $class = $this->getClassByInternalId($authDevice->getDeviceId());

        return $this->createDevice($class, $authDevice);
    }

    public function createFromArgs(string $deviceId, string $ip, string $mac, ?string $name = null): ?AbstractDevice
    {
        $class = $this->getClassByInternalId($deviceId);

        if (!$class) {
            return null;
        }

        return new $class($ip, $mac, $deviceId, $name);
    }

    private function createDevice(string $class, AuthenticatableDeviceInterface $device): AbstractDevice
    {
        return new $class(
            $device->getIP(),
            $device->getMac(),
            $device->getDeviceId(),
            $device->getName()
        );
    }

    private function getClassByInternalId(int $deviceId): string
    {
        foreach (self::DEVICE_ID_CLASS_MAP as $class => $ids) {
            if (in_array($deviceId, $ids)) {
                return $class;
            }
        }

        return UnknownDevice::class;
    }
}
