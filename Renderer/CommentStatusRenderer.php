<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Renderer;

use Sonata\CommentBundle\Model\Comment;
use Sonata\CoreBundle\Component\Status\StatusClassRendererInterface;

/**
 * Class CommentStatusRenderer.
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CommentStatusRenderer implements StatusClassRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function handlesObject($object, $statusName = null)
    {
        return $object instanceof Comment
            && in_array($statusName, array('moderate', 'invalid', 'valid', null));
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusClass($object, $statusName = null, $default = '')
    {
        switch ($object->getState()) {
            case Comment::STATUS_MODERATE:
                return 'info';
            case Comment::STATUS_VALID:
                return 'success';
            case Comment::STATUS_INVALID:
                return 'important';
            default:
                return $default;
        }
    }
}
