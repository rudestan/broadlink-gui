<?php
/**
 * Created by PhpStorm.
 * User: devstan
 * Date: 2019-02-24
 * Time: 20:11
 */

namespace BRMControl\Controller;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Service\DeviceApiClient;
use BRMControl\Service\DeviceReader;
use BRMControl\Service\ScenarioPlayer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @var DeviceReader
     */
    private $deviceReader;

    /**
     * @var ScenarioPlayer
     */
    private $scenarioPlayer;

    /**
     * @var DeviceApiClient
     */
    private $deviceApiClient;

    public function __construct(DeviceReader $deviceReader, ScenarioPlayer $scenarioPlayer, DeviceApiClient $deviceApiClient)
    {
        $this->deviceReader = $deviceReader;
        $this->scenarioPlayer = $scenarioPlayer;
        $this->deviceApiClient = $deviceApiClient;
    }

    /**
     * @Route("/command/send/{commandId}", name="api_command_send")
     */
    public function actionRemote(Request $request, string $commandId): JsonResponse
    {
        $devices = $this->deviceReader->readDevices();

        /** @var RMPPlus $device */
        $device = $devices->first();

        /** @var Command $remote */
        $command = $device->getCommandById($commandId);

        if (!$command) {
            return new JsonResponse(['success' => false]);
        }

        $this->deviceApiClient->sendCommand($device, $command);

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/scenario/run/{scenarioId}", name="api_scenario_run")
     */
    public function actionScenario(Request $request, string $scenarioId): JsonResponse
    {
        $devices = $this->deviceReader->readDevices();

        /** @var RMPPlus $device */
        $device = $devices->first();

        /** @var Scenario $scenario */
        $scenario = $device->getScenarioById($scenarioId);

        if (!$scenario) {
            return new JsonResponse(['success' => false]);
        }

        $this->scenarioPlayer->playScenario($device, $scenario);

        return new JsonResponse(['success' => true]);
    }
}