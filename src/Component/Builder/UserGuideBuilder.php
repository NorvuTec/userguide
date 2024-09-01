<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

/**
 * Builder for user guides
 * The builder is used to configure the user guide
 */
interface UserGuideBuilder {

    /**
     * Option to set the title of the step
     */
    public const OPTION_TITLE = "title";
    /**
     * Let the screen scroll to the element
     */
    public const OPTION_AUTOSCROLL = "autoscroll";

    /**
     * Set the default / starting route for the user guide
     * Allows the user guide to be started from guide list
     * @param string $route Default route
     */
    public function route(string $route): static;

    /**
     * Add an alternate route to the user guide
     * Will be used if you have different routes for e.g. the same form
     * @param string $route Alternate route
     */
    public function alternateRoute(string $route): static;

    /**
     * Add a new step to the user guide
     * @param string $selector CSS selector to attach
     * @param string $content Content of the step
     * @param array $options Options for the step
     */
    public function add(string $selector, string $content, array $options = []): static;

}