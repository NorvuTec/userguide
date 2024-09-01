<?php

namespace Norvutec\UserGuideBundle\Controller;

use Norvutec\UserGuideBundle\Component\UserGuideRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class GuideController extends AbstractController {

    public function __construct(
        private readonly UserGuideRegistry $registry
    ) { }

    #[Route("/userguide/userguide.js", name: "userguide_script", methods: ["GET"], stateless: true)]
    public function javascript() : Response {
        return new Response(
            $this->renderView('@NorvutecUserGuideBundle/guide/script.js.twig'),
            200,
            ['Content-Type' => 'text/javascript']
        );
    }

    #[Route("/userguide/userguide.css", name: "userguide_stylesheet", methods: ["GET"], stateless: true)]
    public function stylesheet() : Response {
        return new Response(
            $this->renderView('@NorvutecUserGuideBundle/guide/stylesheet.css.twig'),
            200,
            ['Content-Type' => 'text/css']
        );
    }

}