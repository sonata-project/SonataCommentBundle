<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Tests\Resources;

use Sonata\CoreBundle\Test\XliffValidatorTestCase;

/**
 * This is a XliffTest class to ensure that translations are correctly formatted.
 */
class XliffTest extends XliffValidatorTestCase
{
    /**
     * @return array List all path to validate xliff
     */
    public function getXliffPaths()
    {
        return array(array(__DIR__.'/../../Resources/translations'));
    }
}
