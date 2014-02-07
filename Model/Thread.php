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
}