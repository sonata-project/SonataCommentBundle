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

namespace Sonata\CommentBundle\Form\Type;

use FOS\CommentBundle\Form\CommentType as FOSCommentType;
use Sonata\CommentBundle\Note\NoteProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This is a FOSCommentBundle overridden form type.
 */
class CommentType extends AbstractType
{
    /**
     * @var NoteProvider
     */
    protected $noteProvider;

    /**
     * Is comment model implementing signed interface?
     *
     * @var bool
     */
    protected $isSignedInterface = false;

    /**
     * Constructor.
     */
    public function __construct(NoteProvider $noteProvider)
    {
        $this->noteProvider = $noteProvider;
    }

    /**
     * Configures a Comment form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['add_author']) {
            $builder->add('authorName', TextType::class, ['required' => true]);

            $this->vars['add_author'] = $options['add_author'];
        }

        if ($options['show_note']) {
            $builder->add('note', ChoiceType::class, [
                'required' => false,
                'choices' => $this->noteProvider->getValues(),
            ]);
        }

        $builder
            ->add('website', UrlType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'add_author' => !$this->isSignedInterface,
            'show_note' => true,
        ]);
    }

    /**
     * Sets if comment model is implementing signed interface.
     *
     * @param bool $isSignedInterface
     */
    public function setIsSignedInterface($isSignedInterface)
    {
        $this->isSignedInterface = $isSignedInterface;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'sonata_comment_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return FOSCommentType::class;
    }
}
