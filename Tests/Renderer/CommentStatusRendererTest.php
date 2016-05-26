<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Tests\Renderer;

use Sonata\CommentBundle\Model\Comment;
use Sonata\CommentBundle\Renderer\CommentStatusRenderer;

/**
 * This is the OrderStatusRenderer test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CommentStatusRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Should handle only Comment model class.
     */
    public function testHandles()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = new \DateTime();
        $this->assertFalse($commentStatusRenderer->handlesObject($comment));

        $comment = $this->getMock('Sonata\CommentBundle\Model\Comment');
        $this->assertTrue($commentStatusRenderer->handlesObject($comment));

        foreach (array('moderate', 'invalid', 'valid') as $correctStatusType) {
            $this->assertTrue($commentStatusRenderer->handlesObject($comment, $correctStatusType));
        }

        $this->assertFalse($commentStatusRenderer->handlesObject($comment, 'statusName'));
    }

    /**
     * Should returns valid status classes depending on comment state.
     */
    public function testGetValidClass()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = $this->getMock('Sonata\CommentBundle\Model\Comment');
        $comment->expects($this->once())->method('getState')->will($this->returnValue(array_rand(Comment::getStateList())));

        $this->assertContains($commentStatusRenderer->getStatusClass($comment, '', 'error'), array('success', 'info', 'important'));
    }

    /**
     * Should return default value if comment state is not caught.
     */
    public function testGetInvalidClass()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = $this->getMock('Sonata\CommentBundle\Model\Comment');
        $comment->expects($this->once())->method('getState')->will($this->returnValue(8));

        $this->assertEquals('default_value', $commentStatusRenderer->getStatusClass($comment, 'statusName', 'default_value'));
    }
}
