<?php

namespace BRMControl\Service;

use BRMControl\Device\Type\AbstractDevice;
use BRMControl\Factory\BroadlinkDeviceFactory;
use BRMControl\Factory\DeviceFactory;
use BroadlinkApi\Device\AuthenticatableDeviceInterface;
use BroadlinkApi\Device\IdentifiedDeviceInterface;
use BroadlinkApi\Device\NetDevice;
use BroadlinkApi\Exception\BroadlinkApiException;
use BroadlinkApi\Exception\ProtocolException;

class DeviceApiClient
{
    /**
     * @var DeviceFactory
     */
    private $deviceFactory;

    /**
     * @var BroadlinkDeviceFactory
     */
    private $broadlinkDeviceFactory;

    /**
     * @var array
     */
    private $authDevicePool;

    public function __construct(DeviceFactory $deviceFactory, BroadlinkDeviceFactory $broadlinkDeviceFactory)
    {
        $this->deviceFactory = $deviceFactory;
        $this->broadlinkDeviceFactory = $broadlinkDeviceFactory;
    }

    public function authenticate(AbstractDevice $device): bool
    {
        $broadlinkDevice = $this->broadlinkDeviceFactory->create($device);

        if (!$broadlinkDevice) {
            return false;
        }

        try {
            if($broadlinkDevice->authenticate()) {
                // We need to keep pool of authorized device to be able to use them during commands and scenarios
                $this->addDeviceToAuthPool($broadlinkDevice);

                return true;
            }
        } catch (ProtocolException $e) {
        }

        return false;
    }

    public function discover(): array
    {
        $netDevice = new NetDevice();

        try {
            $discoveredDevices = $netDevice->discover();

            return $this->createDeviceFromDiscovered($discoveredDevices);
        } catch (BroadlinkApiException $e) {
        }

        return [];
    }

    private function createDeviceFromDiscovered(array $discoveredDevices): array
    {
        $devices = [];

        /** @var IdentifiedDeviceInterface|AuthenticatableDeviceInterface $discoveredDevice */
        foreach ($discoveredDevices as $discoveredDevice) {
            if ($discoveredDevice instanceof AuthenticatableDeviceInterface) {
                $devices[] = $this->deviceFactory->create($discoveredDevice);
            }
        }

        return $devices;
    }

    private function addDeviceToAuthPool(AuthenticatableDeviceInterface $device): void
    {
        $key = $this->getKey($device);

        $this->authDevicePool[$key] = $device;
    }

    private function getKey($device): string
    {
        return sha1($device->getIp() . $device->getMac());
    }
}
