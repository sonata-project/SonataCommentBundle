Usage
=====

Entities properties
-------------------

In addition to ``FOSCommentBundle`` entities properties, we have added some properties, let's have a look:

Comment
^^^^^^^

    - ``website`` property: allows you to (optionally) store the author website URL,
    - ``email`` property: allows you to (optionally) store the author email address,
    - ``note`` property: allows you to add a note to your comments,
    - ``private`` property: allows you to flag a comment as private (will not appear publicly).

A comment can have a state from the following 3 states labels:

    - ``moderate``: This is a comment awaiting for moderation,
    - ``valid``: This is a valid comment message,
    - ``invalid``: This is an invalid/refused comment message.

Thread
^^^^^^

    - ``averageNote`` property: this is the average note of all thread comments

Command
-------

In order to keep the ``averageNote`` of all threads up-to-date, you can use the following Symfony command:

``php app/console sonata:comment:sync``

Add a new comment thread
------------------------

You can add a new comment thread by adding this to your template:

.. code-block:: jinja

    {% include 'SonataCommentBundle:Thread:async.html.twig' with {'id': 'my-custom-thread'} %}
