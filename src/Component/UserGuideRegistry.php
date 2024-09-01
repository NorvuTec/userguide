<?php

namespace Norvutec\UserGuideBundle\Component;

/**
 * Registry for the user guides in the system
 * This registry is used to store all user guides in the system
 * @package Norvutec\UserGuideBundle\Registry
 */
class UserGuideRegistry {

    /**
     * @param iterable $userGuides The user guides by tag norvutec.user_guide.guide
     */
    public function __construct(
        private iterable $userGuides
    )
    { }

    /**
     * Adds a user guide to the registry
     * @param UserGuide $guide The user guide to add
     * @return void
     */
    public function addUserGuide(UserGuide $guide): void {
        $this->userGuides[] = $guide;
    }

    /**
     * Gets a user guide by its id
     * The default id is the md5 of the full class name
     * @param string $userGuideId The id of the user guide
     * @return UserGuide|null The user guide or null if not found
     */
    public function getUserGuideById(string $userGuideId) : ?UserGuide {
        /** @var UserGuide $userGuide */
        foreach($this->userGuides as $userGuide) {
            if($userGuide->id() === $userGuideId) {
                return $userGuide;
            }
        }
        return null;
    }

    /**
     * Gets all user guides
     * @return array<UserGuide> All user guides
     */
    public function all() : array {
        return iterator_to_array($this->userGuides);
    }

}