<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * Class SonataCommentExtension
 *
 * This is the Sonata comment bundle Symfony extension class
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class SonataCommentExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.xml');

        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load(sprintf('admin_%s.xml', $config['manager_type']));
        }

        $config = $this->addDefaults($config);

        $this->registerDoctrineMapping($config, $container);

        if (isset($bundles['SonataUserBundle'])) {
            $this->registerSonataUserDoctrineMapping($config, $container);
        }

        $this->configureAdminClass($config, $container);
        $this->configureClass($config, $container);
        $this->configureController($config, $container);
        $this->configureTranslationDomain($config, $container);
    }

    /**
     * @param array $config
     *
     * @return array
     */
    public function addDefaults(array $config)
    {
        if ('orm' === $config['manager_type']) {
            $modelType = 'Entity';
        } elseif ('mongodb' === $config['manager_type']) {
            $modelType = 'Document';
        }

        $defaultConfig['class']['comment'] = sprintf('Application\\Sonata\\CommentBundle\\%s\\Comment', $modelType);
        $defaultConfig['class']['thread'] = sprintf('Application\\Sonata\\CommentBundle\\%s\\Thread', $modelType);

        $defaultConfig['admin']['comment']['class'] = sprintf('Sonata\\CommentBundle\\Admin\\%s\\CommentAdmin', $modelType);
        $defaultConfig['admin']['thread']['class'] = sprintf('Sonata\\CommentBundle\\Admin\\%s\\ThreadAdmin', $modelType);

        return array_replace_recursive($defaultConfig, $config);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureAdminClass($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.class', $config['admin']['comment']['class']);
        $container->setParameter('sonata.comment.admin.thread.class', $config['admin']['thread']['class']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureClass($config, ContainerBuilder $container)
    {
        if ('orm' === $config['manager_type']) {
            $modelType = 'entity';
        } elseif ('mongodb' === $config['manager_type']) {
            $modelType = 'document';
        }

        $container->setParameter(sprintf('sonata.comment.admin.comment.%s', $modelType), $config['class']['comment']);
        $container->setParameter(sprintf('sonata.comment.admin.thread.%s', $modelType), $config['class']['thread']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureController($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.controller', $config['admin']['comment']['controller']);
        $container->setParameter('sonata.comment.admin.thread.controller', $config['admin']['thread']['controller']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureTranslationDomain($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.translation_domain', $config['admin']['comment']['translation']);
        $container->setParameter('sonata.comment.admin.thread.translation_domain', $config['admin']['thread']['translation']);
    }

    /**
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container Symfony container builder
     */
    public function registerDoctrineMapping(array $config, ContainerBuilder $container)
    {
        foreach ($config['class'] as $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['comment'], 'mapManyToOne', array(
            'fieldName'       => 'thread',
            'targetEntity'    => $config['class']['thread'],
            'cascade'         => array()
        ));

        if ('orm' === $config['manager_type']) {
            $modelType = 'entity';
        } elseif ('mongodb' === $config['manager_type']) {
            $modelType = 'document';
        }

        $userClass = $container->getParameter(sprintf('sonata.user.admin.user.%s', $modelType));

        $collector->addAssociation($config['class']['comment'], 'mapManyToOne', array(
            'fieldName'       => 'author',
            'targetEntity'    => $userClass,
            'cascade'         => array()
        ));
    }

    /**
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container Symfony container builder
     */
    public function registerSonataUserDoctrineMapping(array $config, ContainerBuilder $container)
    {
        foreach ($config['class'] as $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        if ('orm' === $config['manager_type']) {
            $modelType = 'entity';
        } elseif ('mongodb' === $config['manager_type']) {
            $modelType = 'document';
        }

        $userClass = $container->getParameter(sprintf('sonata.user.admin.user.%s', $modelType));

        $collector->addAssociation($config['class']['comment'], 'mapManyToOne', array(
            'fieldName'       => 'author',
            'targetEntity'    => $userClass,
            'cascade'         => array()
        ));
    }
}