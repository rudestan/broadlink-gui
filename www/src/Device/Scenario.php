<?php

namespace BRMControl\Device;

use BRMControl\Device\Traits\HashableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Scenario
{
    use HashableTrait;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $id;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<BRMControl\Device\ScenarioItem>")
     */
    private $items;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = $this->generateHash($name);
        $this->items = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    public function setItems(ArrayCollection $items): void
    {
        $this->items = $items;
    }

    public function addScenarioItem(ScenarioItem $scenarioItem): void
    {
        $this->items->add($scenarioItem);
    }
}
