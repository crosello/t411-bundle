<?php

namespace Rosello\T411Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Rosello\T411Bundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('t411');

        $rootNode
            ->children()
                ->scalarNode("limit")
                    ->defaultValue(10)
                ->end()
                ->arrayNode("token")
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('storage')
                            ->defaultValue('session')
                        ->end()
                        ->scalarNode('name')
                            ->defaultValue('t411_token')
                        ->end()
                        ->scalarNode('expire')
                            ->defaultValue(3600)
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
