<?php

namespace BRMControl\Service;

use BRMControl\Device\DeviceStorage;
use BRMControl\Device\Type\AbstractDevice;
use BRMControl\Factory\DeviceFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Finder\Finder;

class DeviceStorageReader extends AbstractDeviceStorage
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

    public function readDeviceStorage(): ?DeviceStorage
    {
        $deviceStorageFiles = $this->getDeviceStorageFile();

        foreach ($deviceStorageFiles as $deviceStorageFile) {
            $deviceStorage = $this->getDeviceStorageFromFile($deviceStorageFile);

            if ($deviceStorage !== null) {
                dump($deviceStorage);die();
                //return $deviceStorage;
            }
        }

        return null;
    }

    public function readDevice(string $fileName): ?RMPPlus
    {
        $fileInfo = new \SplFileInfo($fileName);

        return $this->getDeviceFromFile($fileInfo);
    }

    private function getDeviceStorageFromFile(\SplFileInfo $deviceStorageFile): ?DeviceStorage
    {
        if (!$deviceStorageFile->isReadable()) {
            return null;
        }

        $contents = $deviceStorageFile->getContents();

        /** @var DeviceStorage $deviceStorage */
        $deviceStorage = $this->serializer->deserialize($contents);
        $deviceStorage->setFilename($deviceStorageFile->getRealPath());

        return $deviceStorage;
    }

    public function getDeviceStorageFile(): Finder
    {
        return $this->finder->name($this->prefix .'*.json')->in($this->dir);
    }
}
