<?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcBRMControl_KernelProdDebugContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->staticRoutes = [
            '/widget/show' => [[['_route' => 'widget_show', '_controller' => 'BRMControl\\Controller\\WidgetController::actionShow'], null, null, null, false, false, null]],
        ];
        $this->regexpList = [
            0 => '{^(?'
                    .'|/api/command/send/([^/]++)/([^/]++)(*:42)'
                .')/?$}sDu',
        ];
        $this->dynamicRoutes = [
            42 => [[['_route' => 'api_command_send', '_controller' => 'BRMControl\\Controller\\ApiController::actionRemote'], ['remoteId', 'commandId'], null, null, false, true, null]],
        ];
    }
}
