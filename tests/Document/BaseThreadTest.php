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

namespace Sonata\CommentBundle\Tests\Document;

use PHPUnit\Framework\TestCase;
use Sonata\CommentBundle\Document\BaseThread;

/**
 * This is the document BaseThread test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class BaseThreadTest extends TestCase
{
    public function testGetters()
    {
        // Given
        $thread = new BaseThread();
        $thread->setId('my-comment-thread');
        $thread->setCommentable(true);

        $lastCommentDate = new \DateTime();
        $thread->setLastCommentAt($lastCommentDate);

        $thread->setNumComments(5);
        $thread->setPermalink('my-custom-permalink');

        // Then
        $this->assertSame('my-comment-thread', $thread->getId(), 'Should return correct thread identifier');
        $this->assertTrue($thread->getIsCommentable(), 'Should return if thread is commentable');
        $this->assertSame($lastCommentDate, $thread->getLastCommentAt(), 'Should return correct last commented date');
        $this->assertSame(5, $thread->getNumComments(), 'Should return correct number of comments');
        $this->assertSame('my-custom-permalink', $thread->getPermalink(), 'Should return correct thread permalink');
    }
}
