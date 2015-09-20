<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
interface CrawlerInterface
{
    /**
     * @param  string $url
     */
    public function open($url);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getUserAgent();


    /**
     * @param  string $id
     * @return string
     */
    public function getText($id);

    /**
     * @param  string $id
     * @return string
     */
    public function getTagName($id);

    /**
     * @param  string $id
     * @param  string $value
     * @return string
     */
    public function getAttribute($id, $name);

    /**
     * @param  string $id
     * @return string
     */
    public function getHtml($id);

    /**
     * @param  string $id
     * @return string
     */
    public function getFullHtml();

    /**
     * @param  string $id
     * @return string
     */
    public function getValue($id);

    /**
     * @param  string $id
     * @return string
     */
    public function isVisible($id);

    /**
     * @param  string $id
     * @return string
     */
    public function isSelected($id);

    /**
     * @param  string $id
     * @return string
     */
    public function isChecked($id);

    /**
     * @param  string $id
     * @param  string $value
     * @return string
     */
    public function setValue($id, $value);

    /**
     * @param  string $id
     * @return string
     */
    public function click($id);

    /**
     * @param  Query\AbstractQuery $query
     * @param  string              $parent
     * @return array
     */
    public function queryIds(Query\AbstractQuery $query, $parent = null);
}
