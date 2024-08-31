<?php

namespace Norvutec\UserGuideBundle;

use Norvutec\UserGuideBundle\DependencyInjection\UserGuideExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class NorvutecUserGuideBundle extends AbstractBundle {

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new UserGuideExtension();
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }

}