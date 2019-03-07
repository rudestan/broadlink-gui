<?php

namespace BRMControl\Controller;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Provider\WidgetViewProvider;
use BRMControl\Service\DeviceStorageReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/widget")
 */
class WidgetController extends AbstractController
{
    /**
     * @var DeviceStorageReader
     */
    private $deviceReader;

    /**
     * @var WidgetViewProvider
     */
    private $widgetViewProvider;

    public function __construct(DeviceStorageReader $deviceReader, WidgetViewProvider $widgetViewProvider)
    {
        $this->deviceReader = $deviceReader;
        $this->widgetViewProvider = $widgetViewProvider;
    }

    /**
     * @Route("/all/{type}", name="widget_all")
     */
    public function actionAll(Request $request, ?string $type = null): Response
    {
        $data = $this->widgetViewProvider->getWidgetViewData($type);

        return new Response($this->renderView('Controller/widget/All/all.html.twig', $data));
    }

    /**
     * @Route("/remote/single/{remoteId}", name="widget_remote_single")
     */
    public function actionRemoteSingle(Request $request, string $remoteId): Response
    {
        $devices = $this->deviceReader->readDevices();
        $data = [];

        if ($devices->count() !== 0) {
            /** @var RMPPlus $device */
            $device = $devices->first();

            $remote = $device->getRemoteById($remoteId);

            if ($remote) {
                $data = $this->widgetViewProvider->getRemoteViewData($remote);
            }
        }

        return new Response($this->renderView('Controller/widget/Remote/single.html.twig', $data));
    }

    /**
     * @Route("/scenario/single/{scenarioId}", name="widget_scenario_single")
     */
    public function actionScenarioSingle(Request $request, string $scenarioId): Response
    {
        $devices = $this->deviceReader->readDevices();
        $data = [];

        if ($devices->count() !== 0) {
            /** @var RMPPlus $device */
            $device = $devices->first();

            $scenario = $device->getScenarioById($scenarioId);

            if ($scenario) {
                $data = $this->widgetViewProvider->getScenarioViewData($scenario);
            }
        }

        return new Response($this->renderView('Controller/widget/Scenario/single.html.twig', $data));
    }
}
