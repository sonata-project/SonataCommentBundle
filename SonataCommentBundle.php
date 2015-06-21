<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SonataCommentBundle.
 *
 * This is the Sonata comment bundle class for Symfony extending from FOSCommentBundle
 */
class SonataCommentBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
