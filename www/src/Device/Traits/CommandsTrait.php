<?php

namespace BRMControl\Device\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use BRMControl\Device\Command;

trait CommandsTrait
{
    /**
     * @var ArrayCollection|null
     */
    private $commands;


    public function setCommands(ArrayCollection $commands): void
    {
        $this->commands = $commands;
    }

    public function getCommands(): ArrayCollection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): void
    {
        $this->commands->add($command);
    }

    public function isCommandExist(string $name): bool
    {
        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            if ($command->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function getCommandsWithNamesAsKeys(): array
    {
        $commands = [];

        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            $commands[$command->getName()] = $command;
        }

        return $commands;
    }

    public function getCommandByName(string $name): ?Command
    {
        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }

        return null;
    }

    public function getCommandById(string $id): ?Command
    {
        /** @var Command $command */
        foreach ($this->getCommands() as $command) {
            if ($command->getId() === $id) {
                return $command;
            }
        }

        return null;
    }
}
