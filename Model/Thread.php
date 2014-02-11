<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Model;

use FOS\CommentBundle\Entity\Thread as AbstractedThread;

/**
 * Thread entity
 */
abstract class Thread extends AbstractedThread
{
    /**
     * Identifier
     *
     * @var string $id
     */
    protected $id;

    /**
     * Thread average note
     *
     * @var float
     */
    protected $averageNote;

    /**
     * @return bool
     */
    public function getIsCommentable()
    {
        return $this->isCommentable();
    }

    /**
     * @param bool $isCommentable
     *
     * @return null
     */
    public function setIsCommentable($isCommentable)
    {
        $this->setCommentable($isCommentable);
    }

    /**
     * Sets thread average comments note
     *
     * @param $averageNote
     */
    public function setAverageNote($averageNote)
    {
        $this->averageNote = $averageNote;
    }

    /**
     * Returns thread average comments note
     *
     * @return float
     */
    public function getAverageNote()
    {
        return $this->averageNote;
    }
}