<?php

namespace BRMControl\Service;

use BRMControl\Device\RMPPlus;
use BRMControl\Factory\RMPPlusFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Finder\Finder;

class DeviceReader extends AbstractDeviceStorage
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var RMPPlusFactory
     */
    private $rmpPlusFactory;

    public function __construct(
        DeviceSerializer $deviceSerializer,
        RMPPlusFactory $rmpPlusFactory,
        string $dir,
        string $prefix
    ) {
        parent::__construct($deviceSerializer, $dir, $prefix);

        $this->finder = new Finder();
        $this->rmpPlusFactory = $rmpPlusFactory;
    }

    public function readDevices(): ArrayCollection
    {
        $devices = new ArrayCollection();
        $deviceFiles = $this->getDeviceFiles();

        foreach ($deviceFiles as $deviceFile) {
            $device = $this->getDeviceFromFile($deviceFile);

            if ($device !== null) {
                $devices->set($device->getId(), $device);
            }
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

        $unserialized = $this->serializer->unserialize($contents);

        if ($unserialized === null) {
            return null;
        }

        $device = $this->rmpPlusFactory->createFromArray($unserialized);
        $device->setFilename($deviceFile->getRealPath());

        return $device;
    }

    public function getDeviceFiles(): Finder
    {
        return $this->finder->name($this->prefix .'*.json')->in($this->dir);
    }
}
