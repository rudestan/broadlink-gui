<?php

namespace BRMControl\Service;

use BRMControl\Device\Device;
use BRMControl\Factory\DeviceFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Finder\Finder;

class DeviceReader extends AbstractDeviceStorage
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var DeviceFactory
     */
    private $deviceFactory;

    public function __construct(
        DeviceStorageSerializer $deviceSerializer,
        DeviceFactory $deviceFactory,
        string $dir,
        string $prefix
    ) {
        parent::__construct($deviceSerializer, $dir, $prefix);

        $this->finder = new Finder();
        $this->deviceFactory = $deviceFactory;
    }

    public function readDevices(): ArrayCollection
    {
        $devices = new ArrayCollection();
        $deviceFiles = $this->getDeviceFiles();

        foreach ($deviceFiles as $deviceFile) {
            $device = $this->getDeviceFromFile($deviceFile);

            $devices->set($device->getId(), $device);
        }

        return $devices;
    }

    public function readDevice(string $fileName): ?RMPPlus
    {
        $fileInfo = new \SplFileInfo($fileName);

        return $this->getDeviceFromFile($fileInfo);
    }

    private function getDeviceFromFile(\SplFileInfo $deviceFile): ?RMPPlus
    {
        if (!$deviceFile->isReadable()) {
            return null;
        }

        $contents = $deviceFile->getContents();

        /** @var RMPPlus $device */
        $device = $this->serializer->deserialize($contents);
        $device->setFilename($deviceFile->getRealPath());

        return $device;
    }

    public function getDeviceFiles(): Finder
    {
        return $this->finder->name($this->prefix .'*.json')->in($this->dir);
    }
}
