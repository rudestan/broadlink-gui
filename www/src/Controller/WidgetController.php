<?php

namespace BRMControl\Controller;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
use BRMControl\Device\Scenario;
use BRMControl\Service\DeviceReader;
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
     * @var DeviceReader
     */
    private $deviceReader;

    public function __construct(DeviceReader $deviceReader)
    {
        $this->deviceReader = $deviceReader;
    }

    /**
     * @Route("/", name="widget_show")
     */
    public function actionShow(Request $request): Response
    {
        $devices = $this->deviceReader->readDevices();

        /** @var RMPPlus $device */
        $device = $devices->first();

        return new Response(
            $this->renderView(
                'Controller/widget/Show/show.html.twig',
                [
                    'remotes' => $this->getRemotes($device),
                    'scenarios' => $this->getScenarios($device),
                ]
            )
        );
    }

    private function getScenarios(RMPPlus $device): array
    {
        $scenarios = [];

        /** @var Scenario $scenario */
        foreach ($device->getScenarios() as $scenario) {
            $scenarios[] = [
                'id' => $scenario->getId(),
                'name' => $scenario->getName(),
            ];
        }

        return $scenarios;
    }

    private function getRemotes(RMPPlus $device): array
    {
        $remotesData = [];

        /** @var Remote $remote */
        foreach ($device->getRemotes() as $remote) {
            $remoteItem = [
                'name' => $remote->getName(),
                'id' => $remote->getId(),
                'type' => 'remote',
                'commands' => [],
            ];

            /** @var Command $command */
            foreach ($remote->getCommands() as $command) {
                $commandItem = [
                    'id' => $command->getId(),
                    'name' => $command->getName(),
                    'icon_class' => $command->getIconClass(),
                    'color_class' => $command->getColorClass(),
                ];

                $remoteItem['commands'][] = $commandItem;
            }

            $remotesData[] = $remoteItem;
        }

        return $remotesData;
    }
}
