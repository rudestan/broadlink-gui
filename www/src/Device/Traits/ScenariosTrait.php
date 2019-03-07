<?php

namespace BRMControl\Device\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use BRMControl\Device\Scenario;

trait ScenariosTrait
{
    /**
     * @var ArrayCollection|null
     */
    private $scenarios;

    public function getScenarios(): ?ArrayCollection
    {
        return $this->scenarios;
    }

    public function setScenarios(ArrayCollection $scenarios): void
    {
        $this->scenarios = $scenarios;
    }

    public function addScenario(Scenario $scenario): void
    {
        $this->scenarios->add($scenario);
    }

    public function isScenarioExist(string $name): bool
    {
        return $this->scenarios->exists(function (string $key, Scenario $el) use ($name) {
            return $el->getName() === $name;
        });
    }

    public function getScenariosWithNamesAsKeys(): array
    {
        $scenarios = [];

        /** @var Scenario $scenario */
        foreach ($this->getScenarios() as $scenario) {
            $scenarios[$scenario->getName()] = $scenario;
        }

        return $scenarios;
    }

    public function getScenarioByName(string $name): ?Scenario
    {
        /** @var Scenario $scenario */
        foreach ($this->getScenarios() as $scenario) {
            if ($scenario->getName() === $name) {
                return $scenario;
            }
        }

        return null;
    }

    public function getScenarioById(string $id): ?Scenario
    {
        /** @var Scenario $scenario */
        foreach ($this->getScenarios() as $scenario) {
            if ($scenario->getId() === $id) {
                return $scenario;
            }
        }

        return null;
    }
}
