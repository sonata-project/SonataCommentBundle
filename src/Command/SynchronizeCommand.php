<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CommentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('sonata:comment:sync');
        $this->setDescription('Synchronize comments count (average thread note, ...)');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Updating thread comments average note...');

        $this->getThreadManager()->updateAverageNote();

        $output->writeln('<info>done!</info>');
    }

    /**
     * Returns Thread manager.
     *
     * @return \Sonata\CommentBundle\Manager\ThreadManager
     */
    protected function getThreadManager()
    {
        return $this->getContainer()->get('sonata.comment.manager.thread');
    }
}
