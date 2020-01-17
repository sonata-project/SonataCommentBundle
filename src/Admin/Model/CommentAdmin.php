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

namespace Sonata\CommentBundle\Admin\Model;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CommentBundle\Form\Type\CommentStatusType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

abstract class CommentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('createdAt', DateTimePickerType::class)
            ->add('body')
            ->add('email')
            ->add('website')
            ->add('state', CommentStatusType::class, [
                'translation_domain' => 'SonataCommentBundle',
            ])
            ->add('private', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('body')
            ->add('email')
            ->add('website')
            ->add('state')
            ->add('private')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id')
            ->add('body', 'text')
            ->add('createdAt', 'datetime')
            ->add('note', 'float')
            ->add('state', 'string', ['template' => '@SonataComment/CommentAdmin/list_status.html.twig'])
            ->add('private', 'boolean', ['editable' => true])
        ;
    }
}
