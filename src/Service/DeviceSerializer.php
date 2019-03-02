<?php

namespace BRMControl\Service;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\ScenarioItem;
use Doctrine\Common\Collections\ArrayCollection;

class DeviceSerializer
{
    public function serialize(RMPPlus $rmpPlus): string
    {
        $data = [
            'id' => $rmpPlus->getId(),
            'ip' => $rmpPlus->getIp(),
            'mac' => $rmpPlus->getMac(),
            'name' => $rmpPlus->getName(),
            'remotes' => $this->getRemotesData($rmpPlus->getRemotes()),
            'scenarios' => $this->getScenariosData($rmpPlus->getScenarios()),
        ];

        return json_encode($data);
    }

    public function unserialize(string $data): ?array
    {
        $decoded = json_decode($data, true);

        if ($this->isDeviceData($decoded)) {
            return $decoded;
        }

        return null;
    }

    private function getRemotesData(ArrayCollection $remotes): array
    {
        $remotesData = [];

        /** @var Remote $remote */
        foreach ($remotes as $remote) {
            $remoteData = [
                'id' => $remote->getId(),
                'name' => $remote->getName(),
                'commands' => $this->getCommandsData($remote->getCommands()),
            ];

            $remotesData[] = $remoteData;
        }

        return $remotesData;
    }

    private function getCommandsData(ArrayCollection $commands): array
    {
        $commandsData = [];

        /** @var Command $command */
        foreach ($commands as $command) {
            $commandData = [
                'id' => $command->getId(),
                'name' => $command->getName(),
                'code' => $command->getIrCode(),
                'icon_class' => $command->getIconClass(),
                'color_class' => $command->getColorClass(),
            ];

            $commandsData[] = $commandData;
        }

        return $commandsData;
    }

    private function getScenariosData(ArrayCollection $scenarios): array
    {
        $scenariosData = [];

        /** @var Scenario $scenario */
        foreach ($scenarios as $scenario) {
            $scenarioData = [
                'id' => $scenario->getId(),
                'name' => $scenario->getName(),
                'items' => $this->getScenarioItems($scenario->getItems())
            ];

            $scenariosData[] = $scenarioData;
        }

        return $scenariosData;
    }

    private function getScenarioItems(ArrayCollection $scenarioItems): array
    {
        $scenarioItemsData = [];

        /** @var ScenarioItem $scenarioItem */
        foreach ($scenarioItems as $scenarioItem) {
            $scenarioItemData = [
                'id' => $scenarioItem->getId(),
                'remote' => $scenarioItem->getRemoteId(),
                'command' => $scenarioItem->getCommandId(),
                'delay' => $scenarioItem->getDelay(),
            ];

            $scenarioItemsData[] = $scenarioItemData;
        }

        return $scenarioItemsData;
    }

    private function isDeviceData(array $data): bool
    {
        return isset($data['id']) && isset($data['ip']) && isset($data['mac']) && isset($data['name']);
    }
}
