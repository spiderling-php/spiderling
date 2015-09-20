<?php

namespace SP\Spiderling;

use Countable;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Node
{
    use TraverseTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var CrawlerInterface
     */
    private $crawler;

    /**
     * @param CrawlerInterface $crawler
     * @param string  $id
     */
    public function __construct(CrawlerInterface $crawler, $id) {
        $this->crawler = $crawler;
        $this->id = $id;
    }

    /**
     * @param  Query\AbstractQuery $query
     * @return array
     */
    public function queryIds(Query\AbstractQuery $query)
    {
        return $this->crawler->queryIds($query, $this->id);
    }

    /**
     * @return CrawlerInterface
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * @param  callable $callback
     */
    public function with(callable $callback)
    {
        $callback($this);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    // Accessors

    /**
     * @param  string $name
     * @return string
     */
    public function getAttribute($name)
    {
        return $this->crawler->getAttribute($this->id, $name);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->crawler->getText($this->id);
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->crawler->getHtml($this->id);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->crawler->getValue($this->id);
    }

    /**
     * @param  string $value
     * @return Node
     */
    public function setValue($value)
    {
        $this->crawler->setValue($this->id, $value);

        return $this;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return $this->crawler->isVisible($this->id);
    }

    /**
     * @return boolean
     */
    public function isSelected()
    {
        return $this->crawler->isSelected($this->id);
    }

    /**
     * @return boolean
     */
    public function isChecked()
    {
        return $this->crawler->isChecked($this->id);
    }

    /**
     * @return Node
     */
    public function click()
    {
        $this->crawler->click($this->id);

        return $this;
    }
}
