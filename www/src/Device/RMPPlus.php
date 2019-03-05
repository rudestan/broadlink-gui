<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

class RMPPlus
{
    use HashableTrait;

    private const DEVICE_PREFIX = 'RM Pro+ #';

    /**
     * @Type("string")
     * @var string
     */
    private $id;

    /**
     * @Type("string")
     * @var string
     */
    private $mac;

    /**
     * @Type("string")
     * @var string
     */
    private $ip;

    /**
     * @Type("string")
     * @var string|null
     */
    private $name;

    /**
     * @Type("ArrayCollection<BRMControl\Device\Remote>")
     * @var ArrayCollection
     */
    private $remotes;

    /**
     * @Type("ArrayCollection<BRMControl\Device\Scenario>")
     * @var ArrayCollection
     */
    private $scenarios;

    /**
     * @Exclude
     * @var string|null
     */
    private $filename = null;

    public function __construct(string $ip, string $mac, ?string $name = null)
    {
        $this->ip = $ip;
        $this->mac = $mac;
        $this->id = $this->generateHash($mac);
        $this->name = $name ?? self::DEVICE_PREFIX . $this->id;
        $this->remotes = new ArrayCollection();
        $this->scenarios = new ArrayCollection();
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMac(): string
    {
        return $this->mac;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getRemotes(): ArrayCollection
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

    public function getScenarios(): ArrayCollection
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

    public function isPersisted() {
        return $this->filename === null;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
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

    public function getScenariosWithNamesAsKeys(): array
    {
        $scenarios = [];

        /** @var Scenario $scenario */
        foreach ($this->getScenarios() as $scenario) {
            $scenarios[$scenario->getName()] = $scenario;
        }

        return $scenarios;
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
