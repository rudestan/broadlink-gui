<?php
/**
 * Created by PhpStorm.
 * User: devstan
 * Date: 2019-02-23
 * Time: 19:26
 */

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;

class RMPPlus
{
    use HashableTrait;

    private const DEVICE_PREFIX = 'RM Pro+ #';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $mac;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $remotes;

    /**
     * @var ArrayCollection
     */
    private $scenarios;

    /**
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
        $this->remotes->set($remote->getId(), $remote);
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
        $this->scenarios->set($scenario->getId(), $scenario);
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
