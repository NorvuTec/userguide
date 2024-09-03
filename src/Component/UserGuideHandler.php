<?php

namespace Norvutec\UserGuideBundle\Component;

use Norvutec\UserGuideBundle\Component\Builder\DefaultUserGuideBuilder;
use Norvutec\UserGuideBundle\Event\UserGuideCompletedEvent;
use Norvutec\UserGuideBundle\Event\UserGuideEvents;
use Norvutec\UserGuideBundle\Event\UserGuideStartedEvent;
use Norvutec\UserGuideBundle\Exception\InvalidUserGuideException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Handles the execution and management of user guides
 */
readonly class UserGuideHandler {

    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private UserGuideRegistry        $registry,
        private RequestStack             $requestStack,
        private Environment              $twig
    ) { }

    /**
     * Returns the user guide session bag of the current user
     * @param bool $register whether to register the bag if it does not exist
     * @return ?UserGuideBag
     */
    private function getBag(bool $register): ?UserGuideBag {
        try{
            $bag = $this->requestStack->getCurrentRequest()->getSession()->getBag('user_guide');
            if($bag instanceof UserGuideBag) {
                return $bag;
            }
            throw new \InvalidArgumentException("The bag is not an instance of UserGuideBag");
        }catch (\InvalidArgumentException $e) {
            if($register) {
                $newBag = new UserGuideBag();
                $this->requestStack->getCurrentRequest()->getSession()->registerBag($newBag);
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
     * Sets the current step of the running user guide
     * @param string $guideId id of the user guide
     */
    public function setRunningGuide(string $guideId): void {
        $this->getBag(true)->setCurrentGuide($guideId);
    }

    /**
     * Returns the current step of the running user guide
     * @return int|null the current step of the running user guide
     */
    public function getRunningGuideStep(): ?int {
        return $this->getBag(false)?->getCurrentStep();
    }

    /**
     * Sets the current step of the running user guide
     * @param string $guideId id of the user guide
     * @param int $guideStep step to set
     */
    public function setRunningGuideStep(string $guideId, int $guideStep): void {
        $this->getBag(true)->setCurrentGuide($guideId);
        $this->getBag(false)->setCurrentStep($guideStep);
    }

    /**
     * Completes the current user guide
     * @param string $guideId id of the user guide to complete
     */
    public function completeGuide(string $guideId): void {
        if($this->getBag(false)?->getCurrentGuide() == $guideId) {
            $this->getBag(false)->setCurrentGuide(null);
            $this->getBag(false)->setCurrentStep(0);
        }
        $guide = $this->registry->getUserGuideById($guideId);
        if($guide != null) {
            $event = new UserGuideCompletedEvent($guide);
            $this->dispatcher->dispatch($event, UserGuideEvents::USER_GUIDE_COMPLETED);
        }
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

    /**
     * generates the json data for the user guide
     * @param UserGuide $guide user guide
     * @return array guide data
     * @throws Error
     */
    public function getGuideData(UserGuide $guide) : array {
        $builder = new DefaultUserGuideBuilder();
        $guide->configure($builder);
        return [
            "id" => $guide->id(),
            "name" => $guide->name(),
            "steps" => $builder->getStepsWithTemplate($this->twig)
        ];
    }

}