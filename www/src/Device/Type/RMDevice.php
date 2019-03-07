<?php

namespace BRMControl\Device\Type;

use BRMControl\Device\Traits\RemotesTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use BRMControl\Device\Remote;
use BRMControl\Device\Command;
use JMS\Serializer\Annotation\PostDeserialize;

class RMDevice extends AbstractDevice
{
    use RemotesTrait;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\Remote>")
     */
    private $remotes;

    public function __construct(string $ip, string $mac, ?string $name = null)
    {
        parent::__construct($ip, $mac, $name);

        $this->remotes = new ArrayCollection();
    }

    public function getType(): string
    {
        return self::TYPE_RM;
    }

    public function getCommandById(string $id): ?Command
    {
        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            $command = $remote->getCommandById($id);

            if ($command === null) {
                continue;
            }

            if ($command->getId() === $id) {
                return $command;
            }
        }

        return null;
    }

    public function getCommands(): ArrayCollection
    {
        $commands = [];

        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            $commands = array_merge($commands, $remote->getCommands()->toArray());
        }

        return new ArrayCollection($commands);
    }
}
