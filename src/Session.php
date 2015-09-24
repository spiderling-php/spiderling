<?php

namespace SP\Spiderling;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Session
{
    use TraverseTrait;

    /**
     * CrawlerInterface
     */
    private $crawler;

    /**
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param  Query\AbstractQuery $query
     * @return array
     */
    public function queryIds(Query\AbstractQuery $query)
    {
        return $this->crawler->queryIds($query);
    }

    /**
     * @return CrawlerInterface
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * @param  string $url
     * @return self
     */
    public function open($url)
    {
        $this->crawler->open($url);

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->crawler->getUri();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->crawler->getPath();
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->crawler->getFullHtml();
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->crawler->getUserAgent();
    }
}
