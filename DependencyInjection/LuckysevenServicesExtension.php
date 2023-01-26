<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Bundle\MakerBundle\DependencyInjection\Configuration;

class LuckysevenServicesExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $loader = new YamlFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $containerBuilder->setParameter('luckyseven_services.service_entity', $configs[0]['service_entity']);
    }
}
