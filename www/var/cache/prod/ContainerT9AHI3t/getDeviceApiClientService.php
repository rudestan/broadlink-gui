<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'BRMControl\Service\DeviceApiClient' shared autowired service.

include_once $this->targetDirs[3].'/src/Service/DeviceApiClient.php';
include_once $this->targetDirs[3].'/src/Service/CommandCodeEncoder.php';

return $this->privates['BRMControl\Service\DeviceApiClient'] = new \BRMControl\Service\DeviceApiClient(($this->privates['BRMControl\Service\CommandCodeEncoder'] ?? ($this->privates['BRMControl\Service\CommandCodeEncoder'] = new \BRMControl\Service\CommandCodeEncoder())));
