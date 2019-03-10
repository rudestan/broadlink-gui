<?php

namespace BRMControl\Client;

use BRMControl\Device\Command;
use BRMControl\Device\RMPPlus;
use BRMControl\Exception\DeviceAuthorizationException;
use BRMControl\Factory\DeviceFactory;
use BroadlinkApi\Device\Authenticatable\RMDevice;
use BroadlinkApi\Device\NetDevice;
use BroadlinkApi\Exception\BroadlinkApiException;

class DeviceApiClient
{
    /**
     * @var RMDevice|null
     */
    private $rmpDevice = null;

    /**
     * @var CommandCodeEncoder
     */
    private $commandCodeEncoder;

    private $deviceFactory;

    public function __construct(CommandCodeEncoder $commandCodeEncoder, DeviceFactory $deviceFactory)
    {
        $this->commandCodeEncoder = $commandCodeEncoder;
    }

    public function discover(): array
    {
        $netDevice = new NetDevice();
        $devices = [];

        try {
            $netDevice->discover();
        } catch (BroadlinkApiException $e) {

        }

        return $devices;
    }

    private function connect(RMPPlus $device): void
    {
        if (!$this->rmpDevice instanceof RMDevice) {
            $this->rmpDevice = new RMDevice($device->getIp(), $device->getMac());
        }

        try {
            if (!$this->rmpDevice->isAuthenticated()) {
                $this->rmpDevice->authenticate();
            }
        } catch (\Exception $e) {
            throw new DeviceAuthorizationException(
                sprintf(
                    'Failed to authorize the device "%s (ip: %s)". Please check whether it is online and discoverable.',
                    $device->getName(),
                    $device->getIp()
                )
            );
        }
    }

    public function startLearning(RMPPlus $device): void
    {
        $this->connect($device);

        $this->rmpDevice->enterLearning();
    }

    public function getLastLearnedCommand(): ?string
    {
        if (!$this->isInstantiated()) {
            throw new \LogicException('Device is not instantiated.');
        }

        $lastLearnedCommand = $this->rmpDevice->getLearnedCommand();

        return $lastLearnedCommand !== null ? $this->commandCodeEncoder->encode($lastLearnedCommand) : null;
    }

    public function sendCommand(RMPPlus $device, Command $command)
    {
        $commandCode = $this->commandCodeEncoder->decode($command->getCode());

        $this->connect($device);
        $this->rmpDevice->sendCommand($commandCode);
    }

    private function isInstantiated(): bool
    {
        return $this->rmpDevice instanceof RMDevice;
    }
}
