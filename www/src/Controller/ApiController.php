<?php
/**
 * Created by PhpStorm.
 * User: devstan
 * Date: 2019-02-24
 * Time: 20:11
 */

namespace BRMControl\Controller;

use BRMControl\Device\Command;
use BRMControl\Device\DeviceStorage;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Device\Type\AbstractDevice;
use BRMControl\Factory\DeviceFactory;
use BRMControl\Service\DeviceApiClient;
use BRMControl\Service\DeviceStorageReader;
use BRMControl\Service\DeviceStorageWriter;
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
     * @var DeviceApiClient
     */
    private $deviceApiCLient;

    /**
     * @var DeviceFactory
     */
    private $deviceFactory;

    /**
     * @var DeviceStorageReader
     */
    private $deviceStorageReader;

    /**
     * @var DeviceStorageWriter
     */
    private $deviceStorageWriter;

    public function __construct(
        DeviceApiClient $deviceApiClient,
        DeviceFactory $deviceFactory,
        DeviceStorageReader $deviceStorageReader,
        DeviceStorageWriter $deviceStorageWriter
    ) {
        $this->deviceApiCLient = $deviceApiClient;
        $this->deviceFactory = $deviceFactory;
        $this->deviceStorageReader = $deviceStorageReader;
        $this->deviceStorageWriter = $deviceStorageWriter;
    }

    /**
     * @Route("/device/discover", name="api_device_discover")
     */
    public function actionDiscover(): JsonResponse
    {
        $data = [
            'devices' => []
        ];

        $devices = $this->deviceApiCLient->discover();

        /** @var AbstractDevice $device */
        foreach ($devices as $device) {
            $data['devices'][] = [
                'id' => $device->getId(),
                'internalId' => $device->getInternalId(),
                'type' => $device->getType(),
                'ip' => $device->getIp(),
                'mac' => $device->getMac(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/device/authenticate", name="api_device_authenticate", methods={"POST"})
     */
    public function actionAuthenticate(Request $request): JsonResponse
    {
        $data = [
            'authenticated' => false,
            'error' => 'Unknown error'
        ];

        $internalId = $request->get('internalId');
        $ip = $request->get('ip');
        $mac = $request->get('mac');

        $device = $this->deviceFactory->createFromArgs($internalId, $ip, $mac);

        if (!$device) {
            $data['error'] = 'Unknown device';

            return new JsonResponse($data);
        }

        $data['authenticated'] = $this->deviceApiCLient->authenticate($device);

        if (!$data['authenticated']) {
            $data['error'] = 'Failed to authenticate device';
        } else {
            $data['error'] = '';
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/device/add", name="api_device_add", methods={"POST"})
     */
    public function addDevice(Request $request): JsonResponse
    {
        $data = ['success' => false];

        $name = $request->get('name');
        $internalId = $request->get('internalId');
        $ip = $request->get('ip');
        $mac = $request->get('mac');

        $device = $this->deviceFactory->createFromArgs($internalId, $ip, $mac, $name);

        if (!$device) {
            return new JsonResponse($data);
        }

        $deviceStorage = $this->deviceStorageReader->readDeviceStorage();

        if ($deviceStorage === null) {
            $deviceStorage = new DeviceStorage();

            $deviceStorage->addDevice($device);

            $data['success'] = $this->deviceStorageWriter->saveNewDeviceStorage($deviceStorage);
        } else {
            if(!$deviceStorage->isDeviceExist($device->getId())) {
                $deviceStorage->addDevice($device);

                $data['success'] = $this->deviceStorageWriter->saveDeviceStorage($deviceStorage);
            }
        }

        return new JsonResponse($data);
    }
}
