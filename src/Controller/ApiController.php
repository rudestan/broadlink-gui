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
use BRMControl\Service\DeviceApiClient;
use BRMControl\Service\DeviceReader;
use Symfony\Component\HttpFoundation\Response;
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
     * @var DeviceApiClient
     */
    private $deviceApiClient;

    public function __construct(DeviceReader $deviceReader, DeviceApiClient $deviceApiClient)
    {
        $this->deviceReader = $deviceReader;
        $this->deviceApiClient = $deviceApiClient;
    }

    /**
     * @Route("/command/send/{remoteId}/{commandId}", name="api_command_send")
     */
    public function actionRemote(Request $request, string $remoteId, string $commandId): JsonResponse
    {
        $devices = $this->deviceReader->readDevices();

        /** @var RMPPlus $device */
        $device = $devices->first();

        /** @var Remote $remote */
        $remote = $device->getRemoteById($remoteId);

        if (!$remote) {
            return new JsonResponse(['success' => false]);
        }

        /** @var Command $command */
        $command = $remote->getCommandById($commandId);

        if (!$command) {
            return new JsonResponse(['success' => false]);
        }

        $this->deviceApiClient->sendCommand($device, $command);

        return new JsonResponse(['success' => true]);
    }
}