<?php

namespace SP\Spiderling;

use SP\Spiderling\Query\AbstractQuery;
use DomainException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class EmptyNode extends Node
{
    private $query;

    /**
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler, AbstractQuery $query = null)
    {
        $this->query = $query;

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
     * @throws DomainException
     */
    public function setValue($value)
    {
        throw new DomainException(sprintf('Cannot set value, element not found: %s', $this->query));
    }

    /**
     * @param  string $file
     * @throws DomainException
     */
    public function setFile($file)
    {
        throw new DomainException(sprintf('Cannot set file, element not found: %s', $this->query));
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
     * @throws DomainException
     */
    public function click()
    {
        throw new DomainException(sprintf('Cannot click, element not found: %s', $this->query));
    }

    /**
     * @throws DomainException
     */
    public function select()
    {
        throw new DomainException(sprintf('Cannot select, element not found: %s', $this->query));
    }
}
