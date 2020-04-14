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

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

abstract class ThreadAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper): void
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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
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

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper->addIdentifier('id');

        if (interface_exists('Sonata\\ClassificationBundle\\Model\\CategoryInterface')) {
            $listMapper->add('category');
        }

        $listMapper
            ->add('permalink', 'text')
            ->add('numComments')
            ->add('isCommentable', 'boolean', ['editable' => true])
        ;
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, ?AdminInterface $childAdmin = null): void
    {
        if (!$childAdmin && !\in_array($action, ['edit'], true)) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            $this->trans('sonata_comment_admin_edit', [], 'SonataCommentBundle'),
            ['uri' => $admin->generateUrl('edit', ['id' => $id])]
        );

        $menu->addChild(
            $this->trans('sonata_comment_admin_view_comments', [], 'SonataCommentBundle'),
            ['uri' => $admin->generateUrl('sonata.comment.admin.comment.list', ['id' => $id])]
        );
    }
}
