.. index::
    single: Installation
    single: Bundle
    single: Configuration
    single: Extend

Installation
============

Prerequisites
-------------

PHP 7.1 and Symfony >=3.4 or >= 4.2 are needed to make this bundle work, there are
also some Sonata dependencies that need to be installed and configured beforehand:

* `SonataAdminBundle <https://sonata-project.org/bundles/admin>`_
* `SonataEasyExtendsBundle <https://sonata-project.org/bundles/easy-extends>`_

You will need to install those in their 2.0 or 3.0 branches. Follow also
their configuration step; you will find everything you need in their own
installation chapter.

.. note::

    If a dependency is already installed somewhere in your project or in
    another dependency, you won't need to install it again.

Enable the Bundle
-----------------

Use these commands:

.. code-block:: bash

    composer require sonata-project/comment-bundle --no-update
    composer require sonata-project/doctrine-orm-admin-bundle --no-update # optional
    composer update

Next, be sure to enable the bundles in your ``bundles.php`` file if they
are not already enabled::

    // config/bundles.php

    return [
        // ...
        FOS\CommentBundle\FOSCommentBundle::class => ['all' => true],
        Sonata\Form\Bridge\Symfony\Bundle\SonataFormBundle::class => ['all' => true],
        Sonata\Doctrine\Bridge\Symfony\Bundle\SonataDoctrineBundle::class => ['all' => true],
        Sonata\Twig\Bridge\Symfony\Bundle\SonataTwigBundle::class => ['all' => true],
        Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
        Sonata\CommentBundle\SonataCommentBundle::class => ['all' => true],
    ];

Configuration
-------------

SonataCommentBundle Configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: yaml

    # config/packages/sonata_comment.yaml

    sonata_comment:
        manager_type: orm # can be 'orm' or 'mongodb'
        class:
            comment: App\Entity\Comment # This is an optional value
            thread: App\Entity\Thread   # This is an optional value

FOSCommentBundle Configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: yaml

    # config/packages/fos_comment.yaml

    fos_comment:
        db_driver: orm
        class:
            model:
                comment: App\Entity\Comment
                thread: App\Entity\Thread
        form:
            comment:
                type: sonata_comment_comment

Doctrine Configuration
~~~~~~~~~~~~~~~~~~~~~~
Add these bundles in the config mapping definition (or enable `auto_mapping <http://symfony.com/doc/2.0/reference/configuration/doctrine.html#configuration-overview>`_):

.. code-block:: yaml

    # config/packages/doctrine.yaml

    doctrine:
        orm:
            entity_managers:
                default:
                    mappings:
                        ApplicationSonataCommentBundle: ~
                        SonataCommentBundle: ~

        dbal:
            types:
                json: Sonata\Doctrine\Types\JsonType

Extending the Bundle
--------------------

At this point, the bundle is functional, but not quite ready yet. You need to
generate the correct entities for the media:

.. code-block:: bash

    bin/console sonata:easy-extends:generate SonataCommentBundle --dest=src --namespace_prefix=App

With provided parameters, the files are generated in ``src/Application/Sonata/CommentBundle``.

.. note::

    The command will generate domain objects in an ``App\Application`` namespace.
    So you can point entities' associations to a global and common namespace.
    This will make Entities sharing easier as your models will allow to
    point to a global namespace. For instance the user will be
    ``App\Application\Sonata\CommentBundle\Entity\Thread``.

Now, add the new ``Application`` Bundle into the ``bundles.php``::

    // config/bundles.php

    return [
        // ...
        App\Application\Sonata\CommentBundle\ApplicationSonataCommentBundle::class => ['all' => true],
    ];

Update your schema database schema afterwards:

.. code-block:: bash

    bin/console doctrine:schema:update --force
