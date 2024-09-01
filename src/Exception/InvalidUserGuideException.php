<?php

namespace Norvutec\UserGuideBundle\Exception;

/**
 * Exception thrown when a user guide with a given id does not exist.
 */
final class InvalidUserGuideException extends \Exception {

    public function __construct(
        private readonly string $guideId
    ) {
        parent::__construct("The user guide with id '{$guideId}' does not exist.");
    }

    /**
     * Get the id of the user guide that was not found.
     * @return string
     */
    public function getGuideId(): string
    {
        return $this->guideId;
    }

}