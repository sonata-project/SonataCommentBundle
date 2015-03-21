.. index::
    single: Installation
    single: Bundle
    single: Configuration
    single: Extend

Installation
============

Prerequisites
-------------

PHP 5.3 and Symfony 2 are needed to make this bundle work; there are also some
Sonata dependencies that need to be installed and configured beforehand:

* `SonataAdminBundle <https://sonata-project.org/bundles/admin>`_
* `SonataEasyExtendsBundle <https://sonata-project.org/bundles/easy-extends>`_

You will need to install those in their 2.0 branches (or master if they don't
have a similar branch). Follow also their configuration step; you will find
everything you need in their installation chapter.

.. note::

    If a dependency is already installed somewhere in your project or in
    another dependency, you won't need to install it again.

Enable the Bundle
-----------------

Use these commands:

.. code-block:: bash

    php composer require sonata-project/comment-bundle --no-update
    php composer require sonata-project/doctrine-orm-admin-bundle --no-update # optional
    php composer update

Next, be sure to enable the bundles in your autoload.php and AppKernel.php
files:

.. code-block:: php

    <?php

    // app/AppKernel.php

    public function registerbundles()
    {
        return array(
            new FOS\CommentBundle\FOSCommentBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CommentBundle\SonataCommentBundle(),
            // ...
        );
    }

.. note::

    If you already have installed a Sonata dependency, you may ignore the step
    on the modification of the ``autoload.php`` file.

Configuration
-------------
Here is the configuration you will need to add:

.. code-block:: yaml

    # app/config/config.yml

    sonata_comment:
        manager_type: orm # can be 'orm' or 'mongodb'
        class:
            comment: Application\Sonata\CommentBundle\Entity\Comment # This is an optional value
            thread: Application\Sonata\CommentBundle\Entity\Thread   # This is an optional value

Doctrine Configuration
~~~~~~~~~~~~~~~~~~~~~~
Then, add these bundles in the config mapping definition (or enable `auto_mapping <http://symfony.com/doc/2.0/reference/configuration/doctrine.html#configuration-overview>`_):

.. code-block:: yaml

    # app/config/config.yml

    fos_comment:
        db_driver: orm
        class:
            model:
                comment: Application\Sonata\CommentBundle\Entity\Comment
                thread: Application\Sonata\CommentBundle\Entity\Thread
        form:
            comment:
                type: sonata_comment_comment
        notes:
            values: [1, 2, 3] # Optional, default would be: [1, 2, 3, 4, 5]

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

    php app/console sonata:easy-extends:generate SonataCommentBundle

If you specify no parameter, the files are generated in app/Application/Sonata... but you can specify the path with `--dest=src`.

.. note::

    The command will generate domain objects in an ``Application`` namespace.
    So you can point entities' associations to a global and common namespace.
    This will make Entities sharing easier as your models will allow to
    point to a global namespace. For instance the user will be
    ``Application\Sonata\CommentBundle\Entity\Thread``.

Now, add the new `Application` Bundle into the kernel:

.. code-block:: php

    <?php

    // app/AppKernel.php

    class AppKernel {
        public function registerbundles()
        {
            return array(
                // Application Bundles
                // ...
                new Application\Sonata\CommentBundle\ApplicationSonataCommentBundle(),
                // ...

            )
        }
    }