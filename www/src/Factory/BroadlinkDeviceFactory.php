<?php

namespace BRMControl\Factory;

use BRMControl\Device\Type\AbstractDevice;
use BroadlinkApi\Device\AuthenticatableDeviceInterface;
use BroadlinkApi\Service\DeviceFactory;

class BroadlinkDeviceFactory
{
    /**
     * @var DeviceFactory
     */
    private $deviceFactory;

    public function __construct(DeviceFactory $deviceFactory)
    {
        $this->deviceFactory = $deviceFactory;
    }

    public function create(AbstractDevice $device): ?AuthenticatableDeviceInterface
    {
        $broadlinkDevice = $this->deviceFactory->create($device->getIp(), $device->getMac(), $device->getInternalId());

        return $broadlinkDevice->isAuthenticatable() === true ? $broadlinkDevice : null;
    }
}
