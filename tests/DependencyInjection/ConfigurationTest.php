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

namespace Sonata\CommentBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Sonata\CommentBundle\DependencyInjection\Configuration;
use Sonata\CommentBundle\DependencyInjection\SonataCommentExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testDefault(): void
    {
        $this->assertProcessedConfigurationEquals([
            'provider' => 'fos_comment',
            'manager_type' => 'orm',
            'notes' => [
                'values' => [1, 2, 3, 4, 5],
            ],
            'admin' => [
                'comment' => [
                    'controller' => 'SonataAdminBundle:CRUD',
                    'translation' => 'SonataCommentBundle',
                ],
                'thread' => [
                    'controller' => 'SonataAdminBundle:CRUD',
                    'translation' => 'SonataCommentBundle',
                ],
            ],
        ], [
            __DIR__.'/../Fixtures/configuration.yaml',
        ]);
    }

    protected function getContainerExtension(): ExtensionInterface
    {
        return new SonataCommentExtension();
    }

    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }
}
