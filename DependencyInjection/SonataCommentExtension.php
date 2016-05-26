<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class SonataCommentExtension.
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
        $loader->load('event.xml');
        $loader->load('form.xml');
        $loader->load('note.xml');
        $loader->load('orm.xml');
        $loader->load('twig.xml');

        if ($this->hasBundle('SonataBlockBundle', $container)) {
            $loader->load('block.xml');
        }

        if ($this->hasBundle('SonataAdminBundle', $container)) {
            $loader->load(sprintf('admin_%s.xml', $config['manager_type']));
        }

        if ('orm' === $config['manager_type']) {
            $modelType = 'entity';
        } elseif ('mongodb' === $config['manager_type']) {
            $modelType = 'document';
        }

        $config = $this->addDefaults($config, $modelType);

        $this->registerDoctrineMapping($config, $container);

        $this->configureAdminClass($config, $container);
        $this->configureClass($config, $container, $modelType);
        $this->configureController($config, $container);
        $this->configureTranslationDomain($config, $container);
        $this->configureBlocksEvents($container);
        $this->configureFormTypes($config, $container);
        $this->configureNotesValues($config, $container);

        $isSignedInterface = false;

        if ($this->hasBundle('SonataUserBundle', $container)) {
            $commentClass = $container->getParameter(sprintf('sonata.comment.class.comment.%s', $modelType));
            $isSignedInterface = is_subclass_of($commentClass, 'FOS\CommentBundle\Model\SignedCommentInterface');

            if ($isSignedInterface) {
                $this->registerSonataUserDoctrineMapping($config, $container, $modelType);
            }
        }

        $container->setParameter('sonata.comment.class.comment.signed', $isSignedInterface);
    }

    /**
     * @param array  $config
     * @param string $modelType
     *
     * @return array
     */
    public function addDefaults(array $config, $modelType)
    {
        $defaultConfig['class']['comment'] = sprintf('Application\\Sonata\\CommentBundle\\%s\\Comment', ucfirst($modelType));
        $defaultConfig['class']['thread'] = sprintf('Application\\Sonata\\CommentBundle\\%s\\Thread', ucfirst($modelType));
        $defaultConfig['class']['category'] = sprintf('Application\\Sonata\\ClassificationBundle\\%s\\Category', ucfirst($modelType));

        $defaultConfig['admin']['comment']['class'] = sprintf('Sonata\\CommentBundle\\Admin\\%s\\CommentAdmin', ucfirst($modelType));
        $defaultConfig['admin']['thread']['class'] = sprintf('Sonata\\CommentBundle\\Admin\\%s\\ThreadAdmin', ucfirst($modelType));

        return array_replace_recursive($defaultConfig, $config);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function configureAdminClass($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.class', $config['admin']['comment']['class']);
        $container->setParameter('sonata.comment.admin.thread.class', $config['admin']['thread']['class']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param string           $modelType
     */
    public function configureClass($config, ContainerBuilder $container, $modelType)
    {
        $container->setParameter(sprintf('sonata.comment.class.comment.%s', $modelType), $config['class']['comment']);
        $container->setParameter(sprintf('sonata.comment.class.thread.%s', $modelType), $config['class']['thread']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function configureController($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.controller', $config['admin']['comment']['controller']);
        $container->setParameter('sonata.comment.admin.thread.controller', $config['admin']['thread']['controller']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function configureTranslationDomain($config, ContainerBuilder $container)
    {
        $container->setParameter('sonata.comment.admin.comment.translation_domain', $config['admin']['comment']['translation']);
        $container->setParameter('sonata.comment.admin.thread.translation_domain', $config['admin']['thread']['translation']);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function configureBlocksEvents(ContainerBuilder $container)
    {
        $container
            ->getDefinition('sonata.comment.event.sonata.comment')
            ->addMethodCall('setBlockService', array(new Reference('sonata.comment.block.thread.async')))
        ;
    }

    /**
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container Symfony container builder
     */
    public function configureFormTypes(array $config, ContainerBuilder $container)
    {
        $container
            ->getDefinition('sonata.comment.form.comment_status_type')
            ->replaceArgument(0, $config['class']['comment'])
        ;
    }

    /**
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container Symfony container builder
     */
    public function configureNotesValues(array $config, ContainerBuilder $container)
    {
        $container
            ->getDefinition('sonata.comment.note.provider')
            ->replaceArgument(1, $config['notes']['values'])
        ;
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

        // Comment

        $collector->addAssociation($config['class']['comment'], 'mapManyToOne', array(
            'fieldName' => 'thread',
            'targetEntity' => $config['class']['thread'],
            'cascade' => array(),
        ));

        // Thread

        if ($this->hasBundle('SonataClassificationBundle', $container)) {
            $collector->addAssociation($config['class']['thread'], 'mapManyToOne', array(
                'fieldName' => 'category',
                'targetEntity' => $config['class']['category'],
                'cascade' => array(
                    'persist',
                ),
                'mappedBy' => null,
                'joinColumns' => array(
                    array(
                        'name' => 'category_id',
                        'referencedColumnName' => 'id',
                        'onDelete' => 'CASCADE',
                        'onUpdate' => 'CASCADE',
                    ),
                ),
                'orphanRemoval' => false,
            ));
        }
    }

    /**
     * @param array            $config    A configuration array
     * @param ContainerBuilder $container Symfony container builder
     * @param string           $modelType Configuration model type
     */
    public function registerSonataUserDoctrineMapping(array $config, ContainerBuilder $container, $modelType)
    {
        foreach ($config['class'] as $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        $userClass = $container->getParameter(sprintf('sonata.user.admin.user.%s', $modelType));

        $collector->addAssociation($config['class']['comment'], 'mapManyToOne', array(
            'fieldName' => 'author',
            'targetEntity' => $userClass,
            'cascade' => array(),
        ));
    }

    /**
     * Returns if a bundle is available.
     *
     * @param string           $name      A bundle name
     * @param ContainerBuilder $container Symfony dependency injection container
     *
     * @return bool
     */
    protected function hasBundle($name, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        return isset($bundles[$name]);
    }
}
