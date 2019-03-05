<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Remote
{
    use HashableTrait;

    /**
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @Type("string")
     * @var string
     */
    private $name;

    /**
     * @Type("ArrayCollection<BRMControl\Device\Command>")
     * @var ArrayCollection
     */
    private $commands;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = $this->generateHash($name);
        $this->commands = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

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
