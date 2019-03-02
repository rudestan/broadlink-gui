<?php

namespace BRMControl\Service;

use BRMControl\Device\Command;
use BRMControl\Device\RMPPlus;
use BRMControl\Exception\DeviceAuthorizationException;
use BroadlinkApi\Device\Authenticatable\RMDevice;

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

    public function __construct(CommandCodeEncoder $commandCodeEncoder)
    {
        $this->commandCodeEncoder = $commandCodeEncoder;
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
        $commandCode = $this->commandCodeEncoder->decode($command->getIrCode());

        $this->connect($device);
        $this->rmpDevice->sendCommand($commandCode);
    }

    private function isInstantiated(): bool
    {
        return $this->rmpDevice instanceof RMDevice;
    }
}
