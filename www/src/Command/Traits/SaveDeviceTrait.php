<?php

namespace BRMControl\Command\Traits;

use BRMControl\Device\RMPPlus;

trait SaveDeviceTrait
{
    private function saveDevice(RMPPlus $device, string $name, string $type): bool
    {
        $res = $this->deviceWriter->saveDevice($device->getFilename(), $device);

        if ($res) {
            $this->output->writeln('<okresult>'.$type.' "'.$name.'" saved successfully!</okresult>');
        } else {
            $this->output->writeln('<warn>Failed to save the "'.$name.'" '.$type.'!.</warn>');
        }

        return $res;
    }
}
