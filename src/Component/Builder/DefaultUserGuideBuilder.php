<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

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

}