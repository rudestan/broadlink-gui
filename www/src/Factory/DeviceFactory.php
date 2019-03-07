<?php

namespace BRMControl\Factory;

use BRMControl\Device\Type\AbstractDevice;
use BRMControl\Device\Type\RMDevice;
use BRMControl\Device\Type\SPDevice;
use BroadlinkApi\Device\AuthenticatableDeviceInterface;
use BroadlinkApi\Device\IdentifiedDeviceInterface;

class DeviceFactory
{
    public function create(AuthenticatableDeviceInterface $authDevice): AbstractDevice
    {
        $device = null;

        switch ($authDevice->getType()) {
            case IdentifiedDeviceInterface::TYPE_RM:
                $device = $this->createRmDevice($authDevice);
                break;
            case IdentifiedDeviceInterface::TYPE_SP:
                $device = $this->createSpDevice($authDevice);
                break;
        }

        if ($device === null) {
            throw new \InvalidArgumentException('Unknown device!');
        }

        return $device;
    }

    public function createRmDevice(AuthenticatableDeviceInterface $device): AbstractDevice
    {
        return new RMDevice(
            $device->getIP(),
            $device->getMac(),
            $device->getName()
        );
    }

    public function createSpDevice(AuthenticatableDeviceInterface $device): AbstractDevice
    {
        return new SPDevice(
            $device->getIP(),
            $device->getMac(),
            $device->getName()
        );
    }
}
