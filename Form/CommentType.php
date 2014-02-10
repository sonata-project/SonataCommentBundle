<?php

/**
 * This file is part of the FOSCommentBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sonata\CommentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\CommentBundle\Form\CommentType as BaseCommentType;

/**
 * This is a FOSCommentBundle overridden form type
 */
class CommentType extends BaseCommentType
{
    /**
     * Configures a Comment form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('website', 'url', array('required' => false))
            ->add('email', 'email', array('required' => false))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "sonata_comment_comment";
    }
}
