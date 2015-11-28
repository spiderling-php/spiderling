<?php

namespace SP\Spiderling;

use Psr\Http\Message\UriInterface;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
interface CrawlerInterface
{
    /**
     * @param  UriInterface $url
     */
    public function open(UriInterface $url);

    /**
     * @return UriInterface
     */
    public function getUri();

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
     * @param  string $name
     * @return string
     */
    public function getAttribute($id, $name);

    /**
     * @param  string $id
     * @return string
     */
    public function getHtml($id);

    /**
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
     * @return boolean
     */
    public function isVisible($id);

    /**
     * @param  string $id
     * @return boolean
     */
    public function isSelected($id);

    /**
     * @param  string $id
     * @return boolean
     */
    public function isChecked($id);

    /**
     * @param  string $id
     * @param  mixed  $value
     */
    public function setValue($id, $value);

    /**
     * @param  string $id
     */
    public function click($id);

    /**
     * @param  string $id
     */
    public function select($id);

    /**
     * @param  Query\AbstractQuery $query
     * @param  string              $parentId
     * @return array
     */
    public function queryIds(Query\AbstractQuery $query, $parentId = null);
}
