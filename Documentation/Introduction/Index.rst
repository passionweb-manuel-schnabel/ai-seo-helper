.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _what_it_does:

What does it do?
^^^^^^^^^^^^^^^^

Generates SEO metadata based on page content using AI. Currently, meta description, keywords, page title, Open Graph and Twitter data (titles and descriptions) of the page properties can be generated. Based on page title and meta description you can fill Open Graph title, Twitter title, Open Graph description and Twitter description too.

Furthermore, alternative title suggestions, description suggestions and keywords can be generated for articles of EXT:news.

By using an additional button next to the corresponding input fields you can generate the specific suggestions/data.

.. _requirements:

Requirements
^^^^^^^^^^^^

You need an OpenAI account and API key. If you have not yet created an account or key, you can do so using the following links.

- `Create OpenAI account <https://platform.openai.com/signup>`_

- `Create API key <https://platform.openai.com/account/api-keys>`_

.. _notices_to_keep_in_mind:

Notices to keep in mind
^^^^^^^^^^^^^^^^^^^^^^^

Just like this extension, OpenAI is still in development mode and not fully mature. For this reason, we urgently advise you to check all generated texts for correctness before saving them and to make any necessary adjustments!

.. _restriction_on_very_large_texts:

Restrictions on very large texts
--------------------------------

The OpenAI API (currently) limits the maximum number of tokens per request depending on the model used (currently the maximum possible tokens are 32,768 by using the `gpt-4-32k` model). You can find a detailed overview of models and the maximum number of tokens here:

`https://platform.openai.com/docs/models/ <https://platform.openai.com/docs/models/>`_

Based on the current status of the extension, it is unfortunately not yet possible to analyze larger texts.

.. _possible_limitations_when_using_the_gpt_4_model:

Possible limitations when using the GPT-4 model
-----------------------------------------------

At the time of version 0.6.0 release, only people with a $1 or more successful payment on their account have access to the GPT-4 model. According to OpenAI, that should change soon.

If you try to use the GPT-4 model without access you currently get a 404 error message which is a bit confusing.

.. _troubleshooting_logging:

Troubleshooting and logging
^^^^^^^^^^^^^^^^^^^^^^^^^^^

If something does not work as expected take a look at the log file first.
Every problem is logged to the TYPO3 log (normally found in `var/log/typo3_*.log`).

If something still doesn't work as desired after checking the logs, feel free to contact me.

.. _feedback:

Achieving more together or Feedback, Feedback, Feedback
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

I'm grateful for any feedback! Be it suggestions for improvement, extension requests or just a (constructive) feedback on how good or crappy the extension is.

Feel free to send me your feedback to `service@passionweb.de <mailto:service@passionweb.de>`_ or `contact me on Slack <https://typo3.slack.com/team/U02FG49J4TG>`_

