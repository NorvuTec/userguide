<?php

namespace Norvutec\UserGuideBundle\Twig;

use Norvutec\UserGuideBundle\Component\Builder\RouteCheckUserGuideBuilder;
use Norvutec\UserGuideBundle\Component\UserGuideHandler;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TemplateLoaderExtension extends AbstractExtension {

    public function __construct(
        private readonly UserGuideHandler   $handler,
        private readonly Request            $request
    )
    {

    }

    public function getFunctions(): array {
        return [
            new TwigFunction('userGuideJavascript', [$this, 'userGuideJavascript'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    /**
     * Returns the javascript includes for the user guides on page load
     * @param Environment $environment twig environment
     * @return string javascript includes
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function userGuideJavascript(Environment $environment): string {
        $runningGuide =  $this->handler->getRunningGuide();
        if($runningGuide != null) {
            $routeCheckBuilder = new RouteCheckUserGuideBuilder();
            $runningGuide->configure($routeCheckBuilder);
            if(!$routeCheckBuilder->isMatching($this->request)) {
                // Wrong route for the guide
                $runningGuide = null;
            }
        }
        return $environment->render('@NorvutecUserGuideBundle/guide/javascript.html.twig', [
            "currentGuide" => $runningGuide,
            "currentStep" => $this->handler->getRunningGuideStep()
        ]);
    }

}