<?php

namespace SP\Spiderling\Query;

use ReflectionClass;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractQuery
{
    /**
     * @var string
     */
    private $selector;

    /**
     * @var Filters
     */
    private $filters;

    /**
     * @param string  $selector
     * @param Filters $filters
     */
    public function __construct($selector, Filters $filters = null)
    {
        $this->filters = $filters ?: new Filters();

        $this->selector = $this->filters->extractAllPatterns($selector);
    }

    /**
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * @return Filters
     */
    public function getFilters()
    {
        return $this->filters;
    }

    public function __toString()
    {
        $reflect = new ReflectionClass($this);

        return sprintf('[%s: %s]', $reflect->getShortName(), $this->selector);
    }

    /**
     * @return string
     */
    abstract public function getXPath();

}
