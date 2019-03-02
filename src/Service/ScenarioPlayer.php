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
     * @var CommandProvider
     */
    private $commandProvider;

    /**
     * @var CommandCodeEncoder
     */
    private $commandCodeEncoder;

    public function __construct(
        DeviceApiClient $deviceApiClient,
        CommandProvider $commandProvider,
        CommandCodeEncoder $commandCodeEncoder
    ) {
        $this->deviceApiClient = $deviceApiClient;
        $this->commandProvider = $commandProvider;
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
        $command = $this->commandProvider->getByIdAndRemoteId(
            $device,
            $scenarioItem->getCommandId(),
            $scenarioItem->getRemoteId()
        );

        $this->deviceApiClient->sendCommand($device, $command);

        if ($scenarioItem->getDelay() > 0 && $scenarioItem->getDelay() <= ScenarioItem::MAX_DELAY) {
            sleep($scenarioItem->getDelay());
        }

        return $command;
    }
}
