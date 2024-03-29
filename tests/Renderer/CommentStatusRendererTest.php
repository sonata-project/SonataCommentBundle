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

namespace Sonata\CommentBundle\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use Sonata\CommentBundle\Model\Comment;
use Sonata\CommentBundle\Renderer\CommentStatusRenderer;

/**
 * This is the OrderStatusRenderer test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CommentStatusRendererTest extends TestCase
{
    /**
     * Should handle only Comment model class.
     */
    public function testHandles()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = new \DateTime();
        static::assertFalse($commentStatusRenderer->handlesObject($comment));

        $comment = $this->createMock('Sonata\CommentBundle\Model\Comment');
        static::assertTrue($commentStatusRenderer->handlesObject($comment));

        foreach (['moderate', 'invalid', 'valid'] as $correctStatusType) {
            static::assertTrue($commentStatusRenderer->handlesObject($comment, $correctStatusType));
        }

        static::assertFalse($commentStatusRenderer->handlesObject($comment, 'statusName'));
    }

    /**
     * Should returns valid status classes depending on comment state.
     */
    public function testGetValidClass()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = $this->createMock('Sonata\CommentBundle\Model\Comment');
        $comment->expects(static::once())->method('getState')->willReturn(array_rand(Comment::getStateList()));

        static::assertContains($commentStatusRenderer->getStatusClass($comment, '', 'error'), ['success', 'info', 'important']);
    }

    /**
     * Should return default value if comment state is not caught.
     */
    public function testGetInvalidClass()
    {
        $commentStatusRenderer = new CommentStatusRenderer();

        $comment = $this->createMock('Sonata\CommentBundle\Model\Comment');
        $comment->expects(static::once())->method('getState')->willReturn(8);

        static::assertSame('default_value', $commentStatusRenderer->getStatusClass($comment, 'statusName', 'default_value'));
    }
}
