<?php

namespace SP\Spiderling;

use SP\Spiderling\Query\AbstractQuery;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class EmptyNode extends Node
{
    /**
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
    {
        parent::__construct($crawler, null);
    }

    /**
     * @param  AbstractQuery $query
     * @return array
     */
    public function queryIds(AbstractQuery $query)
    {
        return [];
    }

    // Accessors

    /**
     * @param  string $name
     * @return null
     */
    public function getAttribute($name)
    {
        return null;
    }

    /**
     * @return null
     */
    public function getText()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getHtml()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return null;
    }

    /**
     * @param  string $value
     * @return null
     */
    public function setValue($value)
    {
        return null;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isSelected()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isChecked()
    {
        return false;
    }

    /**
     * @return null
     */
    public function click()
    {
        return null;
    }
}
