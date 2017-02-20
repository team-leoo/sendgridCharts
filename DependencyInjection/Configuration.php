<?php
/** Namespace */
namespace LeooTeam\SendgridChartsBundle\DependencyInjection;

/** Usages */
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('leoo_team_sendgrid_charts');

        $rootNode
            ->children()
                ->scalarNode('apikey')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                ->scalarNode('client')
                    ->cannotBeEmpty()
                    ->defaultValue('leoo_team_sendgrid_charts')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
