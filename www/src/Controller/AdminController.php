<?php

namespace BRMControl\Controller;

use BRMControl\Provider\WidgetViewProvider;
use BRMControl\Service\DeviceStorageReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
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
     * @Route("/", name="admin_main")
     */
    public function actionIndex(Request $request): Response
    {
        return new Response($this->renderView('Controller/Admin/Index/index.html.twig'));
    }

    /**
     * @Route("/widget/edit", name="widget_edit")
     */
    public function editWidget(Request $request): Response
    {
        $data = $this->widgetViewProvider->getWidgetViewData();

        return new Response($this->renderView('Controller/Admin/Widget/edit.html.twig', $data));
    }
}
