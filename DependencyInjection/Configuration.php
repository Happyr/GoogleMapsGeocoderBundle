<?php

namespace HappyR\Google\GeocoderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode=$treeBuilder->root('happy_r_google_geocoder');

        $rootNode
            ->children()
                ->scalarNode('developer_key')->defaultValue('')->end()
                //list of supported languages https://developers.google.com/maps/faq#languagesupport
                ->scalarNode('language')->defaultValue('')->end()
            ->end();

        return $treeBuilder;
    }
}
