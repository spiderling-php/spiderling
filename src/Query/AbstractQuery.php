<?php

namespace SP\Spiderling\Query;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractQuery
{
    private $selector;
    private $filters;

    public function __construct($selector, Filters $filters)
    {
        $this->filters = $filters;

        $this->selector = $this->filters->extractAllPatterns($selector);
    }

    public function getSelector()
    {
        return $this->selector;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    abstract function getXPath();
}
