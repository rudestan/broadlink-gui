<?php

namespace BRMControl\Service;

use BRMControl\Device\Command;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\ScenarioItem;

class ScenarioPlayer
{
    /**
     * @var DeviceApiClient
     */
    private $deviceApiClient;

    /**
     * @var CommandCodeEncoder
     */
    private $commandCodeEncoder;

    public function __construct(DeviceApiClient $deviceApiClient, CommandCodeEncoder $commandCodeEncoder) {
        $this->deviceApiClient = $deviceApiClient;
        $this->commandCodeEncoder = $commandCodeEncoder;
    }

    public function playScenario(RMPPlus $device, Scenario $scenario): void
    {
        $scenarioItems = $scenario->getItems();

        if ($scenarioItems->count() == 0) {
            return;
        }

        /** @var ScenarioItem $scenarioItem */
        foreach ($scenarioItems as $scenarioItem) {
            $this->playScenarioItem($device, $scenarioItem);
        }
    }

    public function playScenarioItem(RMPPlus $device, ScenarioItem $scenarioItem): ?Command
    {
        $command = $device->getCommandById($scenarioItem->getCommandId());

        if ($command) {
            $this->deviceApiClient->sendCommand($device, $command);

            if ($scenarioItem->getDelay() > 0 && $scenarioItem->getDelay() <= ScenarioItem::MAX_DELAY) {
                sleep($scenarioItem->getDelay());
            }
        }

        return $command;
    }
}
