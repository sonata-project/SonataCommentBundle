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

use Doctrine\ORM\EntityManager;
use FOS\CommentBundle\Entity\ThreadManager as BaseThreadManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ThreadManager extends BaseThreadManager
{
    /**
     * @var CommentManager
     */
    protected $commentManager;

    /**
     * Constructor.
     *
     * @param CommentManager           $commentManager
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager            $em
     * @param string                   $class
     */
    public function __construct(CommentManager $commentManager, EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        $this->commentManager = $commentManager;

        parent::__construct($dispatcher, $em, $class);
    }

    /**
     * Updates the threads average note from comments notes.
     */
    public function updateAverageNote()
    {
        $commentTableName = $this->em->getClassMetadata($this->commentManager->getClass())->table['name'];
        $threadTableName = $this->em->getClassMetadata($this->getClass())->table['name'];

        $this->em->getConnection()->beginTransaction();
        $this->em->getConnection()->query(sprintf('UPDATE %s t SET t.average_note = 0', $threadTableName));

        $this->em->getConnection()->query(sprintf(
            'UPDATE %s t, (SELECT c.thread_id, avg(c.note) as avg_note FROM %s as c WHERE c.private <> 1 GROUP BY c.thread_id) as comments_note
            SET t.average_note = comments_note.avg_note
            WHERE t.id = comments_note.thread_id
            AND t.is_commentable <> 0', $threadTableName, $commentTableName));

        $this->em->getConnection()->commit();
    }
}
