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

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

abstract class ThreadAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id');

        if (interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
            $formMapper->add('category');
        }

        $formMapper
            ->add('permalink')
            ->add('isCommentable')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');

        if (interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
            $datagridMapper->add('category');
        }

        $datagridMapper
            ->add('permalink')
            ->add('isCommentable')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');

        if (interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
            $listMapper->add('category');
        }

        $listMapper
            ->add('permalink', 'text')
            ->add('numComments')
            ->add('isCommentable', 'boolean', array('editable' => true))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('sonata_comment_admin_edit', array(), 'SonataCommentBundle'),
            array('uri' => $admin->generateUrl('edit', array('id' => $id)))
        );

        $menu->addChild(
            $this->trans('sonata_comment_admin_view_comments', array(), 'SonataCommentBundle'),
            array('uri' => $admin->generateUrl('sonata.comment.admin.comment.list', array('id' => $id)))
        );
    }
}
