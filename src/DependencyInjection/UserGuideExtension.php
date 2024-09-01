<?php

namespace Norvutec\UserGuideBundle\DependencyInjection;

use Norvutec\UserGuideBundle\Component\UserGuide;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class UserGuideExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );
        $loader->load('services.yaml');

        $container->registerForAutoconfiguration(UserGuide::class)
            ->addTag('norvutec.user_guide.guide');
    }

}