<?php

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

abstract class CommentAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('createdAt', 'sonata_type_datetime_picker')
            ->add('body')
            ->add('email')
            ->add('website')
            ->add('state', 'sonata_comment_status', array('translation_domain' => 'SonataCommentBundle'))
            ->add('private', 'checkbox', array('required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
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

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('body', 'text')
            ->add('createdAt', 'datetime')
            ->add('note', 'float')
            ->add('state', 'string', array('template' => 'SonataCommentBundle:CommentAdmin:list_status.html.twig'))
            ->add('private', 'boolean', array('editable' => true))
        ;
    }
}
