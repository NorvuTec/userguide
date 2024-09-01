<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

/**
 * Default implementation of the {@link UserGuideBuilder}
 */
class ListUserGuideBuilder implements UserGuideBuilder {

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

    public function getSteps(): array{
        return $this->steps;
    }

    public function getAlternateRoutes() : array {
        return $this->additionalRoutes;
    }

    public function stepsCount() : int {
        return count($this->steps);
    }

    public function getRoute() : ?string {
        return $this->route;
    }

    public function alternateRouteCount(): int{
        return count($this->additionalRoutes);
    }

}