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

namespace Sonata\CommentBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Sonata\CommentBundle\Entity\BaseThread;

/**
 * This is the entity BaseThread test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class BaseThreadTest extends TestCase
{
    /**
     * Tests setters & getters.
     */
    public function testGetters(): void
    {
        // Given
        $thread = new BaseThread();
        $thread->setId('my-comment-thread');
        $thread->setCommentable(true);
        $thread->setAverageNote(0.40);

        $lastCommentDate = new \DateTime();
        $thread->setLastCommentAt($lastCommentDate);

        $thread->setNumComments(5);
        $thread->setPermalink('my-custom-permalink');

        // Then
        $this->assertSame('my-comment-thread', $thread->getId(), 'Should return correct thread identifier');
        $this->assertTrue($thread->getIsCommentable(), 'Should return if thread is commentable');
        $this->assertSame(0.40, $thread->getAverageNote(), 'Should return correct average note');
        $this->assertSame($lastCommentDate, $thread->getLastCommentAt(), 'Should return correct last commented date');
        $this->assertSame(5, $thread->getNumComments(), 'Should return correct number of comments');
        $this->assertSame('my-custom-permalink', $thread->getPermalink(), 'Should return correct thread permalink');
    }

    /**
     * Tests category setter & getter if using SonataClassificationBundle.
     */
    public function testCategoryGetters(): void
    {
        if (!interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
            $this->markTestSkipped('Sonata\ClassificationBundle\Model\CategoryInterface does not exist');
        }

        // Given
        $category = $this->createMock('Sonata\ClassificationBundle\Model\CategoryInterface');
        $category->expects($this->once())->method('getName')->willReturn('my-category');

        $thread = new BaseThread();
        $thread->setId('my-comment-thread');
        $thread->setCategory($category);

        // Then
        $this->assertSame('my-category', $thread->getCategory()->getName(), 'Should return correct category name');
    }
}
