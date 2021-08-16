.. index::
    single: Installation
    single: Configuration

Installation
============

Prerequisites
-------------

PHP ^7.3 and Symfony ^4.4 are needed to make this bundle work, there are
also some Sonata dependencies that need to be installed and configured beforehand.

Required dependencies:

* `SonataAdminBundle <https://docs.sonata-project.org/projects/SonataAdminBundle/en/3.x/>`_
* `SonataBlockBundle <https://docs.sonata-project.org/projects/SonataBlockBundle/en/3.x/>`_

And the persistence bundle (choose one):

* `SonataDoctrineOrmAdminBundle <https://docs.sonata-project.org/projects/SonataDoctrineORMAdminBundle/en/3.x/>`_
* `SonataDoctrineMongoDBAdminBundle <https://docs.sonata-project.org/projects/SonataDoctrineMongoDBAdminBundle/en/3.x/>`_

Follow also their configuration step; you will find everything you need in
their own installation chapter.

.. note::

    If a dependency is already installed somewhere in your project or in
    another dependency, you won't need to install it again.

Enable the Bundle
-----------------

Add ``SonataCommentBundle`` via composer::

    composer require sonata-project/comment-bundle

.. note::

    This will install the FOSCommentBundle_, too.

Next, be sure to enable the bundles in your ``config/bundles.php`` file if they
are not already enabled::

    // config/bundles.php

    return [
        // ...
        FOS\CommentBundle\FOSCommentBundle::class => ['all' => true],
        Sonata\CommentBundle\SonataCommentBundle::class => ['all' => true],
    ];

Configuration
=============

SonataCommentBundle Configuration
---------------------------------

.. code-block:: yaml

    # config/packages/sonata_comment.yaml

    sonata_comment:
        manager_type: orm
        class:
            comment: App\Entity\SonataCommentComment
            thread: App\Entity\SonataCommentThread

FOSCommentBundle Configuration
------------------------------

.. code-block:: yaml

    # config/packages/fos_comment.yaml

    fos_comment:
        db_driver: orm
        class:
            model:
                comment: App\Entity\SonataCommentComment
                thread: App\Entity\SonataCommentThread
        form:
            comment:
                type: sonata_comment_comment

Doctrine ORM Configuration
--------------------------

Add these bundles in the config mapping definition (or enable `auto_mapping`_)::

    # config/packages/doctrine.yaml

    doctrine:
        orm:
            entity_managers:
                default:
                    mappings:
                        FOSCommentBundle: ~
                        SonataCommentBundle: ~

And then create the corresponding entities, ``src/Entity/SonataCommentComment``::

    // src/Entity/SonataCommentComment.php

    use Doctrine\ORM\Mapping as ORM;
    use Sonata\CommentBundle\Entity\BaseComment;

    /**
     * @ORM\Entity
     * @ORM\Table(name="comment__comment")
     */
    class SonataCommentComment extends BaseComment
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        protected $id;
    }

and ``src/Entity/SonataCommentThread``::

    // src/Entity/SonataCommentThread.php

    use Doctrine\ORM\Mapping as ORM;
    use Sonata\CommentBundle\Entity\BaseThread;

    /**
     * @ORM\Entity
     * @ORM\Table(name="comment__thread")
     */
    class SonataCommentThread extends BaseThread
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        protected $id;
    }

The only thing left is to update your schema::

    bin/console doctrine:schema:update --force

Doctrine MongoDB Configuration
------------------------------

You have to create the corresponding documents, ``src/Document/SonataCommentComment``::

    // src/Document/SonataCommentComment.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
    use Sonata\CommentBundle\Document\BaseComment;

    /**
     * @MongoDB\Document
     */
    class SonataCommentComment extends BaseComment
    {
        /**
         * @MongoDB\Id
         */
        protected $id;
    }

and ``src/Document/SonataCommentThread``::

    // src/Document/SonataCommentThread.php

    use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
    use Sonata\CommentBundle\Document\BaseThread;

    /**
     * @MongoDB\Document
     */
    class SonataCommentThread extends BaseThread
    {
        /**
         * @MongoDB\Id
         */
        protected $id;
    }

Then configure ``SonataCommentBundle`` to use the newly generated classes::

    # config/packages/sonata_comment.yaml

    sonata_comment:
        manager_type: mongodb
        class:
            comment: App\Document\SonataCommentComment
            thread: App\Document\SonataCommentThread

And ``FosCommentBundle``::

    # config/packages/fos_comment.yaml

    fos_comment:
        db_driver: mongodb
        class:
            model:
                comment: App\Document\SonataCommentComment
                thread: App\Document\SonataCommentThread

Next Steps
----------

At this point, your Symfony installation should be fully functional, without errors
showing up from SonataCommentBundle. If, at this point or during the installation,
you come across any errors, don't panic:

    - Read the error message carefully. Try to find out exactly which bundle is causing the error.
      Is it SonataCommentBundle or one of the dependencies?
    - Make sure you followed all the instructions correctly, for both SonataCommentBundle and its dependencies.
    - Still no luck? Try checking the project's `open issues on GitHub`_.

After you have successfully installed the above bundles you need to configure SonataCommentBundle.
All that is needed to quickly set up SonataCommentBundle is described in the :doc:`usage` chapter.

.. _`open issues on GitHub`: https://github.com/sonata-project/SonataCommentBundle/issues
.. _FOSCommentBundle: https://github.com/FriendsOfSymfony/FOSCommentBundle
.. _`auto_mapping`: http://symfony.com/doc/4.4/reference/configuration/doctrine.html#configuration-overviews
