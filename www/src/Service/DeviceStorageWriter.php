<?php

namespace BRMControl\Service;

use BRMControl\Exception\FileExistsException;
use BRMControl\Device\DeviceStorage;

class DeviceStorageWriter extends AbstractDeviceStorage
{
    public function saveNewDeviceStorage(DeviceStorage $deviceStorage): bool
    {
        $fileName = $this->getFileName($deviceStorage);

/*        if ($this->exists($deviceStorage)) {
            throw new FileExistsException(sprintf('File "%s" already exists!', $fileName));
        }*/

        $res = $this->saveDeviceStorage($deviceStorage, $fileName);

        if ($res) {
            $deviceStorage->setFilename($fileName);
        }

        return $res;
    }

    public function saveDeviceStorage(DeviceStorage $deviceStorage, ?string $fileName = null): bool
    {
        if ($fileName === null && $deviceStorage->getFilename() === null) {
            return false;
        }

        $file = $fileName === null ? $deviceStorage->getFilename() : $fileName;

        return file_put_contents($file, $this->serializer->serialize($deviceStorage)) !== false;
    }

    public function exists(DeviceStorage $deviceStorage): bool
    {
        return file_exists($this->getFileName($deviceStorage));
    }

    private function getFileName(DeviceStorage $deviceStorage): string
    {
        return $this->dir . $this->prefix . $deviceStorage->getId() . '.json';
    }
}
