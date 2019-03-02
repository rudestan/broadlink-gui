<?php

namespace BRMControl\Service;

use BRMControl\Device\Command;
use BRMControl\Device\RMPPlus;
use BRMControl\Exception\ItemNotFoundException;

class CommandProvider
{
    public function getByIdAndRemoteId(RMPPlus $device, string $commandId, string $remoteId): Command
    {
        $remote = $device->getRemoteById($remoteId);

        if ($remote === null) {
            throw new ItemNotFoundException('The Remote with id "'.$remoteId.'" was not found.');
        }

        $command = $remote->getCommandById($commandId);

        if ($command === null) {
            throw new ItemNotFoundException('The Command with id "'.$commandId.'" was not found.');
        }

        return $command;
    }
}
