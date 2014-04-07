.. index::
    single: Authors
    single: Authentication

Use with authenticated authors
==============================

You can use this bundle with Symfony authentication in order to retrieve author names as stored in Symfony security context.

This is a ``FOSCommentBundle`` feature. We will explain to you here how to enable it using ``SonataCommentBundle``.

Implement SignedCommentInterface
--------------------------------

Open entity ``Application\Sonata\CommentBundle\Entity\Comment`` and implement the following methods and interface:

.. code-block:: php

    <?php

    namespace Application\Sonata\CommentBundle\Entity;

    use FOS\CommentBundle\Model\SignedCommentInterface;
    use Symfony\Component\Security\Core\User\UserInterface;

    use Sonata\CommentBundle\Entity\BaseComment as BaseComment;

    class Comment extends BaseComment implements SignedCommentInterface
    {
        /**
         * @var integer $id
         */
        protected $id;

        /**
         * @var UserInterface
         */
        protected $author;

        /**
         * Get id
         *
         * @return integer $id
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * {@inheritdoc}
         */
        public function setAuthor(UserInterface $author)
        {
            $this->author = $author;
        }

        /**
         * {@inheritdoc}
         */
        public function getAuthor()
        {
            return $this->author;
        }

        /**
         * {@inheritdoc}
         */
        public function getAuthorName()
        {
            return $this->getAuthor() ? $this->getAuthor()->getUsername() : 'Anonymous';
        }
    }


That's it, you can now use your authenticated users as comments authors.