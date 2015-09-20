<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
interface BrowserInterface extends CrawlerInterface
{
    /**
     * @return string
     */
    public function getAlertText();

    /**
     * @param  string $confirm
     */
    public function confirm($confirm);

    /**
     * @param string  $name
     * @param string  $value
     * @param integer $time
     */
    public function setCookie($name, $value = '', $time = 0);

    /**
     * @param  string $name
     * @return string
     */
    public function getCookie($name);

    /**
     * @param  string $name
     */
    public function removeCookie($name);

    public function removeAllCookies();

    /**
     * @param  string $javascript
     * @return mixed
     */
    public function executeJs($javascript);

    /**
     * @return array
     */
    public function getJsErrors();

    /**
     * @return array
     */
    public function getJsMessages();

    /**
     * @param  string $id
     */
    public function moveMouseTo($id);

    /**
     * @param  string $file
     */
    public function saveScreenshot($file);
}
