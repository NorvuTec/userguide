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
        $steps = [];
        $counter = 0;
        foreach($this->steps as $step) {
            $step['template'] = $twig->render('@NorvutecUserGuide/tooltip.html.twig', [
                "title" => ($step['options'][self::OPTION_TITLE] ?? null),
                "content" => $step['content'],
                "options" => $step['options'],
                "isFirst" => $counter == 0,
                "isLast" => $counter == (count($this->steps) - 1),
                "step" => ($counter + 1)
            ]);
            $step['step'] = ($counter + 1);
            $steps[] = $step;
            $counter++;
        }
        return $steps;
    }

}