<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sonata_comment');
        // NEXT_MAJOR: drop support for symfony/config < 4.2
        // Keep compatibility with symfony/config < 4.2
        if (!method_exists($treeBuilder, 'getRootNode')) {
            $node = $treeBuilder->root('sonata_comment');
        } else {
            $node = $treeBuilder->getRootNode();
        }

        $supportedManagerTypes = ['orm', 'mongodb'];
        $supportedProviders = ['fos_comment'];

        $node
            ->children()
                ->scalarNode('provider')
                    ->defaultValue('fos_comment')
                    ->validate()
                        ->ifNotInArray($supportedProviders)
                        ->thenInvalid('The provider %s is not supported. Please choose one of '.json_encode($supportedProviders))
                    ->end()
                ->end()
                ->scalarNode('manager_type')
                    ->defaultValue('orm')
                    ->validate()
                        ->ifNotInArray($supportedManagerTypes)
                        ->thenInvalid('The manager type %s is not supported. Please choose one of '.json_encode($supportedManagerTypes))
                    ->end()
                ->end()
                ->arrayNode('notes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('values')
                            ->prototype('scalar')->end()
                            ->defaultValue([1, 2, 3, 4, 5])
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('class')
                    ->children()
                        ->scalarNode('comment')->cannotBeEmpty()->end()
                        ->scalarNode('thread')->cannotBeEmpty()->end()
                        ->scalarNode('category')->cannotBeEmpty()->end()
                    ->end()
                ->end()

                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('comment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('SonataAdminBundle:CRUD')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('SonataCommentBundle')->end()
                            ->end()
                        ->end()
                        ->arrayNode('thread')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('SonataAdminBundle:CRUD')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('SonataCommentBundle')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
