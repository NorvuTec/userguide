<?php

namespace Norvutec\UserGuideBundle\Event;

class UserGuideEvents {

    /**
     * @Event("Norvutec\UserGuideBundle\Event\UserGuideStartedEvent")
     */
    public const USER_GUIDE_STARTED = 'norvutec.user_guide.started';
    /**
     * @Event("Norvutec\UserGuideBundle\Event\UserGuideCompletedEvent")
     */
    public const USER_GUIDE_COMPLETED = 'norvutec.user_guide.completed';

}