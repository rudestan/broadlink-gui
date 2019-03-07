<?php

namespace BRMControl\Service;

abstract class AbstractDeviceStorage
{
    /**
     * @var DeviceStorageSerializer
     */
    protected $serializer;

    /**
     * @var string
     */
    protected $dir;

    /**
     * @var string
     */
    protected $prefix;

    public function __construct(DeviceStorageSerializer $serializer, string $dir, string $prefix)
    {
        $this->serializer = $serializer;
        $this->dir = $dir;
        $this->prefix = $prefix;
    }
}
