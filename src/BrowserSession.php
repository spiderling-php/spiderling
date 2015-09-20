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
    private $brwoser;

    public function __construct(BrowserInterface $browser) {

        $this->browser = $browser;

        parent::__construct($browser);
    }

    public function getBrowser()
    {
        return $this->browser;
    }

    public function getAlertText()
    {
        return $this->browser->getAlertText();
    }

    public function confirm($confirm)
    {
        return $this->browser->confirm($confirm);
    }

    public function setCookie($name, $value = '', $expires = 0)
    {
        return $this->browser->setCookie($name, $value, $expires);
    }

    public function getCookie($name)
    {
        return $this->browser->getCookie($name);
    }

    public function removeCookie($name)
    {
        return $this->browser->removeCookie($name);
    }

    public function removeAllCookies()
    {
        return $this->browser->removeAllCookies();
    }

    public function executeJs($javascript)
    {
        return $this->browser->executeJs($javascript);
    }

    public function getJsErrors()
    {
        return $this->browser->getJsErrors();
    }

    public function getJsMessages()
    {
        return $this->browser->getJsMessages();
    }

    public function saveScreenshot($file)
    {
        return $this->browser->saveScreenshot($file);
    }

    public function hoverNode(Node $node)
    {
        $this->browser->moveMouseTo($node->getId());
    }

    public function hover($selector)
    {
        $this->hoverNode($this->get($selector));
    }

    public function hoverButton($selector)
    {
        $this->hoverNode($this->getButton($selector));
    }

    public function hoverField($selector)
    {
        $this->hoverNode($this->getField($selector));
    }
}
