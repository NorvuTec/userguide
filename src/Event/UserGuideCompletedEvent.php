<?php

namespace Norvutec\UserGuideBundle\Event;

use Norvutec\UserGuideBundle\Component\UserGuide;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event dispatched when a user guide is completed.
 */
final class UserGuideCompletedEvent extends Event {

    public function __construct(
        private readonly UserGuide $userGuide
    ) {

    }

    /**
     * Get the user guide that was completed.
     * @return UserGuide
     */
    public function getUserGuide(): UserGuide
    {
        return $this->userGuide;
    }

}