<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'BRMControl\Command\CreateRemoteCommand' shared autowired service.

include_once $this->targetDirs[3].'/vendor/symfony/console/Command/Command.php';
include_once $this->targetDirs[3].'/src/Command/AbstractCommand.php';
include_once $this->targetDirs[3].'/src/Command/Traits/SaveDeviceTrait.php';
include_once $this->targetDirs[3].'/src/Command/CreateRemoteCommand.php';

$this->privates['BRMControl\Command\CreateRemoteCommand'] = $instance = new \BRMControl\Command\CreateRemoteCommand(($this->privates['BRMControl\Service\DeviceReader'] ?? $this->load('getDeviceReaderService.php')), ($this->privates['BRMControl\Service\DeviceWriter'] ?? $this->load('getDeviceWriterService.php')));

$instance->setName('rmproplus:remote:create');

return $instance;
