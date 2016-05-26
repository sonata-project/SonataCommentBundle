<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Manager;

use FOS\CommentBundle\Entity\CommentManager as BaseCommentManager;
use Sonata\CommentBundle\Model\Thread;

class CommentManager extends BaseCommentManager
{
    /**
     * Returns Thread average note.
     *
     * @param Thread $thread
     *
     * @return float
     */
    public function findAverageNote(Thread $thread)
    {
        return $this->repository->createQueryBuilder('c')
            ->select('avg(c.note)')
            ->where('c.private <> :private')
            ->andWhere('c.thread = :thread')
            ->setParameters(array(
                'private' => 1,
                'thread' => $thread,
            ))
            ->getQuery()
            ->getSingleScalarResult();
    }
}
