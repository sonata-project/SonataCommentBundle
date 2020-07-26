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

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\CommentBundle\Admin\Entity\CommentAdmin;
use Sonata\CommentBundle\Admin\Entity\ThreadAdmin;
use Sonata\CommentBundle\Block\CommentThreadAsyncBlockService;
use Sonata\CommentBundle\Command\SynchronizeCommand;
use Sonata\CommentBundle\DependencyInjection\SonataCommentExtension;
use Sonata\CommentBundle\Event\CommentThreadAsyncListener;
use Sonata\CommentBundle\Form\Type\CommentStatusType;
use Sonata\CommentBundle\Form\Type\CommentType;
use Sonata\CommentBundle\Manager\CommentManager;
use Sonata\CommentBundle\Manager\ThreadManager;
use Sonata\CommentBundle\Note\NoteProvider;

final class SonataCommentExtensionTest extends AbstractExtensionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->container->setParameter('kernel.bundles', [
            'SonataDoctrineBundle' => true,
            'SonataAdminBundle' => true,
            'SonataBlockBundle' => true,
            'SonataUserBundle' => true,
        ]);
    }

    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('sonata.comment.admin.comment', CommentAdmin::class);
        $this->assertContainerBuilderHasService('sonata.comment.admin.thread', ThreadAdmin::class);
        $this->assertContainerBuilderHasService('sonata.comment.block.thread.async', CommentThreadAsyncBlockService::class);
        $this->assertContainerBuilderHasService(SynchronizeCommand::class);
        $this->assertContainerBuilderHasService('sonata.comment.event.sonata.comment', CommentThreadAsyncListener::class);
        $this->assertContainerBuilderHasService('sonata.comment.form.comment_type', CommentType::class);
        $this->assertContainerBuilderHasService('sonata.comment.form.comment_status_type', CommentStatusType::class);
        $this->assertContainerBuilderHasService('sonata.comment.note.provider', NoteProvider::class);
        $this->assertContainerBuilderHasService('sonata.comment.manager.comment', CommentManager::class);
        $this->assertContainerBuilderHasService('sonata.comment.manager.thread', ThreadManager::class);

        $this->assertContainerBuilderHasParameter('sonata.comment.admin.groupname', 'sonata_comment');
        $this->assertContainerBuilderHasParameter('sonata.comment.block.thread.async.class', CommentThreadAsyncBlockService::class);
        $this->assertContainerBuilderHasParameter('sonata.comment.manager.comment.class', CommentManager::class);
        $this->assertContainerBuilderHasParameter('sonata.comment.manager.thread.class', ThreadManager::class);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new SonataCommentExtension(),
        ];
    }
}
