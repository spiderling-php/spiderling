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
    public function getArray($selector, Query\Filters $filters = null)
    {
        return $this->query(new Query\Css($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getLinkArray($selector, Query\Filters $filters = null)
    {
        return $this->query(new Query\Link($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getButtonArray($selector, Query\Filters $filters = null)
    {
        return $this->query(new Query\Button($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getFieldArray($selector, Query\Filters $filters = null)
    {
        return $this->query(new Query\Field($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node[]
     */
    public function getLabelArray($selector, Query\Filters $filters = null)
    {
        return $this->query(new Query\Label($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function get($selector, Query\Filters $filters = null)
    {
        return $this->queryFirst(new Query\Css($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getLink($selector, Query\Filters $filters = null)
    {
        return $this->queryFirst(new Query\Link($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getButton($selector, Query\Filters $filters = null)
    {
        return $this->queryFirst(new Query\Button($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getField($selector, Query\Filters $filters = null)
    {
        return $this->queryFirst(new Query\Field($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return Node
     */
    public function getLabel($selector, Query\Filters $filters = null)
    {
        return $this->queryFirst(new Query\Label($selector, $filters));
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function clickOn($selector, Query\Filters $filters = null)
    {
        $this
            ->get($selector, $filters)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function clickLink($selector, Query\Filters $filters = null)
    {
        $this
            ->getLink($selector, $filters)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function clickButton($selector, Query\Filters $filters = null)
    {
        $this
            ->getButton($selector, $filters)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function setField($selector, $value, Query\Filters $filters = null)
    {
        $this
            ->getField($selector, $filters)
            ->setValue($value);

        return $this;
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function check($selector, Query\Filters $filters = null)
    {
        $this
            ->getField($selector, $filters)
            ->click();

        return $this;
    }

    /**
     * @param  string $selector
     * @return self
     */
    public function select($selector, $optionText, Query\Filters $filters = null)
    {
        $this
            ->getField($selector, $filters)
                ->get('option', new Query\Filters(['text' => $optionText]))
                    ->select();

        return $this;
    }
}
