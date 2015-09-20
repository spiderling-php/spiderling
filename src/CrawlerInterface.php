<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
interface CrawlerInterface
{
    public function open();
    public function getPath();
    public function getUrl();
    public function getContent();
    public function getUserAgent();

    public function getText($id);
    public function getTagName($id);
    public function getAttribute($id, $name);
    public function getHtml($id);
    public function getFullHtml();
    public function getValue($id);
    public function isVisible($id);
    public function isSelected($id);
    public function isChecked($id);
    public function setValue($id, $value);
    public function click($id);
    public function queryIds(Query\AbstractQuery $query, $parent = null);
}
