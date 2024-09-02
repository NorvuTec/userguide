<?php

namespace Norvutec\UserGuideBundle\Controller;

use Norvutec\UserGuideBundle\Component\UserGuideHandler;
use Norvutec\UserGuideBundle\Component\UserGuideRegistry;
use Norvutec\UserGuideBundle\Exception\InvalidUserGuideException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Error\Error;

#[AsController]
class GuideController extends AbstractController {

    public function __construct(
        private readonly UserGuideRegistry $registry,
        private readonly UserGuideHandler $handler
    ) { }

    /**
     * Loads the user guide for javascript
     * @param string $guide guide id to load
     * @return JsonResponse guide data
     * @throws InvalidUserGuideException
     * @throws Error
     */
    #[Route('/userguide/load/{guide}', name: 'userguide_load')]
    public function ajaxGuide(string $guide): JsonResponse {
        $guide = $this->registry->getUserGuideById($guide);
        if($guide == null) {
            throw new InvalidUserGuideException($guide);
        }
        return $this->json($this->handler->getGuideData($guide));
    }

}