<?php

namespace BRMControl\Provider;

use BRMControl\Service\DeviceReader;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\Scenario;

class WidgetViewProvider
{
    private const TYPE_REMOTES = 'remotes';

    private const TYPE_SCENARIOS = 'scenarios';

    /**
     * @var DeviceReader
     */
    private $deviceReader;

    public function __construct(DeviceReader $deviceReader)
    {
        $this->deviceReader = $deviceReader;
    }

    public function getWidgetViewData(?string $type = null): array
    {
        $data = [];

        $devices = $this->deviceReader->readDevices();

        if ($devices->count() !== 0) {
            /** @var RMPPlus $device */
            $device = $devices->first();

            if ($type === null || $type === self::TYPE_REMOTES) {
                $data['remotes'] = $this->getRemotes($device);
            }

            if ($type === null || $type === self::TYPE_SCENARIOS) {
                $data['scenarios'] = $this->getScenarios($device);
            }
        }

        return $data;
    }

    public function getScenarioViewData(Scenario $scenario): array
    {
        $scenario = [
            'id' => $scenario->getId(),
            'name' => $scenario->getName(),
        ];

        return $scenario;
    }

    public function getRemoteViewData(Remote $remote): array
    {
        $remoteItem = [
            'name' => $remote->getName(),
            'id' => $remote->getId(),
            'type' => 'remote',
            'commands' => $this->getCommandsViewData($remote),
        ];

        return $remoteItem;
    }

    private function getScenarios(RMPPlus $device): array
    {
        $scenarios = [];

        /** @var Scenario $scenario */
        foreach ($device->getScenarios() as $scenario) {
            $scenarios[] = $this->getScenarioViewData($scenario);
        }

        return $scenarios;
    }

    private function getRemotes(RMPPlus $device): array
    {
        $remotesData = [];

        /** @var Remote $remote */
        foreach ($device->getRemotes() as $remote) {
            $remotesData[] = $this->getRemoteViewData($remote);
        }

        return $remotesData;
    }

    private function getCommandsViewData(Remote $remote): array
    {
        $commandItems = [];

        /** @var Command $command */
        foreach ($remote->getCommands() as $command) {
            $commandItem = [
                'id' => $command->getId(),
                'name' => $command->getName(),
                'icon_class' => $command->getIconClass(),
                'color_class' => $command->getColorClass(),
            ];

            $commandItems[] = $commandItem;
        }

        return $commandItems;
    }
}