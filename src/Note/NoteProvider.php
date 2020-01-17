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

namespace Sonata\CommentBundle\Note;

use FOS\CommentBundle\Model\CommentManager;
use Sonata\CommentBundle\Model\Thread;

/**
 * Class NoteProvider.
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

    public function __construct(CommentManager $commentManager, array $values)
    {
        $this->commentManager = $commentManager;
        $this->values = $values;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function findAverageNote(Thread $thread): float
    {
        return $this->commentManager->findAverageNote($thread);
    }
}
