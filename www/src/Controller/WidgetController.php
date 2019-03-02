<?php

namespace BRMControl\Controller;

use BRMControl\Device\Command;
use BRMControl\Device\Remote;
use BRMControl\Device\RMPPlus;
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

        $remotesData = [];

        $remotes = $device->getRemotes();

        /** @var Remote $remote */
        foreach ($remotes as $remote) {
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

        return new Response(
            $this->renderView(
                'Controller/widget/Show/show.html.twig',
                [
                    'remotes' => $remotesData,
                ]
            )
        );
    }
}
