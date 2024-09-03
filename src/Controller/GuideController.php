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
     * Handles a step of the guide as loaded
     * @param string $guide guide id
     * @param int $step step number
     * @return JsonResponse
     */
    #[Route('/userguide/set_step_loaded/{guide}/{step}', name: 'set_step_loaded', methods: ['POST'])]
    public function setLoadedStep(string $guide, int $step): JsonResponse {
        $this->handler->setRunningGuideStep($guide, $step);
        return $this->json(['success' => true]);
    }

    /**
     * Handles the guide as completed
     * @param string $guide guide id
     * @return JsonResponse
     */
    #[Route('/userguide/set_guide_complete/{guide}', name: 'set_guide_complete', methods: ['POST'])]
    public function setGuideComplete(string $guide): JsonResponse {
        $this->handler->completeGuide($guide);
        return $this->json(['success' => true]);
    }

    /**
     * Loads the user guide for javascript
     * @param string $guide guide id to load
     * @return JsonResponse guide data
     * @throws InvalidUserGuideException
     * @throws Error
     */
    #[Route('/userguide/load/{guide}', name: 'load')]
    public function ajaxGuide(string $guide): JsonResponse {
        $guide = $this->registry->getUserGuideById($guide);
        if($guide == null) {
            throw new InvalidUserGuideException($guide);
        }
        $this->handler->setRunningGuide($guide->id());
        return $this->json($this->handler->getGuideData($guide));
    }

}