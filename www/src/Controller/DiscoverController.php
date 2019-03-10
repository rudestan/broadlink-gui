<?php

namespace BRMControl\Controller;

use BRMControl\Provider\WidgetViewProvider;
use BRMControl\Service\DeviceStorageReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discover")
 */
class DiscoverController extends AbstractController
{
    /**
     * @Route("/", name="discover_index")
     */
    public function actionIndex(Request $request): Response
    {
        return new Response($this->renderView('Controller/Discover/index.html.twig'));
    }
}
