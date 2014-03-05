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

use Sonata\CommentBundle\Note\NoteProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This is a FOSCommentBundle overridden form type
 */
class CommentType extends AbstractType
{
    /**
     * @var NoteProvider
     */
    protected $noteProvider;

    /**
     * Constructor
     *
     * @param NoteProvider $noteProvider
     */
    public function __construct(NoteProvider $noteProvider)
    {
        $this->noteProvider = $noteProvider;
    }

    /**
     * Is comment model implementing signed interface?
     *
     * @var boolean
     */
    protected $isSignedInterface = false;

    /**
     * Configures a Comment form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['add_author']) {
            $builder->add('authorName', 'text', array('required' => true));

            $this->vars['add_author'] = $options['add_author'];
        }

        if ($options['show_note']) {
            $builder->add('note', 'choice', array(
                'required' => false,
                'choices'  => $this->noteProvider->getValues()
            ));
        }

        $builder
            ->add('website', 'url', array('required' => false))
            ->add('email', 'email', array('required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'add_author' => !$this->isSignedInterface,
            'show_note'  => true
        ));
    }

    /**
     * Sets if comment model is implementing signed interface
     *
     * @param boolean $isSignedInterface
     */
    public function setIsSignedInterface($isSignedInterface)
    {
        $this->isSignedInterface = $isSignedInterface;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "sonata_comment_comment";
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return "fos_comment_comment";
    }
}
