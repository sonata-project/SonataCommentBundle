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
use Sonata\CommentBundle\Entity\BaseComment;
use Sonata\CommentBundle\Entity\BaseThread;

/**
 * This is the entity BaseComment test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class BaseCommentTest extends TestCase
{
    public function testGetters()
    {
        // Given
        $thread = new BaseThread();
        $thread->setId('my-comment-thread');

        $comment = new BaseComment();
        $comment->setBody('Comment text');
        $comment->setWebsite('http://www.example.com');
        $comment->setEmail('test@example.com');
        $comment->setNote(0.20);
        $comment->setPrivate(true);
        $comment->setAuthorName('My name');

        $date = new \DateTime();
        $comment->setCreatedAt($date);

        $comment->setState(1);
        $comment->setThread($thread);

        // Then
        static::assertSame('Comment text', $comment->getBody(), 'Should return correct comment body');
        static::assertSame('http://www.example.com', $comment->getWebsite(), 'Should return correct comment author website');
        static::assertSame('test@example.com', $comment->getEmail(), 'Should return correct comment author email address');
        static::assertSame(0.20, $comment->getNote(), 'Should return correct comment note');
        static::assertTrue($comment->isPrivate(), 'Should return that comment is flagged as private');
        static::assertSame('My name', $comment->getAuthorName(), 'Should return correct comment author name');
        static::assertSame($date, $comment->getCreatedAt(), 'Should return correct creation date');

        static::assertSame($thread, $comment->getThread(), 'Should return correct thread');
        static::assertSame('my-comment-thread', $comment->getThread()->getId(), 'Should return correct thread identifier');
    }
}
