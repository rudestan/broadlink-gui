<?php

namespace BRMControl\Factory;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\ScenarioItem;
use BroadlinkApi\Device\Authenticatable\RMDevice;
use Doctrine\Common\Collections\ArrayCollection;

class RMPPlusFactory
{
    public function create(RMDevice $device): RMPPlus
    {
        $rmpDevice = new RMPPlus(
            $device->getIP(),
            $device->getMac(),
            $device->getName()
        );

        return $rmpDevice;
    }

    public function createFromArray(array $data): RMPPlus
    {
        $rmpDevice = new RMPPlus(
            $data['ip'],
            $data['mac'],
            $data['name']
        );

        $rmpDevice->setId($data['id']);

        if (isset($data['remotes']) && count($data['remotes'])) {
            $rmpDevice->setRemotes($this->getRemotes($data['remotes']));
        }

        if (isset($data['scenarios']) && count($data['scenarios'])) {
            $this->setScenarios($rmpDevice, $data['scenarios']);
        }

        return $rmpDevice;
    }

    private function getRemotes(array $data): ArrayCollection
    {
        $remotes = new ArrayCollection();

        foreach ($data as $remoteData) {
            $remote = new Remote($remoteData['name'], $remoteData['id']);

            if (isset($remoteData['commands']) && count($remoteData['commands'])) {
                $remote->setCommands($this->getCommands($remoteData['commands']));
            }

            $remotes->set($remote->getId(), $remote);
        }

        return $remotes;
    }

    private function getCommands(array $data): ArrayCollection
    {
        $commands = new ArrayCollection();

        foreach ($data as $commandData) {
            $command = new Command(
                $commandData['name'],
                $commandData['code'],
                $commandData['id'],
                $commandData['icon_class'] ?? null,
                $commandData['color_class'] ?? null
            );

            $commands->set($command->getId(), $command);
        }

        return $commands;
    }

    private function setScenarios(RMPPlus $rmpDevice, array $data): void
    {
        foreach ($data as $scenarioData) {
            $scenario = new Scenario($scenarioData['name'], $scenarioData['id']);

            $this->addScenarioItems($scenario, $scenarioData['items']);
            $rmpDevice->addScenario($scenario);
        }
    }

    private function addScenarioItems(Scenario $scenario, array $data): void
    {
        foreach ($data as $scenarioItemData) {
            $scenarioItem = new ScenarioItem(
                $scenarioItemData['remote'],
                $scenarioItemData['command'],
                $scenarioItemData['id']
            );

            $scenarioItem->setDelay($scenarioItemData['delay']);

            $scenario->addScenarioItem($scenarioItem);
        }
    }
}
