<?php

namespace SP\Spiderling;

use Countable;
use SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class BrowserSession extends Session
{
    /**
     * @var BrowserInterface
     */
    private $brwoser;

    /**
     * @param BrowserInterface $browser
     */
    public function __construct(BrowserInterface $browser) {

        $this->browser = $browser;

        parent::__construct($browser);
    }

    /**
     * @return BrowserInterface
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @return string
     */
    public function getAlertText()
    {
        return $this->browser->getAlertText();
    }

    /**
     * @param  string $confirm
     */
    public function confirm($confirm)
    {
        $this->browser->confirm($confirm);

        return $this;
    }

    /**
     * @param string  $name
     * @param string  $value
     * @param integer $expires
     * @return BrowserSession
     */
    public function setCookie($name, $value = '', $expires = 0)
    {
        $this->browser->setCookie($name, $value, $expires);

        return $this;
    }

    /**
     * @param  string $name
     * @return string
     */
    public function getCookie($name)
    {
        return $this->browser->getCookie($name);
    }

    /**
     * @param  string $name
     * @return BrowserSession
     */
    public function removeCookie($name)
    {
        $this->browser->removeCookie($name);

        return $this;
    }

    /**
     * @param  string $name
     * @return BrowserSession
     */
    public function removeAllCookies()
    {
        $this->browser->removeAllCookies();

        return $this;
    }

    /**
     * @param  string $javascript
     * @return mixed
     */
    public function executeJs($javascript)
    {
        return $this->browser->executeJs($javascript);
    }

    /**
     * @return array
     */
    public function getJsErrors()
    {
        return $this->browser->getJsErrors();
    }

    /**
     * @return array
     */
    public function getJsMessages()
    {
        return $this->browser->getJsMessages();
    }

    /**
     * @param  string $file
     * @return BrowserSession
     */
    public function saveScreenshot($file)
    {
        $this->browser->saveScreenshot($file);

        return $this;
    }

    /**
     * @param  Node   $node
     * @return BrowserSession
     */
    public function hoverNode(Node $node)
    {
        $this->browser->moveMouseTo($node->getId());

        return $this;
    }

    /**
     * @param  string $selector
     * @return BrowserSession
     */
    public function hover($selector)
    {
        $this->hoverNode($this->get($selector));

        return $this;
    }

    /**
     * @param  string $selector
     * @return BrowserSession
     */
    public function hoverButton($selector)
    {
        $this->hoverNode($this->getButton($selector));

        return $this;
    }

    /**
     * @param  string $selector
     * @return BrowserSession
     */
    public function hoverField($selector)
    {
        $this->hoverNode($this->getField($selector));

        return $this;
    }
}
