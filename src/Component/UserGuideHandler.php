<?php

namespace Norvutec\UserGuideBundle\Component;

use Norvutec\UserGuideBundle\Event\UserGuideEvents;
use Norvutec\UserGuideBundle\Event\UserGuideStartedEvent;
use Norvutec\UserGuideBundle\Exception\InvalidUserGuideException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles the execution and management of user guides
 */
readonly class UserGuideHandler {

    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private UserGuideRegistry        $registry,
        private Request                  $request
    ) { }

    /**
     * Returns the user guide session bag of the current user
     * @param bool $register whether to register the bag if it does not exist
     * @return ?UserGuideBag
     */
    private function getBag(bool $register): ?UserGuideBag {
        try{
            $bag = $this->request->getSession()->getBag('user_guide');
            if($bag instanceof UserGuideBag) {
                return $bag;
            }
            throw new \InvalidArgumentException("The bag is not an instance of UserGuideBag");
        }catch (\InvalidArgumentException $e) {
            if($register) {
                $newBag = new UserGuideBag();
                $this->request->getSession()->registerBag($newBag);
                return $newBag;
            }
        }
        return null;
    }

    /**
     * Returns the currently running user guide for this user
     * @return UserGuide|null the currently running user guide
     */
    public function getRunningGuide() : ?UserGuide {
        $currentGuideId = $this->getBag(false)?->getCurrentGuide();
        if($currentGuideId == null) {
            return null;
        }
        return $this->registry->getUserGuideById($currentGuideId);
    }

    /**
     * Starts a new user guide by its id
     * @param string $userGuideId id of the user guide to start
     * @throws InvalidUserGuideException
     */
    public function startUserGuideById(string $userGuideId) : void {
        $userGuide = $this->registry->getUserGuideById($userGuideId);
        if($userGuide == null) {
            throw new InvalidUserGuideException($userGuideId);
        }
        $this->startUserGuide($userGuide);
    }

    /**
     * Starts a new user guide
     * @param UserGuide $userGuide
     */
    public function startUserGuide(UserGuide $userGuide) : void {
        $bag = $this->getBag(true);
        $bag->setCurrentGuide($userGuide->id());
        $bag->setCurrentStep(0);

        $event = new UserGuideStartedEvent($userGuide);
        $this->dispatcher->dispatch($event, UserGuideEvents::USER_GUIDE_STARTED);
    }

}