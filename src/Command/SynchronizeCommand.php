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

namespace Sonata\CommentBundle\Command;

use Sonata\CommentBundle\Manager\ThreadManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeCommand extends ContainerAwareCommand
{
    public function configure(): void
    {
        $this->setName('sonata:comment:sync');
        $this->setDescription('Synchronize comments count (average thread note, ...)');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Updating thread comments average note...');

        $this->getThreadManager()->updateAverageNote();

        $output->writeln('<info>done!</info>');
    }

    protected function getThreadManager(): ThreadManager
    {
        return $this->getContainer()->get('sonata.comment.manager.thread');
    }
}
