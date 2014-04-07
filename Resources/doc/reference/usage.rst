.. index::
    single: Usage
    single: Properties

Usage
=====

Entities properties
-------------------

In addition to ``FOSCommentBundle`` entities properties, we have added some properties. Let's have a look:

Comment
^^^^^^^

* ``authorName`` property: allows you to specify an author name,
* ``website`` property: allows you to (optionally) store the author website URL,
* ``email`` property: allows you to (optionally) store the author email address,
* ``note`` property: allows you to add a note to your comments,
* ``private`` property: allows you to flag a comment as private (will not appear publicly).

A comment can have a state from the following 3 states labels:

* ``moderate``: This is a comment awaiting for moderation,
* ``valid``: This is a valid comment message,
* ``invalid``: This is an invalid/refused comment message.

Thread
^^^^^^

* ``averageNote`` property: this is the average note of all thread comments.

Command
-------

In order to keep the ``averageNote`` of all threads up-to-date, you can use the following Symfony command:

.. code-block:: bash

    php app/console sonata:comment:sync

Add a new comment thread
------------------------

You can add a new comment thread by adding the following code to your template.

If you are using ``SonataBlockBundle``, the following block event is available:

.. code-block:: jinja

    {{ sonata_block_render_event('sonata.comment', {'id': 'my-custom-thread-identifier'}) }}

Else, you can use this Twig include:

.. code-block:: jinja

    {% include 'SonataCommentBundle:Thread:async.html.twig' with {'id': 'my-custom-thread-identifier'} %}