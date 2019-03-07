<?php

namespace BRMControl\Device\Traits;

use BRMControl\Device\Type\AbstractDevice;
use Doctrine\Common\Collections\ArrayCollection;

trait DevicesTrait
{
    /**
     * @var ArrayCollection|null
     */
    private $devices;

    public function getDevices(): ?ArrayCollection
    {
        return $this->devices;
    }

    public function setDevices(ArrayCollection $devices): void
    {
        $this->devices = $devices;
    }

    public function addDevice(AbstractDevice $device): void
    {
        if ($this->isDeviceExist($device->getId())) {
            return;
        }

        $this->devices->add($device);
    }

    public function isDeviceExist(string $id): bool
    {
        return $this->getDeviceById($id) !== null;
    }

    public function getDeviceById(string $id): ?AbstractDevice
    {
        /** @var AbstractDevice $device */
        foreach ($this->getDevices() as $device) {
            if ($device->getId() === $id) {
                return $device;
            }
        }

        return null;
    }
}
