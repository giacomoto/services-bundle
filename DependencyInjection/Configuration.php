<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('luckyseven_services');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('service_entity')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
