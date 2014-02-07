<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Tests\Entity;

use Sonata\CommentBundle\Entity\BaseThread;
use Sonata\CommentBundle\Entity\BaseComment;

class BaseCommentTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        // Given
        $thread = new BaseThread();
        $thread->setId('my-comment-thread');

        $comment = new BaseComment();
        $comment->setAuthor('Author name');
        $comment->setBody('Comment text');

        $date = new \DateTime();
        $comment->setCreatedAt($date);

        $comment->setState(1);
        $comment->setThread($thread);

        // Then
        $this->assertEquals('Author name', $comment->getAuthorName(), 'Should return the correct author name');
    }
}