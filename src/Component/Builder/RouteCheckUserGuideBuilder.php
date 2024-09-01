<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

use Symfony\Component\HttpFoundation\Request;

/**
 * Route check implementation of the {@link UserGuideBuilder}
 */
class RouteCheckUserGuideBuilder implements UserGuideBuilder {

    private ?string $route = null;
    private array $additionalRoutes = [];

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
        return $this;
    }

    /**
     * Checks if the route is matching to the assigned routes
     * @param Request $request request to check
     * @return bool
     */
    public function isMatching(Request $request) : bool {
        if($this->route == null  && count($this->additionalRoutes) == 0) {
            return true;
        }
        $route = $request->attributes->get('_route');
        return $this->route === $route || in_array($route, $this->additionalRoutes);
    }

}