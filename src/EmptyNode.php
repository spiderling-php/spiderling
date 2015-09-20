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
    public function __construct(CrawlerInterface $crawler)
    {
        parent::__construct($crawler, null);
    }

    public function queryIds(AbstractQuery $query)
    {
        return [];
    }

    // Accessors

    public function getAttribute($name)
    {
        return null;
    }

    public function getText()
    {
        return null;
    }

    public function getHtml()
    {
        return null;
    }

    public function getValue()
    {
        return null;
    }

    public function setValue($value)
    {
        return null;
    }

    public function isVisible()
    {
        return false;
    }

    public function isSelected()
    {
        return false;
    }

    public function isChecked()
    {
        return false;
    }

    public function click()
    {
        return null;
    }
}
