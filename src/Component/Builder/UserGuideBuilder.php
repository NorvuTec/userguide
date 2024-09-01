<?php

namespace Norvutec\UserGuideBundle\Component\Builder;

/**
 * Builder for user guides
 * The builder is used to configure the user guide
 */
interface UserGuideBuilder {

    /**
     * Let the screen scroll to the element
     */
    public const OPTION_AUTOSCROLL = "autoscroll";

    /**
     * Set the default / starting route for the user guide
     * Allows the user guide to be started from guide list
     * @param string $route Default route
     * @return void
     */
    public function route(string $route) : void;

    /**
     * Add a new step to the user guide
     * @param string $selector CSS selector to attach
     * @param string $content Content of the step
     * @param array $options Options for the step
     * @return void
     */
    public function add(string $selector, string $content, array $options = []) : void;

}