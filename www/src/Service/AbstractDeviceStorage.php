<?php

namespace BRMControl\Service;

abstract class AbstractDeviceStorage
{
    /**
     * @var DeviceSerializer
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

    public function __construct(DeviceSerializer $serializer, string $dir, string $prefix)
    {
        $this->serializer = $serializer;
        $this->dir = $dir;
        $this->prefix = $prefix;
    }
}
