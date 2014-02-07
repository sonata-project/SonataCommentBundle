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

use Symfony\Component\Security\Core\User\UserInterface;

use FOS\CommentBundle\Entity\Comment as AbstractedComment;
use FOS\CommentBundle\Model\SignedCommentInterface;

/**
 * Comment entity
 */
class Comment extends AbstractedComment implements SignedCommentInterface
{
    /**
     * Identifier
     *
     * @var int $id
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread $thread
     */
    protected $thread;

    /**
     * @var UserInterface
     */
    protected $author;

    /**
     * {@inheritdoc}
     */
    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorName()
    {
        return $this->getAuthor() ? $this->getAuthor()->getUsername() : 'Anonymous';
    }
}