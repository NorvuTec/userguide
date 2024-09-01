<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

/**
 * Default implementation of the {@link UserGuideBuilder}
 */
class DefaultUserGuideBuilder implements UserGuideBuilder {

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

}