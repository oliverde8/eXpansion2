<?php

namespace eXpansion\Core\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * Class Configuration
 *
 * @package eXpansion\Core\DependencyInjection;
 * @author oliver de Cramer <oliverde8@gmail.com>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('e_xpansion_core')
            ->children()
                ->arrayNode('parameters')->children()
                    ->arrayNode('core_chat_color_codes')
                        ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }
}