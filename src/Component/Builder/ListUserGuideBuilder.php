<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

/**
 * Default implementation of the {@link UserGuideBuilder}
 */
class ListUserGuideBuilder implements UserGuideBuilder {

    private ?string $route = null;
    private array $steps = [];

    public function __construct() {

    }

    /**
     * @inheritDoc
     */
    public function route(string $route): void {
        $this->route = $route;
    }

    /**
     * @inheritDoc
     */
    public function add(string $selector, string $content, array $options = []): void {
        $this->steps[] = [
            "selector" => $selector,
            "content" => $content,
            "options" => $options
        ];
    }

    public function stepsCount() : int {
        return count($this->steps);
    }

    public function getRoute() : ?string {
        return $this->route;
    }

}