<?php

namespace BRMControl\Service;

use BRMControl\Device\RMPPlus;
use BRMControl\Exception\FileExistsException;

class DeviceWriter extends AbstractDeviceStorage
{
    public function saveNewDevice(RMPPlus $device): bool
    {
        $fileName = $this->getFileName($device);

        if ($this->exists($device)) {
            throw new FileExistsException(sprintf('File "%s" already exists!', $fileName));
        }

        $res = $this->saveDevice($fileName, $device);

        if ($res) {
            $device->setFilename($fileName);
        }

        return $res;
    }

    public function saveDevice(string $fileName, RMPPlus $device): bool
    {
        return file_put_contents($fileName, $this->serializer->serialize($device)) !== false;
    }

    public function exists(RMPPlus $device): bool
    {
        return file_exists($this->getFileName($device));
    }

    private function getFileName(RMPPlus $device): string
    {
        return $this->dir . $this->prefix . $device->getId() . '.json';
    }
}
