.. index::
    single: Authors
    single: Authentication

Use with authenticated authors
==============================

You can use this bundle with Symfony authentication in order to retrieve author names as stored in Symfony security context.

This is a ``FOSCommentBundle`` feature. We will explain to you here how to enable it using ``SonataCommentBundle``.

Implement SignedCommentInterface
--------------------------------

Open ``App\\Entity\Comment`` and implement the following methods and interface::

    namespace App\Entity;

    use FOS\CommentBundle\Model\SignedCommentInterface;
    use Sonata\CommentBundle\Entity\BaseComment;
    use Symfony\Component\Security\Core\User\UserInterface;

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

        public function setAuthor(UserInterface $author)
        {
            $this->author = $author;
        }

        public function getAuthor()
        {
            return $this->author;
        }

        public function getAuthorName()
        {
            return $this->getAuthor() ? $this->getAuthor()->getUsername() : 'Anonymous';
        }
    }

You can now use your authenticated users as comments authors.