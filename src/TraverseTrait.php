<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait TraverseTrait
{
    /**
     * @return CrawlerInterface
     */
    abstract public function getCrawler();

    /**
     * @param  Query\AbstractQuery $query
     * @return array
     */
    abstract public function queryIds(Query\AbstractQuery $query);

    /**
     * @param  string $id
     * @return Node
     */
    public function newNode($id)
    {
        return new Node($this->getCrawler(), $id);
    }

    /**
     * @return EmptyNode
     */
    public function newEmptyNode()
    {
        return new EmptyNode($this->getCrawler());
    }

    /**
     * @param  Query\AbstractQuery $query
     * @return Node[]
     */
    public function query(Query\AbstractQuery $query)
    {
        return array_map(
            [$this, 'newNode'],
            $this->queryIds($query)
        );
    }

    /**
     * @param  Query\AbstractQuery $query
     * @return Node
     */
    public function queryFirst(Query\AbstractQuery $query)
    {
        $nodes = $this->query($query);

        return reset($nodes) ?: $this->newEmptyNode();
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getArray($selector)
    {
        return $this->query(new Query\Css($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getLinkArray($selector)
    {
        return $this->query(new Query\Link($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getButtonArray($selector)
    {
        return $this->query(new Query\Button($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getFieldArray($selector)
    {
        return $this->query(new Query\Field($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getLabelArray($selector)
    {
        return $this->query(new Query\Label($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function get($selector)
    {
        return $this->queryFirst(new Query\Css($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getLink($selector)
    {
        return $this->queryFirst(new Query\Link($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getButton($selector)
    {
        return $this->queryFirst(new Query\Button($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getField($selector)
    {
        return $this->queryFirst(new Query\Field($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getLabel($selector)
    {
        return $this->queryFirst(new Query\Label($selector, new Query\Filters()));
    }

    /**
     * @param  string $selector
     */
    public function clickOn($selector)
    {
        $this
            ->get($selector)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function clickLink($selector)
    {
        $this
            ->getLink($selector)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function clickButton($selector)
    {
        $this
            ->getButton($selector)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function setField($selector, $value)
    {
        $this
            ->getField($selector)
            ->setValue($value);

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function check($selector)
    {
        $this
            ->getField($selector)
            ->setValue(true);

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function uncheck($selector)
    {
        $this
            ->getField($selector)
            ->setValue(false);

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function select($selector, $optionText)
    {
        $optionText = addslashes($optionText);

        $this
            ->getField($selector)
                ->get("option:text('{$optionText}')")
                    ->setValue(true);

        return $this;
    }

    /**
     * @param  string $selector
     */
    public function unselect($selector, $optionText)
    {
        $optionText = addslashes($optionText);

        $this
            ->getField($selector)
                ->get("option:text('{$optionText}')")
                    ->setValue(false);

        return $this;
    }
}
