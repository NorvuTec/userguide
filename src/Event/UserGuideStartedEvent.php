<?php

namespace Norvutec\UserGuideBundle\Event;

use Norvutec\UserGuideBundle\Component\UserGuide;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event dispatched when a user guide is started.
 */
final class UserGuideStartedEvent extends Event {

    public function __construct(
        private UserGuide $userGuide
    ) {

    }

    /**
     * Get the user guide that was started.
     * @return UserGuide
     */
    public function getUserGuide(): UserGuide
    {
        return $this->userGuide;
    }

}