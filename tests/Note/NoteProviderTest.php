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

namespace Sonata\CommentBundle\Tests\Note;

use PHPUnit\Framework\TestCase;
use Sonata\CommentBundle\Note\NoteProvider;

/**
 * This is the NoteProvider test class.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class NoteProviderTest extends TestCase
{
    /**
     * Test findAverageNote() method.
     */
    public function testFindAverageNote()
    {
        // Given
        $thread = $this->createMock('Sonata\CommentBundle\Model\Thread');

        $commentManager = $this->getMockBuilder('Sonata\CommentBundle\Manager\CommentManager')
            ->disableOriginalConstructor()
            ->getMock();
        $commentManager->expects($this->once())->method('findAverageNote')->will($this->returnValue(3.5));

        $provider = new NoteProvider($commentManager, [0, 1, 2, 3]);

        // When
        $averageNote = $provider->findAverageNote($thread);

        // Then
        $this->assertEquals(3.5, $averageNote, 'Note should be the same as comment manager query returns');
    }

    /**
     * Test getValues() method.
     */
    public function testGetValues()
    {
        // Given
        $thread = $this->createMock('Sonata\CommentBundle\Model\Thread');

        $commentManager = $this->getMockBuilder('Sonata\CommentBundle\Manager\CommentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $provider = new NoteProvider($commentManager, [1, 2, 3]);

        // When
        $notes = $provider->getValues();

        // Then
        $this->assertEquals([1, 2, 3], $notes, 'Should return notes given in constructor');
    }
}
