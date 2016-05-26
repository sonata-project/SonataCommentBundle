<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Model;

use FOS\CommentBundle\Entity\Thread as AbstractedThread;
use Sonata\ClassificationBundle\Model\CategoryInterface;

/**
 * Thread entity.
 */
abstract class Thread extends AbstractedThread
{
    /**
     * Identifier.
     *
     * @var string
     */
    protected $id;

    /**
     * Thread average note.
     *
     * @var float
     */
    protected $averageNote;

    /**
     * A thread category.
     *
     * @var CategoryInterface
     */
    protected $category;

    /**
     * @return bool
     */
    public function getIsCommentable()
    {
        return $this->isCommentable();
    }

    /**
     * @param bool $isCommentable
     */
    public function setIsCommentable($isCommentable)
    {
        $this->setCommentable($isCommentable);
    }

    /**
     * Sets thread average comments note.
     *
     * @param $averageNote
     */
    public function setAverageNote($averageNote)
    {
        $this->averageNote = $averageNote;
    }

    /**
     * Returns thread average comments note.
     *
     * @return float
     */
    public function getAverageNote()
    {
        return $this->averageNote;
    }

    /**
     * Sets a thread category.
     *
     * @param CategoryInterface $category
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * Returns thread category.
     *
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }
}
