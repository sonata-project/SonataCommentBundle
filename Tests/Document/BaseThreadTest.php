<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Tests\Document;

use Sonata\CommentBundle\Document\BaseThread;

/**
 * This is the document BaseThread test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class BaseThreadTest extends \PHPUnit_Framework_TestCase
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
        $this->assertEquals('my-comment-thread', $thread->getId(), 'Should return correct thread identifier');
        $this->assertEquals(true, $thread->getIsCommentable(), 'Should return if thread is commentable');
        $this->assertEquals($lastCommentDate, $thread->getLastCommentAt(), 'Should return correct last commented date');
        $this->assertEquals(5, $thread->getNumComments(), 'Should return correct number of comments');
        $this->assertEquals('my-custom-permalink', $thread->getPermalink(), 'Should return correct thread permalink');
    }
}
