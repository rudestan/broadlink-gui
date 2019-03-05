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
}
