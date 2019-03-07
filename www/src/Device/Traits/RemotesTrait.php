<?php

namespace BRMControl\Device\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use BRMControl\Device\Remote;

trait RemotesTrait
{
    /**
     * @var ArrayCollection|null
     */
    private $remotes;

    public function getRemotes(): ?ArrayCollection
    {
        return $this->remotes;
    }

    public function setRemotes(ArrayCollection $remotes): void
    {
        $this->remotes = $remotes;
    }

    public function addRemote(Remote $remote): void
    {
        $this->remotes->add($remote);
    }

    public function isRemoteExist(string $name): bool
    {
        return $this->remotes->exists(function (string $key, Remote $el) use ($name) {
            return $el->getName() === $name;
        });
    }

    public function getRemotesWithNamesAsKeys(): array
    {
        $remoteNames = [];

        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            $remoteNames[$remote->getName()] = $remote;
        }

        return $remoteNames;
    }

    public function getRemoteByName(string $name): ?Remote
    {
        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            if ($remote->getName() === $name) {
                return $remote;
            }
        }

        return null;
    }

    public function getRemoteById(string $id): ?Remote
    {
        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            if ($remote->getId() === $id) {
                return $remote;
            }
        }

        return null;
    }

    public function getRemoteByCommandId(string $id): ?Remote
    {
        /** @var Remote $remote */
        foreach ($this->getRemotes() as $remote) {
            $command = $remote->getCommandById($id);

            if ($command === null) {
                continue;
            }

            if ($command->getId() === $id) {
                return $remote;
            }
        }

        return null;
    }
}
