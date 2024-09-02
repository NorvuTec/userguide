<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Default implementation of the {@link UserGuideBuilder}
 */
class DefaultUserGuideBuilder implements UserGuideBuilder {

    private ?string $route = null;
    private array $additionalRoutes = [];
    private array $steps = [];

    public function __construct() {

    }

    /**
     * @inheritDoc
     */
    public function route(string $route): static {
        $this->route = $route;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function alternateRoute(string $route): static {
        $this->additionalRoutes[] = $route;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(string $selector, string $content, array $options = []): static {
        $this->steps[] = [
            "selector" => $selector,
            "content" => $content,
            "options" => $options
        ];
        return $this;
    }

    /**
     * Returns the steps as built array including "template" key
     * @param Environment $twig
     * @return array
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getStepsWithTemplate(Environment $twig): array {
        $steps = $this->steps;
        $counter = 0;
        foreach($steps as $step) {
            $step['template'] = $twig->render('@NorvutecUserGuideBundle/tooltip.html.twig', [
                "title" => ($step['options'][self::OPTION_TITLE] ?? null),
                "content" => $step['content'],
                "options" => $step['options'],
                "isFirst" => $counter == 0,
                "isLast" => $counter == (count($steps) - 1)
            ]);
            $counter++;
        }
        return $steps;
    }

}