<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
interface BrowserInterface extends CrawlerInterface
{
    public function getAlertText();
    public function confirm($confirm);

    public function setCookie($name, $value = '', $time = 0);
    public function getCookie($name);
    public function removeCookie($name);
    public function removeAllCookies();

    public function executeJs($javascript);
    public function getJsErrors();
    public function getJsMessages();

    public function moveMouseTo($id);

    public function saveScreenshot($file);
}
