<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Note;

use Sonata\CommentBundle\Model\Thread;

use FOS\CommentBundle\Model\CommentManager;

/**
 * Class NoteProvider
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class NoteProvider
{
    /**
     * @var CommentManager
     */
    protected $commentManager;

    /**
     * @var array
     */
    protected $values;

    /**
     * Constructor
     *
     * @param CommentManager $commentManager A comment manager
     * @param array          $values         An array of notes values
     */
    public function __construct(CommentManager $commentManager, array $values) {
        $this->commentManager = $commentManager;
        $this->values         = $values;
    }

    /**
     * Returns notes values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Returns Thread average note
     *
     * @param Thread $thread
     *
     * @return float
     */
    public function findAverageNote(Thread $thread)
    {
        return $this->commentManager->findAverageNote($thread);
    }
}