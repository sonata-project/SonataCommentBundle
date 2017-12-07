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

namespace Sonata\CommentBundle\Event;

use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;
use Sonata\CommentBundle\Block\CommentThreadAsyncBlockService;

/**
 * Comment thread asynchronous listener.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CommentThreadAsyncListener
{
    /**
     * @var CommentThreadAsyncBlockService
     */
    protected $blockService;

    /**
     * Add a comment thread asynchronous block service.
     *
     * @param CommentThreadAsyncBlockService $blockService
     */
    public function setBlockService(CommentThreadAsyncBlockService $blockService): void
    {
        $this->blockService = $blockService;
    }

    /**
     * Add blocks services to event.
     *
     * @param BlockEvent $event
     */
    public function onBlock(BlockEvent $event): void
    {
        $identifier = $event->getSetting('id', null);

        if (null === $identifier) {
            return;
        }

        $block = new Block();
        $block->setId(uniqid());
        $block->setSettings($event->getSettings());
        $block->setType($this->blockService->getName());

        $event->addBlock($block);
    }
}
