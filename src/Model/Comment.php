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

namespace Sonata\CommentBundle\Model;

use FOS\CommentBundle\Entity\Comment as AbstractedComment;

/**
 * Comment entity.
 */
class Comment extends AbstractedComment
{
    /**
     * Available comment status.
     */
    public const STATUS_VALID = 0;
    public const STATUS_INVALID = 1;
    public const STATUS_MODERATE = 2;

    /**
     * Identifier.
     *
     * @var int
     */
    protected $id;

    /**
     * Thread of this comment.
     *
     * @var Thread
     */
    protected $thread;

    /**
     * Comment author name.
     *
     * @var string
     */
    protected $authorName;

    /**
     * Comment author email address.
     *
     * @var string
     */
    protected $email;

    /**
     * Comment author website url.
     *
     * @var string
     */
    protected $website;

    /**
     * Comment evaluation note.
     *
     * @var float
     */
    protected $note;

    /**
     * @var bool
     */
    protected $private;

    /**
     * Sets comment author name.
     *
     * @param string $authorName
     */
    public function setAuthorName($authorName): void
    {
        $this->authorName = $authorName;
    }

    /**
     * Returns comment author name.
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Sets comment author email address.
     *
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Returns comment author email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets comment author website url.
     *
     * @param string $website
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * Returns comment author website url.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets comment note.
     *
     * @param float $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * Returns comment note.
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Returns comment state list.
     *
     * @return array
     */
    public static function getStateList()
    {
        return [
            self::STATUS_VALID => 'valid',
            self::STATUS_INVALID => 'invalid',
            self::STATUS_MODERATE => 'moderate',
        ];
    }

    /**
     * Returns comment state label.
     *
     * @return int|null
     */
    public function getStateLabel()
    {
        $list = self::getStateList();

        return isset($list[$this->getState()]) ? $list[$this->getState()] : null;
    }

    /**
     * Sets if comment is flagged as private.
     *
     * @param bool $private
     */
    public function setPrivate($private): void
    {
        $this->private = $private;
    }

    /**
     * Returns if comment is flagged as private.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
    }
}
