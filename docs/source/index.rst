.. title:: Spiderling

==========
Spiderling
==========

Browser emulator, for crawling web pages, inspired by `capybara <http://jnicklas.github.io/capybara>`_

Source code at github - `spiderling-php/spiderling <https://github.com/spiderling-php/spiderling>`_


Quick Example
-------------

Heres' a quick preview of how it could be used:

.. code-block:: php
    use SP\Spiderling\CrawlerSession;
    use SP\CurlDriver\Crawler;

    $session = new CrawlerSession(new Crawler());

    $session->open('http://example.com/index');

    // Reading the h1 header text
    echo $session->get('h1')->getText();

    // Clicking links
    $session->clickLink('Next');

    // Using forms
    $session
        ->setField('Name', 'Jessy')
        ->setField('Email', 'jessy@example.com')
        ->select('Gender', 'Female')
        ->clickButton('Submit');

Spiderling supports a variety of crawlers and browsers - raw curl, guzzle, phantomjs or even selenium. Uses the latest PSR7 spec internally and supports native framework drivers. For example using kohana driver you can test websites built with Kohana framework directly without touching the networking stack, for unparalleled speed.

Most html form elements are supported, selects, checkboxes, radio buttons and even file uploads. Using phantomjs or selenium you can even use hovers, execute javascript and take screenshots.

PHPUnit support

Spiderling was developed specifically to have fast integration tests with phpunit. Here is how that might look like

.. code-block:: php

    use SP\Phpunit\SpiderlingTestCase;

    class IntegrationTest extends SpiderlingTestCase
    {
        public static setUpBeforeClass()
        {
            self::getSessionContainer()->addBuilder('test', function () {
                return $this
                    ->getMockBuilder('SP\Spiderling\BrowserSession')
                    ->disableOriginalConstructor()
                    ->getMock();
            });

        }
    }


.. toctree::
   :maxdepth: 2
   :caption: Documentation

.. toctree::

   installation
   documentation

.. toctree::
   :maxdepth: 2
   :caption: Drivers

   drivers/kohana
   drivers/curl
   drivers/guzzle
   drivers/phantom
   drivers/selenium

Credits
-------

This is basically a refactoring of my earlier work on `OpenBuildings/spiderling <https://github.com/OpenBuildings/spiderling />`_. I split it into multiple smaller packages, and allowed loading different drivers independantly.
Built by `Ivan Kerin <https://github.com/ivank />`_ as part of `Clippings.com <https://clippings.com>`_
